<?php

require_once "../Core/mainModelo.php";

class ConfirmarEmailControlador extends MainModel {

    public function verificarEmail() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = self::limpiarCadena(self::decryption($_POST['email'])) ?? '';
            $token = self::limpiarCadena($_POST['token']) ?? '';

            $query = self::conectDB()->prepare("
                SELECT * FROM usuario
                WHERE correo_electronico = :email
                AND token = :token
            ");
            $query->bindParam(":email", $email);
            $query->bindParam(":token", $token);
            $query->execute();

            if ($query->rowCount() > 0) {
                $queryU = self::conectDB()->prepare("
                    UPDATE usuario SET confirmado = '1'
                    WHERE correo_electronico = :email
                ");
                $queryU->bindParam(":email", $email);
                $queryU->execute();

                if ($queryU->rowCount() > 0) {
                    $response = [
                        'status' => '',
                        'title' => '(^_^)b',
                        'text' => '¡Ya puedes iniciar sesión!',
                        'redirect' => SERVER . 'loggin-form'
                    ];
                } else {
                    $response = [
                        'status' => '',
                        'title' => '(;-;)',
                        'text' => 'Ocurrió un error, por favor intente de nuevo'
                    ];
                }
            } else {
                $response = [
                    'status' => '',
                    'title' => '(;-;)',
                    'text' => 'Código incorrecto, intenta de nuevo'
                ];
            }

        } else {
            $response = [
                'status' => '',
                'title' => '(;-;)',
                'text' => 'Código incorrecto, intenta de nuevo'
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

}
