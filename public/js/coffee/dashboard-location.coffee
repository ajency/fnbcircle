$('body').on 'change', 'input[type=radio][name=locationType]', ->
  if @value == '0'
    $('.select_city').addClass 'hidden'
    $('#locationForm select').val("")
    $('.select_city select').removeAttr('required')
    $('select[name="status"] option[value="1"]').attr("hidden","hidden")
  else if @value == '1'
    $('.select_city').removeClass 'hidden'
    $('.select_city select').attr('required','required')
    $('select[name="status"] option[value="1"]').removeAttr("hidden")
    # $('.select-branch-cat, .parent_cat_icon').addClass('hidden')
    $('#add_location_modal select').val ''
  $('input[type="text"]').val ''
  $('input[type="number"]').val '1'
  return

$('#add_location_modal').on 'show.bs.modal', (e) ->
  $('input#city[name="locationType"]').prop 'checked', true
  $('.select_city').addClass 'hidden'
  $('.select_city select').removeAttr('required')
  $('#add_location_modal select').val ''
  $('input[type="text"]').val ''
  $('input[type="number"]').val '1'
  $('select[name="status"] option[value="1"]').attr("hidden","hidden")
  return

$('#add_location_modal').on 'click','.save-btn', (e)->
  e.preventDefault()
  instance = $('#locationForm').parsley()
  if !instance.validate()
    return false;
  city_id = $('.select_city select').val()
  area_id = ""
  type = $('input[type=radio][name=locationType]:checked').val()
  name = $('input[name="name"]').val()
  slug = $('input[name="slug"]').val()
  sort_order = $('input[name="order"]').val()
  status = $('select[name="status"]').val()
  console.log type,city_id,name,slug,sort_order,status,area_id
  $.ajax
    type: 'post'
    url: '/save-location'
    data: 
      "type" : type
      "city_id" : city_id
      "name" : name
      "slug" : slug
      "sort_order" : sort_order
      "status" : status
      "area_id" : area_id 
    success: (data) ->
      # console.log "success"
      # console.log data
      if data.hasOwnProperty('city_id')
      	iscity = '-<span class="hidden">no</span>'
      	isarea = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>'
      	city = data['city']['name']
      	area = "1"
      	city_id = data['city_id']
      else
      	iscity = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>'
      	isarea = '-<span class="hidden">no</span>'
      	city = ""
      	area="0"
      	city_id = ""
      	opt = document.createElement('option')
      	opt.value = data['id']
      	opt.innerHTML = data['name']
      	document.getElementById('allcities').appendChild(opt)
      	opt1 = document.createElement('option')
      	opt1.value = data['name']
      	opt1.innerHTML = data['name']
      	document.getElementById('filtercities').appendChild(opt1)
      	$('#filtercities').multiselect('rebuild')
      if(data['status'] == 0) 
      	$status = 'Draft'
      	# console.log "woohoo"
      if(data['status'] == 1) 
      	$status = 'Published'
      if(data['status'] == 2) 
      	$status = 'Archived'
      table = $('#datatable-locations').DataTable()
      node= table.row.add({
        "#" : '<a href="#"><i class="fa fa-pencil"></i></a>',
        "name":data['name']
        "slug":data['slug']
        "isCity":iscity
        "isArea":isarea
        "city" : city
        "sort_order": data['order']
        "publish":data['published_date']
        "update" : data['updated_at']
        "status" : $status
        "id": data['id']
        "area": area
        "city_id": city_id
      }).draw().node()
      $('#add_location_modal').modal('hide')
      $('.alert-success #message').html "Location added successfully."
      $('.alert-success').addClass 'active'
      # $(node).css( 'color', 'red' ).animate( { color: 'black' } )
    error: (request, status, error) ->
      console.log status
      console.log error
      $('.alert-failure').addClass 'active'
      return

editrow = undefined

$('#datatable-locations').on 'click', 'i.fa-pencil', ->
	# console.log 'pitasha'
	table = $('#datatable-locations').DataTable()
	editrow = $(this).closest('td')
	loc = table.row(editrow).data()
	console.log loc
	$('#listing_warning').html ''
	$('#edit_location_modal .save-btn').prop('disabled',false)
	$('#edit_location_modal input[name="type"]').val(loc['area'])
	$('#edit_location_modal input[name="area_id"]').val(loc["id"])
	$('#edit_location_modal select#allcities').val(loc['city_id'])
	if loc['city_id'] == ""
		$('#edit_location_modal .select_city').addClass 'hidden'
		$('#edit_location_modal .select_city select').removeAttr 'required'
		$('#edit_location_modal input[name="area_id"]').val("")
		$('#edit_location_modal select#allcities').val(loc['id'])
	else
		$('#edit_location_modal .select_city select').attr 'required','required'
	$('#edit_location_modal input[name="name"]').val(loc['name'])
	$('#edit_location_modal input[name="slug"]').val(loc['slug'])
	$('#edit_location_modal input[name="order"]').val(loc['sort_order'])
	if loc['status'] == "Draft"
		$('#edit_location_modal select[name="status"]').val("0")
		$('#edit_location_modal select[name="status"] option[value="0"]').removeAttr "hidden"
		$('#edit_location_modal select[name="status"] option[value="1"]').removeAttr "hidden"
		$('#edit_location_modal select[name="status"] option[value="2"]').attr "hidden","hidden"
	if loc['status'] == "Published"
		$('#edit_location_modal select[name="status"]').val("1")
		$('#edit_location_modal select[name="status"] option[value="0"]').attr "hidden","hidden"
		$('#edit_location_modal select[name="status"] option[value="1"]').removeAttr "hidden"
		$('#edit_location_modal select[name="status"] option[value="2"]').removeAttr "hidden"
	if loc['status'] == "Archived"
		$('#edit_location_modal select[name="status"]').val("2")
		$('#edit_location_modal select[name="status"] option[value="0"]').attr "hidden","hidden"
		$('#edit_location_modal select[name="status"] option[value="1"]').removeAttr "hidden"
		$('#edit_location_modal select[name="status"] option[value="2"]').removeAttr "hidden"
	$('#edit_location_modal').modal('show')



$('#edit_location_modal').on 'click','.save-btn', (e)->
  e.preventDefault()
  instance = $('#editlocationForm').parsley()
  if !instance.validate()
    return false;
  city_id = $('#edit_location_modal .select_city select').val()
  area_id = $('#edit_location_modal input[name=area_id]').val()
  type = $('#edit_location_modal input[name=type]').val()
  name = $('#edit_location_modal input[name="name"]').val()
  slug = $('#edit_location_modal input[name="slug"]').val()
  sort_order = $('#edit_location_modal input[name="order"]').val()
  status = $('#edit_location_modal select[name="status"]').val()
  console.log type,city_id,name,slug,sort_order,status,area_id
  $.ajax
    type: 'post'
    url: '/save-location'
    data: 
      "type" : type
      "city_id" : city_id
      "name" : name
      "slug" : slug
      "sort_order" : sort_order
      "status" : status
      "area_id" : area_id 
    success: (data) ->
      # console.log "success"
      # console.log data
      if data.hasOwnProperty('city_id')
      	iscity = '-<span class="hidden">no</span>'
      	isarea = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>'
      	city = data['city']['name']
      	area = "1"
      	city_id = data['city_id']
      else
      	iscity = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>'
      	isarea = '-<span class="hidden">no</span>'
      	city = ""
      	area="0"
      	city_id = ""
      	opt = $('#allcities option[value="'+data['id']+'"]')
      	opt.val(data['id'])
      	opt.html(data['name'])
      	opt1 = $('#filtercities option[value="'+data['id']+'"]')
      	opt1.val(data['id'])
      	opt1.html(data['name'])
      	$('#filtercities').multiselect('rebuild')
      if(data['status'] == 0) 
      	$status = 'Draft'
      	# console.log "woohoo"
      if(data['status'] == 1) 
      	$status = 'Published'
      if(data['status'] == 2) 
      	$status = 'Archived'
      table = $('#datatable-locations').DataTable()
      node= table.row(editrow).data({
        "#" : '<a href="#"><i class="fa fa-pencil"></i></a>',
        "name":data['name']
        "slug":data['slug']
        "isCity":iscity
        "isArea":isarea
        "city" : city
        "sort_order": data['order']
        "publish":data['published_date']
        "update" : data['updated_at']
        "status" : $status
        "id": data['id']
        "area": area
        "city_id": city_id
      }).draw()
      $('#edit_location_modal').modal('hide')
      $('.alert-success #message').html "Location edited successfully."
      $('.alert-success').addClass 'active'
      # $(node).css( 'color', 'red' ).animate( { color: 'black' } )
    error: (request, status, error) ->
      console.log status
      console.log error
      $('.alert-failure').addClass 'active'
      return

$('#edit_location_modal').on 'change','select[name="status"]', (e)->
	$('#edit_location_modal .save-btn').prop('disabled',false)
	console.log $(this).val()  
	city_id = $('#edit_location_modal .select_city select').val()
	area_id = $('#edit_location_modal input[name=area_id]').val()
	type = $('#edit_location_modal input[name=type]').val()
	console.log city_id, area_id, type
	if $(this).val() == "2"
		$.ajax
			type:'post'
			url: '/has_listing'
			data:
				"type" : type
				"city_id" : city_id
				"area_id" : area_id
			success: (data) ->
				console.log data['warning']
				if data['warning']
					$('#listing_warning').html 'this location has listings under it.'
				else
					$('#listing_warning').html ''
				return
	if $(this).val() == "1" and type == "0"
		$('#edit_location_modal .save-btn').prop('disabled',true)
		$.ajax
			type:'post'
			url: '/has_areas'
			data:
				"city_id" : city_id
			success: (data) ->
				console.log data
				if data
					$('#listing_warning').html ''
					$('#edit_location_modal .save-btn').prop('disabled',false)
				else
					$('#listing_warning').html 'There are no published areas'
				return
	return