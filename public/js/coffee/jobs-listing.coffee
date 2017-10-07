filterJobs = (resetPage) ->
  console.log resetPage
  append = false
  if (resetPage) 
    $('input[name="listing_page"]').val(1)
  
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

  urlParams = '';
  job_name = $('#job_name').val()
  city = $('select[name="job_city"]').val()
  category_id = $('input[name="category_id"]').val()
  salary_type = $('select[name="salary_type"]').val()
  salary_lower =$('input[name="salary_lower"]').val()
  salary_upper = $('input[name="salary_upper"]').val()
  page = $('input[name="listing_page"]').val()

  if(page!='')
    urlParams +='page='+page

  if(city!='')
    urlParams +='&city='+city

  if(salary_type!='')
    urlParams +='&salary_type='+salary_type

  if(salary_lower!='')
    urlParams +='&salary_lower='+salary_lower

  if(salary_upper!='')
    urlParams +='&salary_upper='+salary_upper


  if(job_name.trim()!='')
    urlParams +='&job_name='+job_name

  if(category_id!='')
    urlParams +='&category='+category_id

  

  if(jobTypeValues.length != 0)
    urlParams +='&job_type='+JSON.stringify(jobTypeValues)

  if(areaValues.length != 0)
    urlParams +='&area='+JSON.stringify(areaValues)

  if(experienceValues.length != 0)
    urlParams +='&experience='+JSON.stringify(experienceValues)

  if(keywords.length != 0)
    urlParams +='&keywords='+JSON.stringify(keywords)


  window.history.pushState("", "", "?"+urlParams);
  $.ajax
    type: 'post'
    url: 'jobs/get-listing-jobs'
    data:
      'page' : page;
      'job_name' : job_name
      'company_name' :''
      'job_type': jobTypeValues
      'city' : city
      'area' : areaValues
      'experience' :experienceValues
      'category' : category_id
      'keywords': keywords
      'salary_type': salary_type
      'salary_lower': salary_lower
      'salary_upper': salary_upper
      'append': append
    success: (response) ->
      $("#filtered_count").text response.filtered_items 
      $("#total_count").text response.total_items 
      $(".job-pagination").html response.pagination 
      if(append) 
          $('.job-listings').append response.data 
      else 
          $('.job-listings').html '' 
          $('.job-listings').html response.data 
        
      
    error: (request, status, error) ->
      throwError()
      return

$(document).on 'change', '.search-job', ->
  filterJobs(true)
  return




$('.clear-checkbox').click ->
  $(this).closest('.filter-check').find('input[type="checkbox"]').prop('checked',false)
  filterJobs(true)


$('.clear-salary').click ->
  $('select[name="salary_type"]').prop("selectedIndex", 0)
  $('input[name="salary_lower"]').val('0')
  $('input[name="salary_upper"]').val('200000')
  filterJobs(true)


$('.header_city').change ->
  cityText = $('option:selected',this).text();
  window.location.href = '/'+cityText+'/job-listings'
  return

$('select[name="job_city"]').change ->
  displayCityText()
  return

$('input[name="area_search"]').change ->
  displayCityText()

displayCityText = () -> 
  cityObj = $('select[name="job_city"]');
  cityText = $('option:selected',cityObj).text();
  $("#state_name").text cityText 

  $.ajax
    type: 'post'
    url: '/get_areas'
    data:
      'city': cityObj.val()
      'area_name': $('input[name="area_search"]').val()
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


$('.job-pagination').on 'click', '.paginate', ->
  page = $(this).attr 'page'
  $('input[name="listing_page"]').val page
  filterJobs(false)




$('.job-keywords').on 'select:flexdatalist', (event, set, options) ->
  inputTxt = '<input type="hidden" name="keyword_id[]" value="'+set.id+'" label="'+set.label+'">'
  $('#keyword-ids').append inputTxt
  filterJobs(true) 

$('.job-keywords').on 'change:flexdatalist', (event, set, options) ->
  if(set.length && $('input[label="'+set[0]['text']+'"]').length)
    $('input[label="'+set[0]['text']+'"]').remove()
    filterJobs(true) 
 

$(document).ready ()->
  $('.job-keywords').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      selectionRequired:true
      minLength: 1
      url: '/get-keywords'
      searchIn: ["label"]

  $('.job-categories').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      selectionRequired:true
      minLength: 1
      url: '/job/get-category-types'
      searchIn: ["name"] 

  $('.job-categories').on 'select:flexdatalist', (event, set, options) ->
    $('input[name="category_id"]').val set.id   
    filterJobs(true) 

  console.log $('.area-list').attr('has-filter')
  if $('.area-list').attr('has-filter').trim() == 'no'
    displayCityText()
  filterJobs(true)