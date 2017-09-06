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
      'status': '0,1,2';
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
        html_mob += '" id="' + slugify(data[id]['children'][key]['name']) + '" name="' + data[id]['children'][key]['id'] + '"><div id="selectall" class="nodes"><input type="checkbox" class="checkbox"><label class="flex-row">Selectall</label></div><ul class="nodes"><li>' + data[id]['children'][key]['name'] + '</li></ul></div>'
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
    error: (request, status, error) ->
      throwError()
      return
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
        'status': '0,1,2'
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
        html = '<input type="hidden" name="parent" value="'+data[branchID]['parent']['name']+'">'
        html += '<input type="hidden" name="image" value="'+data[branchID]['parent']['icon_url']+'">'
        html += '<input type="hidden" name="branch" value="'+data[branchID]['name']+'" id="'+branchID+'">'
        data[branchID]['children'] = _.sortBy(_.sortBy(data[branchID]['children'],'name'),'order');
        # console.log array
        for key of data[branchID]['children']
          html += '<li><label class="flex-row"><input type="checkbox" class="checkbox" '
          # console.log data[branchID]['children'][key]['id']
          if _.indexOf(array,String(data[branchID]['children'][key]['id'])) != -1
            html+='checked'
          html +=' for="'+slugify(data[branchID]['children'][key]['name'])+'" value="'+data[branchID]['children'][key]['id']+'" name="'+data[branchID]['children'][key]['name']+'"><p class="lighter nodes__text" id="'+slugify(data[branchID]['children'][key]['name'])+'">'+data[branchID]['children'][key]['name']+'</p></label></li>'
        # console.log  slugify(data[branchID]['name'])
        $('div#'+slugify(data[branchID]['name'])+'.tab-pane ul.nodes').html html
        categ[branchID] = true
        if $('div#'+slugify(data[branchID]['name'])+'.tab-pane ul.nodes input[type="checkbox"]').length == $('div#'+slugify(data[branchID]['name'])+'.tab-pane ul.nodes input[type="checkbox"]:checked').length and $('div#'+slugify(data[branchID]['name'])+'.tab-pane ul.nodes input[type="checkbox"]').length != 0
          $('div#'+slugify(data[branchID]['name'])+'.tab-pane div#selectall input[type="checkbox"]').prop('checked',true)
        return
      async: true
      error: (request, status, error) ->
        throwError()
        return
  return

categories = 'categories': []

$('body').on 'click', '.categ-list a', ->
  populate()
  getNodes($(this).attr('name'))


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

populate = () ->
  source = '{{#categories}}<div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer corecat-container"><div class="col-sm-4 flex-row"><img class="import-icon cat-icon" src="{{image-url}}"></img><div class="branch-row"><div class="cat-label">{{parent}}</div></div></div><div class="col-sm-2"><strong class="branch">{{branch}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row" id="view-categ-node">{{#nodes}}<li><span class="fnb-cat__title">{{name}}<input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> <span class="fa fa-times remove"></span></span></li>{{/nodes}}</ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>{{/categories}}'
  template = Handlebars.compile(source, {noEscape: true})
  # console.log categories
  $('div#categories.node-list').html template(categories)
  return


$('body').on 'click', '.delete-cat', ->
  $(this).closest('.single-category').remove()

$('body').on 'click', '.fnb-cat .remove', ->
  item = $(this).closest('.fnb-cat__title').parent()
  list= item.parent()
  item.remove()
  if list.children().length == 0
    list.closest('.single-category').remove()


$('body').on 'change', '.tab-pane.collapse input[type=\'checkbox\']', ->
  # console.log $(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked')
  if $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').length == $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]:checked').length
    $(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked',true)
  else
    if $(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked')
      $(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked',false)
  parentDiv = $(this).closest('div')
  branchID = parentDiv.find('input[name="branch"]').attr('id')
  if !categories['categories'].hasOwnProperty branchID
    categories['categories'][branchID] =
    'image-url': parentDiv.find('input[name="image"]').val()
    'parent': parentDiv.find('input[name="parent"]').val()
    'branch': parentDiv.find('input[name="branch"]').val()
    'nodes': []
  if $(this)[0].checked
    categories['categories'][branchID]['nodes'][$(this).val()] = {'name': $(this).attr('name') , 'id':$(this).val()}
  else
    id=$(this).val()
    # console.log 'remove this shit'
    delete(categories['categories'][branchID]['nodes'][id])
    # console.log $(this)[0]



$('body').on 'click', 'button#category-select.fnb-btn', ->
  k=0
  if categories['categories'].length > 0
    for branch of categories['categories']
      # console.log categories['categories'][branch]
      j=0
      for i of categories['categories'][branch]['nodes'] 
        j++
      if j == 0
        delete categories['categories'][branch]
        continue
      k++
  populate()
  # console.log k
  if k>0
    $('#categ-selected').removeClass('hidden');
    $('#no-categ-select').addClass('hidden');
    $('.core-cat-cont').removeClass('hidden');
  else
    $('#categ-selected').addClass('hidden');
    $('#no-categ-select').removeClass('hidden');
    $('.core-cat-cont').addClass('hidden');

applyCategFilter = () ->
  return

$('body').on 'click','button#resetAll', (e)->
  $('div#categories.node-list').html ''
  applyCategFilter()
  return

$('div#category-select').on 'change','div#selectall input[type="checkbox"]', () ->
  if $(this).prop('checked')
    $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').prop('checked',true).change()
  else
    $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').prop('checked',false).change()