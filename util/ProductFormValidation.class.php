<?php
class ProductFormValidation{
 // Camps necessaris per a cada acció
    const ADD_FIELDS = array('id', 'name', 'price', 'description', 'category'); // [cite: 28]
    const MODIFY_FIELDS = array('id', 'name', 'price', 'description', 'category'); // [cite: 57, 60, 61, 62, 63]
    const DELETE_FIELDS = array('id'); // [cite: 59, 64]
    const SEARCH_FIELDS = array('id'); // [cite: 55]

    // Expressions Regulars
    const INTEGER_POSITIVE = "/[^0-9]/"; // Numèric positiu sense decimals (per a Id) 
    const ALPHABETIC = "/[^a-z A-Z]/"; // Només lletres i espais (per a Name) [cite: 31]
    const DECIMAL_POSITIVE = "/^(\d+\.\d+|\d+)$/"; // Numèric positiu amb o sense decimals (per a Price) [cite: 32]
    // Accepta lletres, números, espais i caràcters habituals en descripcions
    const ALPHANUMERIC_OPTIONAL = "/[^a-z A-Z 0-9 ,.;\(\)\-]/i";

    public static function checkData($fields) {
        $id = NULL;
        $name = NULL;
        $price = NULL;
        $description = NULL;
        $category = NULL;

        // Inicialitza l'array d'errors si encara no existeix (és bona pràctica)
        if (!isset($_SESSION['error'])) {
            $_SESSION['error'] = array();
        }

        foreach ($fields as $field) {
            switch ($field) {
                case 'id':
                    $id = trim(filter_input(INPUT_POST, 'id'));
                    $idValid = !preg_match(self::INTEGER_POSITIVE, $id);

                    if (empty($id)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_id']); // 
                    } else if ($idValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_id']); // 
                    }
                    break;

                case 'name':
                    $name = trim(filter_input(INPUT_POST, 'name'));
                    // El nom ha de ser alfabètic (requisit) 
                    $nameValid = !preg_match(self::ALPHABETIC, $name);

                    if (empty($name)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_name']); // [cite: 31]
                    } else if ($nameValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_name']); // [cite: 31]
                    }
                    break;

                case 'price':
                    $price = trim(filter_input(INPUT_POST, 'price'));
                    // Validació per a decimals (requisit) 
                    $priceValid = preg_match(self::DECIMAL_POSITIVE, $price) && $price > 0;

                    if (empty($price)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_price']); // [cite: 32]
                    } else if ($priceValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_price']); // [cite: 32]
                    }
                    break;

                case 'description':
                    $description = trim(filter_input(INPUT_POST, 'description'));
                    // Descripció és opcional, només validem si no està buida 
                    $descriptionValid = !preg_match(self::ALPHANUMERIC_OPTIONAL, $description);

                    if (!empty($description) && $descriptionValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_description']); // [cite: 33]
                    }
                    break;

                case 'category':
                    // Assumim que la categoria es recull com un ID de categoria vàlid de categories.txt
                    $category = trim(filter_input(INPUT_POST, 'category'));
                    // La categoria és opcional. Si es selecciona, hauria de ser numèrica.
                    if (!empty($category)) {
                        // Podem reutilitzar la validació d'enter si és l'ID de la categoria
                        $categoryValid = !preg_match(self::INTEGER_POSITIVE, $category);
                        if ($categoryValid == FALSE) {
                             // Aquí podríem afegir un missatge d'error específic si calgués
                        }
                    } else {
                        // Si és opcional, no cal error si està buit, només s'assigna NULL
                    }
                    break;
            }
        }

        // Retornem l'objecte Product amb les dades filtrades
        $product = new Product($id, $name, $price, $description, $category);

        return $product;
    }

}
?>