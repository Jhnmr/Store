<?php
namespace Models;
use Config\Query;

class AdminModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProductos()
    {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE estado = 1";
        return $this->select($sql);
    }

    public function getVentas()
    {
        $sql = "SELECT COUNT(*) as total FROM ventas WHERE estado = 1";
        return $this->select($sql);
    }

    public function getPedidos()
    {
        $sql = "SELECT COUNT(*) as total FROM pedidos WHERE estado = 1";
        return $this->select($sql);
    }

    public function getTotalCategorias()
    {
        $sql = "SELECT COUNT(*) as total_categorias FROM categorias WHERE estado = 1";
        return $this->select($sql);
    }

    public function getPedidosMes()
    {
        $sql = "SELECT COUNT(*) as pedidos_mes FROM pedidos 
                WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha) = YEAR(CURRENT_DATE()) 
                AND estado = 1";
        return $this->select($sql);
    }

    public function getVentasMes()
    {
        $sql = "SELECT COALESCE(SUM(total), 0) as ventas_mes FROM ventas 
                WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha) = YEAR(CURRENT_DATE()) 
                AND estado = 1";
        return $this->select($sql);
    }
} 