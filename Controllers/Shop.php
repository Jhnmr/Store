<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;

class Shop extends Controller
{
    protected $query;
    protected $views;
    
    public function __construct()
    {
        parent::__construct();
        $this->views = new Views();
        $this->query = new Query();
        session_start();
    }
    
    public function index()
    {
        $data['title'] = 'Tienda';
        $data['productos'] = $this->model->getProductos();
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('shop', 'index', $data);
    }
    
    public function categoria($id_categoria)
    {
        $data['categoria'] = $this->query->select("SELECT * FROM categorias WHERE id = ? AND estado = 1", [$id_categoria]);
        if (empty($data['categoria'])) {
            header('Location: ' . BASE_URL . 'shop');
            exit;
        }
        
        $data['title'] = 'Categoría: ' . $data['categoria']['nombre'];
        $data['productos'] = $this->query->selectAll("SELECT p.*, c.nombre as categoria 
            FROM productos p 
            INNER JOIN categorias c ON p.id_categoria = c.id 
            WHERE p.estado = 1 AND p.id_categoria = ?
            ORDER BY p.id DESC", [$id_categoria]);
            
        $data['categorias'] = $this->query->selectAll("SELECT * FROM categorias WHERE estado = 1");
        $this->views->getView('principal', "shop", $data);
    }
    
    public function producto($id_producto)
    {
        $data['producto'] = $this->query->select("SELECT p.*, c.nombre as categoria 
            FROM productos p 
            INNER JOIN categorias c ON p.id_categoria = c.id 
            WHERE p.id = ? AND p.estado = 1", [$id_producto]);
            
        if (empty($data['producto'])) {
            header('Location: ' . BASE_URL . 'shop');
            exit;
        }
        
        $data['title'] = $data['producto']['nombre'];
        
        // Productos relacionados de la misma categoría
        $data['relacionados'] = $this->query->selectAll("SELECT * FROM productos 
            WHERE estado = 1 
            AND id_categoria = ? 
            AND id != ? 
            ORDER BY RAND() 
            LIMIT 4", 
            [$data['producto']['id_categoria'], $id_producto]
        );
        
        $this->views->getView('principal', "producto", $data);
    }
} 