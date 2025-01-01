<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;
use Config\Helpers;

class Pedidos extends Controller
{
    protected $query;
    protected $views;
    private $helpers;
    
    public function __construct() {
        parent::__construct();
        $this->views = new Views();
        $this->query = new Query();
        session_start();
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->helpers = new Helpers();
    }
    
    public function index()
    {
        if ($_SESSION['rol_usuario'] != 1) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $data['title'] = 'Pedidos';
        $this->views->getView('pedidos', 'index', $data);
    }
    
    public function listar()
    {
        $data = $this->model->getPedidos();
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-warning">Pendiente</span>';
            } else if ($data[$i]['estado'] == 2) {
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Cancelado</span>';
            }
            
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-info" type="button" onclick="verPedido('.$data[$i]['id'].')"><i class="fas fa-eye"></i></button>
                <div class="btn-group">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Estado
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" onclick="cambiarEstado('.$data[$i]['id'].', 1)">Pendiente</a></li>
                        <li><a class="dropdown-item" onclick="cambiarEstado('.$data[$i]['id'].', 2)">Completado</a></li>
                        <li><a class="dropdown-item" onclick="cambiarEstado('.$data[$i]['id'].', 3)">Cancelado</a></li>
                    </ul>
                </div>
            </div>';
        }
        echo json_encode($data);
        die();
    }
    
    public function ver($id)
    {
        $data['title'] = 'Detalles del Pedido';
        $data['pedido'] = $this->model->getPedido($id);
        $data['productos'] = $this->model->getDetallePedido($id);
        $this->views->getView('pedidos', 'ver', $data);
    }
    
    public function cambiarEstado()
    {
        $id = $this->helpers->strClean($_POST['id']);
        $estado = $this->helpers->strClean($_POST['estado']);
        
        if (empty($id) || empty($estado)) {
            $res = array('msg' => 'Error de parámetros', 'type' => 'error');
        } else {
            $data = $this->model->actualizarEstado($estado, $id);
            if ($data == 1) {
                $res = array('msg' => 'Estado actualizado', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al actualizar', 'type' => 'error');
            }
        }
        echo json_encode($res);
        die();
    }
} 