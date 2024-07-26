
<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class FeedModelo extends MainModel {

        protected function listarFeedModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                ORDER BY a.idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }

        protected function listarPerdidosModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "Perdido"
                ORDER BY a.idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }

        protected function listarEncontradosModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "Encontrado"
                ORDER BY a.idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }

        protected function listarEnAdopcionModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "En Adopcion"
                ORDER BY a.idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }

        protected function listarEnPeligroModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "En Peligro"
                ORDER BY a.idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }


    }
