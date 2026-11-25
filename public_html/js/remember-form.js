/**
 * Onthoudt ingevulde klantgegevens (velden met data-remember) in deze browser, zodat ze
 * bij een volgend bezoek al zijn ingevuld. Gedeeld tussen formulieren: naam en e-mailadres
 * uit het bestelformulier staan dus ook klaar in het contactformulier.
 *
 * De gegevens blijven op het apparaat van de bezoeker (localStorage) en gaan niet naar de server.
 * Met het vinkje [data-remember-toggle] zet de bezoeker het uit; dan worden de gegevens gewist.
 */
(function () {
    const DATA_KEY = 'frater:gegevens';
    const OPT_OUT_KEY = 'frater:niet-onthouden';

    const forms = Array.from(document.querySelectorAll('form')).filter((form) => form.querySelector('[data-remember]'));
    if (forms.length === 0) return;

    const storage = (() => {
        try {
            const test = '__frater__';
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return localStorage;
        } catch (e) {
            return null; // bijv. privévenster met geblokkeerde opslag
        }
    })();

    if (!storage) {
        forms.forEach((form) => form.querySelectorAll('[data-remember-toggle]').forEach((t) => t.closest('label')?.remove()));
        return;
    }

    const read = () => {
        try { return JSON.parse(storage.getItem(DATA_KEY)) || {}; } catch (e) { return {}; }
    };
    const optedOut = () => storage.getItem(OPT_OUT_KEY) === '1';

    function save(form) {
        if (optedOut()) return;
        const data = read();
        form.querySelectorAll('[data-remember]').forEach((field) => {
            const value = field.value.trim();
            if (value) data[field.name] = value;
            else delete data[field.name];
        });
        storage.setItem(DATA_KEY, JSON.stringify(data));
    }

    forms.forEach((form) => {
        const toggle = form.querySelector('[data-remember-toggle]');
        if (toggle) toggle.checked = !optedOut();

        // Invullen wat bekend is (alleen lege velden: na een foutmelding gaan de net ingevulde waarden voor)
        if (!optedOut()) {
            const data = read();
            form.querySelectorAll('[data-remember]').forEach((field) => {
                if (!field.value && data[field.name]) field.value = data[field.name];
            });
        }

        form.addEventListener('input', (event) => {
            if (event.target.matches('[data-remember]')) save(form);
        });
        form.addEventListener('submit', () => save(form));

        if (toggle) {
            toggle.addEventListener('change', () => {
                if (toggle.checked) {
                    storage.removeItem(OPT_OUT_KEY);
                    save(form);
                } else {
                    storage.setItem(OPT_OUT_KEY, '1');
                    storage.removeItem(DATA_KEY);
                }
                // Andere formulieren op de pagina gelijk laten lopen
                document.querySelectorAll('[data-remember-toggle]').forEach((t) => { t.checked = toggle.checked; });
            });
        }
    });
})();
