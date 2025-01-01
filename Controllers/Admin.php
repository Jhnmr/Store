<?php
namespace Controllers;
use Config\Query;
use App\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use \Exception;

class Admin extends Controller {
    protected $query;
    
    public function __construct() {
        parent::__construct();
        session_start();
        
        // Debug de sesión
        error_log('Datos de sesión: ' . print_r($_SESSION, true));
        error_log('ID de usuario: ' . ($_SESSION['id_usuario'] ?? 'no definido'));
        error_log('Rol de usuario: ' . ($_SESSION['id_rol'] ?? 'no definido'));
        
        // Verificar si el usuario está logueado
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }

        // Verificar si es administrador (rol 1)
        if ($_SESSION['id_rol'] != 1) {
            // Agregar mensaje de error en la sesión
            $_SESSION['error'] = 'Acceso denegado. Se requieren permisos de administrador.';
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        $this->loadModel('Admin');
        $this->query = new Query();
    }

    public function index()
    {
        $data['title'] = 'Panel Administrativo';
        $data['productos'] = $this->model->getProductos();
        $data['ventas'] = $this->model->getVentas();
        $data['pedidos'] = $this->model->getPedidos();
        $data['total_categorias'] = $this->model->getTotalCategorias();
        $data['pedidos_mes'] = $this->model->getPedidosMes();
        $data['ventas_mes'] = $this->model->getVentasMes();
        $this->views->getView('admin', 'home', $data);
    }

    public function productos() {
        $data['title'] = 'Productos';
        $data['productos'] = $this->query->selectAll("SELECT p.*, c.nombre as categoria 
            FROM productos p 
            INNER JOIN categorias c 
            ON p.id_categoria = c.id 
            ORDER BY p.id DESC");
        $data['categorias'] = $this->query->selectAll("SELECT * FROM categorias");
        $this->views->getView('Admin', 'productos', $data);
    }

    public function categorias() {
        $data['title'] = 'Categorías';
        $data['categorias'] = $this->query->selectAll("SELECT * FROM categorias ORDER BY id DESC");
        $this->views->getView('Admin', 'categorias', $data);
    }

    public function registrarProducto() {
        if (isset($_POST)) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $cantidad = $_POST['stock'];
            $categoria = $_POST['categoria'];
            
            if (empty($nombre) || empty($precio) || empty($cantidad)) {
                $res = array('msg' => 'Todos los campos son obligatorios', 'type' => 'warning');
            } else {
                if (!empty($_FILES['imagen']['name'])) {
                    $imagen = $_FILES['imagen'];
                    $name = $imagen['name'];
                    $tmp = $imagen['tmp_name'];
                    
                    $permitidos = array('image/jpg', 'image/jpeg', 'image/png');
                    if (!in_array($imagen['type'], $permitidos)) {
                        $res = array('msg' => 'Tipo de archivo no permitido', 'type' => 'warning');
                        echo json_encode($res);
                        die();
                    }

                    $directorio = 'assets/img/productos/';
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }
                    
                    $fecha = date('YmdHis');
                    $imgNombre = $fecha . '.jpg';
                    $destino = $directorio . $imgNombre;
                }

                if (empty($id)) {
                    if (!empty($_FILES['imagen']['name'])) {
                        if (move_uploaded_file($tmp, $destino)) {
                            $data = array(
                                'nombre' => $nombre,
                                'descripcion' => $descripcion,
                                'precio' => $precio,
                                'stock' => $cantidad,
                                'imagen' => $imgNombre,
                                'id_categoria' => $categoria,
                                'estado' => 1
                            );
                            $query = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, id_categoria, estado) VALUES (:nombre, :descripcion, :precio, :stock, :imagen, :id_categoria, :estado)";
                        } else {
                            $res = array('msg' => 'Error al subir la imagen', 'type' => 'error');
                            echo json_encode($res);
                            die();
                        }
                    } else {
                        $data = array(
                            'nombre' => $nombre,
                            'descripcion' => $descripcion,
                            'precio' => $precio,
                            'stock' => $cantidad,
                            'id_categoria' => $categoria,
                            'estado' => 1
                        );
                        $query = "INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria, estado) VALUES (:nombre, :descripcion, :precio, :stock, :id_categoria, :estado)";
                    }
                    
                    $result = $this->query->save($query, $data);
                    if ($result) {
                        $res = array('msg' => 'Producto registrado correctamente', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'Error al registrar el producto', 'type' => 'error');
                    }
                } else {
                    if (!empty($_FILES['imagen']['name'])) {
                        if (move_uploaded_file($tmp, $destino)) {
                            $imgAnterior = $this->query->select("SELECT imagen FROM productos WHERE id = $id");
                            if (!empty($imgAnterior['imagen'])) {
                                if (file_exists($directorio . $imgAnterior['imagen'])) {
                                    unlink($directorio . $imgAnterior['imagen']);
                                }
                            }
                            
                            $data = array(
                                'nombre' => $nombre,
                                'descripcion' => $descripcion,
                                'precio' => $precio,
                                'stock' => $cantidad,
                                'imagen' => $imgNombre,
                                'id_categoria' => $categoria,
                                'id' => $id
                            );
                            $query = "UPDATE productos SET nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, imagen=:imagen, id_categoria=:id_categoria WHERE id=:id";
                        } else {
                            $res = array('msg' => 'Error al subir la imagen', 'type' => 'error');
                            echo json_encode($res);
                            die();
                        }
                    } else {
                        $data = array(
                            'nombre' => $nombre,
                            'descripcion' => $descripcion,
                            'precio' => $precio,
                            'stock' => $cantidad,
                            'id_categoria' => $categoria,
                            'id' => $id
                        );
                        $query = "UPDATE productos SET nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, id_categoria=:id_categoria WHERE id=:id";
                    }
                    
                    $result = $this->query->save($query, $data);
                    if ($result) {
                        $res = array('msg' => 'Producto modificado correctamente', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'Error al modificar el producto', 'type' => 'error');
                    }
                }
            }
            echo json_encode($res);
            die();
        }
    }

    public function eliminarProducto($id) {
        if (is_numeric($id)) {
            try {
                // Primero obtenemos la información del producto para la imagen
                $producto = $this->query->select("SELECT imagen FROM productos WHERE id = $id");
                
                // Eliminamos el registro de la base de datos
                $query = "DELETE FROM productos WHERE id = :id";
                $data = array('id' => $id);
                $result = $this->query->save($query, $data);

                if ($result) {
                    // Si hay una imagen, la eliminamos del servidor
                    if (!empty($producto['imagen'])) {
                        $rutaImagen = 'assets/img/productos/' . $producto['imagen'];
                        if (file_exists($rutaImagen)) {
                            unlink($rutaImagen);
                        }
                    }
                    $res = array('msg' => 'Producto eliminado correctamente', 'type' => 'success');
                } else {
                    $res = array('msg' => 'Error al eliminar el producto', 'type' => 'error');
                }
            } catch (\Exception $e) {
                $res = array('msg' => 'Error: ' . $e->getMessage(), 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ID no válido', 'type' => 'error');
        }
        
        echo json_encode($res);
        die();
    }

    public function editProducto($id) {
        if (is_numeric($id)) {
            $data = $this->query->select("SELECT * FROM productos WHERE id = $id");
            echo json_encode($data);
        }
        die();
    }

    public function registrarCategoria() {
        if (isset($_POST)) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            
            if (empty($nombre)) {
                $res = array('msg' => 'El nombre es requerido', 'type' => 'warning');
                echo json_encode($res);
                die();
            }

            // Manejo de imagen
            if (!empty($_FILES['imagen']['name'])) {
                $imagen = $_FILES['imagen'];
                $name = $imagen['name'];
                $tmp = $imagen['tmp_name'];
                
                $fecha = date('YmdHis');
                
                // Verificar tipo de imagen
                $permitidos = array('image/jpg', 'image/jpeg', 'image/png');
                if (!in_array($imagen['type'], $permitidos)) {
                    $res = array('msg' => 'Tipo de archivo no permitido', 'type' => 'warning');
                    echo json_encode($res);
                    die();
                }

                // Crear directorio si no existe
                $directorio = 'assets/img/categorias/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }
                
                $imgNombre = $fecha . '.jpg';
                $destino = $directorio . $imgNombre;
            }

            if (empty($id)) {
                // Nueva categoría
                if (!empty($_FILES['imagen']['name'])) {
                    if (move_uploaded_file($tmp, $destino)) {
                        $data = array(
                            'nombre' => $nombre,
                            'descripcion' => $descripcion,
                            'imagen' => $imgNombre
                        );
                        $query = "INSERT INTO categorias (nombre, descripcion, imagen) VALUES (:nombre, :descripcion, :imagen)";
                    } else {
                        $res = array('msg' => 'Error al subir la imagen', 'type' => 'error');
                        echo json_encode($res);
                        die();
                    }
                } else {
                    $data = array(
                        'nombre' => $nombre,
                        'descripcion' => $descripcion
                    );
                    $query = "INSERT INTO categorias (nombre, descripcion) VALUES (:nombre, :descripcion)";
                }
                
                $result = $this->query->save($query, $data);
                $msg = 'Categoría registrada correctamente';
            } else {
                // Actualizar categoría
                if (!empty($_FILES['imagen']['name'])) {
                    if (move_uploaded_file($tmp, $destino)) {
                        // Eliminar imagen anterior
                        $imgAnterior = $this->query->select("SELECT imagen FROM categorias WHERE id = $id");
                        if (!empty($imgAnterior['imagen'])) {
                            if (file_exists($directorio . $imgAnterior['imagen'])) {
                                unlink($directorio . $imgAnterior['imagen']);
                            }
                        }
                        
                        $data = array(
                            'nombre' => $nombre,
                            'descripcion' => $descripcion,
                            'imagen' => $imgNombre,
                            'id' => $id
                        );
                        $query = "UPDATE categorias SET nombre=:nombre, descripcion=:descripcion, imagen=:imagen WHERE id=:id";
                    } else {
                        $res = array('msg' => 'Error al subir la imagen', 'type' => 'error');
                        echo json_encode($res);
                        die();
                    }
                } else {
                    $data = array(
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                        'id' => $id
                    );
                    $query = "UPDATE categorias SET nombre=:nombre, descripcion=:descripcion WHERE id=:id";
                }
                
                $result = $this->query->save($query, $data);
                $msg = 'Categoría modificada correctamente';
            }
            
            if ($result) {
                $res = array('msg' => $msg, 'type' => 'success');
            } else {
                $res = array('msg' => 'Error en la operación', 'type' => 'error');
            }
            echo json_encode($res);
            die();
        }
    }

    public function eliminarCategoria($id) {
        if (is_numeric($id)) {
            // Verificar si hay productos asociados
            $productos = $this->query->selectAll("SELECT COUNT(*) as total FROM productos WHERE id_categoria = $id AND estado = 1");
            if ($productos[0]['total'] > 0) {
                $res = array(
                    'msg' => 'No se puede eliminar la categoría porque tiene productos asociados', 
                    'type' => 'warning'
                );
                echo json_encode($res);
                die();
            }

            // Si no hay productos, procedemos a eliminar
            $categoria = $this->query->select("SELECT imagen FROM categorias WHERE id = $id");
            
            $query = "DELETE FROM categorias WHERE id = :id";
            $data = array('id' => $id);
            $result = $this->query->save($query, $data);

            if ($result) {
                if (!empty($categoria['imagen'])) {
                    $rutaImagen = 'assets/img/categorias/' . $categoria['imagen'];
                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }
                $res = array('msg' => 'Categoría eliminada correctamente', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al eliminar la categoría', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ID no válido', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function editCategoria($id) {
        if (is_numeric($id)) {
            $data = $this->query->select("SELECT * FROM categorias WHERE id = $id");
            echo json_encode($data);
        }
        die();
    }

    // Nuevo método para obtener datos filtrados por fecha
    public function getDatosFiltrados()
    {
        try {
            $inicio = $_POST['fecha_inicio'] ?? date('Y-m-d', strtotime('-30 days'));
            $fin = $_POST['fecha_fin'] ?? date('Y-m-d');

            $ventas = $this->query->selectAll("
                SELECT 
                    DATE_FORMAT(fecha, '%Y-%m-%d') as fecha,
                    SUM(total) as total
                FROM pedidos
                WHERE fecha BETWEEN '$inicio' AND '$fin 23:59:59'
                AND estado = 1
                GROUP BY DATE_FORMAT(fecha, '%Y-%m-%d')
                ORDER BY fecha ASC
            ");

            echo json_encode([
                'status' => 'success',
                'data' => $ventas
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener los datos'
            ]);
        }
    }

    public function exportarExcel()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Estilo para el encabezado
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0066cc']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ];
            
            // Encabezados
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Cliente');
            $sheet->setCellValue('C1', 'Fecha');
            $sheet->setCellValue('D1', 'Total');
            $sheet->setCellValue('E1', 'Estado');
            
            // Aplicar estilo al encabezado
            $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
            
            // Datos
            $pedidos = $this->query->selectAll("
                SELECT 
                    p.id,
                    c.nombre as cliente,
                    DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
                    p.total,
                    p.estado
                FROM pedidos p
                INNER JOIN clientes c ON p.id_cliente = c.id
                ORDER BY p.fecha DESC
            ");
            
            $row = 2;
            foreach($pedidos as $pedido) {
                $sheet->setCellValue('A' . $row, $pedido['id']);
                $sheet->setCellValue('B' . $row, $pedido['cliente']);
                $sheet->setCellValue('C' . $row, $pedido['fecha']);
                $sheet->setCellValue('D' . $row, '$' . number_format($pedido['total'], 2));
                $sheet->setCellValue('E' . $row, $pedido['estado'] == 1 ? 'Completado' : 'Pendiente');
                $row++;
            }
            
            // Autoajustar columnas
            foreach(range('A','E') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Crear archivo Excel
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Reporte_Pedidos_' . date('Y-m-d') . '.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            
        } catch (\Exception $e) {
            error_log("Error en exportación Excel: " . $e->getMessage());
            echo "Error al generar el archivo Excel";
        }
    }

    public function exportarPDF()
    {
        try {
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
            
            // Configuración básica
            $pdf->SetCreator('Sistema de Pedidos');
            $pdf->SetAuthor('Administrador');
            $pdf->SetTitle('Reporte de Pedidos');
            
            // Márgenes
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(TRUE, 15);
            
            // Agregar página
            $pdf->AddPage();
            
            // Título
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(0, 10, 'Reporte de Pedidos', 0, 1, 'C');
            $pdf->Ln(10);
            
            // Encabezados de tabla
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(20, 7, 'ID', 1, 0, 'C');
            $pdf->Cell(60, 7, 'Cliente', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Fecha', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Total', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Estado', 1, 1, 'C');
            
            // Datos
            $pdf->SetFont('helvetica', '', 10);
            
            $pedidos = $this->query->selectAll("
                SELECT 
                    p.id,
                    c.nombre as cliente,
                    DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
                    p.total,
                    p.estado
                FROM pedidos p
                INNER JOIN clientes c ON p.id_cliente = c.id
                ORDER BY p.fecha DESC
            ");
            
            foreach($pedidos as $pedido) {
                $pdf->Cell(20, 7, $pedido['id'], 1, 0, 'C');
                $pdf->Cell(60, 7, $pedido['cliente'], 1, 0, 'L');
                $pdf->Cell(30, 7, $pedido['fecha'], 1, 0, 'C');
                $pdf->Cell(40, 7, '$' . number_format($pedido['total'], 2), 1, 0, 'R');
                $pdf->Cell(30, 7, $pedido['estado'] == 1 ? 'Completado' : 'Pendiente', 1, 1, 'C');
            }
            
            // Salida del PDF
            $pdf->Output('Reporte_Pedidos_' . date('Y-m-d') . '.pdf', 'D');
            
        } catch (\Exception $e) {
            error_log("Error en exportación PDF: " . $e->getMessage());
            echo "Error al generar el archivo PDF";
        }
    }

    public function getResumenMensual()
    {
        try {
            // Resumen del mes actual vs mes anterior
            $resumen = $this->query->selectAll("
                SELECT 
                    DATE_FORMAT(fecha, '%Y-%m') as mes,
                    COUNT(*) as total_pedidos,
                    SUM(total) as total_ventas,
                    COUNT(DISTINCT id_cliente) as total_clientes
                FROM pedidos
                WHERE fecha >= DATE_SUB(CURRENT_DATE, INTERVAL 2 MONTH)
                AND estado = 1
                GROUP BY DATE_FORMAT(fecha, '%Y-%m')
                ORDER BY mes DESC
                LIMIT 2
            ");

            // Productos más vendidos del mes
            $productos_mes = $this->query->selectAll("
                SELECT 
                    p.nombre,
                    SUM(dp.cantidad) as cantidad,
                    SUM(dp.cantidad * dp.precio_unitario) as total
                FROM productos p
                INNER JOIN detalle_pedido dp ON p.id = dp.id_producto
                INNER JOIN pedidos pe ON dp.id_pedido = pe.id
                WHERE DATE_FORMAT(pe.fecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')
                AND pe.estado = 1
                GROUP BY p.id, p.nombre
                ORDER BY cantidad DESC
                LIMIT 5
            ");

            echo json_encode([
                'status' => 'success',
                'resumen' => $resumen,
                'productos_mes' => $productos_mes
            ]);

        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener el resumen mensual'
            ]);
        }
    }

    public function getEstadisticasAvanzadas()
    {
        try {
            // Estadísticas de los últimos 30 días
            $estadisticas = $this->query->selectAll("
                SELECT 
                    fecha,
                    total_ventas,
                    total_pedidos,
                    total_productos_vendidos,
                    promedio_venta
                FROM estadisticas_diarias
                WHERE fecha >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)
                ORDER BY fecha DESC
            ");

            // Resumen del mes actual
            $resumen_mes = $this->query->select("
                SELECT 
                    SUM(total_ventas) as ventas_mes,
                    SUM(total_pedidos) as pedidos_mes,
                    SUM(total_productos_vendidos) as productos_vendidos,
                    AVG(promedio_venta) as promedio_venta_mes
                FROM estadisticas_diarias
                WHERE DATE_FORMAT(fecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')
            ");

            // Comparativa con mes anterior
            $mes_anterior = $this->query->select("
                SELECT 
                    SUM(total_ventas) as ventas_mes,
                    SUM(total_pedidos) as pedidos_mes
                FROM estadisticas_diarias
                WHERE DATE_FORMAT(fecha, '%Y-%m') = DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH), '%Y-%m')
            ");

            echo json_encode([
                'status' => 'success',
                'estadisticas' => $estadisticas,
                'resumen_mes' => $resumen_mes,
                'mes_anterior' => $mes_anterior
            ]);

        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener las estadísticas avanzadas'
            ]);
        }
    }

    public function getVentasHoy()
    {
        try {
            $ventas_hoy = $this->query->select("
                SELECT 
                    COUNT(*) as total_pedidos,
                    COALESCE(SUM(total), 0) as total_ventas
                FROM pedidos 
                WHERE DATE(fecha) = CURRENT_DATE
                AND estado = 1
            ");

            echo json_encode([
                'status' => 'success',
                'data' => $ventas_hoy
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener ventas del día'
            ]);
        }
    }

    public function pedidos()
    {
        $data['title'] = 'Pedidos';
        $data['pedidos'] = $this->query->selectAll("
            SELECT 
                p.id,
                c.nombre as cliente,
                p.total,
                DATE_FORMAT(p.fecha, '%d/%m/%Y %H:%i:%s') as fecha,
                p.estado
            FROM pedidos p
            INNER JOIN clientes c ON p.id_cliente = c.id
            ORDER BY p.fecha DESC
        ");
        $this->views->getView('Admin', 'pedidos', $data);
    }

    public function verPedido($idPedido)
    {
        $data = $this->query->selectAll("
            SELECT 
                p.nombre,
                d.cantidad,
                d.precio_unitario,
                (d.cantidad * d.precio_unitario) as subtotal
            FROM detalle_pedido d
            INNER JOIN productos p ON d.id_producto = p.id
            WHERE d.id_pedido = $idPedido
        ");
        echo json_encode($data);
    }

    public function cambiarEstado($idPedido)
    {
        $pedido = $this->query->select("SELECT estado FROM pedidos WHERE id = $idPedido");
        $nuevo_estado = ($pedido['estado'] == 1) ? 0 : 1;
        
        $query = "UPDATE pedidos SET estado = ? WHERE id = ?";
        $data = array($nuevo_estado, $idPedido);
        
        if ($this->query->save($query, $data)) {
            $res = array('msg' => 'Estado actualizado', 'type' => 'success');
        } else {
            $res = array('msg' => 'Error al actualizar', 'type' => 'error');
        }
        echo json_encode($res);
    }

    public function estadisticas()
    {
        // Limpiar cualquier salida previa
        if (ob_get_length()) ob_clean();
        
        // Establecer headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            $data = [
                'usuarios' => intval($this->query->select("SELECT COUNT(*) as total FROM usuarios WHERE estado = 1", "total")),
                'productos' => intval($this->query->select("SELECT COUNT(*) as total FROM productos WHERE estado = 1", "total")),
                'categorias' => intval($this->query->select("SELECT COUNT(*) as total FROM categorias WHERE estado = 1", "total")),
                'pedidos' => intval($this->query->select("SELECT COUNT(*) as total FROM pedidos WHERE estado != -1", "total"))
            ];
            
            echo json_encode($data, JSON_NUMERIC_CHECK);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function actualizarEstadisticas()
    {
        // Limpiar todo el buffer de salida y deshabilitar el buffering
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Establecer cabeceras
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            $ventas = $this->query->select("SELECT COUNT(*) FROM ventas WHERE estado = 1");
            $usuarios = $this->query->select("SELECT COUNT(*) FROM usuarios WHERE estado = 1");
            $productos = $this->query->select("SELECT COUNT(*) FROM productos WHERE estado = 1");
            $pedidos = $this->query->select("SELECT COUNT(*) FROM pedidos WHERE estado = 1");
            
            $data = [
                'status' => true,
                'ventas' => intval($ventas),
                'usuarios' => intval($usuarios),
                'productos' => intval($productos),
                'pedidos' => intval($pedidos)
            ];
            
            echo json_encode($data, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => false,
                'msg' => 'Error al actualizar estadísticas'
            ]);
        }
        exit;
    }
} 