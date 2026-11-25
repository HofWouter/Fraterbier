<?php
/**
 * Applicatieconfiguratie: eigen modules registreren.
 *
 * @see https://craftcms.com/docs/5.x/extend/module-guide.html
 */

use modules\orders\Module as OrdersModule;

return [
    'modules' => [
        'orders' => OrdersModule::class,
    ],
    'bootstrap' => ['orders'],
];
