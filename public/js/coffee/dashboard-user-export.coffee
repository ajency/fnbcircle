$('body').on 'change', '#export-type', ->
  if @value != ""
    url = document.head.querySelector('[property="export-type-change-url"]').content
    $.ajax
      type: 'post'
      url: url
      data:
        type: @value
      success: (response) ->
        $('#filter-area').html response
        if $('#export-categories') != undefined
          $('#export-categories').jstree
            'plugins': [ 'checkbox','search' ]
            'core': 'data':
              'url': 'http://localhost:8000/get-categories-data'
              'dataType': 'json'
              'data': (node) ->
                { 'id': node.id }

  else
    $('#filter-area').html ""


$('body').on 'click','#select-export-categories', ->
  instance = $('#export-categories').jstree(true)
  selected = instance.get_selected()
  console.log selected
  url = document.head.querySelector('[property="category-hierarchy"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      categories: selected
    success: (response) ->
      console.log  response
  