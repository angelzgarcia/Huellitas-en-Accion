<?php

    class VistasModelo {

        protected function obtenerVistasModelo($vista) {
            $listaBlanca = [
                "loggin-form", "about_us", "admin_dashboard", "blog", "en_adopcion", "en_peligro", "encontrados",
                "organizations", "feed", "perdidos", "publicar", "emergencia", "confirm_email", "perfil", "organizaciones", "ubicaciones",
                "animales", "usuarios", "tips", "noticias", "post"
            ];

            if (!in_array($vista, $listaBlanca)) {
                $contenido = "404";
            } elseif (is_file("./Vista/ContenidosHTML/" . $vista . "-view.php")) {
                $contenido = "./Vista/ContenidosHTML/" . $vista . "-view.php";
            } else {
                $contenido = "404";
            }

            return $contenido;
        }

    }

