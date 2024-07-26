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
            <!-- TABLA DE NOTICIAS -->
            <?php $table -> listarNoticiasControl($pagina[1] ?? 1, 1, ''); ?>
        </div>

        <!-- BOTON DE REGRESO -->
        <div class="back-icon bi-admin bb-blog" id="logo-image">
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


<!-- FORMULARIO AGREGAR NOTICIA -->
<script>

    $(document).ready(function() {

        if (sessionStorage.getItem('agregarNoticia') === 'true') {
            agregarNoticia();
            sessionStorage.removeItem('agregarNoticia');
        }

        // BOTON AGREGAR ORGANIZACION
        $('.btn-add').click(function() {
            agregarNoticia();
        });

        // FORMULARIO AGREGAR ORGANIZACION
        async function agregarNoticia() {
            const { value: formValues } = await Swal.fire({
                title: "AGREGAR NOTICIA",
                width: 700,
                html: `
                    <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                        <input id="title-new" class="swal2-input" placeholder="Titulo de la noticia" style="width:80%;">
                        <input id="subtitle-new" class="swal2-input" placeholder="Subtitulo de la noticia" style="width:80%;">
                        <textarea id="desc-new" class="swal2-textarea" placeholder="Descripción" style="width:80%; resize: vertical; "></textarea>
                        <input type="file" id="img-new" class="swal2-file">
                    </form>
                `,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    toast.classList.add('custom-toast-form');
                },
                focusConfirm: false,
                preConfirm: () => {
                    const titulo = document.getElementById('title-new').value;
                    const subtitulo = document.getElementById('subtitle-new').value;
                    const descripcion = document.getElementById('desc-new').value;
                    const imagen = document.getElementById('img-new').files[0];

                    if (!titulo || !subtitulo || !descripcion || !imagen) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    return {
                        titulo: titulo,
                        subtitulo: subtitulo,
                        descripcion: descripcion,
                        imagen: imagen
                    };

                }
            });

            if (formValues) {
                confirmacionAgregarNoticia(formValues);
            }

        }

        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmacionAgregarNoticia(datos) {
            let timerInterval;
            Swal.fire({
                title: "Agregando noticia...",
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
            formData.append('subtitulo', datos.subtitulo);
            formData.append('descripcion', datos.descripcion);
            formData.append('imagen', datos.imagen);
            formData.append('action', 'add');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/blogAjax.php',
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


<!-- ALERTA ELIMINAR NOTICIA -->
<script>

    $(document).ready(function() {

        // BOTON ELIMINAR TIP
        $('.btn-delete').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const titulo = row.data('titulo');
            eliminarNoticia(id, titulo);
        });

        // ALERTA DE CONFIRMACION DE ELIMINACION
        function eliminarNoticia(id, titulo) {
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
                title: "Eliminando noticia...",
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
                url: '<?=SERVER?>Ajax/blogAjax.php',
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


<!-- FORMULARIO EDITAR NOTICIA -->
<script>

    $(document).ready(function() {

        if (sessionStorage.getItem('editarNoticia') === 'true') {
            editarNoticia();
            sessionStorage.removeItem('editarNoticia');
        }

        // BOTON EDITAR TIP
        $('.btn-update').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const titulo = row.data('titulo');
            const subtitulo = row.data('subtitulo');
            const descripcion = row.data('descripcion');
            const imagen = row.data('imagen');
            editarNoticia(id, titulo, subtitulo, descripcion, imagen);
        });

        // FORMULARIO EDITAR TIP
        async function editarNoticia(id, titulo, subtitulo, descripcion, imagen) {
            const { value: formValues } = await Swal.fire({
                title: 'EDITAR NOTICIA',
                width: 700,
                html: `
                    <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                        <input id="edit-title-new" class="swal2-input" placeholder="Titulo" value="${titulo}" style="width:76%;">
                        <input id="edit-sub-new" class="swal2-input" placeholder="Titulo" value="${subtitulo}" style="width:76%;">
                        <textarea id="edit-desc-new" class="swal2-textarea" placeholder="Descripción" style="width:76%; resize: vertical; ">${descripcion}</textarea>
                        <div><img src="${imagen}" style="width: 40%;"/></div>
                        <input type="file" id="edit-img-new" class="swal2-file">
                        <input type="hidden" id="current-img-new" value="${imagen}">
                    </form>
                `,
                focusConfirm: false,
                didOpen: (toast) => {
                    toast.classList.add('custom-toast-form');
                },
                preConfirm: () => {
                    const titulo = document.getElementById('edit-title-new').value;
                    const subtitulo = document.getElementById('edit-sub-new').value;
                    const descripcion = document.getElementById('edit-desc-new').value;
                    const imagen = document.getElementById('edit-img-new').files[0];
                    const imagenActual = document.getElementById('current-img-new').value;

                    if (!titulo || !descripcion) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    return {
                        id: id,
                        titulo: titulo,
                        subtitulo: subtitulo,
                        descripcion: descripcion,
                        imagen: imagen ? imagen : imagenActual
                    };
                }
            });

            if (formValues) {
                confirmarEditarNoticia(formValues);
            }
        }
        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmarEditarNoticia(datos) {
            let timerInterval;
            Swal.fire({
                title: "Actualizando noticia...",
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
            formData.append('subtitulo', datos.subtitulo);
            formData.append('descripcion', datos.descripcion);
            formData.append('imagen', datos.imagen);
            formData.append('action', 'update');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/blogAjax.php',
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
