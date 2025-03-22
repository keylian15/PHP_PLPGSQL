<?php

/**
 * 
 */
class Etudiant
{

    private object $pdo;

    private string $numetu;
    private string $nometu;
    private string $prenometu;
    private string $adretu;
    private string $viletu;
    private string $cpetu;
    private string $teletu;
    private string $datentetu;
    private int $annetu;
    private string $remetu;
    private string $sexetu;
    private string $datnaietu;

    /**
     * Magik methode permettant de construire et d'initialiser l'étudiant.
     * 
     * @param object $pdo Le pdo permettant d'acceder a la base de données.
     * @param array $data Tableau permettant d'hydrater l'etudiant, null par défaut.
     * @return void
     */
    public function __construct($pdo, $datas = [])
    {
        // Initialiser les variables
        $this->pdo = $pdo;
        $this->numetu = "";
        $this->nometu = "";
        $this->prenometu = "";
        $this->adretu = "";
        $this->viletu = "";
        $this->cpetu = "";
        $this->teletu = "";
        $this->datentetu = "";
        $this->annetu = 0;
        $this->remetu = "";
        $this->sexetu = "";
        $this->datnaietu = "";

        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Méthode permettant d'hydrater l'étudiant avec des données avec ajout d'erreur.
     * 
     * @param array $data Un tableau de valeurs associatifs.
     * @return void
     */
    public function hydrate(array $data)
    {
        $this->numetu = $this->isNumetu($data["numetu"]);
        $this->nometu = filter_var($data["nometu"]) ?? "";
        $this->prenometu = filter_var($data["prenometu"]) ?? "";
        $this->adretu = filter_var($data["adretu"]) ?? "";
        $this->viletu = filter_var($data["viletu"]) ?? "";
        $this->cpetu = $this->isCp($data["cpetu"]) ?? "";
        $this->teletu = filter_var($data["teletu"]) ?? "";
        $this->datentetu = filter_var($data["datentetu"]) ?? "";
        $this->annetu = $this->isYear($data["annetu"]);
        $this->remetu = filter_var($data["remetu"]) ?? null;
        $this->sexetu = filter_var($data["sexetu"]) ?? "";
        $this->datnaietu = filter_var($data["datnaietu"]) ?? "";

        // Si on est bien en mode ajouter ou edit:
        if (GETPOST('action') == "add" || GETPOST('action') == "edit") {
            foreach ($data as $key => $value) {
                if (empty($value)) {
                    if ($key != "remetu") { // La remarque peut etre null donc exception.
                        $_SESSION['mesgs']['errors'][] = "Tous les champs doivent etre remplis.";
                        return;
                    }
                }
            }
        }
    }

    /**
     * Fonction permettant de créer un etudiant en base de donnée avec ajout d'erreur.
     * 
     * @return void
     */
    public function create()
    {
        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables :
            // $admin = 0;
            $datnaietu = DateTime::createFromFormat('d-m-Y', $this->datnaietu);
            if (!$datnaietu) {
                $datnaietu = DateTime::createFromFormat('Y-m-d', $this->datnaietu);
            }
            $datentetu = DateTime::createFromFormat('d-m-Y', $this->datentetu);
            if (!$datentetu) {
                $datentetu = DateTime::createFromFormat('Y-m-d', $this->datentetu);
            }
            // === Création de l'etudiant : 
            // $sqlEtudiant = "INSERT INTO etudiants (numetu, nometu, prenometu, adretu, viletu, cpetu, teletu, datentetu, annetu, remetu, sexetu, datnaietu)
            // VALUES (:numetu, :nometu, :prenometu, :adretu, :viletu, :cpetu, :teletu, :datentetu, :annetu, :remetu, :sexetu, :datnaietu);";

            // // Pour utiliser les procedures : 
            $sqlEtudiant = "CALL ajout_etudiant(:numetu, :nometu, :prenometu, :adretu, :viletu, :cpetu, :teletu, :datentetu, :annetu, :remetu, :sexetu, :datnaietu)";

            // Préparer la commande sql : 
            $stmtEtudiant = $this->pdo->prepare($sqlEtudiant);

            // Les valeurs : 
            $stmtEtudiant->bindValue(':numetu', $this->numetu);
            $stmtEtudiant->bindValue(':nometu', $this->nometu);
            $stmtEtudiant->bindValue(':prenometu', $this->prenometu);
            $stmtEtudiant->bindValue(':adretu', $this->adretu);
            $stmtEtudiant->bindValue(':viletu', $this->viletu);
            $stmtEtudiant->bindValue(':cpetu', $this->cpetu);
            $stmtEtudiant->bindValue(':teletu', $this->teletu);
            $stmtEtudiant->bindValue(':datentetu', $datentetu->format('Y-m-d'));
            $stmtEtudiant->bindValue(':annetu', $this->annetu);
            $stmtEtudiant->bindValue(':remetu', $this->remetu);
            $stmtEtudiant->bindValue(':sexetu', $this->sexetu);
            $stmtEtudiant->bindValue(':datnaietu', $datnaietu->format('Y-m-d'));

            // Execution : 
            $stmtEtudiant->execute();

            // === Fin Création l'etudiant.
            $this->pdo->commit();

            $_SESSION['mesgs']['confirm'][] = "Etudiant Créer (create)";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), "La clé « (numetu)") !== false) { // Dans le cas d'un duplicat :
                $_SESSION['mesgs']['errors'][] = "Le numero etudiant est déjà utilisé.";
            } elseif (strpos($e->getMessage(), "valeur trop longue pour le type character varying(10)") != false) {
                $_SESSION['mesgs']['errors'][] = "Le nom de la ville est trop long.";
            } else {
                $_SESSION['mesgs']['errors'][] = $e->getMessage();
            }
            $this->pdo->rollback();
        }
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur un étudiant.
     * 
     * 
     * @param int $numetu Le numéro étudiant. 
     * @return array Le tableau des valeurs. Et modification de l'étudiant actuel.
     */
    public function fetch($numetu)
    {
        try {
            if ($numetu) { // Si numetu existe recherche par numetu
                $sql = "SELECT * FROM etudiants where numetu = :numetu";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':numetu', $numetu);
            } else {
                $_SESSION['mesgs']['errors'][] = "Pour la fonction fetch un parametre doit etre non nul.";
                return null;
            }

            $stmt->execute();
            $valeur = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($valeur)) {
                $this->hydrate($valeur);
                return $valeur;
            } else {
                $_SESSION['mesgs']['errors'][] = "Aucun étudiant trouvé pour le numetu :" . $numetu;
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur tous les etudiants.
     * 
     * @return array Tableau de tous les etudiants.
     */
    public function fetchAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT etudiants.* FROM etudiants order by numetu");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Methode permettant de trouver des etudiants via des filtres de recherche.
     * 
     * @param array $critere les critères sous forme [clé => valeurs] multiples.
     * @return array Le tableau des etudiants trouvés.
     */
    public function find($critere)
    {
        try {

            $where = [];
            $params = [];

            foreach ($critere as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }

            $whereStr = implode(" AND ", $where);

            $sql = "SELECT * FROM etudiants where $whereStr;";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $params[$key]);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $_SESSION['mesgs']['errors'][] = "Aucun étudiant trouvé pour ces filtres.";
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
        return [];
    }

    /**
     * Méthode permettant d'update un etudiant de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function update()
    {
        try {
            $this->pdo->beginTransaction();
            // Initialisation des variables : 
            $datnaietu = DateTime::createFromFormat('Y-m-d', $this->datnaietu);
            $datentetu = DateTime::createFromFormat('Y-m-d', $this->datentetu);

            // $sqlEtudiant = "UPDATE etudiants set nometu = :nometu, prenometu = :prenometu, adretu = :adretu, viletu = :viletu,
            // cpetu = :cpetu, teletu = :teletu, datentetu = :datentetu, annetu = :annetu, remetu = :remetu, sexetu = :sexetu, datnaietu = :datnaietu where numetu = :numetu;";

            // // Pour utiliser les procedures : 
            $sqlEtudiant = "CALL modif_etudiant(:numetu, :nometu, :prenometu, :adretu, :viletu, :cpetu, :teletu, :datentetu, :annetu,
             :remetu, :sexetu, :datnaietu)";
            $stmtEtudiant = $this->pdo->prepare($sqlEtudiant);

            $stmtEtudiant->bindValue(':numetu', $this->numetu);
            $stmtEtudiant->bindValue(':nometu', $this->nometu);
            $stmtEtudiant->bindValue(':prenometu', $this->prenometu);
            $stmtEtudiant->bindValue(':adretu', $this->adretu);
            $stmtEtudiant->bindValue(':viletu', $this->viletu);
            $stmtEtudiant->bindValue(':cpetu', $this->cpetu);
            $stmtEtudiant->bindValue(':teletu', $this->teletu);
            $stmtEtudiant->bindValue(':datentetu', $datentetu->format('Y-m-d'));
            $stmtEtudiant->bindValue(':annetu', $this->annetu);
            $stmtEtudiant->bindValue(':remetu', $this->remetu);
            $stmtEtudiant->bindValue(':sexetu', $this->sexetu);
            $stmtEtudiant->bindValue(':datnaietu', $datnaietu->format('Y-m-d'));

            $stmtEtudiant->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();

            if (strpos($e->getMessage(), "valeur trop longue pour le type character varying(10)") != false) {
                $_SESSION['mesgs']['errors'][] = "Le nom de la ville est trop long.";
            } else {
                $_SESSION['mesgs']['errors'][] = $e->getMessage();
            }
            $this->pdo->rollback();
        }
    }

    /**
     * Méthode permettant de supprimer un etudiant de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function delete()
    {

        try {
            $this->pdo->beginTransaction();

            // === Suppression Etudiant : 
            $sqlEtudiant = "DELETE FROM etudiants WHERE numetu = :numetu";
            $stmtEtudiant = $this->pdo->prepare($sqlEtudiant);

            $stmtEtudiant->bindValue(':numetu', $this->numetu);

            $stmtEtudiant->execute();
            // === Fin Suppresion Etudiant.

            $this->pdo->commit();
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
    }

    /**
     * Setteur.
     * 
     * @param mixed $name Le nom de l'attribut.
     * @param mixed $value La valeur de l'attribut.
     * @return void
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * Getteur.
     * 
     * @param mixed $name Le nom de l'attribut.
     * @return mixed La valeur de l'attribut. 
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Test de l'année avec ajout d'erreurs.
     * 
     * @param string $annetu
     * @return srting La variable $annetu ou null si y a une erreur.
     */
    public function isYear($annetu)
    {
        // On verifie si l'année est conforme.
        $annetu = (int)$annetu;
        if ($annetu >= 1 && $annetu <= 2) {
            return $annetu;
        } else {
            if (empty($annetu)) {
                $_SESSION['mesgs']['errors'][] = 'L\'année ne doit pas être vide.';
            } else {
                $_SESSION['mesgs']['errors'][] = 'L\'année d\'étude doit être un nombre entier compris entre 1 et 8.';
            }
            return 0;
        }
    }

    /**
     * Test du numetu avec ajout d'erreurs.
     * 
     * @param string $numetu.
     * @return srting La variable $numetu ou null si y a une erreur.
     */
    function isNumetu($numetu)
    {
        if (empty($numetu)) {
            return "";
        }
        if (!is_numeric($numetu)) {
            $_SESSION['mesgs']['errors'][] = "Le numetu doit etre un nombre.";
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le num etu ne change pas ou est vide : 
            if ($this->numetu == "" || $_POST["numetu"] == $this->numetu) {
                return $numetu;
            }
        }
        return $numetu;
    }

    /**
     * Test du code postal
     * @param int $cpens. 
     * @return srting La variable $cpens ou null si y a une erreur.
     */
    function isCp($cpens)
    {

        if (empty($cpens)) {
            return "";
        }
        if (!is_numeric($cpens)) {
            $_SESSION['mesgs']['errors'][] = "Le code postal doit etre un nombre.";
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le cpens ne change pas ou est vide : 
            if ($this->cpens == "" || $_POST["cpens"] == $this->cpens) {
                return $cpens;
            }
        }
        return $cpens;
    }
}
