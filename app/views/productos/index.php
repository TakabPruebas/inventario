<h2>Catálogo de Productos</h2>
<a href="productos_create.php">Agregar Producto</a>
<?php if (isset($_GET['success'])) echo "<p style='color:green;'>Producto guardado correctamente.</p>"; ?>
<?php if (isset($_GET['deleted'])) echo "<p style='color:red;'>Producto eliminado.</p>"; ?>
<form method="get">
    Buscar: <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
    Código: <input type="text" name="codigo" value="<?= htmlspecialchars($_GET['codigo'] ?? '') ?>">
    Tipo: 
    <select name="tipo">
        <option value="">Todos</option>
        <option value="Consumible" <?= (($_GET['tipo'] ?? '')=='Consumible'?'selected':'') ?>>Consumible</option>
        <option value="Herramienta" <?= (($_GET['tipo'] ?? '')=='Herramienta'?'selected':'') ?>>Herramienta</option>
    </select>
    <button type="submit">Filtrar</button>
</form>
<table border="1">
<thead>
<tr><th>Código</th><th>Nombre</th><th>Tipo</th><th>Stock</th><th>Almacén</th><th>Estado</th><th>Último solicitante</th><th>Acciones</th></tr>
</thead>
<tbody>
<?php foreach($productos as $p): ?>
<tr>
    <td><?= htmlspecialchars($p['codigo']) ?></td>
    <td><?= htmlspecialchars($p['nombre']) ?></td>
    <td><?= $p['tipo'] ?></td>
    <td><?= $p['stock_actual'] ?></td>
    <td><?= $p['almacen'] ?></td>
    <td><?= $p['estado'] ?></td>
    <td><?= $p['last_user'] ?? '-' ?></td>
    <td>
        <a href="productos_view.php?id=<?= $p['id'] ?>">Ver</a> | 
        <a href="productos_edit.php?id=<?= $p['id'] ?>">Editar</a> | 
        <a href="productos_delete.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar producto?');">Eliminar</a> |

    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
