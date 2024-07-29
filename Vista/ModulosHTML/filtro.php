<!-- COLOR DEL FILTRO -->
<?php
    $colorForm = '';

    if (isset($_GET['views'])) {
        switch ($_GET['views']) {
            case 'en_adopcion':
                $colorForm = '609e4b';
                break;

            case 'en_peligro':
                $colorForm = 'cc5e55';
                break;

            case 'encontrados':
                $colorForm = '7a94ad';
                break;

            case 'perdidos':
                $colorForm = 'cdb23c';
                break;

            default:
                $colorForm = 'fcb271';
                break;
        }
    } else { $colorForm = 'beb2d6'; }
?>

<!-- CONTENEDOR DEL FILTRO -->
<div class="search-category-container">

    <!-- IMAGEN DETRÁS DEL FILTRO -->
    <div class="filter-dog-image">
        <!-- IMG -->
    </div>

    <!-- FILTRO DE BUSQUEDA -->
    <form action="<?=SERVER?>Ajax/filtroAjax.php" method="POST" class="en-adopcion encontrados formAjax" style="background-color: #<?=$colorForm?>;">
        <span>
            Quiero buscar un....
        </span>

        <!-- TIPO DE MASCOTA -->
        <div class="checbox-filter">
            <!-- PERRO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="perro" name="perro" value="1" checked/>
                <span class="checkmark"></span>
            </label>
            <!-- GATO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="gato" name="gato" value="1" checked/>
                <span class="checkmark"></span>
            </label>

            <!-- SEXO -->
            <!-- MACHO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="macho" name="macho" value="1" checked/>
                <span class="checkmark"></span>
            </label>
            <!-- HEMBRA -->
            <label class="custom-checkbox">
                <input type="checkbox" id="hembra" name="hembra" value="1" checked/>
                <span class="checkmark"></span>
            </label>

            <!-- TAMAÑO -->
            <!-- PEQUEÑO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="pequenio" name="pequenio" value="1" checked/>
                <span class="checkmark" title="Pequeño" ></span>
            </label>
            <!-- MEDIANO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="mediano" name="mediano" value="1" checked/>
                <span class="checkmark" title="Mediano" ></span>
            </label>
            <!-- GRANDE -->
            <label class="custom-checkbox">
                <input type="checkbox" id="grande" name="grande" value="1" checked/>
                <span class="checkmark" title="Grande"></span>
            </label>

            <!-- EDAD -->
            <!-- CACHORRO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="cachorro" name="cachorro" value="1" checked/>
                <span class="checkmark" title="Cachorro"></span>
            </label>
            <!-- ADULTO -->
            <label class="custom-checkbox">
                <input type="checkbox" id="adulto" name="adulto" value="1" checked/>
                <span class="checkmark" title="Adulto"></span>
            </label>
            <!-- ADULTO MAYOR -->
            <label class="custom-checkbox">
                <input type="checkbox" id="adultoMayor" name="adultoMayor" value="1" checked/>
                <span class="checkmark" title="Adulto mayor"></span>
            </label>
        </div>

        <!-- ESTADOS DE LA REPUBLICA -->
        <div class="submit-check-form">
            <select name="estado" id="estado">
                <option selected disabled>Ubicación</option>
                <option value="">República Mexicana</option>
                <option value="aguascalientes">Aguascalientes</option>
                <option value="baja-california">Baja California</option>
                <option value="baja-california-sur">Baja California Sur</option>
                <option value="campeche">Campeche</option>
                <option value="chiapas">Chiapas</option>
                <option value="chihuahua">Chihuahua</option>
                <option value="coahuila">Coahuila</option>
                <option value="colima">Colima</option>
                <option value="cdmx">Ciudad de México</option>
                <option value="durango">Durango</option>
                <option value="guanajuato">Guanajuato</option>
                <option value="guerrero">Guerrero</option>
                <option value="hidalgo">Hidalgo</option>
                <option value="jalisco">Jalisco</option>
                <option value="mexico">México</option>
                <option value="michoacan">Michoacán</option>
                <option value="morelos">Morelos</option>
                <option value="nayarit">Nayarit</option>
                <option value="nuevo-leon">Nuevo León</option>
                <option value="oaxaca">Oaxaca</option>
                <option value="puebla">Puebla</option>
                <option value="queretaro">Querétaro</option>
                <option value="quintana-roo">Quintana Roo</option>
                <option value="san-luis-potosi">San Luis Potosí</option>
                <option value="sinaloa">Sinaloa</option>
                <option value="sonora">Sonora</option>
                <option value="tabasco">Tabasco</option>
                <option value="tamaulipas">Tamaulipas</option>
                <option value="tlaxcala">Tlaxcala</option>
                <option value="veracruz">Veracruz</option>
                <option value="yucatan">Yucatán</option>
                <option value="zacatecas">Zacatecas</option>
            </select>
            <!-- BOTON ENVIAR -->
            <button type="submit"><span style="margin: 0 1.5em;">Buscar</span> <i class="fa-solid fa-paw"></i></button>
        </div>

        <input type="text" name="status" value="<?=htmlspecialchars($_GET['views'])?>" hidden readonly>
    </form>
    <!-- <div class="RespuestaAjax"></div> -->

</div>

<!-- AJAX -->
<script>
    $(document).ready(function() {
        $('.formAjax').submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let metodo = form.attr('method');
            let accion = form.attr('action');
            let perro = document.getElementById('perro').checked;
            let gato  = document.getElementById('gato').checked;
            let macho = document.getElementById('macho').checked;
            let hembra = document.getElementById('hembra').checked;
            let pequenio = document.getElementById('pequenio').checked;
            let mediano = document.getElementById('mediano').checked;
            let grande = document.getElementById('grande').checked;
            let cachorro = document.getElementById('cachorro').checked;
            let adulto = document.getElementById('adulto').checked;
            let adultoMayor = document.getElementById('adultoMayor').checked;

            // let respuesta = form.find('.RespuestaAjax');
            let formData = new FormData(this);
            if (formData.entries().next().done) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciona al menos un filtro de búsqueda',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                });
                return false;
            }

            if (!(perro || gato || macho || hembra || pequenio || mediano || grande || cachorro || adulto || adultoMayor)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciona al menos un filtro de búsqueda',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                });

            } else if (!(perro || gato)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciona al menos un filtro de tipo de animal',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                });

            } else if (!(macho || hembra)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciona al menos un filtro de sexo',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                });

            } else if (!(pequenio || mediano || grande)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciona al menos un filtro de tamaño',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                });

            } else if (!(cachorro || adulto || adultoMayor)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Selecciona al menos un filtro de edad',
                    text: '',
                    width: 400,
                    showConfirmButton: false,
                    timer: 1200,
                    toast: true,
                });

            } else {
                Swal.fire({
                    title: 'Buscando...',
                    // icon: 'info',
                    allowOutsideClick: false,
                    width: 210,
                    showConfirmButton: false,
                    timer: 900,
                    toast: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: accion,
                    type: metodo,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        setTimeout(function() {
                            $('.filtradosContainer').html(data);
                            // location.reload();
                        }, 900);
                    },
                    error: function() {
                        Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                    }

                });

            }

        });

    });
</script>

<!-- TOOLTIPS -->
<script>
    document.querySelectorAll('span[title]').forEach((span) => {
        const title = span.getAttribute('title');
        span.removeAttribute('title');
        tippy(span, {
            content: title,
            arrow: true,
            animation: 'fade',
            theme: 'custom',
        });
    });
</script>
