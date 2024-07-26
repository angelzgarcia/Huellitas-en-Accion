
<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class FeedModelo extends MainModel {

        public function listarFeedModelo() {
            $query = self::conectDB()->query('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                ORDER BY idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }

    }
