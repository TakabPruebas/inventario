<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/Session.php';
Session::requireLogin(['Administrador', 'Almacen']); // Para alta, edición y borrado de productos
Session::requireLogin(); // Para vistas generales


class ProductoController
{
    public function index()
    {
        Session::requireLogin();
        $filtros = $_GET;
        $productos = Producto::all($filtros);
        include __DIR__ . '/../views/productos/index.php';
    }

public function create()
{
    Session::requireLogin(['Administrador', 'Almacen']);
    $db = Database::getInstance()->getConnection();
    $categorias = $db->query("SELECT id, nombre FROM categorias")->fetchAll();
    $proveedores = $db->query("SELECT id, nombre FROM proveedores")->fetchAll();
    $almacenes = $db->query("SELECT id, nombre FROM almacenes")->fetchAll();
    $unidades = $db->query("SELECT id, nombre FROM unidades_medida")->fetchAll();
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar código único
        if (Producto::findByCodigo($_POST['codigo'])) {
            $error = "Ya existe un producto con ese código.";
        } else {
            $imagen_path = null;
            if (!empty($_FILES['imagen_url']['name'])) {
                $upload_dir = __DIR__ . '/../../public/assets/images/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen_url']['name']);
                $target_file = $upload_dir . $nombreArchivo;
                $tipoArchivo = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES['imagen_url']['tmp_name']);
                if ($check === false) {
                    $error = "El archivo no es una imagen válida.";
                } elseif ($_FILES['imagen_url']['size'] > 2 * 1024 * 1024) {
                    $error = "La imagen es demasiado grande (máx. 2MB).";
                } elseif (!in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $error = "Formato de imagen no permitido.";
                } elseif (!move_uploaded_file($_FILES['imagen_url']['tmp_name'], $target_file)) {
                    $error = "Error al subir la imagen.";
                } else {
                    $imagen_path = 'assets/images/' . $nombreArchivo;
                }
            }
            if (empty($error)) {
                $data = $_POST;
                $data['imagen_url'] = $imagen_path;
                $data['last_requested_by_user_id'] = null;
                $data['last_request_date'] = null;
                Producto::create($data);
                header("Location: productos.php?success=1");
                exit();
            }
        }
    }
    include __DIR__ . '/../views/productos/create.php';
}

public function edit($id)
{
    Session::requireLogin(['Administrador', 'Almacen']);
    $producto = Producto::find($id);
    $db = Database::getInstance()->getConnection();
    $categorias = $db->query("SELECT id, nombre FROM categorias")->fetchAll();
    $proveedores = $db->query("SELECT id, nombre FROM proveedores")->fetchAll();
    $almacenes = $db->query("SELECT id, nombre FROM almacenes")->fetchAll();
    $unidades = $db->query("SELECT id, nombre FROM unidades_medida")->fetchAll();
    $error = '';
    if (!$producto) die("Producto no encontrado.");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar código único excepto este id
        if (Producto::existsCodigoExcept($_POST['codigo'], $id)) {
            $error = "Ya existe otro producto con ese código.";
        } else {
            $imagen_path = $producto['imagen_url'];
            if (!empty($_FILES['imagen_url']['name'])) {
                $upload_dir = __DIR__ . '/../../public/assets/images/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen_url']['name']);
                $target_file = $upload_dir . $nombreArchivo;
                $tipoArchivo = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES['imagen_url']['tmp_name']);
                if ($check === false) {
                    $error = "El archivo no es una imagen válida.";
                } elseif ($_FILES['imagen_url']['size'] > 2 * 1024 * 1024) {
                    $error = "La imagen es demasiado grande (máx. 2MB).";
                } elseif (!in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $error = "Formato de imagen no permitido.";
                } elseif (!move_uploaded_file($_FILES['imagen_url']['tmp_name'], $target_file)) {
                    $error = "Error al subir la imagen.";
                } else {
                    $imagen_path = 'assets/images/' . $nombreArchivo;
                }
            }
            if (empty($error)) {
                $data = $_POST;
                $data['imagen_url'] = $imagen_path;
                $data['last_requested_by_user_id'] = $producto['last_requested_by_user_id'];
                $data['last_request_date'] = $producto['last_request_date'];
                Producto::update($id, $data);
                header("Location: productos.php?success=2");
                exit();
            }
        }
    }
    include __DIR__ . '/../views/productos/edit.php';
}


    public function view($id)
    {
        Session::requireLogin();
        $producto = Producto::find($id);
        if (!$producto) die("Producto no encontrado.");
        include __DIR__ . '/../views/productos/view.php';
    }

    public function delete($id)
    {
        Session::requireLogin(['Administrador', 'Almacen']);
        Producto::delete($id);
        header("Location: productos.php?deleted=1");
        exit();
    }

    public function setActive($id, $active)
    {
        Session::requireLogin(['Administrador', 'Almacen']);
        Producto::setActive($id, $active);
        header("Location: productos.php");
        exit();
    }
}


