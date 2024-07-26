
<!DOCTYPE html>
<html lang="en">
<?php
    require_once '../Core/confGeneral.php';
    session_start(['name' => 'HA-A']);

    if (!isset($_SESSION["tipoU"]) || $_SESSION["tipoU"] != "Administrador")  {
        session_destroy();
        header("Location:" . SERVER );
        exit();
    }

    require_once RUTACONTROL . 'crud-controlador.php';
?>
<body>
    <?php
        $crudAnimales = new CrudControlador();
        echo $crudAnimales -> crudAnimalesControl();
    ?>
</body>
</html>

