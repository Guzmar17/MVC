<?php

require_once "model/ModelInterface.class.php";
require_once "model/persist/ConnectDb.class.php";

class ProductDbDAO implements ModelInterface {
private static $instance = NULL; // instancia de la clase
    private $connect; // conexión actual

    public function __construct() {
        $this->connect = (new ConnectDb())->getConnection();
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    public static function getInstance(): ProductDbDAO {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function add($product): bool {
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return FALSE;
        };

        try {
            $sql = <<<SQL
                INSERT INTO product (id,name,price,category_id) 
                VALUES (:id,:name,:price,:category_id);
SQL;

            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $product->getId(), PDO::PARAM_INT);
            $stmt->bindValue(":name", $product->getName(), PDO::PARAM_STR);
            $stmt->bindValue(":price", $product->getPrice(), PDO::PARAM_STR);
            $stmt->bindValue(":category_id", $product->getCategoryId(), PDO::PARAM_INT);

            $stmt->execute(); // devuelve TRUE o FALSE

            if ($stmt->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return FALSE;
        }
    }

    public function modify($product): bool {
        
    }

    public function delete($id): bool {
        /* TODO */
    }

    public function listAll(): array {
        $result = array(); 
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $result;
        }; 
        try {
            $sql = <<<SQL
                SELECT id,name,price,category_id FROM product;
SQL;

            $result = $this->connect->query($sql); // devuelve los datos

            $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');

            return $result->fetchAll();
        } catch (PDOException $e) {
            return $result;
        } return $result;

        }  


     public function searchById($id) {
        $product = NULL;

        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $product;
        };

        try {
            $sql = <<<SQL
                SELECT id,name,price,category_id FROM product WHERE id = :id;
SQL;
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute(); // devuelve TRUE o FALSE

            if ($stmt->rowCount()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');
                $product = $stmt->fetch();
            }

            return $product;
        } catch (PDOException $e) {
            return $product;
        }

    }
}
?>