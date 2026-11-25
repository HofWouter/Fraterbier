/**
 * Aantal-kiezers (templates/_partials/forms/quantity.twig): − en + knoppen,
 * en het aantal binnen min/max houden. Stuurt een "change"-event zodat andere scripts kunnen reageren.
 */
(function () {
    function clamp(input) {
        const min = Number(input.min) || 0;
        const max = Number(input.max) || 999;
        const value = Math.round(Number(input.value)) || 0;
        input.value = Math.min(max, Math.max(min, value));
    }

    document.querySelectorAll('[data-quantity]').forEach((wrapper) => {
        const input = wrapper.querySelector('[data-quantity-input]');
        if (!input) return;

        wrapper.querySelectorAll('[data-step]').forEach((button) => {
            button.addEventListener('click', () => {
                input.value = (Number(input.value) || 0) + Number(button.dataset.step);
                clamp(input);
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
        input.addEventListener('change', () => clamp(input));
        if (input.form) input.form.addEventListener('submit', () => clamp(input));
    });
})();
