<?php
    $bg = !isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador' ? '#f5ebeb' : '#080808';
?>

<!-- ENCABEZADO -->
<header class="hero">
    <!-- CONTENEDOR BARRA DE NAVEGACION -->
    <div class="nav-hero" id="hero" style="background-color: <?=$bg?>;">

        <!-- LOGO -->
        <a href="<?= isset($_GET['views']) && $_GET['views'] != 'index' ? SERVER : '#ha'; ?>">
            <div class="logo-image" id="logo-image">
            </div>
        </a>

        <!-- CONTENEDOR BOTONES DE NAVEGACIONES -->
        <div class="bottons-hero-containt">
            <!-- BOTON ADOPTA -->
            <div class="botton-hero">
                <a href="<?=SERVER?>en_adopcion" data-tooltip="Adopta">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg>
                </a>
            </div>
            <!-- BOTON EMERGENCIA -->
            <div class="botton-hero">
                <a href="<?= SERVER ?>emergencia" data-tooltip="Reporta una emergencia">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-107q75-71 117.5-136.5T640-354q0-69-46.5-117.5T480-520q-67 0-113.5 48.5T320-354q0 45 42.5 110.5T480-107Zm0 107Q359-103 299.5-191T240-354q0-102 69.5-174T480-600q101 0 170.5 72T720-354q0 75-59.5 163T480 0Zm0-300q25 0 42.5-17.5T540-360q0-25-17.5-42.5T480-420q-25 0-42.5 17.5T420-360q0 25 17.5 42.5T480-300ZM338-662l-56-56q40-40 91-61t107-21q56 0 107 21t91 61l-56 56q-29-29-65.5-43.5T480-720q-40 0-76.5 14.5T338-662ZM226-775l-57-56q63-63 143-96t168-33q88 0 168 33t143 96l-56 57q-51-51-117-78.5T480-880q-72 0-137.5 27T226-775Zm254 415Z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed" loading="lazy"><path d="M194-80v-395h80v315h280v-193l105-105q29-29 45-65t16-77q0-40-16.5-76T659-741l-25-26-127 127H347l-43 43-57-56 67-67h160l160-160 82 82q40 40 62 90.5T800-600q0 57-22 107.5T716-402l-82 82v240H194Zm197-187L183-475q-11-11-17-26t-6-31q0-16 6-30.5t17-25.5l84-85 124 123q28 28 43.5 64.5T450-409q0 40-15 76.5T391-267Z"/></svg>
                </a>
            </div>
            <!-- BOTON ORGANIZACIONES -->
            <div class="botton-hero">
                <a href="<?= SERVER ?>organizations" data-tooltip="Organizaciones">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120v-160h-80v-80h80v-166L88-440l-48-64 440-336 440 336-48 64-112-86v166h80v80h-80v160h-80v-160H520v160h-80v-160H280v160h-80Zm80-240h160v-349L280-587v227Zm240 0h160v-227L520-709v349Z"/></svg>
                </a>
            </div>
        </div>

        <!-- BOTON LOGIN -->
        <?php
            if (!isset($_SESSION['tipoU'])) {
                ?>
                    <div class="loggin-icon" id="loggin-icon">
                        <a href="<?= SERVER ?>loggin-form" data-tooltip="Inicia sesion">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="30px" width="30px" fill="#c0c8d4"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                        </a>
                    </div>
                <?php
            }
        ?>

    </div>
</header>

