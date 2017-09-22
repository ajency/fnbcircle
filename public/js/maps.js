(function() {
  var escapeRegExp, getAddress, initMap, key, map, marker, populate, replaceAll, updateAddr;

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
    var inp, lat, lng;
    document.getElementById('map').style.height = "300px";
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12
    });
    marker = new google.maps.Marker({
      draggable: true,
      title: 'your business location'
    });
    inp = $("input#mapadd").val();
    lat = $('input#latitude').val();
    lng = $('input#longitude').val();
    if (lat === '') {
      populate(inp);
    } else {
      initMap(lat, lng);
    }
    google.maps.event.addListener(marker, 'dragend', function(ev) {
      return getAddress();
    });
  };

  escapeRegExp = function(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, '\\$1');
  };

  getAddress = function() {
    var pos;
    pos = marker.getPosition();
    console.log('lat= ' + pos.lat());
    $('input#latitude').val(pos.lat());
    console.log('lng= ' + pos.lng());
    $('input#longitude').val(pos.lng());
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
        updateAddr();
      }
    });
  };

  updateAddr = function() {
    var mapaddr;
    mapaddr = $('#mapadd').val();
    if ($('.save-addr').prop('checked')) {
      $('.another-address').val(mapaddr);
    }
  };

  $('.save-addr').on('change', function() {
    updateAddr();
    if ($('.save-addr').prop('checked')) {
      return $('.another-address').prop('disabled', true);
    } else {
      return $('.another-address').prop('disabled', false);
    }
  });

  replaceAll = function(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
  };

  $('body').on('blur', 'input#mapadd	', function() {
    updateAddr();
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
    $('input#latitude').val(myLatLng.lat());
    $('input#longitude').val(myLatLng.lng());
    map.setCenter(myLatLng);
    marker.setPosition(myLatLng);
    marker.setMap(map);
  };

}).call(this);
