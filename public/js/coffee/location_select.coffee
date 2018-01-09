city = []
window.cities = 'cities': []
$('body').on 'click', '.city-list a', ->
	getAreas($(this).attr('name'))

$('body').on 'click', 'div.toggle-collapse.desk-hide', ->
	$('.collapse').collapse 'hide'
	getAreas($(this).attr('name'))

getAreas = (cityID) ->
  loader ='<div class="site-loader section-loader half-loader"><div id="floatingBarsG"><div class="blockG" id="rotateG_01"></div><div class="blockG" id="rotateG_02"></div><div class="blockG" id="rotateG_03"></div><div class="blockG" id="rotateG_04"></div><div class="blockG" id="rotateG_05"></div><div class="blockG" id="rotateG_06"></div><div class="blockG" id="rotateG_07"></div><div class="blockG" id="rotateG_08"></div></div></div>'
  if city[cityID] == true
  # if (_.indexOf(city,cityID) != -1)
    return
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
    $('div[name="'+cityID+'"].tab-pane ul.nodes').removeClass('disable-section') 
    if $('div[name="'+cityID+'"].tab-pane input#throughout_city').prop('checked')
      $('div[name="'+cityID+'"].tab-pane input#throughout_city').prop('checked',false)
      

  


array = []
        
$('body').on 'show.bs.modal', '#area-select', (e) ->
  setTimeout (->
    $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",true
    return
  ), 500
  array=[]
  $('.city-list li').each (index,item)->
    # $(this).find('input.city-checkbox').prop('checked',false);
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


$('body').on 'show.bs.modal','#category-select', (e) ->
  setTimeout (->
    $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",true
    return
  ), 500



$('body').on 'change', '.tab-pane.collapse ul.nodes input[type=\'checkbox\']', ->
  if @checked
    if $(this).closest('ul.nodes').find('input[type=\'checkbox\']:checked').length == $(this).closest('ul.nodes').find('input[type=\'checkbox\']').length
      $(this).closest('.tab-pane').find('input#throughout_city').prop('checked',true);
  else
    if $(this).closest('.tab-pane').find('input#throughout_city').prop('checked')
      $(this).closest('.tab-pane').find('input#throughout_city').prop('checked',false);
    cityID =  $(this).closest('div').find('input[name="city"]').attr('data-city-id');
    if cities['cities'][cityID] and cities['cities'][cityID]['areas'][$(this).val()]
      delete cities['cities'][cityID]['areas'][$(this).val()]
  return

$('body').on 'click', '.fnb-modal button.operation-save', ->
  $('.tab-pane.collapse ul.nodes input[type=\'checkbox\']:checked').each ->
    parent = undefined
    pid = undefined
    pval = undefined
    parent = $(this).closest('div').find('input[name="city"]')
    pid = parent.attr('data-city-id')
    pval = parent.val()
    # console.log(!cities['cities'].hasOwnProperty(pid))
    if !cities['cities'].hasOwnProperty(pid)
      # console.log 'yes'
      cities['cities'][pid] =
        name: pval
        id: pid
        areas: []
    if $(this)[0].checked
      cities['cities'][pid]['areas'][$(this).val()] ={
        'name': $(this).attr('name')
        'id': $(this).val()
      }
    else
      # console.log $(this).val()
      delete cities['cities'][pid]['areas'][$(this).val()]
    return
  $('.city-list li .city-checkbox:checked').each ->
    pid = $(this).siblings('a').attr('name')
    cities['cities'][pid]['areas'].length = 0
  populate()
  return

populate = () ->
  k=0
  source = '{{#cities}}<div class="single-area single-category gray-border m-t-10 m-b-20" data-city-id="{{id}}">
              <div class="row flex-row areaContainer corecat-container">
                <div class="col-sm-3">
                    <strong class="branch text-secondary">{{name}}</strong>
                </div>
                <div class="col-sm-9">
                    <ul class="fnb-cat small flex-row">
                        {{#areas}}<li><span class="fnb-cat__title"><input type="hidden" name="areas" value="{{id}}" data-item-name="{{name}}">{{name}}<span class="fa fa-times remove"></span></span>
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
    
$('body').on 'click', '#disp-operation-areas .delete-cat', ->
  pid = parseInt($(this).closest('.single-category').attr('data-city-id'))
  console.log pid
  delete(cities['cities'][pid])
  $(this).closest('.single-category').remove()
  $('.city-list input#checkbox-'+pid).prop('checked', false).change()
  # if document.getElementById('disp-operation-areas').children.length == 0
  #   $('#area-modal-link').html '+ Add area(s)'

$('body').on 'click', '#disp-operation-areas .fnb-cat .remove', ->
  item = $(this).closest('.fnb-cat__title').parent()
  list= item.parent()
  $deletedAreaCity = list.closest('.single-area').attr('data-city-id')
  $('#area-select input#checkbox-'+$deletedAreaCity).prop('checked',false)
  cid = parseInt($(this).closest('.single-category').attr('data-city-id'))
  aid = parseInt(item.find('input[type="hidden"]').val())
  console.log cid,aid
  delete(cities['cities'][cid]['areas'][aid])
  item.remove()
  if list.children().length == 0
    console.log cid
    selectState($('.city-list input[type="checkbox"]#checkbox-'+cid).prop('checked', true)[0])

  #   pid = parseInt(list.closest('.single-category').attr('data-city-id'))
  #   delete(cities['cities'][pid])
  #   list.closest('.single-category').remove()
  #   $('.city-list a#checkbox-'+pid).prop('checked', false).change()
  # if document.getElementById('disp-operation-areas').children.length == 0
  #   $('#area-modal-link').html '+ Add area(s)'


selectState = (element)->
  console.log element
  city_link = $(element).parent().find('a')
  city_link.click()
  if element.checked
    $('.tab-pane.active .nodes').addClass 'disable-section'
    setTimeout (->
      $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",true
      return
    ), 100
    cityID = city_link.attr 'name'
    # $('div[name="'+cityID+'"].tab-pane input[type="checkbox"]').prop "checked",false
    #//////////////////////////////////////////////Disable the div
    cityValue = $('div[name="'+cityID+'"].tab-pane input[type="hidden"][name="city"]').val()
    console.log cityID, cityValue
    cities['cities'][cityID] =
        name: cityValue
        id: cityID
        areas: []
  else
    $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",false
    $('.tab-pane.active .nodes').removeClass 'disable-section'
    console.log 'unchecked'
    cityID = city_link.attr 'name'
    #//////////////////////////////////////Enable the div
    delete(cities['cities'][cityID])
  return

$('body').on 'change', '.city-list input[type="checkbox"]', ->
  selectState(this)


$('body').on 'change', '.mobile-child-selection', ->
  city_link = $(this).siblings('.toggle-collapse')
  city_link.click()
  if @checked
    setTimeout (->
      $('.tab-pane.in .nodes').addClass 'disable-section'
      $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",true
      return
    ), 500
  else
    $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",false
    $('.tab-pane.in .nodes').removeClass 'disable-section'
  return





# $('body').on 'change', '.categ-list input[type="checkbox"]', ->
#   city_link = $(this).parent().find('a')
#   city_link.click()
#   if @checked
#     $('.tab-pane.active .nodes').addClass 'disable-section'
#     setTimeout (->
#       $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",true
#       return
#     ), 100
#   else
#     console.log 'test'
#     $('.tab-pane .disable-section input[type="checkbox"]').prop "checked",false
#     $('.tab-pane.active .nodes').removeClass 'disable-section'
#   return




