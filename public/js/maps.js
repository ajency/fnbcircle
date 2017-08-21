(function() {
  var escapeRegExp, initMap, key, map, marker, populate, replaceAll;

  key = void 0;

  map = void 0;

  marker = void 0;

  window.onload = function() {
    $.ajax({
      type: 'post',
      url: '/get-map-key',
      success: function(data) {
        var newScript, src;
        key = data['key'];
        newScript = document.createElement('script');
        newScript.type = 'text/javascript';
        newScript.src = src = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&callback=init';
        newScript.async = true;
        newScript.defer = true;
        document.getElementsByTagName('head')[0].appendChild(newScript);
      }
    });
  };

  window.init = function() {
    var inp;
    document.getElementById('map').style.height = "300px";
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12
    });
    marker = new google.maps.Marker({
      draggable: true,
      title: 'your business location'
    });
    inp = $("input#mapadd").val();
    populate(inp);
    google.maps.event.addListener(marker, 'dragend', function(ev) {
      var pos;
      pos = marker.getPosition();
      console.log('lat= ' + pos.lat());
      console.log('lng= ' + pos.lng());
      $.ajax({
        type: 'GET',
        url: 'https://maps.googleapis.com/maps/api/geocode/json',
        data: {
          'latlng': pos.lat() + ',' + pos.lng(),
          'key': key
        },
        success: function(data) {
          console.log(data['results'][0]['formatted_address']);
          document.getElementById('mapadd').value = data['results'][0]['formatted_address'];
        }
      });
    });
  };

  escapeRegExp = function(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, '\\$1');
  };

  replaceAll = function(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
  };

  $('body').on('change', 'input#mapadd	', function() {
    populate(this.value);
  });

  populate = function(inp) {
    var search;
    console.log(inp);
    search = replaceAll(inp, ' ', '+');
    console.log('search= ' + search);
    $.ajax({
      type: 'GET',
      url: 'https://maps.googleapis.com/maps/api/geocode/json',
      data: {
        'address': search,
        'key': key
      },
      success: function(data) {
        var loc;
        console.log(data['results'][0]['geometry']['location']);
        loc = data['results'][0]['geometry']['location'];
        initMap(loc['lat'], loc['lng']);
      }
    });
  };

  initMap = function(lat, long) {
    var myLatLng;
    myLatLng = new google.maps.LatLng(lat, long);
    console.log(myLatLng.lat(), myLatLng.lng());
    map.setCenter(myLatLng);
    marker.setPosition(myLatLng);
    marker.setMap(map);
  };

}).call(this);
