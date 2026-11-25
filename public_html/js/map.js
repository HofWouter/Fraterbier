/**
 * Kaart met verkooppunten ("Waar te koop?").
 * Gegevens komen uit window.locaties (gezet in templates/_blocks/stores-map.twig).
 * Gebruikt Leaflet met OpenStreetMap-kaarttegels: geen API-key nodig.
 */
(function () {
    const mapElement = document.getElementById('map');
    const locaties = Array.isArray(window.locaties) ? window.locaties : [];

    if (!mapElement || typeof L === 'undefined' || locaties.length === 0) {
        return;
    }

    const labels = Object.assign({
        afstand: 'Afstand',
        route: 'Route plannen',
        geenLocatie: 'Je locatie kon niet worden bepaald.'
    }, window.mapLabels || {});

    function escapeHtml(tekst) {
        return String(tekst ?? '').replace(/[&<>"']/g, (teken) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        })[teken]);
    }

    // 1. Kaart aanmaken (scrollen met het muiswiel pas na een klik, zodat de pagina niet "vastloopt")
    const map = L.map(mapElement, { scrollWheelZoom: false });
    map.on('click', () => map.scrollWheelZoom.enable());
    map.on('mouseout', () => map.scrollWheelZoom.disable());

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    // 2. Markers plaatsen
    function popupInhoud(locatie) {
        const route = `https://www.google.com/maps/dir/?api=1&destination=${locatie.lat},${locatie.lng}`;
        return `
            <strong>${escapeHtml(locatie.naam)}</strong>
            ${locatie.adres ? `<br>${escapeHtml(locatie.adres)}` : ''}
            ${locatie.afstandKm ? `<br>📍 ${escapeHtml(labels.afstand)}: ${locatie.afstandKm} km` : ''}
            <br><a href="${route}" target="_blank" rel="noopener">${escapeHtml(labels.route)}</a>
        `;
    }

    const bounds = [];
    locaties.forEach((locatie) => {
        const positie = [Number(locatie.lat), Number(locatie.lng)];
        locatie.marker = L.marker(positie, { title: locatie.naam })
            .addTo(map)
            .bindPopup(() => popupInhoud(locatie));
        bounds.push(positie);
    });

    if (bounds.length === 1) {
        map.setView(bounds[0], 13);
    } else {
        map.fitBounds(bounds, { padding: [40, 40] });
    }

    // 3. Klik in de lijst = marker op de kaart openen
    document.querySelectorAll('[data-store]').forEach((knop) => {
        knop.addEventListener('click', () => {
            const locatie = locaties[Number(knop.dataset.store)];
            if (!locatie) return;
            map.setView(locatie.marker.getLatLng(), Math.max(map.getZoom(), 13));
            locatie.marker.openPopup();
        });
    });

    // 4. Afstand berekenen: alleen na een klik, zodat de bezoeker niet ongevraagd om zijn locatie wordt gevraagd
    const afstandKnop = document.getElementById('map-distance-btn');
    if (afstandKnop && navigator.geolocation) {
        afstandKnop.hidden = false;
        afstandKnop.addEventListener('click', () => {
            navigator.geolocation.getCurrentPosition((positie) => {
                const gebruiker = L.latLng(positie.coords.latitude, positie.coords.longitude);

                locaties.forEach((locatie, index) => {
                    locatie.afstandKm = (gebruiker.distanceTo(locatie.marker.getLatLng()) / 1000).toFixed(1);
                    const afstandEl = document.getElementById(`afstandLocatie${index}`);
                    if (afstandEl) {
                        afstandEl.textContent = `${locatie.afstandKm} km`;
                    }
                });

                afstandKnop.hidden = true;
            }, () => {
                afstandKnop.textContent = labels.geenLocatie;
                afstandKnop.disabled = true;
            });
        });
    }
})();
