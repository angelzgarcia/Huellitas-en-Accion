<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizaciones Cerca de Ti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .title {
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .map-container {
            height: 500px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            Organizaciones Cerca de Ti
        </div>
        <div id="map" class="map-container"></div>
    </div>

    <script>
        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    const map = new google.maps.Map(document.getElementById("map"), {
                        center: userLocation,
                        zoom: 15,
                    });

                    const userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'Tu ubicación'
                    });

                    // Obtener la latitud y longitud de la organización recién agregada desde GET
                    const urlParams = new URLSearchParams(window.location.search);
                    const latitud = parseFloat(urlParams.get('latitud'));
                    const longitud = parseFloat(urlParams.get('longitud'));

                    if (!isNaN(latitud) && !isNaN(longitud)) {
                        const orgMarker = new google.maps.Marker({
                            position: { lat: latitud, lng: longitud },
                            map: map,
                            title: 'Nueva Organización'
                        });

                        const infowindow = new google.maps.InfoWindow({
                            content: `<div><strong>Nueva Organización</strong><br>Ubicación de la organización recién agregada.</div>`
                        });

                        orgMarker.addListener('click', () => {
                            infowindow.open(map, orgMarker);
                        });
                    } else {
                        console.log('No se encontraron coordenadas válidas para la nueva organización.');
                    }

                    fetch('get_organizations.php')
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(org => {
                                const marker = new google.maps.Marker({
                                    position: { lat: parseFloat(org.latitud), lng: parseFloat(org.longitud) },
                                    map: map,
                                    title: org.nombre
                                });

                                const infowindow = new google.maps.InfoWindow({
                                    content: `<div><strong>${org.nombre}</strong><br>${org.direccion}<br>${org.descripcion}</div>`
                                });

                                marker.addListener('click', () => {
                                    infowindow.open(map, marker);
                                });
                            });
                        });
                }, function () {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                handleLocationError(false, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, pos) {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: pos,
                zoom: 6,
            });

            const infoWindow = new google.maps.InfoWindow({
                position: pos,
                content: browserHasGeolocation ?
                    'Error: El servicio de geolocalización ha fallado.' :
                    'Error: Tu navegador no soporta la geolocalización.'
            });
            infoWindow.open(map);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I&callback=initMap"></script>
</body>
</html>
