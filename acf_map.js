function initMap() {
    // Controleer of de locaties array vanuit PHP aanwezig en gevuld is
    if (typeof locaties === 'undefined' || !Array.isArray(locaties) || locaties.length === 0) {
        console.warn("Geen ACF locaties gevonden om op de kaart te tonen.");
        return;
    }

    // 1. Maak de kaart aan (gecentreerd op de eerste beschikbare locatie)
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: locaties[0].lat, lng: locaties[0].lng }
    });

    // 2. Maak een bounds-object aan zodat alle markers automatisch netjes in beeld passen
    let bounds = new google.maps.LatLngBounds();

    // 3. Loop door alle ACF locaties en plaats de markers
    for (let i = 0; i < locaties.length; i++) {
        let locatie = locaties[i];

        // Sla ongeldige coördinaten over
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

        // Breid de grenzen van de kaart uit met deze marker
        bounds.extend(markerPosition);
    }

    // Pas het zoomniveau/centrum van de kaart automatisch aan op basis van alle markers
    if (locaties.length > 1) {
        map.fitBounds(bounds);
    }

    // 4. Bereken de afstanden als de gebruiker zijn locatie deelt
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

            // Afstand berekenen in meters
            let afstand = google.maps.geometry.spherical.computeDistanceBetween(
                userLocation,
                targetLocation
            );

            // Vul de HTML-elementen in (bijv. #afstandLocatie0, #afstandLocatie1, etc.)
            let afstandEl = document.getElementById(`afstandLocatie${i}`);
            if (afstandEl) {
                afstandEl.textContent = `${(afstand / 1000).toFixed(2)} km`;
            }
        }
    }, function(error) {
        console.log("Geolocatie kon niet worden opgehaald:", error.message);
    });
}

// Zorg dat Google Maps de functie kan aanroepen bij de async callback
window.initMap = initMap;

// Mocht het script pas laden nadat Google Maps al aanwezig is
if (typeof google !== 'undefined' && google && google.maps) {
    initMap();
}
