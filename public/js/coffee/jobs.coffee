$(document).on 'change', 'select[name="job_city[]"]', ->
  jobCityObj = $(this)
  html=''
  jobCityObj.closest('.location-select').find('.job-areas').html html
  jobCityObj.closest('.city').find('.city-errors').text ''
  city = $(this).val()
  if city == ''
    return

  hasDuplicateState = false
  jobCityObj.closest('.areas-select').find('select[name="job_city[]"]').each ->
    if jobCityObj.get(0) != $(this).get(0) and $(this).val() == city
      jobCityObj.closest('.city').find('.state-errors').text 'State already selected'
      hasDuplicateState =true
      jobCityObj.val ''
      return 

  if !hasDuplicateState
    $.ajax
      type: 'post'
      url: '/get_areas'
      data:
        'city': city
      success: (data) ->
        # console.log data
        for key of data
          html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>'

        jobCityObj.closest('.location-select').find('.job-areas').html html
        jobCityObj.closest('.location-select').find('.job-areas').multiselect 'destroy'
        jobCityObj.closest('.location-select').find('.job-areas').multiselect
          includeSelectAllOption: true
          numberDisplayed: 2
          delimiterText:','
          nonSelectedText: 'Select City'

        jobCityObj.closest('.location-select').find('.job-areas').attr('name','job_area['+city+'][]')

        return
      error: (request, status, error) ->
        throwError()
        return


$('input[name="salary_type"]').change (e) ->
  $('.salary-amt').attr('data-parsley-required',true)
  console.log $('input[name="salary_lower"]').attr('salary-type-checked')
  if($('input[name="salary_lower"]').attr('salary-type-checked') == "true")
    $('.salary-amt').val ''

  $('input[name="salary_lower"]').attr('salary-type-checked',true)

$('#job-form').bind 'input select textarea iframe', ->
  $('input[name="has_changes"]').val 1
  return

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

$(document).ready ()->
  if $('.job-keywords').length
    $('.job-keywords').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      selectionRequired:true
      minLength: 0
      maxShownResults: 5000
      url: '/get-keywords'
      searchIn: ["label"]
    return

  if $('.auto-company').length
    $('.auto-company').flexdatalist
      removeOnBackspace: false
      searchByWord:true
      searchContain:true
      # selectionRequired:true
      minLength: 1
      url: '/get-company'
      searchIn: ["title"]
    return


$('.job-keywords').on 'select:flexdatalist', (event, set, options) ->
  inputTxt = '<input type="hidden" name="keyword_id['+set.id+']" value="'+set.label+'" label="">'
  $('#keyword-ids').append inputTxt
  return 

$('.auto-company').on 'select:flexdatalist', (event, set, options) ->
  
  $('input[name="company_id"]').val set.id

  if(set.logo == '')
    $('input[name="company_logo"]').removeAttr 'data-default-file' 
    $('.dropify-preview').css('display','none')
    $('.dropify-wrapper').removeClass('has-preview')
    $('.dropify-render').html('')
  else
    $('input[name="company_logo"]').attr 'data-default-file', set.logo
    $('.dropify-preview').css('display','block')
    $('.dropify-wrapper').addClass('has-preview')
    $('.dropify-render').html('<img src="'+set.logo+'">')


  $('textarea[name="company_description"]').text set.description
  CKEDITOR.instances['editor'].setData(set.description);
  $('input[name="company_website"]').val set.website

 
  return

# $('.job-keywords').on 'before:flexdatalist.remove', (event, set, options) ->
#   console.log "event"
#   console.log set
#   console.log options
#   return  

 
$('.job-save-btn').click (e) ->
  e.preventDefault()
  if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
    $('.job-keywords').removeAttr('data-parsley-required')
  else
    $('.job-keywords').attr('data-parsley-required','')  


  if $('input[name="step"]').val()  == 'job-details' || $('input[name="step"]').val()  == 'company-details'
    CKEDITOR.instances.editor.updateElement()

    editorStr = CKEDITOR.instances.editor.getData()
    editorStr = editorStr.replace(/&nbsp;/g, '');
    editorStr = editorStr.replace("<p>", "")
    editorStr = editorStr.replace("</p>", "")
    
    if editorStr == ""
      CKEDITOR.instances.editor.setData('')

  $(this).closest('form').submit()
  return


$('#salary_lower').on 'change', ->
  if $(this).val() != ''
    $(this).attr('salary-type-checked', $('input[name="salary_type"]').is(':checked'))
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
    $('#salary_lower').attr('salary-type-checked', $('input[name="salary_type"]').is(':checked'))
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

$('#job-form').on 'keyup keypress', (e) ->
  keyCode = e.keyCode or e.which
  if keyCode == 13
    e.preventDefault()
    return false
 


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

$('.resume-upload').dropify messages:
  'default': 'Upload my resume'
  'replace': 'Replace resume'
  'remove': '<i class="">&#10005;</i>'
  'error': ''


$('.resume-already-upload').dropify messages:
  'default': 'Upload new resume'
  'replace': 'Replace resume'
  'remove': '<i class="">&#10005;</i>'
  'error': ''  

if $(window).width() > 769  
  if $('.comp-logo').length 
    companyLogo = $('.comp-logo').dropify messages:
      'default': 'Add Logo'
      'replace': 'Change Logo'
      'remove': '<i class="">&#10005;</i>'
 
if $(window).width() < 769  
  if $('.comp-logo').length
    companyLogo = $('.comp-logo').dropify messages:
      'default': 'Add Logo'
      'replace': 'Change Logo'

if $('.comp-logo').length
  companyLogo.on 'dropify.afterClear', (event, element) ->
    $("input[name='delete_logo']").val 1
    $("input[type='file']").attr('title','')
 


if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
else
  $('.job-keywords').attr('data-parsley-required','')  


$('body').on 'keyup', '.job-keywords', (e) ->
  if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
    $('.job-keywords').removeAttr('data-parsley-required')
  else
    $('.job-keywords').attr('data-parsley-required','')  
 

$('body').on 'blur', '.job-keywords', (e) ->
  if $('.flex-data-row .flexdatalist-multiple li').hasClass('value')
    $('.job-keywords').removeAttr('data-parsley-required')
    
  else
    $('.job-keywords').attr('data-parsley-required','')  
 

# $('body').on 'click', '.fdl-remove', (e) ->
#   console.log '121' 
#   console.log($(this).closest('li').find('span[class="text"]').text())
 



# Ckeditor inti

if $('#editor').length
  CKEDITOR.replace( 'editor' )
  CKEDITOR.instances.editor.on 'change', ->
    $('input[name="has_changes"]').val 1
    return

# Ease scrolling

$("html").easeScroll()

# Equal card height

if $(window).width() > 769
  setTimeout (->
    getheight = $('.design-2-card').outerHeight()
    $('.equal-col').css 'height', getheight
    return
  ), 500

# scroll to details

$('.check-detail').click ->
  $('html, body').animate { scrollTop: $('#about-company').offset().top - 20 }, 2000
  return

$('.scroll-to-location').click ->
  $('html, body').animate { scrollTop: $('#map').offset().top - 35 }, 2000
  return


$('.more-show').click (event) ->
  event.preventDefault()
  $(this).addClass 'hidden'
  $('.line').addClass 'hidden'
  $(this).parent().addClass 'expand-more'
  return

if $(window).width() <= 768
  setTimeout (->
    coreCat = $('.detach-col-1').detach()
    $('.job-info').after coreCat
    return
  ), 500
  Applybtn = $('.applyJob').detach()
  $('.detachsection').after Applybtn
  Articles = $('.related-article,.similar-business').detach()
  $('.list-of-business').after Articles
  adv = $('.advertisement').detach()
  $('.list-of-business').after adv
  company = $('.company-info').detach()
  $('.desc-start').after company

$('[data-toggle="tooltip"]').tooltip()


# Get map address value and pass to div text

# setTimeout (->
#   getaddress = $('.location-val').val()
#   $('.mapAddress').text(getaddress)
#   return
# ), 1000


# Get id add active

if $(window).width() > 769
  getID = $('.gs-form .tab-pane').attr('id')
  $('.gs-steps .form-toggle').each ->
    if $(this).attr('id') == getID
      $(this).parent().addClass 'active'
    return 


$('body').on 'click', '.add-job-areas', (e) ->
  console.log 12

  locationLen = $('.location-select').length
  addLocationLen = parseInt(locationLen)+1
  area_group = undefined
  area_group_clone = undefined
  e.preventDefault()
  area_group = $(this).closest('.areas-select').find('.area-append')
  area_group_clone = area_group.clone()
  area_group_clone.removeClass 'area-append hidden'
  area_group_clone.find('.areas-appended').addClass 'newly-created'
  area_group_clone.find('.selectCity').attr 'data-parsley-required', ''
  area_group_clone.find('.selectCity').attr 'data-parsley-errors-container', '#state-errors'+addLocationLen
  area_group_clone.find('.state-errors').attr 'id', 'state-errors'+addLocationLen
  area_group_clone.find('.selectCity').attr 'data-parsley-required-message', 'Select a state where the job is located.'
  area_group_clone.find('.job-areas').attr 'data-parsley-required', ''
  area_group_clone.find('.job-areas').attr 'data-parsley-required-message', 'Select city where the job is located.'
  area_group_clone.find('.job-areas').attr 'data-parsley-errors-container', '#city-errors'+addLocationLen
  area_group_clone.find('.city-errors').attr 'id', 'city-errors'+addLocationLen
  area_group_clone.find('.newly-created').multiselect
    includeSelectAllOption: true
    numberDisplayed: 1
    nonSelectedText: 'Select City'
  area_group_clone.insertBefore area_group
  return


previewL = $('.detach-preview').detach()
$('.preview-detach').append previewL


if $('.readMore').length
  $('.readMore').readmore
    speed: 75
    collapsedHeight: 40
    lessLink: '<a href="#">Read less</a>'

# $('.applicant-phone').intlTelInput
#   # initialCountry: country
#   separateDialCode: true
#   geoIpLookup: (callback) ->
#     $.get('https://ipinfo.io', (->
#     ), 'jsonp').always (resp) ->
#       countryCode = if resp and resp.country then resp.country else ''
#       callback 91
#       return
#     return
#   preferredCountries: [ 'IN' ]
#   americaMode: false
#   formatOnDisplay:false

# $(document).ready ()->
#   mobileNo = $('.applicant-phone').val()
#   countryCode = $('input[name="country_code"]').val()
#   $('.applicant-phone').intlTelInput("setNumber", "+"+countryCode).val mobileNo

$(document).on 'countrychange', 'input[name="applicant_phone"]', (e, countryData)->  
  $('input[name="country_code"]').val countryData.dialCode
    


$(document).on 'click', 'input[name="send_alert"]', ->
  sendAlerts = ($(this).is(":checked")) ? 1 : 0
  $.ajax
    type: 'get'
    url: '/user/send-job-alerts'
    data:
      'send_alert': sendAlerts
    success: (data) ->
      $('.edit-criteria').removeClass 'hidden'
      # console.log data
      
      return
    error: (request, status, error) ->
      throwError()
      return

$('body').on 'click', '.removelocRow', ->
  
  if $(this).closest('.job-areas').find('.location-select').length == 2
    $(this).closest('.job-areas').find('.add-job-areas').click()




