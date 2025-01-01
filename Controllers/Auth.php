<?php
namespace Controllers;

use App\Controller;
use App\Views;
use Config\Query;
use Models\UsuariosModel;

class Auth extends Controller
{
    protected $query;
    protected $views;
    protected $model;
    
    public function __construct()
    {
        parent::__construct();
        $this->views = new Views();
        $this->query = new Query();
        $this->model = new UsuariosModel();
        session_start();
    }
    
    public function index()
    {
        if (isset($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        header('Content-Type: text/html');
        $data['title'] = 'Iniciar Sesión';
        $this->views->getView('auth', "login", $data);
    }

    public function validar()
    {
        if (isset($_POST['email']) && isset($_POST['clave'])) {
            $email = $_POST['email'];
            $clave = $_POST['clave'];
            $data = $this->model->validarLogin($email);
            
            if ($data) {
                if (password_verify($clave, $data['clave'])) {
                    $_SESSION['id_usuario'] = $data['id'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['nombre'] = $data['nombres'];
                    $_SESSION['id_rol'] = $data['id_rol'];
                    
                    $res = array(
                        'icono' => 'success',
                        'titulo' => 'Bienvenido',
                        'mensaje' => 'Inicio de sesión exitoso'
                    );
                } else {
                    $res = array(
                        'icono' => 'error',
                        'titulo' => 'Error',
                        'mensaje' => 'Contraseña incorrecta'
                    );
                }
            } else {
                $res = array(
                    'icono' => 'error',
                    'titulo' => 'Error',
                    'mensaje' => 'El email no existe'
                );
            }
            echo json_encode($res);
            die();
        }
    }

    public function register()
    {
        $data['title'] = 'Crear Cuenta';
        $this->views->getView('auth', 'register', $data);
    }

    public function registrar()
    {
        ob_clean();
        header('Content-Type: application/json');
        
        try {
            $datos = [
                'nombres' => $_POST['nombres'],
                'apellidos' => $_POST['apellidos'],
                'email' => $_POST['email'],
                'clave' => $_POST['clave'],
                'id_rol' => 2, // Cliente por defecto
                'estado' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];
            
            if ($this->model->registrarCliente($datos)) {
                echo json_encode([
                    'status' => true,
                    'msg' => 'Cuenta creada correctamente',
                    'redirect' => BASE_URL . 'auth'
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'msg' => 'El correo ya existe'
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => false,
                'msg' => 'Error al crear la cuenta'
            ]);
        }
        exit;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }

    public function registro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        header('Content-Type: application/json');

        try {
            if (empty($_POST['nombre']) || empty($_POST['apellidos']) || 
                empty($_POST['correo']) || empty($_POST['clave'])) {
                throw new \Exception('Todos los campos son obligatorios');
            }

            // Debug
            error_log("Datos de registro recibidos - Email: " . $_POST['correo']);
            
            $clave_hash = password_hash($_POST['clave'], PASSWORD_DEFAULT);
            error_log("Hash generado: " . $clave_hash);

            $datos = [
                'nombres' => trim($_POST['nombre']),
                'apellidos' => trim($_POST['apellidos']),
                'email' => trim($_POST['correo']),
                'clave' => $clave_hash,
                'id_rol' => 2,
                'estado' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];

            $resultado = $this->model->registrarCliente($datos);
            
            if ($resultado['status']) {
                echo json_encode([
                    'type' => 'success',
                    'msg' => 'Cuenta creada correctamente'
                ]);
            } else {
                echo json_encode([
                    'type' => 'error',
                    'msg' => $resultado['msg']
                ]);
            }

        } catch (\Exception $e) {
            error_log("Error en registro: " . $e->getMessage());
            echo json_encode([
                'type' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        header('Content-Type: application/json');

        try {
            if (empty($_POST['email']) || empty($_POST['clave'])) {
                throw new \Exception('Todos los campos son obligatorios');
            }

            $email = trim($_POST['email']);
            $clave = trim($_POST['clave']);

            error_log("Intento de login - Email: " . $email);

            $usuario = $this->model->validarLogin($email);
            
            if ($usuario) {
                error_log("Hash almacenado: " . $usuario['clave']);
                error_log("Clave proporcionada: " . $clave);
                
                if (password_verify($clave, $usuario['clave'])) {
                    error_log("Verificación de contraseña exitosa");
                    $_SESSION['id_usuario'] = $usuario['id'];
                    $_SESSION['nombre_usuario'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
                    $_SESSION['email_usuario'] = $usuario['email'];
                    $_SESSION['rol_usuario'] = $usuario['id_rol'];

                    echo json_encode([
                        'type' => 'success',
                        'msg' => 'Login exitoso'
                    ]);
                } else {
                    error_log("Verificación de contraseña fallida");
                    echo json_encode([
                        'type' => 'error',
                        'msg' => 'Datos incorrectos'
                    ]);
                }
            } else {
                error_log("Usuario no encontrado");
                echo json_encode([
                    'type' => 'error',
                    'msg' => 'Datos incorrectos'
                ]);
            }

        } catch (\Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            echo json_encode([
                'type' => 'error',
                'msg' => 'Error en el servidor'
            ]);
        }
        exit;
    }
} 