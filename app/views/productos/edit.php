<h2>Editar Producto</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post" enctype="multipart/form-data" action="">
    <label>Código:</label><br>
    <input type="text" name="codigo" value="<?= htmlspecialchars($producto['codigo']) ?>" required><br>

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion"><?= htmlspecialchars($producto['descripcion']) ?></textarea><br>

    <label>Proveedor:</label><br>
    <select name="proveedor_id" required>
        <option value="">Seleccione</option>
        <?php foreach ($proveedores as $prov): ?>
            <option value="<?= $prov['id'] ?>" <?= ($producto['proveedor_id'] == $prov['id']) ? 'selected' : '' ?>><?= htmlspecialchars($prov['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Categoría:</label><br>
    <select name="categoria_id" required>
        <option value="">Seleccione</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($producto['categoria_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Peso (kg):</label><br>
    <input type="number" name="peso" step="0.01" value="<?= htmlspecialchars($producto['peso']) ?>"><br>

    <label>Ancho (cm):</label><br>
    <input type="number" name="ancho" step="0.01" value="<?= htmlspecialchars($producto['ancho']) ?>"><br>

    <label>Alto (cm):</label><br>
    <input type="number" name="alto" step="0.01" value="<?= htmlspecialchars($producto['alto']) ?>"><br>

    <label>Profundidad (cm):</label><br>
    <input type="number" name="profundidad" step="0.01" value="<?= htmlspecialchars($producto['profundidad']) ?>"><br>

    <label>Unidad de medida:</label><br>
    <select name="unidad_medida_id">
        <option value="">Seleccione</option>
        <?php foreach ($unidades as $um): ?>
            <option value="<?= $um['id'] ?>" <?= ($producto['unidad_medida_id'] == $um['id']) ? 'selected' : '' ?>><?= htmlspecialchars($um['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Clase/Categoría:</label><br>
    <input type="text" name="clase_categoria" value="<?= htmlspecialchars($producto['clase_categoria']) ?>"><br>

    <label>Marca:</label><br>
    <input type="text" name="marca" value="<?= htmlspecialchars($producto['marca']) ?>"><br>

    <label>Color:</label><br>
    <input type="text" name="color" value="<?= htmlspecialchars($producto['color']) ?>"><br>

    <label>Forma:</label><br>
    <input type="text" name="forma" value="<?= htmlspecialchars($producto['forma']) ?>"><br>

    <label>Especificaciones técnicas:</label><br>
    <textarea name="especificaciones_tecnicas"><?= htmlspecialchars($producto['especificaciones_tecnicas']) ?></textarea><br>

    <label>Origen:</label><br>
    <input type="text" name="origen" value="<?= htmlspecialchars($producto['origen']) ?>"><br>

    <label>Costo de compra:</label><br>
    <input type="number" name="costo_compra" step="0.01" value="<?= htmlspecialchars($producto['costo_compra']) ?>"><br>

    <label>Precio de venta:</label><br>
    <input type="number" name="precio_venta" step="0.01" value="<?= htmlspecialchars($producto['precio_venta']) ?>"><br>

    <label>Stock mínimo:</label><br>
    <input type="number" name="stock_minimo" min="0" value="<?= htmlspecialchars($producto['stock_minimo']) ?>"><br>

    <label>Stock actual:</label><br>
    <input type="number" name="stock_actual" min="0" value="<?= htmlspecialchars($producto['stock_actual']) ?>"><br>

    <label>Almacén:</label><br>
    <select name="almacen_id" required>
        <option value="">Seleccione</option>
        <?php foreach ($almacenes as $alm): ?>
            <option value="<?= $alm['id'] ?>" <?= ($producto['almacen_id'] == $alm['id']) ? 'selected' : '' ?>><?= htmlspecialchars($alm['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Estado:</label><br>
    <select name="estado" required>
        <option value="Nuevo" <?= $producto['estado']=='Nuevo'?'selected':'' ?>>Nuevo</option>
        <option value="Usado" <?= $producto['estado']=='Usado'?'selected':'' ?>>Usado</option>
        <option value="Dañado" <?= $producto['estado']=='Dañado'?'selected':'' ?>>Dañado</option>
        <option value="En reparación" <?= $producto['estado']=='En reparación'?'selected':'' ?>>En reparación</option>
    </select><br>

    <label>Tipo:</label><br>
    <select name="tipo" required>
        <option value="Consumible" <?= $producto['tipo']=='Consumible'?'selected':'' ?>>Consumible</option>
        <option value="Herramienta" <?= $producto['tipo']=='Herramienta'?'selected':'' ?>>Herramienta</option>
    </select><br>

    <?php if ($producto['imagen_url']): ?>
        <label>Imagen actual:</label><br>
        <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" width="100"><br>
    <?php endif; ?>

    

    <label>Cambiar imagen:</label>
    <input type="file" name="imagen_url" accept="image/*"><br>

    <input type="hidden" name="last_requested_by_user_id" value="<?= htmlspecialchars($producto['last_requested_by_user_id']) ?>">
    <input type="hidden" name="last_request_date" value="<?= htmlspecialchars($producto['last_request_date']) ?>">
    

    <label>Tags:</label><br>
    <input type="text" name="tags" value="<?= htmlspecialchars($producto['tags']) ?>"><br>

    <button type="submit">Actualizar</button>
</form>
<a href="productos.php">Volver al listado</a>
