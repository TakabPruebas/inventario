<?php
require_once __DIR__ . '/../../helpers/Session.php';
Session::requireLogin();
$role = $_SESSION['role'];

// Calcula valor total del inventario
$valorInventario = array_sum(array_map(fn($p) => $p['valor_total'] ?? 0, $productos));

// Para mantener búsqueda y filtro
$q = htmlspecialchars($_GET['q'] ?? '');
$cat = htmlspecialchars($_GET['cat'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario | TAKAB</title>
    <link rel="stylesheet" href="../public/assets/css/inventario.css">
    <link rel="stylesheet" href="../public/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="main-inv-layout">
        <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="login-logo"><img src="../public/assets/images/icono_takab.png" alt="logo_TAKAB" width="90" height="55""></div>
            <div>
                <div class="sidebar-title">TAKAB</div>
                <div class="sidebar-desc">Dashboard</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
            <?php if ($role === 'Administrador'): ?>
                <a href="usuarios.php"><i class="fa-solid fa-users-cog"></i> Gestión de Usuarios</a>
                <a href="productos.php"><i class="fa-solid fa-boxes-stacked"></i> Gestión de Productos</a>
                <a href="inventario_actual.php" class="active"><i class="fa-solid fa-list-check"></i> Inventario</a>
                <a href='revisar_solicitudes.php'><i class="fa-solid fa-comment-medical"></i>Solicitudes de Material</a>
                <a href="reportes.php"><i class="fa-solid fa-chart-line"></i> Reportes</a>
                <a href="configuracion.php"><i class="fa-solid fa-gear"></i> Configuración</a>

            <?php elseif ($role === 'Almacen'): ?>
                <a href="productos.php"><i class="fa-solid fa-boxes-stacked"></i> Gestión de Productos</a>
                <a href="solicitudes.php"><i class="fa-solid fa-inbox"></i> Gestionar Solicitudes</a>
                <a href='revisar_solicitudes.php'>Solicitudes de Material</a>
                <a href="configuracion_almacen">Configuración</a>

            <?php elseif ($role === 'Empleado'): ?>
                <a href="solicitudes_crear.php"><i class="fa-solid fa-plus-square"></i> Solicitar Material</a>
                <a href="mis_solicitudes.php"><i class="fa-solid fa-clipboard-list"></i> Mis Solicitudes</a>
                <a href='solicitar_material_general.php'><i class="bi bi-gear"></i> Solicitar Material/Herramienta General</a>


                <?php endif; ?>
            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión</a>
        </nav>
    </aside>
    <div class="inv-content">
<div class="inv-header">
    <!-- Columna izquierda -->
    <div>
        <div class="inv-title">Gestión de Inventario</div>
        <div class="inv-desc">Control de stock y movimientos de inventario</div>
    </div>

    <!-- Columna derecha: botones -->
    <?php if ($role === 'Administrador' || $role === 'Almacen'): ?>
    <div class="inv-summary-cards">
        <a href="inventario_entradas.php" class="btn-principal">
            <i class="fa fa-plus"></i> Entrada de Inventario
        </a>
        <a href="inventario_salidas.php" class="btn-secundario">
            <i class="fa fa-minus"></i> Salida de Inventario
        </a>
    </div>
    <?php endif; ?>
</div>

        <!-- Cards resumen -->
        <div class="inv-summary-cards">
            <div class="inv-card">
                <div class="inv-card-label">Total Productos</div>
                <div class="inv-card-value"><?= count($productos) ?></div>
                <div class="inv-card-icon inv-card-icon-products"><i class="fa fa-cube"></i></div>
            </div>
            <div class="inv-card">
                <div class="inv-card-label">Stock Bajo</div>
                <div class="inv-card-value">
                    <?= count(array_filter($productos, fn($p) => $p['stock_actual'] < $p['stock_minimo'])) ?>
                </div>
                <div class="inv-card-icon inv-card-icon-alert"><i class="fa fa-exclamation-triangle"></i></div>
            </div>
            <div class="inv-card">
                <div class="inv-card-label">Valor Total</div>
                <div class="inv-card-value">
                    $<?= number_format($valorInventario, 2) ?>
                </div>
                <div class="inv-card-icon inv-card-icon-money"><i class="fa fa-dollar-sign"></i></div>
            </div>
            <!-- Puedes agregar otros cards si lo necesitas -->
        </div>

        <!-- Buscador y filtro avanzado -->
        <form method="get" class="inv-tools-bar" style="display: flex; gap: 10px;">
            <div class="inv-search">
                <i class="fa fa-search"></i>
                <input type="text" name="q" placeholder="Buscar productos..." value="<?= $q ?>">
            </div>
            <select class="inv-select-cat" name="cat" onchange="this.form.submit()">
                <option value="">Todas las categorías</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= htmlspecialchars($categoria) ?>" <?= $categoria === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>

        <!-- Tabla -->
        <div class="inv-table-wrap">
            <table class="inv-table">
                <thead>
    <tr>
        <th>Código</th>
        <th>Producto</th>
        <th>Categoría</th>
        <th>Stock Total</th>
        <th>Stock Mínimo</th>
        <th>Estado</th>
        <th>Valor Total</th>
        <th>Último Movimiento</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($productos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['codigo'] ?? '') ?></td>
            <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
            <td><?= htmlspecialchars($p['categoria'] ?? '') ?></td>
            <td><?= (int)$p['stock_actual'] . ' ' . htmlspecialchars($p['unidad'] ?? '') ?></td>
            <td><?= (int)$p['stock_minimo'] . ' ' . htmlspecialchars($p['unidad'] ?? '') ?></td>
            <td>
                <?php if ($p['stock_actual'] < $p['stock_minimo']): ?>
                    <span class="badge badge-critico">crítico</span>
                <?php else: ?>
                    <span class="badge badge-normal">normal</span>
                <?php endif; ?>
            </td>
            <td>$<?= number_format($p['valor_total'] ?? 0, 2) ?></td>
            <td>
                <?= $p['ultimo_movimiento'] 
                    ? date('d-m-Y H:i', strtotime($p['ultimo_movimiento'])) 
                    : '-' ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

            </table>
        </div>
    </div>
</div>
</body>
</html>
