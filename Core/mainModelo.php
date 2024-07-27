<?php

    // if ($peticionAjax) {
    //     require_once "../Core/configApp.php";
    // } else {
    // require_once "./Core/configApp.php";
    // }
    require_once "configApp.php";

    class MainModel {

        protected function conectDB() {
            $con = new PDO(SGDB, USER, PASS);
            return $con;
        }

        protected function ejecturarConsultaSimple($consulta) {
            $respuesta = self::conectDB() -> prepare($consulta);
            $respuesta -> execute();
            return $respuesta;
        }

        public function encryption($string){
            $output=FALSE;
            $key=hash('sha256', SECRET_KEY);
            $iv=substr(hash('sha256', SECRET_IV), 0, 16);
            $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
            $output=base64_encode($output);
            return $output;
        }

        public static function decryption($string){
            $key=hash('sha256', SECRET_KEY);
            $iv=substr(hash('sha256', SECRET_IV), 0, 16);
            $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        protected function geocodificacion($latitud, $longitud, $apiKey) {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitud,$longitud&key=$apiKey";

            $response = file_get_contents($url);
            $response = json_decode($response, true);

            if (isset($response['results'][0])) {
                return $response['results'][0]['formatted_address'];
            } else {
                return "No se pudo encontrar la dirección.";
            }

        }

        protected function obtenerCoordenadas($direccion, $apiKey) {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json';

            $params = [
                'address' => urlencode($direccion),
                'key' => $apiKey
            ];

            $url .= '?' . http_build_query($params);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch); 

            curl_close($ch);

            $data = json_decode($response, true);

            if ($data['status'] === 'OK') {
                $coordenadas = $data['results'][0]['geometry']['location'];
                return [
                    'latitud' => $coordenadas['lat'],
                    'longitud' => $coordenadas['lng']
                ];
            } else {
                return null;
            }
        }

        protected function generarCodigo($letra, $longitud, $num) {
            for ($i=1; $i <= $longitud; $i++) {
                $numero = rand(0,9);
                $letra .= $numero;
            }
            return $letra ."-" . $num;
        }

        protected function limpiarCadena($cadena) {
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            $cadena = htmlspecialchars($cadena);
            $cadena = str_ireplace("SELECT * FROM", "", $cadena);
            $cadena = str_ireplace("DELETE FROM", "", $cadena);
            $cadena = str_ireplace("INSERT INTO", "", $cadena);
            $cadena = str_ireplace("SELECT *", "", $cadena);
            $cadena = str_ireplace("UPDATE", "", $cadena);
            $cadena = str_ireplace("<script src>", "", $cadena);
            $cadena = str_ireplace("<script type>", "", $cadena);
            $cadena = str_ireplace("</script>", "", $cadena);
            $cadena = str_ireplace("<script>", "", $cadena);
            $cadena = str_ireplace("<link>", "", $cadena);
            $cadena = str_ireplace("</link>", "", $cadena);
            $cadena = str_ireplace("<?php", "", $cadena);
            $cadena = str_ireplace("?>", "", $cadena);
            $cadena = str_ireplace("<?=", "", $cadena);
            $cadena = str_ireplace("<?echo", "", $cadena);
            $cadena = str_ireplace("~", "", $cadena);
            $cadena = str_ireplace("``", "", $cadena);
            $cadena = str_ireplace("||", "", $cadena);
            $cadena = str_ireplace("&&", "", $cadena);
            $cadena = str_ireplace("===", "", $cadena);
            $cadena = str_ireplace("!=", "", $cadena);
            $cadena = str_ireplace("==", "", $cadena);
            $cadena = str_ireplace("<", "", $cadena);
            $cadena = str_ireplace(">", "", $cadena);
            $cadena = str_ireplace("^", "", $cadena);
            $cadena = str_ireplace("[", "", $cadena);
            $cadena = str_ireplace("]", "", $cadena);
            $cadena = str_ireplace("{", "", $cadena);
            $cadena = str_ireplace("}", "", $cadena);
            // $cadena = str_ireplace("_", "", $cadena);
            // $cadena = str_ireplace("?", "", $cadena);
            // Aqui se perdieron 2 horas sin necesidad
            // $cadena = str_ireplace(".", "", $cadena);
            // $cadena = str_ireplace(",", "", $cadena);
            // $cadena = str_ireplace("¿", "", $cadena);
            // $cadena = str_ireplace("/", "", $cadena);
            // $cadena = str_ireplace(";", "", $cadena);
            // $cadena = str_ireplace(":", "", $cadena);
            return $cadena;
        }

        protected function sweetAlert($datos) {
            $titulo = json_encode($datos['Titulo']);
            $texto = json_encode($datos['Texto']);
            $tipo = json_encode($datos['Tipo']);

            if ($datos['Alerta'] == 'simple') {
                $alerta = '
                    <script>
                        Swal.fire({
                            position: "center",
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            showConfirmButton: false,
                            timer: 3000,
                            width: 300
                        });
                    </script>
                ';
            } elseif ($datos['Alerta'] == 'simpleCentro') {
                $didOpenCode = '';
                if ($_SESSION['tipoU'] == "Administrador") {
                    $didOpenCode = '
                        didOpen: (toast) => {
                            toast.classList.add("custom-toast-form");
                        },
                    ';
                }
                $alerta = '
                    <script>
                        Swal.fire({
                            position: "center",
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            showConfirmButton: false,
                            timer: 1600,
                            width: 310,
                            toast: true,
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
                            '.$didOpenCode.'
                        });
                    </script>
                ';

            }elseif ($datos['Alerta'] == 'eliminar') {
                $alerta = '
                    <script>
                        Swal.fire({
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            showCancelButton: true,
                            cancelButtonText: "Cancelar",
                            cancelButtonColor: "#d33",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Si, eliminar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "¡Eliminado!",
                                    icon: "success"
                                });
                                location.reload();
                            }
                        });
                    </script>
                ';
            } elseif ($datos['Alerta'] == 'confirmar') {
                $alerta = '
                    <script>
                        Swal.fire({
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            showCancelButton: true,
                            cancelButtonText: "Cancelar",
                            cancelButtonColor: "#d33",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    </script>
                ';
            } elseif ($datos['Alerta'] == 'guardar') {
                $alerta = '
                    <script>
                        Swal.fire({
                            title: '.$titulo.',
                            showDenyButton: true,
                            denyButtonText: "No guardar",
                            showCancelButton: true,
                            cancelButtonText: "Cancelar",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Guardar",
                            confirmButtonColor: "#3085d6"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire("¡Cambios guardados!", "", "success");
                            } else if (result.isDenied) {
                                Swal.fire("No se guardaron los cambios", "", "info");
                            }
                        });
                    </script>
                ';
            } elseif ($datos['Alerta'] == 'limpiar') {
                $alerta = '
                    <script>
                        Swal.fire({
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            showConfirmButton: false,
                            showCancelButton: false,
                            timer: 4000,
                            toast: true,
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
                        }).then(() => {
                            setTimeout(function() {
                                window.location.href = "'.SERVER.'perfil";
                            }, 600);
                        });
                    </script>
                ';
            } elseif ($datos['Alerta'] == 'confirmarUsuario') {
                $alerta = '
                    <script>
                        Swal.fire({
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            }elseif ($datos['Alerta'] == 'autenticacion') {
                $alerta = '
                    <script>
                        Swal.fire({
                            title: '.$titulo.',
                            text: '.$texto.',
                            icon: '.$tipo.',
                            showCancelButton: false,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "";
                        });
                    </script>
                ';
            }

            return $alerta;
        }

        protected function agregarOrganizacionForm() {
            return '
            <script>
                async function mostrarFormulario() {
                    const { value: formValues } = await Swal.fire({
                        title: "Formulario de Organización",
                        html: `
                            <form autocomplete="off" enctype="multipart/form-data">
                                <input id="nom-org" class="swal2-input" placeholder="Nombre de la organización">
                                <input id="num-org" class="swal2-input" placeholder="Número">
                                <input id="dir-org" class="swal2-input" placeholder="Dirección">
                                <textarea id="desc-org" class="swal2-textarea" placeholder="Descripción"></textarea>
                                <input type="file" id="img-org" class="swal2-file">
                            </form>
                        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                resolve({
                                    nombre: document.getElementById("nom-org").value,
                                    numero: document.getElementById("num-org").value,
                                    direccion: document.getElementById("dir-org").value,
                                    descripcion: document.getElementById("desc-org").value,
                                    imagen: document.getElementById("img-org").files[0]
                                });
                            });
                        }
                    });

                    if (formValues) {
                        enviarDatos(formValues);
                    }
                }

                function enviarDatos(datos) {
                    var formData = new FormData();
                    formData.append("nombre", datos.nombre);
                    formData.append("numero", datos.numero);
                    formData.append("direccion", datos.direccion);
                    formData.append("descripcion", datos.descripcion);
                    formData.append("imagen", datos.imagen);
                    formData.append("action", "add");

                    $.ajax({
                        type: "POST",
                        url: "'.SERVER.'Ajax/crudAjax.php",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $(".RespuestaAjax").html(response);
                        },
                        error: function() {
                            Swal.fire("Ocurrió un error inesperado", "Por favor recargue la página", "error");
                        }
                    });
                }

                document.addEventListener("DOMContentLoaded", function() {
                    mostrarFormulario();
                });
            </script>
        ';
        }

    }
