<?php
/**
 * Gedeelde bootstrap voor public_html/index.php en de `craft` console-tool.
 */

define('CRAFT_BASE_PATH', __DIR__);
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH . '/vendor');

require_once CRAFT_VENDOR_PATH . '/autoload.php';

// Laad omgevingsvariabelen uit .env (als die bestaat)
if (class_exists(Dotenv\Dotenv::class)) {
    Dotenv\Dotenv::createUnsafeImmutable(CRAFT_BASE_PATH)->safeLoad();
}
