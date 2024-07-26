<?php

    require_once "../Modelo/sesion-modelo.php";

    class SesionControl extends SesionModelo {

        public function iniciarSesionControl() {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $correo = self::limpiarCadena($_POST['correo']);
                $pass = self::limpiarCadena($_POST['pass']);
                $pass = self::encryption($pass);

                $datos = [
                    'email' => $correo,
                    'pass' => $pass
                ];

                $query = self::iniciarSesionModelo($datos);

                if (!$query -> rowCount() > 0) {
                    return self::sweetAlert(
                        $alerta = [
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => '¿Quién sos?, no importa, ¡Registrate gratis!',
                            'Tipo' => ''
                        ]
                    );
                }

                $dataUser = $query->fetch(PDO::FETCH_ASSOC);
                session_start(['name' => 'HA-A']);
                $_SESSION['nom'] = $dataUser['nombre'] ?? '';
                $_SESSION['ap'] = $dataUser['apellidos'] ?? '';
                $_SESSION['gen'] = $dataUser['genero'] ?? '';
                $_SESSION['photo'] = $dataUser['foto'] ?? RUTARECURSOS .'IMG/SUBIDAS/PERFILES/'. $dataUser['foto'];
                $_SESSION['tipoU'] = $dataUser['tipoUsuario'] ?? '';
                $_SESSION['email'] = $dataUser['correo_electronico'] ?? '';
                $_SESSION['numero'] = $dataUser['telefono'] ?? '';
                $_SESSION['token'] = md5(uniqid(mt_rand(), true));

                if ($dataUser['tipoUsuario'] == 'Administrador') {
                    return '<script>
                                window.location.href = "'.SERVER.'admin_dashboard"
                            </script>';
                } else {
                    return '<script>
                                window.location.href = "'.SERVER.'perfil"
                            </script>';
                }

            } else {
                return self::sweetAlert(
                    $alerta = [
                        'Alerta' => 'simple',
                        'Titulo' => '(˚Δ˚)b',
                        'Texto' => 'No pudimos iniciar la sesión, por favor intente de nuevo más tarde',
                        'Tipo' => ''
                    ]
                );
            }

        }

        public function cerrarSesionControl() {
            session_start(['name' => 'HA-A']);
            $token = self::decryption($_GET['Token']);

            $datos = [
                'usuario' => $_SESSION['tipoU'],
                'Token' => $_SESSION['token'],
                'token' => $token
            ];

            return self::cerrarSesionModelo($datos);
        }


        public function autenticarUsuarioControl($google_id, $nombre, $email, $foto) {
            $google_id = self::limpiarCadena($google_id) ?? '';
            $nom = self::limpiarCadena($nombre) ?? '';
            $correo = self::limpiarCadena($email) ?? '';
            $picture = $foto ?? '';

            $query = self::autenticarUsuarioModelo($google_id);

            if ($query->rowCount() > 0) {
                $dataUser = $query->fetch(PDO::FETCH_ASSOC);

                self::ejecturarConsultaSimple("
                    UPDATE usuario SET nombre = '$nom', correo_electronico = '$correo', foto = '$picture'
                    WHERE google_id = '$google_id'
                ");

                session_start(['name' => 'HA-A']);
                $_SESSION['google_id'] = $dataUser['google_id'] ?? '';
                $_SESSION['nom'] = $dataUser['nombre'] ?? '';
                $_SESSION['ap'] = $dataUser['apellidos'] ?? '';
                $_SESSION['gen'] = $dataUser['genero'] ?? '';
                $_SESSION['photo'] = $dataUser['foto'] ?? '';
                $_SESSION['tipoU'] = $dataUser['tipoUsuario'] ?? '';
                $_SESSION['email'] = $dataUser['correo_electronico'] ?? '';
                $_SESSION['numero'] = $dataUser['telefono'] ?? '';
                $_SESSION['token'] = md5(uniqid(mt_rand(), true));

                if ($dataUser['tipoUsuario'] == 'Administrador') {
                    echo 'admin_dashboard';
                } else {
                    echo 'perfil';
                }
            } else {
                $query = self::ejecturarConsultaSimple("
                    SELECT * FROM usuario
                    WHERE correo_electronico = '$correo'
                ");

                if ($query->rowCount() > 0) {
                    $dataUser = $query->fetch(PDO::FETCH_ASSOC);

                    self::ejecturarConsultaSimple("
                        UPDATE usuario SET google_id = '$google_id', nombre = '$nom', correo_electronico = '$correo', foto = '$picture'
                        WHERE correo_electronico = '$correo'
                    ");

                    session_start(['name' => 'HA-A']);
                    $_SESSION['google_id'] = $dataUser['google_id'] ?? '';
                    $_SESSION['nom'] = $dataUser['nombre'] ?? '';
                    $_SESSION['ap'] = $dataUser['apellidos'] ?? '';
                    $_SESSION['gen'] = $dataUser['genero'] ?? '';
                    $_SESSION['photo'] = $dataUser['foto'] ?? '';
                    $_SESSION['tipoU'] = $dataUser['tipoUsuario'] ?? '';
                    $_SESSION['email'] = $dataUser['correo_electronico'] ?? '';
                    $_SESSION['numero'] = $dataUser['telefono'] ?? '';
                    $_SESSION['token'] = md5(uniqid(mt_rand(), true));

                    if ($dataUser['tipoU'] == 'Administrador') {
                        echo 'admin_dashboard';
                    } else {
                        echo 'perfil';
                    }
                } else {
                    $agregarUsuario = self::conectDB()->prepare('
                        INSERT INTO usuario (google_id, nombre, correo_electronico, foto, tipoUsuario, confirmado)
                        VALUES(:google_id, :nombre, :correo, :foto, :tipoUsuario, :confirmado)
                    ');

                    $tipoU = 'Usuario';
                    $confirmado = 1;
                    $agregarUsuario->bindParam(':google_id', $google_id);
                    $agregarUsuario->bindParam(':nombre', $nom);
                    $agregarUsuario->bindParam(':correo', $correo);
                    $agregarUsuario->bindParam(':foto', $picture);
                    $agregarUsuario->bindParam(':tipoUsuario', $tipoU);
                    $agregarUsuario->bindParam(':confirmado', $confirmado);

                    $agregarUsuario->execute();

                    if ($agregarUsuario->rowCount() > 0) {
                        $dataUser = [
                            'google_id' => $google_id,
                            'nombre' => ucwords($nom),
                            'foto' => $picture,
                            'tipoU' => $tipoU,
                            'correo' => $correo
                        ];

                        session_start(['name' => 'HA-A']);
                        $_SESSION['google_id'] = $dataUser['google_id'] ?? '';
                        $_SESSION['nom'] = $dataUser['nombre'] ?? '';
                        $_SESSION['photo'] = $dataUser['foto'] ?? '';
                        $_SESSION['tipoU'] = $dataUser['tipoU'] ?? '';
                        $_SESSION['email'] = $dataUser['correo'] ?? '';
                        $_SESSION['token'] = md5(uniqid(mt_rand(), true));

                        if ($dataUser['tipoU'] == 'Administrador') {
                            echo 'admin_dashboard';
                        } else {
                            echo 'perfil';
                        }
                    }
                }
            }
        }



    }

