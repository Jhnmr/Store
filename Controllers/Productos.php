<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;
use Config\Helpers;

class Productos extends Controller
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
        try {
            $data['title'] = 'Gestión de Productos';
            $data['productos'] = $this->query->selectAll("SELECT p.*, c.nombre as categoria 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                WHERE p.estado = 1");
            $data['categorias'] = $this->query->selectAll("SELECT * FROM categorias WHERE estado = 1");
            $this->views->getView('productos', "index", $data);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function listar()
    {
        $data = $this->model->getProductos();
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img src="'.BASE_URL.$data[$i]['imagen'].'" width="50">';
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="editarProducto('.$data[$i]['id'].')"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="eliminarProducto('.$data[$i]['id'].')"><i class="fas fa-trash"></i></button>
            </div>';
        }
        echo json_encode($data);
        die();
    }

    public function guardar()
    {
        $id = $this->helpers->strClean($_POST['id']);
        $nombre = $this->helpers->strClean($_POST['nombre']);
        $descripcion = $this->helpers->strClean($_POST['descripcion']);
        $precio = $this->helpers->strClean($_POST['precio']);
        $cantidad = $this->helpers->strClean($_POST['cantidad']);
        $categoria = $this->helpers->strClean($_POST['categoria']);
        
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];

        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($cantidad) || empty($categoria)) {
            $res = array('msg' => 'Todos los campos son obligatorios', 'type' => 'warning');
        } else {
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos =  array('png', 'jpeg', 'jpg');
                if (!in_array($extension, $formatos_permitidos)) {
                    $res = array('msg' => 'Archivo no permitido', 'type' => 'warning');
                } else {
                    $dir = "assets/images/productos/";
                    $fecha = date('YmdHis');
                    $filename = $fecha . ".jpg";
                    move_uploaded_file($tmpname, $dir . $filename);
                    if (empty($id)) {
                        $data = $this->model->registrarProducto($nombre, $descripcion, $precio, $cantidad, $categoria, $filename);
                        if ($data > 0) {
                            $res = array('msg' => 'Producto registrado', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'Error al registrar', 'type' => 'error');
                        }
                    } else {
                        $data = $this->model->modificarProducto($nombre, $descripcion, $precio, $cantidad, $categoria, $filename, $id);
                        if ($data == 1) {
                            $res = array('msg' => 'Producto modificado', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'Error al modificar', 'type' => 'error');
                        }
                    }
                }
            } else {
                if (empty($id)) {
                    $res = array('msg' => 'La imagen es requerida', 'type' => 'warning');
                } else {
                    $data = $this->model->modificarProducto($nombre, $descripcion, $precio, $cantidad, $categoria, '', $id);
                    if ($data == 1) {
                        $res = array('msg' => 'Producto modificado', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'Error al modificar', 'type' => 'error');
                    }
                }
            }
        }
        echo json_encode($res);
        die();
    }
} 