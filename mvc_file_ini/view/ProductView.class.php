<?php
class ProductView {
    
    public function __construct() {
        // Constructor vacío
    }

    public function display($template = NULL, $content = NULL, $categories = NULL) {
        // DEBUG TEMPORAL
        echo "<p style='background: lime;'>DEBUG ProductView->display(): Categorías recibidas = ";
        if (isset($categories)) {
            echo count($categories) . "</p>";
            if (!empty($categories)) {
                foreach ($categories as $cat) {
                    echo "- " . $cat->getId() . " : " . $cat->getName() . "<br>";
                }
            }
        } else {
            echo "NULL (no se pasaron)</p>";
        }
        
        // Incluye el menú principal
        include("view/menu/MainMenu.html");

        // Incluye la plantilla específica si se proporciona
        if (!empty($template)) {
            include($template);
        }
        
        // Incluye el formulario de mensajes (errores e información)
        include("view/form/MessageForm.php");
    }    

}