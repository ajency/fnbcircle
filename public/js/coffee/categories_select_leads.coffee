selected_categ_id = []
window.categories = 'parents': []

$('body').on 'click','#category-select-btn', ()->
  selected_categ = []
  # categories = 'parents': []
  $('#category-select input[type="checkbox"]:checked').each ->
    selected_categ_id.push $(this).val()
    selected_categ.push JSON.parse $(this).parent().find('input[type="hidden"]#hierarchy').val()
    return
  # console.log selected_categ
  selected_categ.forEach( (element) ->
  	parentID = element['parent']['id']
  	# console.log parentID
  	if !categories['parents'].hasOwnProperty parentID
      categories['parents'][parentID] =
      'id': element['parent']['id']
      'image-url': element['parent']['icon_url']
      'name': element['parent']['name']
      'slug': element['parent']['slug']
      'selected': 0
      'branches': []
    if element.hasOwnProperty('branch') and categories['parents'][parentID]['selected'] == 0
      branchID = element['branch']['id']
      if !categories['parents'][parentID]['branches'].hasOwnProperty branchID
        categories['parents'][parentID]['branches'][branchID] =
        'id': element['branch']['id']
        'name': element['branch']['name']
        'slug': element['branch']['slug']
        'selected': 0
        'nodes': []
      if element.hasOwnProperty('node') and categories['parents'][parentID]['branches'][branchID]['selected'] == 0
        nodeID = element['node']['id']
        if !categories['parents'][parentID]['branches'][branchID]['nodes'].hasOwnProperty nodeID
          categories['parents'][parentID]['branches'][branchID]['nodes'][nodeID] =
          'id': element['node']['id']
          'name': element['node']['name']
          'slug': element['node']['slug']
      else
        categories['parents'][parentID]['branches'][branchID]['selected'] = 1
        # console.log element
    else
      categories['parents'][parentID]['selected'] = 1
      # console.log 'parent select ', element
  )
  console.log categories
  populate()
  

populate = () ->
  source = '
{{#parents}}
<div class="single-category gray-border add-more-cat m-t-15" data-categ-id="{{id}}">
  <div class="row flex-row categoryContainer corecat-container">
    <div class="col-sm-4 flex-row">
      <img class="import-icon cat-icon" src="{{image-url}}">
      <div class="branch-row">
        <div class="cat-label">
          {{name}}
          <input type=hidden name="categories" value="{{id}}" data-item-name="{{slug}}"> 
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      {{#branches}}
      <div class="m-b-20 row branch-container" data-categ-id={{id}}>
        <div class="col-sm-4">
          <strong class="branch">{{name}}</strong><span class="fa fa-times remove branch-remove"></span>
          <input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> 
        </div>
        <div class="col-sm-8">
          <ul class="fnb-cat small flex-row" id="view-categ-node">
             {{#nodes}}
            <li class="node-container">
              <span class="fnb-cat__title">
                {{name}}
                <input data-item-name="{{name}}" name="categories" type="hidden" value="{{id}}"> 
                <span class="fa fa-times remove node-remove"></span>
              </span>
            </li>
            {{/nodes}}
          </ul>
        </div>
      </div>
       {{/branches}}
    </div>
  </div>
  <div class="delete-cat">
    <span class="fa fa-times remove"></span>
  </div>
</div>
{{/parents}}'
  template = Handlebars.compile(source, {noEscape: true})
  # console.log template
  $('div#categories.node-list').html template(categories)
  return

$('#categories.node-list').on 'click', '.delete-cat', ->
  pid = parseInt($(this).closest('.single-category').attr('data-categ-id'))
  console.log pid
  delete(categories['parents'][pid])
  $(this).closest('.single-category').remove()
  # if document.getElementById('disp-operation-areas').children.length == 0
  #   $('#area-modal-link').html '+ Add area(s)'

$('#categories.node-list').on 'click', '.branch-remove', ->
  item = $(this).closest('.branch-container')
  pid = parseInt($(this).closest('.single-category').attr('data-categ-id'))
  bid = parseInt($(this).closest('.branch-container').attr('data-categ-id'))
  delete(categories['parents'][pid]['branches'][bid])
  item.remove()

$('#categories.node-list').on 'click', '.fnb-cat .node-remove', ->
  item = $(this).closest('.fnb-cat__title').parent()
  list= item.parent()
  pid = parseInt($(this).closest('.single-category').attr('data-categ-id'))
  bid = parseInt($(this).closest('.branch-container').attr('data-categ-id'))
  nid = parseInt(item.find('input[type="hidden"]').val())
  delete(categories['parents'][pid]['branches'][bid]['nodes'][nid])
  item.remove()


window.getLeafNodes = () ->
  leaf_nodes = []
  for parent of categories['parents']
    i=0
    for branch of categories['parents'][parent]['branches']
      i++
      j=0
      for node of categories['parents'][parent]['branches'][branch]['nodes']
        j++
        leaf_nodes.push(categories['parents'][parent]['branches'][branch]['nodes'][node]['id'])
      if j==0
        leaf_nodes.push(categories['parents'][parent]['branches'][branch]['id'])
    if i==0
      leaf_nodes.push(categories['parents'][parent]['id'])
  return leaf_nodes

$(document).ready ()->
  $(document).on "shown.bs.modal", "#category-select", (event) ->
    enquiry_categories = getLeafNodes()
    console.log enquiry_categories
    $("#category-select #previously_available_categories").val(JSON.stringify(enquiry_categories))
    return
  return