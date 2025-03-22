<?php

/**
 * 
 */
class Matiere
{

    private string $nummat;
    private string $nommat;
    private int $coefmat;
    private int $nummod;

    private object $pdo;


    /**
     * Magik methode permettant de construire et d'initialiser la matiere.
     * 
     * @param object $pdo Le pdo permettant d'acceder a la base de données.
     * @param array $data Tableau permettant d'hydrater la matiere, null par défaut.
     * @return void
     */
    public function __construct($pdo, $datas = [])
    {
        // Initialiser les variables
        $this->pdo = $pdo;

        $this->nummat = "";
        $this->nommat = "";
        $this->coefmat = 0;
        $this->nummod = 0;


        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Méthode permettant d'hydrater le matiere avec des données avec ajout d'erreur.
     * 
     * @param array $data Un tableau de valeurs associatifs.
     * @return void
     */
    public function hydrate(array $data)
    {
        $this->nummat = $this->isNummat($data["nummat"]);
        $this->nommat = $this->isNommat($data["nommat"]);
        $this->coefmat = $this->isCoef($data["coefmat"]);
        $this->nummod = filter_var($data["nummod"], FILTER_VALIDATE_INT) ?? 0;
        // Si on est bien en mode ajouter ou edit:
        if (GETPOST('action') == "add" || GETPOST('action') == "edit") {
            foreach ($data as $key => $value) {
                if (empty($value)) {
                    $_SESSION['mesgs']['errors'][] = "Tous les champs doivent etre remplis.";
                    return;
                }
            }
        }
    }

    /**
     * Fonction permettant de créer un matiere en base de donnée avec ajout d'erreur.
     * 
     * @return void
     */
    public function create()
    {
        try {
            $this->pdo->beginTransaction();

            // === Création de du matiere : 
            // $sql = "INSERT INTO matieres (nummat, nommat, coefmat, nummod) VALUES (:nummat,:nommat,:coefmat,:nummod);";
            $sql = "CALL ajout_matiere(:nummat, :nommat, :coefmat, :nummod)";

            // Préparer la commande sql : 
            $stmt = $this->pdo->prepare($sql);

            // Les valeurs : 
            $stmt->bindValue(':nummat', $this->nummat);
            $stmt->bindValue(':nommat', $this->nommat);
            $stmt->bindValue(':coefmat', $this->coefmat);
            $stmt->bindValue(':nummod', $this->nummod);

            // Execution : 
            $stmt->execute();

            // === Fin Création du matiere.
            $this->pdo->commit();

            $_SESSION['mesgs']['confirm'][] = "Matiere Créer (create)";
        } catch (PDOException $e) {

            if (strpos($e->getMessage(), "La clé « (nummat)") !== false) { // Dans le cas d'un duplicat :

                $_SESSION['mesgs']['errors'][] = "Le numero du matiere est déjà utilisé.";
            } else {
                $_SESSION['mesgs']['errors'][] = $e->getMessage();
            }
            $this->pdo->rollback();
        }
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur un matiere.
     * 
     * @param int $nummat Le numéro matiere. 
     * @return array Le tableau des valeurs. Et modification de la matiere actuel.
     */
    public function fetch($nummat)
    {
        try {
            if ($nummat) { // Si nummat existe recherche par nummat
                $sql = "SELECT * FROM matieres where nummat = :nummat";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':nummat', $nummat);
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
                $_SESSION['mesgs']['errors'][] = "Aucun matiere trouvé pour le nummat :" . $nummat;
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur tous les matieres.
     * 
     * @return array Tableau de tous les matieres.
     */
    public function fetchAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT matieres.* FROM matieres order by nummat");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Methode permettant de trouver des matieres via des filtres de recherche.
     * 
     * @param array $critere les critères sous forme [clé => valeurs] multiples.
     * @return array Le tableau des matieres trouvés.
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

            $sql = "SELECT * FROM matieres where $whereStr;";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $params[$key]);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $_SESSION['mesgs']['errors'][] = "Aucun matiere trouvé pour ces filtres.";
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
        return [];
    }

    /**
     * Méthode permettant d'update un matiere de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function update()
    {
        try {
            $this->pdo->beginTransaction();
            // Initialisation des variables : 

            // $sql = "UPDATE matieres set nommat = :nommat, coefmat = :coefmat, nummod = :nummod where nummat = :nummat;";
            // Pour les procédures : 
            $sql = "CALL update_matiere(:nummat, :nommat, :coefmat, :nummod)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nummat', $this->nummat);
            $stmt->bindValue(':nommat', $this->nommat);
            $stmt->bindValue(':coefmat', $this->coefmat);
            $stmt->bindValue(':nummod', $this->nummod);

            $stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
    }

    /**
     * Méthode permettant de supprimer un matiere de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function delete()
    {

        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables : 

            // === Suppression matiere : 
            $sql = "DELETE FROM matieres WHERE nummat = :nummat";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':nummat', $this->nummat);

            $stmt->execute();

            // === Fin Suppresion matiere.

            $this->pdo->commit();

            // $_SESSION['mesgs']['confirm'][] = "matiere supprimé.";

        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
    }

    /**
     * Setteur.
     * 
     * @param mixed $nommat Le nom de l'attribut.
     * @param mixed $value La valeur de l'attribut.
     * @return void
     */
    public function __set($nommat, $value)
    {
        $this->$nommat = $value;
    }

    /**
     * Getteur.
     * 
     * @param mixed $nommat Le nom de l'attribut.
     * @return mixed La valeur de l'attribut. 
     */
    public function __get($nommat)
    {
        return $this->$nommat;
    }

    /**
     * Test du nummat avec ajout d'erreurs.
     * 
     * @param string $nummat.
     * @return srting La variable $nummat ou null si y a une erreur.
     */
    function isNummat($nummat)
    {
        if (empty($nummat)) {
            return "";
        }
        if (!is_numeric($nummat)) {
            $_SESSION['mesgs']['errors'][] = "Le nummat doit etre un nombre.";
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le num etu ne change pas ou est vide : 
            if ($this->nummat == "" || $_POST["nummat"] == $this->nummat) {
                return $nummat;
            }
        }
        return $nummat;
    }

    /**
     * Test du nommat avec ajout d'erreurs.
     * 
     * @param string $nommat.
     * @return srting La variable $nommat ou null si y a une erreur.
     */
    function isNommat($nommat)
    {
        if (empty($nommat)) {
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le num etu ne change pas ou est vide : 
            if ($this->nommat == "" || $_POST["nommat"] == $this->nommat) {
                return $nommat;
            }
        }
        return $nommat;
    }

    /**
     * Test du code coefficient
     * @param int $coefmat. 
     * @return srting La variable $coefmat ou null si y a une erreur.
     */
    function isCoef($coefmat)
    {
        if (empty($coefmat)) {
            $_SESSION['mesgs']['errors'][] = "Le coefficient doit etre supérieur a 0.";
            return 0;
        }
        if (!is_numeric($coefmat)) {
            $_SESSION['mesgs']['errors'][] = "Le coefficient doit etre un nombre.";
            return 0;
        }
        return $coefmat;
    }
}
