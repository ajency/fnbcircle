city = []

$('body').on 'click', '.city-list a', ->
	getAreas($(this).attr('name'))

$('body').on 'click', 'div.toggle-collapse.desk-hide', ->
	$('.collapse').collapse 'hide'
	getAreas($(this).attr('name'))

getAreas = (cityID) ->
  loader ='<div class="site-loader section-loader half-loader"><div id="floatingBarsG"><div class="blockG" id="rotateG_01"></div><div class="blockG" id="rotateG_02"></div><div class="blockG" id="rotateG_03"></div><div class="blockG" id="rotateG_04"></div><div class="blockG" id="rotateG_05"></div><div class="blockG" id="rotateG_06"></div><div class="blockG" id="rotateG_07"></div><div class="blockG" id="rotateG_08"></div></div></div>'
  if city[cityID] != true
    $('div[name="'+cityID+'"].tab-pane').addClass 'relative'
    $('div[name="'+cityID+'"].tab-pane ul.nodes').html loader
    $.ajax
      type: 'post'
      url: '/get_areas'
      data:
        'city': cityID
      success: (data) ->
        # console.log data
        html=''
        # console.log array
        for key of data
          html+='<li><label class="flex-row"><input type="checkbox" '
          # console.log data[key]['id'], _.indexOf(array,data[key]['id'])
          if _.indexOf(array,data[key]['id']) != -1
            html+='checked'
          html+= ' class="checkbox" for="'+slugify(data[key]['name'])+'" value="'+data[key]['id']+'" name="'+data[key]['name']+'"><p class="lighter nodes__text" id="'+slugify(data[key]['name'])+'">'+data[key]['name']+'</p></label></li>'
        city[cityID] = true
        # console.log html
        $('div[name="'+cityID+'"].tab-pane ul.nodes').html html
        return
      error: (request, status, error) ->
        throwError()
        return
      async: false
  if $('div[name="'+cityID+'"].tab-pane ul.nodes input[type=\'checkbox\']:checked').length == $('div[name="'+cityID+'"].tab-pane ul.nodes input[type=\'checkbox\']').length
    $('div[name="'+cityID+'"].tab-pane input#throughout_city').prop('checked',true);
  else 
    if $('div[name="'+cityID+'"].tab-pane input#throughout_city').prop('checked')
      $('div[name="'+cityID+'"].tab-pane input#throughout_city').prop('checked',false)
  


array = []
        
$('.fnb-modal.area-modal').on 'show.bs.modal', (e) ->
  array=[]
  $('.city-list li').each (index,item)->
    if index == 0
      $('.tab-pane').removeClass('active')
      $(this).addClass('active')
      $('div[name="'+$(this).find('a').attr('name')+'"].tab-pane').addClass('active')
    else
      $(this).removeClass('active')
  cityID =$('.city-list .active a').attr('name');
  $('div#disp-operation-areas').find('input[type=\'hidden\']').each (index,data) ->
    array.push $(this).val()
    return
  getAreas(cityID);
  $('.tab-pane ul.nodes input[type="checkbox"]').each ->
    key = $(this).val()
    if _.indexOf(array,key) != -1
      $(this).prop("checked",true)
    else
      $(this).prop("checked",false)
  return

# window.cities = 'cities':[]
# cities['cities'][1] = {
# 	name: 'Mumbai'
# 	areas: [{name: 'Bandra' , id: '2'},{name: 'Worli' , id: '3'},{name: 'juhu' , id: '4'}]
# }

$('body').on 'change', '.tab-pane.collapse ul.nodes input[type=\'checkbox\']', ->
  if @checked
    if $(this).closest('ul.nodes').find('input[type=\'checkbox\']:checked').length == $(this).closest('ul.nodes').find('input[type=\'checkbox\']').length
      $(this).closest('.tab-pane').find('input#throughout_city').prop('checked',true);
  else
    if $(this).closest('.tab-pane').find('input#throughout_city').prop('checked')
      $(this).closest('.tab-pane').find('input#throughout_city').prop('checked',false);
  return

$('body').on 'click', '.fnb-modal button.operation-save', ->
  $('.tab-pane.collapse ul.nodes input[type=\'checkbox\']').each ->
    parent = undefined
    pid = undefined
    pval = undefined
    parent = $(this).closest('div').find('input[name="city"]')
    pid = parent.attr('id')
    pval = parent.val()
    # console.log(!cities['cities'].hasOwnProperty(pid))
    if !cities['cities'].hasOwnProperty(pid)
      # console.log 'yes'
      cities['cities'][pid] =
        name: pval
        areas: []
    if $(this)[0].checked
      cities['cities'][parent.attr('id')]['areas'][$(this).val()] ={
        'name': $(this).attr('name')
        'id': $(this).val()
      }
    else
      # console.log $(this).val()
      delete cities['cities'][parent.attr('id')]['areas'][$(this).val()]
    return
  populate()
  return

populate = () ->
  k=0
  if cities['cities'].length > 0
    for entry of cities['cities']
    	j=0
    	for i of cities['cities'][entry]['areas']
          j++
    	if j == 0
    		delete cities['cities'][entry]
  source = '{{#cities}}<div class="single-area single-category gray-border m-t-10 m-b-20">
              <div class="row flex-row areaContainer corecat-container">
                <div class="col-sm-3">
                    <strong class="branch">{{name}}</strong>
                </div>
                <div class="col-sm-9">
                    <ul class="fnb-cat small flex-row">
                        {{#areas}}<li><span class="fnb-cat__title"><input type=hidden name="areas" value="{{id}}" data-item-name="{{name}}">{{name}}<span class="fa fa-times remove"></span></span>
                        </li>{{/areas}}
                    </ul>
                </div>
              </div>
              <div class="delete-cat">
                <span class="fa fa-times remove"></span>
              </div>
          </div>{{/cities}}'
  template = Handlebars.compile(source)
  $('div#disp-operation-areas.node-list').html template(cities)
  if document.getElementById('disp-operation-areas').children.length == 0
    $('#area-modal-link').html '+ Add area(s)'
  else
    $('#area-modal-link').html '+ Add / Edit area(s)'
    
$('body').on 'click', '.delete-cat', ->
  $(this).closest('.single-category').remove()
  if document.getElementById('disp-operation-areas').children.length == 0
    $('#area-modal-link').html '+ Add area(s)'

$('body').on 'click', '.fnb-cat .remove', ->
  item = $(this).closest('.fnb-cat__title').parent()
  list= item.parent()
  item.remove()
  if list.children().length == 0
    list.closest('.single-category').remove()
  if document.getElementById('disp-operation-areas').children.length == 0
    $('#area-modal-link').html '+ Add area(s)'

$('body').on 'change','input#closed[type="checkbox"]', ->
  if $(this)[0].checked == true
    # console.log "woerds"
    parent = $(this).closest('.day-hours')
    # console.log parent
    start = parent.find('.open-1 select')
    start.val('closed');
    start.attr('disabled','true');
    end = parent.find('.open-2 select')
    end.val('closed');
    end.attr('disabled','true')
  else
    parent = $(this).closest('.day-hours')
    # console.log parent
    start = parent.find('.open-1 select')
    start.prop('selectedIndex',0)
    start.removeAttr('disabled');
    end = parent.find('.open-2 select')
    end.prop('selectedIndex',0)
    # end.removeAttr('disabled')

$('body').on 'change','.day-hours select', ->
  parent = $(this).closest('.day-hours')
  start = parent.find('.open-1 select')
  end = parent.find('.open-2 select')
  if $(this).prop('selectedIndex') == 0
    start.val('open24');
    start.removeAttr('disabled');
    end.val('open24');
    end.attr('disabled','true')
  else
  	if end.attr('disabled')
      end.prop('selectedIndex',start.prop('selectedIndex')+1)
      end.removeAttr('disabled');
    else
      if start.prop('selectedIndex') >= end.prop('selectedIndex')
      	end.prop('selectedIndex',start.prop('selectedIndex')+1)
  return

$('body').on 'click','a.copy-timing', (e)->
	e.preventDefault()
	start = $('.day-hours .open-1 select.monday').val()
	sprop = $('.day-hours .open-1 select.monday').prop('disabled')
	end = $('.day-hours .open-2 select.monday').val()
	eprop = $('.day-hours .open-2 select.monday').prop('disabled')
	closed = $('.day-hours input[type="checkbox"].monday').prop('checked')
	$('.day-hours .open-1 select').val(start)
	$('.day-hours .open-1 select').prop('disabled',sprop)
	$('.day-hours .open-2 select').val(end)
	$('.day-hours .open-2 select').prop('disabled',eprop)
	$('.day-hours input[type="checkbox"]').prop('checked',closed)
	return




$('.hours-display').change ->
  if $('.dont-display').is(':checked')
    $('.hours-list,.copy-timing').addClass 'disable-hours'
    $('.fnb-select').prop('selectedIndex',0)
  else
    $('.hours-list,.copy-timing').removeClass 'disable-hours'
  return



window.validateLocationHours = () ->
  $('.section-loader').removeClass('hidden');
  areas={}
  $('.areaContainer input[name="areas"][type="hidden"]').each (index,item)->
    area = {}
    area['id']= $(this).val()
    areas[index] = area
  time={}
  $('.day-hours').each (index,item) ->
    day={};
    day['from']= $(this).find('.open-1 select').val()
    day['to']= $(this).find('.open-2 select').val()
    if $(this).find('input#closed').prop('checked')
      day['closed'] = "1"
      day['from'] ="00:00"
      day['to'] ="00:00"
    else
      day['closed'] = "0"
    if day['from'] == "open24"
      day['open24'] = "1"
      day['from'] ="00:00"
      day['to'] ="00:00"
    else
      day['open24'] = "0"
    time[index] = day
    return
  parameters = {}
  parameters['listing_id'] = document.getElementById('listing_id').value
  parameters['step'] = 'business-location-hours'
  parameters['change'] = window.change
  if window.submit ==1
    parameters['submitReview'] = 'yes'
  if window.archive ==1
    parameters['archive'] = 'yes'
  if window.publish ==1
    parameters['publish'] = 'yes'
  parameters['latitude'] = $('input#latitude').val()
  parameters['longitude'] = $('input#longitude').val()
  parameters['map_address'] = $('input#mapadd').val()
  parameters['address'] = $('input.another-address').val()
  parameters['display_hours'] = $('input[type="radio"][name="hours"]:checked').val()
  parameters['operation_time'] = JSON.stringify time
  parameters['operation_areas'] = JSON.stringify areas
  form = $('<form></form>')
  form.attr("method", "post")
  form.attr("action", "/listing")
  $.each parameters, (key, value) ->
    field = $('<input></input>');
    field.attr("type", "hidden");
    field.attr("name", key);
    field.attr("value", value);
    form.append(field);
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
  return

