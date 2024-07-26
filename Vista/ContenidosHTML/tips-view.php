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
        $pagina = explode('/', $_GET['views']);
        $table = new CrudControlador();

?>
<body class="admin-index">
    <main class="content-page content-page-admin">

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- CONTENEDOR DE LA TABLA -->
        <div class="tables-contaniner">
            <!-- TABLA -->
            <?php $table -> listarTipsAdminControl($pagina[1] ?? 1, 1, ''); ?>
        </div>

        <!-- BOTON DE REGRESO -->
        <div class="back-icon bi-admin bb-tips" id="logo-image">
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


<!-- FORMULARIO AGREGAR TIPS -->
<script>

    $(document).ready(function() {

        if (sessionStorage.getItem('agregarTip') === 'true') {
            agregarOrg();
            sessionStorage.removeItem('agregarTip');
        }

        // BOTON AGREGAR ORGANIZACION
        $('.btn-add').click(function() {
            agregarTip();
        });

        // FORMULARIO AGREGAR ORGANIZACION
        async function agregarTip() {
            const { value: formValues } = await Swal.fire({
                title: "AGREGAR TIP",
                width: 430,
                html: `
                    <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                        <input id="nom-tip" class="swal2-input" placeholder="Titulo del Tip">
                        <textarea id="desc-tip" class="swal2-textarea" placeholder="Descripción" style="width:76%; resize: vertical; "></textarea>
                        <input type="file" id="img-tip" class="swal2-file">
                    </form>
                `,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    toast.classList.add('custom-toast-form');
                },
                focusConfirm: false,
                preConfirm: () => {
                    const titulo = document.getElementById('nom-tip').value;
                    const descripcion = document.getElementById('desc-tip').value;
                    const imagen = document.getElementById('img-tip').files[0];

                    if (!titulo || !descripcion || !imagen) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    return {
                        titulo: titulo,
                        descripcion: descripcion,
                        imagen: imagen
                    };

                }
            });

            if (formValues) {
                confirmacionAgregarTip(formValues);
            }

        }

        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmacionAgregarTip(datos) {
            let timerInterval;
            Swal.fire({
                title: "Agregando tip...",
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#d33",
                timer: 1700,
                // width: 300,
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
                    toast.classList.add('custom-toast-form');
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
                    enviarDatos(datos);
                } else {
                    Swal.fire({
                        title: "Operación cancelada",
                        timer: 2000,
                        icon: 'info',
                        width: 300,
                        showConfirmButton: false,
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
                    })
                }
            });
        }

        // ENVIO DE DATOS AL SERVIDOR
        function enviarDatos(datos) {
            var formData = new FormData();
            formData.append('titulo', datos.titulo);
            formData.append('descripcion', datos.descripcion);
            formData.append('imagen', datos.imagen);
            formData.append('action', 'add');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/tipsAjax.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.RespuestaAjax').html(response);
                    setTimeout(function() {
                        location.reload();
                    }, 1760);
                },
                error: function() {
                    Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                }
            });
        }

    });

</script>


<!-- ALERTA ELIMINAR TIP -->
<script>

    $(document).ready(function() {

        // BOTON ELIMINAR TIP
        $('.btn-delete').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const titulo = row.data('titulo');
            eliminarTip(id, titulo);
        });

        // ALERTA DE CONFIRMACION DE ELIMINACION
        function eliminarTip(id, titulo) {
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
                    confirmarEliminacion(id, titulo);
                } else if (result.isDenied) {
                    Swal.fire({
                        title: "Operación cancelada",
                        timer: 2000,
                        icon: 'info',
                        // width: 300,
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
                    })
                }
                });

            } else if ( result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Operación cancelada",
                    timer: 2000,
                    icon: 'info',
                    // width: 300,
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
                })
            }
            });
        }

        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmarEliminacion(id, titulo) {
            let timerInterval;
            Swal.fire({
                title: "Eliminando tip...",
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
                    enviarDatosEliminados(id, titulo);
                }
            });
        }
        // ENVIO DE DATOS AL SERVIDOR
        function enviarDatosEliminados(id, titulo) {
            var formData = new FormData();
            formData.append('id', id);
            formData.append('titulo', titulo);
            formData.append('action', 'delete');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/tipsAjax.php',
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


<!-- FORMULARIO EDITAR TIP -->
<script>

    $(document).ready(function() {

        if (sessionStorage.getItem('editarTip') === 'true') {
            editarTip();
            sessionStorage.removeItem('editarTip');
        }

        // BOTON EDITAR TIP
        $('.btn-update').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const titulo = row.data('titulo');
            const descripcion = row.data('descripcion');
            const imagen = row.data('foto');
            editarTip(id, titulo, descripcion, imagen);
        });

        // FORMULARIO EDITAR TIP
        async function editarTip(id, titulo, descripcion, imagen) {
            const { value: formValues } = await Swal.fire({
                title: 'EDITAR TIP',
                width: 430,
                html: `
                    <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                        <input id="edit-nom-tip" class="swal2-input" placeholder="Titulo" value="${titulo}">
                        <textarea id="edit-desc-tip" class="swal2-textarea" placeholder="Descripción" style="width:76%; resize: vertical; ">${descripcion}</textarea>
                        <div><img src="${imagen}" style="width: 40%;"/></div>
                        <input type="file" id="edit-img-tip" class="swal2-file">
                        <input type="hidden" id="current-img-tip" value="${imagen}">
                    </form>
                `,
                focusConfirm: false,
                didOpen: (toast) => {
                    toast.classList.add('custom-toast-form');
                },
                preConfirm: () => {
                    const titulo = document.getElementById('edit-nom-tip').value;
                    const descripcion = document.getElementById('edit-desc-tip').value;
                    const imagen = document.getElementById('edit-img-tip').files[0];
                    const imagenActual = document.getElementById('current-img-tip').value;

                    if (!titulo || !descripcion) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    return {
                        id: id,
                        titulo: titulo,
                        descripcion: descripcion,
                        imagen: imagen ? imagen : imagenActual
                    };
                }
            });

            if (formValues) {
                confirmarEditarTip(formValues);
            }
        }
        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmarEditarTip(datos) {
            let timerInterval;
            Swal.fire({
                title: "Actualizando tip...",
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#d33",
                timer: 1800,
                // width: 300,
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
                    toast.classList.add('custom-toast-form');
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
                    enviarDatosEditados(datos);
                } else {
                    Swal.fire({
                    title: "Operación cancelada",
                    timer: 2000,
                    icon: 'info',
                    // width: 300,
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
                    })
                }
            });
        }
        // ENVIO DE DATOS AL SERVIDOR
        function enviarDatosEditados(datos) {
            var formData = new FormData();
            formData.append('id', datos.id);
            formData.append('titulo', datos.titulo);
            formData.append('descripcion', datos.descripcion);
            formData.append('imagen', datos.imagen);
            formData.append('action', 'update');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/tipsAjax.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.RespuestaAjax').html(response);
                    setTimeout(function() {
                        location.reload();
                    }, 1760);
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
