<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php

    if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador') :
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    else :
        $_SESSION['gen'] == 'm' ? $saludo = 'o' : $saludo = 'a';
        $dogs = [
            0 => RUTARECURSOS . 'IMG/d1.png',
            1 => RUTARECURSOS . 'IMG/d2.png',
            2 => RUTARECURSOS . 'IMG/d3.png',
            3 => RUTARECURSOS . 'IMG/d4.png'
        ];
        $dog = $dogs[rand(0, count($dogs)-1)]

?>
<body class="admin-index">
    <main class="content-page content-page-admin" style="background-image: url(<?=$dog?>);">

        <!-- AJAX PARA ALERTA DE BIENVENIDA -->
        <script>
            const Toast = Swal.fire({
                toast: true,
                timerProgressBar: true,
                // position: "top",
                // icon: "success",
                title: "<div style = 'text-align: center; font-size: 1.5em;'>¡ Bienvenid<?=$saludo?> <?=$_SESSION['nom']?> ! \n\\(^Д^)/</div> ",
                html: '<div style="text-align: center;"><img src="<?=$_SESSION['photo']?>" style="height: 80px; border-radius: 50%;" /></div>',
                showConfirmButton: false,
                timer: 1800,
                showClass: {
                    popup: `
                    animate__animated
                    animate__fadeInUp
                    animate__faster
                    `
                },
                hideClass: {
                    popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                    `
                },
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    toast.classList.add('custom-toast');
                }
            });
        </script>

        <!-- PRE - VIEW DE TABLAS -->
        <div class="tables-grid-container">
            <!-- ORGANIZACIONES -->
            <div class="preview-table">
                <a href="<?=SERVER?>organizaciones">
                    Organizaciones <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="40px"  width="40px" fill="#fff" loading="lazy"><path d="M420-280h120v-100h100v-120H540v-100H420v100H320v120h100v100ZM160-120v-480l320-240 320 240v480H160Zm80-80h480v-360L480-740 240-560v360Zm240-270Z"/></svg>
                </a>
            </div>

            <!-- UBICACIONES -->
            <div class="preview-table">
                <a href="<?=SERVER?>ubicaciones">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="40px"  width="40px" fill="#fff" loading="lazy"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg> Ubicaciones
                </a>
            </div>

            <!-- ANIMALES -->
            <div class="preview-table">
                <a href="<?=SERVER?>animales">
                    Animales <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="40px"  width="40px" fill="#fff" loading="lazy"><path d="M194-80v-395h80v315h280v-193l105-105q29-29 45-65t16-77q0-40-16.5-76T659-741l-25-26-127 127H347l-43 43-57-56 67-67h160l160-160 82 82q40 40 62 90.5T800-600q0 57-22 107.5T716-402l-82 82v240H194Zm197-187L183-475q-11-11-17-26t-6-31q0-16 6-30.5t17-25.5l84-85 124 123q28 28 43.5 64.5T450-409q0 40-15 76.5T391-267Z"/></svg>
                </a>
            </div>

            <!-- USUARIOS -->
            <div class="preview-table">
                <a href="<?=SERVER?>usuarios">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="40px"  width="40px" fill="#fff" loading="lazy"><path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/></svg> Usuarios
                </a>
            </div>

            <!-- TIPS -->
            <div class="preview-table">
                <a href="<?=SERVER?>tips">
                    Tips <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="40px"  width="40px" fill="#fff" loading="lazy"><path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
                </a>
            </div>

            <!-- BLOG -->
            <div class="preview-table">
                <a href="<?=SERVER?>noticias">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="40px"  width="40px" fill="#000" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200q0-33 23.5-56.5T200-280q33 0 56.5 23.5T280-200q0 33-23.5 56.5T200-120Zm480 0q0-117-44-218.5T516-516q-76-76-177.5-120T120-680v-120q142 0 265 53t216 146q93 93 146 216t53 265H680Zm-240 0q0-67-25-124.5T346-346q-44-44-101.5-69T120-440v-120q92 0 171.5 34.5T431-431q60 60 94.5 139.5T560-120H440Z"/></svg> Blog
                </a>
            </div>
        </div>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

    </main>
</body>
</html>
<?php endif; ?>



