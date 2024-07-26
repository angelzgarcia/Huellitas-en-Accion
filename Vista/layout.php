<!-- SEGURIDAD DE SESIONES EN LAS VISTAS -->
<?php
    if (!isset($_SESSION['tipoU']) || empty($_SESSION['tipoU'])) :
        session_start();
        session_destroy();
    endif;
?>

<!DOCTYPE html>
<html lang="en">
<!-- INICIO SE SESION -->
<!-- HEAD -->
<!-- CONTROLADOR DE VISTAS -->
<a name="ha"></a>
<?php
    session_start(['name' => 'HA-A']);
    include_once  RUTAMODULOS . "head.php";

    $s = new MainModel();
    $vista = new VistasControl();
    $v = $vista->obtenerVistasControlador();

    if ($v == '404') : require_once RUTACONTENIDOS . $v . "-view.php";
    elseif ($v != 'index.php') : require_once $v;
    else :
?>
<body class="body-index">

    <!-- PAGINA PRINCIPAL -->
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

    <!-- CONTENIDO DEL INDEX -->
        <div class="content-container">

        <!--BANNER INDEX-->
            <div class="banner-container">
                <div class="slogan-description-banner">
                    <h1>Compasión <span>Conectada....</span></h1>
                    <p>
                        <!-- Un espacio dedicado a proteger a los animales en riesgo, facilitando su rescate y cuidado mediante la colaboración de la comunidad. -->
                        Encuentra y <span><em><strong>ayuda a animales perdidos, abandonados o en peligro</strong></em></span>
                        y sé parte de una red solidaria que trabaja para brindarles un futuro mejor.
                    </p>
                </div>
            </div>

        <!-- TARJETAS INFORMATIVAS -->
            <div class="targets-info-container">

                <div class="target-info">
                    <div class="icon-target">
                        <img src="<?=RUTARECURSOS?>IMG/i-target1.png" alt="">
                    </div>
                    <div class="title-target">
                        <h2>Antes de adoptar</h2>
                        <h2><span>reflexiona:</span></h2>
                    </div>
                    <div class="info-target">
                        ¿Todos en casa están de acuerdo?
                    </div>
                </div>

                <div class="target-info">
                    <div class="icon-target">
                        <img src="<?=RUTARECURSOS?>IMG/i-target12.png" alt="">
                    </div>
                    <div class="title-target">
                        <h2>Antes de adoptar</h2>
                        <h2><span>reflexiona:</span></h2>
                    </div>
                    <div class="info-target">
                        ¿Puedo cubrir todos los gastos para ser un dueño responsable?
                    </div>
                </div>

                <div class="target-info">
                    <div class="icon-target">
                        <!-- <i class="fa-solid fa-bone"></i> -->
                        <img src="<?=RUTARECURSOS?>IMG/i-target9.png" alt="">
                    </div>
                    <div class="title-target">
                        <h2>Antes de adoptar</h2>
                        <h2><span>reflexiona:</span></h2>
                    </div>
                    <div class="info-target">
                        ¿Aceptaré a un animal de compañia que no es de raza pura?
                    </div>
                </div>

                <div class="target-info">
                    <div class="icon-target">
                        <!-- <i class="fa-solid fa-bone"></i> -->
                        <img src="<?=RUTARECURSOS?>IMG/i-target2.png" alt="">
                    </div>
                    <div class="title-target">
                        <h2>Antes de adoptar</h2>
                        <h2><span>reflexiona:</span></h2>
                    </div>
                    <div class="info-target">
                        ¿Estoy de acuerdo en dar donativo representativo al albergue que cuidó a mi próximo compañero?
                    </div>
                </div>

                <div class="target-info">
                    <div class="icon-target">
                        <!-- <i class="fa-solid fa-bone"></i> -->
                        <img src="<?=RUTARECURSOS?>IMG/i-target11.png" alt="">
                    </div>
                    <div class="title-target">
                        <h2>Antes de adoptar</h2>
                        <h2><span>reflexiona:</span></h2>
                    </div>
                    <div class="info-target">
                        ¿Estoy dispuesto a mantener mi compromiso durante 10 o 15 años?
                    </div>
                </div>

                <div class="target-info">
                    <div class="icon-target">
                        <!-- <i class="fa-solid fa-bone"></i> -->
                        <img src="<?=RUTARECURSOS?>IMG/i-target10.png" alt="">
                    </div>
                    <div class="title-target">
                        <h2>Antes de adoptar</h2>
                        <h2><span>reflexiona:</span></h2>
                    </div>
                    <div class="info-target">
                        ¿ ?
                    </div>
                </div>

            </div>

        <!-- ¿ POR QUE ADOPTAR ? -->
            <div class="why-adopt-contaniner">
                <div class="img-adopt-container">
                </div>
                <div class="adopt-facts">
                    <h2><span>¿Por qúe</span> adoptar?</h2>
                    <p>
                        Existen <span>millones</span> de perros que viven en situación de calle. <br>
                        En conjunto con los albergues hacemos un mundo mejor para las mascotas, por eso creemos que cada perro merece una nueva oportunidad para encontrar un hogar amoroso. ¡Tú podrías ser la persona que ellos están esperando!
                    </p>

                    <div class="facts-percents-container">
                        <div class="fac-percent-container">
                            <div class="fact-percent-button"><span>79%</span></div>
                            <p>De los perros llegan de forma inesperada a una familia.</p>
                        </div>

                        <div class="fac-percent-container">
                            <div class="fact-percent-button"><span>65%</span></div>
                            <p> De los perros de casa serán abandonados. </p>
                        </div>
                    </div>
                </div>
            </div>

        <!-- TARJETAS DE TIPS -->
            <div class="tips-container">

                <h2>Tips y Cuidados</h2>
                <h3>Si ya decidiste adoptar....</h3>

                <?php
                    require_once RUTACONTROL . 'tips-controlador.php';
                    $cards = new TipsControlador();
                    $cards -> listarTipsControl();
                ?>

            <!--
                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/comida.png" alt="">
                        <div class="tip-number">
                            <span>1</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>Comida</h3>
                        <hr>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Id optio impedit placeat officia qui
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/correa.png" alt="">
                        <div class="tip-number">
                            <span>2</span>
                        </div>
                    </div>

                    <div class="tip-info">
                        <h3>Correa</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/placa.png" alt="">
                        <div class="tip-number">
                            <span>3</span>
                        </div>
                    </div>

                    <div class="tip-info">
                        <h3>Placa de identificación</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/arnes.png" alt="">
                        <div class="tip-number">
                            <span>4</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>Arnés</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/juguetea.png" alt="">
                        <div class="tip-number">
                            <span>5</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>Juguetes</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic explicabo eos deserunt quaerat architecto doloremque non consequatur tempore,
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/limpiar_cama_perro-removebg-preview.png" alt="cama">
                        <div class="tip-number">
                            <span>6</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>Cama</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/limpieza.png" alt="">
                        <div class="tip-number">
                            <span>7</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>Artiuclos de limpieza</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/D_NQ_NP_926415-MCO75020069210_032024-O-removebg-preview.png" alt="">
                        <div class="tip-number">
                            <span>8</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>Transportador</h3>
                        <hr>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/erda-estremera-D1wiHCovGJ0-unsplash-removebg-preview.png" alt="">
                        <div class="tip-number">
                            <span>9</span>
                        </div>
                    </div>
                    <div class="tip-info">
                        <h3>lorem</h3>
                        <hr>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi magnam, aliquid temporibus id similique deserunt ducimus, illo accusantium fugiat doloribus quis, sapiente nobis ipsum iste suscipit aliquam voluptatum quod? Aliquam.
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div>

                <div class="tip-target-content">
                    <div class="img-target">
                        <img src="<?= RUTARECURSOS?>IMG/erda-estremera-D1wiHCovGJ0-unsplash-removebg-preview.png" alt="">
                    </div>
                    <div class="tip-number">
                        <span>9</span>
                    </div>
                    <div class="tip-info">
                        <h3>lorem</h3>
                        <hr>
                        <p>
                            Harum aspernatur sunt non? Dolorem rem esse magni quas ipsum quis, nobis itaque quibusdam? Ipsa, assumenda veniam optio cupiditate at harum saepe.
                        </p>
                    </div>
                </div> -->

            </div>

        <!-- PREGUNTAS SOBRE EL SITIO -->
            <div class="faq-container">
                <div class="faq-items">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>1. ¿Huellitas en acción vende perros y gatos?</span>
                            <button class="faq-toggle"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="faq-answer">
                            <p>No, <strong><a href="<?=SERVER?>about_us" style="color: gold; text-decoration-color: #f0ac03;">Huellitas en Aciión</a></strong> no vende perros ni gatos. En cambio, somos un intermediario que facilita la adopción para ayudar a encontrar hogares para mascotas.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>2. ¿Puedo adoptar una mascota con ayuda de Huellitas en Acción?</span>
                            <button class="faq-toggle"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="faq-answer">
                            <p>Sí, el equipo de <strong><a href="<?=SERVER?>about_us#team" style="color: gold; text-decoration-color: #f0ac03;">Digital Solutions</a></strong> te ofrece una plataforma segura y amigable para encontrar a tu nuevo próximo mejor amigo.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>3. ¿Cómo puedo adoptar un perro o gato en H.A?</span>
                            <button class="faq-toggle"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="faq-answer">
                            <p>Puedes consultar la seccion <strong><a href="<?=SERVER?>en_adopcion" style="color: gold; text-decoration-color: #f0ac03;">en adopción</a></strong> y comunicarte con los usuarios de la comunidad Huellitas en Acción para solicitar información y organizar un encuentro en tu zona local.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>4. ¿Cuánto cuesta adoptar un perro o gato en H.A?</span>
                            <button class="faq-toggle"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="faq-answer">
                            <p>¡Ser parte de H.A y encontrar a tu mejor amigo <strong style="color: gold;">no tiene coto</strong> alguno!</p>
                        </div>
                    </div>
                </div>
                <!-- BANNER -->
                <div class="banner-faq">
                </div>
            </div>

        <!-- BANNER DE ADOPCIÓN -->
            <div class="adopt-banner-container">
                <img src="<?=RUTARECURSOS?>IMG/alvan-nee-eoqnr8ikwFE-unsplash__1_-removebg-preview.png" alt="" class="pet-img-left">
                <em>
                    <p>
                        Un hogar lleno de amor es su mayor deseo.
                        </p>
                        <span>¡Adopta!</span>
                </em>
                <img src="<?=RUTARECURSOS?>IMG/kabo-p6yH8VmGqxo-unsplash-removebg-preview.png" alt="" class="pet-img-right">

            </div>

        <!-- CONTENEDOR FILTRO DE BUSQUEDA -->
            <?php include_once RUTAMODULOS . "filtro.php"; ?>

        <!-- CARRUSEL STATUS -->
            <div class="carousel-container cc-l">

                <div class="category-carousel-header">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-80q-106 0-173-33.5T240-200q0-24 14.5-44.5T295-280l63 59q-9 4-19.5 9T322-200q13 16 60 28t98 12q51 0 98.5-12t60.5-28q-7-8-18-13t-21-9l62-60q28 16 43 36.5t15 45.5q0 53-67 86.5T480-80Zm1-220q99-73 149-146.5T680-594q0-102-65-154t-135-52q-70 0-135 52t-65 154q0 67 49 139.5T481-300Zm-1 100Q339-304 269.5-402T200-594q0-71 25.5-124.5T291-808q40-36 90-54t99-18q49 0 99 18t90 54q40 36 65.5 89.5T760-594q0 94-69.5 192T480-200Zm0-320q33 0 56.5-23.5T560-600q0-33-23.5-56.5T480-680q-33 0-56.5 23.5T400-600q0 33 23.5 56.5T480-520Zm0-80Z"/></svg>
                    <h3>FEED</h3>
                    <a href="<?= SERVER ?>feed">Ver todos</a>
                </div>

                <button class="carousel-button prev" onclick="prevSlideLost()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m480-320 160-160-160-160-56 56 64 64H320v80h168l-64 64 56 56Zm0 240q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></button>

                <div class="carousel carousel-lost">

                    <div class="card card-l">
                        <div class="status-pet macho">
                            <p class="perdido">
                                Perdido
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-160q-83 0-141.5-58.5T280-360q0-73 45.5-127.5T440-556v-171l-64 63-56-56 160-160 160 160-56 57-64-64v171q69 14 114.5 68.5T680-360q0 83-58.5 141.5T480-160Zm0-80q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0-120Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>EDO. MEXICO NEZAHUALCOYOTL</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Rocky
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±5 años</p>
                            <p>Coquer</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet hembra">
                            <p class="en-adopcion">
                                En adopcion
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>CDMX</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Deimos
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±1 año</p>
                            <p>Terry Escocés</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet hembra">
                            <p class="en-peligro">
                                En peligro
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>CDMX</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Deimos
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±1 año</p>
                            <p>Terry Escocés</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet hembra">
                            <p class="encontrado">
                                Encontrado
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>CDMX</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Deimos
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±1 año</p>
                            <p>Terry Escocés</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet macho">
                            <p class="perdido">
                                Perdido
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-160q-83 0-141.5-58.5T280-360q0-73 45.5-127.5T440-556v-171l-64 63-56-56 160-160 160 160-56 57-64-64v171q69 14 114.5 68.5T680-360q0 83-58.5 141.5T480-160Zm0-80q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0-120Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>EDO. MEXICO NEZAHUALCOYOTL</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Rocky
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±5 años</p>
                            <p>Coquer</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet hembra">
                            <p class="en-adopcion">
                                En adopcion
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>CDMX</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Deimos
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±1 año</p>
                            <p>Terry Escocés</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet hembra">
                            <p class="en-peligro">
                                En peligro
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>CDMX</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Deimos
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±1 año</p>
                            <p>Terry Escocés</p>
                        </div>
                    </div>

                    <div class="card card-l">
                        <div class="status-pet hembra">
                            <p class="encontrado">
                                Encontrado
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                        </div>
                        <div class="location-pet">
                            <!-- <i class="fa-solid fa-map-pin"></i> -->
                            <!-- <i class="fa-solid fa-thumbtack"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                            <p>CDMX</p>
                        </div>
                        <div class="img-pet">
                            <a href="#">
                                <img src="<?=RUTARECURSOS?>IMG/oscar-sutton-yihlaRCCvd4-unsplash.jpg" alt="Imagen 1">
                            </a>
                        </div>
                        <div class="card-content">
                            <h2>
                                Deimos
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                            </h2>
                            <p>±1 año</p>
                            <p>Terry Escocés</p>
                        </div>
                    </div>

                </div>

                <button class="carousel-button next" onclick="nextSlideLost()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m480-320 160-160-160-160-56 56 64 64H320v80h168l-64 64 56 56Zm0 240q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></button>

            </div>

        </div>

        <!-- PIE DE PAGINA -->
        <?php include_once RUTAMODULOS . "footer.php" ?>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- BORON GO UP -->
        <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

    </main>

</body>

<!-- CARRUSELES SCRIPT -->
<script>
let currentIndexLost = 0;
function showSlideLost(indexL) {
    const slidesLost = document.querySelectorAll('.card-l');
    const carouselLost = document.querySelector('.carousel-lost');
    if (indexL >= slidesLost.length) {
        currentIndexLost = 0;
    } else if (indexL < 0) {
        currentIndexLost = slidesLost.length - 1;
    } else {
        currentIndexLost = indexL;
    }
    const offsetL = -currentIndexLost * (slidesLost[0].clientWidth + 20); // 20 is the margin
    carouselLost.style.transform = `translateX(${offsetL}px)`;


}
function nextSlideLost() {
    showSlideLost(currentIndexLost + 1);
}
function prevSlideLost() {
    showSlideLost(currentIndexLost - 1);
}
// Automatic transition
setInterval(nextSlideLost, 3000);


let currentIndexWarning = 0;
function showSlideWarning(indexW) {
    const slidesWarning = document.querySelectorAll('.card-w');
    const carouselWarning = document.querySelector('.carousel-warning');
    if (indexW >= slidesWarning.length) {
        currentIndexWarning = 0;
    } else if (indexW < 0) {
        currentIndexWarning = slidesWarning.length - 1;
    } else {
        currentIndexWarning = indexW;
    }
    const offsetW = -currentIndexWarning * (slidesWarning[0].clientWidth + 20); // 20 is the margin
    carouselWarning.style.transform = `translateX(${offsetW}px)`;


}
function nextSlideWarning() {
    showSlideWarning(currentIndexWarning + 1);
}
function prevSlideWarning() {
    showSlideWarning(currentIndexWarning - 1);
}
// Automatic transition
setInterval(nextSlideWarning, 3500);


let currentIndexAdoption = 0;
function showSlideAdoption(index) {
    const slides = document.querySelectorAll('.card-a');
    const carousel = document.querySelector('.carousel-adoption');
    if (index >= slides.length) {
        currentIndexAdoption = 0;
    } else if (index < 0) {
        currentIndexAdoption = slides.length - 1;
    } else {
        currentIndexAdoption = index;
    }
    const offset = -currentIndexAdoption * (slides[0].clientWidth + 20); // 20 is the margin
    carousel.style.transform = `translateX(${offset}px)`;


}
function nextSlideAdoption() {
    showSlideAdoption(currentIndexAdoption + 1);
}
function prevSlideAdoption() {
    showSlideAdoption(currentIndexAdoption - 1);
}
// Automatic transition
setInterval(nextSlideAdoption, 3700);


let currentIndexFound = 0;
function showSlideFound(indexF) {
    const slidesF = document.querySelectorAll('.card-f');
    const carouselF = document.querySelector('.carousel-found');
    if (indexF >= slidesF.length) {
        currentIndexFound = 0;
    } else if (indexF < 0) {
        currentIndexFound = slidesF.length - 1;
    } else {
        currentIndexFound = indexF;
    }
    const offsetF = -currentIndexFound * (slidesF[0].clientWidth + 20); // 20 is the margin
    carouselF.style.transform = `translateX(${offsetF}px)`;


}
function nextSlideFound() {
    showSlideFound(currentIndexFound + 1);
}
function prevSlideFound() {
    showSlideFound(currentIndexFound - 1);
}
// Automatic transition
setInterval(nextSlideFound, 3900);

</script>

</html>
<?php endif; ?>
