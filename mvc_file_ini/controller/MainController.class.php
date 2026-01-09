<?php
require_once "controller/CategoryController.class.php";
require_once "controller/ProductController.class.php";
require_once "controller/UserController.class.php";
class MainController {

    // carga la vista según la opción
    public function processRequest() {

        //$request=filter_has_var(INPUT_GET, 'menu')?filter_input(INPUT_GET, 'menu'):NULL;

        $request=NULL;
        // recupera la opción de un menú
        if (filter_has_var(INPUT_GET, 'menu')) {
            $request=filter_input(INPUT_GET, 'menu');
        }

        switch ($request) {
            // categorías
             case "category":
                $controlCategory=new CategoryController();
                $controlCategory->processRequest();
                break;
            case "product":
                echo "<p style='color: green;'>Ejecutando ProductController</p>";
                $controlProduct = new ProductController();
                $controlProduct->processRequest();
                break;
            default:
                $controlCategory=new CategoryController();
                $controlCategory->processRequest();
                break;
        }

    }
    
}
