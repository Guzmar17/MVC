<?php
require_once "model/ModelInterface.class.php";
require_once "model/persist/ConnectFile.class.php";
require_once "model/persist/ConnectFile.class.php";

class ProductFileDAO implements ModelInterface {

    private static $instance=NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE="model/resource/products.txt";    
    
    public function __construct() {
        $this->connect=new ConnectFile(self::FILE);
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    public static function getInstance():ProductFileDAO {
        if (is_null(self::$instance)) {
            self::$instance=new self();
        }
        return self::$instance;
    }

    /**
     * insert a product in file
     * @param $product Product object to insert
     * @return TRUE or FALSE
     */    
    public function add($product):bool {
        $result=FALSE;

        // abre el fichero en modo append
        if ($this->connect->openFile("a+")) {
            fputs($this->connect->getHandle(), $product->__toString());
            $this->connect->closeFile();
            $result=TRUE;
        }

        return $result;
    }

    /**
     * update a product in file
     * @param $product Product object to update
     * @return TRUE or FALSE
     */
    public function modify($product):bool {
        
        return false; 
    }

    public function delete($id):bool {
        $result = FALSE;
        $fileData = array();
        $deleted = FALSE;

        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);

                    if ($id != $fields[0]) {
                        array_push($fileData, $line . "\n"); // Guarda les línies que NO s'esborren
                    } else {
                        $deleted = TRUE;
                    }
                }
            }
            $this->connect->closeFile();
        }

        // Només reescriu si s'ha trobat l'ID i s'ha eliminat
        if ($deleted && $this->connect->writeFile($fileData)) {
            $result = TRUE;
        }

        return $result;
    } 
    public function listAll():array{
        $result=array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    $product=new product($fields[0], $fields[1]);
                    array_push($result, $product);
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }    
     public function searchById($id) {  // SIN tipo de retorno específico
        $product = NULL;

        // Lee el archivo línea por línea buscando el ID
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                
                if ($line != "") {
                    $fields = explode(";", $line);
                    
                    // Si encuentra el ID, crea y retorna el objeto Product
                    if ($id == $fields[0]) {
                        $product = new Product(
                            $fields[0],                         // id
                            $fields[1],                         // name
                            $fields[2],                         // price
                            isset($fields[3]) ? $fields[3] : '', // description
                            isset($fields[4]) ? $fields[4] : ''  // category
                        );
                        break; // Sale del bucle cuando lo encuentra
                    }      
                }
            }
            $this->connect->closeFile();
        }

        return $product;
    }

}



?>