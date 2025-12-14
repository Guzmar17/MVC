<?php
class ProductFormValidation{

    const ADD_FIELDS = array('id', 'name', 'price', 'description', 'category'); 
    const MODIFY_FIELDS = array('id', 'name', 'price', 'description', 'category'); 
    const DELETE_FIELDS = array('id');
    const SEARCH_FIELDS = array('id'); 

   
    const INTEGER_POSITIVE = "/[^0-9]/"; 
    const ALPHABETIC = "/[^a-z A-Z]/";
    const DECIMAL_POSITIVE = "/^(\d+\.\d+|\d+)$/"; 

    const ALPHANUMERIC_OPTIONAL = "/[^a-z A-Z 0-9 ,.;\(\)\-]/i";

    public static function checkData($fields) {
        $id = NULL;
        $name = NULL;
        $price = NULL;
        $description = NULL;
        $category = NULL;

     
        if (!isset($_SESSION['error'])) {
            $_SESSION['error'] = array();
        }

        foreach ($fields as $field) {
            switch ($field) {
                case 'id':
                    $id = trim(filter_input(INPUT_POST, 'id'));
                    $idValid = !preg_match(self::INTEGER_POSITIVE, $id);

                    if (empty($id)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_id']); 
                    } else if ($idValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_id']); 
                    }
                    break;

                case 'name':
                    $name = trim(filter_input(INPUT_POST, 'name'));
                  
                    $nameValid = !preg_match(self::ALPHABETIC, $name);

                    if (empty($name)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_name']);
                    } else if ($nameValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_name']); 
                    }
                    break;

                case 'price':
                    $price = trim(filter_input(INPUT_POST, 'price'));
                    
                    $priceValid = preg_match(self::DECIMAL_POSITIVE, $price) && $price > 0;

                    if (empty($price)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_price']); 
                    } else if ($priceValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_price']); 
                    }
                    break;

                case 'description':
                    $description = trim(filter_input(INPUT_POST, 'description'));
               
                    $descriptionValid = !preg_match(self::ALPHANUMERIC_OPTIONAL, $description);

                    if (!empty($description) && $descriptionValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_description']); 
                    }
                    break;

                case 'category':
                   
                    $category = trim(filter_input(INPUT_POST, 'category'));
                   
                    if (!empty($category)) {
                       
                        $categoryValid = !preg_match(self::INTEGER_POSITIVE, $category);
                    break;
            }
        }

     
        $product = new Product($id, $name, $price, $description, $category);

        return $product;
    }

}
?>