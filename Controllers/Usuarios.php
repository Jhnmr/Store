<?php
namespace Controllers;
use Config\Query;
use Models\UsuariosModel;
use App\Controller;
use Config\Helpers;

class Usuarios extends Controller
{
    private $helpers;
    
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 1) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->helpers = new Helpers();
    }

    public function index()
    {
        $data['title'] = 'Usuarios';
        $data['roles'] = $this->model->getRoles();
        $this->views->getView('usuarios', 'index', $data);
    }

    public function listar()
    {
        $data = $this->model->getUsuarios();
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
            }
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="editarUsuario('.$data[$i]['id'].')"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="eliminarUsuario('.$data[$i]['id'].')"><i class="fas fa-trash"></i></button>
            </div>';
        }
        echo json_encode($data);
        die();
    }

    public function guardar()
    {
        $id = $this->helpers->strClean($_POST['id']);
        $nombre = $this->helpers->strClean($_POST['nombre']);
        $email = $this->helpers->strClean($_POST['email']);
        $rol = $this->helpers->strClean($_POST['rol']);
        $clave = $this->helpers->strClean($_POST['clave']);

        if (empty($nombre) || empty($email) || empty($rol)) {
            $res = array('msg' => 'Todos los campos son obligatorios', 'type' => 'warning');
        } else {
            if (empty($id)) {
                if (empty($clave)) {
                    $res = array('msg' => 'La contraseña es requerida', 'type' => 'warning');
                } else {
                    $hash = password_hash($clave, PASSWORD_DEFAULT);
                    $data = $this->model->registrarUsuario($nombre, $email, $hash, $rol);
                    if ($data > 0) {
                        $res = array('msg' => 'Usuario registrado', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'Error al registrar', 'type' => 'error');
                    }
                }
            } else {
                $data = $this->model->modificarUsuario($nombre, $email, $rol, $id);
                if ($data == 1) {
                    $res = array('msg' => 'Usuario modificado', 'type' => 'success');
                } else {
                    $res = array('msg' => 'Error al modificar', 'type' => 'error');
                }
            }
        }
        echo json_encode($res);
        die();
    }
} 