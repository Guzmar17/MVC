<?php

class ProductMessage {

    const INF_FORM =
        array(
            'insert' => 'Product data inserted successfully',
            'update' => 'Product data updated successfully',
            'delete' => 'Product data deleted successfully',
            'found'  => 'Product data found',
            '' => ''
        );

    const ERR_FORM =
        array(
            'empty_id'          => 'Id must be filled',
            'empty_name'        => 'Name must be filled',
            'empty_price'       => 'Price must be filled',
            'invalid_id'        => 'Id must be a positive integer', 
            'invalid_name'      => 'Name must be alphabetic',
            'invalid_price'     => 'Price must be a positive number with decimals', 
            'invalid_description' => 'Description must be alphanumeric',
            'exists_id'         => 'Id already exists in products.txt', 
            'not_exists_id'     => 'Id not exists in products.txt', 
            'not_found'         => 'No product data found',
            '' => ''
        );

    const ERR_DAO =
        array(
            'insert' => 'Error inserting product data',
            'update' => 'Error updating product data',
            'delete' => 'Error deleting product data',
            'used'   => 'Product not deleted, in use elsewhere',
            '' => ''
        );

}
?>