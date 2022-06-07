<script type="text/javascript"
        src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=o4pib9jalh"></script>

<div id="map" style="width:100%;height:100%;"></div>

<script>
    document.body.style.margin = 0;
    var mapOptions = {
        center: new naver.maps.LatLng(36.7666609, 127.2813937),
        zoom: 18
    };

    var map = new naver.maps.Map('map', mapOptions);

    var marker = new naver.maps.Marker({
        position: new naver.maps.LatLng(36.7666609, 127.2813937),
        animation: naver.maps.Animation.DROP,
        map: map
    });

    naver.maps.Event.addListener(map, 'click', function (e) {
        marker.setPosition(e.latlng);
    });
</script>
