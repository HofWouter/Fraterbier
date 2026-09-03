<?php
/**
 * 
 * Beschikbare variabelen (via extract in parent template):
 * @var string $naam - Naam van het bier
 * @var string $volume - Volume (bijv. "330ml")
 * @var string $alc - Alcoholpercentage (bijv. "8,5%")
 * @var string $omschrijving - Beschrijving van het bier
 * @var string $ingredienten - Ingrediënten
 * @var string $untappd_url - Link naar Untappd
 * @var bool $is_active - Of deze container actief is
 */


?>

<?php

$current_lang = pll_current_language();
    if ($current_lang == 'dk') {
        $button_text = 'Ansøgning';
        $Smaakprofiel_text = 'Smagsprofil';
        $Serveersuggestie_text = 'Serveringsforslag';
        $Ingredienten_text = 'Ingrediënten';
    }
    else if ($current_lang == 'en') {
        $button_text = 'Place a request';
        $Smaakprofiel_text = 'Taste profile';
        $Serveersuggestie_text = 'Serving suggestion';
        $Ingredienten_text = 'Ingredients';
    }
    else {
        $button_text = 'Aanvragen';
        $Smaakprofiel_text = 'Smaakprofiel';
        $Serveersuggestie_text = 'Serveersuggestie';
        $Ingredienten_text = 'Ingrediënten';
    }

?>

<div class="bier__type-wrapper">
    <div class="bier__type">
        <h3><?php echo esc_html( $args['naam'] ); ?></h3>
        <div class="bier__details">
            <h5><?php echo esc_html( $args['volume'].'ml' ); ?></h5>
            <h5>ALC. <?php echo esc_html( $args['alc'].'%' ); ?></h5>
        </div>
    </div>
    <hr>
</div>

<?php
    $bestel_page_id = pll_get_post( 99 );
    $bestel_page_url = get_permalink( $bestel_page_id );
?>

<a href="<?php echo esc_url( $bestel_page_url ); ?>"><button class="btn--primary btn btn--secondary"><?php echo $button_text; ?></button></a>

<div class="bier__type-wrapper">
    <h5><?php echo esc_html( $Smaakprofiel_text ); ?></h5>
    <p><?php echo wp_kses_post( $args['omschrijving'] ); ?></p>
    <h5><?php echo esc_html( $Serveersuggestie_text ); ?></h5>
    <p><?php echo esc_html( $args['serveersuggestie'] ); ?></p>
    <h5><?php echo esc_html( $Ingredienten_text ); ?></h5>
    <p><?php echo esc_html( $args['ingredienten'] ); ?></p>
</div>