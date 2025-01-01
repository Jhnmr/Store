<?php
namespace Controllers;
use App\Controller;

class Errors extends Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['title'] = 'Página no encontrada';
        $this->views->getView('Template_Principal', 'header', $data);
        $this->views->getView('Principal', 'error', $data);
        $this->views->getView('Template_Principal', 'footer', $data);
    }
}