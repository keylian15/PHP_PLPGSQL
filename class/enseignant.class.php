<?php

/**
 * 
 */
class Enseignant
{

    private string $numens;
    private string $nomens;
    private string $preens;
    private string $foncens;
    private string $adrens;
    private string $vilens;
    private string $cpens;
    private string $telens;
    private string $datnaiens;
    private string $datembens;
    public array $t_function =  ["AGREGE", "CERTIFIE", "MAITRE DE CONFERENCES", "VACATAIRE"];

    private object $pdo;

    /**
     * Magik methode permettant de construire et d'initialiser l'enseignant.
     * 
     * @param object $pdo Le pdo permettant d'acceder a la base de données.
     * @param array $data Tableau permettant d'hydrater l'enseignant, null par défaut.
     * @return void
     */
    public function __construct($pdo, $datas = [])
    {
        // Initialiser les variables
        $this->pdo = $pdo;

        $this->numens = "";
        $this->nomens = "";
        $this->preens = "";
        $this->foncens = "";
        $this->adrens = "";
        $this->vilens = "";
        $this->cpens = "";
        $this->telens = "";
        $this->datnaiens = "";
        $this->datembens = "";

        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Méthode permettant d'hydrater l'enseignant avec des données avec ajout d'erreur.
     * 
     * @param array $data Un tableau de valeurs associatifs.
     * @return void
     */
    public function hydrate(array $data)
    {

        $this->numens = $this->isNumens($data["numens"]);
        $this->nomens = filter_var($data["nomens"]) ?? "";
        $this->preens = filter_var($data["preens"]) ?? "";
        $this->foncens = filter_var($data["foncens"]) ?? "";
        $this->adrens = filter_var($data["adrens"]) ?? "";
        $this->vilens = filter_var($data["vilens"]) ?? "";
        $this->cpens = $this->isCp($data["cpens"]);
        $this->telens = filter_var($data["telens"]) ?? "";
        $this->datnaiens = filter_var($data["datnaiens"]) ?? "";
        $this->datembens = filter_var($data["datembens"]) ?? "";

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
     * Fonction permettant de créer un enseignant en base de donnée avec ajout d'erreur.
     * 
     * @return void
     */
    public function create()
    {

        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables :
            $datnaiens = DateTime::createFromFormat('d-m-Y', $this->datnaiens);
            if (!$datnaiens) {
                $datnaiens = DateTime::createFromFormat('Y-m-d', $this->datnaiens);
            }
            $datembens = DateTime::createFromFormat('d-m-Y', $this->datembens);
            if (!$datembens) {
                $datembens = DateTime::createFromFormat('Y-m-d', $this->datembens);
            }

            // === Création de l'enseignant : 
            // $sqlEnseignant = "INSERT INTO enseignants (numens, nomens, preens, foncens, adrens, vilens, cpens, telens, datnaiens, datembens) VALUES
            // (:numens, :nomens, :preens, :foncens, :adrens, :vilens, :cpens, :telens, :datnaiens, :datembens);";

            // Pour utiliser les procedures : 
            $sqlEnseignant = "CALL ajout_enseignant(:numens, :nomens, :preens, :foncens, :adrens, :vilens, :cpens, :telens, :datnaiens, :datembens)";

            // Préparer la commande sql : 
            $stmtEnseignant = $this->pdo->prepare($sqlEnseignant);

            // Les valeurs : 
            $stmtEnseignant->bindValue(':numens', $this->numens);
            $stmtEnseignant->bindValue(':nomens', $this->nomens);
            $stmtEnseignant->bindValue(':preens', $this->preens);
            $stmtEnseignant->bindValue(':foncens', $this->foncens);
            $stmtEnseignant->bindValue(':adrens', $this->adrens);
            $stmtEnseignant->bindValue(':vilens', $this->vilens);
            $stmtEnseignant->bindValue(':cpens', $this->cpens);
            $stmtEnseignant->bindValue(':telens', $this->telens);
            $stmtEnseignant->bindValue(':datnaiens', $datnaiens->format('Y-m-d'));
            $stmtEnseignant->bindValue(':datembens', $datembens->format('Y-m-d'));

            // Execution : 
            $stmtEnseignant->execute();

            // === Fin Création l'enseignant.
            $this->pdo->commit();

            $_SESSION['mesgs']['confirm'][] = "Enseignant Créer (create)";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), "La clé « (numens)") !== false) { // Dans le cas d'un duplicat :
                $_SESSION['mesgs']['errors'][] = "Le numero enseignant est déjà utilisé.";
            } else {
                $_SESSION['mesgs']['errors'][] = $e->getMessage();
            }
            $this->pdo->rollback();
        }
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur un enseignant.
     * 
     * @param int $numens Le numéro enseignant. 
     * @return array Le tableau des valeurs. Et modification de l'enseignant actuel.
     */
    public function fetch($numens = 0)
    {
        try {
            if ($numens) { // Si numens existe recherche par numens
                $sql = "SELECT * FROM enseignants where numens = :numens";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':numens', $numens);
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
                $_SESSION['mesgs']['errors'][] = "Aucun enseignant trouvé pour le numens :" . $numens;
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur tous les enseignants.
     * 
     * @return array Tableau de tous les enseignants.
     */
    public function fetchAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM enseignants order by numens");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Methode permettant de trouver des enseignants via des filtres de recherche.
     * 
     * @param array $critere les critères sous forme [clé => valeurs] multiples.
     * @return array Le tableau des enseignants trouvés.
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

            $sql = "SELECT * FROM enseignants where $whereStr;";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $params[$key]);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $_SESSION['mesgs']['errors'][] = "Aucun enseignant trouvé pour ces filtres.";
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
        return [];
    }

    /**
     * Méthode permettant d'update un enseignant de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function update()
    {
        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables : 
            $datnaiens = DateTime::createFromFormat('d-m-Y', $this->datnaiens);
            if (!$datnaiens) {
                $datnaiens = DateTime::createFromFormat('Y-m-d', $this->datnaiens);
            }
            $datembens = DateTime::createFromFormat('d-m-Y', $this->datembens);
            if (!$datembens) {
                $datembens = DateTime::createFromFormat('Y-m-d', $this->datembens);
            }

            // $sqlEnseignant = "UPDATE enseignants set nomens = :nomens, preens = :preens, foncens = :foncens, adrens = :adrens, vilens = :vilens, cpens = :cpens,
            // telens = :telens, datnaiens = :datnaiens, datembens = :datembens where numens = :numens;";

            // Pour utiliser les procédures : 
            $sqlEnseignant = "CALL update_enseignant(:numens, :nomens, :preens, :foncens, :adrens, :vilens, :cpens, :telens, :datnaiens, :datembens)";

            $stmtEnseignant = $this->pdo->prepare($sqlEnseignant);

            $stmtEnseignant->bindValue(':nomens', $this->nomens);
            $stmtEnseignant->bindValue(':preens', $this->preens);
            $stmtEnseignant->bindValue(':foncens', $this->foncens);
            $stmtEnseignant->bindValue(':adrens', $this->adrens);
            $stmtEnseignant->bindValue(':vilens', $this->vilens);
            $stmtEnseignant->bindValue(':cpens', $this->cpens);
            $stmtEnseignant->bindValue(':telens', $this->telens);
            $stmtEnseignant->bindValue(':datnaiens', $datnaiens->format('Y-m-d'));
            $stmtEnseignant->bindValue(':datembens', $datembens->format('Y-m-d'));
            $stmtEnseignant->bindValue(':numens', $this->numens);


            $stmtEnseignant->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
    }

    /**
     * Méthode permettant de supprimer un enseignant de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function delete()
    {

        try {
            $this->pdo->beginTransaction();

            // === Suppression enseignant : 
            $sqlEnseignant = "DELETE FROM enseignants WHERE numens = :numens";
            $stmtEnseignant = $this->pdo->prepare($sqlEnseignant);

            $stmtEnseignant->bindValue(':numens', $this->numens);

            $stmtEnseignant->execute();
            // === Fin Suppresion enseignant.

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
     * Test du numens avec ajout d'erreurs.
     * 
     * @param string $numens.
     * @return srting La variable $numens ou null si y a une erreur.
     */
    function isNumens($numens)
    {
        if (empty($numens)) {
            return "";
        }
        if (!is_numeric($numens)) {
            $_SESSION['mesgs']['errors'][] = "Le numens doit etre un nombre.";
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le num etu ne change pas ou est vide : 
            if ($this->numens == "" || $_POST["numens"] == $this->numens) {
                return $numens;
            }
        }
        return $numens;
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
