<?php
namespace Models;
use Config\Query;

class UsuariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validarLogin($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        return $this->select($sql);
    }

    public function registrarCliente($datos)
    {
        $sql = "INSERT INTO usuarios (nombres, apellidos, email, clave, id_rol, estado, fecha_creacion) VALUES (?,?,?,?,?,?,?)";
        $array = array($datos['nombres'], $datos['apellidos'], $datos['email'], 
                      $datos['clave'], $datos['id_rol'], $datos['estado'], $datos['fecha_creacion']);
        return $this->insert($sql, $array);
    }
} 