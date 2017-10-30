(function() {
  var enquiry_table;

  enquiry_table = $('#datatable-manage_enquiries').DataTable({
    'pageLength': 25,
    'processing': true,
    'order': [[2, 'desc']],
    'serverSide': true,
    'ajax': {
      'url': '/get-enquiries',
      'type': 'post',
      'data': function(d) {}
    },
    "columns": [
      {
        "data": "type"
      }, {
        "data": "enquirer_type"
      }, {
        "data": "request_date"
      }, {
        "data": "enquirer_name"
      }, {
        "data": "enquirer_email"
      }, {
        "data": "enquirer_phone"
      }, {
        "data": "enquirer_details"
      }, {
        "data": "message"
      }, {
        "data": "categories"
      }, {
        "data": "areas"
      }, {
        "data": "made_against"
      }, {
        "data": "sent_to"
      }
    ],
    'columnDefs': [
      {
        'targets': 'no-sort',
        'orderable': false
      }, {
        'targets': [],
        'visible': false,
        'searchable': false
      }
    ]
  });

  enquiry_table.columns().iterator('column', function(ctx, idx) {
    $(enquiry_table.column(idx).header()).append('<span class="sort-icon"/>');
  });

}).call(this);
