<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;

class Perfil extends Controller
{
    protected $views;
    protected $query;
    
    public function __construct() {
        parent::__construct();
        $this->views = new Views();
        $this->query = new Query();
        
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }
    
    public function index()
    {
        $data['title'] = 'Mi Perfil';
        $data['usuario'] = $this->query->select("SELECT * FROM usuarios WHERE id = " . $_SESSION['id_usuario']);
        $this->views->getView('perfil', "index", $data);
    }
    
    public function actualizar()
    {
        if (isset($_POST)) {
            $id = $_SESSION['id_usuario'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $clave = $_POST['clave'];
            
            if (empty($clave)) {
                $sql = "UPDATE usuarios SET nombres = ?, email = ? WHERE id = ?";
                $data = [$nombre, $correo, $id];
            } else {
                $sql = "UPDATE usuarios SET nombres = ?, email = ?, clave = ? WHERE id = ?";
                $data = [$nombre, $correo, password_hash($clave, PASSWORD_DEFAULT), $id];
            }
            
            $respuesta = $this->query->save($sql, $data);
            
            if ($respuesta) {
                $_SESSION['nombre_usuario'] = $nombre;
                $_SESSION['correo_usuario'] = $correo;
                $res = array('msg' => 'Perfil actualizado con éxito', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al actualizar el perfil', 'type' => 'error');
            }
            
            echo json_encode($res);
            die();
        }
    }
    
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['id_usuario'];
            
            $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
            $respuesta = $this->query->save($sql, [0, $id]);
            
            if ($respuesta) {
                session_destroy();
                $res = array('msg' => 'Cuenta eliminada correctamente', 'type' => 'success', 'url' => BASE_URL);
            } else {
                $res = array('msg' => 'Error al eliminar la cuenta', 'type' => 'error');
            }
            
            echo json_encode($res);
            die();
        }
    }
}
