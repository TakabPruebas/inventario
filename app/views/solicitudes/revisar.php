<?php
require_once __DIR__ . '/../../helpers/Session.php';
Session::requireLogin(['Administrador', 'Almacen']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes por Revisar / Entregar | TAKAB</title>
    <link rel="stylesheet" href="../public/assets/css/solicitudes-revisar.css">
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
            <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a href="usuarios.php"><i class="fa-solid fa-users-cog"></i> Gestión de Usuarios</a>
                <a href="productos.php"><i class="fa-solid fa-boxes-stacked"></i> Gestión de Productos</a>
                <a href="inventario_actual.php"><i class="fa-solid fa-list-check"></i> Inventario</a>
                <a href='revisar_solicitudes.php' class="active"><i class="fa-solid fa-comment-medical"></i>Solicitudes de Material</a>
                <a href='prestamos_pendientes.php'>Préstamos Pendientes</a>
                <a href='prestamos_historial.php'>Historial de Préstamos</a>
                <a href="reportes.php"><i class="fa-solid fa-chart-line"></i> Reportes</a>
                <a href="configuracion.php"><i class="fa-solid fa-gear"></i> Configuración</a>

            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión</a>
        </nav>
    </aside>
<div class="revisar-main">
    <div class="revisar-title">
        <i class="fa-solid fa-clipboard-check"></i>
        Solicitudes por Revisar / Entregar
    </div>
    <table class="takab-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Solicitante</th>
                <th>Tipo de Solicitud</th>
                <th>Motivo/Destino</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitudes as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['fecha_solicitud']) ?></td>
                    <td><?= htmlspecialchars($s['usuario']) ?></td>
                    <td><?= htmlspecialchars($s['tipo_solicitud']) ?></td>
                    <td><?= htmlspecialchars($s['comentario']) ?></td>
                    <td>
                        <?php
                            $estado = strtolower($s['estado']);
                            $clase = match($estado) {
                                'pendiente' => 'badge-pendiente',
                                'aprobada' => 'badge-aprobada',
                                'entregada' => 'badge-entregada',
                                'cancelada' => 'badge-cancelada',
                                'rechazada' => 'badge-rechazada',
                                default => 'badge'
                            };
                            echo "<span class='badge $clase'>" . ucfirst(htmlspecialchars($s['estado'])) . "</span>";
                        ?>
                    </td>
                    <td>
                        <?php if ($s['estado'] == 'pendiente'): ?>
                            <a href="solicitud_aprobar.php?id=<?= $s['id'] ?>" class="btn-accion aprobar">
                                <i class="fa fa-gavel"></i> Aprobar / Rechazar
                            </a>
                        <?php elseif ($s['estado'] == 'aprobada'): ?>
                            <a href="solicitud_entregar.php?id=<?= $s['id'] ?>" class="btn-accion entregar">
                                <i class="fa fa-truck"></i> Entregar
                            </a>
                        <?php else: ?>
                            <span class="badge badge-gray">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
    </div>
</body>
</html>
