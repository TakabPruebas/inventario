<?php
require_once __DIR__ . '/../../helpers/Session.php';
Session::requireLogin(['Administrador', 'Almacen']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Entrada de Inventario | TAKAB</title>
    <link rel="stylesheet" href="../public/assets/css/inventario-entrada.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="main-inventario">
    <div class="top-header">
        <div class="header-title"><i class="fa fa-arrow-down"></i> Registrar Entrada de Inventario</div>
        <a href="actual.php" class="btn-volver"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>

    <?php if (!empty($msg)): ?>
        <div class="alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form class="card-form" method="post" autocomplete="off">
        <div class="form-row">
            <label>Producto
                <select name="producto_id" required>
                    <option value="">Seleccionar producto...</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="form-row">
            <label>Almacén
                <select name="almacen_id" required>
                    <option value="">Seleccionar almacén...</option>
                    <?php foreach ($almacenes as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="form-row">
            <label>Cantidad
                <input type="number" name="cantidad" min="1" required placeholder="Ingrese cantidad">
            </label>
        </div>
        <div class="form-row">
            <label>Observaciones
                <input type="text" name="observaciones" placeholder="Observaciones (opcional)">
            </label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fa fa-save"></i> Registrar Entrada
            </button>
        </div>
    </form>
</div>
</body>
</html>
