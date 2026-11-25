# Frater Bier

Dit is de repository voor Frater. Deze website is bedoeld om klanten te informeren over nieuwe bieren en waar deze te koop zijn. Daarnaast is het voor zakelijke klanten mogelijk om bestellingen te plaatsen.

---

De reden van dit project is dat ik graag mijn vaardigheden wil toepassen voor een commerciële opdracht. De website is beschikbaar in het Nederlands en Deens.

Oorspronkelijk was dit een WordPress-thema; het project is omgebouwd naar **Craft CMS 5**.

---

## Pagina's

* Home (`/`, `/dk/`)
* Ons verhaal (`/ons-verhaal`, `/dk/vores-historie`)
* Waar te koop? (kaart met verkooppunten onderaan de homepage, `#google-maps-kaart`)
* Contact (`/contact`, `/dk/kontakt`)
* Bestellen (`/bestellen`, `/dk/bestil`)

## Vereisten

* PHP 8.2+, MySQL 8 (of MariaDB 10.5+), Composer
* Node.js 20+ (alleen om de CSS te bouwen)
* Of: [DDEV](https://ddev.com) (aanbevolen voor lokaal ontwikkelen, configuratie zit in `.ddev/`)

## Lokaal installeren (DDEV)

```bash
ddev start
ddev composer install
cp .env.example .env
```

Vul in `.env` de database-gegevens van DDEV in (`CRAFT_DB_SERVER=db`, database/gebruiker/wachtwoord `db`) en zet `PRIMARY_SITE_URL=https://frater.ddev.site`. Daarna:

```bash
ddev craft setup/keys
ddev craft install
```

Craft ziet de map `config/project/` en maakt automatisch alle talen, secties, velden en plugins aan. Het control panel staat op `https://frater.ddev.site/admin`.

## Structuur

| Map | Inhoud |
| --- | --- |
| `templates/` | Twig-templates (`_layouts`, `_partials`, `_blocks`, `_singles`, `_pages`) |
| `translations/da` | Vaste Deense teksten (vervangt Polylang-strings) |
| `config/project/` | Contentstructuur (secties, velden, sites), beheerd door Craft |
| `modules/orders/` | Eigen module: slaat bestellingen op in de sectie Bestellingen |
| `src/css/app.css` | Tailwind-bron (huisstijl, basisstijlen, componenten); wordt gebouwd naar `public_html/css/style.css` |
| `public_html/` | Document root: `css/`, `js/`, `fonts/`, `assets/`, `uploads/` (geüploade afbeeldingen) |

## CSS (Tailwind)

De opmaak is geschreven met [Tailwind CSS v4](https://tailwindcss.com): utility-klassen staan direct in de Twig-templates.
`src/css/app.css` bevat de huisstijl als tokens (kleuren zoals `bg-navy`, `text-cream`, `bg-plum`, `bg-sky`, `bg-butter`;
fonts `font-display`, `font-body`, `font-body-bold`; breakpoints `sm` 480px, `md` 768px, `lg` 992px, `xl` 1200px),
basisstijlen voor koppen en tekst, en een paar componenten (`.section`, `.btn`, `.btn-primary`, `.input`, `.link`).
Statusklassen die de scripts zetten zijn bruikbaar als variant: `is-active:`, `is-open:`, `is-visible:`, `is-selected:`.

```bash
npm install      # eenmalig
npm run dev      # tijdens het ontwikkelen: bouwt opnieuw bij elke wijziging
npm run build    # geminimaliseerde public_html/css/style.css
```

Na het aanpassen van templates altijd `npm run build` draaien (de deploy-workflow doet dit ook automatisch).

## Content in het control panel

| WordPress | Craft |
| --- | --- |
| Pagina "Home" + ACF-velden | Single **Home** (hero, over ons, titel bierensectie) |
| Pagina "Ons verhaal" | Single **Ons verhaal** |
| Pagina "Contact" | Single **Contact** |
| Pagina "Bestelformulier" | Single **Bestellen** |
| Overige pagina's (`index.php`) | Structuur **Pagina's** (bijv. slug `disclaimer` of `auteursrechten` wordt automatisch gelinkt in de footer) |
| ACF-groepen `bier1`, `bier2`… | Structuur **Bieren**: onbeperkt aantal, volgorde via slepen |
| WP Google Maps-plugin | Kanaal **Verkooppunten** met een kaartveld van de plugin [Maps](https://plugins.craftcms.com/simplemap) (Lite, gratis): adres opzoeken of pin verslepen |
| ACF `fotoblok`, `fotoblok_2`, adres | Global set **Algemeen** |
| Polylang | Sites **Nederlands** (`nl`), **Dansk** (`dk`), wisselen via de taalkiezer bovenin het CP |
| Contact Form 7 | Plugin [Contact Form](https://github.com/craftcms/contact-form), ontvanger via `CONTACT_FORM_TO_EMAIL` |

## Bestellingen

Elke bestelaanvraag via de bestelpagina wordt gemaild (Contact Form-plugin, naar `CONTACT_FORM_TO_EMAIL`)
én bewaard als entry in de sectie **Bestellingen** in het control panel (status, bieren met aantallen, klantgegevens).
Dat doet de module `modules/orders` (geregistreerd in `config/app.php`); het bestelformulier herkent hij aan het verborgen veld `orderForm`.
De status (Nieuw / In behandeling / Afgerond / Geannuleerd) pas je zelf aan in het CP. Bestellingen zijn niet zichtbaar op de website.

## Kaart

De kaart onder **Waar te koop?** gebruikt [Leaflet](https://leafletjs.com) met OpenStreetMap-kaarttegels en de adreszoeker Nominatim. Daarvoor is geen API-key nodig. De instellingen staan in `config/simplemap.php`.

## Omgevingsvariabelen

Zie `.env.example`. Belangrijk:

* `CONTACT_FORM_TO_EMAIL` / `CRAFT_EMAIL_FROM`: e-mailadressen voor de formulieren.

## Live zetten

1. Zet de document root van het domein op de map `public_html/`.
2. Upload het project (de workflow in `.github/workflows/deploy.yml` kan dit handmatig doen).
3. Maak op de server een `.env` aan met `CRAFT_ENVIRONMENT=production`, `CRAFT_DEV_MODE=false` en `CRAFT_ALLOW_ADMIN_CHANGES=false`.
4. Draai `php craft up` na elke deploy.

Wijzigingen aan de contentstructuur (velden, secties) maak je lokaal in het CP; Craft schrijft ze naar `config/project/` en `php craft up` past ze op de server toe.

## Auteur

**Ontwerp en ontwikkeling** Wouter Hof (wouterhof.com) Deltion College / studentnummer: 97133362)

## Randvoorwaarden

Bij de ontwikkeling van de website wordt rekening gehouden met de AVG-wetgeving.

* **Gegevensverwerking:** Formuliergegevens (zoals bestellingen of contactaanvragen) worden alleen gebruikt voor het afhandelen van de betreffende transactie of vraag. Formulieren worden alleen per e-mail verstuurd en niet in de database opgeslagen.
* **Geen Onnodige Opslag:** Er worden geen privacygevoelige gegevens opgeslagen in lokale sessies of ongebeveiligde bestanden.
* **Cookies:** De website gebruikt alleen functionele cookies (sessie en CSRF-beveiliging van Craft). Er worden geen tracking- of marketingcookies geplaatst zonder expliciete toestemming van de bezoeker.

## Licentie

* **Licentie** Dit project is gelicenseerd onder de MIT-licentie.
* **Hergebruik:** Het is niet toegestaan om afbeeldingen, teksten of visueel materiaal van deze website te kopiëren, te verspreiden of te gebruiken voor commerciële doeleinden zonder voorafgaande schriftelijke toestemming.
