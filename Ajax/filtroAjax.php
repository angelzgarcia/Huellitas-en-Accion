
<!DOCTYPE html>
<html lang="en">
<?php
    require_once "../Core/confGeneral.php";
    session_start(['name' => 'HA-A']);

    if ($_SERVER['REQUEST_METHOD'] != 'POST'):
        session_destroy();
        header('Location: ' . SERVER);
        exit();

    else:
        // include_once RUTAMODULOS . 'head.php';
        require_once RUTACONTROL . "feed-controlador.php";

        $s = new FeedControlador();
        echo $s->filtrarFeedControlador();
    endif;
