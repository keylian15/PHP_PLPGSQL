<?php

require_once(dirname(__FILE__) . '/module.class.php');

/**
 * 
 */
class Epreuve
{

    private int $numepr;
    private string $libepr;
    private int $ensepr;
    private int $matepr;
    private string $datepr;
    private int $coefepr;
    private int $annepr;

    private object $pdo;

    /**
     * Magik methode permettant de construire et d'initialiser l'epreuve.
     * 
     * @param object $pdo Le pdo permettant d'acceder a la base de données.
     * @param array $data Tableau permettant d'hydrater l'epreuve, null par défaut.
     * @return void
     */
    public function __construct($pdo, $datas = [])
    {
        // Initialiser les variables
        $this->pdo = $pdo;

        $this->numepr = 0;
        $this->libepr = "";
        $this->ensepr = 0;
        $this->matepr = 0;
        $this->datepr = "";
        $this->coefepr = 0;
        $this->annepr = 0;

        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Méthode permettant d'hydrater l'epreuve avec des données avec ajout d'erreur.
     * 
     * @param array $data Un tableau de valeurs associatifs.
     * @return void
     */
    public function hydrate(array $data)
    {
        $this->numepr = filter_var($data["numepr"], FILTER_VALIDATE_INT) ?? 0;
        $this->libepr = filter_var($data["libepr"]) ?? "";
        $this->ensepr = filter_var($data["ensepr"], FILTER_VALIDATE_INT) ?? 0;
        $this->matepr = filter_var($data["matepr"], FILTER_VALIDATE_INT) ?? 0;
        $this->datepr = filter_var($data["datepr"]) ?? "";
        $this->coefepr = filter_var($data["coefepr"], FILTER_VALIDATE_INT) ?? 0;
        $this->annepr = filter_var($data["annepr"], FILTER_VALIDATE_INT) ?? 0;

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
     * Fonction permettant de créer un epreuves en base de donnée avec ajout d'erreur.
     * 
     * @return void
     */
    public function create()
    {
        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables :
            $datepr = DateTime::createFromFormat('d-m-Y', $this->datepr);
            if (!$datepr) {
                $datepr = DateTime::createFromFormat('Y-m-d', $this->datepr);
            }

            // === Création de epreuves : 
            // $sql = "INSERT INTO epreuves (numepr, libepr, ensepr, matepr, datepr, coefepr, annepr) 
            // VALUES (:numepr, :libepr, :ensepr, :matepr, :datepr, :coefepr, :annepr)";
            $sql = "CALL ajout_note(:numepr, :libepr, :ensepr, :matepr, :datepr, :coefepr, :annepr)";

            // Préparer la commande SQL
            $stmt = $this->pdo->prepare($sql);

            // Lier les valeurs
            $stmt->bindValue(':numepr', $this->numepr);
            $stmt->bindValue(':libepr', $this->libepr);
            $stmt->bindValue(':ensepr', $this->ensepr);
            $stmt->bindValue(':matepr', $this->matepr);
            $stmt->bindValue(':datepr', $datepr->format('Y-m-d'));
            $stmt->bindValue(':coefepr', $this->coefepr);
            $stmt->bindValue(':annepr', $this->annepr);

            // Exécuter la requête
            $stmt->execute();

            // === Fin Création du epreuve.
            $this->pdo->commit();

            $_SESSION['mesgs']['confirm'][] = "Epreuve Créer (create)";
        } catch (PDOException $e) {

            if (strpos($e->getMessage(), "La clé « (numepr)") !== false) { // Dans le cas d'un duplicat :

                $_SESSION['mesgs']['errors'][] = "Le numero du epreuves est déjà utilisé.";
            } else {
                $_SESSION['mesgs']['errors'][] = $e->getMessage();
            }
            $this->pdo->rollback();
        }
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur un epreuve.
     * 
     * @param int $numepr Le numepr epreuve.
     * @return array Le tableau des valeurs. Et modification de l'epreuves actuel.
     */
    public function fetch($numepr)
    {
        try {
            if ($numepr) { // Si numepr existe recherche par numepr
                $sql = "SELECT * FROM epreuves where numepr = :numepr";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':numepr', $numepr);
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
                $_SESSION['mesgs']['errors'][] = "Aucune epreuve trouvée pour le numepr :" . $numepr;
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Méthode permettant d'obtenir toutes les informations sur tous les epreuves.
     * 
     * @return array Tableau de tous les epreuves.
     */
    public function fetchAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT epreuves.* FROM epreuves order by numepr");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] = $e->getMessage();
        }
        return null;
    }

    /**
     * Methode permettant de trouver des epreuves via des filtres de recherche.
     * 
     * @param array $critere les critères sous forme [clé => valeurs] multiples.
     * @return array Le tableau des epreuves trouvés.
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

            $sql = "SELECT * FROM epreuves where $whereStr;";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $params[$key]);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $_SESSION['mesgs']['errors'][] = "Aucune epreuves trouvée pour ces filtres.";
            }
        } catch (PDOException $e) {
            $_SESSION['mesgs']['errors'][] =  $e->getMessage();
        }
        return [];
    }

    /**
     * Méthode permettant d'update un epreuves de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function update()
    {
        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables :
            $datepr = DateTime::createFromFormat('d-m-Y', $this->datepr);
            if (!$datepr) {
                $datepr = DateTime::createFromFormat('Y-m-d', $this->datepr);
            }

            // === Mise à jour d'une épreuve :
            // $sql = "UPDATE epreuves SET libepr = :libepr, ensepr = :ensepr, matepr = :matepr, datepr = :datepr, coefepr = :coefepr, annepr = :annepr WHERE numepr = :numepr";
            $sql = "CALL modif_note(:numepr, :libepr, :ensepr, :matepr, :datepr, :coefepr, :annepr)";

            // Préparer la commande SQL
            $stmt = $this->pdo->prepare($sql);

            // Lier les valeurs
            $stmt->bindValue(':numepr', $this->numepr);
            $stmt->bindValue(':libepr', $this->libepr);
            $stmt->bindValue(':ensepr', $this->ensepr);
            $stmt->bindValue(':matepr', $this->matepr);
            $stmt->bindValue(':datepr', $datepr->format('Y-m-d'));
            $stmt->bindValue(':coefepr', $this->coefepr);
            $stmt->bindValue(':annepr', $this->annepr);

            // Exécuter la requête
            $stmt->execute();

            // === Fin mise à jour de l'épreuve.
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();

            if (strpos($e->getMessage(), "SQLSTATE[23505]") !== false) { // Dans le cas d'un duplicat :

                if (strpos($e->getMessage(), "libepr") !== false) {
                    $_SESSION['mesgs']['errors'][] = "Le numero du epreuves est déjà utilisé.";
                } elseif (strpos($e->getMessage(), "'epreuves.name'") !== false) {
                    $_SESSION['mesgs']['errors'][] = "Le nom du epreuves est déjà utilisé.";
                } else {
                    $_SESSION['mesgs']['errors'][] = $e->getMessage();
                }
            } else {
                $_SESSION['mesgs']['errors'][] =  $e->getMessage();
            }
        }
    }

    /**
     * Méthode permettant de supprimer un epreuves de la BDD avec ajout d'erreur.
     *      
     * @return void
     */
    public function delete()
    {

        try {
            $this->pdo->beginTransaction();

            // Initialisation des variables : 

            // === Suppression epreuves : 
            $sql = "DELETE FROM epreuves WHERE numepr = :numepr";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':numepr', $this->numepr);

            $stmt->execute();

            // === Fin Suppresion epreuve.
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
}
