<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || empty($_SESSION['token']) || ($_SESSION['tipoU'] != 'Usuario' && $_SESSION['tipoU'] != 'Administrador')):
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    else:
        if ($_SERVER["REQUEST_METHOD"] == "POST"):
            require_once SERVERURL . 'Core/mainModelo.php';
            $mainModel = new MainModel();

            $formTypeAnimal = 'form-type-animal-hidden';

            if (isset($_POST['type-animal']) && isset($_POST['status'])):
                $status = $_POST['status'];

                $statusSalud = match ($status) {
                    'perdido' => 'comprometido',
                    'en-adopcion' => 'estable',
                    'en-peligro' => 'grave',
                    default => 'desconocido',
                };

                $typeOfAnimal = $_POST['type-animal'];

            else: exit(); endif;

        else: $formReport = 'form-report-animal-hidden'; endif;

?>
<body class="body-index" onload="initMap()">
    <main class="content-page content-page-forms-publish">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- CONTENEDOR TIPO DE ANIMAL REPORTADO -->
        <div class="container-del-container <?=$formTypeAnimal?>">
            <div class="type-of-animal-container">
                <h2 class="type-title">¿Qué deseas reportar?</h2>
                <!-- CONTENEDOR DE FORMULARIOS TIPO DE ANIMAL  -->
                <div class="forms-type-animal-container">
                    <!-- FORMULARIO PERRO -->
                    <form method="post" action="publicar" class="icons-type-of-animal">
                        <!-- CONTENEDOR BOTON PERRO -->
                        <div class="type-of-animal-icon type-dog">
                            <!-- YA MUCHO DIV, PERO ASI SE VA A QUEDAR -->
                            <div>
                                <input type="hidden" readonly name="status" value="<?=htmlspecialchars($_GET['s'])?>">
                                <input type="hidden" readonly name="type-animal" value="perro">
                                <button type="submit" class="btn-type-dog"></button>
                            </div>
                        </div>
                    </form>
                    <!-- FORMULARIO GATO -->
                    <form method="post" action="publicar" class="icons-type-of-animal">
                        <!-- GATO -->
                        <div class="type-of-animal-icon type-cat">
                            <!-- YA MUCHO DIV, PERO ASI SE VA A QUEDAR -->
                            <div>
                                <input type="hidden" readonly name="status" value="<?=htmlspecialchars($_GET['s'])?>">
                                <input type="hidden" readonly name="type-animal" value="gato">
                                <button type="submit" class="btn-type-cat"></button>
                            </div>
                        </div>
                    </form>
                    <!-- FORMULARIO OTROS -->
                    <form method="post" action="publicar" class="icons-type-of-animal">
                        <!-- OTRO -->
                        <div class="type-of-animal-icon type-other">
                            <!-- YA MUCHO DIV, PERO ASI SE VA A QUEDAR -->
                            <div>
                                <input type="hidden" readonly name="status" value="<?=htmlspecialchars($_GET['s'])?>">
                                <input type="hidden" readonly name="type-animal" value="otro">
                                <button type="submit" class="btn-type-other"><h2>Otro</h2></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FORMULARIOS DE PUBLICACION -->
        <div class="formularioAnimalsContainer <?=$formReport?>">
            <!-- Formularios -->
            <form id="formularioAnimales" class="formAjax formAnimals" action="<?=SERVER?>Ajax/publicarAjax.php" method="POST" enctype="multipart/form-data">
                <!-- contenedor de los datos de entrada -->
                <div class="data-container">
                    <!-- nombre -->
                    <fieldset>
                        <legend>Nombre provisional</legend>
                        <input type="text" id="nombre" name="nombre"  >
                    </fieldset>

                    <!-- sexo -->
                    <fieldset>
                        <legend>Sexo</legend>
                        <select id="sexo" name="sexo">
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                        </select>
                    </fieldset>

                    <?php
                        switch ($typeOfAnimal) {
                            case 'perro':
                                ?>
                                    <!-- razas perro -->
                                    <fieldset>
                                        <legend>Raza</legend>
                                        <select id="raza" name="raza" >
                                            <option value="Mestizo">Mestizo</option>
                                            <option value="Affenpinscher">Affenpinscher</option>
                                            <option value="Akita Inu">Akita Inu</option>
                                            <option value="Alaskan Malamute">Alaskan Malamute</option>
                                            <option value="American Bully">American Bully</option>
                                            <option value="American Pit Bull Terrier">American Pit Bull Terrier</option>
                                            <option value="American Staffordshire Terrier">American Staffordshire Terrier</option>
                                            <option value="Antiguo Pastor Inglés">Antiguo Pastor Inglés</option>
                                            <option value="Australian Cattle Dog">Australian Cattle Dog</option>
                                            <option value="Australian Terrier">Australian Terrier</option>
                                            <option value="Azawakh">Azawakh</option>
                                            <option value="Basenji">Basenji</option>
                                            <option value="Basset Hound">Basset Hound</option>
                                            <option value="Beagle">Beagle</option>
                                            <option value="Beauceron">Beauceron</option>
                                            <option value="Bedlington Terrier">Bedlington Terrier</option>
                                            <option value="Bichón Frisé">Bichón Frisé</option>
                                            <option value="Bloodhound">Bloodhound</option>
                                            <option value="Border Collie">Border Collie</option>
                                            <option value="Border Terrier">Border Terrier</option>
                                            <option value="Boyero de Berna">Boyero de Berna</option>
                                            <option value="Boxer">Boxer</option>
                                            <option value="Braco Alemán">Braco Alemán</option>
                                            <option value="Briard">Briard</option>
                                            <option value="Bulldog Francés">Bulldog Francés</option>
                                            <option value="Bulldog Inglés">Bulldog Inglés</option>
                                            <option value="Bullmastiff">Bullmastiff</option>
                                            <option value="Cairn Terrier">Cairn Terrier</option>
                                            <option value="Cane Corso">Cane Corso</option>
                                            <option value="Cavalier King Charles Spaniel">Cavalier King Charles Spaniel</option>
                                            <option value="Chihuahua">Chihuahua</option>
                                            <option value="Chow Chow">Chow Chow</option>
                                            <option value="Cocker Spaniel">Cocker Spaniel</option>
                                            <option value="Collie">Collie</option>
                                            <option value="Dachshund">Dachshund</option>
                                            <option value="Dálmata">Dálmata</option>
                                            <option value="Dandie Dinmont Terrier">Dandie Dinmont Terrier</option>
                                            <option value="Doberman">Doberman</option>
                                            <option value="Dogo Argentino">Dogo Argentino</option>
                                            <option value="Dogo de Burdeos">Dogo de Burdeos</option>
                                            <option value="Dogo del Tíbet">Dogo del Tíbet</option>
                                            <option value="Fila Brasileño">Fila Brasileño</option>
                                            <option value="Fox Terrier">Fox Terrier</option>
                                            <option value="Galgo Español">Galgo Español</option>
                                            <option value="Golden Retriever">Golden Retriever</option>
                                            <option value="Gran Danés">Gran Danés</option>
                                            <option value="Husky Siberiano">Husky Siberiano</option>
                                            <option value="Jack Russell Terrier">Jack Russell Terrier</option>
                                            <option value="Keeshond">Keeshond</option>
                                            <option value="Komondor">Komondor</option>
                                            <option value="Labrador Retriever">Labrador Retriever</option>
                                            <option value="Lhasa Apso">Lhasa Apso</option>
                                            <option value="Maltés">Maltés</option>
                                            <option value="Mastín Español">Mastín Español</option>
                                            <option value="Mastín Napolitano">Mastín Napolitano</option>
                                            <option value="Mastín Tibetano">Mastín Tibetano</option>
                                            <option value="Papillon">Papillon</option>
                                            <option value="Pastor Alemán">Pastor Alemán</option>
                                            <option value="Pastor Australiano">Pastor Australiano</option>
                                            <option value="Pastor Belga">Pastor Belga</option>
                                            <option value="Pekinés">Pekinés</option>
                                            <option value="Pembroke Welsh Corgi">Pembroke Welsh Corgi</option>
                                            <option value="Perro de Agua Español">Perro de Agua Español</option>
                                            <option value="Perro Lobo Checoslovaco">Perro Lobo Checoslovaco</option>
                                            <option value="Pointer">Pointer</option>
                                            <option value="Pomerania">Pomerania</option>
                                            <option value="Poodle">Poodle</option>
                                            <option value="Pug">Pug</option>
                                            <option value="Rhodesian Ridgeback">Rhodesian Ridgeback</option>
                                            <option value="Rottweiler">Rottweiler</option>
                                            <option value="Saluki">Saluki</option>
                                            <option value="Samoyedo">Samoyedo</option>
                                            <option value="San Bernardo">San Bernardo</option>
                                            <option value="Schnauzer">Schnauzer</option>
                                            <option value="Scottish Terrier">Scottish Terrier</option>
                                            <option value="Setter Irlandés">Setter Irlandés</option>
                                            <option value="Shar Pei">Shar Pei</option>
                                            <option value="Shiba Inu">Shiba Inu</option>
                                            <option value="Shih Tzu">Shih Tzu</option>
                                            <option value="Silky Terrier">Silky Terrier</option>
                                            <option value="Skye Terrier">Skye Terrier</option>
                                            <option value="Staffordshire Bull Terrier">Staffordshire Bull Terrier</option>
                                            <option value="Teckel">Teckel</option>
                                            <option value="Terranova">Terranova</option>
                                            <option value="Terrier Australiano">Terrier Australiano</option>
                                            <option value="Terrier Escocés">Terrier Escocés</option>
                                            <option value="Terrier Irlandés">Terrier Irlandés</option>
                                            <option value="Terrier Tibetano">Terrier Tibetano</option>
                                            <option value="Weimaraner">Weimaraner</option>
                                            <option value="West Highland White Terrier">West Highland White Terrier</option>
                                            <option value="Whippet">Whippet</option>
                                            <option value="Yorkshire Terrier">Yorkshire Terrier</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </fieldset>
                                <?php
                                break;

                            case 'gato':
                                ?>
                                    <!-- razas gato -->
                                    <fieldset>
                                        <legend>Raza</legend>
                                            <select name="raza" id="raza"  >
                                            <option value="mestizo">Mestizo</option>
                                            <option value="siamés">Siamés</option>
                                            <option value="persian">Persa</option>
                                            <option value="maine-coon">Maine Coon</option>
                                            <option value="russian-blue">Azul Ruso</option>
                                            <option value="sphynx">Sphynx</option>
                                            <option value="bengal">Bengalí</option>
                                            <option value="scottish-fold">Scottish Fold</option>
                                            <option value="siberian">Siberiano</option>
                                            <option value="british-shorthair">British Shorthair</option>
                                            <option value="burmese">Burmés</option>
                                            <option value="ragdoll">Ragdoll</option>
                                            <option value="himalayan">Himalayo</option>
                                            <option value="abysinnian">Abisinio</option>
                                            <option value="devon-rex">Devon Rex</option>
                                            <option value="cornish-rex">Cornish Rex</option>
                                        </select>
                                    </fieldset>
                                <?php
                                break;

                            case 'otro':
                                ?>
                                    <!-- otro tipo de animal -->
                                    <fieldset style="display: none;" >
                                        <legend>Raza</legend>
                                            <select name="raza" id="raza" hidden readonly>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </fieldset>
                                <?php
                                break;

                            default:
                                ?>
                                    <!-- otro tipo de animal -->
                                    <fieldset style="display: none;" >
                                        <legend>Raza</legend>
                                            <select name="raza" id="raza" hidden readonly>
                                                <option value="otro">Otro</option>
                                            </select>
                                    </fieldset>
                                <?php
                                break;
                        }
                    ?>

                    <!-- tamaño -->
                    <fieldset>
                        <legend>Tamaño</legend>
                        <select id="tamanio" name="tamanio">
                            <option value="Pequeño">Pequeño</option>
                            <option value="Mediano">Mediano</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </fieldset>

                    <!-- peso -->
                    <fieldset>
                        <legend>Peso (Kg)</legend>
                        <input type="text" id="peso" name="peso" title="Ingresa solo unidades">
                    </fieldset>

                    <!-- edad -->
                    <fieldset>
                        <legend>Edad estimada</legend>
                        <select name="tipoEdad" id="tipoEdad">
                            <option disabled selected>Meses / Años</option>
                            <option value="meses">Meses</option>
                            <option value="anios">Años</option>
                        </select>
                        <input type="text" id="valorEdad" name="valorEdad" title="Ingresa solo unidades" hidden>
                        <input type="hidden" id="tipoEdadHidden" name="tipoEdadHidden">
                    </fieldset>

                    <!-- descripcion -->
                    <fieldset>
                        <legend>Descripción</legend>
                        <textarea id="descripcion" name="descripcion" rows="4" style="resize: vertical;" placeholder="Mínimo 50 caracteres <?="\n"?>Máximo 500 caracteres"></textarea>
                    </fieldset>

                    <!-- imagen -->
                    <fieldset>
                        <div class="file-upload-wrapper">
                            <input type="file" id="file-upload" name="imagen" class="file-upload-input" onchange="updateFileName()">
                            <label for="file-upload" class="file-upload-button">Subir Archivo</label>
                            <span id="file-name" class="file-upload-name">Ningún archivo seleccionado</span>
                        </div>
                    </fieldset>

                    <!-- estado de salud -->
                    <input type="text" id="saludStatus" name="saludStatus" value="<?=$statusSalud?>" hidden   >
                    <!-- status -->
                    <input type="text" id="status" name="status" value="<?=$status?>" hidden   >
                    <!-- tipo de animal -->
                    <input type="text" id="tipoAnimal" name="tipoAnimal" value="<?=$typeOfAnimal?>" hidden   >

                    <!-- Latitud -->
                    <input type="text" id="latitud" name="latitud" hidden   >
                    <!-- longitud -->
                    <input type="text" id="longitud" name="longitud" hidden   >

                    <!-- correo de usuario -->
                    <input type="text" id="correo" name="correo" value="<?= $_SESSION['email'] ?>" hidden   >

                </div>

                <!-- CONTENEDOR DEL MAPA Y BOTONES DE ENVIO Y UBICACION -->
                <div class="map-button-container">
                    <h3><?=$statusSalud != 'estable' ? '¿Dónde se visualizó por útlima vez?' : ''; ?></h3>
                    <!-- mapa -->
                    <div id="map" class="map-container"></div>

                    <div class="buttons-form-animals">
                        <!-- ubicacion -->
                        <button type="button" class="btn-frm-animals" onclick="obtenerUbicacion()">Obtener ubicación</button>
                        <!-- enviar datos -->
                        <button type="submit" class="btn-frm-animals">Enviar</button>
                    </div>
                </div>
                <div class="RespuestaAjax"></div>

            </form>

        </div>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

    </main>
</body>

<!-- CONFIGURACIONES DEL MAPA DE GOOGLE -->
<script>
    var mapPerro;
    var markerPerro;
    var estadoSeleccionado = ''; // Variable para almacenar el estado seleccionado
    var mexicoBounds; // Variable para los límites de México

    function cambiarEstado(estado) {
        estadoSeleccionado = estado;
        console.log('Estado seleccionado:', estadoSeleccionado);
    }

    function initMap() {
        var mapOptions = {
            center: { lat: 23.6345, lng: -102.5528 },
            zoom: 5,
            disableDefaultUI: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            gestureHandling: 'greedy',
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [{ "color": "#1d2c4d" }]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#8ec3b9" }]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [{ "color": "#1a3646" }]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "geometry.stroke",
                    "stylers": [{ "color": "#4b6878" }]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#64779e" }]
                },
                {
                    "featureType": "administrative.province",
                    "elementType": "geometry.stroke",
                    "stylers": [{ "color": "#4b6878" }]
                },
                {
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.stroke",
                    "stylers": [{ "color": "#334e87" }]
                },
                {
                    "featureType": "landscape.natural",
                    "elementType": "geometry",
                    "stylers": [{ "color": "#023e58" }]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [{ "color": "#283d6a" }]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#6f9ba5" }]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.stroke",
                    "stylers": [{ "color": "#1d2c4d" }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [{ "color": "#023e58" }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#3C7680" }]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [{ "color": "#304a7d" }]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#98a5be" }]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.stroke",
                    "stylers": [{ "color": "#1d2c4d" }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [{ "color": "#2c6675" }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [{ "color": "#255763" }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#b0d5ce" }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text.stroke",
                    "stylers": [{ "color": "#023e58" }]
                },
                {
                    "featureType": "transit",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#98a5be" }]
                },
                {
                    "featureType": "transit",
                    "elementType": "labels.text.stroke",
                    "stylers": [{ "color": "#1d2c4d" }]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "geometry.fill",
                    "stylers": [{ "color": "#283d6a" }]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [{ "color": "#3a4762" }]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{ "color": "#0e1626" }]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [{ "color": "#4e6d70" }]
                }
            ]
        };
        mapPerro = new google.maps.Map(document.getElementById('map'), mapOptions);

        markerPerro = new google.maps.Marker({
            position: { lat: 23.6345, lng: -102.5528 },
            map: mapPerro,
            draggable: true,
            icon: {
                url: '<?=RUTARECURSOS?>IMG/huella-pata-icono-grafico.png',
                scaledSize: new google.maps.Size(95, 95)
            }
        });

        mexicoBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(14.559322, -118.363069), // Suroeste
            new google.maps.LatLng(32.718655, -86.588700)  // Noreste
        );

        google.maps.event.addListener(markerPerro, 'dragend', function(event) {
            placeMarker(event.latLng);
        });

        mapPerro.addListener('click', function(event) {
            placeMarker(event.latLng);
        });
    }

    function placeMarker(location) {
        if (mexicoBounds.contains(location)) {
            markerPerro.setPosition(location);
            mapPerro.setCenter(location);
            document.getElementById('latitud').value = location.lat();
            document.getElementById('longitud').value = location.lng();
        } else {
            Swal.fire({
                title: "Tu ubicación debe estar dentro de la República Mexicana.",
                width: 600,
                padding: "1em 0",
                color: "#716add",
                confirmButtonText: "Entendido",
                background: "#fff url(/images/trees.png)",
                backdrop: `
                    rgba(14, 22, 38, 0.5)
                    url("<?=RUTARECURSOS?>IMG/Imip.gif")
                    left 101%
                    no-repeat
                `,
                showClass: {
                    popup: `
                    animate__animated
                    animate__fadeInUp
                    animate__faster
                    `
                },
                hideClass: {
                    popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                    `
                }
            });
        }
    }

    function obtenerUbicacion() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                if (mexicoBounds.contains(userLocation)) {
                    document.getElementById('latitud').value = userLocation.lat;
                    document.getElementById('longitud').value = userLocation.lng;
                    mapPerro.setCenter(userLocation);
                    mapPerro.setZoom(15);
                    markerPerro.setPosition(userLocation);
                } else {
                    alert('Tu ubicación debe estar dentro de la República Mexicana.');
                }
            }, function() {
                alert('No se pudo obtener la ubicación.');
            });
        } else {
            alert('Tu navegador no soporta Geolocalización.');
        }
    }
</script>

<!-- PASAR EL FICHERO SUBIDO AL INPUT OCULTO -->
<script>
    function updateFileName() {
        const input = document.getElementById('file-upload');
        const fileName = input.files.length > 0 ? input.files[0].name : 'Ningún archivo seleccionado';
        document.getElementById('file-name').textContent = fileName;
    }
</script>

<!-- SELECT E INPUT EDAD -->
<script>

    document.addEventListener('DOMContentLoaded', function() {
        const selectEdad = document.getElementById('tipoEdad');
        const inputEdad = document.getElementById('valorEdad');
        const hiddenTipoEdad = document.getElementById('tipoEdadHidden');

        selectEdad.addEventListener('change', function() {
            hiddenTipoEdad.value = selectEdad.value;
            inputEdad.hidden = false;
            selectEdad.hidden = true;
        });
    });

</script>

<!-- AJAX -->
<script>
    $(document).ready(function() {
        $('.formAjax').submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let metodo = form.attr('method');
            let accion = form.attr('action');
            let respuesta = form.find('.RespuestaAjax');
            let nombre = document.getElementById('nombre').value;
            let sexo = document.getElementById('sexo').value;
            let raza = document.getElementById('raza').value;
            let tamanio = document.getElementById('tamanio').value;
            let peso = document.getElementById('peso').value;
            let valorEdad = document.getElementById('valorEdad').value;
            let tipoEdadHidden = document.getElementById('tipoEdadHidden').value;
            let descripcion = document.getElementById('descripcion').value;
            let saludStatus = document.getElementById('saludStatus').value;
            let tipoAnimal = document.getElementById('tipoAnimal').value;
            let status = document.getElementById('status').value;
            let imagen = document.getElementById('file-upload').files[0];
            let latitud = document.getElementById('latitud').value;
            let longitud = document.getElementById('longitud').value;
            let correo = document.getElementById('correo').value;

            let formData = new FormData(this);
            let camposVacios = false;

            formData.forEach(function (value, key) {
                if (!value) {
                    camposVacios = true;
                }
            });

            if (camposVacios) {
                Swal.fire({
                    icon: 'error',
                    title: 'Todos los campos son obligatorios',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                    showClass: {
                        popup: `
                        animate__animated
                        animate__fadeInUp
                        animate__faster
                        `
                    },
                    hideClass: {
                        popup: `
                        animate__animated
                        animate__fadeOutDown
                        animate__faster
                        `
                    }
                });
                return false;
            }

            $.ajax({
                url: accion,
                type: metodo,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                success: function(data) {
                    respuesta.html(data);
                },
                error: function() {
                    Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                }

            });

        });

    });
</script>

<!-- TOOLTIPS -->
<script>
    document.querySelectorAll('input[title]').forEach((input) => {
        const title = input.getAttribute('title');
        input.removeAttribute('title');
        tippy(input, {
            content: title,
            arrow: true,
            animation: 'fade',
        });
    });
</script>

</html>
<?php endif; ?>
