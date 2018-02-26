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


$('body').on 'click','#select-export-states', ->
  selected = []
  $('#export-state-filter input[name="exportState[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-state-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      states: selected
    success: (response) ->
      $('div#display-export-state').html (response['html'])

$('body').on 'click','#select-export-statuses', ->
  selected = []
  $('#export-status-filter input[name="exportStatus[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-status-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      statuses: selected
    success: (response) ->
      $('div#display-export-status').html (response['html'])

$('body').on 'click','#select-export-premium', ->
  selected = $('#export-premium input[name="exportPremium"]').prop 'checked'
  console.log selected
  url = document.head.querySelector('[property="export-premium-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      premium: selected
    success: (response) ->
      $('div#display-export-premium').html (response['html'])

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

$('body').on 'click','#select-export-usertypes', ->
  selected = []
  $('#export-usertypes input[name="usertypes[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-usertype-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      userTypes: selected
    success: (response) ->
      $('div#display-export-usertypes').html (response['html'])

$('body').on 'click','#select-export-usersubtypes', ->
  selected = []
  $('#export-usersubtypes input[name="usersubtypes[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-usersubtype-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      userSubTypes: selected
    success: (response) ->
      $('div#display-export-usersubtypes').html (response['html'])

$('body').on 'click','#select-export-jobbusinesstypes', ->
  selected = []
  $('#export-jobbusinesstypes input[name="jobbusinesstypes[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-jobtype-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      jobTypes: selected
    success: (response) ->
      $('div#display-export-jobtypes').html (response['html'])

$('body').on 'click','#select-export-jobroles', ->
  selected = []
  $('#export-jobroles input[name="jobroles[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-jobrole-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      jobRoles: selected
    success: (response) ->
      $('div#display-export-jobroles').html (response['html'])

$('body').on 'click','#select-export-signuptypes', ->
  selected = []
  $('#export-signuptype-filter input[name="exportsignuptype[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-signup-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      signup: selected
    success: (response) ->
      $('div#display-export-signup').html (response['html'])

$('body').on 'click','#select-export-active', ->
  selected = []
  $('#export-active input[name="exportActive[]"]:checked').each ->
    selected.push(this.value)
  console.log selected
  url = document.head.querySelector('[property="export-active-display"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      active: selected
    success: (response) ->
      $('div#display-export-active').html (response['html'])

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