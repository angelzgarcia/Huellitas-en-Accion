
    <?php
        require_once RUTAMODELO . 'publicar-modelo.php';

        class PublicarControlador extends PublicarModelo {

            public function publicarControlador() {
                if($_SERVER['REQUEST_METHOD'] != 'POST') {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Hubo problemas al enivar los datos. Intentalo más tarde',
                            'Tipo' => ''
                        ]
                    );
                }

                $tipoAnimal = self::limpiarCadena(ucwords(strtolower($_POST['tipoAnimal']))) ?? '';
                $saludStatus = self::limpiarCadena(ucwords(strtolower($_POST['saludStatus']))) ?? '';
                $status = self::limpiarCadena(ucwords(strtolower(str_replace('-', ' ', $_POST['status'])))) ?? '';
                $nombre = self::limpiarCadena(ucwords(strtolower($_POST['nombre']))) ?? '';
                $sexo = self::limpiarCadena(ucwords(strtolower($_POST['sexo']))) ?? '';
                $raza = self::limpiarCadena(ucwords(strtolower(str_replace('-', ' ', $_POST['raza'])))) ?? '';
                $tamanio = self::limpiarCadena(ucwords(strtolower($_POST['tamanio']))) ?? '';
                $peso = self::limpiarCadena($_POST['peso']) ?? '';
                $valorEdad = self::limpiarCadena($_POST['valorEdad']) ?? '';
                $tipoEdadHidden = self::limpiarCadena($_POST['tipoEdadHidden']) ?? '';
                $descripcion = ucfirst(self::limpiarCadena($_POST['descripcion'])) ?? '';
                $imagen = $_FILES['imagen'] ?? '';
                $latitud = self::limpiarCadena($_POST['latitud']) ?? '';
                $longitud = self::limpiarCadena($_POST['longitud']) ?? '';
                $correo = self::limpiarCadena($_POST['correo']) ?? '';

                if ($latitud < 14.5374 || $latitud > 32.7201 || $longitud < -118.9347 || $longitud > -86.6904) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => 'Tu ubicación debe estar dentro de la República Mexicana.',
                            'Texto' => '',
                            'Tipo' => 'warning'
                        ]
                    );
                }

                if (!preg_match('/^[A-Za-z ]+$/', $nombre)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => '"'.$nombre.'" no es un nombre válido.',
                            'Texto' => '',
                            'Tipo' => 'warning'
                        ]
                    );
                }
                if (!preg_match('/^\d{1,2}(\.\d+)?$/', $peso)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => 'Ingresa un peso válido',
                            'Texto' => '',
                            'Tipo' => 'warning'
                        ]
                    );
                }
                if (!preg_match('/^\d{1,2}$/', $valorEdad)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => 'Ingresa una edad válida',
                            'Texto' => '',
                            'Tipo' => 'warning'
                        ]
                    );
                }
                switch ($tipoEdadHidden) {
                    case 'meses':
                        if ($valorEdad > 12) {
                            return self::sweetAlert(
                                [
                                    'Alerta' => 'simpleCentro',
                                    'Titulo' => 'Estas intentando ingresar la edad en años',
                                    'Texto' => '',
                                    'Tipo' => 'warning'
                                ]
                            );

                        } elseif ($valorEdad < 1) {
                            return self::sweetAlert(
                                [
                                    'Alerta' => 'simpleCentro',
                                    'Titulo' => 'Ingresa una edad válida',
                                    'Texto' => '',
                                    'Tipo' => 'warning'
                                ]
                            );
                        }
                        break;

                    default:
                        if ($valorEdad > 50) {
                            return self::sweetAlert(
                                [
                                    'Alerta' => 'simpleCentro',
                                    'Titulo' => 'Ingresa una edad válida',
                                    'Texto' => '',
                                    'Tipo' => 'warning'
                                ]
                            );

                        } elseif ($valorEdad < 1) {
                            return self::sweetAlert(
                                [
                                    'Alerta' => 'simpleCentro',
                                    'Titulo' => 'Estas intentando ingresar la edad en meses',
                                    'Texto' => '',
                                    'Tipo' => 'warning'
                                ]
                            );
                        }
                        break;
                }

                if (strlen($descripcion) < 50) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => 'Caracteres mínimos insuficientes',
                            'Texto' => 'Faltan: '. (50-strlen($descripcion)).'',
                            'Tipo' => 'warning'
                        ]
                    );
                } elseif (strlen($descripcion) > 500) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simpleCentro',
                            'Titulo' => '¡Demasiados caracteres!',
                            'Texto' => 'Sobran: '. (strlen($descripcion)-500).'',
                            'Tipo' => 'warning'
                        ]
                    );
                }

                if ($imagen['error'] !== UPLOAD_ERR_OK) {
                    switch ($imagen['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'Problemas con el tamaño del fichero',
                                'Tipo' => ''
                            ]);
                        case UPLOAD_ERR_PARTIAL:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'El archivo se ha subido parcialmente',
                                'Tipo' => ''
                            ]);
                        case UPLOAD_ERR_NO_FILE:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'No se subió ningún archivo',
                                'Tipo' => ''
                            ]);
                        case UPLOAD_ERR_NO_TMP_DIR:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'Fallos con la carpeta temporal, lo sentimos',
                                'Tipo' => ''
                            ]);
                        case UPLOAD_ERR_CANT_WRITE:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'No se pudo escribir el archivo en el disco',
                                'Tipo' => ''
                            ]);
                        case UPLOAD_ERR_EXTENSION:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'Se detuvo la subida del archivo',
                                'Tipo' => ''
                            ]);
                        default:
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'Error inesperado',
                                'Tipo' => ''
                            ]);
                    }

                } else {
                    $nombreImagen = basename($imagen['name']);
                    $nombreTmpImagen = $imagen['tmp_name'];
                    $dir = SERVERURL . 'Vista/Recursos/IMG/SUBIDAS/';
                    $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    $tipoArchivo = mime_content_type($nombreTmpImagen);

                    if (!in_array($tipoArchivo, $tiposPermitidos)) {
                        return self::sweetAlert([
                            'Alerta' => 'simpleCentro',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Tipo de archivo no permitido',
                            'Tipo' => ''
                        ]);

                    } else {
                        $destinoDeImagen = $dir . $nombreImagen;
                        if (!move_uploaded_file($nombreTmpImagen, $destinoDeImagen)) {
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => '\(o_o)/',
                                'Texto' => 'Error al subir la imagen, intenta de nuevo',
                                'Tipo' => ''
                            ]);
                        }
                    }
                }

                // CONSULTA ID USUARIO
                $query = self::conectDB() -> prepare('
                    SELECT idUsuario FROM usuario
                    WHERE correo_electronico = :correo
                ');
                $query -> bindParam(':correo', $correo);
                $query -> execute();

                if ($query -> rowCount() != 1)  {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => 'No pudimos conectar con tu perfil :(',
                        'Texto' => '',
                        'Tipo' => 'error'
                    ]);
                }
                $usuario = $query->fetch(PDO::FETCH_ASSOC);
                $idUsuario = $usuario['idUsuario'];

                // COUSNULTA INSERCION DE UBICACION
                $query = self::conectDB() -> prepare("
                    INSERT INTO ubicacion (latitud, longitud)
                    VALUES (:latitud, :longitud)
                ");
                $query -> bindParam(':latitud', $latitud);
                $query -> bindParam(':longitud', $longitud);
                $query -> execute();

                if ($query -> rowCount() != 1) {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => 'No se pudo determinar la ubicación.',
                        'Texto' => '',
                        'Tipo' => 'error'
                    ]);

                }

                // CONSULTA DE ULTIMA UBICACION INSERTADA
                $query = self::conectDB()->prepare('
                    SELECT * FROM ubicacion
                    ORDER BY idUbicacion DESC
                    LIMIT 1
                ');
                $query->execute();
                if ($query->rowCount() != 1) {
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => 'Hubo un error con la ubicación, lo sentimos',
                        'Texto' => '',
                        'Tipo' => 'error'
                    ]);
                }
                $ubicacion = $query->fetch(PDO::FETCH_ASSOC);
                $idUbicacion = $ubicacion['idUbicacion'];

                $edad = $tipoEdadHidden == 'meses'
                ?
                    ($valorEdad == 1
                    ?
                    ' mes'
                    :
                    ' meses')
                :
                    ($valorEdad == 1
                    ?
                    ' año'
                    :
                    ' años')
                ;

                $datos = [
                    'nombre' => $nombre,
                    'sexo' => $sexo,
                    'tipoAnimal' => $tipoAnimal,
                    'raza' => $raza,
                    'estadoSalud' => $saludStatus,
                    'status' => $status,
                    'tamanio' => $tamanio,
                    'peso' => "{$peso}kg",
                    'edad' => "$valorEdad$edad",
                    'descripcion' => $descripcion,
                    'imagen' => $nombreImagen,
                    'fechaReporte' => date('Y-m-d'),
                    'idUsuario' => $idUsuario,
                    'idUbicacion' => $idUbicacion
                ];

                foreach ($datos as $dato) {
                    if (empty($dato) || $dato == '') {
                        return self::sweetAlert([
                            'Alerta' => 'simpleCentro',
                            'Titulo' => 'Tuvimos problemas al capturar los datos ):',
                            'Texto' => '',
                            'Tipo' => 'error'
                        ]);
                    }
                }

                try {
                    $query = self::publicarModelo($datos);

                    if (!$query)  {
                        $deleted = self::eliminarUbicacion($datos['idUbicacion']);

                        if (!$deleted) {
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => 'Estamos experimentando problemas, por favor intenta más tarde',
                                // 'Texto' => $e->getMessage(),
                                'Tipo' => 'error'
                            ]);

                        } else {
                            return self::sweetAlert([
                                'Alerta' => 'simpleCentro',
                                'Titulo' => 'Lo sentimos mucho, hubo un problema al realizar la publicación',
                                // 'Texto' => $e->getMessage(),
                                'Tipo' => 'error'
                            ]);
                        }

                    } else {
                        return self::sweetAlert([
                            'Alerta' => 'limpiar',
                            'Titulo' => '(^_^)b',
                            'Texto' => '¡Tu publicación se revisará para su aprobación!',
                            'Tipo' => 'success'
                        ]);
                    }

                } catch (Exception $e) {
                    self::eliminarUbicacion($idUbicacion);
                    return self::sweetAlert([
                        'Alerta' => 'simpleCentro',
                        'Titulo' => 'Lo sentimos mucho, hubo un problema al realizar la publicación',
                        'Texto' => $e->getMessage(),
                        'Tipo' => 'error'
                    ]);

                }

            }

        }
