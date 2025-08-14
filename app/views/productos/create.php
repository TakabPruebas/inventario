<h2>Alta de Producto</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post" enctype="multipart/form-data" action="">
    <label>Código:</label><br>
    <input type="text" name="codigo" value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>" required><br>
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required><br>
    <label>Descripción:</label><br>
    <textarea name="descripcion"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea><br>
    <label>Proveedor:</label><br>
    <select name="proveedor_id" required>
        <option value="">Seleccione</option>
        <?php foreach ($proveedores as $prov): ?>
            <option value="<?= $prov['id'] ?>" <?= ($_POST['proveedor_id'] ?? '')==$prov['id']?'selected':'' ?>><?= htmlspecialchars($prov['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Categoría:</label><br>
    <select name="categoria_id" required>
        <option value="">Seleccione</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($_POST['categoria_id'] ?? '')==$cat['id']?'selected':'' ?>><?= htmlspecialchars($cat['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Peso (kg):</label><br>
    <input type="number" name="peso" step="0.01" value="<?= htmlspecialchars($_POST['peso'] ?? '') ?>"><br>
    <label>Ancho (cm):</label><br>
    <input type="number" name="ancho" step="0.01" value="<?= htmlspecialchars($_POST['ancho'] ?? '') ?>"><br>
    <label>Alto (cm):</label><br>
    <input type="number" name="alto" step="0.01" value="<?= htmlspecialchars($_POST['alto'] ?? '') ?>"><br>
    <label>Profundidad (cm):</label><br>
    <input type="number" name="profundidad" step="0.01" value="<?= htmlspecialchars($_POST['profundidad'] ?? '') ?>"><br>
    <label>Unidad de medida:</label><br>
    <select name="unidad_medida_id">
        <option value="">Seleccione</option>
        <?php foreach ($unidades as $um): ?>
            <option value="<?= $um['id'] ?>" <?= ($_POST['unidad_medida_id'] ?? '')==$um['id']?'selected':'' ?>><?= htmlspecialchars($um['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Clase/Categoría:</label><br>
    <input type="text" name="clase_categoria" value="<?= htmlspecialchars($_POST['clase_categoria'] ?? '') ?>"><br>
    <label>Marca:</label><br>
    <input type="text" name="marca" value="<?= htmlspecialchars($_POST['marca'] ?? '') ?>"><br>
    <label>Color:</label><br>
    <input type="text" name="color" value="<?= htmlspecialchars($_POST['color'] ?? '') ?>"><br>
    <label>Forma:</label><br>
    <input type="text" name="forma" value="<?= htmlspecialchars($_POST['forma'] ?? '') ?>"><br>
    <label>Especificaciones técnicas:</label><br>
    <textarea name="especificaciones_tecnicas"><?= htmlspecialchars($_POST['especificaciones_tecnicas'] ?? '') ?></textarea><br>
    <label>Origen:</label><br>
    <input type="text" name="origen" value="<?= htmlspecialchars($_POST['origen'] ?? '') ?>"><br>
    <label>Costo de compra:</label><br>
    <input type="number" name="costo_compra" step="0.01" value="<?= htmlspecialchars($_POST['costo_compra'] ?? '') ?>"><br>
    <label>Precio de venta:</label><br>
    <input type="number" name="precio_venta" step="0.01" value="<?= htmlspecialchars($_POST['precio_venta'] ?? '') ?>"><br>
    <label>Stock mínimo:</label><br>
    <input type="number" name="stock_minimo" min="0" value="<?= htmlspecialchars($_POST['stock_minimo'] ?? '') ?>"><br>
    <label>Stock actual:</label><br>
    <input type="number" name="stock_actual" min="0" value="<?= htmlspecialchars($_POST['stock_actual'] ?? '') ?>"><br>
    <label>Almacén:</label><br>
    <select name="almacen_id" required>
        <option value="">Seleccione</option>
        <?php foreach ($almacenes as $alm): ?>
            <option value="<?= $alm['id'] ?>" <?= ($_POST['almacen_id'] ?? '')==$alm['id']?'selected':'' ?>><?= htmlspecialchars($alm['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Estado:</label><br>
    <select name="estado" required>
        <option value="Nuevo">Nuevo</option>
        <option value="Usado">Usado</option>
        <option value="Dañado">Dañado</option>
        <option value="En reparación">En reparación</option>
    </select><br>
    <label>Tipo:</label><br>
    <select name="tipo" required>
        <option value="Consumible">Consumible</option>
        <option value="Herramienta">Herramienta</option>
    </select><br>
    <label>Imagen:</label><br>
    <input type="file" name="imagen_url" accept="image/*"><br>
    <input type="hidden" name="last_requested_by_user_id" value="">
    <input type="hidden" name="last_request_date" value="">
    <label>Tags:</label><br>
    <input type="text" name="tags" value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>"><br>
    <button type="submit">Guardar</button>
</form>
<a href="productos.php">Volver al listado</a>
