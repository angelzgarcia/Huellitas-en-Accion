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

        public static function encryption($string){
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

        protected static function getStateBoundaries($stateName) {
            $stateBoundaries = [
                'aguascalientes' => [
                    'northeast' => ['lat' => 22.467930, 'lng' => -101.999544],
                    'southwest' => ['lat' => 21.572222, 'lng' => -102.977700]
                ],
                'baja-california' => [
                    'northeast' => ['lat' => 32.718831, 'lng' => -114.722009],
                    'southwest' => ['lat' => 27.153346, 'lng' => -118.421964]
                ],
                'baja-california-sur' => [
                    'northeast' => ['lat' => 28.323139, 'lng' => -109.442458],
                    'southwest' => ['lat' => 22.870500, 'lng' => -114.895908]
                ],
                'campeche' => [
                    'northeast' => ['lat' => 20.861787, 'lng' => -89.175528],
                    'southwest' => ['lat' => 17.894728, 'lng' => -92.271587]
                ],
                'chiapas' => [
                    'northeast' => ['lat' => 17.849645, 'lng' => -90.409092],
                    'southwest' => ['lat' => 14.532369, 'lng' => -94.320797]
                ],
                'chihuahua' => [
                    'northeast' => ['lat' => 31.868074, 'lng' => -103.044534],
                    'southwest' => ['lat' => 25.419606, 'lng' => -109.292203]
                ],
                'coahuila' => [
                    'northeast' => ['lat' => 29.849764, 'lng' => -100.079045],
                    'southwest' => ['lat' => 24.334417, 'lng' => -104.570639]
                ],
                'colima' => [
                    'northeast' => ['lat' => 19.523552, 'lng' => -103.472111],
                    'southwest' => ['lat' => 18.700247, 'lng' => -104.698487]
                ],
                'cdmx' => [
                    'northeast' => ['lat' => 19.592757, 'lng' => -98.960426],
                    'southwest' => ['lat' => 19.187271, 'lng' => -99.360807]
                ],
                'durango' => [
                    'northeast' => ['lat' => 26.984909, 'lng' => -102.020614],
                    'southwest' => ['lat' => 22.565498, 'lng' => -107.994708]
                ],
                'guanajuato' => [
                    'northeast' => ['lat' => 21.991139, 'lng' => -100.345539],
                    'southwest' => ['lat' => 19.768755, 'lng' => -102.218181]
                ],
                'guerrero' => [
                    'northeast' => ['lat' => 18.915947, 'lng' => -98.014743],
                    'southwest' => ['lat' => 16.192055, 'lng' => -102.501297]
                ],
                'hidalgo' => [
                    'northeast' => ['lat' => 21.338667, 'lng' => -98.347422],
                    'southwest' => ['lat' => 19.369791, 'lng' => -99.538556]
                ],
                'jalisco' => [
                    'northeast' => ['lat' => 22.755487, 'lng' => -101.846557],
                    'southwest' => ['lat' => 18.897325, 'lng' => -105.753503]
                ],
                'mexico' => [
                    'northeast' => ['lat' => 20.179758, 'lng' => -98.552774],
                    'southwest' => ['lat' => 18.003398, 'lng' => -100.406693]
                ],
                'michoacan' => [
                    'northeast' => ['lat' => 20.428374, 'lng' => -100.020261],
                    'southwest' => ['lat' => 17.649234, 'lng' => -103.514847]
                ],
                'morelos' => [
                    'northeast' => ['lat' => 18.931875, 'lng' => -98.617646],
                    'southwest' => ['lat' => 18.339939, 'lng' => -99.359817]
                ],
                'nayarit' => [
                    'northeast' => ['lat' => 23.502462, 'lng' => -104.388248],
                    'southwest' => ['lat' => 20.712262, 'lng' => -106.933468]
                ],
                'nuevo-leon' => [
                    'northeast' => ['lat' => 27.164176, 'lng' => -98.999054],
                    'southwest' => ['lat' => 23.671708, 'lng' => -101.524282]
                ],
                'oaxaca' => [
                    'northeast' => ['lat' => 18.912792, 'lng' => -93.972220],
                    'southwest' => ['lat' => 15.894738, 'lng' => -98.745247]
                ],
                'puebla' => [
                    'northeast' => ['lat' => 20.8665109, 'lng' => -97.1503],
                    'southwest' => ['lat' => 17.4657, 'lng' => -99.0872]
                ],
                'queretaro' => [
                    'northeast' => ['lat' => 21.635462, 'lng' => -99.533128],
                    'southwest' => ['lat' => 20.102610, 'lng' => -100.529874]
                ],
                'quintana-roo' => [
                    'northeast' => ['lat' => 21.705834, 'lng' => -86.745009],
                    'southwest' => ['lat' => 17.768891, 'lng' => -89.277342]
                ],
                'san-luis-potosi' => [
                    'northeast' => ['lat' => 24.502052, 'lng' => -98.800134],
                    'southwest' => ['lat' => 21.120462, 'lng' => -102.473206]
                ],
                'sinaloa' => [
                    'northeast' => ['lat' => 27.292331, 'lng' => -106.343108],
                    'southwest' => ['lat' => 22.339691, 'lng' => -109.045223]
                ],
                'sonora' => [
                    'northeast' => ['lat' => 32.529521, 'lng' => -108.995237],
                    'southwest' => ['lat' => 26.542654, 'lng' => -115.236428]
                ],
                'tabasco' => [
                    'northeast' => ['lat' => 18.650559, 'lng' => -91.161540],
                    'southwest' => ['lat' => 16.983435, 'lng' => -94.159439]
                ],
                'tamaulipas' => [
                    'northeast' => ['lat' => 27.690120, 'lng' => -97.101537],
                    'southwest' => ['lat' => 22.573737, 'lng' => -100.734178]
                ],
                'tlaxcala' => [
                    'northeast' => ['lat' => 19.540057, 'lng' => -97.748461],
                    'southwest' => ['lat' => 19.123970, 'lng' => -98.564816]
                ],
                'veracruz' => [
                    'northeast' => ['lat' => 22.413452, 'lng' => -93.828316],
                    'southwest' => ['lat' => 17.052875, 'lng' => -98.999054]
                ],
                'yucatan' => [
                    'northeast' => ['lat' => 21.664140, 'lng' => -87.589032],
                    'southwest' => ['lat' => 19.487374, 'lng' => -90.845507]
                ],
                'zacatecas' => [
                    'northeast' => ['lat' => 25.731553, 'lng' => -101.6141],
                    'southwest' => ['lat' => 22.2260, 'lng' => -103.0581]
                ]
            ];

            if (isset($stateBoundaries[$stateName])) {
                return $stateBoundaries[$stateName];
            }

            // esta madre da lo que quiere
            $apiKey = 'AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I';
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($stateName) . ",+Mexico&key=" . $apiKey;

            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (!empty($data['results'][0]['geometry']['bounds'])) {
                return $data['results'][0]['geometry']['bounds'];
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
