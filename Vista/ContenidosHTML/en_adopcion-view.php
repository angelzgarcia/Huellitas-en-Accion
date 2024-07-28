<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php

    $encontrados = [
        0 => RUTARECURSOS . "IMG/michael-g-KuDi137PY4I-unsplash-removebg-preview.png",
        1 => RUTARECURSOS . "IMG/michael-g-5jsyOKc70UY-unsplash-removebg-preview.png",
        2 => RUTARECURSOS . "IMG/michael-g-r8eIu4bifwA-unsplash-removebg-preview.png",
        3 => RUTARECURSOS . "IMG/michael-g-vRk7F5Pw7FQ-unsplash-removebg-preview.png",
        4 => RUTARECURSOS . "IMG/michael-g-BKIqOSyburQ-unsplash-removebg-preview.png",
        5 => RUTARECURSOS . "IMG/michael-g-Lh6277yyRjw-unsplash-removebg-preview.png",
        6 => RUTARECURSOS . "IMG/michael-g-cdNFUE406lA-unsplash-removebg-preview.png"
    ];

    $banner = $encontrados[rand(0, count($encontrados)-1)];
    require_once SERVERURL . "Controlador/feed-controlador.php";
?>
<body class="body-index">
    <main class="content-page">

        <!-- HEADER -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER EN ADOPCION -->
        <div class="banner-encontrados-container banner-en-adopcion" style="background-image: linear-gradient(rgba(0,0,0,0.2) 100%, rgba(0,0,0,0.1)), url(<?=$banner?>), linear-gradient(140deg, #479130, #59b73c, #2e5d1f);">
            <!-- IMG -->
            <h1>En adopcion</h1>
        </div>

        <!-- FILTRO DE BUSQUEDA -->
        <?php include_once RUTAMODULOS . "filtro.php"; ?>

        <!-- ORGANIZACIONES VISTA / CONTENIDO -->
        <div class="en-adopcion-container filtradosContainer">
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
