<?php
require_once __DIR__ . '/../helpers/Database.php';

class MovimientoInventario {
    public static function registrar($data) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO movimientos_inventario 
            (producto_id, tipo, cantidad, fecha, usuario_id, almacen_origen_id, almacen_destino_id, observaciones)
            VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['producto_id'],
            $data['tipo'],
            $data['cantidad'],
            $data['usuario_id'],
            $data['almacen_origen_id'] ?? null,
            $data['almacen_destino_id'] ?? null,
            $data['observaciones'] ?? ''
        ]);
    }

    public static function movimientos($filtros = []) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT m.*, p.nombre AS producto, a.nombre AS almacen_origen, ad.nombre AS almacen_destino, u.nombre_completo AS usuario
                FROM movimientos_inventario m
                LEFT JOIN productos p ON m.producto_id = p.id
                LEFT JOIN almacenes a ON m.almacen_origen_id = a.id
                LEFT JOIN almacenes ad ON m.almacen_destino_id = ad.id
                LEFT JOIN usuarios u ON m.usuario_id = u.id
                WHERE 1=1";
        $params = [];
        if (!empty($filtros['tipo'])) {
            $sql .= " AND m.tipo = ?";
            $params[] = $filtros['tipo'];
        }
        if (!empty($filtros['producto_id'])) {
            $sql .= " AND m.producto_id = ?";
            $params[] = $filtros['producto_id'];
        }
        $sql .= " ORDER BY m.fecha DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
