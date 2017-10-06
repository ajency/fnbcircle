filterJobs = (append) ->
  if (append == undefined) 
    append = false
  
  experienceValues = []
  $('input[name="experience[]"]:checked').map ->
    experienceValues.push $(this).val()

  jobTypeValues = []
  $('input[name="job_type[]"]:checked').map ->
    jobTypeValues.push $(this).val()

  areaValues = []
  $('input[name="areas[]"]:checked').map ->
    areaValues.push $(this).val()

  keywords = []
  $('input[name="keyword_id[]"]').map ->
    keywords.push $(this).val()

 
  $.ajax
    type: 'post'
    url: 'jobs/get-listing-jobs'
    data:
      'job_name' : $('#job_name').val()
      'company_name' :''
      'job_type': jobTypeValues
      'city' :$('select[name="job_city"]').val()
      'area' : areaValues
      'experience' :experienceValues
      'category' :''
      'keywords': keywords
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

$(document).on 'change', '.search-job', ->
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
        area_html += '<input type="checkbox" class="checkbox p-r-10 search-job" name="areas[]" value="' + data[key]['id'] + '" class="checkbox p-r-10">'
        area_html += '<span>' + data[key]['name'] + '</span>'
        area_html += '</label>'

 
      $(".area-list").html area_html                        
 
      return
    error: (request, status, error) ->
      throwError()
      return

$('.job-keywords').on 'select:flexdatalist', (event, set, options) ->

  inputTxt = '<input type="hidden" name="keyword_id[]" value="'+set.id+'" label="'+set.label+'">'
  $('#keyword-ids').append inputTxt
  filterJobs() 

$('.job-keywords').on 'change:flexdatalist', (event, set, options) ->
  if(set.length && $('input[label="'+set[0]['text']+'"]').length)
    $('input[label="'+set[0]['text']+'"]').remove()
    filterJobs() 

 
    

$(document).ready ()->
  $('.job-keywords').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      selectionRequired:true
      minLength: 1
      url: '/get-keywords'
      searchIn: ["label"]
    

  displayCityText($('select[name="job_city"]'))
  filterJobs()