<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador') :
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    else:
        require_once RUTACONTROL . 'crud-controlador.php';
        $pagina = explode('/', $_GET['views']);
        $tabla = new CrudControlador();
?>
<body class="admin-index">
    <main class="content-page content-page-admin">

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- CONTENEDOR DE LA TABLA -->
        <div class="tables-contaniner table-locations">
            <!-- TABLA -->
            <?php $tabla -> listarUbicacionesControl($pagina[1] ?? 1, 10, '') ?>
        </div>

        <!-- BOTON DE REGRESO -->
        <div class="back-icon bi-admin bb-locations" id="logo-image">
            <a href="<?= SERVER ?>admin_dashboard" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
            </a>
        </div>

    </main>
</body>
</html>
<?php endif; ?>
