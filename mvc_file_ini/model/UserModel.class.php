<?php
// File
require_once "model/persist/UserFileDAO.class.php";
require_once "model/UserDbDAO.class.php";

class UserModel {

    private $dataUser;

    public function __construct() {
        // File
        $this->dataUser=UserFileDAO::getInstance();        
    }

    public function add($user):bool {
        return $this->dataUser->add($user);
    }

    public function modify($user):bool {
        return $this->dataUser->modify($user);
    }

    public function delete($username) {
        return $this->dataUser->delete($username);
    }    
    
    public function searchByUser($user):bool {
        return $this->dataUser->searchByUser($user);
    }

    public function searchByUsername($username) {
        $result=$this->dataUser->searchByUsername($username);
        
        return $result;
    }

    public function listAll():array {
        return $this->dataUser->listAll();
    }
    
}
