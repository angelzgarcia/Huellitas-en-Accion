
<!-- AJAX PARA CERRAR SESION -->
<script>
    $(document).ready(function() {
    $('.logoutButton').on('click', function(e) {
        e.preventDefault();
        let Token = $(this).attr('href');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
                popup: 'swal2-center'
            },
            buttonsStyling: false
        });

        Swal.fire({
            title: 'Cerrando sesión...',
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            cancelButtonColor: "#d33",
            width: 400,
            timer: 2250,
            didOpen: (toast) => {
                Swal.showLoading();
                const timer = Swal.getHtmlContainer().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: 'Operación cancelada',
                    width: 350,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                $.ajax({
                    url: '<?=SERVER?>Ajax/logoutAjax.php?Token=' + Token,
                    success: function(data) {
                        if (data === "true") {
                            window.location.href = '<?=SERVER?>';
                        } else {
                            Swal.fire({
                                title: 'Ocurrió un error',
                                text: 'No se pudo cerrar la sesión',
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: 'No se pudo cerrar la sesión',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>

<!-- BARRAS LATERALES -->

    <!-- BARRA LATERAL USUARIOS -->
    <?php
        if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador') {
            ?>
                <!-- SECCION BARRA LATERAL CLIENTE -->
                <section class="sidebar" id="sidebar">
                    <!-- BARRA LATERAL CONTENEDOR -->
                    <div class="menubar-content" id="menubar-content">
                    <!-- VALIDACION DE SESION E INCLUSION DE REDES SOCIALES Y AJUSTES DE PERFIL -->
                        <?php
                            if (empty($_SESSION['token']) || empty($_SESSION['tipoU'])) {
                                ?>
                                    <!-- REDES SOCIALES -->
                                    <div class="social-media-icons">
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-instagram"></i>
                                        </a>
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-tiktok"></i>
                                        </a>
                                    </div>
                                    <hr>
                                <?php

                            } else {
                                ?>
                                    <!-- OPCIONES DE PERFIL-->
                                    <div class="social-media-icons admin-name">
                                        <span><strong><?=ucwords($_SESSION['nom'])?> <?=ucwords($_SESSION['ap'])?></strong></span>
                                        <div class="account-admin-icon">
                                            <button onclick="showSettings()"><img src="<?=$_SESSION['photo']?>" style="width: 40px;"/></button>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- REDES SOCIALES -->
                                    <div class="social-media-icons">
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-instagram"></i>
                                        </a>
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                        <a href="" class="red-social">
                                            <i class="fa-brands fa-tiktok"></i>
                                        </a>
                                    </div>
                                <?php
                            }
                        ?>

                        <!-- LOGO HUELLITAS EN ACCION -->
                        <div class="sidebar-image">
                            <a href="<?=SERVER?>"></a>
                        </div>

                        <!-- CONTENEDOR DE OPCIONES DE LA BARRA LATERAL-->
                        <div class="links-container">

                        <!--ENLACES DE LAS SECCIONES DE LA PAGINA PRINCIPAL -->
                            <!-- GUIA DEL HUMANO -->
                            <a href="#" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#c0c8d4" loading="lazy"><path d="M240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm0-80h480v-640h-80v280l-100-60-100 60v-280H240v640Zm0 0v-640 640Zm200-360 100-60 100 60-100-60-100 60Z"/></svg> Guía del humano
                            </a>
                            <!-- BLOG -->
                            <a href="<?= SERVER ?>blog">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#c0c8d4" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200q0-33 23.5-56.5T200-280q33 0 56.5 23.5T280-200q0 33-23.5 56.5T200-120Zm480 0q0-117-44-218.5T516-516q-76-76-177.5-120T120-680v-120q142 0 265 53t216 146q93 93 146 216t53 265H680Zm-240 0q0-67-25-124.5T346-346q-44-44-101.5-69T120-440v-120q92 0 171.5 34.5T431-431q60 60 94.5 139.5T560-120H440Z"/></svg> Blog
                            </a>
                            <!-- ACERCA DE NOSOTROS -->
                            <a href="<?= SERVER ?>about_us">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z"/></svg> Conócenos
                            </a>
                            <!-- DONACIONES -->
                            <a href="https://mundopatitas.mx/donativos" target="_blank" rel="noopener nofollow noreferrer preload">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M640-440 474-602q-31-30-52.5-66.5T400-748q0-55 38.5-93.5T532-880q32 0 60 13.5t48 36.5q20-23 48-36.5t60-13.5q55 0 93.5 38.5T880-748q0 43-21 79.5T807-602L640-440Zm0-112 109-107q19-19 35-40.5t16-48.5q0-22-15-37t-37-15q-14 0-26.5 5.5T700-778l-60 72-60-72q-9-11-21.5-16.5T532-800q-22 0-37 15t-15 37q0 27 16 48.5t35 40.5l109 107ZM280-220l278 76 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T578-354l-234-86h-64v220ZM40-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L560-60l-280-78v58H40Zm80-80h80v-280h-80v280Zm520-546Z"/></svg> Donaciones
                            </a>

                            <!-- DETAILS FEED -->
                            <details>
                                <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M160-120q-33 0-56.5-23.5T80-200v-280h80v280h360v80H160Zm160-160q-33 0-56.5-23.5T240-360v-280h80v280h360v80H320Zm160-160q-33 0-56.5-23.5T400-520v-240q0-33 23.5-56.5T480-840h320q33 0 56.5 23.5T880-760v240q0 33-23.5 56.5T800-440H480Zm0-80h320v-160H480v160Z"/></svg> Feed
                                </summary>
                                <div class="details-menu-content">
                                    <a href="<?= SERVER ?>feed"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0"><path d="M80-360v-240q0-33 23.5-56.5T160-680q33 0 56.5 23.5T240-600v240q0 33-23.5 56.5T160-280q-33 0-56.5-23.5T80-360Zm280 160q-33 0-56.5-23.5T280-280v-400q0-33 23.5-56.5T360-760h240q33 0 56.5 23.5T680-680v400q0 33-23.5 56.5T600-200H360Zm360-160v-240q0-33 23.5-56.5T800-680q33 0 56.5 23.5T880-600v240q0 33-23.5 56.5T800-280q-33 0-56.5-23.5T720-360Zm-360 80h240v-400H360v400Zm120-200Z"/></svg> Todos</a>
                                    <a href="<?= SERVER ?>perdidos"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M519-82v-80q42-6 81.5-23t74.5-43l58 58q-47 37-101 59.5T519-82Zm270-146-56-56q26-33 42-72.5t22-83.5h82q-8 62-30.5 115.5T789-228Zm8-292q-6-45-22-84.5T733-676l56-56q38 44 61.5 98T879-520h-82ZM439-82q-153-18-255.5-131T81-480q0-155 102.5-268T439-878v80q-120 17-199 107t-79 211q0 121 79 210.5T439-162v80Zm238-650q-36-27-76-44t-82-22v-80q59 5 113 27.5T733-790l-56 58ZM480-280q-58-49-109-105t-51-131q0-68 46.5-116T480-680q67 0 113.5 48T640-516q0 75-51 131T480-280Zm0-200q18 0 30.5-12.5T523-523q0-17-12.5-30T480-566q-18 0-30.5 13T437-523q0 18 12.5 30.5T480-480Z"/></svg> Perdidos</a>
                                    <a href="<?= SERVER ?>encontrados"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="m438-426 198-198-57-57-141 141-56-56-57 57 113 113Zm42 240q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg> Encontrados</a>
                                    <a href="<?= SERVER ?>en_adopcion"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#c0c8d4" loading="lazy"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg> En adopción</a>
                                    <a href="<?= SERVER ?>en_peligro"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#c0c8d4" loading="lazy"><path d="M160-80q-33 0-56.5-23.5T80-160v-480q0-33 23.5-56.5T160-720h160v-80q0-33 23.5-56.5T400-880h160q33 0 56.5 23.5T640-800v80h160q33 0 56.5 23.5T880-640v480q0 33-23.5 56.5T800-80H160Zm0-80h640v-480H160v480Zm240-560h160v-80H400v80ZM160-160v-480 480Zm280-200v120h80v-120h120v-80H520v-120h-80v120H320v80h120Z"/></svg> En peligro</a>
                                </div>
                            </details>

                            <!-- DETAILS PUBLICAR -->
                            <?php
                                $class = '';
                                if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Usuario') :
                                    $class = "-disabled";
                                else : $class = '-enable'; endif;
                            ?>
                            <details class="details<?=$class?>">
                                <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M240-160q-33 0-56.5-23.5T160-240q0-33 23.5-56.5T240-320q33 0 56.5 23.5T320-240q0 33-23.5 56.5T240-160Zm0-240q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm0-240q-33 0-56.5-23.5T160-720q0-33 23.5-56.5T240-800q33 0 56.5 23.5T320-720q0 33-23.5 56.5T240-640Zm240 0q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Zm240 0q-33 0-56.5-23.5T640-720q0-33 23.5-56.5T720-800q33 0 56.5 23.5T800-720q0 33-23.5 56.5T720-640ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm40 240v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg> Publicar
                                </summary>
                                <div class="details-menu-content">
                                    <!-- perdidos -->
                                    <a href="<?= SERVER ?>publicar?s=<?=htmlspecialchars('perdido')?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M480-80Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880h20q10 0 20 2v81q-10-2-19.5-2.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186q122-112 181-203.5T720-552v-8h80v8q0 100-79.5 217.5T480-80Zm0-400q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0-80Zm240-80h80v-120h120v-80H800v-120h-80v120H600v80h120v120Z"/></svg> Perdido</a>
                                    <!-- <a href="<?= SERVER ?>publicar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q32 0 62-6t58-17l60 61q-41 20-86 31t-94 11Zm280-80v-120H640v-80h120v-120h80v120h120v80H840v120h-80ZM424-296 254-466l56-56 114 114 400-401 56 56-456 457Z"/></svg> Encontrado</a> -->
                                    <!-- en adopcion -->
                                    <a href="<?= SERVER ?>publicar?s=<?=htmlspecialchars('en-adopcion')?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/></svg> Dar en adopción</a>
                                    <!-- en peligro -->
                                    <a href="<?= SERVER ?>publicar?s=<?=htmlspecialchars('en-peligro')?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M160-80q-33 0-56.5-23.5T80-160v-480q0-33 23.5-56.5T160-720h160v-80q0-33 23.5-56.5T400-880h160q33 0 56.5 23.5T640-800v80h160q33 0 56.5 23.5T880-640v480q0 33-23.5 56.5T800-80H160Zm0-80h640v-480H160v480Zm240-560h160v-80H400v80ZM160-160v-480 480Zm280-200v120h80v-120h120v-80H520v-120h-80v120H320v80h120Z"/></svg> En peligro</a>
                                </div>
                            </details>
                            <?php
                                if ($class == '-disabled') {
                                    ?>
                                        <div class="dd-tooltip-text">¡Regístrate gratis y publica!</div>
                                    <?php
                                }
                            ?>

                        </div>

                    </div>
                    <!-- <input type="text" title="Al menos: 1 Mayuscula, 1 minuscula, 1 número, un símbolo [@, $, !, %, *, ?, &] "> -->

                    <!-- BOTON DE LA BARRA LATERAL -->
                    <div class="sidebox" class="toggle" onclick="toggleSidebar()">
                        <button id="sidebox-button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="30px" width="30px" fill="#18232b" loading="lazy"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></i>
                        </button>
                    </div>

                </section>

                <!-- AJUSTES DEL PERFIL -->
                <div class="settings-profile settings-user" id="settings-profile" style="background-color: #f5ebeb;">
                    <a href="<?=SERVER?>perfil"><p>Tu perfil</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="15px"  width="15px" fill="#000" loading="lazy">!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.<path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg></a>
                    <a href="<?=SERVER?>settings"><p>Ajustes</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="15px"  width="15px" fill="#000" loading="lazy"><path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path><path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path></svg></a>
                    <a href="<?=SERVER?>"><p>Inicio</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="15px"  width="15px" fill="#000" loading="lazy"><path d="M200-160v-366L88-440l-48-64 440-336 160 122v-82h120v174l160 122-48 64-112-86v366H520v-240h-80v240H200Zm80-80h80v-240h240v240h80v-347L480-739 280-587v347Zm120-319h160q0-32-24-52.5T480-632q-32 0-56 20.5T400-559Zm-40 319v-240h240v240-240H360v240Z"/></svg></a>
                    <a href="<?= $s -> encryption($_SESSION['token']); ?>" class="logoutButton" data-swal-toast-template="#my-template"><p>Salir</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="15px"  width="15px" fill="#000" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg></a>
                </div>

            <?php
        } else {
            ?>
    <!-- BARRA LATERAL ADMINISTRADOR -->
                <!-- SECCION DE LA BARRA LATERAL DE ADMINISTRADOR-->
                <section class="sidebar sidebar-admin" id="sidebar">

                    <!-- CONTENEDOR DE LA BARRA LATERAL -->
                    <div class="menubar-content menubar-admin" id="menubar-content">

                        <!-- PERFIL OPTIONS-->
                        <div class="social-media-icons admin-name">
                            <span><strong><?=ucwords($_SESSION['nom'])?> <?=ucwords($_SESSION['ap'])?></strong></span>
                            <div class="account-admin-icon">
                                <button onclick="showSettings()"><img src="<?=$_SESSION['photo']?>"/></button>
                            </div>
                        </div>
                        <hr>

                        <!-- CONTENEDOR DE LINKS -->
                        <div class="links-container">

                        <!-- DETAILS TABLAS DE REGISTROS -->
                            <details>
                                <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200Zm80-400h560v-160H200v160Zm213 200h134v-120H413v120Zm0 200h134v-120H413v120ZM200-400h133v-120H200v120Zm427 0h133v-120H627v120ZM200-200h133v-120H200v120Zm427 0h133v-120H627v120Z"/></svg> Registros
                                </summary>
                            <!-- TABLAS -->
                                <!-- TABLA ORGANIZACIONES -->
                                <a href="organizaciones"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M420-280h120v-100h100v-120H540v-100H420v100H320v120h100v100ZM160-120v-480l320-240 320 240v480H160Zm80-80h480v-360L480-740 240-560v360Zm240-270Z"/></svg> Organizaciones</a>
                                <!-- TABLA UBICACIONES -->
                                <a href="ubicaciones"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg> Ubicaciones</a>
                                <!-- TABLA MASCOTAS -->
                                <a href="animales"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M194-80v-395h80v315h280v-193l105-105q29-29 45-65t16-77q0-40-16.5-76T659-741l-25-26-127 127H347l-43 43-57-56 67-67h160l160-160 82 82q40 40 62 90.5T800-600q0 57-22 107.5T716-402l-82 82v240H194Zm197-187L183-475q-11-11-17-26t-6-31q0-16 6-30.5t17-25.5l84-85 124 123q28 28 43.5 64.5T450-409q0 40-15 76.5T391-267Z"/></svg> Animales</a>
                                <!-- TABLA USUARIOS -->
                                <a href="usuarios"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/></svg> Usuarios</a>
                                <!-- TABLA TIPS -->
                                <a href="tips"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg> Tips</a>
                                <!-- TABLA BLOG -->
                                <a href="noticias"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200q0-33 23.5-56.5T200-280q33 0 56.5 23.5T280-200q0 33-23.5 56.5T200-120Zm480 0q0-117-44-218.5T516-516q-76-76-177.5-120T120-680v-120q142 0 265 53t216 146q93 93 146 216t53 265H680Zm-240 0q0-67-25-124.5T346-346q-44-44-101.5-69T120-440v-120q92 0 171.5 34.5T431-431q60 60 94.5 139.5T560-120H440Z"/></svg> Blog</a>


                            <!-- ACCIONES / OPERACIONES -->

                                <!-- ACCIONES ORGANIZACIONES -->
                                <details>
                                    <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24px" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z"/></svg> Organizaciones
                                    </summary>
                                    <div class="details-menu-content">
                                        <a href="<?= SERVER ?>agregar_org"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg> Agregar</a>
                                        <a href="<?= SERVER ?>eliminar_org"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M360-200q-20 0-37.5-9T294-234L120-480l174-246q11-16 28.5-25t37.5-9h400q33 0 56.5 23.5T840-680v400q0 33-23.5 56.5T760-200H360Zm400-80v-400 400Zm-400 0h400v-400H360L218-480l142 200Zm96-40 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Z"/></svg> Eliminar</a>
                                        <a href="<?= SERVER ?>modificar-org"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg> Modificar y Actualizar</a>
                                    </div>
                                </details>

                                <!-- ACCIONES ANIMALES -->
                                <details>
                                    <summary>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24px" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z"/></svg> Animales
                                    </summary>
                                    <div class="details-menu-content">
                                        <a href="<?= SERVER ?>eliminar_ub"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M360-200q-20 0-37.5-9T294-234L120-480l174-246q11-16 28.5-25t37.5-9h400q33 0 56.5 23.5T840-680v400q0 33-23.5 56.5T760-200H360Zm400-80v-400 400Zm-400 0h400v-400H360L218-480l142 200Zm96-40 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Z"/></svg> Eliminar</a>
                                    </div>
                                </details>

                                <!-- ACCIONES USUARIOS -->
                                <details>
                                    <summary>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24px" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z"/></svg> Usuarios
                                    </summary>
                                    <div class="details-menu-content">
                                        <a href="<?= SERVER ?>eliminar_us"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M360-200q-20 0-37.5-9T294-234L120-480l174-246q11-16 28.5-25t37.5-9h400q33 0 56.5 23.5T840-680v400q0 33-23.5 56.5T760-200H360Zm400-80v-400 400Zm-400 0h400v-400H360L218-480l142 200Zm96-40 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Z"/></svg> Eliminar</a>
                                    </div>
                                </details>

                                <!-- ACCIONES TIPS -->
                                <details>
                                    <summary>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24px" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z"/></svg> Tips
                                    </summary>
                                    <div class="details-menu-content">
                                        <a href="<?= SERVER ?>agregar_tip"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg> Agregar</a>
                                        <a href="<?= SERVER ?>eliminar_tip"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M360-200q-20 0-37.5-9T294-234L120-480l174-246q11-16 28.5-25t37.5-9h400q33 0 56.5 23.5T840-680v400q0 33-23.5 56.5T760-200H360Zm400-80v-400 400Zm-400 0h400v-400H360L218-480l142 200Zm96-40 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Z"/></svg> Eliminar</a>
                                        <a href="<?= SERVER ?>modificar_tip"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg> Modificar y Actualizar</a>
                                    </div>
                                </details>

                                <!-- ACCIONES BLOG -->
                                <details>
                                    <summary>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24px" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z"/></svg> Blog
                                    </summary>
                                    <div class="details-menu-content">
                                        <a href="<?= SERVER ?>agregar_noticia"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg> Agregar</a>
                                        <a href="<?= SERVER ?>eliminar_noticia"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M360-200q-20 0-37.5-9T294-234L120-480l174-246q11-16 28.5-25t37.5-9h400q33 0 56.5 23.5T840-680v400q0 33-23.5 56.5T760-200H360Zm400-80v-400 400Zm-400 0h400v-400H360L218-480l142 200Zm96-40 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Z"/></svg> Eliminar</a>
                                        <a href="<?= SERVER ?>modificar_noticia"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0" loading="lazy"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg> Modificar y Actualizar</a>
                                    </div>
                                </details>

                            </details>
                            <hr>

                        <!--ENLACES DE LAS SECCIONES DE LA PAGINA PRINCIPAL -->
                            <!-- GUIA DEL HUMANO -->
                            <a href="#" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm0-80h480v-640h-80v280l-100-60-100 60v-280H240v640Zm0 0v-640 640Zm200-360 100-60 100 60-100-60-100 60Z"/></svg> Guía del humano</a>
                            <!-- BLOG -->
                            <a href="<?= SERVER ?>blog"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200q0-33 23.5-56.5T200-280q33 0 56.5 23.5T280-200q0 33-23.5 56.5T200-120Zm480 0q0-117-44-218.5T516-516q-76-76-177.5-120T120-680v-120q142 0 265 53t216 146q93 93 146 216t53 265H680Zm-240 0q0-67-25-124.5T346-346q-44-44-101.5-69T120-440v-120q92 0 171.5 34.5T431-431q60 60 94.5 139.5T560-120H440Z"/></svg> Blog</a>
                            <!-- ACERCA DE NOSOTROS -->
                            <a href="<?= SERVER ?>about_us"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z"/></svg> Conócenos</a>
                            <!-- DONACIONES -->
                            <a href="https://mundopatitas.mx/donativos" target="_blank" rel="noopener nofollow noreferrer preload"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M640-440 474-602q-31-30-52.5-66.5T400-748q0-55 38.5-93.5T532-880q32 0 60 13.5t48 36.5q20-23 48-36.5t60-13.5q55 0 93.5 38.5T880-748q0 43-21 79.5T807-602L640-440Zm0-112 109-107q19-19 35-40.5t16-48.5q0-22-15-37t-37-15q-14 0-26.5 5.5T700-778l-60 72-60-72q-9-11-21.5-16.5T532-800q-22 0-37 15t-15 37q0 27 16 48.5t35 40.5l109 107ZM280-220l278 76 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T578-354l-234-86h-64v220ZM40-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L560-60l-280-78v58H40Zm80-80h80v-280h-80v280Zm520-546Z"/></svg> Donaciones</a>

                            <!-- DETAILS FEED -->
                            <details>
                                <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M160-120q-33 0-56.5-23.5T80-200v-280h80v280h360v80H160Zm160-160q-33 0-56.5-23.5T240-360v-280h80v280h360v80H320Zm160-160q-33 0-56.5-23.5T400-520v-240q0-33 23.5-56.5T480-840h320q33 0 56.5 23.5T880-760v240q0 33-23.5 56.5T800-440H480Zm0-80h320v-160H480v160Z"/></svg> Feed
                                </summary>
                                <div class="details-menu-content">
                                <a href="<?= SERVER ?>feed"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px" fill="#cfd6e0"><path d="M80-360v-240q0-33 23.5-56.5T160-680q33 0 56.5 23.5T240-600v240q0 33-23.5 56.5T160-280q-33 0-56.5-23.5T80-360Zm280 160q-33 0-56.5-23.5T280-280v-400q0-33 23.5-56.5T360-760h240q33 0 56.5 23.5T680-680v400q0 33-23.5 56.5T600-200H360Zm360-160v-240q0-33 23.5-56.5T800-680q33 0 56.5 23.5T880-600v240q0 33-23.5 56.5T800-280q-33 0-56.5-23.5T720-360Zm-360 80h240v-400H360v400Zm120-200Z"/></svg> Todos</a>
                                    <a href="<?= SERVER ?>perdidos"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M519-82v-80q42-6 81.5-23t74.5-43l58 58q-47 37-101 59.5T519-82Zm270-146-56-56q26-33 42-72.5t22-83.5h82q-8 62-30.5 115.5T789-228Zm8-292q-6-45-22-84.5T733-676l56-56q38 44 61.5 98T879-520h-82ZM439-82q-153-18-255.5-131T81-480q0-155 102.5-268T439-878v80q-120 17-199 107t-79 211q0 121 79 210.5T439-162v80Zm238-650q-36-27-76-44t-82-22v-80q59 5 113 27.5T733-790l-56 58ZM480-280q-58-49-109-105t-51-131q0-68 46.5-116T480-680q67 0 113.5 48T640-516q0 75-51 131T480-280Zm0-200q18 0 30.5-12.5T523-523q0-17-12.5-30T480-566q-18 0-30.5 13T437-523q0 18 12.5 30.5T480-480Z"/></svg> Perdidos</a>
                                    <a href="<?= SERVER ?>encontrados"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="m438-426 198-198-57-57-141 141-56-56-57 57 113 113Zm42 240q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg> Encontrados</a>
                                    <a href="<?= SERVER ?>en_adopcion"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg> En adopción</a>
                                    <a href="<?= SERVER ?>en_peligro"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M480-107q75-71 117.5-136.5T640-354q0-69-46.5-117.5T480-520q-67 0-113.5 48.5T320-354q0 45 42.5 110.5T480-107Zm0 107Q359-103 299.5-191T240-354q0-102 69.5-174T480-600q101 0 170.5 72T720-354q0 75-59.5 163T480 0Zm0-300q25 0 42.5-17.5T540-360q0-25-17.5-42.5T480-420q-25 0-42.5 17.5T420-360q0 25 17.5 42.5T480-300ZM338-662l-56-56q40-40 91-61t107-21q56 0 107 21t91 61l-56 56q-29-29-65.5-43.5T480-720q-40 0-76.5 14.5T338-662ZM226-775l-57-56q63-63 143-96t168-33q88 0 168 33t143 96l-56 57q-51-51-117-78.5T480-880q-72 0-137.5 27T226-775Zm254 415Z"/></svg> En peligro</a>
                                </div>
                            </details>

                            <!-- DETAILS PUBLICAR -->
                            <details>
                                <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M240-160q-33 0-56.5-23.5T160-240q0-33 23.5-56.5T240-320q33 0 56.5 23.5T320-240q0 33-23.5 56.5T240-160Zm0-240q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm0-240q-33 0-56.5-23.5T160-720q0-33 23.5-56.5T240-800q33 0 56.5 23.5T320-720q0 33-23.5 56.5T240-640Zm240 0q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Zm240 0q-33 0-56.5-23.5T640-720q0-33 23.5-56.5T720-800q33 0 56.5 23.5T800-720q0 33-23.5 56.5T720-640ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm40 240v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg> Publicar
                                </summary>
                                <div class="details-menu-content">
                                    <!-- perdido -->
                                    <a href="<?= SERVER ?>publicar?s=<?=htmlspecialchars('perdido')?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M480-80Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880h20q10 0 20 2v81q-10-2-19.5-2.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186q122-112 181-203.5T720-552v-8h80v8q0 100-79.5 217.5T480-80Zm0-400q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0-80Zm240-80h80v-120h120v-80H800v-120h-80v120H600v80h120v120Z"/></svg> Perdido</a>
                                    <!-- <a href="<?= SERVER ?>publicar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q32 0 62-6t58-17l60 61q-41 20-86 31t-94 11Zm280-80v-120H640v-80h120v-120h80v120h120v80H840v120h-80ZM424-296 254-466l56-56 114 114 400-401 56 56-456 457Z"/></svg> Encontrado</a> -->
                                    <!-- en adopcion -->
                                    <a href="<?= SERVER ?>publicar?s=<?=htmlspecialchars('en-adopcion')?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" height="20px" fill="#e8eaed"><path d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/></svg> Dar en adopción</a>
                                    <!-- en peligro -->
                                    <a href="<?= SERVER ?>publicar?s=<?=htmlspecialchars('en-peligro')?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px"  width="20px" fill="#cfd6e0" loading="lazy"><path d="M160-80q-33 0-56.5-23.5T80-160v-480q0-33 23.5-56.5T160-720h160v-80q0-33 23.5-56.5T400-880h160q33 0 56.5 23.5T640-800v80h160q33 0 56.5 23.5T880-640v480q0 33-23.5 56.5T800-80H160Zm0-80h640v-480H160v480Zm240-560h160v-80H400v80ZM160-160v-480 480Zm280-200v120h80v-120h120v-80H520v-120h-80v120H320v80h120Z"/></svg> En peligro</a>
                                </div>
                            </details>

                        </div>

                    </div>

                    <!-- SIDEBOX BUTTON -->
                    <div class="sidebox sidebox-admin" class="toggle" onclick="toggleSidebar()">
                        <button id="sidebox-button" >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="30px" width="30px" fill="#18232b" loading="lazy"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></i>
                        </button>
                    </div>

                </section>

            <!-- AJUSTES DEL PERFIL -->
                <div class="settings-profile" id="settings-profile">
                    <a href="<?=SERVER?>admin_dashboard"><p>Dashboard</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="15px"  width="15px" fill="#cfd6e0" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm200-80v-240H200v240h200Zm80 0h280v-240H480v240ZM200-520h560v-240H200v240Z"/></svg></a>
                    <a href="<?=SERVER?>perfil/admin?v=<?=$s->encryption($_SESSION['token'])?>"><p>Tu perfil</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="15px"  width="15px" fill="#cfd6e0" loading="lazy">!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.<path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg></a>
                    <a href="<?=SERVER?>settings/admin?v=<?=$s->encryption($_SESSION['token'])?>"><p>Ajustes</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="15px"  width="15px" fill="#cfd6e0" loading="lazy"><path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path><path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path></svg></a>
                    <a href="<?=SERVER?>"><p>Inicio</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="15px"  width="15px" fill="#cfd6e0" loading="lazy"><path d="M200-160v-366L88-440l-48-64 440-336 160 122v-82h120v174l160 122-48 64-112-86v366H520v-240h-80v240H200Zm80-80h80v-240h240v240h80v-347L480-739 280-587v347Zm120-319h160q0-32-24-52.5T480-632q-32 0-56 20.5T400-559Zm-40 319v-240h240v240-240H360v240Z"/></svg></a>
                    <a href="<?= $s -> encryption($_SESSION['token']); ?>" class="logoutButton" data-swal-toast-template="#my-template"><p>Salir</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="15px"  width="15px" fill="#cfd6e0" loading="lazy"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg></a>
                </div>

            <?php
        }

    ?>


