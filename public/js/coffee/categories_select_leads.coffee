selected_categ_id = []
window.categories = 'parents': []

$('body').on 'click','#category-select-btn', ()->
  selected_categ = []
  selected_categ_id = []
  $('#category-select input[type="checkbox"]:checked').each ->
    selected_categ_id.push $(this).val()
    selected_categ.push JSON.parse $(this).parent().find('input[type="hidden"]#hierarchy').val()
    return
  console.log selected_categ
  selected_categ.forEach( (element) ->
  	parentID = element['parent']['id']
  	console.log parentID
  	if !categories['parents'].hasOwnProperty parentID
      categories['parents'][parentID] =
      'id': element['parent']['id']
      'image-url': element['parent']['icon_url']
      'name': element['parent']['name']
      'slug': element['parent']['slug']
      'branches': []
    if element.hasOwnProperty 'branch'
      branchID = element['branch']['id']
      if !categories['parents'][parentID]['branches'].hasOwnProperty branchID
        categories['parents'][parentID]['branches'][branchID] =
        'id': element['branch']['id']
        'name': element['branch']['name']
        'slug': element['branch']['slug']
        'nodes': []
    if element.hasOwnProperty 'node'
      nodeID = element['node']['id']
      if !categories['parents'][parentID]['branches'][branchID]['nodes'].hasOwnProperty nodeID
        categories['parents'][parentID]['branches'][branchID]['nodes'][nodeID] =
        'id': element['node']['id']
        'name': element['node']['name']
        'slug': element['node']['slug']
    console.log categories
  )
  

populate = () ->
  source = '
{{#parents}}
<div class="single-category gray-border add-more-cat m-t-15">
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
      <div class="m-b-20 row">
        <div class="col-sm-4">
          <strong class="branch">{{name}}</strong>
          <input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> 
        </div>
        <div class="col-sm-8">
          <ul class="fnb-cat small flex-row" id="view-categ-node">
             {{#nodes}}
            <li>
              <span class="fnb-cat__title">
                Crabs
                <input data-item-name="{{name}}" name="categories" type="hidden" value="{{id}}"> 
                <span class="fa fa-times remove"></span>
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

# '{{#categories}}
#   <div class="single-category gray-border add-more-cat m-t-15">
#     <div class="row flex-row categoryContainer corecat-container">
#       <div class="col-sm-4 flex-row">
#         <img class="import-icon cat-icon" src="{{image-url}}"></img>
#         <div class="branch-row">
#           <div class="cat-label">
#             {{parent}}
#           </div>
#         </div>
#       </div>
#     <div class="col-sm-2">
#       <strong class="branch">
#         {{branch}}
#       </strong>
#     </div>
#     <div class="col-sm-6"> 
#       <ul class="fnb-cat small flex-row" id="view-categ-node">
#         {{#nodes}}
#         <li>
#           <span class="fnb-cat__title">
#             {{name}}
#             <input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> 
#             <span class="fa fa-times remove"></span>
#           </span>
#         </li>
#         {{/nodes}}
#       </ul>
#     </div> 
#   </div>
#   <div class="delete-cat">
#     <span class="fa fa-times remove"></span>
#   </div>
# </div>
# {{/categories}}'

# '{{#categories}}
# <div class="single-category gray-border add-more-cat m-t-15">
#   <div class="row flex-row categoryContainer corecat-container">
#     <div class="col-sm-4 flex-row">
#       <img class="import-icon cat-icon" src="{{image-url}}">
#       <div class="branch-row">
#         <div class="cat-label">
#           {{name}}
#           <input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> 
#         </div>
#       </div>
#     </div>
#     <div class="col-sm-8">
#       {{#branches}}
#       <div class="m-b-20 row">
#         <div class="col-sm-4">
#           <strong class="branch">{{name}}</strong>
#           <input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> 
#         </div>
#         <div class="col-sm-8">
#           <ul class="fnb-cat small flex-row" id="view-categ-node">
#              {{#nodes}}
#             <li>
#               <span class="fnb-cat__title">
#                 Crabs
#                 <input data-item-name="{{name}}" name="categories" type="hidden" value="{{id}}"> 
#                 <span class="fa fa-times remove"></span>
#               </span>
#             </li>
#             {{/nodes}}
#           </ul>
#         </div>
#       </div>
#        {{/branches}}
#     </div>
#   </div>
#   <div class="delete-cat">
#     <span class="fa fa-times remove"></span>
#   </div>
# </div>
# {{/categories}}'