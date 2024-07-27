
<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class PerfilModelo extends MainModel {

        protected function listarPostsModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, ub.*
                FROM animal a
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                ORDER BY a.idAnimal DESC
            ');

            $query -> execute();
            return $query;
        }

    }
