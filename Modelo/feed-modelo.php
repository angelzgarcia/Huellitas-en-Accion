
<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class FeedModelo extends MainModel {

        protected function listarFeedModelo() {

            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE ub.latitud BETWEEN "14.3895" AND "32.7188"
                AND ub.longitud BETWEEN "-118.6523" AND "-86.5887"
                ORDER BY a.idAnimal DESC
            ');
            $query->execute();
            return $query;
        }

        protected function listarPerdidosModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "Perdido"
                AND ub.latitud BETWEEN "14.5374" AND "32.7201"
                AND ub.longitud BETWEEN "-118.9347" AND "-86.6904"
                ORDER BY a.idAnimal DESC
            ');
            $query->execute();
            return $query;
        }

        protected function listarEncontradosModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "Encontrado"
                AND ub.latitud BETWEEN "14.5374" AND "32.7201"
                AND ub.longitud BETWEEN "-118.9347" AND "-86.6904"
                ORDER BY a.idAnimal DESC
            ');
            $query->execute();
            return $query;
        }

        protected function listarEnAdopcionModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "En Adopcion"
                AND ub.latitud BETWEEN "14.5374" AND "32.7201"
                AND ub.longitud BETWEEN "-118.9347" AND "-86.6904"
                ORDER BY a.idAnimal DESC
            ');
            $query->execute();
            return $query;
        }

        protected function listarEnPeligroModelo() {
            $query = self::conectDB()->prepare('
                SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
                FROM animal a
                JOIN usuario us ON a.idUsuario = us.idUsuario
                JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
                WHERE a.status = "En Peligro"
                AND ub.latitud BETWEEN "14.5374" AND "32.7201"
                AND ub.longitud BETWEEN "-118.9347" AND "-86.6904"
                ORDER BY a.idAnimal DESC
            ');
            $query->execute();
            return $query;
        }

        protected function filtrarFeedControlador() {

        }

        protected function listarFiltradosModelo($datos) {
            $queryStr = '
            SELECT a.*, us.nombre AS nombreUs, us.apellidos AS apellidosUs, ub.*
            FROM animal a
            JOIN usuario us ON a.idUsuario = us.idUsuario
            JOIN ubicacion ub ON a.idUbicacion = ub.idUbicacion
            WHERE (
                ((:status = "Feed" OR :status IS NULL) AND (a.status = "En Peligro" OR a.status = "En Adopcion" OR a.status = "Encontrado" OR a.status = "Perdido"))
                OR (a.status = :status)
            )
            AND ((:perro = 1 AND a.tipoAnimal = "Perro") OR (:gato = 1 AND a.tipoAnimal = "Gato"))
            AND ((:macho = 1 AND a.sexo = "Macho") OR (:hembra = 1 AND a.sexo = "Hembra"))
            AND ((:pequenio = 1 AND a.tamanio = "Pequeño") OR (:mediano = 1 AND a.tamanio = "Mediano") OR (:grande = 1 AND a.tamanio = "Grande"))
            AND (
                (
                    CASE
                        WHEN a.edad LIKE "%año%" THEN
                            CASE
                                WHEN a.edad LIKE "%mes%" THEN
                                    CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED) * 12 + CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(a.edad, "mes", 1), " ", -1) AS UNSIGNED)
                                ELSE
                                    CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED) * 12
                            END
                        WHEN a.edad LIKE "%mes%" THEN
                            CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED)
                        ELSE
                            0
                    END
                ) BETWEEN :cachorroMin AND :cachorroMax
                OR
                (
                    CASE
                        WHEN a.edad LIKE "%año%" THEN
                            CASE
                                WHEN a.edad LIKE "%mes%" THEN
                                    CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED) * 12 + CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(a.edad, "mes", 1), " ", -1) AS UNSIGNED)
                                ELSE
                                    CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED) * 12
                            END
                        WHEN a.edad LIKE "%mes%" THEN
                            CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED)
                        ELSE
                            0
                    END
                ) BETWEEN :adultoMin AND :adultoMax
                OR
                (
                    CASE
                        WHEN a.edad LIKE "%año%" THEN
                            CASE
                                WHEN a.edad LIKE "%mes%" THEN
                                    CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED) * 12 + CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(a.edad, "mes", 1), " ", -1) AS UNSIGNED)
                                ELSE
                                    CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED) * 12
                            END
                        WHEN a.edad LIKE "%mes%" THEN
                            CAST(SUBSTRING_INDEX(a.edad, " ", 1) AS UNSIGNED)
                        ELSE
                            0
                    END
                ) >= :adultoMayorMin
            )
        ';

            if ($datos['limites']) {
                $queryStr .= '
                    AND (ub.latitud BETWEEN :sur AND :norte)
                    AND (ub.longitud BETWEEN :oeste AND :este)
                ';
            }

            $queryStr .= ' ORDER BY a.idAnimal DESC';

            $query = self::conectDB()->prepare($queryStr);

            $query->bindValue(':status', $datos['status']);
            $query->bindValue(':perro', $datos['perro']);
            $query->bindValue(':gato', $datos['gato']);
            $query->bindValue(':macho', $datos['macho']);
            $query->bindValue(':hembra', $datos['hembra']);
            $query->bindValue(':pequenio', $datos['pequeño']);
            $query->bindValue(':mediano', $datos['mediano']);
            $query->bindValue(':grande', $datos['grande']);
            $query->bindValue(':cachorroMin', $datos['cachorroMin']);
            $query->bindValue(':cachorroMax', $datos['cachorroMax']);
            $query->bindValue(':adultoMin', $datos['adultoMin']);
            $query->bindValue(':adultoMax', $datos['adultoMax']);
            $query->bindValue(':adultoMayorMin', $datos['adultoMayorMin']);

            if ($datos['limites']) {
                $query->bindValue(':sur', $datos['limites']['southwest']['lat']);
                $query->bindValue(':norte', $datos['limites']['northeast']['lat']);
                $query->bindValue(':oeste', $datos['limites']['southwest']['lng']);
                $query->bindValue(':este', $datos['limites']['northeast']['lng']);
            }

            $query->execute();

            return $query;
        }


    }
