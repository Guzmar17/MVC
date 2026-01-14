<?php
require_once "model/persist/ConnectFile.class.php";

class UserFileDAO {

    private static $instance=NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE="model/resource/users.txt";    
    
    public function __construct() {
        $this->connect=new ConnectFile(self::FILE);
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    public static function getInstance():UserFileDAO {
        if (is_null(self::$instance)) {
            self::$instance=new self();
        }
        return self::$instance;
    }
    
    public function searchByUsername($username) {
        $user=NULL;

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    
                    if (is_numeric(strpos(strtolower($fields[0]), strtolower($username)))) {
                        $user=new User($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                        break;
                    }      
                }
            }
            $this->connect->closeFile();
        }

        return $user;
    }

    public function add($user): bool {
        if ($this->connect->openFile("a")) {
            $line = $user->getUsername() . ";" . $user->getPassword() . ";" . $user->getAge() . ";" . $user->getRole() . ";" . $user->getActive() . "\n";
            fwrite($this->connect->getHandle(), $line);
            $this->connect->closeFile();
            return true;
        }
        return false;
    }

    public function modify($user): bool {
        $users = $this->listAll();
        $found = false;
        foreach ($users as $key => $u) {
            if (strtolower($u->getUsername()) == strtolower($user->getUsername())) {
                $users[$key] = $user;
                $found = true;
                break;
            }
        }
        if ($found) {
            return $this->writeAll($users);
        }
        return false;
    }

    public function delete($username): bool {
        $users = $this->listAll();
        $newUsers = [];
        $found = false;
        foreach ($users as $u) {
            if (strtolower($u->getUsername()) != strtolower($username)) {
                $newUsers[] = $u;
            } else {
                $found = true;
            }
        }
        if ($found) {
            return $this->writeAll($newUsers);
        }
        return false;
    }

    public function searchByUser($user): bool {
        $foundUser = $this->searchByUsername($user->getUsername());
        if ($foundUser && $foundUser->getPassword() == $user->getPassword()) {
            return true;
        }
        return false;
    }

    public function listAll(): array {
        $users = [];
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    $users[] = new User($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                }
            }
            $this->connect->closeFile();
        }
        return $users;
    }

    private function writeAll($users): bool {
        if ($this->connect->openFile("w")) {
            foreach ($users as $user) {
                $line = $user->getUsername() . ";" . $user->getPassword() . ";" . $user->getAge() . ";" . $user->getRole() . ";" . $user->getActive() . "\n";
                fwrite($this->connect->getHandle(), $line);
            }
            $this->connect->closeFile();
            return true;
        }
        return false;
    }
        
}
