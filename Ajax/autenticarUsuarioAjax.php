<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Core/confGeneral.php';
require_once __DIR__ . '/../vendor/autoload.php';

ob_start();

try {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        session_destroy();
        header('Location: ' . SERVER . 'loggin-form');
        exit();
        
    } else {
        $cliente = new Google_Client(['client_id' => '314207445739-jemg2fmtjl7enmaa1pr039bluqugjpqg.apps.googleusercontent.com']);

        // Leer el contenido del cuerpo de la solicitud
        $datos = $_POST; // Usar $_POST en lugar de json_decode
        error_log('Datos recibidos: ' . print_r($datos, true));

        if (!isset($datos['id_token'])) {
            throw new Exception('ID token not found in the request');
        }
        $id_token = $datos['id_token'];

        error_log("ID Token: " . $id_token);

        $userData = $cliente->verifyIdToken($id_token);
        if ($userData) {
            $google_id = $userData['sub'];
            $nombre = $userData['name'];
            $email = $userData['email'];
            $foto = $userData['picture'];

            require_once RUTACONTROL . 'sesion-controlador.php';
            $usuario = new SesionControl();
            $usuario->autenticarUsuarioControl($google_id, $nombre, $email, $foto);

        } else {
            throw new Exception('Invalid ID Token.');
        }
    }
} catch (Exception $e) {
    ob_end_clean();
    error_log($e->getMessage());
    // Redirigir en caso de error
    header('Location: ' . SERVER . 'loggin-form?error=' . urlencode($e->getMessage()));
    exit();
}
