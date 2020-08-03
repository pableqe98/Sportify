function initMap() {
    var myLatlng = {lat: 37.1881714, lng: -3.6066699};
    
    var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 10, center: myLatlng});

    var vMarker = new google.maps.Marker({
        position: new google.maps.LatLng(myLatlng),
        draggable: true
    });

    google.maps.event.addListener(map, 'click', function(evt) {
        $("#lat").val(evt.latLng.lat().toFixed(6));
        $("#lng").val(evt.latLng.lng().toFixed(6));

        map.panTo(evt.latLng);
        vMarker.setPosition(evt.latLng);
      });

    // adds a listener to the marker
            // gets the coords when drag event ends
            // then updates the input with the new coords
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#lat").val(evt.latLng.lat().toFixed(6));
                $("#lng").val(evt.latLng.lng().toFixed(6));

                map.panTo(evt.latLng);
            });

        // centers the map on markers coords
        map.setCenter(vMarker.position);

        // adds the marker on the map
        vMarker.setMap(map);
}