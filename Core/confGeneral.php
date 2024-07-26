<?php


    // href, src, etc..... recursos y enlaces desde el navegador. RUTAS PUBLICAS ACCESIBLES DESDE EL NAVEGADOR
    define ('SERVER', "http://localhost/Digital_Solutions/");
    // include, require, etc.... recursos internos del sistema de archivos. RUTAS INTERNAS DEL SISTEMA DE ARCHIVOS
    define ('SERVERURL', $_SERVER['DOCUMENT_ROOT'] . "/Digital_Solutions/");

    define ('RUTAMODULOS', SERVERURL . 'Vista/ModulosHTML/'); // interno
    define ('RUTACONTENIDOS', SERVERURL . 'Vista/ContenidosHTML/'); // interno
    define('RUTARECURSOS', SERVER . "Vista/Recursos/"); // publico

    define ('RUTACONTROL', SERVERURL . 'Controlador/'); // interno
    define ('RUTAMODELO', SERVERURL . 'Modelo/'); // interno

    define('RUTARECURSOSA', SERVER . "Vista/ContenidosHTML/");

    define('CSS', RUTARECURSOS . 'CSS/styles.css'); // publico
    define('CSSADMIN', RUTARECURSOS . 'CSS/admin.css'); // publico
    define('FONTS', RUTARECURSOS . 'CSS/fonts.css'); // publico
    define('MEDIAS', RUTARECURSOS . 'CSS/medias.css'); // publico
    define('JS', RUTARECURSOS . 'JS/scripts.js'); // publico

    date_default_timezone_set('America/Mexico_City');

    define('PROYECT', "Huellitas En Acción");

    const CLIENT_ID = '314207445739-jemg2fmtjl7enmaa1pr039bluqugjpqg.apps.googleusercontent.com';

