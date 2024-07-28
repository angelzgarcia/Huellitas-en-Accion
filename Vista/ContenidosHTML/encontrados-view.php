<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    $encontrados = [
        0 => RUTARECURSOS . "IMG/michael-g-f7afljn7OKA-unsplash-removebg-preview.png",
        1 => RUTARECURSOS . "IMG/michael-g-a9gHgNJ-dNY-unsplash-removebg-preview.png",
        2 => RUTARECURSOS . "IMG/michael-g-zt3VQWIapP8-unsplash-removebg-preview.png",
        3 => RUTARECURSOS . "IMG/michael-g-HoytTYgj7tI-unsplash-removebg-preview.png",
        4 => RUTARECURSOS . "IMG/michael-g-EaN3IBTbBdk-unsplash-removebg-preview.png",
        5 => RUTARECURSOS . "IMG/michael-g-S7Q6iQJgxS4-unsplash-removebg-preview.png",
        6 => RUTARECURSOS . "IMG/michael-g-kpbHRhlSHHA-unsplash-removebg-preview.png",
    ];

    $banner = $encontrados[rand(0, count($encontrados)-1)];
    require_once SERVERURL . "Controlador/feed-controlador.php";
?>
<body class="body-index">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER ENCONTRADOS -->
        <div class="banner-encontrados-container" style="background-image: linear-gradient(rgba(0,0,0,0.2) 100%, rgba(0,0,0,0.1)), url(<?=$banner?>), linear-gradient(140deg, #99bad9, #3f70a1, #1d4c76);">
            <!-- IMG -->
            <h1>Encontrados</h1>
        </div>

        <!-- FILTRO DE BUSQUEDA -->
        <?php include_once RUTAMODULOS . "filtro.php"; ?>

        <!-- TARJETAS ENCONTRADOS -->
        <div class="encontrados-container filtradosContainer">
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
