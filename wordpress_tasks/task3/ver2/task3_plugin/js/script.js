function buildMap() {
    var geocoder;
    var map;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(50, 30);
    var mapOptions = {
        zoom: 15,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    var address = my_script_vars.shop_address;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status == 'OK') {
            map.setCenter(results[0].geometry.location);
            var content = my_script_vars.shop_name + ", " + my_script_vars.shop_address;
            var infoWindow = new google.maps.InfoWindow({
                content: content,
            });
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
            marker.addListener('click', function () {
                infoWindow.open({
                    anchor: marker,
                    map,
                });
            });
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}



