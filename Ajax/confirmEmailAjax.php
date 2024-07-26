

<?php

    require_once "../Core/confGeneral.php";
    require_once "../Controlador/confirm_email-controlador.php";

    $c = new ConfirmarEmailControlador();
    $c->verificarEmail();


