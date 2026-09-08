<?php
$image = get_field('hero_achtergrondfoto');
$url = $image['url'];   
?>

<section class="header" style="--bg-image: url('<?php echo $url; ?>')">
    <div class="header__wrapper">
        <h1><?php the_field('welkomsttext'); ?></h1>
        <?php
        $current_lang = pll_current_language();
        if ($current_lang == 'dk') {
            $button_text = 'Se mere';
        }
        else if ($current_lang == 'en') {
            $button_text = 'See more';
        }
        else {
            $button_text = 'Bekijk meer';
        }
        ?>

        <a href="#onze-bieren-container" class="btn--primary btn header__button"><?php echo $button_text; ?></a>
    </div>
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/header_overlay.png" alt="overlay" class="header__overlay">
</section>
