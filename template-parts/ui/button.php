<?php

$text  = $args['text']  ?? 'Klik hier';
$url   = $args['url']   ?? '#';
$class = $args['class'] ?? 'btn--primary';
?>

<a href="<?php echo esc_url($url); ?>
    "class="btn <?php echo esc_attr($class); ?>">
    <?php echo esc_html($text); ?>
</a>