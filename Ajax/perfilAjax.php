
<!DOCTYPE html>
<html lang="en">
<?php
    require_once "../Core/confGeneral.php";
    session_start(['name' => 'HA-A']);

    if ($_SERVER['REQUEST_METHOD'] != 'POST' || ($_SESSION['tipoU'] != 'Usuario' && $_SESSION['tipoU'] != 'Administrador')):
        session_destroy();
        header('Location: ' . SERVER);
        exit();

    else:
        // include_once RUTAMODULOS . 'head.php';
        require_once RUTACONTROL . 'perfil-controlador.php';
?>
<body>
    <?php
        $post = new PerfilControlador();
        echo $post -> crudPostControlador();
    ?>
</body>
</html>
<?php endif; ?>
