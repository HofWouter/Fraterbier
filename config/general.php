<?php
/**
 * Algemene Craft-configuratie
 *
 * @see https://craftcms.com/docs/5.x/reference/config/general.html
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

return GeneralConfig::create()
    ->defaultWeekStartDay(1)
    ->omitScriptNameInUrls()
    // Singles (home, onsVerhaal, contact, bestellen) zijn direct als variabele beschikbaar in Twig
    ->preloadSingles()
    ->devMode(App::env('CRAFT_DEV_MODE') ?? false)
    ->allowAdminChanges(App::env('CRAFT_ALLOW_ADMIN_CHANGES') ?? false)
    ->disallowRobots(App::env('CRAFT_DISALLOW_ROBOTS') ?? false)
    ->aliases([
        '@web' => rtrim(App::env('PRIMARY_SITE_URL') ?? '', '/'),
        '@webroot' => dirname(__DIR__) . '/public_html',
    ]);
