
<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    // if (!isset($_SESSION['tipoU']) || empty($_SESSION['token']) || ($_SESSION['tipoU'] != 'Usuario' && $_SESSION['tipoU'] != 'Administrador')):
    //     session_destroy();
    //     header('Location: ' . SERVER );
    //     exit();

    // require_once SERVERURL . 'Core/mainModelo.php';
    require_once SERVERURL . "Controlador/feed-controlador.php";

    $r = isset($_GET['r']) ? $_GET['r'] :'';
    $lat = isset($_GET['lat']) ? $s::decryption($_GET['lat']) : '';
    $lng = isset($_GET['lng']) ? $s::decryption($_GET['lng']) : '';
?>
<body class="body-index" onload="initMap()">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php include_once RUTAMODULOS . "header.php"; ?>

        <!-- CONTENEDOR DEL POST -->
        <div class="posts-container">
            <?php
                $posts = new FeedControlador();
                $posts -> mostrarPostControlador(htmlspecialchars($r));
            ?>
        </div>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

    </main>
</body>

<!-- CONFIGURACIONES DEL MAPA DE GOOGLE -->
<script>
    var mapPerro;
    var markerPerro;
    var estadoSeleccionado = '';
    var mexicoBounds;
    var lat = <?= isset($lat) ? $lat : 'null' ?>;
    var lng = <?= isset($lng) ? $lng : 'null' ?>;

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
        mapPerro = new google.maps.Map(document.getElementById('mapAnimals'), mapOptions);

        markerPerro = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: mapPerro,
            draggable: false,
            icon: {
                url: '<?=RUTARECURSOS?>IMG/huella-pata-icono-grafico.png',
                scaledSize: new google.maps.Size(95, 95)
            }
        });

        mexicoBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(14.559322, -118.363069),
            new google.maps.LatLng(32.718655, -86.588700)
        );

        // google.maps.event.addListener(markerPerro, 'dragend', function(event) {
        //     placeMarker(event.latLng);
        // });

        // mapPerro.addListener('click', function(event) {
        //     placeMarker(event.latLng);
        // });
    }

    // function placeMarker(location) {
    //     if (mexicoBounds.contains(location)) {
    //         markerPerro.setPosition(location);
    //         mapPerro.setCenter(location);
    //         document.getElementById('latitud').value = location.lat();
    //         document.getElementById('longitud').value = location.lng();
    //     } else {
    //         Swal.fire({
    //             title: "Tu ubicación debe estar dentro de la República Mexicana.",
    //             width: 600,
    //             padding: "1em 0",
    //             color: "#716add",
    //             confirmButtonText: "Entendido",
    //             background: "#fff url(/images/trees.png)",
    //             backdrop: `
    //                 rgba(14, 22, 38, 0.5)
    //                 url("<?=RUTARECURSOS?>IMG/Imip.gif")
    //                 left 101%
    //                 no-repeat
    //             `,
    //             showClass: {
    //                 popup: `
    //                 animate__animated
    //                 animate__fadeInUp
    //                 animate__faster
    //                 `
    //             },
    //             hideClass: {
    //                 popup: `
    //                 animate__animated
    //                 animate__fadeOutDown
    //                 animate__faster
    //                 `
    //             }
    //         });
    //     }
    // }

    // function obtenerUbicacion() {
    //     if (navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(function(position) {
    //             var userLocation = {
    //                 lat: position.coords.latitude,
    //                 lng: position.coords.longitude
    //             };

    //             if (mexicoBounds.contains(userLocation)) {
    //                 document.getElementById('latitud').value = userLocation.lat;
    //                 document.getElementById('longitud').value = userLocation.lng;
    //                 mapPerro.setCenter(userLocation);
    //                 mapPerro.setZoom(15);
    //                 markerPerro.setPosition(userLocation);
    //             } else {
    //                 alert('Tu ubicación debe estar dentro de la República Mexicana.');
    //             }
    //         }, function() {
    //             alert('No se pudo obtener la ubicación.');
    //         });
    //     } else {
    //         alert('Tu navegador no soporta Geolocalización.');
    //     }
    // }

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
