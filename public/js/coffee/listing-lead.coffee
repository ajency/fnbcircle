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
	        <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">City - areas</p>
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


$('.requestDate').daterangepicker()
filters = {}
table = $('#listing-leads').DataTable(
  # 'paging': false
  'ordering': false
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
        		return '<a href="#" class="archiveaction">archive</a>  <span class="details-control"><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></span>' 
        	else 
        		return '<a href="#" class="unarchiveaction">unarchive</a>  <span class="details-control"><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></span>'
    }
  ]
)

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

$('body').on 'change','input#namefilter', ->
  filters['enquirer_name'] = @value
  table.ajax.reload()

$('body').on 'change','input#emailfilter', ->
  filters['enquirer_email'] = @value
  table.ajax.reload()

$('body').on 'change','input#phonefilter', ->
  filters['enquirer_contact'] = @value
  table.ajax.reload()

$('body').on 'change','input#archivefilter', ->
  if @checked
    filters['archive'] = 1
  else
  	filters['archive'] = 0
  table.ajax.reload()

$('body').on 'click','.archiveaction', ->
  editrow = $(this).closest('td')
  enquiry = table.row(editrow).data()
  console.log enquiry
  $('#enquiryarchive a.archive-enquiry-confirmed').attr('data-enquiry-id', enquiry['id']);
  $('#enquiryarchive').modal('show')

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
				setTimeout (->
					$('.alert-success').removeClass 'active'
					return
				), 5000