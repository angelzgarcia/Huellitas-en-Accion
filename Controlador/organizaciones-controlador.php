
<?php

    require_once SERVERURL . 'Modelo/organizaciones-modelo.php';

    class OrganizacionesControl extends OrganizacionesModelo {

        public function listarOrganizacionesControl() {

            $query = self::listarOrganizacionesModelo();
            $orgs = $query -> rowCount() > 0 ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            if (!empty($orgs)):
                foreach ($orgs as $org):
                    ?>
                    <!-- CONTENEDOR DE TARJETAS -->
                        <!-- TARJETA DE ORGANIZACION -->
                        <div class="organization-target">
                            <!-- imagen -->
                            <div class="org-img">
                                <a href="#"><img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$org['imagen']?>" alt="org"></a>
                            </div>
                            <div class="org-inf">
                                <!-- nombre -->
                                <h2><?=$org['nombre']?></h2>
                                <!-- descripcion -->
                                <p>
                                    Descripción:
                                    <span>
                                        <?=$org['descripcion']?>
                                    </span>
                                </p>
                                <!-- direccion -->
                                <p>
                                    Dirección
                                    <span>
                                        <?=$org['direccion']?>
                                    </span>
                                </p>
                                <!-- numero -->
                                <p>
                                    Numero: <span><?=$org['numero']?></span>
                                </p>
                                <!-- correo -->
                                <p>
                                    Correo: <span><?=$org['correo']?></span>
                                </p>
                            </div>
                        </div>
                    <?php
                endforeach;
            else:
                ?>
                    <div class="empty-register">
                        <h2>NO HAY ORGANIZACIONES TODAVÍA</h2>
                    </div>
                <?php
            endif;

        }

        public function obtenerDireccionesControlador() {
            $query = self::ejecturarConsultaSimple('
                SELECT nombre, direccion, imagen FROM organizacion
            ');

            if ($query -> rowCount() > 0) {
                $direcciones = $query -> fetchAll(PDO::FETCH_ASSOC);
                $apiKey = 'AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I';
                $coordenadas = [];
                foreach ($direcciones as $direccion) {
                    $coord = self::obtenerCoordenadas($direccion['direccion'], $apiKey);
                    if ($coord != null) {
                        $coord['nombre'] = $direccion['nombre'];
                        $coord['direccion'] = $direccion['direccion'];
                        $coord['imagen'] = $direccion['imagen'];
                        $coordenadas[] = $coord;
                    }
                }
                return $coordenadas;
            } else {
                return [];
            }

        }

    }
