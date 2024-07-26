
<!DOCTYPE html>
<html lang="en">
<?php
    require_once  $_SERVER['DOCUMENT_ROOT'] . "/Digital_Solutions/Core/confGeneral.php";
    $fotos = [
        0 => RUTARECURSOS . "/IMG/karsten-winegeart-IeT84oak7HQ-unsplash.jpg",
        1 => RUTARECURSOS . "IMG/matthew-henry-U5rMrSI7Pn4-unsplash.jpg",
        2 => RUTARECURSOS . "IMG/justin-veenema-3s3oSch5f1c-unsplash.jpg",
        3 => RUTARECURSOS . "IMG/antonino-visalli-itBudJaqFbQ-unsplash.jpg",
        4 => RUTARECURSOS . "IMG/wren-meinberg-AL2-t0GrSko-unsplash.jpg"
    ];
    $foto = $fotos[rand(0,4)];
?>
<body class="" style="margin: 0;">
<main class="">
    <!-- ENCABEZADO -->
    <header class="hero">
        <div class="nav-hero" id="hero" style="width: 100vw; background-color: transparent;">

            <a href="<?= SERVER ?>">
                <div class="logo-image" id="logo-image" style="border-radius: 0;">
                </div>
            </a>

            <div class="bottons-hero-containt" style="text-align: center;" >
                <div class="botton-hero">
                    <a href="<?=SERVER?>en_adopcion" data-tooltip="Adopta"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000" loading="lazy"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></a>
                </div>

                <div class="botton-hero">
                    <a href="<?= SERVER ?>emergencia" data-tooltip="Reporta una emergencia">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed" loading="lazy"><path d="M200-160v-80h64l79-263q8-26 29.5-41.5T420-560h120q26 0 47.5 15.5T617-503l79 263h64v80H200Zm148-80h264l-72-240H420l-72 240Zm92-400v-200h80v200h-80Zm238 99-57-57 142-141 56 56-141 142Zm42 181v-80h200v80H720ZM282-541 141-683l56-56 142 141-57 57ZM40-360v-80h200v80H40Zm440 120Z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed" loading="lazy"><path d="M194-80v-395h80v315h280v-193l105-105q29-29 45-65t16-77q0-40-16.5-76T659-741l-25-26-127 127H347l-43 43-57-56 67-67h160l160-160 82 82q40 40 62 90.5T800-600q0 57-22 107.5T716-402l-82 82v240H194Zm197-187L183-475q-11-11-17-26t-6-31q0-16 6-30.5t17-25.5l84-85 124 123q28 28 43.5 64.5T450-409q0 40-15 76.5T391-267Z"/></svg>
                    </a>
                </div>

                <div class="botton-hero">
                    <a href="<?= SERVER ?>organizations" data-tooltip="Organizaciones"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000" loading="lazy"><path d="M420-280h120v-100h100v-120H540v-100H420v100H320v120h100v100ZM160-120v-480l320-240 320 240v480H160Zm80-80h480v-360L480-740 240-560v360Zm240-270Z"/></svg></a>
                </div>
            </div>

            <!-- BOTON LOGIN -->
            <?php
                if (!isset($_SESSION['tipoU'])) {
                    ?>
                        <div class="loggin-icon" id="loggin-icon">
                            <a href="<?= SERVER ?>loggin-form" data-tooltip="Inicia sesion">
                                <i class="fa-solid fa-user"></i>
                            </a>
                        </div>
                    <?php
                }
            ?>

        </div>
    </header>

    <div class="container-404" style="background-image: url(<?=$foto?>);">

        <div class="error">
            <p>
                ¡Oh no! Página
            </p>
            <p>
                no encontrada
            </p>
            <p>
                Lamentablemente te perdiste...
            </p>
            <p>
                Te ayudamos a regresar al inicio.
            </p>
        </div>

        <div class="button-index">
            <a href="<?=SERVER?>"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
        </div>

    </div>

</main>
</body>
</html>
