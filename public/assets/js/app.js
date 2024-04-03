var marker;

function initMap() {
  var cityLatitude = cityData.latitude;
  var cityLongitude = cityData.longitude;

  var map = createMap();
  var panorama = createPanorama(cityLatitude, cityLongitude);

  map.addListener("click", function (event) {
    var guessedLatitude = event.latLng.lat();
    var guessedLongitude = event.latLng.lng();

    document.getElementById("guessLatitude").value = guessedLatitude;
    document.getElementById("guessLongitude").value = guessedLongitude;

    // Supprimer le marqueur précédent s'il existe
    if (marker) {
      marker.setMap(null);
    }

    // Ajouter un nouveau marqueur à l'emplacement cliqué
    marker = new google.maps.Marker({
      position: event.latLng,
      map: map,
    });
  });
}

function createMap() {
  return new google.maps.Map(document.querySelector(".map"), {
    center: { lat: 27.26811, lng: 130.01776 },
    zoom: 2,
    styles: [
      {
        featureType: "road",
        elementType: "labels",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "poi",
        elementType: "labels",
        stylers: [{ visibility: "off" }],
      },
    ],
  });
}

function createPanorama(latitude, longitude) {
  return new google.maps.StreetViewPanorama(document.querySelector(".panorama"), {
    position: { lat: latitude, lng: longitude },
    pov: { heading: 34, pitch: 10 },
    address: false,
    control: false,
    fullscreenControl: true,
    motionTracking: false,
    motionTrackingControl: false,
    showRoadLabels: false,
    panControl: false,
    zoomControl: true,
  });
}
