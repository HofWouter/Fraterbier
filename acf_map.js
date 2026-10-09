function initMap() {
    if (typeof locaties === 'undefined' || !Array.isArray(locaties) || locaties.length === 0) {
        console.warn("Geen ACF locaties gevonden om op de kaart te tonen.");
        return;
    }

    // 1. Maak de kaart aan
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: parseFloat(locaties[0].lat), lng: parseFloat(locaties[0].lng) }
    });

    let infoWindow = new google.maps.InfoWindow();
    let bounds = new google.maps.LatLngBounds();

    // 2. Loop door alle ACF locaties en plaats de markers
    for (let i = 0; i < locaties.length; i++) {
        let locatie = locaties[i];

        if (!locatie.lat || !locatie.lng) continue;

        let markerPosition = { 
            lat: parseFloat(locatie.lat), 
            lng: parseFloat(locatie.lng) 
        };

        let marker = new google.maps.Marker({
            position: markerPosition,
            map: map,
            title: locatie.naam || `Locatie ${i + 1}`
        });

        // Bewaar de marker in het locatie-object
        locatie.marker = marker;

        // Koppel 'click' event voor het wolkje
        marker.addListener("click", function() {
            openInfoWindow(locatie, marker, infoWindow, map);
        });

        bounds.extend(markerPosition);
    }

    if (locaties.length > 1) {
        map.fitBounds(bounds);
    }

    // 3. Bereken de afstand
    berekenAfstand(infoWindow, map);
}

// Functie om de inhoud van het wolkje te genereren
function openInfoWindow(locatie, marker, infoWindow, map) {
    let afstandTekst = locatie.afstandKm 
        ? `<p style="margin: 5px 0 0 0; font-weight: bold; color: #2c7a7b;">📍 Afstand: ${locatie.afstandKm} km</p>`
        : `<p style="margin: 5px 0 0 0; color: #888; font-style: italic;">Afstand wordt berekend...</p>`;

    let inhoud = `
        <div style="padding: 5px; color: #333; font-family: sans-serif;">
            <h3 style="margin: 0 0 5px 0; font-size: 15px;">${locatie.naam}</h3>
            ${locatie.adres ? `<p style="margin: 0 0 5px 0; font-size: 13px; color: #666;">${locatie.adres}</p>` : ''}
            ${afstandTekst}
        </div>
    `;

    infoWindow.setContent(inhoud);
    infoWindow.open(map, marker);
}

function berekenAfstand(infoWindow, map) {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(function(position) {
        let userLocation = new google.maps.LatLng(
            position.coords.latitude,
            position.coords.longitude
        );

        for (let i = 0; i < locaties.length; i++) {
            let locatie = locaties[i];
            if (!locatie.lat || !locatie.lng) continue;

            let targetLocation = new google.maps.LatLng(
                parseFloat(locatie.lat),
                parseFloat(locatie.lng)
            );

            // Afstand berekenen in meters en omzetten naar km
            let afstandMeters = google.maps.geometry.spherical.computeDistanceBetween(
                userLocation,
                targetLocation
            );
            let afstandKm = (afstandMeters / 1000).toFixed(2);

            // Sla de afstand op in het locatie-object
            locatie.afstandKm = afstandKm;

            // Vul ook het losse HTML-element in op de pagina (bijv. #afstandLocatie0)
            let afstandEl = document.getElementById(`afstandLocatie${i}`);
            if (afstandEl) {
                afstandEl.textContent = `${afstandKm} km`;
            }
        }
    }, function(error) {
        console.warn("Geolocatie geweigerd of niet beschikbaar:", error.message);
    });
}

window.initMap = initMap;

if (typeof google !== 'undefined' && google && google.maps) {
    initMap();
}
