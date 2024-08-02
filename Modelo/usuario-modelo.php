<?php

    // SE INTERACTUA DIRECTAMENTE CON LA BASE DE DATOS EN EL MODELO
    require_once "../Core/mainModelo.php";
class UsuarioModelo extends MainModel {

        public function crearUsuarioModelo($datos) {
            $query = MainModel::conectDB()->prepare("
                INSERT INTO usuario(google_id, nombre, apellidos, correo_electronico, contraseña, telefono, foto, genero, tipoUsuario, ubicacion, token, confirmado)
                VALUES(:google_id, :nombre, :apellidos, :correo, :pass, :telefono, :foto, :genero, :tipoUsuario, :ubicacion, :token, :confirmado)
            ");

            // SE SUSTITUYEN LOS MARCADORES
            $query->bindParam(":google_id", $datos['google_id']);
            $query->bindParam(":nombre", $datos['nombre']);
            $query->bindParam(":apellidos", $datos['apellidos']);
            $query->bindParam(":correo", $datos['correo']);
            $query->bindParam(":pass", $datos['pass']);
            $query->bindParam(":telefono", $datos['num']);
            $query->bindParam(":foto", $datos['foto']);
            $query->bindParam(":genero", $datos['gene']);
            $query->bindParam(":tipoUsuario", $datos['tipoU']);
            $query->bindParam(":ubicacion", $datos['ubicacion']);
            $query->bindParam(":token", $datos['tok']);
            $query->bindParam(":confirmado", $datos['confirm']);

            $query->execute();
            return $query;
        }

        public function eliminarUsuarioModelo($datos) {
            $query = self::ejecturarConsultaSimple("
                DELETE FROM usuario
                WHERE idUsuario = :id
            ");

            $query->bindParam(":id", $datos['idUsuario']);
            $query->execute();

            return $query;
        }

        public function modificarUsuarioModelo() {


        }


    }
