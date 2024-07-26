<?php

    require_once "./Core/confGeneral.php";
    require_once "./Core/mainModelo.php";
    require_once RUTACONTROL . "vistasControl.php";
    $layout = new VistasControl;
    $layout -> obtenerLayout();
