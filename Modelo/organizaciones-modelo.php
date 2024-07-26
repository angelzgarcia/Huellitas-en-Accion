
<?php

    require_once SERVERURL . 'Core/mainModelo.php';

    class OrganizacionesModelo extends MainModel {

        protected function listarOrganizacionesModelo() {

            $query = self::conectDB()->query('
                SELECT * FROM organizacion
                ORDER BY nombre ASC
            ');

            $query -> execute();
            return $query;
        }

    }

