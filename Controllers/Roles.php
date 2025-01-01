<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;

class Roles extends Controller
{
    protected $query;
    protected $views;
    
    public function __construct() {
        parent::__construct();
        $this->views = new Views();
        $this->query = new Query();
        
        // Verificar si es administrador
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }
    
    public function index()
    {
        try {
            $data['title'] = 'Gestión de Roles';
            $data['roles'] = $this->query->selectAll("SELECT * FROM roles WHERE estado = 1");
            $this->views->getView('roles', "index", $data);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $permisos = 'limited'; // Por defecto
            
            if ($nombre == '') {
                $res = array('msg' => 'El nombre es requerido', 'type' => 'error');
                echo json_encode($res);
                die();
            }
            
            $data = [
                'nombre' => $nombre,
                'permisos' => $permisos,
                'estado' => 1
            ];
            
            $respuesta = $this->query->insert('roles', $data);
            
            if ($respuesta > 0) {
                $res = array('msg' => 'Rol registrado correctamente', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al registrar el rol', 'type' => 'error');
            }
            
            echo json_encode($res);
            die();
        }
    }
    
    public function eliminar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($id == 1 || $id == 2) {
                $res = array('msg' => 'No se pueden eliminar los roles básicos', 'type' => 'error');
                echo json_encode($res);
                die();
            }
            
            $data = ['estado' => 0];
            $respuesta = $this->query->update('roles', $data, $id);
            
            if ($respuesta) {
                $res = array('msg' => 'Rol eliminado correctamente', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al eliminar el rol', 'type' => 'error');
            }
            
            echo json_encode($res);
            die();
        }
    }
} 