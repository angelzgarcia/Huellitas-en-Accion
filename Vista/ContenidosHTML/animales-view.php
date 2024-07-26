<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador') :
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    else:
        require_once RUTACONTROL . 'crud-controlador.php';
        $table = new CrudControlador();
        $pagina = explode('/', $_GET['views']);

?>
<body class="admin-index">
    <main class="content-page content-page-admin">

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- CONTENEDOR DE LA TABLA -->
        <div class="tables-contaniner table-animals-container">
            <!-- TABLA -->
            <?php $table->listarAnimalesAdminControl($pagina[1] ?? 1, 10, '');?>
        </div>

        <!-- BOTON DE REGRESO -->
        <div class="back-icon bi-admin bb-animales" id="logo-image">
            <a href="<?= SERVER ?>admin_dashboard" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
            </a>
        </div>

    </main>
</body>

<!-- OPCIONES DE ORDENAMIENTO -->
<script>
    $(document).ready(function () {

        $('.sort-btn').click(function () {
            mostrarOrdenamietos();
        });

        function mostrarOrdenamietos() {
            const sortMethods = document.getElementById('sortMethodsContainer');
            sortMethods.classList.toggle('hiddenSM');
        }

        $('.sortId-btn').click(function () {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = window.location.href;

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'sort';
                input.value = 'sortId';

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();

        });

        $('.sortName-btn').click(function () {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = window.location.href;

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'sort';
                input.value = 'sortName';

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();

        });

    });
</script>


<!-- ALERTA ELIMINAR ANIMAL -->
<script>

    $(document).ready(function() {
        // BOTON ELIMINAR ANIMAL
        $('.btn-delete').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('idanimal');
            const idUsuario = row.data('idusuario');
            const idUbicacion = row.data('idubicacion');
            eliminarAnimal(id, idUsuario, idUbicacion);
        });

        // ALERTA DE CONFIRMACION DE ELIMINACION
        function eliminarAnimal(id, idUsuario, idUbicacion) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Quiero eliminar este registro",
                text: "¡Esta acción no podrá revertirse!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                confirmButtonColor: "#c62e2e",
                cancelButtonColor: "#7066e0",
                reverseButtons: true,
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
                },
                didOpen: (toast) => {
                    toast.classList.add('custom-toast-form');
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Entiendo los efectos que esto puede tener...",
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Guardar",
                        confirmButtonColor: "#c62e2e",
                        denyButtonText: `No guardar`,
                        denyButtonColor: "#7066e0",
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
                        },
                        didOpen: (toast) => {
                            toast.classList.add('custom-toast-form');
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            confirmarEliminacion(id, idUsuario, idUbicacion);
                        } else if (result.isDenied) {
                            Swal.fire({
                                title: "Operación cancelada",
                                timer: 2000,
                                icon: 'info',
                                toast: true,
                                didOpen: (toast) => {
                                    toast.classList.add('custom-toast-form');
                                },
                                showConfirmButton: false,
                                showClass: {
                                    popup: `
                                    animate__animated
                                    animate__fadeInDown
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
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Operación cancelada",
                        timer: 2000,
                        icon: 'info',
                        toast: true,
                        didOpen: (toast) => {
                            toast.classList.add('custom-toast-form');
                        },
                        showConfirmButton: false,
                        showClass: {
                            popup: `
                            animate__animated
                            animate__fadeInDown
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
            });
        }

        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmarEliminacion(id, idUsuario, idUbicacion) {
            let timerInterval;
            Swal.fire({
                title: "Eliminando animal...",
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1500,
                width: 300,
                timerProgressBar: true,
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
                },
                didOpen: (toast) => {
                    toast.classList.add("custom-toast-form");
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    enviarDatosEliminados(id, idUsuario, idUbicacion);
                }
            });
        }

        // ENVIO DE DATOS AL SERVIDOR
        function enviarDatosEliminados(id, idUsuario, idUbicacion) {
            var formData = new FormData();
            formData.append('idAnimal', id);
            formData.append('idUsuario', idUsuario);
            formData.append('idUbicacion', idUbicacion);
            formData.append('action', 'delete');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/animalesAjax.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.RespuestaAjax').html(response);
                    setTimeout(function() {
                        location.reload();
                    }, 1600);
                },
                error: function() {
                    Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                }
            });
        }

            $('.formAjax').submit(function(e) {
                e.preventDefault();
            });

        });

</script>


<!-- TOOLTIPS BUTTONS -->
<script>
    document.querySelectorAll('button[title]').forEach((button) => {
        const title = button.getAttribute('title');
        button.removeAttribute('title');
        tippy(button, {
            content: title,
            arrow: true,
            animation: 'fade',
        });
    });
</script>

</html>
<?php endif; ?>
