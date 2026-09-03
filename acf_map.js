const apiUrl = 'http://frater-demo.local/wp-json/wp/v2/posts/124';

let locaties = [

    {
        lat: 52.51243536614555,
        lng: 6.095706068316046,
        naam: "Cafe de Gezelligheid"
    },

    {
        lat: 52.51114927616413,
        lng: 6.090238982104997,
        naam: "Bierwinkel038"
    },

    {
        lat: 52.44383003806831,
        lng: 6.0736954149365365,
        naam: "Brouwgilde Hulsbergen"
    },

    {
        lat: 52.43686088274463,
        lng: 6.071554896162196,
        naam: "EETIT"
    },

    {
        lat: 52.439082498453025,
        lng: 6.072308582101156,
        naam: "Streekwinkel Vrieze's erfgoed"
    },

    {
        lat: 52.43265032618126,
        lng: 6.071890668287002,
        naam: "Slagerij & Catering De Haan"
    }
];

function initMap() {
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: locaties[0]
    });

    for (let i = 0; i < locaties.length; i++) {
        let marker = new google.maps.Marker({
            position: locaties[i],
            map: map,
            title: locaties[i].naam
        });
    }
    berekenAfstand();
}

function berekenAfstand(){

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            };



            for (let i=0; i < locaties.length; i++) {
                let locatie = locaties[i];
                let afstand = google.maps.geometry.spherical.computeDistanceBetween(
                    new google.maps.LatLng(userLocation.lat, userLocation.lng),
                    new google.maps.LatLng(locatie.lat, locatie.lng)
                );

                console.log(`Afstand tot ${locatie.naam}: ${afstand} meter`);
                
                document.getElementById(`afstandLocatie${i}`).textContent = `${(afstand / 1000).toFixed(2)} km`;

            }
        });     
    }

}

window.initMap = initMap;

if (typeof google !== 'undefined' && google.maps) {
    initMap();
}