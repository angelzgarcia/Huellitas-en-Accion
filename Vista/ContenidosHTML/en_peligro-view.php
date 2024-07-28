<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php

    $encontrados = [
        0 => RUTARECURSOS . "IMG/michael-g-lQo3-AYDLag-unsplash-removebg-preview.png",
        1 => RUTARECURSOS . "IMG/michael-g-JTa8B9KMQ5Y-unsplash-removebg-preview.png",
        2 => RUTARECURSOS . "IMG/michael-g-dJsfHhftDtA-unsplash-removebg-preview.png",
        3 => RUTARECURSOS . "IMG/michael-g-qpL2eyXbkcI-unsplash-removebg-preview.png",
        4 => RUTARECURSOS . "IMG/michael-g-3KCbGZGtShI-unsplash-removebg-preview.png"
    ];

    $banner = $encontrados[rand(0, count($encontrados)-1)];
    require_once SERVERURL . "Controlador/feed-controlador.php";
?>
<body class="body-index">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER EN PELIGRO -->
        <div class="banner-encontrados-container banner-en-peligro" style="background-image: linear-gradient(rgba(0,0,0,0.2) 100%, rgba(0,0,0,0.1)), url(<?=$banner?>), linear-gradient(140deg, #f33533, #fc6a5d, #850208);">
            <!-- IMG -->
            <h1>En peligro</h1>
        </div>


        <!-- FILTRO -->
        <?php include_once RUTAMODULOS . "filtro.php"; ?>

        <!-- ORGANIZACIONES VISTA / CONTENIDO -->
        <div class="en-peligro-container filtradosContainer">
            <!-- PUBLICACION -->
            <?php
                $posts = new FeedControlador();
                $posts -> listarFeedControlador($_GET['views'], '');
            ?>
        </div>


        <!-- PIE DE PAGINA -->
        <?php include_once RUTAMODULOS . "footer.php"; ?>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- BORON GO UP -->
        <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

    </main>
</body>
</html>
