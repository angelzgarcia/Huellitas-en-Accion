<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class TipsModelo extends MainModel {

        protected function listarTipsModelo() {

            $query = self::conectDB()->query('
                SELECT * FROM tip
            ');

            $query -> execute();
            return $query;
        }

    }

