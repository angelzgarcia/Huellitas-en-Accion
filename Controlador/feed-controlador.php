
<?php

    require_once SERVERURL . 'Modelo/feed-modelo.php';

    class FeedControlador extends FeedModelo {

        public function listarFeedControlador($status, $datos) {

            $query = '';
            switch (self::limpiarCadena($status)) {
                case 'perdidos':
                    $query = self::listarPerdidosModelo();
                    break;

                case 'encontrados':
                    $query = self::listarEncontradosModelo();
                    break;

                case 'en_adopcion':
                    $query = self::listarEnAdopcionModelo();
                    break;

                case 'en_peligro':
                    $query = self::listarEnPeligroModelo();
                    break;

                case 'filtro':
                    $query = self::listarFiltradosModelo($datos);
                    break;

                default:
                    $query = self::listarFeedModelo();
                break;
            }

            $posts = $query -> rowCount() > 0 ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];
            $apiKey = 'AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I';

            if (!empty($posts)):
                foreach ($posts as $post):
                    $latitud = $post['latitud'];
                    $longitud = $post['longitud'];
                    $ubicacion = self::geocodificacion($latitud, $longitud, $apiKey);
                    ?>
                    <!-- PUBLICACION -->
                        <div class="card card-l">
                            <!-- STATUS Y SEXO -->
                            <div class="status-pet <?= $post['sexo'] ?>">
                                <!-- status -->
                                <p class="<?= str_replace(" ", "-", $post['status']) ?>">
                                    <?= $post['status'] ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                                </p>
                                <?php
                                    if ($post['sexo'] == 'Macho'):
                                        ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-160q-83 0-141.5-58.5T280-360q0-73 45.5-127.5T440-556v-171l-64 63-56-56 160-160 160 160-56 57-64-64v171q69 14 114.5 68.5T680-360q0 83-58.5 141.5T480-160Zm0-80q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0-120Z"/></svg>
                                        <?php
                                    else:
                                        ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-80h-80v-80h80v-84q-79-14-129.5-75.5T260-582q0-91 64.5-154.5T480-800q91 0 155.5 63.5T700-582q0 81-50.5 142.5T520-364v84h80v80h-80v80h-80Zm40-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Z"/></svg>
                                        <?php
                                    endif;
                                ?>
                            </div>
                            <!-- UBICACION DE REPORTE -->
                            <div class="location-pet">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                                <p><?= $ubicacion ?></p>
                            </div>
                            <!-- IMAGEN DEL ANIMAL -->
                            <div class="img-pet">
                                <a href="<?=htmlspecialchars(SERVER)?>post?r=<?=htmlspecialchars(self::limpiarCadena(self::encryption($post['idAnimal'])))?>&lat=<?=htmlspecialchars(self::limpiarCadena(self::encryption($latitud)))?>&lng=<?=htmlspecialchars(self::limpiarCadena(self::encryption($longitud)))?>">
                                    <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?= $post['imagen'] ?>" alt="Imagen 1">
                                </a>
                            </div>
                            <!-- FICHA DEL ANIMAL -->
                            <div class="card-content">
                                <!-- nombre -->
                                <h2>
                                    <?= $post['nombre'] ?>
                                </h2>
                                <!-- edad -->
                                <p>± <?= $post['edad'] ?></p>
                                <!-- raza -->
                                <p><?= $post['raza'] ?></p>
                            </div>
                        </div>
                    <?php
                endforeach;

            elseif (empty($posts)):
                ?>
                    <div class="empty-register">
                        <h2>NO HAY PUBLICACIONES TODAVÍA</h2>
                    </div>
                <?php
            endif;

        }

        public function filtrarFeedControlador() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $perro = isset($_POST['perro']) ? 1 : 0;
                $gato = isset($_POST['gato']) ? 1 : 0;
                $macho = isset($_POST['macho']) ? 1 : 0;
                $hembra = isset($_POST['hembra']) ? 1 : 0;
                $pequeño = isset($_POST['pequenio']) ? 1 : 0;
                $mediano = isset($_POST['mediano']) ? 1 : 0;
                $grande = isset($_POST['grande']) ? 1 : 0;
                $cachorroMin = isset($_POST['cachorro']) ? 0 : null;
                $cachorroMax = isset($_POST['cachorro']) ? 12 : null;
                $adultoMin = isset($_POST['adulto']) ? 13 : null;
                $adultoMax = isset($_POST['adulto']) ? 84 : null;
                $adultoMayorMin = isset($_POST['adultoMayor']) ? 85 : null;
                $estado = isset($_POST['estado']) ? self::limpiarCadena($_POST['estado']) : null;
                $status = isset($_POST['status']) ? self::limpiarCadena(ucwords(strtolower(str_replace('_', ' ', substr($_POST['status'], -1) == 's') ? substr($_POST['status'], 0, strlen($_POST['status']) - 1) : str_replace('_', ' ',$_POST['status'])))) : null;

                $limites = $estado ? self::getStateBoundaries($estado) : null;

                $datos = [
                    'perro' => $perro,
                    'gato' => $gato,
                    'macho' => $macho,
                    'hembra' => $hembra,
                    'pequeño' => $pequeño,
                    'mediano' => $mediano,
                    'grande' => $grande,
                    'cachorroMin' => $cachorroMin,
                    'cachorroMax' => $cachorroMax,
                    'adultoMin' => $adultoMin,
                    'adultoMax' => $adultoMax,
                    'adultoMayorMin' => $adultoMayorMin,
                    'limites' => $limites,
                    'status' => $status == '' ?  null : $status,
                ];

                self::listarFeedControlador('filtro', $datos);
                // return self::listarFeedControlador('filtro', $datos);
                // $purge = '';
                // foreach ($datos as $dato) {
                //     $purge .= " $dato ";
                // }
                // return '<script>alert("'.$datos['limites']['southwest']['lng'].'")</script>';
                // return '<script>alert("'.$estado.'")</script>';

            }


        }

        public function mostrarPostControlador ($idAnimal) {
            $idAnimal = self::limpiarCadena(self::decryption($idAnimal)) ?? null;
            $query = self::conectDB() -> prepare('
                SELECT a.*, u.nombre AS nombreU, u.apellidos, u.telefono, u.sobreMi
                FROM animal a
                JOIN usuario u ON a.idUsuario = u.idUsuario
                WHERE a.idAnimal = :idAnimal
            ');
            $query -> bindParam(':idAnimal', $idAnimal);
            $query -> execute();

            if ($query -> rowCount() != 1) {
                ?>
                    <h1>
                        No pudimos conectar con el perfil :(
                    </h1>
                <?php
                return;

            } else {
                $animal = $query -> fetch(PDO::FETCH_ASSOC);

                ?>
                <!-- NOMBRE Y UBICACION DEL ANIMAL -->
                    <div class="post-header-container">
                        <div class="fotos-post-container">
                            <h2><?= $animal['nombre'] ?> <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#0e1626"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg></h2>
                            <div class="post-img">
                                <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?= $animal['imagen'] ?>" alt="post-img">
                            </div>
                        </div>
                        <div class="info-post-container">
                            <!-- <h3>Perdido en:</h3> -->
                            <!-- CONTENEDOR DEL MAPA -->
                            <h2><?= $animal['status'] ?> en:</h2>
                            <div class="map-post-container">
                                <!-- mapa -->
                                <div id="mapAnimals" class="post-map-container"></div>
                            </div>
                        </div>
                    </div>

                <!-- DATOS ESPECIFICOS DEL ANIMAL -->
                    <div class="post-body-container">
                        <!-- DATOS GENERALES -->
                        <div class="datos-generales-container">
                            <h3>Datos generales</h3>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg"  height="24px" width="24px" viewBox="0 0 640 512"><path d="M176 288a112 112 0 1 0 0-224 112 112 0 1 0 0 224zM352 176c0 86.3-62.1 158.1-144 173.1l0 34.9 32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0 0 32c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-32-32 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l32 0 0-34.9C62.1 334.1 0 262.3 0 176C0 78.8 78.8 0 176 0s176 78.8 176 176zM271.9 360.6c19.3-10.1 36.9-23.1 52.1-38.4c20 18.5 46.7 29.8 76.1 29.8c61.9 0 112-50.1 112-112s-50.1-112-112-112c-7.2 0-14.3 .7-21.1 2c-4.9-21.5-13-41.7-24-60.2C369.3 66 384.4 64 400 64c37 0 71.4 11.4 99.8 31l20.6-20.6L487 41c-6.9-6.9-8.9-17.2-5.2-26.2S494.3 0 504 0L616 0c13.3 0 24 10.7 24 24l0 112c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-33.4-33.4L545 140.2c19.5 28.4 31 62.7 31 99.8c0 97.2-78.8 176-176 176c-50.5 0-96-21.3-128.1-55.4z"/></svg>
                                Sexo: <span><?= $animal['sexo'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M194-80v-395h80v315h280v-193l105-105q29-29 45-65t16-77q0-40-16.5-76T659-741l-25-26-127 127H347l-43 43-57-56 67-67h160l160-160 82 82q40 40 62 90.5T800-600q0 57-22 107.5T716-402l-82 82v240H194Zm197-187L183-475q-11-11-17-26t-6-31q0-16 6-30.5t17-25.5l84-85 124 123q28 28 43.5 64.5T450-409q0 40-15 76.5T391-267Z"/></svg>
                                Tipo de animal: <span><?= $animal['tipoAnimal'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#5790ab" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M521.3 128C586.9 128 640 181.1 640 246.6s-53.1 118.6-118.7 118.6c-42.5 0-79.7-22.3-100.7-55.8c11.4-18.2 18-39.7 18-62.8s-6.6-44.6-18-62.8l0 0 .8-1.2c20.8-32.3 56.8-53.9 97.9-54.6l2 0zM320 128c42.5 0 79.7 22.3 100.7 55.8c-11.4 18.2-18 39.7-18 62.8s6.6 44.6 18 62.8l0 0-.8 1.2c-20.8 32.3-56.8 53.9-97.9 54.6l-2 0c-42.5 0-79.7-22.3-100.7-55.8c11.4-18.2 18-39.7 18-62.8s-6.6-44.6-18-62.8l0 0 .8-1.2c20.8-32.3 56.8-53.9 97.9-54.6l2 0zm-201.3 0c42.5 0 79.7 22.3 100.7 55.8c-11.4 18.2-18 39.7-18 62.8s6.6 44.6 18 62.8l0 0-.8 1.2c-20.8 32.3-56.8 53.9-97.9 54.6l-2 0C53.1 365.1 0 312.1 0 246.6S53.1 128 118.7 128z"/></svg>
                                Raza: <span><?= $animal['raza'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-240q-33 0-56.5-23.5T80-320v-320q0-33 23.5-56.5T160-720h640q33 0 56.5 23.5T880-640v320q0 33-23.5 56.5T800-240H160Zm0-80h640v-320H680v160h-80v-160h-80v160h-80v-160h-80v160h-80v-160H160v320Zm120-160h80-80Zm160 0h80-80Zm160 0h80-80Zm-120 0Z"/></svg>
                                Tamaño: <span><?= $animal['tamanio'] ?></span>
                            </p>
                        </div>

                        <!-- DATOS ESPECIFICOS -->
                        <div class="datos-especificos-container">
                            <h3>Datos especificos</h3>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
                                Fecha de reporte: <span><?= $animal['fechaReporte'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M360-160q-19 0-34-11t-22-28l-92-241H40v-80h228l92 244 184-485q7-17 22-28t34-11q19 0 34 11t22 28l92 241h172v80H692l-92-244-184 485q-7 17-22 28t-34 11Z"/></svg>
                                Estado de salud: <span><?= $animal['estadoSalud'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-200h480l-57-400H297l-57 400Zm240-480q17 0 28.5-11.5T520-720q0-17-11.5-28.5T480-760q-17 0-28.5 11.5T440-720q0 17 11.5 28.5T480-680Zm113 0h70q30 0 52 20t27 49l57 400q5 36-18.5 63.5T720-120H240q-37 0-60.5-27.5T161-211l57-400q5-29 27-49t52-20h70q-3-10-5-19.5t-2-20.5q0-50 35-85t85-35q50 0 85 35t35 85q0 11-2 20.5t-5 19.5ZM240-200h480-480Z"/></svg>
                                Peso: <span><?= $animal['peso'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-280v-120H120v-80h120v-120h80v120h120v80H320v120h-80Zm390 80v-438l-92 66-46-70 164-118h64v560h-90Z"/></svg>
                                Edad: <span><?= $animal['edad'] ?></span>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                Descripcion: <span><?= $animal['descripcion'] ?></span>
                            </p>
                            <?php
                                if (isset($_SESSION['tipoU']) && ($_SESSION['tipoU'] == 'Usuario' || $_SESSION['tipoU'] == 'Administrador')):
                                    ?>
                                        <h3>Contacto de la familia temporal</h3>
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                                            Nombre del usuario:
                                            <span><?=$animal['nombreU'] . ' ' . $animal['apellidos']?></span>
                                        </p>
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z"/></svg>
                                            Sobre mí:
                                            <span><?=$animal['sobreMi']?></span>
                                        </p>
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M760-480q0-117-81.5-198.5T480-760v-80q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-480h-80Zm-160 0q0-50-35-85t-85-35v-80q83 0 141.5 58.5T680-480h-80Zm198 360q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z"/></svg>
                                            Teléfono:
                                            <span><?=$animal['telefono']?></span>
                                        </p>
                                    <?php
                                else:
                                    ?>
                                        <div class="button-post-contact">
                                            <a href="<?=SERVER?>loggin-form">Inicia sesión para contactar a la familia</a>
                                        </div>
                                    <?php
                                endif;
                            ?>
                        </div>
                    </div>
                <?php
            }

        }

    }
