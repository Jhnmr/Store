<?php
namespace Config;

class Query extends Database
{
    private $pdo, $con;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->con = $this->pdo->conectar();
    }

    public function select($sql, $data = [])
    {
        try {
            $stmt = $this->con->prepare($sql);
            $stmt->execute($data);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            error_log("Error en select: " . $e->getMessage());
            return false;
        }
    }

    public function selectAll($sql, $data = [])
    {
        try {
            $stmt = $this->con->prepare($sql);
            $stmt->execute($data);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            error_log("Error en selectAll: " . $e->getMessage());
            return false;
        }
    }

    public function save($sql, $data)
    {
        try {
            $stmt = $this->con->prepare($sql);
            $result = $stmt->execute($data);
            return $result;
        } catch (\PDOException $e) {
            error_log("Error en save: " . $e->getMessage());
            return false;
        }
    }

    public function insert($sql, $data)
    {
        try {
            $stmt = $this->con->prepare($sql);
            $stmt->execute($data);
            return $this->con->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Error en insert: " . $e->getMessage());
            return false;
        }
    }

    public function update($tabla, $data, $where)
    {
        try {
            $params = [];
            $setValues = [];
            
            foreach ($data as $key => $value) {
                $setValues[] = "$key = ?";
                $params[] = $value;
            }
            
            foreach ($where as $key => $value) {
                $params[] = $value;
            }
            
            $sql = "UPDATE $tabla SET " . implode(', ', $setValues) . " WHERE " . implode(' AND ', array_keys($where)) . " = ?";
            
            $stmt = $this->con->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }

    public function countRows($sql, $data = [])
    {
        try {
            $stmt = $this->con->prepare($sql);
            $stmt->execute($data);
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en countRows: " . $e->getMessage());
            return 0;
        }
    }
} 