<?php

    require_once RUTACONTROL . 'organizaciones-controlador.php';
    $targets = new OrganizacionesControl();
    $gatos = [
        0 => RUTARECURSOS . 'IMG/pacto-visual-cWOzOnSoh6Q-unsplash.jpg',
        1 => RUTARECURSOS . 'IMG/federica-diliberto-KEXUeZIev10-unsplash.jpg',
        // 2 => RUTARECURSOS . 'IMG/mikhail-vasilyev-Qmox1MkYDnY-unsplash.jpg',
        2 => RUTARECURSOS . 'IMG/diana-parkhouse-uqxHIVMyvJ4-unsplash.jpg'
    ];
    $gato = $gatos[rand(0, count($gatos)-1)];

?>

<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<body class="body-index">
    <main class="content-page">

        <!-- ENCABEZADO -->
        <?php require_once RUTAMODULOS . "header.php"; ?>

        <!-- BANNER DE ORGANIZACIONES -->
        <div class="banner-organizations" style="background-image: linear-gradient(30deg, rgba(0, 0, 0, 0.484) 30%, rgba(0, 0, 0, 0.2)), url(<?=$gato?>);" loading="lazy">
            <h1 class="org-title">Organizaciones</h1>
        </div>

        <!-- TARJETA DE ORGANIZACION -->
        <div class="organizations-container">
            <?php $targets -> listarOrganizacionesControl(); ?>
        </div>

        <!-- mapa de organizaciones -->
        <div id="map" class="mapOrganizaciones" style="margin: auto; margin-block-start: 6em; height: 500px; width: 100%;"></div>

        <!-- PIE DE PAGINA -->
        <?php require_once RUTAMODULOS . "footer.php"; ?>

        <!-- BARRA LATERAL -->
        <?php require_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- BOTON GO UP -->
        <?php include_once RUTAMODULOS . 'go-up-button.php'; ?>

    </main>
</body>

<?php
    require_once RUTACONTROL . 'organizaciones-controlador.php';
    $direcciones = new OrganizacionesControl();
    $coordenadas = $direcciones->obtenerDireccionesControlador();
?>

<script>
    const coordinates = <?php echo json_encode($coordenadas); ?>;
</script>

<script>
    function buildContent(nombre, direccion, imagen) {
        return `
            <div class="info-window-content">
                <h3>${nombre}</h3>
                <div class="details">
                    <span>${direccion}</span>
                    <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/${imagen}" class="icon" alt="Icon"/>
                </div>
            </div>
        `;
    }
</script>

<script>
    let map;

    function initMap() {
        const center = { lat: 23.6345, lng: -102.5528 };

        map = new google.maps.Map(document.getElementById("map"), {
            center: center,
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
    "stylers": [
      {
        "color": "#212121"
      }
    ]
  },
  {
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#212121"
      }
    ]
  },
  {
    "featureType": "administrative",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "administrative.country",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "administrative.locality",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#bdbdbd"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#181818"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1b1b1b"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#2c2c2c"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8a8a8a"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#373737"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#3c3c3c"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#4e4e4e"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#3d3d3d"
      }
    ]
  }
]
        });

        agregarMarcadores(coordinates);
    }

    function agregarMarcadores(coords) {
        coords.forEach(coord => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(coord.latitud), lng: parseFloat(coord.longitud) },
                map: map,
                icon: {
                    url: '<?=RUTARECURSOS?>IMG/dog-paw.png',
                    scaledSize: new google.maps.Size(36, 60)
                }
            });

            const infoWindow = new google.maps.InfoWindow({
                content: buildContent(coord.nombre, coord.direccion, coord.imagen)
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        });
    }

    function loadGoogleMapsAPI(callback) {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I&callback=${callback}`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadGoogleMapsAPI('initMap');
    });
</script>

</html>

