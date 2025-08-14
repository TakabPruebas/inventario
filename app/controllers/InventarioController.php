<?php
require_once __DIR__ . '/../models/MovimientoInventario.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Almacen.php';
require_once __DIR__ . '/../helpers/Session.php';

class InventarioController
{
    public function entrada()
    {
        Session::requireLogin(['Administrador', 'Almacen']);
        $productos = Producto::all();
        $almacenes = Almacen::all();
        $msg = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'producto_id' => $_POST['producto_id'],
                'tipo' => 'Entrada',
                'cantidad' => $_POST['cantidad'],
                'usuario_id' => $_SESSION['user_id'],
                'almacen_destino_id' => $_POST['almacen_id'],
                'observaciones' => $_POST['observaciones'] ?? ''
            ];
            MovimientoInventario::registrar($data);
            Producto::sumarStock($data['producto_id'], $data['cantidad']);
            $msg = "Entrada registrada correctamente.";
        }
        include __DIR__ . '/../views/inventario/entrada.php';
    }

    public function salida()
    {
        Session::requireLogin(['Administrador', 'Almacen']);
        $productos = Producto::all();
        $almacenes = Almacen::all();
        $msg = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'producto_id' => $_POST['producto_id'],
                'tipo' => 'Salida',
                'cantidad' => $_POST['cantidad'],
                'usuario_id' => $_SESSION['user_id'],
                'almacen_origen_id' => $_POST['almacen_id'],
                'observaciones' => $_POST['observaciones'] ?? ''
            ];
            MovimientoInventario::registrar($data);
            Producto::restarStock($data['producto_id'], $data['cantidad']);
            $msg = "Salida registrada correctamente.";
        }
        include __DIR__ . '/../views/inventario/salida.php';
    }

public function actual()
{
    Session::requireLogin();

    // Búsqueda y filtro
    $filtros = [];
    if (!empty($_GET['q'])) {
        $filtros['q'] = trim($_GET['q']);
    }
    if (!empty($_GET['cat'])) {
        $filtros['categoria'] = trim($_GET['cat']);
    }
    $productos = Producto::allInventario($filtros); // Nueva función (ver más abajo)
    $categorias = Producto::categorias(); // Función para traer todas las categorías como array
    include __DIR__ . '/../views/inventario/actual.php';
}

}
