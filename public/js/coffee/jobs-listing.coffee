filterJobs = (resetPage) ->
  console.log resetPage
  append = false
  if (resetPage) 
    $('input[name="listing_page"]').val(1)
  
  experienceValues = []
  $('input[name="experience[]"]:checked').map ->
    experienceValues.push $(this).val()

  jobTypeValues = []
  jobTypeSlug = []
  $('input[name="job_type[]"]:checked').map ->
    jobTypeValues.push $(this).val()
    jobTypeSlug.push $(this).attr('slug')

  areaValues = []
  areaSlugs = []
  $('input[name="areas[]"]:checked').map ->
    areaValues.push $(this).val()
    areaSlugs.push $(this).attr('slug')

  keywords = []
  keywordslug = []
  $('input[name="keyword_id[]"]').map ->
    keywords.push $(this).val()
    keyword_slug_str = $(this).val()+'|'+strSlug($(this).attr('label'))
    keywordslug.push keyword_slug_str

  urlParams = '';
  job_name = $('#job_name').val()
  city = $('select[name="job_city"]').val()
  cityObj = $('select[name="job_city"]');
  cityId = $('option:selected',cityObj).attr('id');

  category_id = $('input[name="category_id"]').val()
  category_slug = $('input[name="category_id"]').attr('slug')
  salary_type_obj = $('select[name="salary_type"]')
  salary_type = salary_type_obj.val()
  salary_type_slug = $("option:selected", salary_type_obj).attr("slug") 
  salary_lower =$('input[name="salary_lower"]').val()
  salary_upper = $('input[name="salary_upper"]').val()
  page = $('input[name="listing_page"]').val()

  if(page!='')
    urlParams +='page='+page

  if(city!='')
    urlParams +='&city='+city

  if(salary_type!='')
    urlParams +='&salary_type='+salary_type_slug

  if(salary_lower!='')
    urlParams +='&salary_lower='+salary_lower

  if(salary_upper!='')
    urlParams +='&salary_upper='+salary_upper


  if(job_name.trim()!='')
    urlParams +='&job_name='+job_name

  if(category_id!='')
    urlParams +='&category='+category_slug

  

  if(jobTypeValues.length != 0)
    urlParams +='&job_type='+JSON.stringify(jobTypeSlug)

  if(areaValues.length != 0)
    urlParams +='&area='+JSON.stringify(areaSlugs)

  if(experienceValues.length != 0)
    urlParams +='&experience='+JSON.stringify(experienceValues)

  if(keywords.length != 0)
    urlParams +='&keywords='+JSON.stringify(keywordslug)


  window.history.pushState("", "", "?"+urlParams);
  $.ajax
    type: 'post'
    url: 'jobs/get-listing-jobs'
    data:
      'page' : page;
      'job_name' : job_name
      'company_name' :''
      'job_type': jobTypeValues
      'city' : cityId
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


strSlug = (str) ->
  str = str.replace(' ','-')
  str = str.trim()
  str = str.toLowerCase()
  str


$('.clear-checkbox').click ->
  $(this).closest('.filter-check').find('input[type="checkbox"]').prop('checked',false)
  filterJobs(true)


$('.clear-keywords').click ->
  # $('input[class="job-input-keywords"]').remove()
  # $('.flexdatalist-multiple').find('li[class="value"]').addClass('hidden')

  $('.flexdatalist-multiple').find('li[class="value"]').each ->
    $(this).find('.fdl-remove').click()

  filterJobs(true)



$('.clear-salary').click ->
  $('select[name="salary_type"]').prop("selectedIndex", 0)
  $('input[name="salary_lower"]').val('')
  $('input[name="salary_upper"]').val('')
  filterJobs(true)

$('select[name="salary_type"]').change ->
  if($(this).val() !='')
    minSalary = $("option:selected", this).attr("min") 
    maxSalary = $("option:selected", this).attr("max") 
    $('input[name="salary_lower"]').val(minSalary)
    $('input[name="salary_upper"]').val(maxSalary)
    $('.salary-range').removeClass('hidden')
  else
    $('.salary-range').addClass('hidden')
    $('input[name="salary_lower"]').val('')
    $('input[name="salary_upper"]').val('')

  return


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
  cityId = $('option:selected',cityObj).attr('id');
  $("#state_name").text cityText 
  $( ".fnb-breadcrums:eq(2)" ).text cityText 

  $.ajax
    type: 'post'
    url: '/get_areas'
    data:
      'city': cityId
      'area_name': $('input[name="area_search"]').val()
    success: (data) ->
      # console.log data
      area_html = ''
      for key of data
        area_html += '<label class="sub-title flex-row text-color">'
        area_html += '<input type="checkbox" class="checkbox p-r-10 search-job" name="areas[]" value="' + data[key]['id'] + '" slug="' + data[key]['slug'] + '" class="checkbox p-r-10">'
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
  inputTxt = '<input type="hidden" name="keyword_id[]" class="job-input-keywords" value="'+set.id+'" label="'+set.label+'">'
  $('#keyword-ids').append inputTxt
  filterJobs(true) 

$('.job-keywords').on 'change:flexdatalist', (event, set, options) ->
  console.log set
  if(set.length && $('input[label="'+set['text']+'"]').length)
    $('input[label="'+set['text']+'"]').remove()
    filterJobs(true) 
 

$(document).ready ()->
  $('.job-keywords').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      minLength: 0
      url: '/get-keywords'
      searchIn: ["label"]

  $('.job-categories').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      minLength: 0
      url: '/job/get-category-types'
      searchIn: ["name"] 

  $('.job-categories').on 'select:flexdatalist', (event, set, options) ->
    $('input[name="category_id"]').val set.id   
    $('input[name="category_id"]').attr 'slug',set.slug   
    filterJobs(true) 

  console.log $('.area-list').attr('has-filter')
  if $('.area-list').attr('has-filter').trim() == 'no'
    displayCityText()
  filterJobs(true)