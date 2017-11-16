(function() {
  var enquiry_table, filters;

  filters = {};

  enquiry_table = $('#datatable-manage_enquiries').DataTable({
    'pageLength': 25,
    'processing': true,
    'order': [[2, 'desc']],
    'serverSide': true,
    'ajax': {
      'url': '/get-enquiries',
      'type': 'post',
      'data': function(d) {
        var datavar;
        datavar = d;
        datavar.filters = filters;
        console.log(datavar);
        return datavar;
      }
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

  $('body').on('change', 'select#updateType', function() {
    filters['enquiry_type'] = $(this).val();
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'select#updateUser', function() {
    filters['enquirer_type'] = $(this).val();
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'select#updateUserDetails', function() {
    filters['enquirer_details'] = $(this).val();
    return enquiry_table.ajax.reload();
  });

  $('body').on('click', 'a#clearSubDate', function() {
    $('#submissionDate').val('');
    filters['request_date'] = [];
    return enquiry_table.ajax.reload();
  });

  $('#submissionDate').on('apply.daterangepicker', function(ev, picker) {
    filters['request_date'] = {};
    filters['request_date']['start'] = picker.startDate.format('YYYY-MM-DD');
    filters['request_date']['end'] = picker.endDate.format('YYYY-MM-DD');
    $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
    enquiry_table.ajax.reload();
  });

  $('body').on('click', 'button#applyLocFilter', function() {
    var entry, i, j, loc_area_array, loc_city_array;
    loc_city_array = [];
    loc_area_array = [];
    for (entry in cities['cities']) {
      j = 0;
      for (i in cities['cities'][entry]['areas']) {
        console.log;
        loc_area_array.push(cities['cities'][entry]['areas'][i]['id']);
        j++;
      }
      if (j === 0) {
        loc_city_array.push(cities['cities'][entry]['id']);
      }
    }
    filters['city'] = loc_city_array;
    filters['area'] = loc_area_array;
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'input#namefilter', function() {
    filters['enquirer_name'] = this.value;
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'input#emailfilter', function() {
    filters['enquirer_email'] = this.value;
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'input#phonefilter', function() {
    filters['enquirer_contact'] = this.value;
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'input#senttofilter', function() {
    filters['sent_to'] = this.value;
    return enquiry_table.ajax.reload();
  });

  $('body').on('change', 'input#madetofilter', function() {
    filters['enquiree'] = this.value;
    return enquiry_table.ajax.reload();
  });

  $('body').on('click', 'button#applyCategFilter', function() {
    console.log('worls');
    filters['categories'] = JSON.stringify(getLeafNodes());
    return enquiry_table.ajax.reload();
  });

  $('#datatable-manage_enquiries').closest('.row').addClass('overflow-table');

  $('body').on('click', 'button#resetAll', function(e) {
    $('div#categories.node-list').html('');
    $('div#disp-operation-areas.node-list').html('');
    $('select#updateType').multiselect('rebuild');
    $('select#updateUser').multiselect('rebuild');
    $('#submissionDate').val('');
    $('#namefilter').val('');
    $('#emailfilter').val('');
    $('#phonefilter').val('');
    $('#madetofilter').val('');
    $('#senttofilter').val('');
    $('.multi-dd').each(function() {
      return $(this).multiselect('deselectAll', false);
    });
    filters = {};
    enquiry_table.ajax.reload();
  });

}).call(this);
