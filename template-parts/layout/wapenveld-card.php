        <?php
        $fotoblok_2 = get_field('fotoblok_2', 27);
        $fotoblok_2_title = is_array($fotoblok_2) ? ($fotoblok_2['fotoblok_2_title'] ?? '') : '';
        ?>
        
        <section id="wapenveld" style="--bg-wapenveld: url('<?php echo esc_url($fotoblok_2['fotoblok_2_image']['url']); ?>');" class="section">
            <div class="header__wrapper">
                <h3>
                    <?php
                    echo esc_html($fotoblok_2_title);
                    ?>
                </h3>
            </div>
        </section>