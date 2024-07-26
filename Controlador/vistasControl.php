<?php

    require_once RUTAMODELO . "vistasModelo.php";
    class VistasControl extends VistasModelo{

        public function obtenerLayout() {
            return include_once "./Vista/layout.php";
        }

        public function obtenerVistasControlador() {
            if (isset($_GET['views'])) {
                $rutas = explode("/", $_GET['views']);
                // foreach ($rutas as $ruta) {
                    $respuesta = VistasModelo::obtenerVistasModelo($rutas[0]);
                    if ($respuesta == '404') {
                        return '404';
                    }
                // }
            } else {
                $respuesta = "index.php";
            }
            return $respuesta;
        }

    }
