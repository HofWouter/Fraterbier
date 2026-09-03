      <?php 
      $link = get_field('over_ons_-_link');
      ?>
      
      <section  class="section section--accent text-block--center">
            <div class="section__title">
                <hr>
                <h2><?php the_field('over_ons_-_titel') ?></h2>
                <hr>
            </div>
                <div class="text-block--center text-block">
                    <h2><?php the_field ('over-ons_ondertitel')?></h2>
                    <div class="text-block--center text-block__element">
                        <p><?php the_field ('over-ons_broodtekst')?></p>  

                        <?php
                        $current_lang = pll_current_language();
                        if ($current_lang == 'dk') {
                            $link = 'Læs mere';
                        }
                        else if ($current_lang == 'en') {
                            $link = 'Read more';
                        }
                        else {
                            $link = 'Lees meer';
                        }
                        ?>

                        <a href="<?php the_field('over_ons_-_link'); ?>" class="btn--primary btn"><?php echo $link; ?></a>
                    </div>
                </div>
        </section>