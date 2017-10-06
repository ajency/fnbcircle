filterJobs = (append) ->
  if (append == undefined) 
    append = false
 
  $.ajax
    type: 'post'
    url: 'jobs/get-listing-jobs'
    data:
      'job_name' : $('#job_name').val()
      'company_name' :''
      'job_status': ''
      'city' :$('select[name="job_city"]').val()
      'category' :''
      'keywords': ''
      'append': append
    success: (response) ->
      $("#total_count").text response.total_items 
      if(append) 
          $('.job-listings').append response.data 
      else 
          $('.job-listings').html '' 
          $('.job-listings').html response.data 
        
      
    error: (request, status, error) ->
      throwError()
      return

$('.search-job').change ->
  filterJobs();
  return

$('.header_city').change ->
  cityText = $('option:selected',this).text();
  window.location.href = '/'+cityText+'/job-listings'
  return

$('select[name="job_city"]').change ->
  displayCityText($(this))

  return

displayCityText = (cityObj) -> 
  cityText = $('option:selected',cityObj).text();
  $("#state_name").text cityText 

  $.ajax
    type: 'post'
    url: '/get_areas'
    data:
      'city': cityObj.val()
    success: (data) ->
      # console.log data
      area_html = ''
      for key of data
        area_html += '<label class="sub-title flex-row text-color">'
        area_html += '<input type="checkbox" name="areas[]" value="' + data[key]['id'] + '" class="checkbox p-r-10">'
        area_html += '<span>' + data[key]['name'] + '</span>'
        area_html += '</label>'

 
      $(".area-list").html area_html                        
 
      return
    error: (request, status, error) ->
      throwError()
      return

$(document).ready ()->
  displayCityText($('select[name="job_city"]'))
  filterJobs();