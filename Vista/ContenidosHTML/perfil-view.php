<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<?php
    if (!isset($_SESSION['tipoU']) || ($_SESSION['tipoU'] != 'Usuario' && $_SESSION['tipoU'] != 'Administrador')) {
        session_destroy();
        header('Location: ' . SERVER );
        exit();

    } else {
        $_SESSION['gen'] == 'm' ? $saludo = 'o' : $saludo = 'a';
        require_once SERVERURL . "Controlador/perfil-controlador.php";

?>
<body class="user-index" style="background-color: <?= $bgU = $_SESSION['tipoU'] == 'Administrador' ? '#232224' : ''; ?>;">
    <main class="content-page content-page-user">

        <!-- PERFIL CONTENEDOR -->
        <div class="profile-container <?=$_SESSION['tipoU'] != 'Administrador' ? 'profile-user' : 'profile-admin'; ?>">
            <!-- PERFIL BIO -->
            <div class="profile-header">
                <?php
                    $perfil = new PerfilControlador();
                    $perfil -> mostrarInfoPerfilControlador();
                ?>
            </div>

            <!-- CONTENEDOR DE PUBLICACIONES -->
            <div class="profile-content" style="background-color: <?= $_SESSION['tipoU'] == 'Usuario' ? '' : '#0b141a'; ?>;">
                <h2>Publicaciones</h2>
                <!-- CONTENEDOR DE PUBLICACION -->
                <div class="post-cards-container">
                    <!-- PUBLICACION -->
                    <?php
                        $post = new PerfilControlador();
                        $post -> listarPostsControlador(PerfilModelo::encryption(htmlspecialchars($_SESSION['email'])));
                    ?>
                </div>
                <div class="RespuestaAjax"></div>

            </div>
        </div>

        <!-- BARRA LATERAL -->
        <?php include_once RUTAMODULOS . "sidebar.php"; ?>

        <!-- AJAX PARA ALERTA DE BIENVENIDA PARA USUARIOS-->
        <?php
            if (isset($_SESSION['tipoU']) && $_SESSION['tipoU'] == 'Usuario'):
                ?>
                    <script>
                        const Toast = Swal.fire({
                            toast: true,
                            timerProgressBar: true,
                            // position: "top",
                            // icon: "success",
                            title: "<div style = 'text-align: center; font-size: 1.5em;'>¡ Bienvenid<?=$saludo?> <?=$_SESSION['nom']?> ! \n\\(^Д^)/</div> ",
                            html: '<div style="text-align: center;"><img src="<?=$_SESSION['photo']?>" style="height: 80px; width: 80px; object-fit: cover; object-position: center; border-radius: 50%; border: 1em outset #f0f2f5;" /></div>',
                            showConfirmButton: false,
                            timer: 1800,
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
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                                // toast.classList.add('custom-toast');
                            }
                        });
                    </script>
                <?php
            endif;
        ?>

    </main>
</body>

<!-- MENU ELIMINAR Y EDITAR POST Y BOTONES -->
<script>
    <?php $esUsuario = $_SESSOON['tipoU'] == 'Usuario'; ?>
    <?php $toast = "
                didOpen: (toast) => {
            toast.classList.add('custom-toast-form');
        },
    "
    ?>

    //  MENU OPCIONES POST
    document.addEventListener('DOMContentLoaded', function() {
        const moreOptionsButtons = document.querySelectorAll('.more-options');

        moreOptionsButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const dropdownMenu = this.closest('.info-post-card').querySelector('.options-posts-container');
                dropdownMenu.style.display = (dropdownMenu.style.display === 'flex') ? 'none' : 'flex';
            });
        });

        window.addEventListener('click', function(event) {
            moreOptionsButtons.forEach(button => {
                const dropdownMenu = button.closest('.info-post-card').querySelector('.options-posts-container');
                if (!event.target.closest('.more-options') && !event.target.closest('.options-posts-container')) {
                    dropdownMenu.style.display = 'none';
                }
            });
        });
    });

    // BOTON ELIMINAR POST
    document.addEventListener('DOMContentLoaded', function() {
        $('.delete-post').click(function(event) {
            event.preventDefault();

            const postId = this.getAttribute('data-id');
            eliminarPost(postId)

            function eliminarPost(postId) {
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
                    <?php if(!$esUsuario){ $toast; } ?>
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
                            <?php if(!$esUsuario){ $toast; } ?>
                        },
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Eliminando post...",
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
                                <?php if(!$esUsuario){ $toast; } ?>
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
                                enviarDatos(postId);
                            }
                        });

                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Operación cancelada",
                            timer: 2000,
                            icon: 'info',
                            // width: 300,
                            toast: true,
                            didOpen: (toast) => {
                                <?php if(!$esUsuario){ $toast; } ?>
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
                        <?php if(!$esUsuario){ $toast; } ?>
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

            function enviarDatos(postId) {
                var formData = new FormData();
                formData.append('id', postId);
                formData.append('action', 'deletePost');

                $.ajax({
                    type: 'POST',
                    url: '<?=SERVER?>Ajax/perfilAjax.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('.RespuestaAjax').html(response);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                    }
                });
            }
        });
    });

    // BOTON EDITAR POST
    document.addEventListener('DOMContentLoaded', function() {
        $('.update-post').click(function(event) {
            event.preventDefault();

            const postId = $(this).data('id');
            const nombre = $(this).data('nombre');
            const sexo = $(this).data('sexo');
            const tipoanimal = $(this).data('tipoanimal');
            const raza = $(this).data('raza');
            const estadoSalud = $(this).data('estadosalud');
            const status = $(this).data('status');
            const tamanio = $(this).data('tamanio');
            const peso = $(this).data('peso');
            const edad = $(this).data('edad');
            const descripcion = $(this).data('descripcion');
            const imagen = $(this).data('imagen');
            const fecha = $(this).data('fecha');
            editarPost(postId, estadoSalud, status, nombre, sexo, tipoanimal, raza, tamanio, peso, edad, descripcion, fecha);

            async function editarPost(postId, estadoSalud, status, nombre, sexo, tipoanimal, raza, tamanio, peso, edad, descripcion, fecha) {
                const { value: formValues } = await Swal.fire({
                    title: 'EDITAR ORGANIZACIÓN',
                    width: 600,
                    html: `
                        <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                            <div class="swal2-input" style="text-align: center; display: flex; width: 100%; flex-direction: column;
                            margin: auto; justify-content: space-between; align-items: center; gap: 1em; min-height: 100vh;">
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M40-199v-200h80v120h720v-120h80v200H40Zm342-161v-34h-3q-13 20-35 31.5T294-351q-49 0-77-25.5T189-446q0-42 32.5-68.5T305-541q23 0 42.5 3.5T381-526v-14q0-27-18.5-43T312-599q-21 0-39.5 9T241-564l-43-32q19-27 48-41t67-14q62 0 95 29.5t33 85.5v176h-59Zm-66-134q-32 0-49 12.5T250-446q0 20 15 32.5t39 12.5q32 0 54.5-22.5T381-478q-14-8-32-12t-33-4Zm185 134v-401h62v113l-3 40h3q3-5 24-25.5t66-20.5q64 0 101 46t37 106q0 60-36.5 105.5T653-351q-41 0-62.5-18T563-397h-3v37h-59Zm143-238q-40 0-62 29.5T560-503q0 37 22 66t62 29q40 0 62.5-29t22.5-66q0-37-22.5-66T644-598Z"/></svg>
                                    </span>
                                    <strong>
                                        Nombre:
                                    </strong>
                                    <small><em>${nombre}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#5790ab" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M176 288a112 112 0 1 0 0-224 112 112 0 1 0 0 224zM352 176c0 86.3-62.1 158.1-144 173.1l0 34.9 32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0 0 32c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-32-32 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l32 0 0-34.9C62.1 334.1 0 262.3 0 176C0 78.8 78.8 0 176 0s176 78.8 176 176zM271.9 360.6c19.3-10.1 36.9-23.1 52.1-38.4c20 18.5 46.7 29.8 76.1 29.8c61.9 0 112-50.1 112-112s-50.1-112-112-112c-7.2 0-14.3 .7-21.1 2c-4.9-21.5-13-41.7-24-60.2C369.3 66 384.4 64 400 64c37 0 71.4 11.4 99.8 31l20.6-20.6L487 41c-6.9-6.9-8.9-17.2-5.2-26.2S494.3 0 504 0L616 0c13.3 0 24 10.7 24 24l0 112c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-33.4-33.4L545 140.2c19.5 28.4 31 62.7 31 99.8c0 97.2-78.8 176-176 176c-50.5 0-96-21.3-128.1-55.4z"/></svg>
                                    </span>
                                    <strong>
                                        Sexo:
                                    </strong>
                                    <small><em>${sexo}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                                    </span>
                                    <strong>Tipo de animal:</strong>
                                    <small><em>${tipoanimal}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#5790ab" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M521.3 128C586.9 128 640 181.1 640 246.6s-53.1 118.6-118.7 118.6c-42.5 0-79.7-22.3-100.7-55.8c11.4-18.2 18-39.7 18-62.8s-6.6-44.6-18-62.8l0 0 .8-1.2c20.8-32.3 56.8-53.9 97.9-54.6l2 0zM320 128c42.5 0 79.7 22.3 100.7 55.8c-11.4 18.2-18 39.7-18 62.8s6.6 44.6 18 62.8l0 0-.8 1.2c-20.8 32.3-56.8 53.9-97.9 54.6l-2 0c-42.5 0-79.7-22.3-100.7-55.8c11.4-18.2 18-39.7 18-62.8s-6.6-44.6-18-62.8l0 0 .8-1.2c20.8-32.3 56.8-53.9 97.9-54.6l2 0zm-201.3 0c42.5 0 79.7 22.3 100.7 55.8c-11.4 18.2-18 39.7-18 62.8s6.6 44.6 18 62.8l0 0-.8 1.2c-20.8 32.3-56.8 53.9-97.9 54.6l-2 0C53.1 365.1 0 312.1 0 246.6S53.1 128 118.7 128z"/></svg>
                                    </span>
                                    <strong>Raza:</strong>
                                    <small><em>${raza}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#5790ab" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 336c0 26.5 21.5 48 48 48l544 0c26.5 0 48-21.5 48-48l0-160c0-26.5-21.5-48-48-48l-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0c-26.5 0-48 21.5-48 48L0 336z"/></svg>
                                    </span>
                                    <strong>Tamaño:</strong>
                                    <small><em>${tamanio}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M480-480q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm-60-100q-8 0-14-6t-6-14q0-8 6-14t14-6q8 0 14 6t6 14q0 8-6 14t-14 6Zm60 0q-8 0-14-6t-6-14q0-8 6-14t14-6q8 0 14 6t6 14q0 8-6 14t-14 6Zm60 0q-8 0-14-6t-6-14q0-8 6-14t14-6q8 0 14 6t6 14q0 8-6 14t-14 6ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Z"/></svg>
                                    </span>
                                    <strong>Peso:</strong>
                                    <small><em>${peso}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M240-280v-120H120v-80h120v-120h80v120h120v80H320v120h-80Zm390 80v-438l-92 66-46-70 164-118h64v560h-90Z"/></svg>
                                    </span>
                                    <strong>Edad:</strong>
                                    <small><em>${edad}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M480-400q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Z"/></svg>
                                    </span>
                                    <strong>Fecha de publicación:</strong>
                                    <small><em>${fecha}</em></small>
                                </p>
                                <p style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .5em;">
                                    <span style="display: flex; align-items: center; justify-content: center; gap: .5em;">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M120-240v-80h480v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
                                        <strong>Descripción:</strong>
                                    </span>
                                    <small><em>${descripcion}</em></small>
                                </p>

                                <div style="width: 100%; display: flex; flex-direction: column;">
                                    <label><strong>Modifica el estado de salud</strong></label>
                                    <select id="edit-estado-salud" class="swal2-input">
                                        <option value="Comprometido" ${estadoSalud === 'Comprometido' ? 'disabled selected' : ''}>Comprometido</option>
                                        <option value="Estable" ${estadoSalud === 'Estable' ? 'disabled selected' : ''}>Estable</option>
                                        <option value="Grave" ${estadoSalud === 'Grave' ? 'disabled selected' : ''}>Grave</option>
                                    </select><br>
                                    <label><strong>Modifica el status</strong></label>
                                    <select id="edit-status" class="swal2-input">
                                        <option value="Perdido" ${status === 'Perdido' ? 'disabled selected' : ''}>Perdido</option>
                                        <option value="Encontrado" ${status === 'Encontrado' ? 'disabled selected' : ''}>Encontrado</option>
                                        <option value="En Adopcion" ${status === 'En Adopcion' ? 'disabled selected' : ''}>En adopción</option>
                                        <option value="En Peligro" ${status === 'En Peligro' ? 'disabled selected' : ''}>En peligro</option>
                                    </select><br>
                                    <p style="width: 100%; display: flex; align-items: center; justify-content: center; gap: .5em;">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M480-260q75 0 127.5-52.5T660-440q0-75-52.5-127.5T480-620q-75 0-127.5 52.5T300-440q0 75 52.5 127.5T480-260Zm0-80q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM160-120q-33 0-56.5-23.5T80-200v-480q0-33 23.5-56.5T160-760h126l74-80h240l74 80h126q33 0 56.5 23.5T880-680v480q0 33-23.5 56.5T800-120H160Z"/></svg>
                                        <strong>Foto</strong>
                                    </p>
                                    <img src="${imagen}" alt="post-img" style="width: 52%; margin: auto; border-radius: .6em;"/>
                                </div>
                            </div>
                        </form>
                    `,
                    focusConfirm: false,
                    confirmButtonText: `
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: .5em;">
                            Actualizar
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m381-240 424-424-57-56-368 367-169-170-57 57 227 226Zm0 113L42-466l169-170 170 170 366-367 172 168-538 538Z"/></svg>
                        </div>
                    `,
                    preConfirm: () => {
                        const editEstadoSalud = document.getElementById('edit-estado-salud').value;
                        const editStatus = document.getElementById('edit-status').value;

                        return {
                            postId: postId,
                            status: editStatus,
                            estadoSalud: editEstadoSalud,
                        };
                    }
                });

                if (formValues) {
                    Swal.fire({
                        title: "Actualizando post...",
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
                            <?php if(!$esUsuario){ $toast; } ?>
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
                            confirmarEditarPost(formValues);
                        }
                    });
                }
            }

            function confirmarEditarPost(datos) {
                var formData = new FormData();
                formData.append('idPost', datos.postId);
                formData.append('status', datos.status);
                formData.append('estadoSalud', datos.estadoSalud);
                formData.append('action', 'updatePost');

                $.ajax({
                    type: 'POST',
                    url: '<?=SERVER?>Ajax/perfilAjax.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('.RespuestaAjax').html(response);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                    }
                });
            }
        });
    });

    // BOTON EDITAR SOBRE MI - BIOGRAFIA DEL PERFIL
    document.addEventListener('DOMContentLoaded', function() {
        $('.bio').click(function(event) {
            event.preventDefault();

            const email = $(this).data('emailuser');
            const sobreMi = $(this).data('sobremi');
            const foto = $(this).data('foto');
            editarBioPerfil(email, sobreMi, foto);

            async function editarBioPerfil(email, sobreMi, foto) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: true
                });
                const { value: formValues } = await Swal.fire({
                    title: 'Editar perfil',
                    html: `
                        <div>
                            <img src="${foto}" id="foto-actual" style="border-radius: 1em; width: 23%;" alt="profile foto"/>
                        </div>
                        <br>
                        <h3>Sobre mí</h3>
                        <textarea id="edit-sobreMi" class="swal2-textarea" style="width: 75%; resize: vertical; margin:0;" placeholder="Máximo 300 caracteres.\nMínimo 30 caracteres." aria-label="Ingresa tu frase de presentación aquí">${sobreMi}</textarea>
                        <br><br>
                        <h3>Cargar nueva foto</h3>
                        <input type="file" id="edit-imagenPerfil" style="margin:0;" class="swal2-file" accept="image/*" aria-label="Sube tu foto de perfil">
                        <input type="text" id="fotoactual" value="${foto}" style="margin:0;" hidden readonly accept="image/*" >
                    `,
                    confirmButtonText: "Guardar",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    cancelButtonColor: 'red',
                    preConfirm: () => {
                        const sobreMi = document.getElementById('edit-sobreMi').value;
                        const editFoto = document.getElementById('edit-imagenPerfil').files[0];
                        const fotoActual = document.getElementById('fotoactual').value;
                        if (!sobreMi || !fotoActual) {
                            Swal.showValidationMessage('El campo es obligatorio');
                            return false;
                        }
                        if (sobreMi.length < 30) {
                            Swal.showValidationMessage('Mínimo 30 caracteres');
                            return false;
                        }
                        if (sobreMi.length > 300) {
                            Swal.showValidationMessage('Máximo 300 caracteres');
                            return false;
                        }
                        return {
                            email: email,
                            sobreMi: sobreMi,
                            fotoNueva: editFoto,
                            fotoActual: fotoActual,
                        };
                    }
                });
                if (formValues) {
                    Swal.fire({
                        title: "Actualizando perfil...",
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
                            <?php if(!$esUsuario){ $toast; } ?>
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
                            enviarDatos(formValues);
                        }
                    });
                }

            }

            function enviarDatos(formValues) {
                var formData = new FormData();
                formData.append('email', formValues.email);
                formData.append('sobreMi', formValues.sobreMi);
                formData.append('imagen', formValues.fotoNueva);
                formData.append('fotoActual', formValues.fotoActual);
                formData.append('action', 'updateBio');

                $.ajax({
                    type: 'POST',
                    url: '<?=SERVER?>Ajax/perfilAjax.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('.RespuestaAjax').html(response);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                    }
                });
            }
        });
    });

    // BOTON EDITAR INFO DEL PERFIL
    document.addEventListener('DOMContentLoaded', function() {
        $('.info-list').click(function(event) {
            event.preventDefault();

            const email = $(this).data('emailuser');
            const numero = $(this).data('numero');
            const ubicacion = $(this).data('ubicacion');
            editarInfoPerfil(email, numero, ubicacion);

            async function editarInfoPerfil(email, numero, ubicacion) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: true
                });
                const { value: formValues } = await Swal.fire({
                    title: 'Editar info',
                    html: `
                        <p style="width: 100%; display: flex; align-items: start; justify-content: center; gap: .2em;">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v58q0 59-40.5 100.5T740-280q-35 0-66-15t-52-43q-29 29-65.5 43.5T480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480v58q0 26 17 44t43 18q26 0 43-18t17-44v-58q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h200v80H480Zm0-280q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z"/></svg>
                            </span>
                            <small style="vertical-align:middle;" ><em>${email}</em></small>
                        </p>
                        <br>
                        <h3 style="display: flex; align-items: center; justify-content: center; gap: .3em;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M162-120q-18 0-30-12t-12-30v-162q0-13 9-23.5t23-14.5l138-28q14-2 28.5 2.5T342-374l94 94q38-22 72-48.5t65-57.5q33-32 60.5-66.5T681-524l-97-98q-8-8-11-19t-1-27l26-140q2-13 13-22.5t25-9.5h162q18 0 30 12t12 30q0 125-54.5 247T631-329Q531-229 409-174.5T162-120Zm556-480q17-39 26-79t14-81h-88l-18 94 66 66ZM360-244l-66-66-94 20v88q41-3 81-14t79-28Zm358-356ZM360-244Z"/></svg>
                        </h3>
                        <input type="text" id="edit-numero" value="${numero}" class="swal2-input" placeholder="Número" maxlength="10" style="margin:0;">
                        <br><br>
                        <h3 style="display: flex; align-items: center; justify-content: center; gap: .3em;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5790ab"><path d="M480-360q56 0 101-27.5t71-72.5q-35-29-79-44.5T480-520q-49 0-93 15.5T308-460q26 45 71 72.5T480-360Zm0-200q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0 374q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                        </h3>
                        <input type="text" id="edit-ubicacion" value="${ubicacion}" placeholder="Ubicación" readonly class="swal2-input" style="margin:0;">
                        <br><br>
                        <input type="button" class="swal2-input" value="Obtener ubicación" onclick="obtenerUbicacion()" style="margin:0;">
                    `,
                    confirmButtonText: "Guardar",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    cancelButtonColor: 'red',
                    preConfirm: () => {
                        const numero = document.getElementById('edit-numero').value;
                        const ubicacion = document.getElementById('edit-ubicacion').value;
                        return {
                            email: email,
                            numero: numero,
                            ubicacion: ubicacion,
                        };
                    }
                });
                if (formValues) {
                    Swal.fire({
                        title: "Actualizando información...",
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
                            <?php if(!$esUsuario){ $toast; } ?>
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
                            enviarDatos(formValues);
                        }
                    });
                }

            }

            function enviarDatos(formValues) {
                var formData = new FormData();
                formData.append('email', formValues.email);
                formData.append('numero', formValues.numero);
                formData.append('ubicacion', formValues.ubicacion);
                formData.append('action', 'updateInfo');

                $.ajax({
                    type: 'POST',
                    url: '<?=SERVER?>Ajax/perfilAjax.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('.RespuestaAjax').html(response);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
                    }
                });
            }
        });
    });

</script>

<!-- OBTENER UBICACION -->
<script>

    const GOOGLE_MAPS_API_KEY = 'AIzaSyAXzKi-hpY--xwLB5skRjCIRNVyRHNfY7I';

    async function obtenerUbicacion() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                const { ciudad, pais } = await obtenerCiudadYPais(latitude, longitude);

                Swal.getPopup().querySelector('#edit-ubicacion').value = `${ciudad}, ${pais}`;
            }, function(error) {
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo obtener la ubicación. Asegúrate de que los permisos de geolocalización estén habilitados.',
                    icon: 'error'
                });
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: 'La geolocalización no es compatible con este navegador.',
                icon: 'error'
            });
        }
    }

    async function obtenerCiudadYPais(lat, lng) {
        const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${GOOGLE_MAPS_API_KEY}`;
        const response = await fetch(url);
        const data = await response.json();

        if (data.status === 'OK' && data.results.length > 0) {
            const addressComponents = data.results[0].address_components;
            let ciudad = '';
            let pais = '';

            addressComponents.forEach(component => {
                if (component.types.includes('locality')) {
                    ciudad = component.long_name;
                }
                if (component.types.includes('country')) {
                    pais = component.long_name;
                }
            });

            return { ciudad, pais };
        } else {
            return { ciudad: 'Ciudad no encontrada', pais: 'País no encontrado' };
        }
    }

</script>

<!-- TOOLTIPS -->
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

<!-- TOOLTIPS -->
<script>
    document.querySelectorAll('a[title]').forEach((a) => {
        const title = a.getAttribute('title');
        a.removeAttribute('title');
        tippy(a, {
            content: title,
            arrow: true,
            animation: 'fade',
        });
    });
</script>

</html>
<?php } ?>

