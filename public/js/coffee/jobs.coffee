$(document).on 'change', 'select[name="job_city[]"]', ->
  jobCityObj = $(this)
  html=''
  jobCityObj.closest('.location-select').find('.job-areas').html html
  jobCityObj.closest('.city').find('.city-errors').text ''
  city = $(this).val()
  if city == ''
    return

  jobCityObj.closest('.areas-select').find('select[name="job_city[]"]').each ->
    if jobCityObj.get(0) != $(this).get(0) and $(this).val() == city
      jobCityObj.closest('.city').find('.city-errors').text 'City already selected'
      jobCityObj.val ''
      return 

  $.ajax
    type: 'post'
    url: '/get_areas'
    data:
      'city': city
    success: (data) ->
      # console.log data
      for key of data
        html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>'

      console.log html
      jobCityObj.closest('.location-select').find('.job-areas').html html
      jobCityObj.closest('.location-select').find('.job-areas').multiselect 'destroy'
      jobCityObj.closest('.location-select').find('.job-areas').multiselect
        includeSelectAllOption: true
        numberDisplayed: 5
        delimiterText:','
        nonSelectedText: 'Select Area(s)'

      jobCityObj.closest('.location-select').find('.job-areas').attr('name','job_area['+city+'][]')

      return
    error: (request, status, error) ->
      throwError()
      return


$('input[name="salary_type"]').click (e) ->
  $('.salary-amt').attr('data-parsley-required',true)
 
$('.years-experience').flexdatalist
  selectionRequired: true,
  minLength: 1,
  removeOnBackspace: false

# $('.job-keywords').flexdatalist
#   selectionRequired: true,
#   minLength: 1,
#   removeOnBackspace: false
#   url: '/jobs/get-keywords'
#   searchIn: ["name"]

setTimeout (->
  $('.job-keywords').flexdatalist
    removeOnBackspace: false
    searchByWord:true
    searchContain:true
    selectionRequired:true
    minLength: 1
    url: '/get-keywords'
    searchIn: ["label"]
  return
), 500
 
$('.job-save-btn').click (e) ->
  e.preventDefault()
  CKEDITOR.instances.editor.updateElement()
  $('form').submit()
  return


$('#salary_lower').on 'change', ->
  if $(this).val() != ''
    salaryLower = parseInt $(this).val() 
    salaryUpper = parseInt $('#salary_upper').val()
    $('#salary_upper').attr('data-parsley-min',salaryLower) 
    $('#salary_upper').attr 'data-parsley-required', true
    if salaryUpper =='' &&  salaryUpper < salaryLower
      $('#salary_upper').val parseInt salaryLower + 1
      $('#salary_upper').attr 'min', salaryLower
  else
    console.log 1212
    $('#salary_upper').removeAttr('data-parsley-min') 
    $('#salary_upper').removeAttr('data-parsley-required') 
    $('#salary_upper').val ''
    $('#salary_upper').removeAttr 'min'

  return
 


$('body').on 'click', '.add-another', (e)->
  e.preventDefault()
  contact_group = $(this).closest('.business-contact').find('.contact-group')
  contact_group_clone = contact_group.clone()
  contact_group_clone.removeClass 'contact-group hidden'
  input = contact_group_clone.find('.fnb-input')
  # input.attr('data-parsley-required',true)
  contact_group_clone.insertBefore(contact_group)

# $('body').on 'click', '.removeRow', ->
#   if $(this).closest('.contact-info').find('.contact-container').length == 2
#     $(this).closest('.contact-info').find('.add-another').click()

#   $(this).closest('.get-val').parent().remove()

$('.contact-info').on 'click', '.delete-contact', (event) ->
  deleteObj = $(this)
  contactId = deleteObj.closest('.contact-container').find('.contact-id').val()
  
  console.log contactId
  if contactId!= ""
    $.ajax
      type: 'post'
      url: '/user/delete-contact-details'
      data:
        'id': contactId
      success: (data) ->
         
        return
      error: (request, status, error) ->
        throwError()
        return
      async: false     
   

  if deleteObj.closest('.contact-info').find('.contact-container').length == 2
    deleteObj.closest('.contact-info').find('.add-another').click()

  deleteObj.closest('.get-val').parent().remove()
 

$('body').on 'click', '.add-custom', (e) ->
  e.preventDefault()
  $('.auto-exp-select').addClass('hidden');
  $('.custom-exp').removeClass('hidden');


$('body').on 'click', '.auto-select', (e) ->
  e.preventDefault()
  event.preventDefault()
  $('.auto-exp-select').removeClass('hidden')
  $('.custom-exp').addClass('hidden');
  $('.custom-row:not(:first-child)').remove()


$('body').on 'click', '.add-exp', (e) ->
  e.preventDefault()
  highlight_group = $(this).parent().closest('.custom-row')
  highlight_group_clone = highlight_group.clone()
  highlight_group_clone.find('.add-exp').remove()
  highlight_group_clone.find('.delete-exp').removeClass('hidden')
  highlight_group_clone.find('.exp-label').remove()
  highlight_group_clone.insertAfter(highlight_group)
  # highlight_group.find('.highlight-input').val('')

$('body').on 'click', '.delete-exp', (e) ->
  e.preventDefault()
  $(this).parent().closest('.custom-row').remove()


setTimeout (->
  $('.alert-success').addClass 'active'
  return
), 1000
setTimeout (->
  $('.alert-success').removeClass 'active'
  return
), 6000


$(document).on 'click', '.verify-link', (event) ->
  $('.contact-container').removeClass('under-review')
  $(this).closest('.contact-container').addClass('under-review')
  verifyContactDetail(true)


verifyContactDetail = (showModal) ->
  contactValueObj = $('.under-review').find('.contact-input')
  contactValue = contactValueObj.val()
  contactType = $('.under-review').closest('.contact-info').attr('contact-type')
  objectType = $('input[name="object_type"]').val()
  objectId = $('input[name="object_id"]').val()

 
  if showModal && contactValue != '' && contactValueObj.parsley().validate()
    $('#'+contactType+'-modal').find('.contact-input-value').text contactValue
    $('#'+contactType+'-modal').modal 'show'
  
 
    $.ajax
      type: 'post'
      url: '/user/verify-contact-details'
      data:
        'id': ''
        'contact_value': contactValue
        'contact_type': contactType
        'object_id': objectId
        'object_type': objectType
      success: (data) ->
         
        return
      error: (request, status, error) ->
        throwError()
        return
      async: false
    # $('.verification-step-modal .number').text get_val
    # $('.verify-steps').addClass 'hidden'
    # $('.default-state, .verificationFooter').removeClass 'hidden'

  else 
    $('#'+contactType+'-modal').modal 'hide'

$('.contact-info').on 'change', '.contact-input', (event) ->
  contactObj = $(this)
  contactval = contactObj.val()
  console.log contactval
  if !checkDuplicateEntries(contactObj) && contactval!= ""
    contactObj.closest('div').find('.dupError').html contactval+' already added to list.'
    contactObj.val ''
  else 
    contactObj.closest('div').find('.dupError').html ''

  return

checkDuplicateEntries = (contactObj) ->
  contactval = contactObj.val()
  $('form').parsley().validate()
  result = true
  contactObj.closest('.contact-info').find('.contact-input').each ->

    if contactObj.get(0) != $(this).get(0) and $(this).val() == contactval
      result = false
      return false

  return result 


$('.edit-number').click (event)->
  $('.value-enter').val('')
  $('.default-state').addClass 'hidden'
  $('.add-number').removeClass 'hidden'
  $('.verificationFooter').addClass 'no-bg'
  return


$('.step-back').click (event)->
  $('.default-state').removeClass 'hidden'
  $('.add-number').addClass 'hidden'
  $('.verificationFooter').removeClass 'no-bg'
  return


$('.verify-stuff').click (event)->
  newContactObj = $(this).closest('.modal').find('.change-contact-input')
  changedValue = newContactObj.val()
  oldContactValue = $(this).closest('.modal').find('.contact-input-value').text().trim()

  if newContactObj.parsley().validate() == true
    # upadte parent conatiner input

    oldContactObj = $('.under-review').find('.contact-input')
    oldContactObj.val changedValue
    
    if !checkDuplicateEntries(oldContactObj)
      oldContactObj.val oldCantactValue
      $(this).closest('.verify-steps').find('.customError').text changedValue+' already added to list.'
    else 
      $(this).closest('.verify-steps').find('.customError').text ''
      $(this).closest('.modal').find('.contact-input-value').text(changedValue)
      $('.default-state').removeClass 'hidden'
      $('.add-number').addClass 'hidden'
      $('.verificationFooter').removeClass 'no-bg'
      verifyContactDetail(false)

  return

$('.resend-link').click (event)->
  $(this).addClass 'sending'
  setTimeout (->
    $('.resend-link').removeClass 'sending'
    return
  ), 2500
  return

$('.expSelect').multiselect
  includeSelectAllOption: true
  numberDisplayed: 5
  delimiterText:','
  nonSelectedText: 'Select Experience'



if $(window).width() > 769   
  $('.comp-logo').dropify messages:
    'default': 'Add Logo'
    'replace': 'Change Logo'
    'remove': '<i class="">&#10005;</i>'
 
if $(window).width() < 769   
  $('.comp-logo').dropify messages:
    'default': 'Add Logo'
    'replace': 'Change Logo'


 


# $('body').on 'keyup', '.job-keywords', (e) ->
#   if $('.flexdatalist-multiple .value').length < 0
#     $('.job-keywords').attr('data-parsley-required','')
#   else
#     $('.job-keywords').removeAttr('data-parsley-required')  
#   return

$(document).on 'change', '.business-contact .toggle__check', ->
# $('.business-contact .toggle__check').change ->
  if $(this).is(':checked')
    $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing')
    $(this).closest('.toggle').find('input').val 1
  else
    $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing')
    $(this).closest('.toggle').find('input').val 0
  return




