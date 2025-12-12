<?php
require_once "model/persist/ProductFileDAO.class.php";
require_once "model/Product.class.php";

class ProductModel {

    private $dataProduct;

    public function __construct() {
        // Utilitza el Singleton per obtenir l'única instància de ProductFileDAO
        $this->dataProduct = ProductFileDAO::getInstance();
    }

    /**
     * Insereix un producte
     */
    public function add($product):bool {
        $result = $this->dataProduct->add($product);

        // if ($result == FALSE) {
        //     $_SESSION['error'] = ProductMessage::ERR_DAO['insert']; // Si hi ha un error al DAO
        // }

        return $result;
    }

    /**
     * actualitza un producte
     */
    public function modify($product):bool {
        // Aquí podries afegir comprovacions abans de cridar al DAO
        $result = $this->dataProduct->modify($product);
        return $result;
    }

    /**
     * elimina un producte
     */
    public function delete($id):bool {
        $result = $this->dataProduct->delete($id);
        return $result;
    }

    /**
     * selecciona tots els productes
     */
    public function listAll():array {
        $products = $this->dataProduct->listAll();
        return $products;
    }

    /**
     * selecciona un producte per Id
     */
    public function searchById($id) {
        $product = $this->dataProduct->searchById($id);
        return $product;
    }
}
?>