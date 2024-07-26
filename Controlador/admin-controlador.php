
<?php

    class AdminControlador extends AdminModelo {

        public function agregarAdministradotControlador() {

        }

        public function paginadorAdministradorControlador($page, $nRegisters) {

            $page = self::limpiarCadena($page);
            $nRegisters = self::limpiarCadena($nRegisters);
            $tabla = '';

            $page = (isset($page) && ($page > 0) && ($page % 2 == 0 || $page % 2 == 1)) ? $page : 1;
            $inicio = ($page > 0) ? ($page * $nRegisters - $nRegisters) : 0;

            $con = self::conectDB();

            $datos = $con->query('
                SELECT SQL_CALC_FOUND_ROWS * FROM 


            ');

            return $tabla;
        }


    }
