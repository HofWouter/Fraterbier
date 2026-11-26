<?php
/**
 * Applicatieconfiguratie: eigen modules registreren.
 *
 * @see https://craftcms.com/docs/5.x/extend/module-guide.html
 */

use modules\languageredirect\Module as LanguageRedirectModule;
use modules\orders\Module as OrdersModule;

return [
    'modules' => [
        'orders' => OrdersModule::class,
        'languageredirect' => LanguageRedirectModule::class,
    ],
    'bootstrap' => ['orders', 'languageredirect'],
];
