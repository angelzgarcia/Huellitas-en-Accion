<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador') :
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    else:

?>
<body class="admin-index">
    <main class="content-page content-page-admin">

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- CONTENEDOR DE LA TABLA -->
        <div class="tables-contaniner">
            <!-- TABLA -->
            <table>
                <caption>Blog</caption>
                <!-- ENCABEZADO -->
                <thead>
                    <!-- FILA -->
                    <tr style="background-color: #d5d7d9; color:#000;">
                        <!-- ENCABEZADOS -->
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Subtitulo</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <!-- CUERPO -->
                <tbody>
                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                    <!-- FILA -->
                    <tr>
                        <!-- DATOS -->
                        <td>01</td>
                        <td>Conmemoremos el Día Internacional Contra la Venta de Animales.</td>
                        <td>
                            Con el propósito de concientizar sobre el concepto erróneo de que los animales – de compañía, silvestres y los que son destinados al
                            consumo humano- son mercancías, hace cuatro años Animal Heroes instauró el 17 de diciembre como el Día Internacional Contra la Venta
                            de Animales. Cuando compramos animales,
                        </td>
                        <td>
                            El mercado de las mal llamadas mascotas, continúa aumentando en nuestro país así como el abandono y sobrepoblación de perros y gatos.
                            En palabras de la diputada Ana Karina Rojo Pimentel, “México ocupa el primer lugar en maltrato animal a nivel Latinoamérica y es la tercera
                            nación donde más actos crueles e inhumanos se cometen contra estos seres”.
                            Muchas de las personas que adquieren animales de compañía no toman en cuenta que deben darles de comer, asearlos, pasearlos, invertir en vacunas
                            y atención médica continua, dedicarles tiempo, educarlos y hacerse responsables de ellos por alrededor de 15 años. Por esta razón, muchos
                            animales son maltratados y abandonados. Además, perras, gatas y otras especies, son explotadas viviendo en condiciones precarias e insalubres,
                            terminando desechadas cuando ya no sirven para seguir dando crías.
                        </td>
                        <td>
                            <img src="data:img/jpg; base64, <?=base64_encode($_SESSION['photo'])?>" style="width: 80px;" alt="new-img">
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- BOTON DE REGRESO -->
        <div class="back-icon bi-admin bb-blog" id="logo-image">
            <a href="<?= SERVER ?>admin_dashboard" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
            </a>
        </div>

    </main>
</body>
</html>
<?php endif; ?>
