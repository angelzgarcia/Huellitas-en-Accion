<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class NoticiasModelo extends MainModel {

        protected function listarNoticiasModelo() {
            $query = self::conectDB()->query('
                SELECT * FROM blog
            ');

            $query -> execute();
            return $query;
        }

    }

