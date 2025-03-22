/* Pour les epreuves :*/
-- Création de la table de classement
drop table if EXISTS classement_epreuves;

CREATE TABLE classement_epreuves (
    numepr INT NOT NULL,
    numetu INT NOT NULL,
    position INT NOT NULL,
    note NUMERIC NOT NULL,
    nometu VARCHAR(255),
    prenometu VARCHAR(255),
    annetu INT,
    PRIMARY KEY (numepr, numetu, annetu)
);

-- Insérer les données deja existantes
INSERT INTO
    classement_epreuves (
        numepr,
        numetu,
        position,
        note,
        nometu,
        prenometu,
        annetu
    )
SELECT an.numepr, an.numetu, RANK() OVER (
        PARTITION BY
            an.numepr
        ORDER BY an.note DESC
    ) AS position, an.note, e.nometu, e.prenometu, e.annetu
FROM avoir_note an
    INNER JOIN etudiants e ON an.numetu = e.numetu
ORDER BY an.numepr, position;

-- Fonction epreuve.
DROP FUNCTION classement_epreuves ();

CREATE OR REPLACE FUNCTION classement_epreuves()
RETURNS VOID AS $$ 
BEGIN
    -- Suppression des anciens classements
    DELETE FROM classement_epreuves;

    INSERT INTO
    classement_epreuves (
        numepr,
        numetu,
        position,
        note,
        nometu,
        prenometu,
        annetu
    )
    SELECT an.numepr, an.numetu, RANK() OVER (
            PARTITION BY
                an.numepr
            ORDER BY an.note DESC
        ) AS position, an.note, e.nometu, e.prenometu, e.annetu
    FROM avoir_note an
        INNER JOIN etudiants e ON an.numetu = e.numetu
    ORDER BY an.numepr, position;
END;
$$ LANGUAGE plpgsql;

/* Pour les matières :*/
-- Création de la table de classement
DROP TABLE IF EXISTS classement_matieres;

CREATE TABLE classement_matieres (
    nummat INT NOT NULL,
    numetu INT NOT NULL,
    position INT NOT NULL,
    moyenne NUMERIC NOT NULL,
    nometu VARCHAR(255),
    prenometu VARCHAR(255),
    annetu INT,
    PRIMARY KEY (nummat, numetu, annetu)
);

-- Insérer les données déjà existantes
INSERT INTO
    classement_matieres (
        nummat,
        numetu,
        position,
        moyenne,
        nometu,
        prenometu,
        annetu
    )
SELECT ep.matepr, an.numetu, RANK() OVER (
        PARTITION BY
            ep.matepr, e.annetu
        ORDER BY ROUND(
                SUM(
                    CAST(an.note AS DECIMAL) * ep.coefepr
                ) / SUM(ep.coefepr), 2
            ) DESC
    ) AS position, ROUND(
        SUM(
            CAST(an.note AS DECIMAL) * ep.coefepr
        ) / SUM(ep.coefepr), 2
    ) AS moyenne, e.nometu, e.prenometu, e.annetu
FROM
    avoir_note an
    INNER JOIN etudiants e ON an.numetu = e.numetu
    INNER JOIN epreuves ep ON an.numepr = ep.numepr
GROUP BY
    ep.matepr,
    an.numetu,
    e.nometu,
    e.prenometu,
    e.annetu
ORDER BY ep.matepr, position;

-- Fonction de calcul de classement :
DROP FUNCTION classement_matieres ();

CREATE OR REPLACE FUNCTION classement_matieres()
RETURNS VOID AS $$
BEGIN
    -- Suppression des anciens classements
    DELETE FROM classement_matieres;

    -- Insertion des nouveaux classements
    INSERT INTO
    classement_matieres (
        nummat,
        numetu,
        position,
        moyenne,
        nometu,
        prenometu,
        annetu
    )
    SELECT ep.matepr, an.numetu, RANK() OVER (
            PARTITION BY
                ep.matepr, e.annetu
            ORDER BY ROUND(
                    SUM(
                        CAST(an.note AS DECIMAL) * ep.coefepr
                    ) / SUM(ep.coefepr), 2
                ) DESC
        ) AS position, ROUND(
            SUM(
                CAST(an.note AS DECIMAL) * ep.coefepr
            ) / SUM(ep.coefepr), 2
        ) AS moyenne, e.nometu, e.prenometu, e.annetu
    FROM
        avoir_note an
        INNER JOIN etudiants e ON an.numetu = e.numetu
        INNER JOIN epreuves ep ON an.numepr = ep.numepr
    GROUP BY
        ep.matepr,
        an.numetu,
        e.nometu,
        e.prenometu,
        e.annetu
    ORDER BY ep.matepr, position;
END;
$$ LANGUAGE plpgsql;

/* Pour les modules :*/
-- Création de la table
DROP TABLE IF EXISTS classement_modules;

CREATE TABLE classement_modules (
    nummod INT NOT NULL,
    numetu INT NOT NULL,
    position INT NOT NULL,
    moyenne NUMERIC NOT NULL,
    nometu VARCHAR(255),
    prenometu VARCHAR(255),
    annetu INT,
    PRIMARY KEY (nummod, numetu, annetu)
);
-- Inserer les données deja existantes :
INSERT INTO
    classement_modules (
        nummod,
        numetu,
        position,
        moyenne,
        nometu,
        prenometu,
        annetu
    )
SELECT m.nummod, e.numetu, RANK() OVER (
        PARTITION BY
            m.nummod, e.annetu
        ORDER BY ROUND(
                SUM(
                    CAST(an.note AS DECIMAL) * ep.coefepr * m.coefmat
                ) / SUM(ep.coefepr * m.coefmat), 2
            ) DESC
    ) AS position, ROUND(
        SUM(
            CAST(an.note AS DECIMAL) * ep.coefepr * m.coefmat
        ) / SUM(ep.coefepr * m.coefmat), 2
    ) AS moyenne, e.nometu, e.prenometu, e.annetu
FROM
    avoir_note an
    INNER JOIN etudiants e ON an.numetu = e.numetu
    INNER JOIN epreuves ep ON an.numepr = ep.numepr
    INNER JOIN matieres m ON ep.matepr = m.nummat
GROUP BY
    m.nummod,
    e.numetu,
    e.nometu,
    e.prenometu,
    e.annetu
ORDER BY m.nummod, position;

-- Création de la fonction
DROP FUNCTION classement_modules ();

CREATE OR REPLACE FUNCTION classement_modules()
RETURNS VOID AS $$
BEGIN
    -- Suppression des anciens classements
    DELETE FROM classement_modules;

    -- Insertion des nouveaux classements
    INSERT INTO
    classement_modules (
        nummod,
        numetu,
        position,
        moyenne,
        nometu,
        prenometu,
        annetu
    )
    SELECT m.nummod, e.numetu, RANK() OVER (
            PARTITION BY
                m.nummod, e.annetu
            ORDER BY ROUND(
                    SUM(
                        CAST(an.note AS DECIMAL) * ep.coefepr * m.coefmat
                    ) / SUM(ep.coefepr * m.coefmat), 2
                ) DESC
        ) AS position, ROUND(
            SUM(
                CAST(an.note AS DECIMAL) * ep.coefepr * m.coefmat
            ) / SUM(ep.coefepr * m.coefmat), 2
        ) AS moyenne, e.nometu, e.prenometu, e.annetu
    FROM
        avoir_note an
        INNER JOIN etudiants e ON an.numetu = e.numetu
        INNER JOIN epreuves ep ON an.numepr = ep.numepr
        INNER JOIN matieres m ON ep.matepr = m.nummat
    GROUP BY
        m.nummod,
        e.numetu,
        e.nometu,
        e.prenometu,
        e.annetu
    ORDER BY m.nummod, position;
END;
$$ LANGUAGE plpgsql;

/* Pour les etudiants */

-- Création de la table
DROP TABLE IF EXISTS classement_etudiants;

CREATE TABLE classement_etudiants (
    nummod INT NOT NULL,
    nommod VARCHAR(255),
    numetu INT NOT NULL,
    nometu VARCHAR(255),
    prenometu VARCHAR(255),
    moyenne NUMERIC(5, 2) NOT NULL,
    position INT NOT NULL,
    annetu INT,
    PRIMARY KEY (nummod, numetu)
);

INSERT INTO
    classement_etudiants (
        nummod,
        nommod,
        numetu,
        nometu,
        prenometu,
        moyenne,
        position,
        annetu
    )
SELECT mo.nummod, mo.nommod, e.numetu, e.nometu, e.prenometu, ROUND(
        SUM(
            CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat
        ) / SUM(ep.coefepr * ma.coefmat), 2
    ) AS moyenne, RANK() OVER (
        PARTITION BY
            mo.nummod, e.annetu
        ORDER BY ROUND(
                SUM(
                    CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat
                ) / SUM(ep.coefepr * ma.coefmat), 2
            ) DESC
    ) AS position, e.annetu
FROM
    etudiants e
    JOIN avoir_note an ON e.numetu = an.numetu
    JOIN epreuves ep ON an.numepr = ep.numepr
    JOIN matieres ma ON ma.nummat = ep.matepr
    JOIN modules mo ON mo.nummod = ma.nummod
GROUP BY
    mo.nummod,
    mo.nommod,
    e.numetu,
    e.nometu,
    e.prenometu,
    e.annetu
ORDER BY mo.nummod, position;

-- Création de la fonction
DROP FUNCTION classement_etudiants ();

CREATE OR REPLACE FUNCTION classement_etudiants()
RETURNS VOID AS $$
BEGIN
    DELETE FROM classement_etudiants; 
    -- Insertion des nouveaux classements des étudiants
    INSERT INTO
    classement_etudiants (
        nummod,
        nommod,
        numetu,
        nometu,
        prenometu,
        moyenne,
        position,
        annetu
    )
    SELECT mo.nummod, mo.nommod, e.numetu, e.nometu, e.prenometu, ROUND(
            SUM(
                CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat
            ) / SUM(ep.coefepr * ma.coefmat), 2
        ) AS moyenne, RANK() OVER (
            PARTITION BY
                mo.nummod, e.annetu
            ORDER BY ROUND(
                    SUM(
                        CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat
                    ) / SUM(ep.coefepr * ma.coefmat), 2
                ) DESC
        ) AS position, e.annetu
    FROM
        etudiants e
        JOIN avoir_note an ON e.numetu = an.numetu
        JOIN epreuves ep ON an.numepr = ep.numepr
        JOIN matieres ma ON ma.nummat = ep.matepr
        JOIN modules mo ON mo.nummod = ma.nummod
    GROUP BY
        mo.nummod,
        mo.nommod,
        e.numetu,
        e.nometu,
        e.prenometu,
        e.annetu
    ORDER BY mo.nummod, position;
END;
$$ LANGUAGE plpgsql;

/* Pour les etudiants (global) */
-- Création de la table
DROP TABLE IF EXISTS classement_etudiants_general;

CREATE TABLE classement_etudiants_general (
    numetu INT NOT NULL,
    nometu VARCHAR(255),
    prenometu VARCHAR(255),
    moyenne NUMERIC(5, 2) NOT NULL,
    position INT NOT NULL,
    annetu INT,
    PRIMARY KEY (numetu, annetu)
);

-- Insertion des données
INSERT INTO
    classement_etudiants_general (
        numetu,
        nometu,
        prenometu,
        moyenne,
        position,
        annetu
    )
SELECT e.numetu, e.nometu, e.prenometu, ROUND(
        SUM(
            CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat * mo.coefmod
        ) / SUM(
            ep.coefepr * ma.coefmat * mo.coefmod
        ), 2
    ) AS moyenne, RANK() OVER (
        PARTITION BY
            e.annetu
        ORDER BY ROUND(
                SUM(
                    CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat * mo.coefmod
                ) / SUM(
                    ep.coefepr * ma.coefmat * mo.coefmod
                ), 2
            ) DESC
    ) AS position, e.annetu
FROM
    etudiants e
    JOIN avoir_note an ON e.numetu = an.numetu
    JOIN epreuves ep ON an.numepr = ep.numepr
    JOIN matieres ma ON ma.nummat = ep.matepr
    JOIN modules mo ON mo.nummod = ma.nummod
GROUP BY
    e.numetu,
    e.nometu,
    e.prenometu,
    e.annetu
ORDER BY e.annetu, position;

-- Création de la fonction
DROP FUNCTION classement_etudiants_general ();

CREATE OR REPLACE FUNCTION classement_etudiants_general()
RETURNS VOID AS $$
BEGIN
    DELETE FROM classement_etudiants_general; 
    -- Insertion des nouveaux classements des étudiants
    INSERT INTO
        classement_etudiants_general (
            numetu,
            nometu,
            prenometu,
            moyenne,
            position,
            annetu
        )
    SELECT 
        e.numetu,
        e.nometu,
        e.prenometu,
        ROUND(
            SUM(
                CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat * mo.coefmod
            ) / SUM(ep.coefepr * ma.coefmat * mo.coefmod), 2
        ) AS moyenne,
        RANK() OVER (
            PARTITION BY e.annetu
            ORDER BY ROUND(
                    SUM(
                        CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat * mo.coefmod
                    ) / SUM(ep.coefepr * ma.coefmat * mo.coefmod), 2
                ) DESC
        ) AS position,
        e.annetu
    FROM
        etudiants e
        JOIN avoir_note an ON e.numetu = an.numetu
        JOIN epreuves ep ON an.numepr = ep.numepr
        JOIN matieres ma ON ma.nummat = ep.matepr
        JOIN modules mo ON mo.nummod = ma.nummod
    GROUP BY
        e.numetu,
        e.nometu,
        e.prenometu,
        e.annetu
    ORDER BY e.annetu, position;
END;
$$ LANGUAGE plpgsql;

/* Fonction qui va appeler tous les classements afin de limiter les triggers inutiles. */
CREATE OR REPLACE FUNCTION appel_classements()
RETURNS TRIGGER AS $$
BEGIN
    -- Appeler toutes les fonctions de classement
    PERFORM classement_epreuves();
    PERFORM classement_matieres();
    PERFORM classement_modules();
    PERFORM classement_etudiants();
    PERFORM classement_etudiants_general();
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger lors d'une modification de note.
DROP TRIGGER IF EXISTS trigger_avoir_note_classements ON avoir_note;

CREATE OR REPLACE TRIGGER trigger_avoir_note_classements
AFTER INSERT OR UPDATE OR DELETE
ON avoir_note
FOR EACH ROW
EXECUTE FUNCTION appel_classements();

-- Trigger lors d'une modification de note.
DROP TRIGGER IF EXISTS trigger_avoir_note_classements ON avoir_note;

CREATE OR REPLACE TRIGGER trigger_avoir_note_classements
AFTER INSERT OR UPDATE OR DELETE
ON avoir_note
FOR EACH ROW
EXECUTE FUNCTION appel_classements();

/* Triggers lors d'une modification d'un coefficient */
-- Coef Epreuve
DROP TRIGGER IF EXISTS trigger_epreuve_coef ON epreuves;

CREATE OR REPLACE TRIGGER trigger_epreuve_coef
AFTER UPDATE OF coefepr 
ON epreuves
FOR EACH ROW
EXECUTE FUNCTION appel_classements();

-- Coef Matiere
DROP TRIGGER IF EXISTS trigger_matiere_coef ON matieres;

CREATE OR REPLACE TRIGGER trigger_matiere_coef
AFTER UPDATE OF coefmat 
ON matieres
FOR EACH ROW
EXECUTE FUNCTION appel_classements();

-- Coef Module
DROP TRIGGER IF EXISTS trigger_module_coef ON modules;

CREATE OR REPLACE TRIGGER trigger_module_coef
AFTER UPDATE OF coefmod
ON modules
FOR EACH ROW
EXECUTE FUNCTION appel_classements();

-- Test Epreuves car impossible depuis le site :
insert into avoir_note values (20, 1, 13);

UPDATE avoir_note SET note = 18 WHERE numetu = 20 AND numepr = 1;

delete from avoir_note where numetu = 20;

-- Pour avoir la liste des triggers (chatGPT)
SELECT
    t.tgname AS trigger_name, -- Nom du trigger
    c.relname AS table_name, -- Nom de la table
    p.proname AS function_name -- Nom de la fonction associée
FROM
    pg_trigger t
    JOIN pg_class c ON t.tgrelid = c.oid
    JOIN pg_namespace n ON c.relnamespace = n.oid
    JOIN pg_proc p ON t.tgfoid = p.oid
WHERE
    NOT t.tgisinternal -- Exclure les triggers internes (ex : triggers pour les clés primaires ou uniques)
ORDER BY table_name, trigger_name;

-- Pour avoir la liste des fonctions (chatGPT)
SELECT
    p.proname AS function_name, -- Nom de la fonction
    pg_catalog.pg_get_function_result (p.oid) AS return_type -- Type de retour
FROM pg_proc p
    JOIN pg_namespace n ON p.pronamespace = n.oid
WHERE
    n.nspname NOT IN(
        'pg_catalog',
        'information_schema'
    ) -- Exclure les fonctions système
ORDER BY function_name;