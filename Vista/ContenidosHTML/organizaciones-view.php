<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || $_SESSION['tipoU'] != 'Administrador'):
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
        <div class="tables-contaniner">
            <!-- TABLA ORGANIZACIONES -->
            <?php $table -> listarOrganizacionesAdminControl($pagina[1] ?? 1, 1, ''); ?>
        </div>

        <!-- BOTON DE RETORNO AL DASHBOARD -->
        <div class="back-icon bi-admin bb-org" id="logo-image">
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


<!-- FORMULARIO AGREGAR ORGANIZACIONES -->
<script>

    $(document).ready(function() {

        if (sessionStorage.getItem('agregarOrg') === 'true') {
            agregarOrg();
            sessionStorage.removeItem('agregarOrg');
        }

        // BOTON AGREGAR ORGANIZACION
        $('.btn-add').click(function() {
            agregarOrg();
        });

        // FORMULARIO AGREGAR ORGANIZACION
        async function agregarOrg() {
            const { value: formValues } = await Swal.fire({
                title: "AGREGAR ORGANIZACIÓN",
                width: 900,
                html: `
                    <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                        <input id="nom-org" class="swal2-input" placeholder="Nombre de la organización">
                        <input id="num-org" class="swal2-input" minlength="10" maxlength="10" placeholder="Número de contacto">
                        <input id="correo-org" class="swal2-input" type="email" placeholder="Correo">
                        <input id="dir-org" class="swal2-input" placeholder="Dirección">
                        <textarea id="desc-org" class="swal2-textarea" placeholder="Descripción" style="width:76%; resize: vertical; "></textarea>
                        <input type="file" id="img-org" class="swal2-file">
                    </form>
                `,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    toast.classList.add('custom-toast-form');
                },
                focusConfirm: false,
                preConfirm: () => {
                    const nombre = document.getElementById('nom-org').value;
                    const numero = document.getElementById('num-org').value;
                    const correo = document.getElementById('correo-org').value;
                    const direccion = document.getElementById('dir-org').value;
                    const descripcion = document.getElementById('desc-org').value;
                    const imagen = document.getElementById('img-org').files[0];

                    if (!nombre || !numero || !correo || !direccion || !descripcion || !imagen) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    return {
                        nombre: nombre,
                        numero: numero,
                        correo: correo,
                        direccion: direccion,
                        descripcion: descripcion,
                        imagen: imagen
                    };

                }
            });

            if (formValues) {
                confirmacionAgregarOrg(formValues);
            }

        }

        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmacionAgregarOrg(datos) {
            let timerInterval;
            Swal.fire({
                title: "Agregando organización...",
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
            formData.append('nombre', datos.nombre);
            formData.append('numero', datos.numero);
            formData.append('correo', datos.correo);
            formData.append('direccion', datos.direccion);
            formData.append('descripcion', datos.descripcion);
            formData.append('imagen', datos.imagen);
            formData.append('action', 'add');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/organizacionAjax.php',
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


<!-- ALERTA ELIMINAR ORGANIZACION -->
<script>

    $(document).ready(function() {

        // BOTON ELIMINAR ORGANIZACION
        $('.btn-delete').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const nombre = row.data('nombre');
            const numero = row.data('numero');
            const correo = row.data('correo');
            const direccion = row.data('direccion');
            const descripcion = row.data('descripcion');
            const imagen = row.data('foto');
            eliminarOrg(id, nombre, numero, correo, direccion, descripcion, imagen);
        });

        // ALERTA DE CONFIRMACION DE ELIMINACION
        function eliminarOrg(id, nombre, numero, correo, direccion, descripcion, foto) {
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
                    confirmarEliminacion(id, nombre, numero, correo, direccion, descripcion, foto);
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
        function confirmarEliminacion(id, nombre, numero, correo, direccion, descripcion, foto) {
            let timerInterval;
            Swal.fire({
                title: "Eliminando organización...",
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
                    enviarDatosEliminados(id, nombre, numero, correo, direccion, descripcion, foto);
                }
            });
        }
        // ENVIO DE DATOS AL SERVIDOR
        function enviarDatosEliminados(id, nombre, numero, correo, direccion, descripcion, foto) {
            var formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('numero', numero);
            formData.append('correo', correo);
            formData.append('direccion', direccion);
            formData.append('descripcion', descripcion);
            formData.append('imagen', foto);
            formData.append('action', 'delete');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/organizacionAjax.php',
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


<!-- FORMULARIO EDITAR ORGANIZACIONES -->
<script>

    $(document).ready(function() {

        if (sessionStorage.getItem('editarOrganizacion') === 'true') {
            editarOrganizacion();
            sessionStorage.removeItem('editarOrganizacion');
        }

        // BOTON EDITAR ORGANIZACION
        $('.btn-update').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const nombre = row.data('nombre');
            const numero = row.data('numero');
            const correo = row.data('correo');
            const direccion = row.data('direccion');
            const descripcion = row.data('descripcion');
            const imagen = row.data('foto');
            editarOrganizacion(id, nombre, numero, correo, direccion, descripcion, imagen);
        });

        // FORMULARIO EDITAR ORGANIZACION
        async function editarOrganizacion(id, nombre, numero, correo, direccion, descripcion, foto) {
            const { value: formValues } = await Swal.fire({
                title: 'EDITAR ORGANIZACIÓN',
                width: 900,
                html: `
                    <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                        <input id="edit-nom-org" class="swal2-input" placeholder="Nombre de la organización" value="${nombre}">
                        <input id="edit-num-org" class="swal2-input" minlength="10" maxlength="10" placeholder="Número" value="${numero}">
                        <input id="edit-correo-org" class="swal2-input" placeholder="Correo" value="${correo}">
                        <input id="edit-dir-org" class="swal2-input" placeholder="Dirección" value="${direccion}">
                        <textarea id="edit-desc-org" class="swal2-textarea" placeholder="Descripción" style="width:76%; resize: vertical; ">${descripcion}</textarea>
                        <div><img src="${foto}" style="width: 40%;"/></div>
                        <input type="file" id="edit-img-org" class="swal2-file">
                        <input type="hidden" id="current-img-org" value="${foto}">
                    </form>
                `,
                focusConfirm: false,
                didOpen: (toast) => {
                    toast.classList.add('custom-toast-form');
                },
                preConfirm: () => {
                    const nombre = document.getElementById('edit-nom-org').value;
                    const numero = document.getElementById('edit-num-org').value;
                    const correo = document.getElementById('edit-correo-org').value;
                    const direccion = document.getElementById('edit-dir-org').value;
                    const descripcion = document.getElementById('edit-desc-org').value;
                    const imagen = document.getElementById('edit-img-org').files[0];
                    const imagenActual = document.getElementById('current-img-org').value;

                    if (!nombre || !numero || !correo || !direccion || !descripcion) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    return {
                        id: id,
                        nombre: nombre,
                        numero: numero,
                        correo: correo,
                        direccion: direccion,
                        descripcion: descripcion,
                        imagen: imagen ? imagen : imagenActual
                    };
                }
            });

            if (formValues) {
                confirmarEditarOrg(formValues);
            }
        }

        // ALERTA CONFIRMACION DE ENVIO DE DATOS
        function confirmarEditarOrg(datos) {
            let timerInterval;
            Swal.fire({
                title: "Actualizando organización...",
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
            formData.append('nombre', datos.nombre);
            formData.append('numero', datos.numero);
            formData.append('correo', datos.correo);
            formData.append('direccion', datos.direccion);
            formData.append('descripcion', datos.descripcion);
            formData.append('imagen', datos.imagen);
            formData.append('action', 'update');

            $.ajax({
                type: 'POST',
                url: '<?=SERVER?>Ajax/organizacionAjax.php',
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
