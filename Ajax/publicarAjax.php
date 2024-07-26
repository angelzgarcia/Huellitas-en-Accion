

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
        include_once RUTAMODULOS . 'head.php';
        require_once RUTACONTROL . 'publicar-controlador.php';
?>
<body>
    <?php
        $post = new PublicarControlador();
        echo $post -> publicarControlador();
    ?>
</body>
</html>
<?php endif; ?>
