<?php

    require_once "../Core/confGeneral.php";

    if (!isset($_GET['Token'])) {
        session_start();
        session_destroy();
        ?>
            <script>
                window.location.href = '<?=SERVER?>';
            </script>
        <?php
        die();
    } else {
        require_once RUTACONTROL . 'sesion-controlador.php';

        $l = new SesionControl();
        echo $l -> cerrarSesionControl();
    }


