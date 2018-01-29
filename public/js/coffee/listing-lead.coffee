# ---------------------------
# DATATABLE INIT -----------
# ---------------------------

# <div class="ca-holder">
# 	<div class="location flex-row align-top">
# 	    <p class="m-b-0 text-color heavier default-size state-name"><i class="fa fa-map-marker text-lighter" aria-hidden="true"></i> Mumbai <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
# 	    </p>
# 	    <ul class="cities flex-row flex-wrap">
# 	      <li>
# 	          <p class="cities__title default-size m-b-0">Calangute</p>
# 	      </li>
# 	      <li>
# 	          <p class="cities__title default-size m-b-0">Canacona</p>
# 	      </li>
# 	     </ul>
# 	</div>
# </div>




# <div class="ca-holder m-b-10">
#     <div class="location flex-row align-top">
#         <p class="m-b-0 text-color heavier default-size state-name">Mumbai <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
#         </p>
#         <ul class="cities flex-row flex-wrap">
#           <li>
#               <p class="cities__title default-size m-b-0 text-color">Chicken</p>
#           </li>
#          </ul>
#     </div>
#     <div class="ca-holder m-b-5">
#         <ul class="cities flex-row flex-wrap m-t-5">
#           <li>
#               <p class="cities__title default-size m-b-0 text-color">Chicken</p>
#           </li>
#           <li>
#               <p class="cities__title default-size m-b-0 text-color">Chicken</p>
#           </li>
#           <li>
#               <p class="cities__title default-size m-b-0 text-color">Chicken</p>
#           </li>
#         </ul>
#     </div>
# </div>


format = (d) ->
  # `d` is the original data object for the row
	# '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' + '<tr>' + '<td>Full name:</td>' + '<td>' + d.name + '</td>' + '</tr>' + '<tr>' + '<td>Extension number:</td>' + '<td>' + d.extn + '</td>' + '</tr>' + '<tr>' + '<td>Extra info:</td>' + '<td>And any further details here (images etc)...</td>' + '</tr>' + '</table>'
	'<div class="row leads-drop">
	    <div class="col-sm-6">
	    <div class="operations m-b-20">
	        <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">State - Cities</p>
	          '+d.areas+'
	        </div>
	        <div class="operations">
	        <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0"><i class="fa fa-comments text-primary" aria-hidden="true"></i> Message</p>
	          <div class="ca-holder">
	            '+d.message+'
	           </div>
	        </div>
	    </div>
		 <div class="col-sm-6">
		    <div class="operations cate-list">
		        <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">Categories</p>
				'+d.categories+'	          
	        </div>
	    </div>

	</div>'

# alert($_GET['type'])
$('.requestDate').daterangepicker()
if $_GET['type'] == undefined or $_GET['type'] == "" 
  filters = {}
else
  filters = 'enquiry_type': [$_GET['type']]
  $('input.type-filter[value="'+$_GET['type']+'"]').prop("checked",true)

table = $('#listing-leads').DataTable(
  # 'paging': false
  'ordering': false
  "dom": 'iltrp'
  "searching": false
  # 'info': false
  # "dom": 'ilrtp'
  'pageLength': 10
  'processing': true
  'serverSide':true
  'ajax':
    'url': document.head.querySelector('[property="listing-enquiry"]').content
    'type':'post'
    'data': (d) ->
      datavar = d;
      datavar.listing_id = document.getElementById('listing_id').value
      datavar.filters = filters
      console.log datavar
      return datavar
  "columns": [
    {"data": "type"}
    {"data": "enquirer_name"}
    {"data": "enquirer_email"}
    {"data": "enquirer_phone"}
    {"data": "enquirer_details"}
    {
        "className":      'text-secondary cursor-pointer',
        "orderable":      false,
        "data":           'archive',
        "render": (d) ->
        	if d == 0 
        		return '<a href="#" class="archiveaction archive-action"><i class="fa fa-star-o lead-star archive" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Archive"></i></a>  ' 
        	else 
        		return '<a href="#" class="unarchiveaction archive-action"><i class="fa fa-star lead-star archived" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Unarchive"></i></a>'
    }
    {
      "orderable":      false,
      "data":  'object_type',
      "render": (d) ->
        if d != 'contact-request' 
          tabWidth = $('#listing-leads').width()
          $('#listing-leads_wrapper').css('width',tabWidth)
          return '<span class="details-control text-secondary heavier cursor-pointer"><span class="more-less-text">More details</span> <i class="fa fa-angle-down" aria-hidden="true"></i></span>' 
        else 
          return ''
    }
  ]
)


tooltipinit = ->
	setTimeout (->
	  $('[data-toggle="tooltip"]').tooltip()
	), 1000

tooltipinit()

# Add event listener for opening and closing details
$('#listing-leads tbody').on 'click', '.details-control', ->
	console.log 'sadfs'
	tr = $(this).closest('tr')
	row = table.row(tr)
	if row.child.isShown()
	# This row is already open - close it
		row.child.hide()
		tr.removeClass 'shown'
		$(this).find('.more-less-text').text 'More details'
	else
	# Open this row
		row.child(format(row.data())).show()
		tr.addClass 'shown'
		$(this).find('.more-less-text').text 'Less details'
	return

$('#submissionDate').val('')
$('body').on 'click','a#clearSubDate', (e) ->
  e.preventDefault()
  $('#submissionDate').val('')
  filters['request_date'] = []
  table.ajax.reload()
  tooltipinit()

$('#submissionDate').on 'apply.daterangepicker', (ev, picker) ->
  filters['request_date'] = {}
  filters['request_date']['start'] = picker.startDate.format('YYYY-MM-DD')
  filters['request_date']['end'] = picker.endDate.format('YYYY-MM-DD')
  $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))
  console.log filters
  table.ajax.reload()
  tooltipinit()
  return

$('body').on 'change', '.type-filter', -> 
  array = []
  $('.type-filter:checked').each (index,element) ->
  	array.push $(element).val()
  filters['enquiry_type'] = array
  table.ajax.reload()
  tooltipinit()

$('body').on 'keyup','input#namefilter', ->
  filters['enquirer_name'] = @value
  table.settings()[0].jqXHR.abort()
  table.ajax.reload()
  tooltipinit()

$('body').on 'keyup','input#emailfilter', ->
  filters['enquirer_email'] = @value
  table.settings()[0].jqXHR.abort()
  table.ajax.reload()
  tooltipinit()

$('body').on 'keyup','input#phonefilter', ->
  filters['enquirer_contact'] = @value
  table.settings()[0].jqXHR.abort()
  table.ajax.reload()
  tooltipinit()

$('body').on 'click','button#applyLocFilter', ->
  loc_city_array = []
  loc_area_array = []
  for entry of cities['cities']
      j=0
      for i of cities['cities'][entry]['areas']
        console.log 
        loc_area_array.push(cities['cities'][entry]['areas'][i]['id'])
        j++
      if j == 0
        loc_city_array.push(cities['cities'][entry]['id'])
  filters['city'] = loc_city_array
  filters['area'] = loc_area_array
  table.ajax.reload()
  tooltipinit()

$('body').on 'change','input#archivefilter', ->
  if @checked
    filters['archive'] = 1
  else
  	filters['archive'] = 0
  table.ajax.reload()
  tooltipinit()


$('body').on 'click','button#applyCategFilter', ->
  console.log 'worls'
  filters['categories'] = JSON.stringify(getLeafNodes())
  table.ajax.reload()
  tooltipinit()

$('body').on 'click','a#clearAllFilters', ->
  filters = {}
  $('input#archivefilter').prop('checked',false)
  $('input#phonefilter').val ''
  $('input#emailfilter').val ''
  $('input#namefilter').val ''
  $('.type-filter').prop('checked',false)
  $('#submissionDate').val ''
  $('#disp-operation-areas').html ""
  $('#categories.node-list').html ""
  categories = 'parents': []
  window.city = []
  window.cities = 'cities': []
  table.ajax.reload()
  tooltipinit()


$('body').on 'click','.archiveaction', ->
  editrow = $(this).closest('td')
  enquiry = table.row(editrow).data()
  console.log enquiry
  $('#enquiryarchive a.archive-enquiry-confirmed').attr('data-enquiry-id', enquiry['id']);
  $('#enquiryarchive').modal('show')
  tooltipinit()

$('body').on 'click','#cancelenquiryarchive', ->
	$('#enquiryarchive a.archive-enquiry-confirmed').removeAttr('data-enquiry-id');

$('#enquiryarchive').on 'click','a.archive-enquiry-confirmed', ->
	id = $(this).attr('data-enquiry-id')
	# ajax call here
	$.ajax 
		type: 'post'
		url: document.head.querySelector('[property="listing-enquiry-archive"]').content
		data: 
			'listing_id' : document.getElementById('listing_id').value
			'enquiry_id': id
		success: (data) ->
			if data['status'] == 200
				table.ajax.reload()
				$('.alert-success span.message').html 'enquiry archived successfully'
				$('.alert-success').addClass 'active'
				tooltipinit()
				setTimeout (->
		          $('.alert-success').removeClass 'active'
		          return
		        ), 5000

$('body').on 'click','.unarchiveaction', ->
	editrow = $(this).closest('td')
	enquiry = table.row(editrow).data()
	console.log enquiry
	$.ajax 
		type: 'post'
		url: document.head.querySelector('[property="listing-enquiry-unarchive"]').content
		data: 
			'listing_id' : document.getElementById('listing_id').value
			'enquiry_id': enquiry['id']
		success: (data) ->
			if data['status'] == 200
				table.ajax.reload()
				$('.alert-success span.message').html 'enquiry unarchived successfully'
				$('.alert-success').addClass 'active'
				tooltipinit()
				setTimeout (->
					$('.alert-success').removeClass 'active'
					return
				), 5000

