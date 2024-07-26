
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Digital_Solutions/Core/confGeneral.php";

    if (!isset($_GET['email']) || !isset($_GET['token'])) {
        header('Location: ' . SERVER . 'loggin-form');
        die();

    } else {
        $email = isset($_GET['email']) ? $_GET['email'] : '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="conf-body">

    <div class="confirm-email-container">
        <div class="conf-container row justify-content-md-center">
            <div class="img-ha">

            </div>
            <form action="<?= SERVER ?>Ajax/confirmEmailAjax.php" method="POST" autocomplete="off" class="formAjax" data-form="save">
                <h2>Introduzca el token</h2>
                <div class="mb-3">
                    <!-- <label for="c" class="form-label">Código de Verificación</label> -->
                    <input type="text" class="form-control" id="c" name="token" placeholder="Token">
                    <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email); ?>" hidden readonly>
                </div>

                <button type="submit" class="btn btn-primary btn-verify">Validar</button>
                <div class="RespuestaAjax"></div>
            </form>

        </div>
    </div>

</body>

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

            // var textoAlerta;
            // if (tipo === "save") {
            //     textoAlerta = "Los datos que enviaras quedaran almacenados en el sistema";
            // } else if (tipo === "delete") {
            //     textoAlerta = "Los datos serán eliminados completamente del sistema";
            // } else if (tipo === "update") {
            //     textoAlerta = "Los datos del sistema serán actualizados";
            // } else {
            //     textoAlerta = "¿Quieres realizar la operación solicitada?";
            // }

            $.ajax({
                type: metodo,
                url: accion,
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,

                success: function(data) {
                    Swal.fire({
                        title: data.title,
                        text: data.text,
                        width: 300,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                },
                error: function() {
                    Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                }
            });

        });
    });

</script>

</html>
