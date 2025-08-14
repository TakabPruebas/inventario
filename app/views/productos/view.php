<h2>Detalle de Producto</h2>
<?php if ($producto['imagen_url']): ?>
    <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" width="150"><br>
<?php endif; ?>
<table border="1" cellpadding="5">
<tr><td><b>ID</b></td><td><?= $producto['id'] ?></td></tr>
<tr><td><b>Código</b></td><td><?= htmlspecialchars($producto['codigo']) ?></td></tr>
<tr><td><b>Nombre</b></td><td><?= htmlspecialchars($producto['nombre']) ?></td></tr>
<tr><td><b>Descripción</b></td><td><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></td></tr>
<tr><td><b>Proveedor</b></td><td><?= htmlspecialchars($producto['proveedor']) . " (#" . $producto['proveedor_id'] . ")" ?></td></tr>
<tr><td><b>Categoría</b></td><td><?= htmlspecialchars($producto['categoria']) . " (#" . $producto['categoria_id'] . ")" ?></td></tr>
<tr><td><b>Peso</b></td><td><?= $producto['peso'] ?></td></tr>
<tr><td><b>Ancho</b></td><td><?= $producto['ancho'] ?></td></tr>
<tr><td><b>Alto</b></td><td><?= $producto['alto'] ?></td></tr>
<tr><td><b>Profundidad</b></td><td><?= $producto['profundidad'] ?></td></tr>
<tr><td><b>Unidad de medida</b></td><td><?= htmlspecialchars($producto['unidad_medida']) . " (#" . $producto['unidad_medida_id'] . ")" ?></td></tr>
<tr><td><b>Clase/Categoría</b></td><td><?= htmlspecialchars($producto['clase_categoria']) ?></td></tr>
<tr><td><b>Marca</b></td><td><?= htmlspecialchars($producto['marca']) ?></td></tr>
<tr><td><b>Color</b></td><td><?= htmlspecialchars($producto['color']) ?></td></tr>
<tr><td><b>Forma</b></td><td><?= htmlspecialchars($producto['forma']) ?></td></tr>
<tr><td><b>Especificaciones técnicas</b></td><td><?= nl2br(htmlspecialchars($producto['especificaciones_tecnicas'])) ?></td></tr>
<tr><td><b>Origen</b></td><td><?= htmlspecialchars($producto['origen']) ?></td></tr>
<tr><td><b>Costo de compra</b></td><td><?= $producto['costo_compra'] ?></td></tr>
<tr><td><b>Precio de venta</b></td><td><?= $producto['precio_venta'] ?></td></tr>
<tr><td><b>Stock mínimo</b></td><td><?= $producto['stock_minimo'] ?></td></tr>
<tr><td><b>Stock actual</b></td><td><?= $producto['stock_actual'] ?></td></tr>
<tr><td><b>Almacén</b></td><td><?= htmlspecialchars($producto['almacen']) . " (#" . $producto['almacen_id'] . ")" ?></td></tr>
<tr><td><b>Estado</b></td><td><?= $producto['estado'] ?></td></tr>
<tr><td><b>Tipo</b></td><td><?= $producto['tipo'] ?></td></tr>
<tr><td><b>Imagen URL</b></td><td><?= htmlspecialchars($producto['imagen_url']) ?></td></tr>
<tr><td><b>Último solicitante</b></td><td><?= $producto['last_user'] ?? "-" ?> (ID: <?= $producto['last_requested_by_user_id'] ?>)</td></tr>
<tr><td><b>Última solicitud</b></td><td><?= $producto['last_request_date'] ?></td></tr>
<tr><td><b>Tags</b></td><td><?= htmlspecialchars($producto['tags']) ?></td></tr>
<tr><td><b>Fecha de creación</b></td><td><?= $producto['created_at'] ?></td></tr>
</table>
<br>
<a href="productos_edit.php?id=<?= $producto['id'] ?>">Editar</a>
&nbsp;|&nbsp;
<a href="productos_delete.php?id=<?= $producto['id'] ?>">Eliminar</a>
&nbsp;|&nbsp;
<a href="productos.php">Volver al listado</a>
