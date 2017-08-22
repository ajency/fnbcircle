key = undefined
map = undefined
marker = undefined
window.onload = ->
  $.ajax
    type: 'post'
    url: '/get-map-key'
    success: (data) ->
      key = data['key']
      newScript = document.createElement('script')
      newScript.type = 'text/javascript'
      newScript.src = src = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&callback=init'
      newScript.async = true
      newScript.defer = true
      document.getElementsByTagName('head')[0].appendChild newScript
      return
  return
window.init = ->
  document.getElementById('map').style.height="300px"
  map = new (google.maps.Map)(document.getElementById('map'), zoom: 12)
  marker = new (google.maps.Marker)(
    draggable: true
    title: 'your business location')
  inp=$("input#mapadd").val();
  lat=$('input#latitude').val()
  lng=$('input#longitude').val()
  if lat == ''
    populate(inp)
  else
    initMap(lat,lng)
  google.maps.event.addListener marker, 'dragend', (ev) ->
    getAddress()
  return
escapeRegExp = (str) ->
  str.replace /([.*+?^=!:${}()|\[\]\/\\])/g, '\\$1'

getAddress = ()->
  pos = marker.getPosition()
  console.log 'lat= ' + pos.lat()
  $('input#latitude').val(pos.lat())
  console.log 'lng= ' + pos.lng()
  $('input#longitude').val(pos.lng())
  $.ajax
    type: 'GET'
    url: 'https://maps.googleapis.com/maps/api/geocode/json'
    data:
      'latlng': pos.lat() + ',' + pos.lng()
      'key': key
    success: (data) ->
      console.log data['results'][0]['formatted_address']
      document.getElementById('mapadd').value = data['results'][0]['formatted_address']
      return
  return

replaceAll = (str, find, replace) ->
  str.replace new RegExp(escapeRegExp(find), 'g'), replace

$('body').on 'blur','input#mapadd	', ->
  populate(this.value)
  return

populate = (inp)->
  console.log inp
  search = replaceAll(inp, ' ', '+')
  console.log 'search= ' + search
  $.ajax
    type: 'GET'
    url: 'https://maps.googleapis.com/maps/api/geocode/json'
    data:
      'address': search
      'key': key
    success: (data) ->
      console.log data['results'][0]['geometry']['location']
      loc = data['results'][0]['geometry']['location']
      initMap loc['lat'], loc['lng']
      return
  return

initMap = (lat, long) ->
  myLatLng = new (google.maps.LatLng)(lat, long)
  console.log myLatLng.lat(), myLatLng.lng()
  $('input#latitude').val(myLatLng.lat())
  $('input#longitude').val(myLatLng.lng())
  map.setCenter myLatLng
  marker.setPosition myLatLng
  marker.setMap map
  return
