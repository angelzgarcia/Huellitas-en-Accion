
<!-- MODULO HEAD -->
<?php

    if (isset($_SESSION['tipoU'])) {
        header('Location:' . SERVER);
        exit();
    }
    $perros = [
        0 => RUTARECURSOS . "IMG/flouffy-qEO5MpLyOks-unsplash-removebg-preview.png",
        1 => RUTARECURSOS . "IMG/chrissy-langston-qTHbQscUKdw-unsplash.jpg",
        2 => RUTARECURSOS . "IMG/josh-rakower-zBsXaPEBSeI-unsplash.jpg",
        3 => RUTARECURSOS . "IMG/alan-king-KZv7w34tluA-unsplash.jpg",
        4 => RUTARECURSOS . "IMG/mel-elias-hhegBj6iJ5E-unsplash.jpg",
        5 => RUTARECURSOS . "IMG/roberto-nickson-ey5s8rNHG-c-unsplash.jpg"
    ];
    $perro = $perros[rand(0,count($perros)-1)];

    $gatos = [
        0 => RUTARECURSOS . "IMG/raoul-droog-yMSecCHsIBc-unsplash.jpg",
        1 => RUTARECURSOS . "IMG/erika-lowe-6KaUGzRscyE-unsplas.jpg"
        // 2 => RUTARECURSOS . "IMG/.jpg"
    ];
    $gato = $gatos[rand(0,count($gatos)-1)];
?>

<script async defer src="https://accounts.google.com/gsi/client"></script>
<body class="body_forms">
    <main class="content-page">

        <!-- FORMULARIOS DE REGISTRO E INICIO -->
        <div class="form-container" id="container">

            <!-- FORMULARIO DE INICIO DE SESION -->
            <div class="form-containt form-loggin" id="form-loggin">
                <!-- FORMULARIO -->
                <form action="<?=SERVER?>Ajax/sesionAjax.php" method="post" autocomplete="off" data-form="save" class="formAjax">
                    <h2>Introduce tus datos</h2>
                    <fieldset>
                        <legend><i class="fa-solid fa-envelope"></i></legend>
                        <input type="text" name="correo">
                    </fieldset>

                    <fieldset>
                        <legend><i class="fa-solid fa-key"></i></legend>
                        <input type="password" name="pass">
                    </fieldset>

                    <a href="">
                        ¿Olvidate tu contraseña?
                    </a>
                    <div class="buttons-loggin">
                        <button type="submit" class="loggin-submit-form"><p>Iniciar sesión</p></button>
                        <!-- BOTON DE GOOGLE -->
                        <div id="g_id_onload"
                            data-client_id="314207445739-jemg2fmtjl7enmaa1pr039bluqugjpqg.apps.googleusercontent.com"
                            data-callback="handleCredentialResponse">
                        </div>
                        <div class="g_id_signin" data-type="standard"></div>
                        <!-- BOTON DE FACEBOOK -->
                        <!-- <button onclick="facebookLogin()" class="f_sigin">Login with Facebook</button> -->
                    </div>
                    <div class="RespuestaAjax"></div>

                </form>

                <!-- SIDEFORM DE REGISTRO -->
                <div class="sideform-loggin" style="background-image: url(<?=$perro?>);">
                    <h2>¡Hola amigo humano!</h2>
                    <p>
                        ¿Aún no estas registrado?
                    </p>
                    <button type="button" class="register-button-form" id="button-register" onclick="cambiarFormulario()">Registrate</button>
                </div>
            </div>

            <!-- CONTENEDOR FORMULARIO DE REGISTRO -->
            <div class="form-containt form-register" id="form-register">
                <!-- SIDEFORM DE LOGUEO -->
                <div class="sideform-loggin sideform-register" style="background-image: linear-gradient(360deg, rgba(0, 0, 0, 0.241) 5%,rgba(0, 0, 0, 0)), url(<?=$gato?>);">
                    <h2>¡Purrfecto día!</h2>
                    <p>
                        ¿Prefieres iniciar sesión?
                    </p>
                    <button type="button" class="register-button-form"  onclick="cambiarFormulario()">Inicia sesión</button>
                </div>

                <!-- FORMULARIO DE REGISTRO -->
                <form action="<?=SERVER?>Ajax/usuarioAjax.php" method="POST" autocomplete="off" data-form="save" class="formAjax form-register">
                    <h2>Crea tu cuenta</h2>
                    <!-- nombre -->
                    <fieldset>
                        <legend>Nombre*</legend>
                        <input type="text" name="nombre" >
                    </fieldset>
                    <!-- apellidos -->
                    <fieldset>
                        <legend>Apellidos*</legend>
                        <input type="text" name="apellidos" >
                    </fieldset>
                    <!-- telefono -->
                    <fieldset>
                        <legend><i class="fa-brands fa-whatsapp"></i>*</legend>
                        <input type="tel" name="numero" maxlength="10" minlength="10">
                    </fieldset>
                    <!-- correo -->
                    <fieldset>
                        <legend><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#999899"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg>*</legend>
                        <input type="text" name="correo" ">
                    </fieldset>
                    <!-- contraseña -->
                    <fieldset>
                        <legend><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#999899"><path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z"/></svg>*</legend>
                        <input type="password" name="pass" title="Al menos: 1 Mayuscula, 1 minuscula, 1 número, un símbolo [@, $, !, %, *, ?, &] ">
                    </fieldset>
                    <!-- contraseña confirmacion -->
                    <fieldset>
                        <legend>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#999899"><path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z"/></svg><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#999899"><path d="M280-200v-80h284q63 0 109.5-40T720-420q0-60-46.5-100T564-560H312l104 104-56 56-200-200 200-200 56 56-104 104h252q97 0 166.5 63T800-420q0 94-69.5 157T564-200H280Z"/></svg>*
                        </legend>
                        <input type="password" name="confPass" title="Al menos: 1 Mayuscula, 1 minuscula, 1 número y un símbolo [@, $, !, %, *, ?, &] ">
                    </fieldset>
                    <!-- genero -->
                    <select name="genero" id="in-genero" class="sel-gen">
                        <option value="" selected disabled>Género</option>
                        <option value="m">Masculino</option>
                        <option value="f">Femenino</option>
                    </select>
                    <!-- términos y coniciones -->
                    <div class="check-term">
                        <input type="checkbox" name="termCond" id="termCond" style="visibility: visible;">
                        <label for="">
                            <small>
                                Soy mayor de 18 años, he leído y acepto los <a href="">Térnimos y condiciones</a>
                            </small>
                        </label>
                    </div>
                    <!-- botones de registro -->
                    <div class="buttons-loggin">
                        <button type="submit" class="loggin-submit-form"><p>Registrar</p></button>
                        <div id="g_id_onload"
                            data-client_id="314207445739-jemg2fmtjl7enmaa1pr039bluqugjpqg.apps.googleusercontent.com"
                            data-callback="handleCredentialResponse">
                        </div>
                        <div class="g_id_signin" data-type="standard"></div>
                    </div>

                    <div class="RespuestaAjax"></div>

                </form>
            </div>

        </div>

        <!-- BOTON RE REGRESO -->
        <div class="back-icon" id="logo-image">
            <a href="<?= SERVER ?>" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
            </a>
        </div>

        <!-- MODULO SIDEBAR -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

    </main>

    <!-- VALIDAR TOKEN GOOGLE -->
<script>
    function handleCredentialResponse(response) {
        const id_token = response.credential;
        console.log("ID Token: " + id_token);

        const formData = new FormData();
        formData.append('id_token', id_token);

        fetch('<?=SERVER?>Ajax/autenticarUsuarioAjax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(url => {
            console.log('Received URL:', url);  // Agrega esta línea para depuración
            if (url) {
                window.location.href = '<?=SERVER?>' + url;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de inicio de sesión: ' + error.message);
        });
    }

    window.onload = function() {
        google.accounts.id.initialize({
            client_id: "314207445739-jemg2fmtjl7enmaa1pr039bluqugjpqg.apps.googleusercontent.com",
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.querySelector(".g_id_signin"),
            { theme: "outline", size: "large" }
        );
    };
</script>

<!-- VALIDAR ID FACEBOOK -->
<!-- <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : 'YOUR_APP_ID',
                cookie     : true,
                xfbml      : true,
                version    : 'v12.0'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script> -->
</body>

<!-- SIDEFORM -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const sideform = document.getElementById('toggle-summary');
        if (sideform) {
            sideform.addEventListener('click', () => {
                this.classList.toggle('active');
            });
        }
    });
</script>

<!-- SWEETALERTS -->
<script>
    $(document).ready(function() {
    $('.formAjax').submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var tipo = form.attr('data-form');
        var accion = form.attr('action');
        var metodo = form.attr('method');
        var respuesta = form.find('.RespuestaAjax');

        var formdata = new FormData(this);
        var camposVacios = false;

        formdata.forEach(function(value, key) {
            if (!value) {
                camposVacios = true;
            }
        });

        if (camposVacios) {
            Swal.fire({
                // position: "top-end",
                icon: "info",
                title: "¡Hay campos vacíos!",
                text: "Completa el formulario para continuar",
                showConfirmButton: false,
                timer: 2000,
                toast: true,
            });
            return false;
        }

        $.ajax({
            type: metodo,
            url: accion,
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        if (percentComplete < 100) {
                            // respuesta.html('<p class="text-center">Procesado... (' + percentComplete + '%)</p><div><div style="width: ' + percentComplete + '%;"></div></div>');
                        } else {
                            // respuesta.html('<p>Proceso completado</p>');
                        }
                    }
                }, false);
                return xhr;
            },
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

<!-- TOOLTIPS PASSWORD -->
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


