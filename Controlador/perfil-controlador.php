
<?php

    require_once SERVERURL . 'Modelo/perfil-modelo.php';

    class PerfilControlador extends PerfilModelo {

        public function listarPostsControlador($email) {
            $query = self::conectDB() -> prepare('
                SELECT idUsuario FROM usuario
                WHERE correo_electronico = :email
            ');
            $email = self::decryption($email);
            $query -> bindParam(':email', $email);
            $query -> execute();

            $idUser = $query -> rowCount() > 0 ? $query -> fetch(PDO::FETCH_ASSOC) : '';
            $query = self::listarPostsModelo(self::encryption($idUser['idUsuario']));

            $posts = $query -> rowCount() > 0 ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];
            $apiKey = 'AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I';

            if (!empty($posts)):
                foreach ($posts as $post):
                    $latitud = $post['latitud'];
                    $longitud = $post['longitud'];
                    $ubicacion = self::geocodificacion($latitud, $longitud, $apiKey);
                    ?>
                        <!-- PUBLICACION -->
                        <div class="post-card">
                            <a href="">
                                <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?= $post['imagen'] ?>" alt="Publicación" class="post-pic">
                            </a>
                            <div class="info-post-card">
                                <h3 class="<?= str_replace(" ", "-", $post['status']) ?>"><?= $post['nombre'] ?><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h3>
                                <p><?=$post['descripcion']?></p>
                                <p><?= $ubicacion ?></p>
                                <!-- FECHA Y BOTON DE OPCIONES -->
                                <p>
                                    <strong><?= $post['fechaReporte'] ?></strong>
                                    <button id="more-options" title="Más opciones">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000"><path d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z"/></svg>
                                    </button>
                                </p>
                                <!-- MENU DESPLEGABLE DE OPCIONES -->
                                <div class="options-posts-container">
                                    <a href="#" id="delete-post" title="Eliminar" data-id="<?=$post['idAnimal']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-440v-80h560v80H200Z"/></svg>
                                    </a>
                                    <a href="" id="delete-post" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                endforeach;

            elseif (empty($posts)):
                ?>
                    <div class="empty-register empty-post-profile">
                        <h2>Aún no has hecho publicaciones</h2>
                    </div>
                <?php
            endif;

        }

        public function mostrarInfoPerfilControlador() {
            $query = self::conectDB() -> prepare('
                SELECT idUsuario FROM usuario
                WHERE correo_electronico = :email
            ');
            $query -> bindParam(':email', $_SESSION['email']);
            $query -> execute();

            $userId = ($query -> rowCount() > 0) ? $query -> fetch(PDO::FETCH_ASSOC) : [];
            $id = $userId['idUsuario'];

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM usuario
                WHERE idUsuario = '$id'
            ");

            $user = ($query -> rowCount() > 0) ? $query -> fetch(PDO::FETCH_ASSOC) : [];

            ?>
                <!-- biografia -->
                <div class="bio">
                    <!-- foto -->
                    <img src="<?=$_SESSION['photo'] ?>" alt="Foto de Perfil" class="profile-pic" id="profilePic">
                    <!-- nombre -->
                    <h1 class="username"><?= $_SESSION['nom'] . ' ' . $_SESSION['ap']; ?></h1>
                    <!-- acerca de mi -->
                    <p><?= $user['sobreMi'] ?></p>
                    <!-- editar biografia -->
                    <button><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg></button>
                </div>
                <!-- info del usuario -->
                <div class="info-list">
                    <ul>
                        <h2>Info</h2>
                        <!-- email -->
                        <li>
                            <strong>Email:</strong>
                            <?= $_SESSION['email']; ?>
                        </li>
                        <!-- telefono -->
                        <li>
                            <strong>Teléfono:</strong>
                            <?= $user['telefono'] ?? ' ¡ Completa tu perfil aquí !' ?>
                        </li>
                        <!-- ubicacion -->
                        <li>
                            <strong>Ubicación:</strong>
                            <?= $user['ubicacion'] ?? ' ¡ Completa tu perfil aquí !' ?>
                        </li>
                    </ul>
                    <!-- editar info de usuario -->
                    <button><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg></button>
                </div>
                <!-- redes sociales -->
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
            <?php
        }

    }
