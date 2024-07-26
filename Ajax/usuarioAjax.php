
<?php

    require_once "../Core/confGeneral.php";

    if ($_SERVER['REQUEST_METHOD'] != 'POST' ) {
        session_destroy();
        header('Location: ' . SERVER);
        exit();

    } else {
        $requeridos = ['nombre','apellidos','numero','correo','pass','confPass','genero','termCond',];

        foreach ($requeridos as $requerido) {
            if (empty($_POST[$requerido])) {
                ?>
                    <script>
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "¡Hay campos vacíos!",
                            text: "Completa el formulario para continuar",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                <?php
                die();
            }
        }
    }

    require_once RUTACONTROL . "usuario-controlador.php";

    $u = new UsuarioControl();
    $alert = $u -> crearUsuarioControl();

?>

    <!DOCTYPE html>
    <html lang="en">
    <?php include_once RUTAMODULOS . 'head.php' ?>
    <body>
        <?=$alert?>
    </body>
    </html>

