
<?php

    require_once SERVERURL . 'Modelo/noticias-modelo.php';

    class NoticiasControlador extends NoticiasModelo {

        public function listarTipsControl() {

            $query = self::listarNoticiasModelo();
            $noticias = $query -> rowCount() > 0 ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            if (!empty($noticias)):
                foreach ($noticias as $noticia):
                    ?>
                        <!-- NOTICIA -->
                        <div class="blog-new-target">
                            <div class="title-new">
                                <h2><?=$noticia['titulo']?></h2>
                                <p><?=$noticia['subtitulo']?></p>
                                <p class="description-new"><?=$noticia['descripcion']?></p>
                            </div>
                            <div class="img-new">
                                <a href="">
                                    <img src="<?=RUTARECURSOS?>IMG/SUBIDAS/<?=$noticia['imagen']?>" alt="new-img">
                                </a>
                            </div>
                        </div>
                    <?php
                endforeach;
            else:
                ?>
                    <div class="empty-register">
                        <h2>NO HAY NOTICIAS TODAVÍA</h2>
                    </div>
                <?php
            endif;

        }

    }
