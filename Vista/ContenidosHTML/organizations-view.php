<?php

    require_once RUTACONTROL . 'organizaciones-controlador.php';
    $targets = new OrganizacionesControl();
    $gatos = [
        0 => RUTARECURSOS . 'IMG/pacto-visual-cWOzOnSoh6Q-unsplash.jpg',
        1 => RUTARECURSOS . 'IMG/federica-diliberto-KEXUeZIev10-unsplash.jpg',
        // 2 => RUTARECURSOS . 'IMG/mikhail-vasilyev-Qmox1MkYDnY-unsplash.jpg',
        2 => RUTARECURSOS . 'IMG/diana-parkhouse-uqxHIVMyvJ4-unsplash.jpg'
    ];
    $gato = $gatos[rand(0, count($gatos)-1)];

?>

<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<body class="body-index">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php require_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER DE ORGANIZACIONES -->
        <div class="banner-organizations" style="background-image: linear-gradient(30deg, rgba(0, 0, 0, 0.484) 30%, rgba(0, 0, 0, 0.2)), url(<?=$gato?>);" loading="lazy">
            <h1 class="org-title">Organizaciones</h1>
        </div>

        <!-- TARJETA DE ORGANIZACION -->
        <?php $targets -> listarOrganizacionesControl(); ?>

        <!-- PIE DE PAGINA -->
        <?php require_once RUTAMODULOS . "footer.php"; ?>

        <!-- BARRA LATERAL -->
        <?php require_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- BOTON GO UP -->
        <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

    </main>
</body>
</html>

