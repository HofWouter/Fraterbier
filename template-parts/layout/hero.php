<?php
$image = get_field('hero_achtergrondfoto');
$url = $image['url'];   
?>

<section class="header" style="--bg-image: url('<?php echo $url; ?>')">
    <div class="header__wrapper">
        <div>
            <h1><?php the_field('welkomsttext'); ?></h1>
            <h4><?php the_field('welkomsttextondertitel'); ?></h4>
        </div>
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

        <a href="#onze-bieren-container" class="btn--primary btn"><?php echo $button_text; ?></a>
        </div>
    
</section>