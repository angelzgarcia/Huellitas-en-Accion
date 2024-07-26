<?php

    // SE MANIPULAN LOS DATOS RECIBIDOS POR EL USUARIO EN LAS VISTAS Y SE PASAN AL MODELO (BASE)
    require_once "../Modelo/usuario-modelo.php";
    class UsuarioControl extends UsuarioModelo {

        public function crearUsuarioControl() {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // ' / ..... / ' => son los delimitadores de la expresion regular
                // ' ^ ' => comienzo de la cadena o expresion regular
                // ' (?= .*) ' => es una ASERCIÓN (condiciones que deben cumplirse en un punto específico de la cadena)
                // ' $ ' => indica el fin de la cadena o expresion regular
                $patronPass = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
                $patronNomAp = '/^[A-Za-z ]+$/';

                $nombre = self::limpiarCadena($_POST['nombre']);
                $apellidos = self::limpiarCadena($_POST['apellidos']);
                $numero = self::limpiarCadena($_POST['numero']);
                $pass = self::limpiarCadena($_POST['pass']);
                $confPass = self::limpiarCadena($_POST['confPass']);

                if (!preg_match($patronNomAp, $nombre)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(o^^)o',
                            'Texto' => ' "'.$nombre.'" no es un nombre válido',
                            'Tipo' => ''
                        ]
                    );
                }

                if (!preg_match($patronNomAp, $apellidos)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(·_·)',
                            'Texto' => ' "'.$apellidos.'" no es un apellido válido',
                            'Tipo' => ''
                        ]
                    );
                }

                if (!preg_match($patronPass, $pass)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'confirmarUsuario',
                            'Titulo' => '(≥o≤)',
                            'Texto' => "La contraseña debe tener al menos:
                            (8 caracteres),
                            (Una letra mayúscula),
                            (Una minúscula),
                            (Un número y un carácter especial (@, $, !, %, *, ?, &)",
                            'Tipo' => ''
                        ]
                    );
                }

                if ($pass != $confPass) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '\(o_o)/',
                            'Texto' => 'Las contraseñas no coincides, intentalo de nuevo',
                            'Tipo' => ''
                        ]
                    );
                }

                if (!preg_match("/^\d{10,10}$/", $numero)) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(o^^)o',
                            'Texto' => 'Ingresa un número telefónico válido',
                            'Tipo' => ''
                        ]
                    );
                }

                $correo = self::limpiarCadena($_POST['correo']);
                $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);

                if (!$correo) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(·_·)',
                            'Texto' => 'Correo electrónico no válido',
                            'Tipo' => ''
                        ]
                    );
                }

                $queryC = self::ejecturarConsultaSimple("
                    SELECT correo_electronico FROM usuario
                    WHERE correo_electronico = '$correo'
                ");
                $queryN = self::ejecturarConsultaSimple("
                    SELECT telefono FROM usuario
                    WHERE telefono = '$numero'
                ");

                if ($queryC -> rowCount() > 0) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(;-;)',
                            'Texto' => 'El correo ya está registrado, intenta de nuevo',
                            'Tipo' => ''
                        ]
                    );
                }
                if ($queryN -> rowCount() > 0) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(=X=)',
                            'Texto' => 'El número telefónico ya está registrado, intenta de nuevo',
                            'Tipo' => ''
                        ]
                    );
                }

                $token = bin2hex(random_bytes(4));
                $titulo = "¡Gracias por registrarte en Huellitas En Acción!";
                $msj = '
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Confirma tu cuenta</title>
                        </head>
                        <style>
                            body {
                                text-align: start;
                                font-family: Arial, sans-serif;
                            }
                            main, footer, .header-banner {
                                min-width: 60vw;
                                max-width: 60vw;
                                margin: auto;
                                background-color: #f1f3f6;
                                padding: 1.5em 2em;
                                display: flex;
                                flex-direction: column;
                                gap: 10px 0;
                            }
                            .header-banner {
                                min-height: 100px;
                                background-color: #5586a4;
                                background-repeat: no-repeat;
                                background-position: 3% center;
                                background-size: 100px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: #fff;
                                font-weight: bolder;
                            }
                            main p, main h2 {
                                display: flex;
                                justify-content: start;
                                text-align: start;
                                align-items: center;
                                background-color: #fff;
                                min-height: 65px;
                                border-radius: .2em;
                            }
                            main h2 span {
                                border-radius: 2em;
                                padding: .2em;
                                background-color: #18232b;
                                color: #fff;
                                text-shadow: 0 0 .1em white;
                            }
                            p {
                                padding: 0 1.5em;
                            }
                            h2 {
                                padding: 0 1em;
                            }
                            .btn-conf {
                                text-decoration: none;
                                background-color: #18232b;
                                color: #fff;
                                font-weight: bolder;
                                padding: .7em 2.5em;
                                cursor: pointer;
                                border: none;
                                border-radius: 2em;
                            }
                            a {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 1em;
                            }
                            a:hover {
                                background-color: #2d4251;
                            }
                            footer {
                                display: flex;
                                flex-direction: column;
                                gap: 2em;
                            }
                            footer p {
                                background-color: transparent;
                                text-align: center;
                                justify-content: center;
                                align-items: center;
                            }
                            .img-foot {
                                width: 100%;
                                height: 150px;
                                border-radius: 50%;
                                background-image: url("'.RUTARECURSOS.'IMG/logo-removebg-preview - copia.png");
                                background-position: bottom;
                                background-size: contain;
                                background-repeat: no-repeat;
                            }
                            .saludo-foot {
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                align-items: center;
                                text-align: center;
                            }
                            .social-media-foot {
                                display: flex;
                                width: 100%;
                                justify-content: space-evenly;
                                align-items: center;
                            }
                            .social-media-foot svg {
                                width: 30px;
                                height: 30px;
                                fill: #5586a4;
                            }
                            footer p:last-of-type {
                                color: #707070;
                            }
                        </style>
                        <body>
                            <div class="header-banner" style="background-image: url('.RUTARECURSOS.'IMG/_252d979c-5df0-43e0-b23d-0cbe28e62864__1_-removebg-preview.png);">
                                <h1>Huellitas en Acción</h1>
                            </div>
                            <main>
                                <h2>¡Bienvenido!, tu token de verificación es:</h2>
                                <h2><span>'.$token.'</span></h2>

                                <p>Por favor, haz clic en el siguiente enlace:</p>
                                <p>
                                    <a href="'.SERVER.'confirm_email?email='.self::encryption($correo).'&token='.self::encryption($token).'" class="btn-conf">
                                        Verificar Cuenta <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>
                                    </a>
                                </p>
                            </main>

                            <footer>
                                <div class="img-foot">
                                </div>
                                <div class="saludo-foot">
                                    <p>
                                        Atentamente,
                                    </p>
                                    <strong>Digital Solutions</strong>
                                    <a href="<?=SERVER?>">
                                        HuellitasEnAcción.com.mx
                                    </a>
                                </div>
                                <div class="social-media-foot">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/></svg>
                                </div>
                                <p>
                                    Cto. Universidad Tecnológica s/n Col. Benito Juárez Nezahualcóyotl, Estado de México, C.P. 57000
                                </p>
                            </footer>
                        </body>
                        </html>

                        ';
                $encabezados = 'MIME-Version: 1.0' . "\r\n"
                                .'Content-type: text/html; charset=UTF-8' . "\r\n";

                if (!mail($correo, $titulo, $msj, $encabezados)) {
                    return self::sweetAlert([
                            'Alerta' => 'simple',
                            'Titulo' => '(˚Δ˚)b',
                            'Texto' => 'No pudimos enviar el correo de confirmación',
                            'Tipo' => ''
                    ]);
                }

                $genero = self::limpiarCadena($_POST['genero']);
                $clave = self::encryption($pass);
                $fotosF = [
                    0 => "avatar-w1.jpg",
                    1 => "avatar-w2.jpg",
                    2 => "avatar-w3.jpg",
                    3 => "avatar-w4.jpg",
                    4 => "avatar-w5.jpg",
                    5 => "avatar-w6.jpg"
                ];
                $fotosM = [
                    0 => "avatar-m1.jpg",
                    1 => "avatar-m2.jpg",
                    2 => "avatar-m3.jpg",
                    3 => "avatar-m4.jpg",
                    4 => "avatar-m5.jpg"
                ];
                $foto = str_contains($genero, "m") ? $fotosM[rand(0, count($fotosM)-1)] : $fotosF[rand(0, count($fotosF)-1)];

                // $foto = base64_encode($foto);

                $tipoUsuario = 'Usuario';
                $datosUsuario = [
                    'google_id' => null,
                    'nombre' => ucwords($nombre),
                    'apellidos' => ucwords($apellidos),
                    'correo' => $correo,
                    'pass' => $clave,
                    'num' => $numero,
                    'foto' => $foto,
                    'gene' => $genero,
                    'tipoU' => $tipoUsuario,
                    'tok' => $token,
                    'confirm' => 0
                ];

                $agregarUsuario = self::crearUsuarioModelo($datosUsuario);


                if (!$agregarUsuario) {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'simple',
                            'Titulo' => '(=X=)',
                            'Texto' => 'Ocurió un error, lo sentimos. Intentalo de nuevo.',
                            'Tipo' => ''
                        ]
                    );
                }else {
                    return self::sweetAlert(
                        [
                            'Alerta' => 'limpiar',
                            'Titulo' => '(^-^*)',
                            'Texto' => 'Por favor revisa tu email para verificar tu cuenta',
                            'Tipo' => 'success'
                        ]
                    );

                }

            } // IF POST

        } // FUNCION

    } // CLASE

