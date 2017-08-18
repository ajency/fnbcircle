# Get Started form next/prev
$('body').on 'click', '.gs-next', ->
	$('.gs-steps > .active').next('li').find('a').trigger 'click'

$('body').on 'click', '.gs-prev', ->
	$('.gs-steps > .active').prev('li').find('a').trigger 'click'

# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'

# Add/Edit categories
$('body').on 'click', 'input:radio[name=\'categories\']', ->
  $('div.full-modal').removeClass 'hidden'
  # console.log categories['categories']
  cat_name = $(this).data('name')
  $('.main-cat-name').html(cat_name)
  # Update icon
  cat_icon = $(this).closest('li').find('.cat-icon').clone().addClass 'm-r-15'
  $('.sub-category .cat-name').find('.cat-icon').remove()
  $('.sub-category .cat-name').prepend(cat_icon)
  $('.categ-list').html ''
  $('.mobile-categories').html ''
  id = $(this).val()
  obj={}
  obj[0] = {"id":id}
  $.ajax
    type: 'post'
    url: '/get_categories'
    data: {
      'parent' : JSON.stringify(obj)
    }
    success: (data) ->
      # console.log data
      html = ''
      html_mob = ''
      i = 0
      data[id]['children'] = _.sortBy(_.sortBy(data[id]['children'],'name'),'order');
      for key of data[id]['children']
        # console.log data[id]['children'][key]['name']
        html_mob += '<div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#' + slugify(data[id]['children'][key]['name']) + '"  name="' + data[id]['children'][key]['id'] + '" aria-expanded="false" aria-controls="' + slugify(data[id]['children'][key]['name']) + '">' + data[id]['children'][key]['name'] + ' <i class="fa fa-angle-down" aria-hidden="true"></i></div><div role="tabpanel" class="tab-pane collapse';
        if i == 0
          html_mob += ' active'
        html_mob += '" id="' + slugify(data[id]['children'][key]['name']) + '" name="' + data[id]['children'][key]['id'] + '"><ul class="nodes"><li>' + data[id]['children'][key]['name'] + '</li></ul></div>'
        html += '<li role="presentation"'
        if i == 0
          html += ' class="active"'
        html += '><a href="#' + slugify(data[id]['children'][key]['name']) + '"  name="' + data[id]['children'][key]['id'] + '" aria-controls="' + slugify(data[id]['children'][key]['name']) + '" role="tab" data-toggle="tab">' + data[id]['children'][key]['name'] + '</a></li>'
        i++
      $('.categ-list').html html
      $('.mobile-categories').html html_mob
      categ.length = 0
      for key of data[id]['children']
        getNodes(data[id]['children'][key]['id'])
        break
      $('div.full-modal').addClass 'hidden'
      return
    async: true
  return

categ = []

getNodes = (branchID) ->
  obj = {}
  obj[0] = 'id': branchID
  loader ='<div class="site-loader section-loader half-loader"><div id="floatingBarsG"><div class="blockG" id="rotateG_01"></div><div class="blockG" id="rotateG_02"></div><div class="blockG" id="rotateG_03"></div><div class="blockG" id="rotateG_04"></div><div class="blockG" id="rotateG_05"></div><div class="blockG" id="rotateG_06"></div><div class="blockG" id="rotateG_07"></div><div class="blockG" id="rotateG_08"></div></div></div>'
  # console.log categ
  if categ[branchID] != true
    $('div[name="'+branchID+'"].tab-pane').addClass 'relative'
    $('div[name="'+branchID+'"].tab-pane ul.nodes').html loader
    $.ajax
      type : 'post'
      url: '/get_categories'
      data:
        'parent' : JSON.stringify(obj)
      success: (data) ->
        array = []
        $('ul#view-categ-node').find('input[type=\'hidden\']').each (index,data) ->
          array.push $(this).val()
        # console.log array
        # console.log categories
        for branch of categories['categories']
          for node of categories['categories'][branch]['nodes']
            if _.indexOf(array, categories['categories'][branch]['nodes'][node]['id']) == -1
              delete categories['categories'][branch]['nodes'][node]
              # console.log categories['categories'][branch]['nodes'][node]['id']
          j=0
          for i of categories['categories'][branch]['nodes']
            j++
          if j == 0
            delete categories['categories'][branch]
        html = '<input type="hidden" name="parent" value="'+data[branchID]['parent']+'">'
        html += '<input type="hidden" name="image" value="'+data[branchID]['image']+'">'
        html += '<input type="hidden" name="branch" value="'+data[branchID]['name']+'" id="'+branchID+'">'
        for key of data[branchID]['children']
          html += '<li><label class="flex-row"><input type="checkbox" class="checkbox" '
          if _.indexOf(array,key) != -1
            html+='checked'
          html +=' for="'+slugify(data[branchID]['children'][key]['name'])+'" value="'+key+'" name="'+data[branchID]['children'][key]['name']+'"><p class="lighter nodes__text" id="'+slugify(data[branchID]['children'][key]['name'])+'">'+data[branchID]['children'][key]['name']+'</p></label></li>'
        # console.log  slugify(data[branchID]['name'])
        $('div#'+slugify(data[branchID]['name'])+'.tab-pane ul.nodes').html html
        categ[branchID] = true
        return
      async: true
  return

$('body').on 'click', '.categ-list a', ->
  populate()
  getNodes($(this).attr('name'))

$('body').on 'click', 'div.toggle-collapse.desk-hide', ->
  populate()
  getNodes($(this).attr('name'))

window.slugify = (string) ->
  string.toString().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace /-+$/, ''

$('body').on 'click', '.sub-category-back', ->
  $('.main-category').removeClass 'hidden'
  $('.sub-category').removeClass 'shown'


$('body').on 'click', '.category-back', ->
  $('.main-category').removeClass 'hidden'
  $('.sub-category').removeClass 'shown'
  $('.desk-level-two').addClass 'hidden'
  $('.firstStep').removeClass 'hidden'
  $('.interested-options .radio').prop 'checked', false


$('.topSelect').click ->
	setTimeout (->
		$('.category-back').addClass 'hidden'
		return
	), 100

$('.catSelect-click').click ->
	$('.category-back').removeClass 'hidden'


$('#category-select').on 'hidden.bs.modal', (e) ->
  $('.interested-options .radio').prop 'checked', false
  return


if $(window).width() < 768
	$('.topSelect').click ->
		setTimeout (->
			$('.category-back').addClass 'hidden'
			$('.cat-cancel').addClass 'hidden'
			$('.mobileCat-back').removeClass 'hidden'
			return
		), 100



# detaching sections
if $(window).width() <= 768
  $('.single-category').each ->
    branchAdd = $(this).find('.branch-row')
    branchrow = $(this).find('.branch').detach()
    $(branchAdd).append branchrow
    return
  $('.get-val').each ->
  	removeRow = $(this).find('.fnb-input')
  	addRow = $(this).find('.removeRow').detach()
  	$(removeRow).after addRow




#jQuery flexdatalist
# alert($('.brand-list').length)


# $('.brand-list').flexdatalist removeOnBackspace: false

setTimeout (->
	$('.brand-list').flexdatalist removeOnBackspace: false
	return
), 500


# Tips Toggle
$('body').on 'click', '.tips', ->
	$(this).toggleClass 'open'
	$('.tips__steps.collapse').collapse('toggle')

$('.sample-img').magnificPopup
	items:
		src: 'img/sample_listing.png'
	type: 'image'
	mainClass: 'mfp-fade'

# All cities select
$('body').on 'change', 'input:checkbox.all-cities', ->
	if $(this).is(':checked')
		$(this).closest('.tab-pane').find('input:checkbox').prop('checked', true)
	else
		$(this).closest('.tab-pane').find('input:checkbox').prop('checked', false)

$('[data-toggle="tooltip"]').tooltip()

# Add/Delete Highlights
$('body').on 'click', '.add-highlight', ->
	highlight_group = $(this).closest('.highlight-input-group')
	highlight_group_clone = highlight_group.clone()
	highlight_group_clone.find('.add-highlight').remove()
	highlight_group_clone.find('.delete-highlight').removeClass('hidden')
	highlight_group_clone.insertBefore(highlight_group)
	highlight_group.find('.highlight-input').val('')

$('body').on 'click', '.delete-highlight', ->
	$(this).closest('.highlight-input-group').remove()

$('body').on 'click', '.add-another', (e)->
	e.preventDefault()
	contact_group = $(this).closest('.business-contact').find('.contact-group')
	contact_group_clone = contact_group.clone()
	contact_group_clone.removeClass 'contact-group hidden'
	input = contact_group_clone.find('.fnb-input')
	input.attr('data-parsley-required',true)
	contact_group_clone.insertBefore(contact_group)


# 	catAdd = $(this).closest('.business-cats').find('.add-more-cat')
# 	catAdd_group = catAdd.clone()
# 	catAdd_group.removeClass 'add-more-cat hidden'
# 	catAdd_group.insertBefore(catAdd)

# Remove Category

$('body').on 'click', '.delete-cat', ->
  $(this).closest('.single-category').remove()
  change_view()

$('body').on 'click', '.fnb-cat .remove', ->
  item = $(this).closest('.fnb-cat__title').parent()
  list= item.parent()
  item.remove()
  if list.children().length == 0
    list.closest('.single-category').remove()
  change_view()


$('body').on 'click', '.review-submit', (e)->
	e.preventDefault()
	$('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary')
	$('.draft-status').attr('data-original-title','Listing is under process')
	$(this).addClass('hidden')



if $(window).width() > 768
	getID = $('.gs-form .tab-pane').attr('id')
	$('.gs-steps .form-toggle').each ->
	  if $(this).attr('id') == getID
	    $(this).parent().addClass 'active'
	  return


# $('.verify-link').click ->
# 	get_val = $(this).closest('.get-val').find('.fnb-input').val()
# 	$('.verification-step-modal .number').text get_val

parent = undefined
input = undefined
id = undefined

verify = ->
  $('.validationError').html ''
  if id.val() == ''
    id_val = null
  else
    id_val = id.val()
  validator = input.parsley()
  valid = validator.validate()
  if valid == true and input.val() != ''
    get_val = input.val()
    # console.log get_val
    # console.log id_val
    if parent.hasClass('business-email')
      $('#email-modal').modal 'show'
      type = '1'
    if parent.hasClass('business-phone')
      $('#phone-modal').modal 'show'
      type = '2'
    $.ajax
      type: 'post'
      url: '/create_OTP'
      data:
        'value': get_val
        'type': type
        'id': id_val
      success: (data) ->
        id.val data['id']
        input.val data['value']
        get_val = data['value']
        # console.log id.val()
        return
      error: (request, status, error) ->
        id.val ""
        alert("OTP failed. Try Again")
        return
      async: false
    $('.verification-step-modal .number').text get_val
    $('.verify-steps').addClass 'hidden'
    $('.default-state, .verificationFooter').removeClass 'hidden'

  else
    $('#email-modal').modal 'hide'
    $('#phone-modal').modal 'hide'
  return

window.checkDuplicates = ->
  contacts = document.getElementsByClassName('fnb-input')
  index = 0
  while index < contacts.length
    others = document.getElementsByClassName('fnb-input')
    value = contacts[index].value
    # console.log 'value=' + value
    if value != ''
      index1 = 0
      while index1 < others.length
        if value == others[index1].value and index != index1
          # console.log 'DupValue=' + others[index1].value
          # console.log 'duplicate found'
          $(others[index1]).closest('.get-val').find('.dupError').html 'Same contact detail has been added multiple times.'
          return true
        else
          $(others[index1]).closest('.get-val').find('.dupError').html ''
        ++index1
    ++index
  return

$(document).on 'blur', '.fnb-input', ->
	checkDuplicates()
	$('#info-form').parsley()
	return



$(document).on 'click', '.verify-link', ->
	event.preventDefault()
	parent = $(this).closest('.business-contact')
	input = $(this).closest('.get-val').find('.fnb-input')
	id = $(this).closest('.get-val').find('.comm-id')
	if(checkDuplicates())
		return false
	verify();
	return

$('.edit-number').click ->
  event.preventDefault()
  $('.value-enter').val('')
  $('.default-state').addClass 'hidden'
  $('.add-number').removeClass 'hidden'
  $('.verificationFooter').addClass 'no-bg'
  return


$('.step-back').click ->
	event.preventDefault();
	$('.default-state').removeClass 'hidden'
	$('.add-number').addClass 'hidden'
	$('.verificationFooter').removeClass 'no-bg'
	return

$('.verify-stuff').click ->
  event.preventDefault();
  inp = $(this).siblings '.value-enter'
  inp.attr('data-parsley-required','true')
  if parent.hasClass('business-email')
    inp.attr('data-parsley-type','email')
  else
    inp.attr('data-parsley-type','digits')
    inp.attr('data-parsley-length','[10,10]')
    inp.attr('data-parsley-length-message','Mobile number should be 10 digits')
  validator=inp.parsley()
  if validator.validate() != true
    # console.log 'gandu'
    inp.removeAttr('data-parsley-required')
    inp.removeAttr('data-parsley-type')
    inp.removeAttr('data-parsley-length')
    inp.removeAttr('data-parsley-length-message')
    return false
  inp.removeAttr('data-parsley-required')
  inp.removeAttr('data-parsley-type')
  inp.removeAttr('data-parsley-length')
  inp.removeAttr('data-parsley-length-message')
  $('.default-state').removeClass 'hidden'
  $('.add-number').addClass 'hidden'
  $('.verificationFooter').removeClass 'no-bg'
  get_value = $(this).siblings('.value-enter').val();
  $('.show-number .number').text(get_value);
  $(input).val(get_value);
  $(inp).val('');
  $('.validationError').html ''
  verify();
  return

$('.code-send').click ->
  # $('.processing').removeClass 'hidden'
  errordiv=$(this).closest('.number-code').find('.validationError')
  inp=$(this).closest('.code-submit').find('.fnb-input')
  inp.attr('data-parsley-required','true')
  inp.attr('data-parsley-type','digits')
  inp.attr('data-parsley-length','[4,4]')
  validator=inp.parsley()
  if validator.isValid() != true
    # console.log 'gandu'
    if inp.val()==''
      errordiv.html 'Please enter sent OTP'
    else
      errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
    inp.val('')
    inp.removeAttr('data-parsley-required')
    inp.removeAttr('data-parsley-type')
    inp.removeAttr('data-parsley-length')
    return false
  inp.removeAttr('data-parsley-required')
  inp.removeAttr('data-parsley-type')
  inp.removeAttr('data-parsley-length')
  OTP = inp.val()
  $('.default-state').addClass('hidden')
  $('.processing').removeClass('hidden')
  $.ajax
    type: 'post'
    url: '/validate_OTP'
    data:
      'OTP': OTP
      'id': id.val()
    success: (data) ->
      # console.log data
      if data['success'] == "1"
        errordiv.html('');
        $('.default-state,.add-number,.verificationFooter').addClass 'hidden'
        $('.processing').addClass 'hidden'
        $('.step-success').removeClass 'hidden'
        $(input).closest('.get-val').find('.verified').html '<span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>'
        $(input).attr('readonly',true)
      else
        $('.processing').addClass('hidden')
        $('.default-state').removeClass('hidden')
        inp.val('')
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      return
    error: (request, status, error) ->
      $('.processing').addClass('hidden')
      ('.default-state').removeClass('hidden')
      inp.val('')
      errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      return
    async: false
  return

$('.verification-step-modal').on 'hidden.bs.modal', (e) ->
  $('.step-success,.add-number').addClass 'hidden'
  $('.verificationFooter').removeClass 'no-bg'
  $('.default-state,.verificationFooter').removeClass 'hidden'
  $('.default-state .fnb-input').val ''
  return

$('.resend-link').click ->
	event.preventDefault();
	$(this).addClass 'sending'
	# console.log id.val()
	setTimeout (->
		$('.resend-link').removeClass 'sending'
		return
	), 2500
	return

$('body').on 'click', '.removeRow', ->
	$(this).closest('.get-val').parent().remove()

# setTimeout (->
#   $('.listing-sections').addClass 'active'
#   return
# ), 1500


$(document).on 'change', '.business-contact .toggle__check', ->
# $('.business-contact .toggle__check').change ->
	if $(this).is(':checked')
		$(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing')
	else
		$(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing')
	return

$(document).on 'change', '.city select', ->
  city = $(this).val()
  $.ajax
    type: 'post'
    url: '/get_areas'
    data:
      'city': city
    success: (data) ->
      # console.log data
      html='<option value="" selected>Select Area </option>'
      for key of data
        html += '<option value="' + key + '">' + data[key] + '</option>'
      $('.area select').html html
      return


categories = window.categories
# categories = 'categories': []
# console.log categories

$('body').on 'change', '.tab-pane.collapse input[type=\'checkbox\']', ->
  # console.log categories
  parentDiv = $(this).closest('div')
  branchID = parentDiv.find('input[name="branch"]').attr('id')
  if !categories['categories'].hasOwnProperty branchID
    categories['categories'][branchID] =
    'image-url': parentDiv.find('input[name="image"]').val()
    'parent': parentDiv.find('input[name="parent"]').val()
    'branch': parentDiv.find('input[name="branch"]').val()
    'nodes': []
  if $(this)[0].checked
    categories['categories'][branchID]['nodes'].push {'name': $(this).attr('name') , 'id':$(this).val()}
  else
    id=$(this).val()
    # console.log 'remove this shit'
    categories['categories'][branchID]['nodes'] = _.reject(categories['categories'][branchID]['nodes'], (node) ->
      # console.log node["id"]
      # console.log id
      if node["id"] == id
        true
      else
        false
    )
    # console.log $(this)[0]

populate = () ->
  source = '{{#categories}}<div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer"><div class="col-sm-4 flex-row"><img class="import-icon cat-icon" src="{{image-url}}"></img><div class="branch-row"><div class="cat-label">{{parent}}</div></div></div><div class="col-sm-2"><strong class="branch">{{branch}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row" id="view-categ-node">{{#nodes}}<li><span class="fnb-cat__title">{{name}}<input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> <span class="fa fa-times remove"></span></span></li>{{/nodes}}</ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>{{/categories}}'
  template = Handlebars.compile(source, {noEscape: true})
  console.log template
  $('div#categories.node-list').html template(categories)
  update_core()
  return

$('body').on 'click', 'button#category-select.fnb-btn', ->
	if $(window).width() <= 768
	  # $('.single-category').each ->
			# branchAdd = $(this).find('.branch-row')
			# branchrow = $(this).find('.branch').detach()
			# $(branchAdd).append branchrow
			# return
  k=0
  if categories['categories'].length > 0
    for branch of categories['categories']
      k++
      j=0
      for i of categories['categories'][branch]['nodes']
        j++
      if j == 0
        delete categories['categories'][branch]
  populate()
  if k>0
    $('#categ-selected').removeClass('hidden');
    $('#no-categ-select').addClass('hidden');
    $('.core-cat-cont').removeClass('hidden');
  else
    $('#categ-selected').addClass('hidden');
    $('#no-categ-select').removeClass('hidden');
    #$('.core-cat-cont').addClass('hidden');
  return



$(document).on 'click', '.full.save-btn.gs-next', (e) ->
  step = $('input#step-name').val()
  e.preventDefault()
  if step == 'business-information'
    window.validateListing(e)
  if step == 'business-categories'
    validateCategories()

change_view = () ->
  if $('div#categories.node-list').children().length == 0
    $('#categ-selected').addClass('hidden');
    $('div.core-cat-cont').addClass('hidden');
    $('#no-categ-select').removeClass('hidden');
  else
    $('#categ-selected').removeClass('hidden');
    $('div.core-cat-cont').removeClass('hidden');
    $('#no-categ-select').addClass('hidden');
  update_core()

update_core = () ->
  item_id = []
  item_name = []
  core = []
  $('ul#view-categ-node').find('input[type=\'hidden\']').each (index,data) ->
    item_id.push $(this).val()
    item_name.push $(this).attr('data-item-name')
  $('input.core-cat-select[type="checkbox"]:checked').each (index,data) ->
    core.push $(this).val()
  # console.log item_id
  # console.log item_name
  # console.log core
  html = ''
  item_id.forEach (item, index) ->
    html += '<li><input type="checkbox" data-parsley-required data-parsley-multiple="core_categ" data-parsley-mincheck=1 data-parsley-maxcheck=10 data-parsley-maxcheck-message="Core categories cannot be more than 10." data-parsley-required-message="At least one core category should be selected for a business." class="checkbox core-cat-select" id="cat-label-'+item+'" value="'+item+'"'
    if _.indexOf(core, item) != -1
      html+=' checked="checked"'
    html += '><label class="core-selector__label m-b-0" for="cat-label-'+item+'"><span class="fnb-cat__title text-medium">'+item_name[index]+'</span></label></span></li>'
    return
  $('.core-selector').html html

validateCategories = ->
  instance = $('#info-form').parsley()
  if $('div#categories.node-list').children().length == 0
    $('div#no-categ-error').removeClass 'hidden'
    return false
  if !instance.validate()
    return false;
  $('.section-loader').removeClass('hidden');
  cat ={}
  cores ={}
  $('#view-categ-node input[name="categories"]').each (index,item) ->
    category={}
    category['id'] = $(this).val()
    cat[index] = category
  $('input[data-parsley-multiple="core_categ"]:checked').each (index,item) ->
    core={}
    core['id'] = $(this).val()
    cores[index] = core
  # console.log JSON.stringify cores
  brands = $('input#brandsinput').val()
  # console.log brands
  parameters = {}
  parameters['listing_id'] = document.getElementById('listing_id').value
  parameters['step'] = 'business-categories'
  parameters['change'] = window.change
  parameters['categories'] = JSON.stringify cat
  parameters['core'] = JSON.stringify cores
  parameters['brands'] = brands
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

# console.log categories


