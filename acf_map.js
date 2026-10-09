function initMap() {
    // Controleer of de locaties array aanwezig is
    if (typeof locaties === 'undefined' || !Array.isArray(locaties) || locaties.length === 0) {
        console.warn("Geen ACF locaties gevonden om op de kaart te tonen.");
        return;
    }

    // 1. Maak de kaart aan
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: locaties[0].lat, lng: locaties[0].lng }
    });

    // 2. Maak één centraal InfoWindow (wolkje) aan
    let infoWindow = new google.maps.InfoWindow();

    let bounds = new google.maps.LatLngBounds();

    // 3. Loop door alle ACF locaties
    for (let i = 0; i < locaties.length; i++) {
        let locatie = locaties[i];

        if (!locatie.lat || !locatie.lng) continue;

        let markerPosition = { 
            lat: parseFloat(locatie.lat), 
            lng: parseFloat(locatie.lng) 
        };

        // Plaats de marker
        let marker = new google.maps.Marker({
            position: markerPosition,
            map: map,
            title: locatie.naam || `Locatie ${i + 1}`
        });

        // 4. VOEG 'CLICK' EVENT TOE VOOR HET WOLKJE
        marker.addListener("click", function() {
            // Stel de inhoud van het wolkje in (mag ook HTML bevatten)
            let inhoud = `
                <div style="padding: 5px; color: #333;">
                    <h3 style="margin: 0 0 5px 0; font-size: 16px;">${locatie.naam}</h3>
                    ${locatie.adres ? `<p style="margin: 0; font-size: 13px;">${locatie.adres}</p>` : ''}
                </div>
            `;

            infoWindow.setContent(inhoud);
            infoWindow.open(map, marker);
        });

        bounds.extend(markerPosition);
    }

    if (locaties.length > 1) {
        map.fitBounds(bounds);
    }

    berekenAfstand();
}

function berekenAfstand() {
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

            let afstand = google.maps.geometry.spherical.computeDistanceBetween(
                userLocation,
                targetLocation
            );

            let afstandEl = document.getElementById(`afstandLocatie${i}`);
            if (afstandEl) {
                afstandEl.textContent = `${(afstand / 1000).toFixed(2)} km`;
            }
        }
    });
}

window.initMap = initMap;

if (typeof google !== 'undefined' && google && google.maps) {
    initMap();
}
