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
              'url': '/get-categories-data'
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
  selected = []
  $('#export-premium input[name="exportPremium[]"]:checked').each ->
    selected.push @value
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

$('body').on 'click','#getExportCount', ->
  exportType = $('input[name="export-type"]').val()
  # console.log exportType
  state = $('#selected-export-states').val()
  # console.log state
  status = $('#selected-export-status').val()
  # console.log status
  premium = $('#selected-export-premium').val()
  # console.log premium
  categories = $('#selected-export-categories').val()
  # console.log categories
  userType = $('#selected-export-usertypes').val()
  # console.log usertypes
  userSubType = $('#selected-export-usersubtypes').val()
  # console.log usersubtypes
  jobBusinessType = $('#selected-export-jobtypes').val()
  # console.log jobbusinesstypes
  jobRole = $('#selected-export-jobRoles').val()
  # console.log jobroles
  signupType = $('#selected-export-signup').val()
  # console.log signuptypes
  active = $('#selected-export-active').val()
  # console.log active
  url = document.head.querySelector('[property="export-count"]').content
  $.ajax
    type: 'post'
    url: url
    data:
      exportType:exportType
      state:state
      status:status
      premium:premium
      categories:categories
      userType:userType
      userSubType:userSubType
      jobBusinessType:jobBusinessType
      jobRole:jobRole
      signupType:signupType
      active:active
    success: (response) ->
      if response['status'] == false
        $('#confirm-mail-message').html 'There was a server error, Please contact site administrator'
        $('#export-confirm').prop 'disabled',true
        $('#confirmBox').modal('show')
        return
      if response['count'] == 0
        $('#confirm-mail-message').html 'No users available to export for current selection'
        $('#export-confirm').prop 'disabled',true
        $('#confirmBox').modal('show')
        return
      if response['count'] > 5000
        $('#confirm-mail-message').html 'More than 5000 users in the current selection. Export will take a long time. Please change your filters.'
        $('#export-confirm').prop 'disabled',true
        $('#confirmBox').modal('show')
        return
      $('#export-confirm').prop 'disabled',false
      $('#confirm-mail-message').html 'There are total '+response['count']+' users in your selection.Are you sure you want to export?';
      $('#confirmBox').modal('show')


$('body').on 'click','#export-confirm', ->
  exportType = $('input[name="export-type"]').val()
  state = $('#selected-export-states').val()
  status = $('#selected-export-status').val()
  premium = $('#selected-export-premium').val()
  categories = $('#selected-export-categories').val()
  userType = $('#selected-export-usertypes').val()
  userSubType = $('#selected-export-usersubtypes').val()
  jobBusinessType = $('#selected-export-jobtypes').val()
  jobRole = $('#selected-export-jobRoles').val()
  signupType = $('#selected-export-signup').val()
  active = $('#selected-export-active').val()
  url = document.head.querySelector('[property="export-download"]').content
  form = $('<form></form>')
  form.attr 'method', 'post'
  form.attr 'action', url
  parameters = {}
  parameters['exportType'] = exportType
  parameters['state'] = state
  parameters['status'] = status
  parameters['premium'] = premium
  parameters['categories'] = categories
  parameters['userType'] = userType
  parameters['userSubType'] = userSubType
  parameters['jobBusinessType'] = jobBusinessType
  parameters['jobRole'] = jobRole
  parameters['signupType'] = signupType
  parameters['active'] = active
  $.each parameters, (key, value) ->
    field = $('<input></input>')
    field.attr 'type', 'hidden'
    field.attr 'name', key
    field.attr 'value', value
    form.append field
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
  # $.ajax
  #   type: 'post'
  #   url: url
  #   data:
  #     exportType:exportType
  #     state:state
  #     status:status
  #     premium:premium
  #     categories:categories
  #     userType:userType
  #     userSubType:userSubType
  #     jobBusinessType:jobBusinessType
  #     jobRole:jobRole
  #     signupType:signupType
  #     active:active
    
$('body').on 'click','#clear-filters', ->
  $('div#display-export-active').html '<input type="hidden" id="selected-export-active" name="selected-export-active" value="">'
  $('div#display-export-state').html '<input type="hidden" id="selected-export-states" name="selected-export-states" value="">'
  $('div#display-export-status').html '<input type="hidden" id="selected-export-status" name="selected-export-status" value="">'
  $('div#display-export-premium').html '<input type="hidden" id="selected-export-premium" name="selected-export-premium" value="false">'
  $('div#display-export-categories').html '<input type="hidden" id="selected-export-categories"  name="selected-categories" value="">'
  $('div#display-export-usertypes').html '<input type="hidden" id="selected-export-usertypes" name="selected-export-status" value="">'
  $('div#display-export-usersubtypes').html '<input type="hidden" id="selected-export-usersubtypes" name="selected-export-usersubtypes" value="">'
  $('div#display-export-jobtypes').html '<input type="hidden" id="selected-export-jobtypes" name="selected-export-jobtypes" value="">'
  $('div#display-export-jobroles').html '<input type="hidden" id="selected-export-jobRoles" name="selected-export-jobRoles" value="">'
  $('div#display-export-signup').html '<input type="hidden" id="selected-export-signup" name="selected-export-signup" value="">'
