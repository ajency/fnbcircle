
if $(window).width() <= 768
  businessListing = $('.businessListing').detach()
  $('.addShow').after businessListing
  $('.filter-data:not(.customer-jobs .filter-data)').each ->
    detailrow = $(this).find('.recent-updates__content')
    detailbtn = $(this).find('.detail-move').detach()
    $(detailrow).append detailbtn
    recentrow = $(this).find('.updates-dropDown')
    recentData = $(this).find('.recent-data').detach()
    $(recentrow).append recentData
    publishedAdd = $(this).find('.stats')
    publisherow = $(this).find('.rat-pub').detach()
    $(publishedAdd).append publisherow
    power = $(this).find('.power-seller-container')
    powerseller = $(this).find('.power-seller').detach()
    $(power).append powerseller
    listlabel = $(this).find('.list-label').detach()
    $(this).find('.list-title-container').before listlabel
    return


$('.get-dash-started').click ->
  $('html, body').animate { scrollTop: $('.no-activity-data').offset().top }, 1000
  return



$('#job-form').on 'submit', (event) ->
  if $(this).parsley().isValid()
    $('.resume-loader').removeClass 'hidden'
  return


$('body').on 'click', '.show-alert-form', () ->
  $(this).closest('.alert-config').addClass 'hidden'
  $('.job-form').removeClass 'hidden'


$('.job-form').on 'submit', (event) ->
  if $(this).parsley().isValid()
    $('.job-form-spinner').removeClass 'hidden'
  return