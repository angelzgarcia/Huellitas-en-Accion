<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php require_once SERVERURL . "Controlador/feed-controlador.php"; ?>
<body class="body-index">
    <main class="content-page">

            <!-- HEADER -->
            <?php require_once RUTAMODULOS . 'header.php'; ?>

            <!-- FILTRO DE BUSQUEDA -->
            <?php require_once RUTAMODULOS . 'filtro.php'; ?>

            <div class="feed-container">

                <?php
                    $posts = new FeedControlador();
                    $posts -> listarFeedControlador('');
                ?>

            </div>

            <!-- FOOTER -->
            <?php require_once RUTAMODULOS . 'footer.php' ?>

            <!-- SIDEBAR -->
            <?php require_once RUTAMODULOS . 'sidebar.php' ?>

            <!-- BORON GO UP -->
            <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

    </main>
</body>
</html>
