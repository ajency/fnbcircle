filters = {}
enquiry_table = $('#datatable-manage_enquiries').DataTable(
  'pageLength': 25
  'processing': true
  'order': [ [
    2
    'desc'
  ] ]
  'serverSide':true
  'ajax':
    'url': '/get-enquiries'
    'type':'post'
    'data': (d) ->
      datavar = d;
      # datavar.search['value'] = $('#listingNameSearch').val()
      datavar.filters = filters
      console.log datavar
      return datavar
  "columns": [
    {"data": "type"}
    {"data": "enquirer_type"}
    {"data": "request_date"}
    {"data": "enquirer_name"}
    {"data": "enquirer_email"}
    {"data": "enquirer_phone"}
    {"data": "enquirer_details"}
    {"data": "message"}
    {"data": "categories"}
    {"data": "areas"}
    {"data": "made_against"}
    {"data": "sent_to"}
  ]
  'columnDefs': [
    {
      'targets': 'no-sort'
      'orderable': false
    }
    {
      'targets': [
        
      ]
      'visible': false
      'searchable': false
    }
  ]
  )
enquiry_table.columns().iterator 'column', (ctx, idx) ->
  $(enquiry_table.column(idx).header()).append '<span class="sort-icon"/>'
  return



$('body').on 'change','select#updateType', ->
  filters['enquiry_type'] = $(this).val()
  enquiry_table.ajax.reload()

$('body').on 'change','select#updateUser', ->
  filters['enquirer_type'] = $(this).val()
  enquiry_table.ajax.reload()

$('body').on 'click','a#clearSubDate', ->
  $('#submissionDate').val('')
  filters['request_date'] = []
  enquiry_table.ajax.reload()

$('#submissionDate').on 'apply.daterangepicker', (ev, picker) ->
  filters['request_date'] = {}
  filters['request_date']['start'] = picker.startDate.format('YYYY-MM-DD')
  filters['request_date']['end'] = picker.endDate.format('YYYY-MM-DD')
  $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))
  enquiry_table.ajax.reload()
  return

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
  enquiry_table.ajax.reload()

$('body').on 'change','input#namefilter', ->
  filters['enquirer_name'] = @value
  enquiry_table.ajax.reload()

$('body').on 'change','input#emailfilter', ->
  filters['enquirer_email'] = @value
  enquiry_table.ajax.reload()

$('body').on 'change','input#phonefilter', ->
  filters['enquirer_contact'] = @value
  enquiry_table.ajax.reload()

$('body').on 'change','input#senttofilter', ->
  filters['sent_to'] = @value
  enquiry_table.ajax.reload()

$('body').on 'change','input#madetofilter', ->
  filters['enquiree'] = @value
  enquiry_table.ajax.reload()

$('body').on 'click','button#applyCategFilter', ->
  console.log 'worls'
  filters['categories'] = JSON.stringify(getLeafNodes())
  enquiry_table.ajax.reload()

