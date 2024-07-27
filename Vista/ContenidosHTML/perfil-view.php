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
                        $post -> listarPostsControlador();
                    ?>
                </div>

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
                            html: '<div style="text-align: center;"><img src="<?=$_SESSION['photo']?>" style="height: 80px; border-radius: 50%;" /></div>',
                            showConfirmButton: false,
                            timer: 3000,
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
</html>
<?php } ?>

