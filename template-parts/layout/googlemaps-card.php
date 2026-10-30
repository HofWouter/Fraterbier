<section class="section waar-te-koop--accent">
    <div class="section__title">
        <hr>
        <h2>Verkooppunten</h2>
        <hr>
    </div>
    <?php
    $locatie_pagina_id = function_exists( 'pll_get_post' )
        ? pll_get_post( 124 )
        : 124;
    $locatie_pagina_id = $locatie_pagina_id ? $locatie_pagina_id : 124;
    $acf_locaties = array();

    for ( $i = 1; $i <= 10; $i++ ) {
        $locatie_veld = get_field( 'locatie' . $i, $locatie_pagina_id );

        if ( ! is_array( $locatie_veld ) || empty( $locatie_veld['lat'] ) || empty( $locatie_veld['lng'] ) ) {
            continue;
        }

        $acf_locaties[] = array(
            'lat'   => $locatie_veld['lat'],
            'lng'   => $locatie_veld['lng'],
            'naam'  => ! empty( $locatie_veld['name'] ) ? $locatie_veld['name'] : get_the_title( $locatie_pagina_id ),
            'adres' => ! empty( $locatie_veld['address'] ) ? $locatie_veld['address'] : '',
        );
    }
    ?>
    <script>
        var locaties = <?php echo wp_json_encode( $acf_locaties, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ); ?>;
    </script>
    <div id="map" class="kaart"></div>
</section>