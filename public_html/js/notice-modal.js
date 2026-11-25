/**
 * Melding (modal) die bij het openen van een pagina verschijnt, bijv. op de bestelpagina.
 * <dialog data-notice-modal="naam"> wordt één keer per bezoek (browsersessie) getoond.
 */
(function () {
    document.querySelectorAll('dialog[data-notice-modal]').forEach((dialog) => {
        const key = 'notice-modal:' + dialog.dataset.noticeModal;

        try {
            if (sessionStorage.getItem(key)) return;
        } catch (e) { /* geen opslag beschikbaar: gewoon tonen */ }

        if (typeof dialog.showModal === 'function') {
            dialog.showModal();
        }

        dialog.addEventListener('close', () => {
            try { sessionStorage.setItem(key, '1'); } catch (e) { /* negeren */ }
        });

        // Klik buiten de melding sluit hem ook
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) dialog.close();
        });
    });
})();
