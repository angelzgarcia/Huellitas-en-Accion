
<?php

    require_once SERVERURL . "Core/mainModelo.php";

    class CrudModelo extends MainModel {

        // INICIO CRUD ORGANIZACIONES
        protected function agregarOrganizacionModelo($datos) {
            $query = self::conectDB()->prepare("
                INSERT INTO organizacion (nombre, numero, correo, direccion, descripcion, imagen)
                VALUES (:nombre, :numero, :correo, :direccion, :descripcion, :imagen)
            ");

            $query->bindParam(':nombre', $datos['nombre']);
            $query->bindParam(':numero', $datos['numero']);
            $query->bindParam(':correo', $datos['correo']);
            $query->bindParam(':direccion', $datos['direccion']);
            $query->bindParam(':descripcion', $datos['descripcion']);
            $query->bindParam(':imagen', $datos['imagen']);

            $query->execute();
            return $query;
        }

        protected function  actualizarOrganizacionModelo($datos) {

            $query = self::conectDB()->prepare("
                UPDATE organizacion
                SET nombre = :nombre, numero = :numero, correo = :correo, direccion = :direccion, descripcion = :descripcion, imagen = :imagen
                WHERE idOrganizacion = :idOrg
            ");

            $query->bindParam(':idOrg', $datos['id']);
            $query->bindParam(':nombre', $datos['nombre']);
            $query->bindParam(':numero', $datos['numero']);
            $query->bindParam(':correo', $datos['correo']);
            $query->bindParam(':direccion', $datos['direccion']);
            $query->bindParam(':descripcion', $datos['descripcion']);
            $query->bindParam(':imagen', $datos['imagen']);

            $query->execute();
            return $query;
        }
        // FIN CRUD ORGANIZACIONES


        // INICIO CRUD TIPS
        protected function agregarTipModelo($datos) {
            $query = self::conectDB()->prepare("
                INSERT INTO tip (titulo, descripcion, imagen)
                VALUES (:titulo, :descripcion, :imagen)
            ");

            $query->bindParam(':titulo', $datos['titulo']);
            $query->bindParam(':descripcion', $datos['descripcion']);
            $query->bindParam(':imagen', $datos['imagen']);

            $query->execute();
            return $query;

        }

        protected function actualizarTipModelo($datos) {
            $query = self::conectDB()->prepare("
                UPDATE tip
                SET titulo = :titulo, descripcion = :descripcion, imagen = :imagen
                WHERE idTip = :idTip
            ");

            $query->bindParam(':idTip', $datos['id']);
            $query->bindParam(':titulo', $datos['titulo']);
            $query->bindParam(':descripcion', $datos['descripcion']);
            $query->bindParam(':imagen', $datos['imagen']);

            $query->execute();
            return $query;
        }
        // FIN CRUD TIPS


        // INICIO CRUD BLOG
        protected function agregarNoticiaModelo($datos) {
            $query = self::conectDB()->prepare("
                INSERT INTO blog (titulo, subtitulo, descripcion, imagen)
                VALUES (:titulo, :subtitulo, :descripcion, :imagen)
            ");

            $query->bindParam(':titulo', $datos['titulo']);
            $query->bindParam(':subtitulo', $datos['subtitulo']);
            $query->bindParam(':descripcion', $datos['descripcion']);
            $query->bindParam(':imagen', $datos['imagen']);

            $query->execute();
            return $query;
        }

        protected function actualizarNoticiaModelo($datos) {
            $query = self::conectDB()->prepare("
                UPDATE blog
                SET titulo = :titulo, subtitulo = :subtitulo, descripcion = :descripcion, imagen = :imagen
                WHERE idBlog = :idBlog
            ");

            $query->bindParam(':idBlog', $datos['id']);
            $query->bindParam(':titulo', $datos['titulo']);
            $query->bindParam(':subtitulo', $datos['subtitulo']);
            $query->bindParam(':descripcion', $datos['descripcion']);
            $query->bindParam(':imagen', $datos['imagen']);

            $query->execute();
            return $query;
        }
        // FIN CRUD BLOG

    }
