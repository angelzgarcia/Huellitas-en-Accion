
    <?php
        require_once '../Core/mainModelo.php';

        class PublicarModelo extends MainModel {

            public function eliminarUbicacion($idUbicacion) {
                $query = self::conectDB()->prepare('DELETE FROM ubicacion WHERE idUbicacion = :idUbicacion');
                $query->bindParam(':idUbicacion', $idUbicacion);
                $query->execute();
            }

            protected function publicarModelo($datos) {
                $query = self::conectDB() -> prepare ("
                    INSERT INTO animal (nombre, sexo, tipoAnimal, raza, estadoSalud, status, tamanio, peso, edad,  descripcion, imagen, fechaReporte, idUsuario, idUbicacion)
                    VALUES (:nombre, :sexo, :tipoAnimal, :raza, :estadoSalud, :status, :tamanio, :peso, :edad, :descripcion, :imagen, :fechaReporte, :idUsuario, :idUbicacion)
                ");

                $query -> bindParam(':nombre', $datos['nombre']);
                $query -> bindParam(':sexo', $datos['sexo']);
                $query -> bindParam(':tipoAnimal', $datos['tipoAnimal']);
                $query -> bindParam(':raza', $datos['raza']);
                $query -> bindParam(':estadoSalud', $datos['estadoSalud']);
                $query -> bindParam(':status', $datos['status']);
                $query -> bindParam(':tamanio', $datos['tamanio']);
                $query -> bindParam(':peso', $datos['peso']);
                $query -> bindParam(':edad', $datos['edad']);
                $query -> bindParam(':descripcion', $datos['descripcion']);
                $query -> bindParam(':imagen', $datos['imagen']);
                $query -> bindParam(':fechaReporte', $datos['fechaReporte']);
                $query -> bindParam(':idUsuario', $datos['idUsuario']);
                $query -> bindParam(':idUbicacion', $datos['idUbicacion']);

                $query -> execute();

                return $query;
            }

        }
