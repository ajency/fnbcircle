window.filters = {
  'id_filter': {
    'start': document.head.querySelector('[property="start-id"]').content
    'end': document.head.querySelector('[property="end-id"]').content
  }
}

listing_table = $('#datatable-manage_listings').DataTable(
  'language':
    "zeroRecords": "No listings? Please check if you're not making one of the common mistakes listed below:<br><ul><li>start_id must always be less than end_id</li></ul>"
  'pageLength': 25
  'processing': true
  'order': [ [
    0
    'desc'
  ] ]
  'serverSide':true
  'ajax':
    'url': '/show-listings'
    'type':'post'
    'data': (d) ->
      datavar = d;
      datavar.search['value'] = $('#listingNameSearch').val()
      datavar.filters = filters
      return datavar
  "columns": [
    {"data": "id"}
    {"data": "city"}
    {"data": "name"}
    {"data": "categories"}
    {"data": "submission_date"}
    {"data": "approval"}
    {"data": "paid"}
    {"data": "status"}
    {"data": "views"}
    {"data": "contact-count"}
    {"data": "direct-count"}
    {"data": "shared-count"}

  ]
  'select':
    'style': 'multi'
    'selector': 'td:first-child'
  'columnDefs': [
    {
      'targets': 'no-sort'
      'orderable': false
    },
    {
      'targets': [
        0
      ]
      'visible': false
      'searchable': false
    }
  ]
  )
listing_table.columns().iterator 'column', (ctx, idx) ->
  $(listing_table.column(idx).header()).append '<span class="sort-icon"/>'
  return
$('#listingNameSearch').on 'keyup', ->
  listing_table.columns(1).search(@value).draw()
  return

$('body').on 'change','select#citySelect', ->
  filters['city']= $(this).val()
  listing_table.ajax.reload()

$('body').on 'change','select#paidFilter', ->
  filters['paid']= $(this).val()
  listing_table.ajax.reload()

$('body').on 'change','select#status-filter', ->
  filters['status']= $(this).val()
  listing_table.ajax.reload()

$('#submissionDate').on 'apply.daterangepicker', (ev, picker) ->
  filters['submission_date'] = {}
  filters['submission_date']['start'] = picker.startDate.format('YYYY-MM-DD')
  filters['submission_date']['end'] = picker.endDate.format('YYYY-MM-DD')
  $('#submissionDate').val(picker.startDate.format('DD-MM-YYYY')+' to '+picker.endDate.format('DD-MM-YYYY'))
  listing_table.ajax.reload()  
  return

$('body').on 'click','a#clearSubDate', ->
  $('#submissionDate').val('')
  filters['submission_date'] = {}
  listing_table.ajax.reload()

$('#approvalDate').on 'apply.daterangepicker', (ev, picker) ->
  filters['approval_date'] = {}
  filters['approval_date']['start'] = picker.startDate.format('YYYY-MM-DD')
  filters['approval_date']['end'] = picker.endDate.format('YYYY-MM-DD')
  $('#approvalDate').val(picker.startDate.format('DD-MM-YYYY')+' to '+picker.endDate.format('DD-MM-YYYY'))
  listing_table.ajax.reload()  
  return

$('body').on 'click','a#clearAppDate', ->
  $('#approvalDate').val('')
  filters['approval_date'] = {}
  listing_table.ajax.reload()

$('#statsDate').on 'apply.daterangepicker', (ev, picker) ->
  filters['stats_date'] = {}
  filters['stats_date']['start'] = picker.startDate.format('YYYY-MM-DD')
  filters['stats_date']['end'] = picker.endDate.format('YYYY-MM-DD')
  $('#statsDate').val(picker.startDate.format('DD-MM-YYYY')+' to '+picker.endDate.format('DD-MM-YYYY'))
  listing_table.ajax.reload()  
  return

$('body').on 'click','a#clearStatDate', ->
  $('#statsDate').val('')
  filters['stats_date'] = {}
  listing_table.ajax.reload()

$('body').on 'show.bs.modal','#category-select', ->
  getCategoryDom("#category-select #level-one-category-dom", "level_1")


$('body').on 'click','button#applyCategFilter', (e)->
  filters['categories']=JSON.stringify(getLeafNodes())
  listing_table.ajax.reload()

$('body').on 'click','button#resetAll', (e)->
  $('#listingNameSearch').val('')
  $('#submissionDate').val('')
  $('#approvalDate').val('')
  $('#statsDate').val('')
  $('.multi-dd').each ->
    # console.log this
    $(this).multiselect('deselectAll',false)
  $('div#categories.node-list').html ''
  window.categories = 'parents': []
  window.filters = {
    'id_filter': {
      'start': document.head.querySelector('[property="start-id"]').content
      'end': document.head.querySelector('[property="end-id"]').content
    }
  }
  listing_table.ajax.reload()

$('body').on 'click','button#exportListings', (e)->
  order = listing_table.order()
  search = $('#listingNameSearch').val()
  form = $('<form></form>')
  form.attr 'method', 'post'
  form.attr 'action', '/download-listings'
  parameters = {}
  parameters['order'] = order
  parameters['search'] = search
  parameters['filters'] = JSON.stringify filters
  $.each parameters, (key, value) ->
    field = $('<input></input>')
    field.attr 'type', 'hidden'
    field.attr 'name', key
    field.attr 'value', value
    form.append field
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
