<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;
use Config\Helpers;

class Categorias extends Controller
{
    protected $query;
    protected $views;
    private $helpers;
    
    public function __construct() {
        parent::__construct();
        $this->views = new Views();
        $this->query = new Query();
        session_start();
        if (empty($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 1) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->helpers = new Helpers();
    }
    
    public function index()
    {
        $data['title'] = 'Categorías';
        $this->views->getView('categorias', 'index', $data);
    }

    public function listar()
    {
        $data = $this->model->getCategorias();
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="editarCategoria('.$data[$i]['id'].')"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="eliminarCategoria('.$data[$i]['id'].')"><i class="fas fa-trash"></i></button>
            </div>';
        }
        echo json_encode($data);
        die();
    }

    public function guardar()
    {
        $id = $this->helpers->strClean($_POST['id']);
        $nombre = $this->helpers->strClean($_POST['nombre']);

        if (empty($nombre)) {
            $res = array('msg' => 'El nombre es requerido', 'type' => 'warning');
        } else {
            if (empty($id)) {
                $data = $this->model->registrarCategoria($nombre);
                if ($data > 0) {
                    $res = array('msg' => 'Categoría registrada', 'type' => 'success');
                } else {
                    $res = array('msg' => 'Error al registrar', 'type' => 'error');
                }
            } else {
                $data = $this->model->modificarCategoria($nombre, $id);
                if ($data == 1) {
                    $res = array('msg' => 'Categoría modificada', 'type' => 'success');
                } else {
                    $res = array('msg' => 'Error al modificar', 'type' => 'error');
                }
            }
        }
        echo json_encode($res);
        die();
    }

    public function eliminar($id)
    {
        if (empty($id)) {
            $res = array('msg' => 'Error de parámetros', 'type' => 'error');
        } else {
            $data = $this->model->eliminarCategoria($id);
            if ($data == 1) {
                $res = array('msg' => 'Categoría eliminada', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al eliminar', 'type' => 'error');
            }
        }
        echo json_encode($res);
        die();
    }
} 