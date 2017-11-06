(function() {
  var registeredUserTable;

  registeredUserTable = $('#datatable-registration').DataTable({
    'pageLength': 25,
    'processing': true,
    'serverSide': true,
    'bAutoWidth': false,
    'aaSorting': [[0, 'desc']],
    'drawCallback': function() {},
    'ajax': {
      url: '/admin-dashboard/users/get-registered-users',
      type: 'post',
      data: function(data) {
        var filters;
        filters = {};
        filters.user_name = $('#user_name').val();
        filters.user_email = $('#user_email').val();
        filters.user_phone = $('#user_phone').val();
        filters.user_status = $('select[name="user_status"]').val();
        filters.state = $('select[name="user_state"]').val();
        filters.city = $('select[name="user_city"]').val();
        filters.registration_type = $('select[name="registration_type"]').val();
        filters.user_created_from = $('input[name="user_created_from"]').val();
        filters.user_created_to = $('input[name="user_created_to"]').val();
        filters.last_login_from = $('input[name="last_login_from"]').val();
        filters.user_created_to = $('input[name="user_created_to"]').val();
        data.filters = filters;
        return data;
      },
      error: function() {}
    },
    'columns': [
      {
        'data': 'name',
        "orderable": false
      }, {
        'data': 'type',
        "orderable": false
      }, {
        'data': 'email',
        "orderable": false
      }, {
        'data': 'phone',
        "orderable": false
      }, {
        'data': 'describe',
        "orderable": false
      }, {
        'data': 'state',
        "orderable": false
      }, {
        'data': 'city',
        "orderable": false
      }, {
        'data': 'date_created'
      }, {
        'data': 'last_login'
      }, {
        'data': 'total_listing'
      }, {
        'data': 'published_listing'
      }, {
        'data': 'total_jobs'
      }, {
        'data': 'published_jobs'
      }, {
        'data': 'job_applied'
      }, {
        'data': 'resume_uploaded',
        "orderable": false
      }, {
        'data': 'status',
        "orderable": false
      }
    ],
    "columnDefs": [
      {
        "width": "60px",
        "targets": 0
      }, {
        "width": "60px",
        "targets": 1
      }, {
        "width": "90px",
        "targets": 2
      }, {
        "width": "100px",
        "targets": 3
      }, {
        "width": "120px",
        "targets": 4
      }, {
        "width": "80px",
        "targets": 5
      }, {
        "width": "100px",
        "targets": 6
      }, {
        "width": "80px",
        "targets": 7
      }, {
        "width": "80px",
        "targets": 8
      }, {
        "width": "80px",
        "targets": 9
      }, {
        "width": "70px",
        "targets": 10
      }
    ]
  });

  registeredUserTable.columns().iterator('column', function(ctx, idx) {
    $(registeredUserTable.column(idx).header()).append('<span class="sort-icon"/>');
  });

  $('.usersearchinput').change(function() {
    registeredUserTable.ajax.reload();
  });

  $('.userstrsearchinput').keyup(function() {
    registeredUserTable.ajax.reload();
  });

  $('body').on('click', '.reset-filters', function() {
    $('#user_name').val('');
    $('#user_phone').val('');
    $('#user_email').val('');
    $('select[name="user_status"]').val('');
    $('select[name="user_state"]').val('');
    $('select[name="user_city"]').val('');
    $('.date-from').val('');
    $('.date-to').val('');
    $('.date-range').val('');
    $('.multi-dd').each(function() {
      return $(this).multiselect('deselectAll', false).change();
    });
    registeredUserTable.ajax.reload();
  });

  $('.date_range_picker').on('apply.daterangepicker', function(ev, picker) {
    $(this).closest('date-range-picker').find('.date_from').val(picker.startDate.format('YYYY-MM-DD'));
    $(this).closest('date-range-picker').find('.date_to').val(picker.endDate.format('YYYY-MM-DD'));
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
    return registeredUserTable.ajax.reload();
  });

  $('.jobs-table').closest('.row').addClass('overflow-table');

  $('.admin-job-role-search').multiselect({
    buttonContainer: '<span></span>',
    buttonClass: '',
    maxHeight: 200,
    templates: {
      button: '<span class="multiselect dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i></span>'
    },
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true
  });

  $('.date-range').daterangepicker({
    autoUpdateInput: false,
    maxDate: moment()
  });

  $('.date-range').on('apply.daterangepicker', function(ev, picker) {
    $(this).closest('.date-range-picker').find('.date-from').val(picker.startDate.format('YYYY-MM-DD'));
    $(this).closest('.date-range-picker').find('.date-to').val(picker.endDate.format('YYYY-MM-DD'));
    $(this).val(picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY'));
    return registeredUserTable.ajax.reload();
  });

  $('body').on('click', '.clear-date', function() {
    $(this).closest('div').find('.date-from').val('');
    $(this).closest('div').find('.date-to').val('');
    $(this).closest('div').find('.date-range').val('');
    return registeredUserTable.ajax.reload();
  });

}).call(this);
