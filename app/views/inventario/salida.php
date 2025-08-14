<?php
require_once __DIR__ . '/../../helpers/Session.php';
Session::requireLogin(['Administrador', 'Almacen']);
?>
<h2>Registrar Salida de Inventario</h2>
<?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post">
    <label>Producto:
        <select name="producto_id" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($productos as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Almacén:
        <select name="almacen_id" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($almacenes as $a): ?>
                <option value="<?= $a['id'] ?>"><?= $a['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Cantidad:
        <input type="number" name="cantidad" min="1" required>
    </label><br>
    <label>Observaciones:
        <input type="text" name="observaciones">
    </label><br>
    <button type="submit">Registrar Salida</button>
</form>
