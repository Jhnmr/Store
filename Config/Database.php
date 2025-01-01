<?php
namespace Config;

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'tienda';
    private $charset = 'utf8';

    public function conectar()
    {
        try {
            $conexion = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES => false
            ];
            return new \PDO($conexion, $this->user, $this->password, $options);
        } catch (\PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
            exit;
        }
    }
}