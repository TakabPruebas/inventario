<?php
require_once __DIR__ . '/../helpers/Database.php';

class Producto {
    public static function all($filtros = []) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT p.*, c.nombre AS categoria, a.nombre AS almacen, u.nombre_completo AS last_user
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN almacenes a ON p.almacen_id = a.id
                LEFT JOIN usuarios u ON p.last_requested_by_user_id = u.id
                WHERE 1=1";
        $params = [];
        if (!empty($filtros['nombre'])) {
            $sql .= " AND p.nombre LIKE ?";
            $params[] = '%' . $filtros['nombre'] . '%';
        }
        if (!empty($filtros['codigo'])) {
            $sql .= " AND p.codigo LIKE ?";
            $params[] = '%' . $filtros['codigo'] . '%';
        }
        if (!empty($filtros['tipo'])) {
            $sql .= " AND p.tipo = ?";
            $params[] = $filtros['tipo'];
        }
        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = ?";
            $params[] = $filtros['categoria_id'];
        }
        if (!empty($filtros['almacen_id'])) {
            $sql .= " AND p.almacen_id = ?";
            $params[] = $filtros['almacen_id'];
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO productos (
            codigo, nombre, descripcion, proveedor_id, categoria_id,
            peso, ancho, alto, profundidad, unidad_medida_id, clase_categoria,
            marca, color, forma, especificaciones_tecnicas, origen,
            costo_compra, precio_venta, stock_minimo, stock_actual, almacen_id,
            estado, tipo, imagen_url, last_requested_by_user_id, last_request_date, tags
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['codigo'], $data['nombre'], $data['descripcion'], $data['proveedor_id'], $data['categoria_id'],
            $data['peso'], $data['ancho'], $data['alto'], $data['profundidad'], $data['unidad_medida_id'],
            $data['clase_categoria'], $data['marca'], $data['color'], $data['forma'], $data['especificaciones_tecnicas'],
            $data['origen'], $data['costo_compra'], $data['precio_venta'], $data['stock_minimo'], $data['stock_actual'],
            $data['almacen_id'], $data['estado'], $data['tipo'], $data['imagen_url'],
            $data['last_requested_by_user_id'], $data['last_request_date'], $data['tags']
        ]);
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT p.*, c.nombre AS categoria, a.nombre AS almacen, u.nombre_completo AS last_user
                              FROM productos p
                              LEFT JOIN categorias c ON p.categoria_id = c.id
                              LEFT JOIN almacenes a ON p.almacen_id = a.id
                              LEFT JOIN usuarios u ON p.last_requested_by_user_id = u.id
                              WHERE p.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function findByCodigo($codigo) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM productos WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch();
    }

    public static function existsCodigoExcept($codigo, $id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM productos WHERE codigo = ? AND id != ?");
        $stmt->execute([$codigo, $id]);
        return $stmt->fetch();
    }

    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE productos SET
            codigo=?, nombre=?, descripcion=?, proveedor_id=?, categoria_id=?,
            peso=?, ancho=?, alto=?, profundidad=?, unidad_medida_id=?, clase_categoria=?,
            marca=?, color=?, forma=?, especificaciones_tecnicas=?, origen=?,
            costo_compra=?, precio_venta=?, stock_minimo=?, stock_actual=?, almacen_id=?,
            estado=?, tipo=?, imagen_url=?, last_requested_by_user_id=?, last_request_date=?, tags=?
            WHERE id=?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['codigo'], $data['nombre'], $data['descripcion'], $data['proveedor_id'], $data['categoria_id'],
            $data['peso'], $data['ancho'], $data['alto'], $data['profundidad'], $data['unidad_medida_id'],
            $data['clase_categoria'], $data['marca'], $data['color'], $data['forma'], $data['especificaciones_tecnicas'],
            $data['origen'], $data['costo_compra'], $data['precio_venta'], $data['stock_minimo'], $data['stock_actual'],
            $data['almacen_id'], $data['estado'], $data['tipo'], $data['imagen_url'],
            $data['last_requested_by_user_id'], $data['last_request_date'], $data['tags'], $id
        ]);
    }

    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM productos WHERE id=?");
        return $stmt->execute([$id]);
    }

    public static function setActive($id, $active) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE productos SET estado=? WHERE id=?");
        return $stmt->execute([$active ? 'Nuevo' : 'Desactivado', $id]);
    }

public static function sumarStock($id, $cantidad) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("UPDATE productos SET stock_actual = stock_actual + ? WHERE id = ?");
    return $stmt->execute([$cantidad, $id]);
}

public static function restarStock($id, $cantidad) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("UPDATE productos SET stock_actual = GREATEST(stock_actual - ?, 0) WHERE id = ?");
    return $stmt->execute([$cantidad, $id]);
}

public static function allInventario($filtros = []) {
    $db = Database::getInstance()->getConnection();
    $sql = "SELECT p.*, 
                   c.nombre AS categoria, 
                   u.abreviacion AS unidad, 
                   (p.costo_compra * p.stock_actual) AS valor_total,
                   (SELECT MAX(fecha) FROM movimientos_inventario m WHERE m.producto_id = p.id) AS ultimo_movimiento
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            LEFT JOIN unidades_medida u ON p.unidad_medida_id = u.id
            WHERE 1=1";
    $params = [];
    if (!empty($filtros['q'])) {
        $sql .= " AND (p.nombre LIKE ? OR p.codigo LIKE ?)";
        $params[] = '%'.$filtros['q'].'%';
        $params[] = '%'.$filtros['q'].'%';
    }
    if (!empty($filtros['categoria'])) {
        $sql .= " AND c.nombre = ?";
        $params[] = $filtros['categoria'];
    }
    $sql .= " ORDER BY p.nombre ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}


// Función para listar todas las categorías únicas (útil para el filtro)
public static function categorias() {
    $db = Database::getInstance()->getConnection();
    $cats = $db->query("SELECT nombre FROM categorias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_COLUMN);
    return $cats ?: [];
}


}
