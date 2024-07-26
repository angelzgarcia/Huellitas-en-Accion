
<?php

    require_once SERVERURL . 'Modelo/feed-modelo.php';

    class FeedControlador extends FeedModelo {

        public function listarFeedControlador() {

            $query = self::listarFeedModelo();
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
                                <p class="perdido">
                                    <?= $post['status'] ?>
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
                                <a href="#">
                                    <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?= $post['imagen'] ?>" alt="Imagen 1">
                                </a>
                            </div>
                            <!-- FICHA DEL ANIMAL -->
                            <div class="card-content">
                                <h2>
                                    <?= $post['nombre'] ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                                </h2>
                                <p>±5 años</p>
                                <p><?= $post['raza'] ?></p>
                            </div>
                        </div>
                    <?php
                endforeach;

            elseif (empty($posts)):
                ?>
                    <div class="empty-register">
                        <h2>NO HAY PUBLICACIONES TODAVIA</h2>
                    </div>
                <?php
            endif;

        }

    }
