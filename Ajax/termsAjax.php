

<?php
    require_once '../Core/confGeneral.php';
    require_once SERVERURL . 'Core/mainModelo.php';
    $d = new MainModel();
    $pdf = $d->decryption($_GET['file']);
    $rnd = $d->decryption($_GET['rnd']);
    session_start(['name' => 'HA-A']);

    if (!isset($_GET['file']) && !isset($_GET['rnd']) && $pdf != 'Vista/Recursos/PDF/TERMINOS-Y-CONDICIONES-DE-USO-HUELLITAS-EN-ACCION.pdf' && $rnd != $_GET['rnd'])  {
        session_destroy();
        header("Location:" . SERVER );
        exit;
    }


    echo "hola";
    header('Content-Type: application/pdf');
    // header("Location". SERVER . 'Vista/Recursos/PDF/GUIA-DEL-HUMANO.pdf');
    header('Content-Disposition: inline; filename="' . basename(SERVER . 'Vista/Recursos/PDF/TERMINOS-Y-CONDICIONES-DE-USO-HUELLITAS-EN-ACCION.pdf') . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    readfile(SERVER . 'Vista/Recursos/PDF/TERMINOS-Y-CONDICIONES-DE-USO-HUELLITAS-EN-ACCION.pdf');
    exit;

