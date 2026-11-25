<?php

namespace modules\orders;

use Craft;
use craft\contactform\events\SendEvent;
use craft\contactform\Mailer;
use craft\elements\Entry;
use yii\base\Event;

/**
 * Bewaart elke bestelaanvraag (templates/_partials/forms/order.twig) als entry
 * in de sectie "Bestellingen", naast de e-mail die de Contact Form-plugin verstuurt.
 *
 * Het opslaan gebeurt vlak vóór het mailen (na de validatie), zodat de bestelling
 * ook bewaard blijft als het versturen van de e-mail mislukt.
 */
class Module extends \yii\base\Module
{
    /** Zo heet een aantal-veld in het bestelformulier: "<Biernaam> (dozen)" */
    private const BEER_SUFFIX = ' (dozen)';

    public function init(): void
    {
        Craft::setAlias('@modules/orders', __DIR__);
        parent::init();

        Event::on(Mailer::class, Mailer::EVENT_BEFORE_SEND, function (SendEvent $event) {
            $request = Craft::$app->getRequest();
            if ($request->getIsConsoleRequest() || !$request->getBodyParam('orderForm')) {
                return; // alleen het bestelformulier, niet het contactformulier
            }

            try {
                $this->saveOrder($event);
            } catch (\Throwable $e) {
                // Nooit de bestelling (e-mail) laten mislukken door het opslaan
                Craft::error('Bestelling kon niet worden opgeslagen: ' . $e->getMessage(), __METHOD__);
            }
        });
    }

    private function saveOrder(SendEvent $event): void
    {
        $entries = Craft::$app->getEntries();
        $section = $entries->getSectionByHandle('orders');
        $type = $entries->getEntryTypeByHandle('order');
        if (!$section || !$type) {
            Craft::warning('Sectie "orders" ontbreekt: bestelling niet opgeslagen.', __METHOD__);
            return;
        }

        $submission = $event->submission;
        $message = is_array($submission->message) ? $submission->message : ['body' => (string)$submission->message];
        $get = fn(string $key) => trim((string)($message[$key] ?? ''));

        // Bieren met een aantal > 0
        $beers = [];
        foreach ($message as $key => $value) {
            if (str_ends_with((string)$key, self::BEER_SUFFIX) && (int)$value > 0) {
                $beers[] = [
                    'bier' => substr($key, 0, -strlen(self::BEER_SUFFIX)),
                    'dozen' => min((int)$value, 999),
                ];
            }
        }

        $address = implode("\n", array_filter([
            trim($get('Straat') . ' ' . $get('Nr.')),
            trim($get('Postcode') . ' ' . $get('Plaats')),
            $get('Land'),
        ]));

        $company = $get('Bedrijfsnaam');
        $name = trim((string)$submission->fromName);
        $totaal = array_sum(array_column($beers, 'dozen'));

        $entry = new Entry();
        $entry->sectionId = $section->id;
        $entry->typeId = $type->id;
        $entry->siteId = Craft::$app->getSites()->getPrimarySite()->id;
        $entry->title = sprintf('%s – %d %s', $company ?: ($name ?: 'Onbekend'), $totaal, $totaal === 1 ? 'doos' : 'dozen');
        $entry->setFieldValues([
            'orderStatus' => 'nieuw',
            'orderBeers' => $beers,
            'orderCompany' => $company,
            'orderContactName' => $name,
            'orderEmail' => trim((string)$submission->fromEmail),
            'orderPhone' => $get('Telefoonnummer'),
            'orderAddress' => $address,
            'orderNotes' => $get('body'),
            'orderLanguage' => Craft::$app->getSites()->getCurrentSite()->name,
        ]);

        if (!Craft::$app->getElements()->saveElement($entry)) {
            Craft::error('Bestelling niet opgeslagen: ' . json_encode($entry->getErrors()), __METHOD__);
        }
    }
}
