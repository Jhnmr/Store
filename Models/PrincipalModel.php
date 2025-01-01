<?php
namespace Models;
use Config\Query;

class PrincipalModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $result = $this->selectAll($sql);
        return $result ? $result : [];
    }

    public function getProductos()
    {
        $sql = "SELECT p.*, c.nombre as categoria FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                WHERE p.estado = 1";
        return $this->selectAll($sql);
    }

    public function getProductosDestacados()
    {
        $sql = "SELECT p.*, c.nombre as categoria FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                WHERE p.estado = 1 AND p.destacado = 1 LIMIT 8";
        $result = $this->selectAll($sql);
        return $result ? $result : [];
    }

    public function getProducto($id)
    {
        $sql = "SELECT p.*, c.nombre as categoria FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                WHERE p.id = $id AND p.estado = 1";
        return $this->select($sql);
    }

    public function getProductosRelacionados($categoria_id)
    {
        $sql = "SELECT p.*, c.nombre as categoria FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                WHERE p.id_categoria = $categoria_id AND p.estado = 1 LIMIT 4";
        return $this->selectAll($sql);
    }

    public function getCategoria($id)
    {
        $sql = "SELECT * FROM categorias WHERE id = $id AND estado = 1";
        return $this->select($sql);
    }

    public function getProductosCategoria($categoria_id)
    {
        $sql = "SELECT p.*, c.nombre as categoria FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                WHERE p.id_categoria = $categoria_id AND p.estado = 1";
        return $this->selectAll($sql);
    }
} 