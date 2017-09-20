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
        numberDisplayed: 2
        delimiterText:','
        nonSelectedText: 'Select Area(s)'

      jobCityObj.closest('.location-select').find('.job-areas').attr('name','job_area['+city+'][]')

      return
    error: (request, status, error) ->
      throwError()
      return


$('input[name="salary_type"]').click (e) ->
  $('.salary-amt').attr('data-parsley-required',true)
 

$('.clear-salary').on 'click', ->
  $('input[name="salary_type"]').prop('checked',false).removeAttr('data-parsley-required') 
  $('input[name="salary_lower"]').removeAttr('data-parsley-required').val ''
  $('input[name="salary_upper"]').removeAttr('data-parsley-required').val ''


if $('.years-experience').length
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
  if $('.job-keywords').length
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
  if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
    $('.job-keywords').removeAttr('data-parsley-required')
  else
    $('.job-keywords').attr('data-parsley-required','')  

  console.log $('input[name="step"]').val()
  if $('input[name="step"]').val()  == 'step-one' || $('input[name="step"]').val()  == 'step-two'
    CKEDITOR.instances.editor.updateElement()

  $('form').submit()
  return


$('#salary_lower').on 'change', ->
  if $(this).val() != ''
    salaryLower = parseInt $(this).val() 
    salaryUpper = parseInt $('#salary_upper').val()
    $('#salary_upper').attr('data-parsley-min',salaryLower) 
    $('#salary_upper').attr 'data-parsley-required', true
    $('input[name="salary_type"]').attr 'data-parsley-required', true
    if salaryUpper =='' &&  salaryUpper < salaryLower
      $('#salary_upper').val parseInt salaryLower + 1
      $('#salary_upper').attr 'min', salaryLower
  else
    $('#salary_upper').removeAttr('data-parsley-min') 
    $('#salary_upper').removeAttr('data-parsley-required') 
    $('input[name="salary_type"]').removeAttr('data-parsley-required') 
    $('#salary_upper').val ''
    $('#salary_upper').attr 'min', 0

  return

$('#salary_upper').on 'change', ->
  if $(this).val() != ''
    $('#salary_lower').attr 'data-parsley-required', true
  else
    $('#salary_lower').removeAttr('data-parsley-required')

  return
 

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


if $('.expSelect').length
  $('.expSelect').multiselect
    includeSelectAllOption: true
    numberDisplayed: 2
    delimiterText:','
    nonSelectedText: 'Select Experience'



if $(window).width() > 769  
  if $('.comp-logo').length 
    $('.comp-logo').dropify messages:
      'default': 'Add Logo'
      'replace': 'Change Logo'
      'remove': '<i class="">&#10005;</i>'
 
if $(window).width() < 769  
  if $('.comp-logo').length
    $('.comp-logo').dropify messages:
      'default': 'Add Logo'
      'replace': 'Change Logo'


if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
else
  $('.job-keywords').attr('data-parsley-required','')  


$('body').on 'keyup', '.job-keywords', (e) ->
  if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
    $('.job-keywords').removeAttr('data-parsley-required')
  else
    $('.job-keywords').attr('data-parsley-required','')  
  return

$('body').on 'blur', '.job-keywords', (e) ->
  if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
    $('.job-keywords').removeAttr('data-parsley-required')
    
    console.log('removed')
  else
    $('.job-keywords').attr('data-parsley-required','')  
    console.log('added')
  return

# Ckeditor inti

if $('#editor').length
  CKEDITOR.replace( 'editor' )

# Ease scrolling

$("html").easeScroll()

# Equal card height

if $(window).width() > 769
  getheight = $('.design-2-card').outerHeight()
  $('.equal-col').css 'height', getheight

# scroll to details

$('.check-detail').click ->
  $('html, body').animate { scrollTop: $('#about-company').offset().top - 20 }, 2000
  return


$('.more-show').click (event) ->
  event.preventDefault()
  $(this).addClass 'hidden'
  $('.line').addClass 'hidden'
  $(this).parent().addClass 'expand-more'
  return

if $(window).width() <= 768
  coreCat = $('.detach-col-1').detach()
  $('.sell-re').after coreCat
  Applybtn = $('.applyJob').detach()
  $('.role-selection').after Applybtn
  Articles = $('.related-article').detach()
  $('.list-of-business').after Articles

$('[data-toggle="tooltip"]').tooltip()

