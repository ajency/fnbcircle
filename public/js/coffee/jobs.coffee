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