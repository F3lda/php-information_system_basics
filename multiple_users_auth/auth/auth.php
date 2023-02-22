<?php

class Auth {
    
    private $database = null;
    
    
    
    public function __construct($database)
    {
        $this->database = $database;
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = "";
            $_SESSION['user_name'] = "";
            $_SESSION['user_type'] = "";
        }
    }
    
    public function login($username, $password)
    {
        $data = $this->database->fetch("SELECT id, username, password, type FROM users WHERE username = :username AND type != 'removed' LIMIT 1", ['username' => $username]);
        if ($this->database->lastError() !== 'OK') {
            return 'SQL ERROR: ' . $this->database->lasterror();
        }
        
        if (isset($data['password'])) {
            if (password_verify($password, $data['password'])) {
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['user_name'] = $data['username'];
                $_SESSION['user_type'] = $data['type'];
            } else {
                $_SESSION['user_id'] = "";
                $_SESSION['user_name'] = "";
                $_SESSION['user_type'] = "";
            }
        } else {
            $_SESSION['user_id'] = "";
            $_SESSION['user_name'] = "";
            $_SESSION['user_type'] = "";
        }
        
        return $this->is_logged_in();
    }

    public function logout()
    {
        $_SESSION['user_id'] = "";
        $_SESSION['user_name'] = "";
        $_SESSION['user_type'] = "";
        
        //session_destroy();
    }
    
    public function is_logged_in()
    {
        if (!empty($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }
    
    public function get_logged_in()
    {
        return ['user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name'], 'user_type' => $_SESSION['user_type']];
    }
    
}

?>
