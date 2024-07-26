<?php

    require_once "../Core/mainModelo.php";

    class SesionModelo extends MainModel {

        protected function iniciarSesionModelo($datos) {
            $query = self::conectDB() -> prepare("
                SELECT * FROM usuario
                WHERE correo_electronico = :mail
                AND contraseña = :pass
                AND confirmado = 1
            ");

            $query -> bindParam(':mail', $datos['email']);
            $query -> bindParam(':pass', $datos['pass']);

            $query -> execute();
            return $query;
        }

        protected function cerrarSesionModelo($datos) {
            if (empty($datos['usuario']) || $datos['Token'] != $datos['token']) {
                return "false";

            } else {
                session_unset();
                session_destroy();
                return "true";

            }

        }

        protected function autenticarUsuarioModelo($google_id) {
            $query = self::conectDB() -> prepare("
                SELECT * FROM usuario
                WHERE google_id = :google_id
            ");

            $query -> bindParam(':google_id', $google_id);

            $query -> execute();
            return $query;
        }

    }
