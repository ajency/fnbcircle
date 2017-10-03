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
    var inp, is_draggable, lat, lng, mapTextMsg;
    mapTextMsg = 'your business location';
    if ($("#map").attr('map-title') !== "") {
      mapTextMsg = $("#map").attr('map-title');
    }
    document.getElementById('map').style.height = "300px";
    if ($(".mapAddress").length) {
      is_draggable = false;
    } else {
      is_draggable = true;
    }
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12
    });
    marker = new google.maps.Marker({
      draggable: is_draggable
    }, {
      title: mapTextMsg
    });
    inp = $("input#mapadd").val();
    lat = $('input#latitude').val();
    lng = $('input#longitude').val();
    if (lat === '') {
      populate(inp);
    } else {
      initMap(lat, lng);
    }
    console.log($("#map").attr('show-address'));
    if ($("#map").attr('show-address') !== "") {
      getAddress();
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
    $('input#latitude').val(pos.lat());
    $('input#longitude').val(pos.lng());
    $.ajax({
      type: 'GET',
      url: 'https://maps.googleapis.com/maps/api/geocode/json',
      data: {
        'latlng': pos.lat() + ',' + pos.lng(),
        'key': key
      },
      success: function(data) {
        document.getElementById('mapadd').value = data['results'][0]['formatted_address'];
        if ($(".mapAddress").length) {
          $(".mapAddress").html(data['results'][0]['formatted_address']);
        }
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

  $('input[name="interview_location"]').on('keyup', function() {
    updateAddr();
    return populate(this.value);
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
    search = replaceAll(inp, ' ', '+');
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
    $('input#latitude').val(myLatLng.lat());
    $('input#longitude').val(myLatLng.lng());
    map.setCenter(myLatLng);
    marker.setPosition(myLatLng);
    marker.setMap(map);
  };

}).call(this);
