<?php

$languages = function_exists('pll_the_languages') ? pll_the_languages(array('raw' => 1)) : array();


$current_lang_slug = 'NL';
if (!empty($languages)) {
    foreach ($languages as $lang) {
        if ($lang['current_lang']) {
            $current_lang_slug = strtoupper($lang['slug']);
            break;
        }
    }
}
?>

<div id="btn-language--selector">
    <button class="btn">
        <span class="nav--btn"><?php echo esc_html($current_lang_slug); ?></span>
    </button>
    
    <?php if (!empty($languages)) : ?>
        <?php foreach ($languages as $lang) : ?>
            <?php if (!$lang['current_lang']) : ?>
                <a href="<?php echo esc_url($lang['url']); ?>" class="btn">
                    <span class="btn--language"><?php echo esc_html(strtoupper($lang['slug'])); ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>