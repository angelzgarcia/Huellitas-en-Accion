<?php

    require_once RUTAMODELO . "crud-modelo.php";

    class CrudControlador extends CrudModelo {

        // INICIO CRUD ORGANIZACIONES
        public function crudOrganizacionesControl() {

            if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['action'])) {
                return self::sweetAlert([
                    'Alerta' => 'simple',
                    'Titulo' => '\(o_o)/',
                    'Texto' => 'Ocurrió un error con el envío de datos, intenta de nuevo',
                    'Tipo' => ''
                ]);

            } else {
                return match ($_POST['action']) {
                    'add' => self::agregarOrganizacionControl(),
                    'update' => self::actualizarOrganizacionControl(),
                    'delete' => self::eliminarOrganizacionControl(),
                };

            }

        }

        private function agregarOrganizacionControl() {
            $nombre = isset($_POST['nombre']) ? self::limpiarCadena(ucwords(strtolower($_POST['nombre']))) : '';
            $numero = isset($_POST['numero']) ? self::limpiarCadena($_POST['numero']) : '';
            $correo = isset($_POST['correo']) ? self::limpiarCadena($_POST['correo']) : '';
            $direccion = isset($_POST['direccion']) ? self::limpiarCadena(ucwords(strtolower($_POST['direccion']))) : '';
            $descripcion = isset($_POST['descripcion']) ? self::limpiarCadena($_POST['descripcion']) : '';
            $imagen = $_FILES['imagen'] ?? '';

            if (!preg_match("/^\d{10,10}$/", $numero)) {
                return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => 'Ingresa un número telefónico válido',
                        'Texto' => '',
                        'Tipo' => 'warning'
                ]);
            }

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM organizacion
                WHERE nombre = '$nombre'
                OR numero = '$numero'
                OR correo = '$correo'
                OR direccion = '$direccion'
            ");

            if ($query -> rowCount() > 0) {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'Uno o más datos ya están vinculados a una organización',
                    'Texto' => '',
                    'Tipo' => 'warning'
                ]);
            }

            // ESPECIFICAR POSIBLES ERRORES EN LA SUBIDA DE IMAGENS
            if ($imagen['error'] !== UPLOAD_ERR_OK) {
                switch ($imagen['error']) {
                    // case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'El archivo es demasiado grande',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_PARTIAL:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'El archivo fue subido parcialmente.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_NO_FILE:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'No se subió ningún archivo.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_NO_TMP_DIR:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Falta la carpeta temporal.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_CANT_WRITE:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'No se pudo escribir el archivo en el disco.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_EXTENSION:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Una extensión de PHP detuvo la subida del archivo.',
                            'Tipo' => ''
                        ]);
                    default:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Error desconocido.',
                            'Tipo' => ''
                    ]);
                }

            } else {
                // SE ALMACENA SOLO EL NOMBRE ORIGINAL DEL ARCHIVO, SIN LA RUTA DESDE DONDE SE SUBIÓ
                $imagenNombre = basename($imagen['name']);
                // NOMBRE DEL ARCHIVO TEMPORAL QUE SE ALMACENA EN EL SERVIDOR
                $imagenTmpNombre = $imagen['tmp_name'];
                // RUTA DESTINO DE ALMACENAMIENTO
                $dir = SERVERURL . "Vista/Recursos/IMG/SUBIDAS/";
                // DEFINIMOS LOS TIPOS DE FICHEROS PERMITIDOS
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                // DETERMINA EL TIPO DE FICHERO DE LA IMAGEN SUBIDA
                $fileType = mime_content_type($imagenTmpNombre);

                // COMPRUEBA QUE EL TIPO DE ARCHIVO ESTE PERMITIDO
                if (!in_array($fileType, $allowedTypes)) {
                    return self::sweetAlert([
                        'Alerta' => 'simple',
                        'Titulo' => '\(o_o)/',
                        'Texto' => 'Tipo de archivo no permitido',
                        'Tipo' => ''
                    ]);

                } else {
                    // SE CONSTRUYE LA RUTA COMPLETA DONDE SE ALMACENARA EL FICHERO
                    $imagenDestino = $dir . $imagenNombre;
                    // MUEVE EL ARCHIVO TEMPORAL A LA RUTA DESTINO
                    if (!move_uploaded_file($imagenTmpNombre, $imagenDestino)) {
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Error al subir la imagen, intenta de nuevo',
                            'Tipo' => ''
                        ]);
                    }

                }

                $datos = [
                    'nombre' => $nombre,
                    'numero' => $numero,
                    'correo' => $correo,
                    'direccion' => $direccion,
                    'descripcion' => $descripcion,
                    'imagen' => $imagenNombre
                ];

                $query = self::agregarOrganizacionModelo($datos);

                if ($query -> rowCount() > 0) {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => '¡Registro exitoso!',
                        'Texto' => '',
                        'Tipo' => 'success'
                    ]);

                } else {
                    return self::sweetAlert([
                        'Alerta' => 'simple',
                        'Titulo' => 'Upss...',
                        'Texto' => 'No se pudo registrar la organización correctamente',
                        'Tipo' => 'error'
                    ]);

                }

            }

        }

        private function actualizarOrganizacionControl() {
            $id = isset($_POST['id']) ? self::limpiarCadena($_POST['id']) : '';
            $nombre = isset($_POST['nombre']) ? self::limpiarCadena(ucwords(strtolower($_POST['nombre']))) : '';
            $numero = isset($_POST['numero']) ? self::limpiarCadena($_POST['numero']) : '';
            $correo = isset($_POST['correo']) ? self::limpiarCadena($_POST['correo']) : '';
            $direccion = isset($_POST['direccion']) ? self::limpiarCadena(ucwords(strtolower($_POST['direccion']))) : '';
            $descripcion = isset($_POST['descripcion']) ? self::limpiarCadena($_POST['descripcion']) : '';
            $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : '';

            if (!preg_match("/^\d{10,10}$/", $numero)) {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'Ingresa un número telefónico válido',
                    'Texto' => '',
                    'Tipo' => 'warning'
                ]);
            }

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM organizacion
                WHERE idOrganizacion = '$id'
            ");

            if ($query -> rowCount() != 1) {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'No se ha podido actualizar el registro, intenalo más tarde',
                    'Texto' => '',
                    'Tipo' => 'warning'
                ]);
            }


            if (!empty($imagen)) {
                if ($imagen['error'] === UPLOAD_ERR_OK) {
                    $imagenNombre = basename($imagen['name']);
                    $imagenTmpNombre = $imagen['tmp_name'];
                    $dir = SERVERURL . "Vista/Recursos/IMG/SUBIDAS/";
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileType = mime_content_type($imagenTmpNombre);

                    if (!in_array($fileType, $allowedTypes)) {
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => 'Tipo de archivo no permitido',
                            'Texto' => '',
                            'Tipo' => 'warning'
                        ]);
                    }

                    $imagenDestino = $dir . $imagenNombre;
                    if (!move_uploaded_file($imagenTmpNombre, $imagenDestino)) {
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => 'Error al subir la imagen, intenta de nuevo',
                            'Texto' => '',
                            'Tipo' => 'error'
                        ]);
                    }
                }
            } else {
                $datosAntiguos = $query -> fetch(PDO::FETCH_ASSOC);
                $imagenNombre = $datosAntiguos['imagen'];
            }

            $datosNuevos = [
                'id' => $id,
                'nombre' => $nombre,
                'numero' => $numero,
                'correo' => $correo,
                'direccion' => $direccion,
                'descripcion' => $descripcion,
                'imagen' => $imagenNombre
            ];

            $query = self::actualizarOrganizacionModelo($datosNuevos);

            if ($query->rowCount() > 0) {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => '¡Actualización exitosa!',
                    'Texto' => '',
                    'Tipo' => 'success'
                ]);
            } else {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'No se detectaron nuevos datos...',
                    'Texto' => '',
                    'Tipo' => 'info'
                ]);
            }

        }

        private function eliminarOrganizacionControl() {

            $id = isset($_POST['id']) ? self::limpiarCadena($_POST['id']) : '' ;
            $nombre = isset($_POST['nombre']) ? self::limpiarCadena(ucwords(strtolower($_POST['nombre']))) : '' ;
            $numero = isset($_POST['numero']) ? self::limpiarCadena($_POST['numero']) : '';
            $correo = isset($_POST['correo']) ? self::limpiarCadena($_POST['correo']) : '';
            $direccion = isset($_POST['direccion']) ? self::limpiarCadena(ucwords(strtolower($_POST['direccion']))) : '' ;
            $descripcion = isset($_POST['descripcion']) ? self::limpiarCadena($_POST['descripcion']) : '' ;

            $query = self::conectDB() -> prepare("
                SELECT * FROM organizacion
                WHERE idOrganizacion = :id
                AND nombre = :nombre
                AND numero = :numero
                AND correo = :correo
                AND direccion = :direccion
                AND descripcion = :descripcion
            ");

            $query -> bindParam(':id', $id);
            $query -> bindParam(':nombre', $nombre);
            $query -> bindParam(':numero', $numero);
            $query -> bindParam(':correo', $correo);
            $query -> bindParam(':direccion', $direccion);
            $query -> bindParam(':descripcion', $descripcion);
            $query -> execute();

            if ($query -> rowCount() > 0) {
                $deleted = self::ejecturarConsultaSimple("
                    DELETE FROM organizacion
                    WHERE idOrganizacion = '$id'
                ");

                if ($deleted -> rowCount() > 0) {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => '¡Registro eliminado!',
                        'Texto' => '',
                        'Tipo' => 'success'
                    ]);

                } else {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => 'Hubo problemas al eliminar el registro, intentalo de nuevo',
                        'Texto' => '',
                        'Tipo' => 'error'
                    ]);
                }

            } else {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'Parece que no se encontró el registro..',
                    'Texto' => '',
                    'Tipo' => 'error'
                ]);
            }


        }

        public function listarOrganizacionesAdminControl($page, $nRegisters, $busqueda) {

            // Numero de la página obtenida de la URL
            $page = (isset($page) && ((int)$page > 0) && ((int)$page % 2 == 0 || (int)$page % 2 == 1)) ? self::limpiarCadena($page) : 1;
            // Número de registros por página definidos estáticamente
            $nRegisters = self::limpiarCadena($nRegisters);
            // Entrada del buscador
            $busqueda = self::limpiarCadena($busqueda);
            // Indice del registro de inicio de cada página
            $inicio = $page * $nRegisters - $nRegisters;


            //
            $query = isset($_POST['sort'])
            ?
                ($query = $_POST['sort'] == 'sortId'
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    ORDER BY idOrganizacion DESC
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    ORDER BY nombre ASC
                    LIMIT $inicio, $nRegisters
                "))
            :
                (isset($busqueda) && !empty($busqueda)
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    WHERE nombre LIKE '%$busqueda%'
                    OR numero LIKE '%$busqueda%'
                    OR direccion LIKE '%$busqueda%'
                    OR idOrganizacion LIKE '$busqueda'
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    LIMIT $inicio, $nRegisters
                "))
            ;


            $orgs = ($query -> rowCount() > 0) ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            $totalQuery = self::ejecturarConsultaSimple("
                SELECT COUNT(*) as total FROM organizacion
            ");
            $total = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];
            $nPages = ceil($total / $nRegisters);

            // echo "Total registros encontrados: $total<br>";
            // echo "Página actual: $page<br>";
            // echo "Registros por página: $nRegisters<br>";
            // echo "Número de páginas: $nPages<br>";

            ?>
                <!-- TABLA ORGANIZACIONES -->
                <table>
                    <!-- SUBITULO DE LA TABLA Y BOTON DE ORDENAMIENTO-->
                    <caption>
                        organizaciones
                        <button title="Ordenar" id="sort-btn" class="sort-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M376-173v-125h208v125H376ZM210-418v-125h539v125H210ZM86-663v-125h788v125H86Z"/></svg>
                        </button>
                    </caption>
                    <!-- CONTENEDRO DE METODOS DE ORDENAMIENTO DE REGISTROS -->
                    <div class="sortMethodsContainer" id="sortMethodsContainer">
                        <ul>
                            <li>
                                <button class="sortId-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m240-160 40-160H120l20-80h160l40-160H180l20-80h160l40-160h80l-40 160h160l40-160h80l-40 160h160l-20 80H660l-40 160h160l-20 80H600l-40 160h-80l40-160H360l-40 160h-80Zm140-240h160l40-160H420l-40 160Z"/></svg> ID</button>
                            </li>
                            <li>
                                <button class="sortName-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m80-280 150-400h86l150 400h-82l-34-96H196l-32 96H80Zm140-164h104l-48-150h-6l-50 150Zm328 164v-76l202-252H556v-72h282v76L638-352h202v72H548ZM360-760l120-120 120 120H360ZM480-80 360-200h240L480-80Z"/></svg> Nombre</button>
                            </li>
                        </ul>
                    </div>
                    <!-- ENCABEZADO -->
                    <thead>
                        <!-- FILA ENCABEZADOS-->
                        <tr style="background-color: #ca3729;">
                            <!-- ENCABEZADOS -->
                            <th></th>
                            <!-- ID -->
                            <th><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M221.91-140.22 263.61-307H100.78L127-413h162.83l33.78-134H160.78L187-653h162.83l41.69-166.22h106.57L456.39-653h133.44l41.69-166.22h106.57L696.39-653h162.83L833-547H670.17l-33.78 134h162.83L773-307H610.17l-41.69 166.78H461.91L503.61-307H370.17l-41.69 166.78H221.91ZM396.39-413h133.44l33.78-134H430.17l-33.78 134Z"/></svg></th>
                            <th>Nombre</th>
                            <th>Número</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                        </tr>
                    </thead>

                    <!-- CUERPO -->
                    <tbody>
                        <!-- BOTON AGREGAR -->
                        <div class="button-agregar">
                            <button id="btn-add" class="btn-add" title="Agregar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg></button>
                            <div class="RespuestaAjax"></div>
                        </div>

                        <!-- INICIO DE LOS REGISTROS -->
                        <?php if (!empty($orgs) && ($total > 0) && ($page <= $nPages)) : ?>
                            <?php foreach ($orgs as $org) : ?>
                                <!-- INICIO DE FILAS DE REGISTROS -->
                                <tr data-id="<?=$org['idOrganizacion']?>"
                                    data-nombre="<?=$org['nombre']?>"
                                    data-numero="<?=$org['numero']?>"
                                    data-correo="<?=$org['correo']?>"
                                    data-direccion="<?=$org['direccion']?>"
                                    data-descripcion="<?=$org['descripcion']?>"
                                    data-foto="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$org['imagen']?>">
                                        <!-- BOTONES DE OPERACIONES CRUD -->
                                        <td>
                                            <div class="buttons-actions-tables" id="buttonsActionsTables<?=$org['idOrganizacion']?>">
                                                <!-- ELIMINAR -->
                                                <button type="button" data-id="<?=$org['idOrganizacion']?>" class="btn-delete" id="btn-delete" title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg></button>
                                                <!-- MODIFICAR -->
                                                <button type="button" data-id="<?=$org['idOrganizacion']?>" class="btn-update" id="btn-update" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#b9bfc8"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                                                <!-- SETEAR OPERACION PARA EL CRUD -->
                                                <input type="hidden" name="action" id="action">
                                            </div>
                                        </td>
                                        <!-- ID -->
                                        <td> <?=$org['idOrganizacion']?> </td>
                                        <!-- NOMBRE -->
                                        <td> <?=$org['nombre']?> </td>
                                        <!-- NUMERO -->
                                        <td> <?=$org['numero']?> </td>
                                        <!-- CORREO -->
                                        <td> <?=$org['correo']?> </td>
                                        <!-- DIRECCION -->
                                        <td> <?=$org['direccion']?> </td>
                                        <!-- DESCRIPCION -->
                                        <td class="min-w-c"> <?=$org['descripcion']?> </td>
                                        <!-- IMAGEN -->
                                        <td> <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$org['imagen']?>" class="image-table"/> </td>
                                </tr>
                                <!-- FIN DE FILA DE REGISTROS -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- EN CASO DE NO HABER REGISTROS -->
                            <tr>
                                <td>
                                </td>
                                <td colspan="7" style="letter-spacing: .5em; font-size: 1.3em;">
                                    NO SE ENCONTRARON REGISTROS....
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="7">
                                    <img src="<?=RUTARECURSOS?>IMG/joe-caione-qO-PIF84Vxg-unsplash.jpg" alt="" style="width: 100%; height: 100%;">
                                </td>
                            </tr>
                        <?php endif; ?>
                        <!-- FIN DE LOS REGISTROS -->
                    </tbody>
                    <!-- FIN DEL CUERPO -->
                </table>
                <!-- FIN DE LA TABLA -->

                <!-- PAGINADOR DE TABLAS -->
                <?php if ($total > 0  && $page <= $nPages) : ?>
                    <nav class="paginador-container">
                        <ul>
                            <?php $arrow =  ($page == 1) ? 'disabled' : 'enabled'; ?>
                                <li class="back-<?=$arrow?>">
                                    <a href="<?=SERVER?>organizaciones/<?=$page-1?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                                <?php

                                    for ($i = 1; $i <= $nPages; $i++) {
                                        $pageSelectd = $i == $page ? 'selected' :  'unselected';
                                        ?>
                                            <li class="page-<?=$pageSelectd?>";">
                                                <a href="<?=SERVER?>organizaciones/<?=$i?>">
                                                    <?=$i?>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                ?>
                            <?php $arrow = ($page == $nPages) ? 'disabled' : 'enabled'; ?>
                                <li class="next-<?=$arrow?>">
                                    <a href="<?=SERVER?>organizaciones/<?= ++$page?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php

        }
        // FIN CRUD ORGANIZACIONES


        // INICIO CRUD ANIMALES
        public function crudAnimalesControl() {
            if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['action'])) {
                return self::sweetAlert([
                    'Alerta' => 'simple',
                    'Titulo' => '\(o_o)/',
                    'Texto' => 'Ocurrió un error con el envío de datos, intenta de nuevo',
                    'Tipo' => ''
                ]);

            } else {
                return match ($_POST['action']) {
                    'delete' => self::eliminarAnimalControl()
                };

            }
        }

        private function eliminarAnimalControl() {
            $idAnimal = self::limpiarCadena($_POST['idAnimal']) ?? '';
            $idUsuario = self::limpiarCadena($_POST['idUsuario']) ?? '';
            $idUbicacion = self::limpiarCadena($_POST['idUbicacion']) ?? '';

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM animal
                WHERE idAnimal = '$idAnimal'
                AND idUsuario = '$idUsuario'
                AND idUbicacion = '$idUbicacion'
            ");

            if ($query -> rowCount() > 0) {
                $deletedAn = self::ejecturarConsultaSimple("
                    DELETE FROM animal
                    WHERE idAnimal = '$idAnimal'
                ");

                if ($deletedAn -> rowCount() > 0){
                    $deletedUb = self::ejecturarConsultaSimple("
                        DELETE FROM ubicacion
                        WHERE idUbicacion = '$idUbicacion'
                    ");

                    if ($deletedUb -> rowCount() > 0) {
                        return self::sweetAlert([
                            'Alerta' => 'simpleCentro',
                            'Titulo' => '¡Registro eliminado!',
                            'Texto' => '',
                            'Tipo' => 'success'
                        ]);

                    } else {


                    }

                }

            } else {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'Parece que no se encontró el registro..',
                    'Texto' => '',
                    'Tipo' => 'error'
                ]);
            }

        }

        public function listarAnimalesAdminControl($page, $nRegisters, $busqueda) {
            $page  = isset($page) && $page > 0 && ((int)$page % 2 == 0 || (int)$page % 2 == 1) ? $page : 1;
            $nRegisters = self::limpiarCadena($nRegisters);
            $busqueda = self::limpiarCadena($busqueda);
            $inicio = $page * $nRegisters - $nRegisters;

            $query = isset($_POST['sort'])
            ?
                ($query = $_POST['sort'] == 'sortId'
                ?
                self::ejecturarConsultaSimple("
                    SELECT a.*
                    FROM animal a
                    JOIN usuario us ON a.idUsuario = us.idUsuario
                    JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                    ORDER BY a.idAnimal DESC
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT a.*
                    FROM animal a
                    JOIN usuario us ON a.idUsuario = us.idUsuario
                    JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                    ORDER BY a.nombre ASC
                    LIMIT $inicio, $nRegisters
                "))
            :
                (isset($busqueda) && !empty($busqueda)
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM animal
                    WHERE nombre LIKE '%$busqueda%'
                    OR sexo LIKE '%$busqueda%'
                    OR descripcion LIKE '%$busqueda%'
                    OR raza LIKE '$busqueda'
                    OR tamaño LIKE '$busqueda'
                    OR estadoSalud LIKE '$busqueda'
                    OR peso LIKE '$busqueda'
                    OR status LIKE '$busqueda'
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs
                    FROM animal a
                    JOIN usuario us ON a.idUsuario = us.idUsuario
                    JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                    ORDER BY idAnimal ASC
                    LIMIT $inicio, $nRegisters
                "))
            ;

            $animales = ($query -> rowCount() > 0) ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            $totalRegistros = self::ejecturarConsultaSimple("
                SELECT COUNT(*) as total
                FROM animal
            ");
            $total = $totalRegistros -> fetch(PDO::FETCH_ASSOC)['total'] ;
            $nPages = ceil($total / $nRegisters);

            ?>
                <table>
                    <caption>
                        animales
                        <button title="Ordenar" id="sort-btn" class="sort-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M376-173v-125h208v125H376ZM210-418v-125h539v125H210ZM86-663v-125h788v125H86Z"/></svg>
                        </button>
                    </caption>
                    <!-- CONTENEDRO DE METODOS DE ORDENAMIENTO DE REGISTROS -->
                    <div class="sortMethodsContainer" id="sortMethodsContainer">
                        <ul>
                            <li>
                                <button class="sortId-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m240-160 40-160H120l20-80h160l40-160H180l20-80h160l40-160h80l-40 160h160l40-160h80l-40 160h160l-20 80H660l-40 160h160l-20 80H600l-40 160h-80l40-160H360l-40 160h-80Zm140-240h160l40-160H420l-40 160Z"/></svg> ID</button>
                            </li>
                            <li>
                                <button class="sortName-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m80-280 150-400h86l150 400h-82l-34-96H196l-32 96H80Zm140-164h104l-48-150h-6l-50 150Zm328 164v-76l202-252H556v-72h282v76L638-352h202v72H548ZM360-760l120-120 120 120H360ZM480-80 360-200h240L480-80Z"/></svg> Nombre</button>
                            </li>
                        </ul>
                    </div>
                    <!-- ENCABEZADO -->
                    <thead>
                        <!-- FILA -->
                        <!-- ENCABEZADOS -->
                        <tr style="background-color: #4a7a91;">
                            <!-- BOTONES CRUD -->
                            <th></th>
                            <!-- ID -->
                            <th><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M221.91-140.22 263.61-307H100.78L127-413h162.83l33.78-134H160.78L187-653h162.83l41.69-166.22h106.57L456.39-653h133.44l41.69-166.22h106.57L696.39-653h162.83L833-547H670.17l-33.78 134h162.83L773-307H610.17l-41.69 166.78H461.91L503.61-307H370.17l-41.69 166.78H221.91ZM396.39-413h133.44l33.78-134H430.17l-33.78 134Z"/></svg></th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Tipo</th>
                            <th>Raza</th>
                            <th>Salud</th>
                            <th>Status</th>
                            <th>Tamaño</th>
                            <th>Peso</th>
                            <th>Descripcion</th>
                            <th>Imagen</th>
                            <th>ID Usuario</th>
                            <th>Nombre Del Usuario</th>
                            <th>ID Ubicación</th>
                        </tr>
                    </thead>
                    <!-- CUERPO -->
                    <tbody>
                        <div class="RespuestaAjax"></div>
                        <!-- INICIO DE LOS REGISTROS -->
                        <?php if (!empty($animales) && ($total > 0) && ($page <= $nPages)): ?>
                            <?php foreach($animales as $animal): ?>
                                <!-- FILA -->
                                <tr data-idanimal="<?=$animal['idAnimal']?>"
                                    data-idusuario="<?=$animal['idUsuario']?>"
                                    data-idubicacion="<?=$animal['idUbicacion']?>">
                                    <!-- BOTONES DE OPERACIONES CRUD -->
                                    <td>
                                        <div class="buttons-actions-tables" id="buttonsActionsTables<?=$animal['idAnimal']?>">
                                            <!-- ELIMINAR -->
                                            <button type="button" data-id="<?=$animal['idAnimal']?>" class="btn-delete" id="btn-delete" title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg></button>
                                            <!-- SETEAR OPERACION PARA EL CRUD -->
                                            <input type="hidden" name="action" id="action">
                                        </div>
                                    </td>
                                    <!-- DATOS ANIMAL -->
                                    <!-- id animal -->
                                    <td><?=$animal['idAnimal']?></td>
                                    <!-- nombre -->
                                    <td><?=$animal['nombre']?></td>
                                    <!-- sexo -->
                                    <td><?=$animal['sexo']?></td>
                                    <!-- tipo de animal -->
                                    <td><?=$animal['tipoAnimal']?></td>
                                    <!-- raza -->
                                    <td><?=$animal['raza']?></td>
                                    <!-- estado de salud -->
                                    <td><?=$animal['estadoSalud']?></td>
                                    <!-- status -->
                                    <td><?=$animal['status']?></td>
                                    <!-- tamaño -->
                                    <td><?=$animal['tamanio']?></td>
                                    <!-- peso -->
                                    <td><?=$animal['peso']?></td>
                                    <!-- descripcion -->
                                    <td class="min-w-c"><?=$animal['descripcion']?></td>
                                    <!-- imagen -->
                                    <td><img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$animal['imagen']?>" class="image-table"/></td>
                                    <!-- id usuario -->
                                    <td><?=$animal['idUsuario']?></td>
                                    <!-- nombreUsuario -->
                                    <td>
                                        <?php
                                            $apellidos = explode(' ', $animal['apellidosUs']);
                                        ?>
                                        <?= strtok(trim($animal['nombreUs']), ' ') . ' ' . $apellidos[0] . ' ' . (count($apellidos) > 1 ? substr($apellidos[1], 0, 1) . '.' : '') ?>
                                    </td>
                                    <!-- id ubicacion -->
                                    <td><?=$animal['idUbicacion']?></td>
                                <tr>
                            <?php endforeach; ?>
                            <!-- FIN DE LOS REGISTROS -->
                        <?php else: ?>
                            <!-- EN CASO DE NO HABER REGISTROS -->
                            <tr>
                                <td>
                                </td>
                                <td colspan="13" style="letter-spacing: .5em; font-size: 1.3em;">
                                    NO SE ENCONTRARON REGISTROS....
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="13">
                                    <img src="<?=RUTARECURSOS?>IMG/joe-caione-qO-PIF84Vxg-unsplash.jpg" alt="" style="width: 50%; height: 50%; border-radius: .5em;">
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- FIN DE LA TABLA -->

                <!-- PAGINADOR DE TABLAS -->
                <?php if ($total > 0  && $page <= $nPages) : ?>
                    <nav class="paginador-container">
                        <ul>
                            <?php $arrow =  ($page == 1) ? 'disabled' : 'enabled'; ?>
                                <li class="back-<?=$arrow?>">
                                    <a href="<?=SERVER?>animales/<?=$page-1?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                                <?php

                                    for ($i = 1; $i <= $nPages; $i++) {
                                        $pageSelectd = $i == $page ? 'selected' :  'unselected';
                                        ?>
                                            <li class="page-<?=$pageSelectd?>";">
                                                <a href="<?=SERVER?>animales/<?=$i?>">
                                                    <?=$i?>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                ?>
                            <?php $arrow = ($page == $nPages) ? 'disabled' : 'enabled'; ?>
                                <li class="next-<?=$arrow?>">
                                    <a href="<?=SERVER?>animales/<?= ++$page?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php
        }
        // FIN CRUD ANIMALES


        // INICIO CRUD TIPS
        public function crudTipsControl() {
            if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['action'])) {
                return self::sweetAlert([
                    'Alerta' => 'simple',
                    'Titulo' => '\(o_o)/',
                    'Texto' => 'Ocurrió un error con el envío de datos, intenta de nuevo',
                    'Tipo' => ''
                ]);

            } else {
                return match ($_POST['action']) {
                    'add' => self::agregarTipControl(),
                    'update' => self::actualizarTipControl(),
                    'delete' => self::eliminarTipControl(),
                };

            }

        }

        private function agregarTipControl() {
            $titulo = isset($_POST['titulo']) ? self::limpiarCadena(ucwords(strtolower($_POST['titulo']))) : '';
            $descripcion = isset($_POST['descripcion']) ? self::limpiarCadena($_POST['descripcion']) : '';
            $imagen = $_FILES['imagen'] ?? '';

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM tip
                WHERE titulo = '$titulo'
            ");

            if ($query -> rowCount() > 0) {

            }

            // ESPECIFICAR POSIBLES ERRORES EN LA SUBIDA DE IMAGENS
            if ($imagen['error'] !== UPLOAD_ERR_OK) {
                switch ($imagen['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'El archivo es demasiado grande',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_PARTIAL:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'El archivo fue subido parcialmente.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_NO_FILE:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'No se subió ningún archivo.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_NO_TMP_DIR:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Falta la carpeta temporal.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_CANT_WRITE:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'No se pudo escribir el archivo en el disco.',
                            'Tipo' => ''
                        ]);
                    case UPLOAD_ERR_EXTENSION:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Una extensión de PHP detuvo la subida del archivo.',
                            'Tipo' => ''
                        ]);
                    default:
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Error desconocido.',
                            'Tipo' => ''
                    ]);
                }

            } else {
                // SE ALMACENA SOLO EL NOMBRE ORIGINAL DEL ARCHIVO, SIN LA RUTA DESDE DONDE SE SUBIÓ
                $imagenNombre = basename($imagen['name']);
                // NOMBRE DEL ARCHIVO TEMPORAL QUE SE ALMACENA EN EL SERVIDOR
                $imagenTmpNombre = $imagen['tmp_name'];
                // RUTA DESTINO DE ALMACENAMIENTO
                $dir = SERVERURL . "Vista/Recursos/IMG/SUBIDAS/";
                // DEFINIMOS LOS TIPOS DE FICHEROS PERMITIDOS
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                // DETERMINA EL TIPO DE FICHERO DE LA IMAGEN SUBIDA
                $fileType = mime_content_type($imagenTmpNombre);

                // COMPRUEBA QUE EL TIPO DE ARCHIVO ESTE PERMITIDO
                if (!in_array($fileType, $allowedTypes)) {
                    return self::sweetAlert([
                        'Alerta' => 'simple',
                        'Titulo' => '\(o_o)/',
                        'Texto' => 'Tipo de archivo no permitido',
                        'Tipo' => ''
                    ]);

                } else {
                    // SE CONSTRUYE LA RUTA COMPLETA DONDE SE ALMACENARA EL FICHERO
                    $imagenDestino = "$dir$imagenNombre";
                    // MUEVE EL ARCHIVO TEMPORAL A LA RUTA DESTINO
                    if (!move_uploaded_file($imagenTmpNombre, $imagenDestino)) {
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Error al subir la imagen, intenta de nuevo',
                            'Tipo' => ''
                        ]);
                    }

                }

                $datos = [
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'imagen' => $imagenNombre
                ];

                $query = self::agregarTipModelo($datos);

                if ($query -> rowCount() > 0) {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => '¡Registro exitoso!',
                        'Texto' => '',
                        'Tipo' => 'success'
                    ]);

                } else {
                    return self::sweetAlert([
                        'Alerta' => 'simple',
                        'Titulo' => 'Upss...',
                        'Texto' => 'El tip no se pudo registrar correctamente',
                        'Tipo' => 'error'
                    ]);

                }

            }

        }

        private function actualizarTipControl() {
            $id = isset($_POST['id']) ? self::limpiarCadena($_POST['id']) : '';
            $titulo = isset($_POST['titulo']) ? self::limpiarCadena(ucwords(strtolower($_POST['titulo']))) : '';
            $descripcion = isset($_POST['descripcion']) ? self::limpiarCadena($_POST['descripcion']) : '';
            $imagen = $_FILES['imagen'] ?? '';

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM tip
                WHERE idTip = '$id'
            ");

            if ($query -> rowCount() != 1) {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'No se ha podido ubicar el registro, intenalo más tarde',
                    'Texto' => '',
                    'Tipo' => 'warning'
                ]);
            }


            if (!empty($imagen)) {
                if ($imagen['error'] === UPLOAD_ERR_OK) {
                    $imagenNombre = basename($imagen['name']);
                    $imagenTmpNombre = $imagen['tmp_name'];
                    $dir = SERVERURL . "Vista/Recursos/IMG/SUBIDAS/";
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileType = mime_content_type($imagenTmpNombre);

                    if (!in_array($fileType, $allowedTypes)) {
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => 'Tipo de archivo no permitido',
                            'Texto' => '',
                            'Tipo' => 'warning'
                        ]);
                    }

                    $imagenDestino = $dir . $imagenNombre;
                    if (!move_uploaded_file($imagenTmpNombre, $imagenDestino)) {
                        return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => 'Error al subir la imagen, intenta de nuevo',
                            'Texto' => '',
                            'Tipo' => 'error'
                        ]);
                    }
                }
            } else {
                $datosAntiguos = $query -> fetch(PDO::FETCH_ASSOC);
                $imagenNombre = $datosAntiguos['imagen'];
            }

            $datosNuevos = [
                'id' => $id,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'imagen' => $imagenNombre
            ];

            $query = self::actualizarTipModelo($datosNuevos);

            if ($query->rowCount() > 0) {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => '¡Actualización exitosa!',
                    'Texto' => '',
                    'Tipo' => 'success'
                ]);
            } else {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'No se detectaron nuevos datos...',
                    'Texto' => '',
                    'Tipo' => 'info'
                ]);
            }

        }

        private function eliminarTipControl() {
            $idTip = self::limpiarCadena($_POST['id']) ?? '';

            $query = self::ejecturarConsultaSimple("
                SELECT * FROM tip
                WHERE idTip = '$idTip'
            ");

            if ($query -> rowCount() > 0) {
                $deletedTip = self::ejecturarConsultaSimple("
                    DELETE FROM tip
                    WHERE idTip = '$idTip'
                ");

                if ($deletedTip -> rowCount() > 0){
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => '¡Registro eliminado!',
                        'Texto' => '',
                        'Tipo' => 'success'
                    ]);

                    } else {
                        return self::sweetAlert([
                            'Alerta' => 'simpleCentro',
                            'Titulo' => 'Parece que no se pudo eliminar el registro..',
                            'Texto' => '',
                            'Tipo' => 'error'
                        ]);

                    }

            } else {
                return self::sweetAlert([
                    'Alerta' => 'simpleCentro',
                    'Titulo' => 'Parece que no se encontró el registro..',
                    'Texto' => '',
                    'Tipo' => 'error'
                ]);
            }

        }

        public function listarTipsAdminControl($page, $nRegisters, $busqueda) {
            $page = (isset($page) && ((int)$page > 0) && ((int)$page % 2 == 0 || (int)$page % 2 == 1)) ? self::limpiarCadena($page) : 1;
            $nRegisters = self::limpiarCadena($nRegisters);
            $busqueda = self::limpiarCadena($busqueda);
            $inicio = $page * $nRegisters - $nRegisters;

            $query = isset($_POST['sort'])
            ?
                ($query = $_POST['sort'] == 'sortId'
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM tip
                    ORDER BY idTip DESC
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM tip
                    ORDER BY titulo ASC
                    LIMIT $inicio, $nRegisters
                "))
            :
                (isset($busqueda) && !empty($busqueda)
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM tip
                    WHERE titulo LIKE '%$busqueda%'
                    OR descripcion LIKE '%$busqueda%'
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM tip
                    LIMIT $inicio, $nRegisters
                "))
            ;


            $tips = ($query -> rowCount() > 0) ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            $totalQuery = self::ejecturarConsultaSimple("
                SELECT COUNT(*) as total FROM tip
            ");
            $total = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];
            $nPages = ceil($total / $nRegisters);

            ?>
            <!-- INICIO DE LA TABLA -->
                <table>
                    <!-- TITULO DE LA TABLA Y BOTON DE ORDENAMIENTO -->
                    <caption>
                        tips
                        <button title="Ordenar" id="sort-btn" class="sort-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M376-173v-125h208v125H376ZM210-418v-125h539v125H210ZM86-663v-125h788v125H86Z"/></svg>
                        </button>
                    </caption>
                    <!-- CONTENEDRO DE METODOS DE ORDENAMIENTO DE REGISTROS -->
                    <div class="sortMethodsContainer" id="sortMethodsContainer">
                        <ul>
                            <li>
                                <button class="sortId-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m240-160 40-160H120l20-80h160l40-160H180l20-80h160l40-160h80l-40 160h160l40-160h80l-40 160h160l-20 80H660l-40 160h160l-20 80H600l-40 160h-80l40-160H360l-40 160h-80Zm140-240h160l40-160H420l-40 160Z"/></svg> ID</button>
                            </li>
                            <li>
                                <button class="sortName-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m80-280 150-400h86l150 400h-82l-34-96H196l-32 96H80Zm140-164h104l-48-150h-6l-50 150Zm328 164v-76l202-252H556v-72h282v76L638-352h202v72H548ZM360-760l120-120 120 120H360ZM480-80 360-200h240L480-80Z"/></svg> Nombre</button>
                            </li>
                        </ul>
                    </div>
                    <!-- ENCABEZADO -->
                    <thead>
                        <!-- FILA -->
                        <tr style="background-color: #172d50;">
                            <!-- ENCABEZADOS -->
                            <th></th>
                            <!-- ID -->
                            <th><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="#e8eaed"><path d="M221.91-140.22 263.61-307H100.78L127-413h162.83l33.78-134H160.78L187-653h162.83l41.69-166.22h106.57L456.39-653h133.44l41.69-166.22h106.57L696.39-653h162.83L833-547H670.17l-33.78 134h162.83L773-307H610.17l-41.69 166.78H461.91L503.61-307H370.17l-41.69 166.78H221.91ZM396.39-413h133.44l33.78-134H430.17l-33.78 134Z"/></svg></th>
                            <th>Titulo</th>
                            <th class="min-w-c">Descripcion</th>
                            <th>Imagen</th>
                        </tr>
                    </thead>
                    <!-- CUERPO -->
                    <tbody>
                        <!-- BOTON AGREGAR -->
                        <div class="button-agregar">
                            <button id="btn-add" class="btn-add" title="Agregar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg></button>
                            <div class="RespuestaAjax"></div>
                        </div>
                        <!-- INICIO DE LOS REGISTROS -->
                        <?php if (!empty($tips) && ($total > 0) && ($page <= $nPages)) : ?>
                            <?php foreach ($tips as $tip) : ?>
                            <!-- INICIO DE FILAS DE REGISTROS -->
                                <tr data-id="<?=$tip['idTip']?>"
                                    data-titulo="<?=$tip['titulo']?>"
                                    data-descripcion="<?=$tip['descripcion']?>"
                                    data-foto="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$tip['imagen']?>">
                                    <!-- BOTONES DE OPERACIONES CRUD -->
                                    <td>
                                        <div class="buttons-actions-tables" id="buttonsActionsTables<?=$tip['idTip']?>">
                                            <!-- ELIMINAR -->
                                            <button type="button" data-id="<?=$tip['idTip']?>" class="btn-delete" id="btn-delete" title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg></button>
                                            <!-- MODIFICAR -->
                                            <button type="button" data-id="<?=$tip['idTip']?>" class="btn-update" id="btn-update" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#b9bfc8"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                                            <!-- SETEAR OPERACION PARA EL CRUD -->
                                            <input type="hidden" name="action" id="action">
                                        </div>
                                    </td>
                                    <!-- id -->
                                    <td><?=$tip['idTip']?></td>
                                    <!-- titulo -->
                                    <td><?=$tip['titulo']?></td>
                                    <!-- descripcion -->
                                    <td class="min-w-c"><?=$tip['descripcion']?></td>
                                    <!-- imagen -->
                                    <td><img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$tip['imagen']?>" class="image-table" alt="tip"></td>
                                </tr>
                            <!-- FIN DE LOS REGISTROS -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- EN CASO DE NO HABER REGISTROS -->
                            <tr>
                                <td>
                                </td>
                                <td colspan="4" style="letter-spacing: .5em; font-size: 1.3em;">
                                    NO SE ENCONTRARON REGISTROS....
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="4">
                                    <img src="<?=RUTARECURSOS?>IMG/joe-caione-qO-PIF84Vxg-unsplash.jpg" alt="" style="width: 100%; height: 100%;">
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <!-- FIN DEL CUERPO -->
                </table>
                <!-- FIN DE LA TABLA -->

                <!-- PAGINADOR DE TABLAS -->
                <?php if ($total > 0  && $page <= $nPages) : ?>
                    <nav class="paginador-container">
                        <ul>
                            <?php $arrow =  ($page == 1) ? 'disabled' : 'enabled'; ?>
                                <li class="back-<?=$arrow?>">
                                    <a href="<?=SERVER?>tips/<?=$page-1?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                                <?php

                                    for ($i = 1; $i <= $nPages; $i++) {
                                        $pageSelectd = $i == $page ? 'selected' :  'unselected';
                                        ?>
                                            <li class="page-<?=$pageSelectd?>";">
                                                <a href="<?=SERVER?>tips/<?=$i?>">
                                                    <?=$i?>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                ?>
                            <?php $arrow = ($page == $nPages) ? 'disabled' : 'enabled'; ?>
                                <li class="next-<?=$arrow?>">
                                    <a href="<?=SERVER?>tips/<?= ++$page?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php
        }

        // FIN CRUD TIPS


        // INICIO CRUD USUARIOS
        public function eliminarUsuarioControl() {

        }

        public function listarUsuariosControl($page, $nRegisters, $busqueda) {
            $page  = isset($page) && $page > 0 && ((int)$page % 2 == 0 || (int)$page % 2 == 1) ? $page : 1;
            $nRegisters = self::limpiarCadena($nRegisters);
            $busqueda = self::limpiarCadena($busqueda);
            $inicio = $page * $nRegisters - $nRegisters;

            $query = isset($_POST['sort'])
            ?
                ($query = $_POST['sort'] == 'sortId'
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FORM usuario
                    ORDER BY idUsuario DESC
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM usuario
                    ORDER BY nombre ASC
                    LIMIT $inicio, $nRegisters
                "))
            :
                (isset($busqueda) && !empty($busqueda)
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM usuario
                    WHERE idUsuario LIKE %$busqueda%
                    OR nombre LIKE %$busqueda%
                    OR apellidos LIKE %$busqueda%
                    OR correo_electronico LIKE %$busqueda%
                    OR telefono LIKE %$busqueda%
                    OR genero LIKE %$busqueda%
                    OR tipoUsuario LIKE %$busqueda%
                    OR confirmado LIKE %$busqueda%
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM usuario
                    LIMIT $inicio, $nRegisters
                "))
            ;

            $usuarios = ($query -> rowCount() > 0) ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];
            $totalR = self::ejecturarConsultaSimple("
                SELECT COUNT(*) as total
                FROM usuario
            ");
            $total = $totalR -> fetch(PDO::FETCH_ASSOC)['total'];
            $nPages = ceil((($total / $nRegisters) < 1) ? 1: $total / $nRegisters);

            ?>
            <!-- TABLA DE UBICACIONES -->
            <table class="table-users">
                <caption>
                    usuarios
                    <button title="Ordenar" id="sort-btn" class="sort-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M376-173v-125h208v125H376ZM210-418v-125h539v125H210ZM86-663v-125h788v125H86Z"/></svg>
                    </button>
                </caption>
                <!-- CONTENEDRO DE METODOS DE ORDENAMIENTO DE REGISTROS -->
                <div class="sortMethodsContainer" id="sortMethodsContainer">
                    <ul>
                        <li>
                            <button class="sortId-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m240-160 40-160H120l20-80h160l40-160H180l20-80h160l40-160h80l-40 160h160l40-160h80l-40 160h160l-20 80H660l-40 160h160l-20 80H600l-40 160h-80l40-160H360l-40 160h-80Zm140-240h160l40-160H420l-40 160Z"/></svg> ID</button>
                        </li>
                        <li>
                            <button class="sortName-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m80-280 150-400h86l150 400h-82l-34-96H196l-32 96H80Zm140-164h104l-48-150h-6l-50 150Zm328 164v-76l202-252H556v-72h282v76L638-352h202v72H548ZM360-760l120-120 120 120H360ZM480-80 360-200h240L480-80Z"/></svg> Nombre</button>
                        </li>
                    </ul>
                </div>
                <!-- ENCABEZADO -->
                <thead>
                    <!-- FILA -->
                    <!-- ENCABEZADOS -->
                    <tr style="background-color: #d9ac2a;">
                        <!-- ENCABEZADOS -->
                        <th></th>
                        <!-- ID -->
                        <th><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="#e8eaed"><path d="M221.91-140.22 263.61-307H100.78L127-413h162.83l33.78-134H160.78L187-653h162.83l41.69-166.22h106.57L456.39-653h133.44l41.69-166.22h106.57L696.39-653h162.83L833-547H670.17l-33.78 134h162.83L773-307H610.17l-41.69 166.78H461.91L503.61-307H370.17l-41.69 166.78H221.91ZM396.39-413h133.44l33.78-134H430.17l-33.78 134Z"/></svg></th>
                        <th>Google ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Teléfono</th>
                        <th>Foto</th>
                        <th>Género</th>
                        <th>Tipo de Usuario</th>
                        <th>Token</th>
                        <th>Verificado</th>
                    </tr>
                </thead>
                <!-- CUERPO -->
                <tbody>
                    <div class="RespuestaAjax"></div>
                    <!-- INICIO DE LOS REGISTROS -->
                    <?php if (!empty($usuarios) && ($total > 0) && ($page <= $nPages)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <!-- FILA -->
                            <tr>
                                <!-- BOTONES DE OPERACIONES CRUD -->
                                <td>
                                    <div class="buttons-actions-tables" id="buttonsActionsTables<?=$usuario['idAnimal']?>">
                                        <!-- ELIMINAR -->
                                        <button type="button" data-id="<?=$usuario['idUsuario']?>" class="btn-delete" id="btn-delete" title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg></button>
                                        <!-- SETEAR OPERACION PARA EL CRUD -->
                                        <input type="hidden" name="action" id="action">
                                    </div>
                                </td>
                                <!-- DATOS -->
                                <!-- id usuario -->
                                <td><?=$usuario['idUsuario'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- google id -->
                                <td><?=$usuario['google_id'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- nombre -->
                                <td><?=$usuario['nombre'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- apellidos -->
                                <td><?= $usuario['apellidos'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- correo electronico -->
                                <td><?=$usuario['correo_electronico'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- contraseña -->
                                <td><?=$usuario['contraseña'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- numero -->
                                <td><?=$usuario['telefono'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- foto -->
                                <td><img src="<?= $usuario['google_id'] ? $usuario['foto'] : RUTARECURSOS .'IMG/SUBIDAS/PERFILES/'. $usuario['foto']; ?>" class="image-table image-iser-table"/> </td>
                                <!-- genero -->
                                <td><?=$usuario['genero'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- tipo de usuario -->
                                <td><?=$usuario['tipoUsuario'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- token de confirmacion -->
                                <td><?=$usuario['token'] ?? '<strong><em>NULO</em></strong>' ?></td>
                                <!-- verificado -->
                                <td><?=$usuario['confirmado'] ?? '<strong><em>NULO</em></strong>' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- FIN DE REGISTROS -->
                    <?php else: ?>
                    <!-- EN CASO DE NO HABER REGISTROS -->
                        <!-- EN CASO DE NO HABER REGISTROS -->
                        <tr>
                            <td>
                            </td>
                            <td colspan="13" style="letter-spacing: .5em; font-size: 1.3em;">
                                NO SE ENCONTRARON REGISTROS....
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="13">
                                <img src="<?=RUTARECURSOS?>IMG/joe-caione-qO-PIF84Vxg-unsplash.jpg" alt="" style="width: 50%; height: 50%; border-radius: .5em;">
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- FIN DE LA TABLA -->

            <!-- PAGINADOR DE TABLAS -->
            <?php if ($total > 0  && $page <= $nPages) : ?>
                    <nav class="paginador-container">
                        <ul>
                            <?php $arrow =  ($page == 1) ? 'disabled' : 'enabled'; ?>
                                <li class="back-<?=$arrow?>">
                                    <a href="<?=SERVER?>usuarios/<?=$page-1?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                            <?php
                                for ($i = 1; $i <= $nPages; $i++) {
                                    $pageSelectd = $i == $page ? 'selected' :  'unselected';
                                    ?>
                                        <li class="page-<?=$pageSelectd?>";">
                                            <a href="<?=SERVER?>usuarios/<?=$i?>">
                                                <?=$i?>
                                            </a>
                                        </li>
                                    <?php
                                }
                            ?>
                            <?php $arrow = ($page == $nPages) ? 'disabled' : 'enabled'; ?>
                                <li class="next-<?=$arrow?>">
                                    <a href="<?=SERVER?>usuarios/<?= ++$page?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php
        }

        // FIN CRUD USUARIOS


        // INICIO CRUD BLOG
        public function crudBlogControl() {

        }

        private function agregarNoticiaControl() {

        }

        private function actualizarNoticiaControl() {

        }

        private function eliminarNoticiaControl() {

        }

        public function listarNoticiasControl($page, $nRegisters, $busqueda) {
            $page = (isset($page) && ((int)$page > 0) && ((int)$page % 2 == 0 || (int)$page % 2 == 1)) ? self::limpiarCadena($page) : 1;
            $nRegisters = self::limpiarCadena($nRegisters);
            $busqueda = self::limpiarCadena($busqueda);
            $inicio = $page * $nRegisters - $nRegisters;

            $query = isset($_POST['sort'])
            ?
                ($query = $_POST['sort'] == 'sortId'
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    ORDER BY idOrganizacion DESC
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    ORDER BY nombre ASC
                    LIMIT $inicio, $nRegisters
                "))
            :
                (isset($busqueda) && !empty($busqueda)
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    WHERE nombre LIKE '%$busqueda%'
                    OR numero LIKE '%$busqueda%'
                    OR direccion LIKE '%$busqueda%'
                    OR idOrganizacion LIKE '$busqueda'
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM organizacion
                    LIMIT $inicio, $nRegisters
                "))
            ;


            $orgs = ($query -> rowCount() > 0) ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            $totalQuery = self::ejecturarConsultaSimple("
                SELECT COUNT(*) as total FROM organizacion
            ");
            $total = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];
            $nPages = ceil($total / $nRegisters);

            ?>
                <!-- TABLA ORGANIZACIONES -->
                <table>
                    <!-- SUBITULO DE LA TABLA Y BOTON DE ORDENAMIENTO-->
                    <caption>
                        organizaciones
                        <button title="Ordenar" id="sort-btn" class="sort-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M376-173v-125h208v125H376ZM210-418v-125h539v125H210ZM86-663v-125h788v125H86Z"/></svg>
                        </button>
                    </caption>
                    <!-- CONTENEDRO DE METODOS DE ORDENAMIENTO DE REGISTROS -->
                    <div class="sortMethodsContainer" id="sortMethodsContainer">
                        <ul>
                            <li>
                                <button class="sortId-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m240-160 40-160H120l20-80h160l40-160H180l20-80h160l40-160h80l-40 160h160l40-160h80l-40 160h160l-20 80H660l-40 160h160l-20 80H600l-40 160h-80l40-160H360l-40 160h-80Zm140-240h160l40-160H420l-40 160Z"/></svg> ID</button>
                            </li>
                            <li>
                                <button class="sortName-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m80-280 150-400h86l150 400h-82l-34-96H196l-32 96H80Zm140-164h104l-48-150h-6l-50 150Zm328 164v-76l202-252H556v-72h282v76L638-352h202v72H548ZM360-760l120-120 120 120H360ZM480-80 360-200h240L480-80Z"/></svg> Nombre</button>
                            </li>
                        </ul>
                    </div>
                    <!-- ENCABEZADO -->
                    <thead>
                        <!-- FILA ENCABEZADOS-->
                        <tr style="background-color: #ca3729;">
                            <!-- ENCABEZADOS -->
                            <th></th>
                            <!-- ID -->
                            <th><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M221.91-140.22 263.61-307H100.78L127-413h162.83l33.78-134H160.78L187-653h162.83l41.69-166.22h106.57L456.39-653h133.44l41.69-166.22h106.57L696.39-653h162.83L833-547H670.17l-33.78 134h162.83L773-307H610.17l-41.69 166.78H461.91L503.61-307H370.17l-41.69 166.78H221.91ZM396.39-413h133.44l33.78-134H430.17l-33.78 134Z"/></svg></th>
                            <th>Nombre</th>
                            <th>Número</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                        </tr>
                    </thead>

                    <!-- CUERPO -->
                    <tbody>
                        <!-- BOTON AGREGAR -->
                        <div class="button-agregar">
                            <button id="btn-add" class="btn-add" title="Agregar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg></button>
                            <div class="RespuestaAjax"></div>
                        </div>

                        <!-- INICIO DE LOS REGISTROS -->
                        <?php if (!empty($orgs) && ($total > 0) && ($page <= $nPages)) : ?>
                            <?php foreach ($orgs as $org) : ?>
                                <!-- INICIO DE FILAS DE REGISTROS -->
                                <tr data-id="<?=$org['idOrganizacion']?>"
                                    data-nombre="<?=$org['nombre']?>"
                                    data-numero="<?=$org['numero']?>"
                                    data-correo="<?=$org['correo']?>"
                                    data-direccion="<?=$org['direccion']?>"
                                    data-descripcion="<?=$org['descripcion']?>"
                                    data-foto="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$org['imagen']?>">
                                        <!-- BOTONES DE OPERACIONES CRUD -->
                                        <td>
                                            <div class="buttons-actions-tables" id="buttonsActionsTables<?=$org['idOrganizacion']?>">
                                                <!-- ELIMINAR -->
                                                <button type="button" data-id="<?=$org['idOrganizacion']?>" class="btn-delete" id="btn-delete" title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg></button>
                                                <!-- MODIFICAR -->
                                                <button type="button" data-id="<?=$org['idOrganizacion']?>" class="btn-update" id="btn-update" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#b9bfc8"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                                                <!-- SETEAR OPERACION PARA EL CRUD -->
                                                <input type="hidden" name="action" id="action">
                                            </div>
                                        </td>
                                        <!-- ID -->
                                        <td> <?=$org['idOrganizacion']?> </td>
                                        <!-- NOMBRE -->
                                        <td> <?=$org['nombre']?> </td>
                                        <!-- NUMERO -->
                                        <td> <?=$org['numero']?> </td>
                                        <!-- CORREO -->
                                        <td> <?=$org['correo']?> </td>
                                        <!-- DIRECCION -->
                                        <td> <?=$org['direccion']?> </td>
                                        <!-- DESCRIPCION -->
                                        <td class="min-w-c"> <?=$org['descripcion']?> </td>
                                        <!-- IMAGEN -->
                                        <td> <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$org['imagen']?>" class="image-table"/> </td>
                                </tr>
                                <!-- FIN DE FILA DE REGISTROS -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- EN CASO DE NO HABER REGISTROS -->
                            <tr>
                                <td>
                                </td>
                                <td colspan="7" style="letter-spacing: .5em; font-size: 1.3em;">
                                    NO SE ENCONTRARON REGISTROS....
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="7">
                                    <img src="<?=RUTARECURSOS?>IMG/joe-caione-qO-PIF84Vxg-unsplash.jpg" alt="" style="width: 100%; height: 100%;">
                                </td>
                            </tr>
                        <?php endif; ?>
                        <!-- FIN DE LOS REGISTROS -->
                    </tbody>
                    <!-- FIN DEL CUERPO -->
                </table>
                <!-- FIN DE LA TABLA -->

                <!-- PAGINADOR DE TABLAS -->
                <?php if ($total > 0  && $page <= $nPages) : ?>
                    <nav class="paginador-container">
                        <ul>
                            <?php $arrow =  ($page == 1) ? 'disabled' : 'enabled'; ?>
                                <li class="back-<?=$arrow?>">
                                    <a href="<?=SERVER?>organizaciones/<?=$page-1?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                                <?php

                                    for ($i = 1; $i <= $nPages; $i++) {
                                        $pageSelectd = $i == $page ? 'selected' :  'unselected';
                                        ?>
                                            <li class="page-<?=$pageSelectd?>";">
                                                <a href="<?=SERVER?>organizaciones/<?=$i?>">
                                                    <?=$i?>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                ?>
                            <?php $arrow = ($page == $nPages) ? 'disabled' : 'enabled'; ?>
                                <li class="next-<?=$arrow?>">
                                    <a href="<?=SERVER?>organizaciones/<?= ++$page?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php
        }
        // FIN CRUD BLOG


        // INICIO CRUD UBICACIONES
        public function listarUbicacionesControl($page, $nRegisters, $busqueda) {
            $page = (isset($page) && (int)$page > 0) && ((int)$page % 2 == 0 || (int)$page % 2 == 1) ? self::limpiarCadena($page): 1;
            $nRegisters = self::limpiarCadena($nRegisters);
            $busqueda = self::limpiarCadena($busqueda);
            $inicio = $page * $nRegisters - $nRegisters;

            $query = isset($_POST['sort'])
            ?
                ($query = $_POST['sort'] == 'sortId'
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FORM ubicacion
                    ORDER BY idUbicacion DESC
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM ubicacion
                    ORDER BY idUbicacion ASC
                    LIMIT $inicio, $nRegisters
                "))
            :
                (isset($busqueda) && !empty($busqueda)
                ?
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM ubicacion
                    WHERE latitud LIKE %$busqueda%
                    OR longitud LIKE %$busqueda%
                    LIMIT $inicio, $nRegisters
                ")
                :
                self::ejecturarConsultaSimple("
                    SELECT SQL_CALC_FOUND_ROWS * FROM ubicacion
                    LIMIT $inicio, $nRegisters
                "))
            ;

            $ubicaciones = ($query -> rowCount() > 0) ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];
            $totalR = self::ejecturarConsultaSimple("
                SELECT COUNT(*) as total FROM ubicacion
            ");
            $total = $totalR -> fetch(PDO::FETCH_ASSOC)['total'];
            $nPages = ceil($total/$nRegisters);

            ?>
            <!-- TABLA DE UBICACIONES -->
                <table class="table-locations">
                    <!-- SUBTITULO DE LA TABLA Y BOTON DE ORDENAMIENTO -->
                    <caption style="margin: 0 1.5em 1em 0;">
                        ubicaciones
                        <button title="Ordenar" id="sort-btn" class="sort-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M376-173v-125h208v125H376ZM210-418v-125h539v125H210ZM86-663v-125h788v125H86Z"/></svg>
                        </button>
                    </caption>
                    <!-- CONTENEDRO DE METODOS DE ORDENAMIENTO DE REGISTROS -->
                    <div class="sortMethodsContainer" id="sortMethodsContainer">
                        <ul>
                            <li>
                                <button class="sortId-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m240-160 40-160H120l20-80h160l40-160H180l20-80h160l40-160h80l-40 160h160l40-160h80l-40 160h160l-20 80H660l-40 160h160l-20 80H600l-40 160h-80l40-160H360l-40 160h-80Zm140-240h160l40-160H420l-40 160Z"/></svg> ID</button>
                            </li>
                            <li>
                                <button class="sortName-btn"><svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e8eaed"><path d="m80-280 150-400h86l150 400h-82l-34-96H196l-32 96H80Zm140-164h104l-48-150h-6l-50 150Zm328 164v-76l202-252H556v-72h282v76L638-352h202v72H548ZM360-760l120-120 120 120H360ZM480-80 360-200h240L480-80Z"/></svg> Nombre</button>
                            </li>
                        </ul>
                    </div>
                    <!-- ENCABEZADO -->
                    <thead>
                        <!-- FILA -->
                        <tr style="background-color: #749940;">
                            <!-- ENCABEZADOS -->
                            <th style="visibility: visible; background-color: #749940; border-radius: 1em 0 0 0;"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M221.91-140.22 263.61-307H100.78L127-413h162.83l33.78-134H160.78L187-653h162.83l41.69-166.22h106.57L456.39-653h133.44l41.69-166.22h106.57L696.39-653h162.83L833-547H670.17l-33.78 134h162.83L773-307H610.17l-41.69 166.78H461.91L503.61-307H370.17l-41.69 166.78H221.91ZM396.39-413h133.44l33.78-134H430.17l-33.78 134Z"/></svg></th>
                            <th style="border-radius: 0;">Latitud</th>
                            <th>Longitud</th>
                        </tr>
                    </thead>
                    <!-- CUERPO -->
                    <tbody class="tbody-locations">
                        <!-- INICIO DE LOS REGISTROS -->
                        <?php if (!empty($ubicaciones) && ($total > 0) && $page <= $nPages ): ?>
                            <?php foreach ($ubicaciones as $ub): ?>
                                <tr>
                                    <!-- DATOS -->
                                    <!-- id -->
                                    <td style="border-radius: 0 0 0 1em"><?=$ub['idUbicacion']?></td>
                                    <!-- latitud -->
                                    <td style="border-radius: 0; font-weight: normal;"><?=$ub['latitud']?></td>
                                    <!-- longitud -->
                                    <td><?=$ub['longitud']?></td>
                                </tr>
                            <?php endforeach; ?>
                        <!-- FIN DE LOS REGISTROS -->
                        <?php else: ?>
                        <!-- EN CASO DE NO HABER REGISTROS -->
                            <tr>
                                <!-- <td>
                                </td> -->
                                <td colspan="3" style="letter-spacing: .5em; font-size: 1.3em;">
                                    NO SE ENCONTRARON REGISTROS....
                                </td>
                            </tr>
                            <tr>
                                <!-- <td></td> -->
                                <td colspan="3">
                                    <img src="<?=RUTARECURSOS?>IMG/joe-caione-qO-PIF84Vxg-unsplash.jpg" alt="" style="width: 90%; height: 100%;">
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <!-- FIN DE LA TABLA -->

            <!-- PAGINADOR DE TABLAS -->
            <?php if ($total > 0  && $page <= $nPages) : ?>
                    <nav class="paginador-container">
                        <ul>
                            <?php $arrow =  ($page == 1) ? 'disabled' : 'enabled'; ?>
                                <li class="back-<?=$arrow?>">
                                    <a href="<?=SERVER?>ubicaciones/<?=$page-1?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                            <?php
                                for ($i = 1; $i <= $nPages; $i++) {
                                    $pageSelectd = $i == $page ? 'selected' :  'unselected';
                                    ?>
                                        <li class="page-<?=$pageSelectd?>";">
                                            <a href="<?=SERVER?>ubicaciones/<?=$i?>">
                                                <?=$i?>
                                            </a>
                                        </li>
                                    <?php
                                }
                            ?>
                            <?php $arrow = ($page == $nPages) ? 'disabled' : 'enabled'; ?>
                                <li class="next-<?=$arrow?>">
                                    <a href="<?=SERVER?>ubicaciones/<?= ++$page?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M224.78-194.5 428.37-480 224.78-765.5h111.63L540-480 336.41-194.5H224.78Zm251.63 0L680-480 476.41-765.5H587.8L791.63-480 587.8-194.5H476.41Z"/></svg>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php
        }
        // FIN CRUD UBICACIONES




    }

