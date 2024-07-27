
<?php

    require_once SERVERURL . 'Modelo/tips-modelo.php';

    class TipsControlador extends TipsModelo {

        public function listarTipsControl() {

            $query = self::listarTipsModelo();
            $tips = $query -> rowCount() > 0 ? $query -> fetchAll(PDO::FETCH_ASSOC) : [];

            if (!empty($tips)):
                $i = 0;
                foreach ($tips as $tip):
                    ?>
                        <!-- TARJETA DE TIP -->
                        <div class="tip-target-content">
                            <div class="img-target">
                                <img src="<?= RUTARECURSOS?>IMG/SUBIDAS/<?=$tip['imagen']?>" alt="tip-card">
                                <div class="tip-number">
                                    <span><?=++$i?></span>
                                </div>
                            </div>
                            <div class="tip-info">
                                <h3><?=$tip['titulo']?></h3>
                                <hr>
                                <p><?=$tip['descripcion']?></p>
                            </div>
                        </div>
                    <?php
                endforeach;
            else:
                ?>
                    <div class="empty-register">
                        <h2>NO HAY TIPS TODAVÍA</h2>
                    </div>
                <?php
            endif;

        }

    }
