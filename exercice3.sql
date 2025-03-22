/* Pour les étudiants : */
-- Ajout
CREATE OR REPLACE PROCEDURE ajout_etudiant(
    p_numetu etudiants.numetu%type,  
    p_nometu etudiants.nometu%type,
    p_prenometu etudiants.prenometu%type,
    p_adretu etudiants.adretu%type,
    p_viletu etudiants.viletu%type,
    p_cpetu etudiants.cpetu%type,
    p_teletu etudiants.teletu%type,
    p_datentetu etudiants.datentetu%type,
    p_annetu etudiants.annetu%type,
    p_remetu etudiants.remetu%type,
    p_sexetu etudiants.sexetu%type,
    p_datnaietu etudiants.datnaietu%type
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO etudiants(
        numetu, nometu, prenometu, adretu, viletu, cpetu, teletu, 
        datentetu, annetu, remetu, sexetu, datnaietu
    )
    VALUES (
        p_numetu, p_nometu, p_prenometu, p_adretu, p_viletu, p_cpetu, p_teletu, 
        p_datentetu, p_annetu, p_remetu, p_sexetu, p_datnaietu
    );
END;
$$;

-- Modif
CREATE OR REPLACE PROCEDURE modif_etudiant(
    p_numetu etudiants.numetu%type,
    p_nometu etudiants.nometu%type,
    p_prenometu etudiants.prenometu%type,
    p_adretu etudiants.adretu%type,
    p_viletu etudiants.viletu%type,
    p_cpetu etudiants.cpetu%type,
    p_teletu etudiants.teletu%type,
    p_datentetu etudiants.datentetu%type,
    p_annetu etudiants.annetu%type,
    p_remetu etudiants.remetu%type,
    p_sexetu etudiants.sexetu%type,
    p_datnaietu etudiants.datnaietu%type
)
LANGUAGE plpgsql AS $$
BEGIN
    UPDATE etudiants
    SET 
        nometu = p_nometu,
        prenometu = p_prenometu,
        adretu = p_adretu,
        viletu = p_viletu,
        cpetu = p_cpetu,
        teletu = p_teletu,
        datentetu = p_datentetu,
        annetu = p_annetu,
        remetu = p_remetu,
        sexetu = p_sexetu,
        datnaietu = p_datnaietu
    WHERE numetu = p_numetu;
END;
$$;

/* Pour les enseignants : */
-- Ajout
CREATE OR REPLACE PROCEDURE ajout_enseignant(
    p_numens enseignants.numens%type,
    p_nomens enseignants.nomens%type,
    p_preens enseignants.preens%type,
    p_foncens enseignants.foncens%type,
    p_adrens enseignants.adrens%type,
    p_vilens enseignants.vilens%type,
    p_cpens enseignants.cpens%type,
    p_telens enseignants.telens%type,
    p_datnaiens enseignants.datnaiens%type,
    p_datembens enseignants.datembens%type
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO enseignants(
        numens, nomens, preens, foncens, adrens, vilens, cpens, telens, 
        datnaiens, datembens
    )
    VALUES (
        p_numens, p_nomens, p_preens, p_foncens, p_adrens, p_vilens, p_cpens, p_telens, 
        p_datnaiens, p_datembens
    );
END;
$$;

-- Mofif
CREATE OR REPLACE PROCEDURE update_enseignant(
    p_numens enseignants.numens%type,
    p_nomens enseignants.nomens%type,
    p_preens enseignants.preens%type,
    p_foncens enseignants.foncens%type,
    p_adrens enseignants.adrens%type,
    p_vilens enseignants.vilens%type,
    p_cpens enseignants.cpens%type,
    p_telens enseignants.telens%type,
    p_datnaiens enseignants.datnaiens%type,
    p_datembens enseignants.datembens%type
)
LANGUAGE plpgsql AS $$
BEGIN
    UPDATE enseignants
    SET 
        nomens = p_nomens,
        preens = p_preens,
        foncens = p_foncens,
        adrens = p_adrens,
        vilens = p_vilens,
        cpens = p_cpens,
        telens = p_telens,
        datnaiens = p_datnaiens,
        datembens = p_datembens
    WHERE numens = p_numens;
END;
$$;

/* Pour les modules : */
-- Ajout 
CREATE OR REPLACE PROCEDURE ajout_module(
    p_nummod modules.nummod%type,
    p_nommod modules.nommod%type,
    p_coefmod modules.coefmod%type
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO modules (nummod, nommod, coefmod)
    VALUES (p_nummod, p_nommod, p_coefmod);
END;
$$;

-- Modif 
CREATE OR REPLACE PROCEDURE modif_module(
    p_nummod modules.nummod%type,
    p_nommod modules.nommod%type,
    p_coefmod modules.coefmod%type
)
LANGUAGE plpgsql AS $$
BEGIN
    UPDATE modules
    SET 
        nommod = p_nommod,
        coefmod = p_coefmod
    WHERE nummod = p_nummod;
END;
$$;

/* Pour les matieres :*/
-- Ajout 
CREATE OR REPLACE PROCEDURE ajout_matiere(
    p_nummat matieres.nummat%type,
    p_nommat matieres.nommat%type,
    p_coefmat matieres.coefmat%type,
    p_nummod matieres.nummod%type
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO matieres (nummat, nommat, coefmat, nummod)
    VALUES (p_nummat, p_nommat, p_coefmat, p_nummod);
END;
$$;

-- Modif
CREATE OR REPLACE PROCEDURE update_matiere(
    p_nummat matieres.nummat%type,
    p_nommat matieres.nommat%type,
    p_coefmat matieres.coefmat%type,
    p_nummod matieres.nummod%type
)
LANGUAGE plpgsql AS $$
BEGIN
    UPDATE matieres
    SET 
        nommat = p_nommat,
        coefmat = p_coefmat,
        nummod = p_nummod
    WHERE nummat = p_nummat;
END;
$$;

/* Pour les epreuves :*/
-- Ajout 
CREATE OR REPLACE PROCEDURE ajout_note(
    p_numepr epreuves.numepr%type,
    p_libepr epreuves.libepr%type,
    p_ensepr epreuves.ensepr%type,
    p_matepr epreuves.matepr%type,
    p_datepr epreuves.datepr%type,
    p_coefepr epreuves.coefepr%type,
    p_annepr epreuves.annepr%type
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO epreuves (numepr, libepr, ensepr, matepr, datepr, coefepr, annepr)
    VALUES (p_numepr, p_libepr, p_ensepr, p_matepr, p_datepr, p_coefepr, p_annepr);
END;
$$;

-- Modif 
CREATE OR REPLACE PROCEDURE modif_note(
    p_numepr epreuves.numepr%type,
    p_libepr epreuves.libepr%type,
    p_ensepr epreuves.ensepr%type,
    p_matepr epreuves.matepr%type,
    p_datepr epreuves.datepr%type,
    p_coefepr epreuves.coefepr%type,
    p_annepr epreuves.annepr%type
)
LANGUAGE plpgsql AS $$
BEGIN
    UPDATE epreuves
    SET 
        libepr = p_libepr,
        ensepr = p_ensepr,
        matepr = p_matepr,
        datepr = p_datepr,
        coefepr = p_coefepr,
        annepr = p_annepr
    WHERE numepr = p_numepr;
END;
$$;
