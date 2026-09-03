        <?php
            $fotoblok = get_field('fotoblok', 27);
            $fotoblok_image = $fotoblok['fotoblok_image'] ?? '';
            $foto_url = '';

            if (is_array($fotoblok_image)) {
                $foto_url = $fotoblok_image['url'] ?? '';
            } elseif (is_numeric($fotoblok_image)) {
                $foto_url = wp_get_attachment_image_url((int) $fotoblok_image, 'full') ?: '';
            } else {
                $foto_url = $fotoblok_image;
            }
        ?>
        
        <section id="landschap" style="--bg-fotoblok: url('<?php echo esc_url($foto_url); ?>')" class="section text-block--center">
            <div class="text-block">
                <h3>
                    <?php echo esc_html ( $fotoblok['fotoblok_titel'] ); ?>
                </h3>
            </div>
        </section>