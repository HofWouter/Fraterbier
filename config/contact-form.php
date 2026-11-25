<?php
/**
 * Instellingen voor de Contact Form-plugin (vervangt Contact Form 7)
 *
 * @see https://github.com/craftcms/contact-form
 */

use craft\helpers\App;

return [
    'toEmail' => App::env('CONTACT_FORM_TO_EMAIL') ?: 'info@brouwgildehulsbergen.nl',
    'prependSubject' => 'Frater website',
    'prependSender' => '',
    'allowAttachments' => false,
];
