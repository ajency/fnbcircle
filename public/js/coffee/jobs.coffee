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

$('.job-keywords').flexdatalist
  selectionRequired: true,
  minLength: 1,
  removeOnBackspace: false
 
$('.job-save-btn').click (e) ->
  e.preventDefault()
  CKEDITOR.instances.editor.updateElement()
  
  $('form').submit()
  return


$('#salary_lower').on 'change', ->
  salaryLower = $(this).val()
  $('#salary_upper').attr('data-parsley-min',salaryLower)  
  return
  