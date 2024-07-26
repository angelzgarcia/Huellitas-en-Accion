<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    require_once RUTACONTROL . 'noticias-controlador.php';
    $targets = new NoticiasControlador();
?>
<body class="body-index">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER BLOG -->
        <div class="banner-blog">
            <h1>BL<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="100px"  width="100px" fill="#fff" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200q0-33 23.5-56.5T200-280q33 0 56.5 23.5T280-200q0 33-23.5 56.5T200-120Zm480 0q0-117-44-218.5T516-516q-76-76-177.5-120T120-680v-120q142 0 265 53t216 146q93 93 146 216t53 265H680Zm-240 0q0-67-25-124.5T346-346q-44-44-101.5-69T120-440v-120q92 0 171.5 34.5T431-431q60 60 94.5 139.5T560-120H440Z"/></svg>G</h1>
        </div>

        <!-- CONTENEDOR DE NOTICIAS -->
        <div class="blog-view-container">
            <!-- NOTICIA -->
            <?= $targets->listarTipsControl(); ?>
        </div>


        <!-- PIE DE PAGINA -->
        <?php include_once RUTAMODULOS . "footer.php"; ?>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- BOTON GO UP -->
        <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

    </main>
</body>
</html>
