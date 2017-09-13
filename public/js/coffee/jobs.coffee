$(document).on 'change', 'select[name="job_city[]"]', ->
  jobCityObj = $(this)
  html='<option value="" selected>Select Area </option>'
  jobCityObj.closest('.location-select').find('.area select').html html
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
      jobCityObj.closest('.location-select').find('.area select').html html
      return
    error: (request, status, error) ->
      throwError()
      return

$('.years-experience').flexdatalist({
  valueProperty: 'id',
  selectionRequired: true,
  removeOnBackspace: false
});
