/**
 * Bestelformulier: gekozen bieren markeren en controleren dat er minstens één bier gekozen is.
 * De −/+ knoppen zelf zitten in quantity.js.
 */
(function () {
    const form = document.querySelector('[data-order-form]');
    if (!form) return;

    const inputs = Array.from(form.querySelectorAll('[data-quantity-input]'));
    const error = form.querySelector('[data-order-error]');

    // Gekozen bieren visueel markeren + foutmelding verbergen
    function update() {
        inputs.forEach((input) => {
            input.closest('[data-order-beer]').classList.toggle('is-selected', Number(input.value) > 0);
        });
        if (error && inputs.some((input) => Number(input.value) > 0)) {
            error.hidden = true;
        }
    }
    form.addEventListener('change', update);
    form.addEventListener('input', update);
    update();

    form.addEventListener('submit', (event) => {
        if (inputs.length === 0) return;

        const chosen = inputs.filter((input) => Number(input.value) > 0);

        if (chosen.length === 0) {
            event.preventDefault();
            if (error) {
                error.textContent = form.dataset.errorEmpty;
                error.hidden = false;
            }
            inputs[0].focus();
            return;
        }

        // Bieren met aantal 0 niet meesturen
        inputs.filter((input) => Number(input.value) <= 0).forEach((input) => {
            input.disabled = true;
        });
    });

    // Na "terug" in de browser velden weer inschakelen
    window.addEventListener('pageshow', () => inputs.forEach((input) => { input.disabled = false; }));
})();
