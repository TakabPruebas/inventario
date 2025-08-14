<?php
require_once __DIR__ . '/../app/helpers/Session.php';
Session::requireLogin();

$role = $_SESSION['role'];
$nombre = $_SESSION['nombre'];

// SIMULACIÓN DE DATOS, AJUSTA SEGÚN TU LÓGICA
$totalProductos = 0;
$stockBajo = 0;
$solicitudesPendientes = 0;
$herramientasPrestadas = 0;
$valorTotalInventario = 0.00;
$alertas = [
    ["Cable UTP Cat6 por debajo del stock mínimo", "20-07-2025", "alta"]
];

// DATOS PARA ALMACÉN
$solicitudesAlmacen = 0;
$productosAlmacen = 0;

// DATOS PARA EMPLEADO
$solicitudesMias = 0;
$pendientesAprobar = 0;
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - TAKAB</title>
    <link rel="stylesheet" href="../public/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="main-layout">
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
            <a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
            <?php if ($role === 'Administrador'): ?>
                <a href="usuarios.php"><i class="fa-solid fa-users-cog"></i> Gestión de Usuarios</a>
                <a href="productos.php"><i class="fa-solid fa-boxes-stacked"></i> Gestión de Productos</a>
                <a href="inventario_actual.php"><i class="fa-solid fa-list-check"></i> Inventario</a>
                <a href='revisar_solicitudes.php'><i class="fa-solid fa-comment-medical"></i>Solicitudes de Material</a>
                <a href="reportes.php"><i class="fa-solid fa-chart-line"></i> Reportes</a>
                <a href="configuracion.php"><i class="fa-solid fa-gear"></i> Configuración</a>



            <?php elseif ($role === 'Almacen'): ?>
                <a href="productos.php"><i class="fa-solid fa-boxes-stacked"></i> Gestión de Productos</a>
                <a href="solicitudes.php"><i class="fa-solid fa-inbox"></i> Gestionar Solicitudes</a>
                <a href='revisar_solicitudes.php'><i class="fa-solid fa-comment-medical"></i>Solicitudes de Material</a>
                <a href="configuracion.php"><i class="fa-solid fa-gear"></i> Configuración</a>

            <?php elseif ($role === 'Empleado'): ?>
                <a href="solicitudes_crear.php"><i class="fa-solid fa-plus-square"></i> Solicitar Material para Servicio</a>
                <a href='solicitar_material_general.php'><i class="fa-solid fa-comment-medical"></i> Solicitar Material en General</a>
                <a href="mis_solicitudes.php"><i class="fa-solid fa-clipboard-list"></i> Mis Solicitudes</a>


                <?php endif; ?>
            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión</a>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <div class="content-area">
        <!-- Header superior -->
        <header class="top-header">
            <div></div>
            <div class="top-header-user">
                <span><?php echo htmlspecialchars($nombre); ?> (<?php echo htmlspecialchars($role); ?>)</span>
                <a href="prueba_Hash.php"><i class="fa-solid fa-user-circle"></i></a>
                <a href="logout.php" class="logout-btn" title="Cerrar sesión"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </header>

        <main class="dashboard-main">
            <div class="dashboard-header-row">
                <div>
                    <h1>
                        <?php
                        if ($role === 'Administrador') echo "Dashboard Administrativo";
                        elseif ($role === 'Almacen') echo "Dashboard Almacén";
                        elseif ($role === 'Empleado') echo "Dashboard Empleado";
                        ?>
                    </h1>
                    <span class="dashboard-desc">
                        <?php
                        if ($role === 'Administrador') echo "Resumen general del sistema de inventario TAKAB";
                        elseif ($role === 'Almacen') echo "Panel para gestión de productos y solicitudes";
                        elseif ($role === 'Empleado') echo "Panel personal de solicitudes y requisiciones";
                        ?>
                    </span>
                </div>
                <div class="dashboard-updated">
                    <div>Último actualizado</div>
                    <div><?php echo date('d/m/Y, h:i:s a'); ?></div>
                </div>
            </div>

            <!-- Tarjetas resumen según rol -->
            <section class="dashboard-cards-row">
                <?php if ($role === 'Administrador'): ?>
                    <div class="dashboard-card blue">
                        <div class="card-label">Total Productos</div>
                        <div class="card-value"><?php echo $totalProductos; ?></div>
                        <div class="card-sub">En ambos almacenes</div>
                    </div>
                    <div class="dashboard-card red">
                        <div class="card-label">Stock Bajo</div>
                        <div class="card-value"><?php echo $stockBajo; ?></div>
                        <div class="card-sub">Requieren restock</div>
                    </div>
                    <div class="dashboard-card yellow">
                        <div class="card-label">Solicitudes Pendientes</div>
                        <div class="card-value"><?php echo $solicitudesPendientes; ?></div>
                        <div class="card-sub">Por aprobar</div>
                    </div>
                    <div class="dashboard-card sky">
                        <div class="card-label">Herramientas Prestadas</div>
                        <div class="card-value"><?php echo $herramientasPrestadas; ?></div>
                        <div class="card-sub">En campo</div>
                    </div>
                <?php elseif ($role === 'Almacen'): ?>
                    <div class="dashboard-card blue">
                        <div class="card-label">Total Productos</div>
                        <div class="card-value"><?php echo $productosAlmacen; ?></div>
                        <div class="card-sub">En almacén</div>
                    </div>
                    <div class="dashboard-card yellow">
                        <div class="card-label">Solicitudes Pendientes</div>
                        <div class="card-value"><?php echo $solicitudesAlmacen; ?></div>
                        <div class="card-sub">Por gestionar</div>
                    </div>
                <?php elseif ($role === 'Empleado'): ?>
                    <div class="dashboard-card blue">
                        <div class="card-label">Mis Solicitudes</div>
                        <div class="card-value"><?php echo $solicitudesMias; ?></div>
                        <div class="card-sub">Enviadas</div>
                    </div>
                    <div class="dashboard-card yellow">
                        <div class="card-label">Pendientes de Aprobación</div>
                        <div class="card-value"><?php echo $pendientesAprobar; ?></div>
                        <div class="card-sub">Por aprobar</div>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Widgets/alertas: solo admin y almacén -->
            <?php if ($role === 'Administrador' || $role === 'Almacen'): ?>
                <section class="dashboard-widget">
                    <div class="widget-title blue"><i class="fa-solid fa-wallet"></i>
                        Valor Total del Inventario
                    </div>
                    <div class="widget-value">$<?php echo number_format($valorTotalInventario, 2); ?></div>
                    <div class="widget-desc">Valor estimado de todos los productos en inventario</div>
                </section>
                <section class="dashboard-widget">
                    <div class="widget-title red"><i class="fa-solid fa-bell"></i> Alertas del Sistema</div>
                    <div class="widget-desc">Elementos que requieren atención inmediata</div>
                    <div class="alertas-list">
                        <?php foreach ($alertas as $a): ?>
                            <div class="alerta-row">
                                <span class="alerta-text"><?php echo $a[0]; ?></span>
                                <span class="alerta-date"><?php echo $a[1]; ?></span>
                                <span class="alerta-badge <?php echo $a[2]; ?>"><?php echo $a[2]; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php elseif ($role === 'Empleado'): ?>
                <section class="dashboard-widget">
                    <div class="widget-title sky"><i class="fa-solid fa-info-circle"></i> Información</div>
                    <div class="widget-desc">Puedes solicitar material y revisar el estado de tus solicitudes desde este panel.</div>
                </section>
            <?php endif; ?>
        </main>
    </div>
</div>
</body>
</html>
