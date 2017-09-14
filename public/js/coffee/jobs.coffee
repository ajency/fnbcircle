$(document).on 'change', 'select[name="job_city[]"]', ->
  jobCityObj = $(this)
  html=''
  jobCityObj.closest('.location-select').find('select[name="job_area[]"]').html html
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
      
      console.log  html
      jobCityObj.closest('.location-select').find('select[name="job_area[]"]').html html
      jobCityObj.closest('.location-select').find('select[name="job_area[]"]').multiselect 'destroy'
      jobCityObj.closest('.location-select').find('select[name="job_area[]"]').multiselect
        includeSelectAllOption: true
        numberDisplayed: 1
        nonSelectedText: 'Select Area(s)'

      return
    error: (request, status, error) ->
      throwError()
      return



setTimeout (->
  $('.years-experience').flexdatalist
    valueProperty: 'id'
    selectionRequired: true
    removeOnBackspace: false
  return
), 500

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
  $('.auto-exp-select').removeClass('hidden');
  $('.custom-exp').addClass('hidden');


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

