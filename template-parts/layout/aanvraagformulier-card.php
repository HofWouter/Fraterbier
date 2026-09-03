<?php

$current_lang = pll_current_language();
if ($current_lang == 'dk') {
    $bestellen = 'Bestillingsformular';
    $verkooppunt_text = 'Dette formular er udelukket for virksomhedskunder, ';
    $verkooppunt_link_text = 'se vores forhandlere';
} elseif ($current_lang == 'en') {
    $bestellen = 'Order form';
    $verkooppunt_text = 'This form is exclusively for business customers, ';
    $verkooppunt_link_text = 'view our retailers';
} else {
    $bestellen = 'Bestellen';
    $verkooppunt_text = 'Dit formulier is uitsluitend voor zakelijke klanten, ';
    $verkooppunt_link_text = 'bekijk onze verkoopunten';
}
?>

<section class="section section--accent section--first">
    <div class="section__title">
    <hr>
    <h2><?php echo esc_html($bestellen); ?></h2>
    <hr>
    </div>
    <p class="bier__caption"><?php echo esc_html($verkooppunt_text); ?>
        <a href="<?php echo esc_url($verkooppunt_page_url); ?>" class="bier__caption-link"><?php echo esc_html($verkooppunt_link_text); ?></a>
    </p>
    <div class="order order-max-width">
    <div class="order__form-wrapper">

    <?php
    $current_lang = pll_current_language();
    if ($current_lang == 'dk') {
        echo do_shortcode('[contact-form-7 id="b91dff3" title="Bestillingsformular" html_class="form__group"]');
    }
    elseif ($current_lang == 'en') {
        echo do_shortcode('[contact-form-7 id="610a86c" title="Order Form" html_class="form__group"]');
    }
    else {
    echo do_shortcode('[contact-form-7 id="706f35b" title="Aanvraagformulier" html_class="form__group"]');
    }
    ?>
    </div>
    </div>
</section>