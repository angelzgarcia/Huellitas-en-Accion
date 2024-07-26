<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    $encontrados = [
        0 => RUTARECURSOS . "IMG/michael-g-7FlGZBB8Jbw-unsplash-removebg-preview.png",
        1 => RUTARECURSOS . "IMG/michael-g-C9EU8mfevv0-unsplash-removebg-preview.png",
        2 => RUTARECURSOS . "IMG/michael-g-gNhiKRh9FNE-unsplash-removebg-preview.png",
        3 => RUTARECURSOS . "IMG/michael-g-LSGI3bCX-uw-unsplash-removebg-preview.png",
        4 => RUTARECURSOS . "IMG/michael-g-b96ckI3XPts-unsplash-removebg-preview.png"
    ];

    $banner = $encontrados[rand(0, count($encontrados)-1)];
    require_once SERVERURL . "Controlador/feed-controlador.php";
?>
<body class="body-index">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER PERDIDOS -->
        <div class="banner-encontrados-container banner-perdidos" style="background-image: linear-gradient(rgba(0,0,0,0.2) 100%, rgba(0,0,0,0.1)), url(<?=$banner?>), linear-gradient(140deg, #fbd214, #fedb37, #956a03);">
            <h1>Perdidos</h1>
        </div>

        <!-- ORGANIZACIONES VISTA / CONTENIDO -->
        <?php include_once RUTAMODULOS . "filtro.php"; ?>


        <!-- TARJETAS PERIDOS -->
        <div class="perdidos-container">
            <!-- PUBLICACION -->
            <?php
                $posts = new FeedControlador();
                $posts -> listarFeedControlador('perdidos');
            ?>
        </div>


        <!-- PIE DE PAGINA -->
        <?php include_once RUTAMODULOS . "footer.php"; ?>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

    </main>
</body>
</html>
