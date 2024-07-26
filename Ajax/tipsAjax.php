
    <?php

        require_once '../Core/confGeneral.php';
        session_start(['name' => 'HA-A']);

        if (!isset($_SESSION["tipoU"]) || $_SESSION["tipoU"] != "Administrador")  {
            session_destroy();
            header("Location:" . SERVER );
            exit();
        }

        require_once RUTACONTROL . 'crud-controlador.php';

        $crudTips = new CrudControlador();
        echo $crudTips -> crudTipsControl();
