<?php

    require_once "../Core/confGeneral.php";

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        session_destroy();
        header('Location: ' . SERVER . 'loggin-form');
        exit();
    } else {
        $requeridos = ['correo', 'pass'];

        foreach ($requeridos as $requerido) {
            if (empty($_POST[$requerido])) {
                ?>
                    <script>
                        Swal.fire({
                            position: "top-end",
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

        require_once RUTACONTROL . "sesion-controlador.php";

        $s = new SesionControl();
        echo $s->iniciarSesionControl();
    }

?>

