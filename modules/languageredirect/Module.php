<?php

namespace modules\languageredirect;

use Craft;
use craft\web\Application;
use yii\base\Event;
use yii\web\Cookie;

/**
 * Stuurt Deense bezoekers bij hun eerste bezoek automatisch naar de Deense site (/dk/).
 *
 * Werkwijze:
 * - Kijkt naar de Accept-Language-header van de browser. De eerste taal uit die lijst
 *   waarvoor wij een site hebben (nl of da) bepaalt de keuze; is dat Deens en zit de
 *   bezoeker niet al op de Deense site, dan volgt een redirect naar dezelfde pagina
 *   in het Deens (of naar de Deense homepage als die pagina niet vertaald is).
 * - Dit gebeurt alleen bij het eerste bezoek: daarna staat er een cookie, zodat een
 *   bezoeker die via de taalkiezer bewust naar NL gaat, niet steeds wordt teruggestuurd.
 */
class Module extends \yii\base\Module
{
    private const COOKIE = 'frater_lang';
    private const TARGET_LANGUAGE = 'da';

    public function init(): void
    {
        Craft::setAlias('@modules/languageredirect', __DIR__);
        parent::init();

        Event::on(Application::class, Application::EVENT_BEFORE_REQUEST, function () {
            try {
                $this->handle();
            } catch (\Throwable $e) {
                // Een fout in de taaldetectie mag de site nooit breken
                Craft::error('Taalredirect mislukt: ' . $e->getMessage(), __METHOD__);
            }
        });
    }

    private function handle(): void
    {
        $request = Craft::$app->getRequest();

        if (
            $request->getIsConsoleRequest()
            || $request->getIsCpRequest()
            || $request->getIsActionRequest()
            || !$request->getIsGet()
            || $request->getIsAjax()
            || $request->getIsPreview()
            || $request->getToken() !== null
        ) {
            return;
        }

        // Al eerder geweest (of bewust een taal gekozen): niets doen
        if ($request->getCookies()->has(self::COOKIE)) {
            return;
        }

        $sites = Craft::$app->getSites();
        $currentSite = $sites->getCurrentSite();

        // Onthoud dat deze bezoeker de site heeft gezien, zodat we maar één keer sturen
        Craft::$app->getResponse()->getCookies()->add(new Cookie([
            'name' => self::COOKIE,
            'value' => '1',
            'expire' => time() + 365 * 24 * 60 * 60,
            'httpOnly' => true,
            'secure' => $request->getIsSecureConnection(),
            'sameSite' => Cookie::SAME_SITE_LAX,
        ]));

        if (str_starts_with(strtolower($currentSite->language), self::TARGET_LANGUAGE)) {
            return; // al op de Deense site
        }

        if ($this->preferredLanguage() !== self::TARGET_LANGUAGE) {
            return;
        }

        $targetSite = null;
        foreach ($sites->getAllSites() as $site) {
            if (str_starts_with(strtolower($site->language), self::TARGET_LANGUAGE)) {
                $targetSite = $site;
                break;
            }
        }
        if (!$targetSite || !$targetSite->hasUrls) {
            return;
        }

        // Dezelfde pagina in het Deens, anders de Deense homepage
        $url = null;
        $element = Craft::$app->getUrlManager()->getMatchedElement();
        if ($element) {
            $localized = $element::find()->id($element->id)->siteId($targetSite->id)->one();
            $url = $localized?->getUrl();
        }
        $url ??= $targetSite->getBaseUrl();

        if (!$url) {
            return;
        }

        $response = Craft::$app->getResponse();
        $response->getHeaders()->set('Vary', 'Accept-Language');
        $response->redirect($url, 302);
        Craft::$app->end();
    }

    /**
     * De eerste taal uit de Accept-Language-header waarvoor een site bestaat
     * (bijv. "da" of "nl"), of null als er geen overeenkomst is.
     */
    private function preferredLanguage(): ?string
    {
        $available = array_unique(array_map(
            fn($site) => strtolower(substr($site->language, 0, 2)),
            Craft::$app->getSites()->getAllSites()
        ));

        foreach (Craft::$app->getRequest()->getAcceptableLanguages() as $language) {
            $code = strtolower(substr($language, 0, 2));
            if (in_array($code, $available, true)) {
                return $code;
            }
        }

        return null;
    }
}
