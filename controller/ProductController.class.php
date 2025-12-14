<?php
require_once "controller/ControllerInterface.php";

require_once "view/ProductView.class.php";
require_once "model/ProductModel.class.php";
require_once "model/Product.class.php";
require_once "util/ProductMessage.class.php";
require_once "util/ProductFormValidation.class.php";

class ProductController implements ControllerInterface {

    private $view;
    private $model;

    public function __construct() {
        
        $this->view = new ProductView();
       
        $this->model = new ProductModel();
    }


    public function processRequest() {
        $request = NULL;
        
        $_SESSION['info'] = array();
        $_SESSION['error'] = array();

        
        if (filter_has_var(INPUT_POST, 'action')) {
            $request = filter_has_var(INPUT_POST, 'action') ? filter_input(INPUT_POST, 'action') : NULL;
        } else {
            $request = filter_has_var(INPUT_GET, 'option') ? filter_input(INPUT_GET, 'option') : NULL;
        }

        switch ($request) {
            case "form_add":
                $this->formAdd();
                break;
            case "add":
                $this->add();
                break;
            case "list_all":
                $this->listAll();
                break;
            case "form_smoddel":
                $this->formSModDel();
                break;
            case "search":
                $this->searchById();
                break;
            case "modify":
                $this->modify();
                break;
            case "delete":
                $this->delete();
                break;
            default:
                
                $this->view->display();
        }
    }

   

    
    public function formAdd() {
        
        $this->view->display("view/form/ProductFormAdd.php"); 
    }

    
    public function formSModDel() {
        $this->view->display("view/form/ProductFormSModDel.php");
    }




    public function add() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::ADD_FIELDS);

      
        if (empty($_SESSION['error'])) {
          
            $product = $this->model->searchById($productValid->getId());

            if (is_null($product)) {
                
                $result = $this->model->add($productValid);

                if ($result == TRUE) {
                    $_SESSION['info'] = ProductMessage::INF_FORM['insert'];
                    $productValid = NULL; 
                }
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['exists_id']; 
            }
        }

        
        $this->view->display("view/form/ProductFormAdd.php", $productValid);
    }

   
    public function searchById() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::SEARCH_FIELDS);

        if (empty($_SESSION['error'])) {
         
            $product = $this->model->searchById($productValid->getId());

            if (!is_null($product)) {
                $_SESSION['info'] = ProductMessage::INF_FORM['found'];
                $productValid = $product; 
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['not_found'];
            }
        }

        
        $this->view->display("view/form/ProductFormSModDel.php", $productValid);
    }

   
    public function modify() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::MODIFY_FIELDS);

        if (empty($_SESSION['error'])) {
           
            $product = $this->model->searchById($productValid->getId());

            if (!is_null($product)) {
                $result = $this->model->modify($productValid);

                if ($result == TRUE) {
                    $_SESSION['info'] = ProductMessage::INF_FORM['update'];
                    
                }
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['not_exists_id']; 
            }
        }

      
        $this->view->display("view/form/ProductFormSModDel.php", $productValid);
    }

   
    public function delete() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::DELETE_FIELDS);

        if (empty($_SESSION['error'])) {
            
            $product = $this->model->searchById($productValid->getId());

            if (!is_null($product)) {
                $result = $this->model->delete($productValid->getId());

                if ($result == TRUE) {
                    $_SESSION['info'] = ProductMessage::INF_FORM['delete'];
                    $productValid = NULL; 
                }
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['not_exists_id']; 
            }
        }

        
        $this->view->display("view/form/ProductFormSModDel.php", $productValid);
    }

   
    public function listAll() {
        $products = $this->model->listAll(); 

        if (!empty($products)) {
            $_SESSION['info'] = ProductMessage::INF_FORM['found']; 
        } else {
            $_SESSION['error'] = ProductMessage::ERR_FORM['not_found'];
        }

        $this->view->display("view/form/ProductList.php", $products);
    }
}
?>