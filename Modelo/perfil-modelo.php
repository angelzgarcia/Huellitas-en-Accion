
<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class PerfilModelo extends MainModel {

        protected function listarPostsModelo($idUser) {
            $query = self::conectDB()->prepare('
                SELECT a.*, ub.*
                FROM animal a
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE idUsuario = :idUsuario
                ORDER BY a.idAnimal DESC
            ');
            $idUser = self::decryption($idUser);
            $query -> bindParam(':idUsuario', $idUser);

            $query -> execute();
            return $query;
        }

    }
