<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || ($_SESSION['tipoU'] != 'Usuario' && $_SESSION['tipoU'] != 'Administrador')) {
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    } else {
        $_SESSION['gen'] == 'm' ? $saludo = 'o' : $saludo = 'a';

?>
<body class="user-index" style="background-color: <?= $bgU = $_SESSION['tipoU'] == 'Administrador' ? '#232224' : ''; ?>;">

    <main class="content-page content-page-user">

        <!-- PERFIL CONTENEDOR -->
        <div class="profile-container <?=$_SESSION['tipoU'] != 'Administrador' ? 'profile-user' : 'profile-admin'; ?>">

            <!-- PERFIL CONTENEDOR -->
            <div class="profile-header">

                <div class="bio">
                    <img src="<?=$_SESSION['photo'] ?>" alt="Foto de Perfil" class="profile-pic" id="profilePic">
                    <h1 class="username"><?= $_SESSION['nom'] . ' ' . $_SESSION['ap']; ?></h1>
                    <p>
                        Amante de cuidar el bienestar de los animales y salvaguardar todas y cada una de sus vidas.
                        Amante de cuidar el bienestar de los animales y salvaguardar todas y cada una de sus vidas.
                    </p>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                    </button>
                </div>

                <div class="info-list">
                    <ul>
                        <h2>Info</h2>
                        <li>
                            <strong>Email:</strong>
                            <?= $_SESSION['email']; ?>
                        </li>
                        <li>
                            <strong>Teléfono:</strong>
                            <?= $_SESSION['numero'] ?>
                        </li>
                        <li>
                            <strong>Ubicación:</strong>
                            Nezahualcoyotl
                        </li>
                    </ul>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                    </button>
                </div>

                <div class="social-links">
                    <h2>Redes Sociales</h2>
                    <a href="https://es-la.facebook.com" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                    </a>
                    <a href="https://x.com/?lang=es" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                    </a>
                </div>
            </div>

            <!-- CONTENEDOR DE PUBLICACIONES -->
            <div class="profile-content">
                <h2>Publicaciones</h2>

                <!-- CONTENEDOR DE PUBLICACION -->
                <div class="post-cards-container">
                    <!-- PUBLICACION -->
                    <div class="post-card">
                        <a href="">
                            <img src="<?=RUTARECURSOS?>IMG/alan-king-KZv7w34tluA-unsplash.JPG" alt="Publicación" class="post-pic">
                        </a>
                        <div class="info-post-card">
                            <h3>Nombre <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h3>
                            <p>
                                Descripcion
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur maiores expedita numquam vel corrupti ipsam, illum dicta porro autem et iste fugiat nostrum corporis dolor unde maxime eius inventore voluptatibus.
                            </p>
                            <p>
                                Ubicacion
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus pariatur ex laborum aspernatur ducimus tenetur, assumenda laudantium aut dolores voluptatum quod perferendis accusantium deleniti esse quidem rem culpa doloremque possimus?
                            </p>
                            <p>
                                Fecha
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus eum omnis impedit, quas voluptatum excepturi! Debitis consectetur omnis est repellendus ipsam perferendis laboriosam, reprehenderit sequi voluptate. Iusto placeat voluptate molestiae?
                            </p>
                        </div>
                    </div>
                    <!-- PUBLICACION -->
                    <div class="post-card">
                        <a href="">
                            <img src="<?=RUTARECURSOS?>IMG/alan-king-KZv7w34tluA-unsplash.JPG" alt="Publicación" class="post-pic">
                        </a>
                        <div class="info-post-card">
                            <h3>Nombre <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h3>
                            <p>
                                Descripcion
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur maiores expedita numquam vel corrupti ipsam, illum dicta porro autem et iste fugiat nostrum corporis dolor unde maxime eius inventore voluptatibus.
                            </p>
                            <p>
                                Ubicacion
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus pariatur ex laborum aspernatur ducimus tenetur, assumenda laudantium aut dolores voluptatum quod perferendis accusantium deleniti esse quidem rem culpa doloremque possimus?
                            </p>
                            <p>
                                Fecha
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus eum omnis impedit, quas voluptatum excepturi! Debitis consectetur omnis est repellendus ipsam perferendis laboriosam, reprehenderit sequi voluptate. Iusto placeat voluptate molestiae?
                            </p>
                        </div>
                    </div>
                    <!-- PUBLICACION -->
                    <div class="post-card">
                        <a href="">
                            <img src="<?=RUTARECURSOS?>IMG/alan-king-KZv7w34tluA-unsplash.JPG" alt="Publicación" class="post-pic">
                        </a>
                        <div class="info-post-card">
                            <h3>Nombre <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h3>
                            <p>
                                Descripcion
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur maiores expedita numquam vel corrupti ipsam, illum dicta porro autem et iste fugiat nostrum corporis dolor unde maxime eius inventore voluptatibus.
                            </p>
                            <p>
                                Ubicacion
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus pariatur ex laborum aspernatur ducimus tenetur, assumenda laudantium aut dolores voluptatum quod perferendis accusantium deleniti esse quidem rem culpa doloremque possimus?
                            </p>
                            <p>
                                Fecha
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus eum omnis impedit, quas voluptatum excepturi! Debitis consectetur omnis est repellendus ipsam perferendis laboriosam, reprehenderit sequi voluptate. Iusto placeat voluptate molestiae?
                            </p>
                        </div>
                    </div>
                    <!-- PUBLICACION -->
                    <div class="post-card">
                        <a href="">
                            <img src="<?=RUTARECURSOS?>IMG/alan-king-KZv7w34tluA-unsplash.JPG" alt="Publicación" class="post-pic">
                        </a>
                        <div class="info-post-card">
                            <h3>Nombre <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h3>
                            <p>
                                Descripcion
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur maiores expedita numquam vel corrupti ipsam, illum dicta porro autem et iste fugiat nostrum corporis dolor unde maxime eius inventore voluptatibus.
                            </p>
                            <p>
                                Ubicacion
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus pariatur ex laborum aspernatur ducimus tenetur, assumenda laudantium aut dolores voluptatum quod perferendis accusantium deleniti esse quidem rem culpa doloremque possimus?
                            </p>
                            <p>
                                Fecha
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus eum omnis impedit, quas voluptatum excepturi! Debitis consectetur omnis est repellendus ipsam perferendis laboriosam, reprehenderit sequi voluptate. Iusto placeat voluptate molestiae?
                            </p>
                        </div>
                    </div>
                    <!-- PUBLICACION -->
                    <div class="post-card">
                        <a href="">
                            <img src="<?=RUTARECURSOS?>IMG/alan-king-KZv7w34tluA-unsplash.JPG" alt="Publicación" class="post-pic">
                        </a>
                        <div class="info-post-card">
                            <h3>Nombre <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h3>
                            <p>
                                Descripcion
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur maiores expedita numquam vel corrupti ipsam, illum dicta porro autem et iste fugiat nostrum corporis dolor unde maxime eius inventore voluptatibus.
                            </p>
                            <p>
                                Ubicacion
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus pariatur ex laborum aspernatur ducimus tenetur, assumenda laudantium aut dolores voluptatum quod perferendis accusantium deleniti esse quidem rem culpa doloremque possimus?
                            </p>
                            <p>
                                Fecha
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus eum omnis impedit, quas voluptatum excepturi! Debitis consectetur omnis est repellendus ipsam perferendis laboriosam, reprehenderit sequi voluptate. Iusto placeat voluptate molestiae?
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>


        <!-- AJAX PARA ALERTA DE BIENVENIDA PARA USUARIOS-->
        <?php
            if (isset($_SESSION['tipoU']) && $_SESSION['tipoU'] == 'Usuario'):
                ?>
                    <script>
                        const Toast = Swal.fire({
                            toast: true,
                            timerProgressBar: true,
                            // position: "top",
                            // icon: "success",
                            title: "<div style = 'text-align: center; font-size: 1.5em;'>¡ Bienvenid<?=$saludo?> <?=$_SESSION['nom']?> ! \n\\(^Д^)/</div> ",
                            html: '<div style="text-align: center;"><img src="<?=$_SESSION['photo']?>" style="height: 80px; border-radius: 50%;" /></div>',
                            showConfirmButton: false,
                            timer: 3000,
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
                                // toast.classList.add('custom-toast');
                            }
                        });
                    </script>
                <?php
            endif;
        ?>

    </main>

</body>
</html>
<?php } ?>

