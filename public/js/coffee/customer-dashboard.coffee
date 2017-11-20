
if $('.expSelect').length
  $('.expSelect').multiselect
    includeSelectAllOption: true
    numberDisplayed: 2
    delimiterText:','
    nonSelectedText: 'Select Experience'

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


# if $(window).width() <= 768
#   setTimeout (->
#     coreCat = $('.detach-col-1').detach()
#     $('.job-info').after coreCat
#     return
#   ), 500
#   Applybtn = $('.applyJob').detach()
#   $('.detachsection').after Applybtn
#   Articles = $('.related-article,.similar-business').detach()
#   $('.list-of-business').after Articles
#   adv = $('.advertisement').detach()
#   $('.list-of-business').after adv
#   company = $('.company-info').detach()
#   $('.desc-start').after company   

#   $('.filter-data').each ->
# 	  detailrow = $(this).find('.recent-updates')
# 	  detailbtn = $(this).find('.detail-move').detach()
# 	  $(detailrow).append detailbtn
# 	  recentrow = $(this).find('.updates-dropDown')
# 	  recentData = $(this).find('.recent-data').detach()
# 	  $(recentrow).append recentData
# 	  publishedAdd = $(this).find('.stats')
# 	  publisherow = $(this).find('.rat-pub').detach()
# 	  $(publishedAdd).append publisherow
# 	  power = $(this).find('.power-seller-container')
# 	  powerseller = $(this).find('.power-seller').detach()
# 	  $(power).append powerseller
#   return