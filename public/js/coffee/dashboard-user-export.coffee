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
      $('div#display-export-categories').html (response['html'])

$('body').on 'keyup','#jobtypesearch', ->
  value = $(this).val().toLowerCase()
  # console.log value
  $('#export-jobbusinesstypes .jobbusinesstype').filter ->
    # console.log $(this).text()
    $(this).toggle $(this).text().toLowerCase().indexOf(value) > -1
    return
  return

$('body').on 'keyup','#jobrolesearch', ->
  value = $(this).val().toLowerCase()
  # console.log value
  $('#export-jobroles .jobrole').filter ->
    # console.log $(this).text()
    $(this).toggle $(this).text().toLowerCase().indexOf(value) > -1
    return
  return