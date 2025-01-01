<?php
namespace App;

class Middleware {
    private $session;
    
    public function __construct() {
        $this->session = new Session();
    }
    
    public function authMiddleware() {
        if (!$this->session->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }
    
    public function adminMiddleware() {
        if (!$this->session->isLoggedIn() || $this->session->get('rol_usuario') != 1) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
} 