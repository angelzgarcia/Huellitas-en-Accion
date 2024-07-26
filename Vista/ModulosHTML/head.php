<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Digital_Solutions/Core/confGeneral.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <link rel="shortcut icon" href="<?=RUTARECURSOS?>IMG/favicon_32x32.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= CSS ?>?v=<?= htmlspecialchars(CSS) . rand(0,99999) ?>">
    <link rel="stylesheet" href="<?= CSSADMIN ?>?v=<?= htmlspecialchars(CSSADMIN) . rand(0,99999) ?>">
    <link rel="stylesheet" href="<?= FONTS ?>?v=<?= htmlspecialchars(FONTS) . rand() ?>">
    <link rel="stylesheet" href="<?= MEDIAS ?>?v=<?= htmlspecialchars(MEDIAS) . rand(0, 999999) ?>">
    <script src="<?= JS ?>?j=<?= rand() ?>" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script async defer src="https://accounts.google.com/gsi/client"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I&callback=initMap"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <!-- TEMA OSCURO SWEET ALERT-->
    <?php
        if (isset($_SESSION['tipoU']) && !empty($_SESSION['token']) && $_SESSION['tipoU'] == 'Administrador') {
            ?>
                <link rel="stylesheet" href="<?=SERVER?>node_modules/@sweetalert2/theme-dark/dark.css">
                <script src="<?=SERVER?>node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
            <?php
        }
    ?>
    <title>
        <?= isset($_GET['views']) ? PROYECT . ' | ' . ucwords(str_replace(["-","_"], " ", $_GET['views'])) : PROYECT  ?>
    </title>
</head>
