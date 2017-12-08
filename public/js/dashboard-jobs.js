(function() {
  var displayCheckbox, jobsTable, updateStatusValues;

  jobsTable = $('#datatable-jobs').DataTable({
    'pageLength': 25,
    'processing': true,
    'serverSide': true,
    'bAutoWidth': false,
    'aaSorting': [[0, 'desc']],
    'drawCallback': function() {
      return displayCheckbox();
    },
    'ajax': {
      url: '/admin-dashboard/jobs/get-jobs',
      type: 'post',
      data: function(data) {
        var filters;
        filters = {};
        filters.job_name = $('#job_name').val();
        filters.company_name = $('#company_name').val();
        filters.job_status = $('select[name="job_status"]').val();
        filters.city = $('select[name="job_city"]').val();
        filters.category = $('select[name="job_category"]').val();
        filters.premium_request = $('select[name="premium_request"]').val();
        filters.keywords = $('select[name="job_keywords"]').val();
        filters.published_date_from = $('input[name="published_from"]').val();
        filters.published_date_to = $('input[name="published_to"]').val();
        filters.submission_date_from = $('input[name="submission_from"]').val();
        filters.submission_date_to = $('input[name="submission_to"]').val();
        data.filters = filters;
        return data;
      },
      error: function() {}
    },
    'columns': [
      {
        'data': 'id'
      }, {
        'data': 'city',
        "orderable": false
      }, {
        'data': 'title',
        "orderable": false
      }, {
        'data': 'business_type',
        "orderable": false
      }, {
        'data': 'keyword',
        "orderable": false
      }, {
        'data': 'company_name',
        "orderable": false
      }, {
        'data': 'date_of_submission'
      }, {
        'data': 'published_date'
      }, {
        'data': 'last_updated'
      }, {
        'data': 'last_updated_by',
        "orderable": false
      }, {
        'data': 'premium_request',
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
        "width": "70px",
        "targets": 2
      }, {
        "width": "80px",
        "targets": 3
      }, {
        "width": "100px",
        "targets": 4
      }, {
        "width": "60px",
        "targets": 5
      }, {
        "width": "100px",
        "targets": 6
      }, {
        "width": "70px",
        "targets": 7
      }, {
        "width": "90px",
        "targets": 8
      }, {
        "width": "80px",
        "targets": 9
      }, {
        "width": "75px",
        "targets": 10
      }, {
        "width": "70px",
        "targets": 11
      }
    ]
  });

  jobsTable.columns().iterator('column', function(ctx, idx) {
    $(jobsTable.column(idx).header()).append('<span class="sort-icon"/>');
  });

  $('.jobsearchinput').change(function() {
    jobsTable.ajax.reload();
  });

  $('.jobstrsearchinput').keyup(function() {
    jobsTable.ajax.reload();
  });

  $('#datatable-jobs').on('click', '.update_status', function() {
    var id, job_link, job_name, status_id;
    id = $(this).attr('job-id');
    status_id = $(this).attr('job-status');
    job_name = $(this).attr('job-name');
    job_link = $(this).attr('job-link');
    $("#job_id").val(id);
    $("span[id='job-title']").html('<a  href="' + job_link + '"  target="_blank" >' + job_name + '</a>');
    $(".update-error").text('');
    $(".job-status").val('');
    updateStatusValues(status_id, 'update-job-status');
  });

  updateStatusValues = function(status_id, className) {
    var can_change_status;
    console.log(className);
    can_change_status = _.pluck(avail_status, status_id);
    can_change_status = _.first(can_change_status);
    $('.' + className + ' > option').each(function() {
      console.log(can_change_status);
      console.log($(this).val());
      if ($(this).val() !== "") {
        if (_.contains(can_change_status, parseInt($(this).val()))) {
          return $(this).removeClass('hidden');
        } else {
          return $(this).addClass('hidden');
        }
      }
    });
  };

  $('body').on('click', '.reset-filters', function() {
    $('#job_name').val('');
    $('#company_name').val('');
    $('select[name="job_status"]').val('');
    $('select[name="job_city"]').val('');
    $('.date-from').val('');
    $('.date-to').val('');
    $('.date-range').val('');
    $('.multi-dd').each(function() {
      $(this).multiselect('deselectAll', false).change();
      return $('.admin-job-role-search').each(function() {
        return $(this).multiselect('deselectAll', false).change();
      });
    });
    jobsTable.ajax.reload();
  });

  $('body').on('click', 'input[name="job_check_all"]', function() {
    console.log("job_check_all");
    if ($(this).is(':checked')) {
      return $('input[name="job_check[]"]').prop('checked', true);
    } else {
      return $('input[name="job_check[]"]').prop('checked', false);
    }
  });

  $('body').on('click', 'input[name="job_check[]"]', function() {
    var allchecked;
    console.log("job_check_all");
    allchecked = true;
    $('input[name="job_check[]"]').each(function() {
      if (!$(this).is(':checked')) {
        return allchecked = false;
      }
    });
    if (allchecked) {
      return $('input[name="job_check_all"]').prop('checked', true);
    } else {
      return $('input[name="job_check_all"]').prop('checked', false);
    }
  });

  $('body').on('click', '#bulkupdate', function() {
    var jobCheck, jobcheckall, new_status_id, old_status_id;
    jobCheck = '';
    $(".bulk-update-error").text('');
    if ($('input[name="job_check_all"]').is(':checked')) {
      jobcheckall = 1;
    } else {
      jobcheckall = 0;
      $('input[name="job_check[]"]').each(function() {
        if ($(this).is(':checked')) {
          return jobCheck += $(this).val() + ',';
        }
      });
    }
    new_status_id = $('.bulk-update-job-status').val();
    old_status_id = $('select[name="job_status"]').val()[0];
    if (new_status_id === "") {
      $(".bulk-update-error").text('Please select status');
    } else if (jobcheckall === 0 && jobCheck === '') {
      return $(".bulk-update-error").text('Please select jobs to change status');
    } else {
      return $.ajax({
        type: 'post',
        url: '/admin-dashboard/jobs/bulk-update-job-status',
        data: {
          'new_status_id': parseInt(new_status_id),
          'old_status_id': parseInt(old_status_id),
          'jobcheckall': jobcheckall,
          'job_check_ids': jobCheck
        },
        success: function(data) {
          if (data.status) {
            $('.alert-success #message').html("Job status updated successfully.");
            $('.alert-success').addClass('active');
            setTimeout((function() {
              $('.alert-success').removeClass('active');
            }), 2000);
            return jobsTable.ajax.reload();
          } else {
            $('.alert-failure #message').html("Failed to updated job status.");
            $('.alert-failure').addClass('active');
            return setTimeout((function() {
              $('.alert-failure').removeClass('active');
            }), 2000);
          }
        }
      });
    }
  });

  displayCheckbox = function() {
    var serachStatus, status_id;
    serachStatus = $('select[name="job_status"]').val();
    if (serachStatus.length === 1) {
      $('input[name="job_check[]"]').removeClass('hidden').prop('checked', false);
      $('input[name="job_check_all"]').removeClass('hidden').prop('checked', false);
      status_id = parseInt(serachStatus[0]);
      return updateStatusValues(status_id, 'bulk-update-job-status');
    } else {
      $('input[name="job_check[]"]').addClass('hidden').prop('checked', false);
      return $('input[name="job_check_all"]').addClass('hidden').prop('checked', false);
    }
  };

  $('#updateStatusModal').on('click', '#change_status', function() {
    var jobId, jobstatus, jobstatusText;
    jobId = $("#job_id").val();
    jobstatus = $(".job-status option:selected").val();
    jobstatusText = $(".job-status option:selected").text();
    console.log(jobstatus);
    if (jobstatus === "") {
      return $(".update-error").text('Please select status');
    } else {
      return $.ajax({
        type: 'post',
        url: '/admin-dashboard/jobs/update-job-status',
        data: {
          'job_id': jobId,
          'job_status': jobstatus
        },
        success: function(data) {
          if (data.status) {
            $('span[status_value="' + jobId + '"]').text(jobstatusText);
            $('a[job-id="' + jobId + '"]').attr('job-status', jobstatus);
            $('.alert-success #message').html("Job status updated successfully.");
            $('.alert-success').addClass('active');
            jobsTable.ajax.reload();
            setTimeout((function() {
              $('.alert-success').removeClass('active');
            }), 2000);
          } else {
            $('.alert-failure #message').html("Failed to updated job status.");
            $('.alert-failure').addClass('active');
            setTimeout((function() {
              $('.alert-failure').removeClass('active');
            }), 2000);
            $("#status-failure").modal('show');
            $("#status-failure").find('.job-title').attr('href', data.link);
            $("#status-failure").find('.job-title').html(data.name);
          }
          $('#updateStatusModal').modal('hide');
        },
        error: function(request, status, error) {
          throwError();
        }
      });
    }
  });

  $('.date_range_picker').on('apply.daterangepicker', function(ev, picker) {
    $(this).closest('date-range-picker').find('.date_from').val(picker.startDate.format('YYYY-MM-DD'));
    $(this).closest('date-range-picker').find('.date_to').val(picker.endDate.format('YYYY-MM-DD'));
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
    return jobsTable.ajax.reload();
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
    return jobsTable.ajax.reload();
  });

  $('body').on('click', '.clear-date', function() {
    $(this).closest('div').find('.date-from').val('');
    $(this).closest('div').find('.date-to').val('');
    $(this).closest('div').find('.date-range').val('');
    return jobsTable.ajax.reload();
  });

}).call(this);
