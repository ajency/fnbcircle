$(document).on 'change', 'select[name="job_city[]"]', ->
  jobCityObj = $(this)
  html=''
  jobCityObj.closest('.location-select').find('.job-areas').html html
  city = $(this).val()
  if city == ''
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
        numberDisplayed: 1
        nonSelectedText: 'Select Area(s)'

      jobCityObj.closest('.location-select').find('.job-areas').attr('name','job_area['+city+'][]')

      return
    error: (request, status, error) ->
      throwError()
      return

 
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
  salaryLower = $(this).val()
  $('#salary_upper').attr('data-parsley-min',salaryLower)  
  return
 

$('body').on 'click', '.add-another', (e)->
  e.preventDefault()
  contact_group = $(this).closest('.business-contact').find('.contact-group')
  contact_group_clone = contact_group.clone()
  contact_group_clone.removeClass 'contact-group hidden'
  input = contact_group_clone.find('.fnb-input')
  input.attr('data-parsley-required',true)
  contact_group_clone.insertBefore(contact_group)

$('body').on 'click', '.removeRow', ->
  $(this).closest('.get-val').parent().remove()
 

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
  contactValue = $(this).closest('.contact-container').find('.contact-input').val
  contactType = $(this).closest('.contact-container').attr('contact-type')
  objectType = $('input[name="object_type"]').val
  objectId = $('input[name="object_id"]').val


$('.contact-info').on 'change', '.contact-input', (event) ->
  contactObj = $(this)
  val = contactObj.val;
  contactObj.closest('.contact-info').find('.contact-input').each ->
    console.log $(this).val()
    if contactObj.get(0) != $(this).get(0) and $(this).val() == val
      contactObj.closest('div').find('.dupError').html contactObj.val+' already added to list.'
      contactObj.val ''
      return false
  return
  



   

 
