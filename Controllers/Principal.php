<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;

class Principal extends Controller
{
    protected $query;
    protected $views;
    
    public function __construct() {
        parent::__construct();
        $this->views = new Views();
        session_start();
    }
    
    public function index()
    {
        if ($this->model === null) {
            die('Error: No se pudo cargar el modelo');
        }
        
        $data['title'] = 'Inicio';
        $data['categorias'] = $this->model->getCategorias();
        $data['productos_destacados'] = $this->model->getProductosDestacados();
        $this->views->getView('principal', "index", $data);
    }
    
    public function shop()
    {
        $data['title'] = 'Tienda';
        $data['productos'] = $this->model->getProductos();
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('principal', "shop", $data);
    }
    
    public function about()
    {
        $data['title'] = 'Sobre Nosotros';
        $this->views->getView('principal', "about", $data);
    }
    
    public function contact()
    {
        $data['title'] = 'Contacto';
        $this->views->getView('principal', "contact", $data);
    }
}