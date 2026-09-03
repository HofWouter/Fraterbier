<?php

function thema_setup() {

}

add_action('after_setup_theme', 'thema_setup');

function thema_scripts() {

    wp_enqueue_style(

        'style',
        get_stylesheet_uri()

    );

    wp_enqueue_script(

        'menu-script',
        get_template_directory_uri() . '/menu.js',
        array(),
        '1.0.0',
        true

    );

    wp_enqueue_script(

        'carousel-script',
        get_template_directory_uri() . '/carousel.js',
        array(),
        '1.0.0',
        true

    );

    }

function theme_enqueue_google_maps() {

    wp_enqueue_script(
        'google-maps-api', 
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyBtcRGd5bO-7oam343JMWZoupbOA1LmRgM&libraries=places,geometry', 
        array(), 
        null, 
        true
    );

    wp_enqueue_script(
        'my-google-map-init', 
        get_template_directory_uri() . '/acf_map.js', 
        array('google-maps-api'),
        '1.0.0', 
        true
    );
}

add_action('wp_enqueue_scripts', 'thema_scripts');
add_action('wp_enqueue_scripts', 'theme_enqueue_google_maps');

function my_acf_google_map_api( $api ) {
    $api['key'] = 'AIzaSyBtcRGd5bO-7oam343JMWZoupbOA1LmRgM';
    return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

add_action('init', function() {
    if (function_exists('pll_register_string')) {
        pll_register_string('Ga snel naar', 'Ga snel naar', 'Links');
        pll_register_string('Onze bieren', 'Onze bieren', 'Links');
        pll_register_string('Ons verhaal', 'Ons verhaal', 'Links');
        pll_register_string('Waar te koop?', 'Waar te koop?', 'Links');
        pll_register_string('Contact', 'Contact', 'Links');
        pll_register_string('Adres kop', 'Adres', 'Links');
        pll_register_string('Land', 'Nederland', 'Links');
        pll_register_string('Disclaimer', 'Disclaimer', 'Links');
        pll_register_string('Auteursrechten', 'Auteursrechten', 'Links');
        pll_register_string('Ontwerp door', 'Ontwerp door:', 'Links');

        pll_register_string('Nieuwsbrief-titel', 'Nieuwsbrief-titel', 'Nieuwsbrief');
        pll_register_string('Nieuwsbrief-tekst', 'Nieuwsbrief-tekst', 'Nieuwsbrief', true);

    }
});

    