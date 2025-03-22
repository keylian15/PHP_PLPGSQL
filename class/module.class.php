<?php

/**
 * 
 */
class Module
{
    private string $nummod;
    private string $nommod;
    private int $coefmod;

    private object $pdo;

    /**
     * Magik methode permettant de construire et d'initialiser la module.
     * 
     * @param object $pdo Le pdo permettant d'acceder a la base de données.
     * @param array $data Tableau permettant d'hydrater la module, null par défaut.
     * @return void
     */
    public function __construct($pdo, $datas = [])
    {
        // Initialiser les variables
        $this->pdo = $pdo;

        $this->nummod = "";
        $this->nommod = "";
        $this->coefmod = 0;

        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Méthode permettant d'hydrater le module avec des données avec ajout d'erreur.
     * 
     * @param array $data Un tableau de valeurs associatifs.
     * @return void
     */
    public function hydrate(array $data)
    {
        $this->nummod = $this->isNummod($data["nummod"]);
        $this->nommod = $this->isNamemod($data["nommod"]);
        $this->coefmod = $this->isCoef($data["coefmod"]);

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
     * Fonction permettant de créer un module en base de donnée avec ajout d'erreur.
     * 
     * @return void
     */
    public function create()
    {


        try {
            $this->pdo->beginTransaction();

            // === Création de du module : 
            // $sql = "INSERT INTO modules (nummod, nommod, coefmod) VALUES (:nummod,:nommod,:coefmod);";
            // Pour les procédures :
            $sql = "CALL ajout_module(:nummod, :nommod, :coefmod)";

            // Préparer la commande sql : 
            $stmt = $this->pdo->prepare($sql);

            // Les valeurs : 
            $stmt->bindValue(':nummod', $this->nummod);
            $stmt->bindValue(':nommod', $this->nommod);
            $stmt->bindValue(':coefmod', $this->coefmod);

            // Execution : 
            $stmt->execute();

            // === Fin Création du module.
            $this->pdo->commit();

            $_SESSION['mesgs']['confirm'][] = "Module Créer (create)";
        } catch (PDOException $e) {

            if (strpos($e->getMessage(), "La clé « (nummod)") !== false) { // Dans le cas d'un duplicat :
                $_SESSION['mesgs']['errors'][] = "Le numero du module est déjà utilisé.";
            } else {
                $_SESSION['mesgs']['errors'][] = $e->getMessage();
            }

            $this->pdo->rollback();
        }
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur un module.
     * 
     * @param int $nummod Le numéro module. 
     * @return array Le tableau des valeurs. Et modification de la module actuel.
     */
    public function fetch($nummod = 0)
    {
        try {
            if ($nummod) { // Si nummod existe recherche par nummod
                $sql = "SELECT * FROM modules where nummod = :nummod";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':nummod', $nummod);
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
                $_SESSION['mesgs']['errors'][] = "Aucun module trouvé pour le nummod :" . $nummod;
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur tous les modules.
     * 
     * @return array Tableau de tous les modules.
     */
    public function fetchAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT modules.* FROM modules order by nummod");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Methode permettant de trouver des modules via des filtres de recherche.
     * 
     * @param array $critere les critères sous forme [clé => valeurs] multiples.
     * @return array Le tableau des modules trouvés.
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

            $sql = "SELECT * FROM modules where $whereStr;";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $params[$key]);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $_SESSION['mesgs']['errors'][] = "Aucun module trouvé pour ces filtres.";
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
        return [];
    }

    /**
     * Méthode permettant d'update un module de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function update()
    {
        try {
            $this->pdo->beginTransaction();
            // Initialisation des variables : 

            // $sql = "UPDATE modules set nommod = :nommod, coefmod = :coefmod where nummod = :nummod;";
            // Pour les procédures : 
            $sql = "CALL modif_module(:nummod, :nommod, :coefmod)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':nummod', $this->nummod);
            $stmt->bindValue(':nommod', $this->nommod);
            $stmt->bindValue(':coefmod', $this->coefmod);

            $stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
    }

    /**
     * Méthode permettant de supprimer un module de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function delete()
    {

        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables : 

            // === Suppression module : 
            $sql = "DELETE FROM modules WHERE nummod = :nummod";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':nummod', $this->nummod);

            $stmt->execute();

            // === Fin Suppresion module.

            $this->pdo->commit();

            // $_SESSION['mesgs']['confirm'][] = "module supprimé.";

        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
    }

    /**
     * Setteur.
     * 
     * @param mixed $nommod Le nom de l'attribut.
     * @param mixed $value La valeur de l'attribut.
     * @return void
     */
    public function __set($nommod, $value)
    {
        $this->$nommod = $value;
    }

    /**
     * Getteur.
     * 
     * @param mixed $nommod Le nom de l'attribut.
     * @return mixed La valeur de l'attribut. 
     */
    public function __get($nommod)
    {
        return $this->$nommod;
    }

    /**
     * Test du nummod avec ajout d'erreurs.
     * 
     * @param string $nummod.
     * @return srting La variable $nummod ou null si y a une erreur.
     */
    function isNummod($nummod)
    {
        if (empty($nummod)) {
            return "";
        }
        if (!is_numeric($nummod)) {
            $_SESSION['mesgs']['errors'][] = "Le nummod doit etre un nombre.";
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le num etu ne change pas ou est vide : 
            if ($this->nummod == "" || $_POST["nummod"] == $this->nummod) {
                return $nummod;
            }
        }
        return $nummod;
    }

    /**
     * Test du nommod avec ajout d'erreurs.
     * 
     * @param string $nommod.
     * @return srting La variable $nommod ou null si y a une erreur.
     */
    function isNamemod($nommod)
    {
        if (empty($nommod)) {
            return "";
        }
        if (GETPOST('action') == "edit") {
            // Si le num etu ne change pas ou est vide : 
            if ($this->nommod == "" || $_POST["nommod"] == $this->nommod) {
                return $nommod;
            }
        }
        return $nommod;
    }

    /**
     * Test du code postal
     * @param int $cpens. 
     * @return srting La variable $cpens ou null si y a une erreur.
     */
    function isCoef($coefmod)
    {
        if (empty($coefmod)) {
            return "";
        }
        if (!is_numeric($coefmod)) {
            $_SESSION['mesgs']['errors'][] = "Le coefficient doit etre un nombre.";
            return "";
        }
        return $coefmod;
    }
}
