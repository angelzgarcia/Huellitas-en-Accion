<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<body class="body-index">
<main class="content-page">

    <!-- HEADER -->
    <?php include_once RUTAMODULOS . "header.php"; ?>

<!-- CONTENIDO ACERCA DE NOSOTROS -->
    <!-- BANNER -->
    <div class="banner-about-us">
        <div class="saludo-title-container">
            <div class="bienvenido-saludo">
                ¡ Bienvenid@ a
            </div>
            <div class="site-name">
                <h2>Huellitas en acci<a href="<?=SERVER?>"><i class="fa-solid fa-paw"></i></a>n !</h2>
            </div>
            <div class="slogan-site">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br> Iure ipsa reiciendis laudantium nemo impedit quidem, sapiente,
            </div>
        </div>
    </div>

    <!-- ACERCA DE NOSOTROS -->
    <div class="about-us-card">
        <div class="about-us-title">
            <h3>¿Quiénes somos?</h3>
        </div>
        <div class="about-us-description">
            Somos un grupo de personas dedicadas en pro de los animales que proporciona una herramienta poderosa con
            el fin de crear una <strong>comunidad activa</strong> que ayude a estas mascotas a darles una mejor vida.
        </div>
    </div>

    <!-- MISION -->
    <div class="mission-card">
        <div class="mission-title">
            <h3>Nuestra misión</h3>
        </div>
        <div class="mission-description">
            La premisa de <strong style="color: #22283f;">Huellitas en Acción</strong> es trabajar por una cultura de respeto, justicia y empatía hacia los animales, así como contribuir a la erradicación
            de animales abandonados y vulnerables a enfermedades y violencia que se ejerce en contra de ellos.
        </div>
    </div>

    <!-- VISION -->
    <div class="mission-card vision-card">
        <div class="mission-title vision-title">
            <h3>Nuestra visión</h3>
        </div>
        <div class="mission-description vision-description">
            Somos un grupo de personas dedicadas en pro de los animales que proporciona una herramienta poderosa para reportar mascotas en situaciones especificas con
            el fin de darles una mejor vida con familias amorosas.
        </div>
    </div>

    <a name="team"></a>
    <!-- EQUIPO -->
    <div class="team-container">
        <h1>CONOCE A NUESTRO EQUIPO</h1>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores eaque omnis, laboriosam itaque et sed molestiae ipsum beatae, aliquid
            architecto cupiditate recusandae, nostrum inventore soluta molestias. Quae neque velit provident.
        </p>
        <div class="team-carrusel">
            <button class="team-prev">&#10094;</button>
            <div class="team-carrusel-items">
                <div class="team-item">
                    <img src="<?=RUTARECURSOS?>IMG/Alin.JPEG" alt="Barrera Elizalde Cinthia Alin">
                    <p>Barrera Elizalde Cinthia Alin</p>
                    <p>Desarrolladora de servicios web </p>
                </div>
                <div class="team-item">
                    <img src="<?=RUTARECURSOS?>IMG/Gabriel.JPEG" alt="Montiel Olguín Gabriel">
                    <p>Montiel Olguín Gabriel</p>
                    <p>Especialista en seguridad </p>
                </div>
                <div class="team-item">
                    <img src="<?=RUTARECURSOS?>IMG/Kevin.JPEG" alt="Rodriguez Servín Kevin Angel">
                    <p>Rodriguez Servín Kevin Angel</p>
                    <p>Administrador de base de datos</p>
                </div>
                <div class="team-item">
                    <img src="<?=RUTARECURSOS?>IMG/Angel.JPEG" alt="Rodríguez García Angel Zabdiel">
                    <p>Rodríguez García Angel Zabdiel</p>
                    <p>Arquitecto de software </p>
                </div>
                <div class="team-item">
                    <img src="<?=RUTARECURSOS?>IMG/Lili.JPG" alt="Velazquez Linares Esmeralda Lili ">
                    <p>Velazquez Linares Esmeralda Lili</p>
                    <p>Desarrolladora de Front-End</p>
                </div>
            </div>
            <button class="team-next">&#10095;</button>
        </div>
        <div class="team-dots">
            <span class="team-dot"><img src="<?=RUTARECURSOS?>IMG/Alin.JPEG"" alt="img"></span>
            <span class="team-dot"><img src="<?=RUTARECURSOS?>IMG/Gabriel.JPEG"" alt="img"></span>
            <span class="team-dot"><img src="<?=RUTARECURSOS?>IMG/Kevin.JPEG"" alt="img"></span>
            <span class="team-dot"><img src="<?=RUTARECURSOS?>IMG/Angel.JPEG"" alt="img"></span>
            <span class="team-dot"><img src="<?=RUTARECURSOS?>IMG/Lili.JPG"" alt="img"></span>
            <!-- Añade más puntos aquí según el número de elementos -->
        </div>
    </div>

    <!-- SIDEBAR -->
    <?php include_once RUTAMODULOS . "sidebar.php"; ?>

    <!-- BORON GO UP -->
    <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

</main>
</body>
</html>
