
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

        protected function editarPostModelo($datos) {
            $query = self::conectDB() -> prepare('
                UPDATE animal
                SET estadoSalud = :estadoSalud, status = :status
                WHERE idAnimal = :idAnimal
            ');
            $query -> bindParam(':idAnimal', $datos['idPost']);
            $query -> bindParam(':estadoSalud', $datos['estadoSalud']);
            $query -> bindParam(':status', $datos['status']);

            $query -> execute();
            return $query;
        }

        protected function actualizarBiografiaPerfilModelo ($datos) {
            $query = self::conectDB() -> prepare('
                UPDATE usuario
                SET foto = :foto, sobreMi = :sobreMi
                WHERE idUsuario = :idUsuario;
            ');
            $query -> bindParam(':foto', $datos['foto']);
            $query -> bindParam(':sobreMi', $datos['sobreMi']);
            $query -> bindParam(':idUsuario', $datos['idUsuario']);

            $query -> execute();
            return $query;
        }

    }
