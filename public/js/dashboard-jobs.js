(function() {
  var displayCheckbox, jobsTable, updateStatusValues;

  jobsTable = $('#datatable-jobs').DataTable({
    'pageLength': 25,
    'processing': true,
    'serverSide': true,
    'bAutoWidth': false,
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
        filters.keywords = $('select[name="job_keywords"]').val();
        data.filters = filters;
        return data;
      },
      error: function() {}
    },
    'columns': [
      {
        'data': '#',
        "orderable": false
      }, {
        'data': 'city',
        "orderable": false
      }, {
        'data': 'title'
      }, {
        'data': 'business_type',
        "orderable": false
      }, {
        'data': 'keyword',
        "orderable": false
      }, {
        'data': 'company_name'
      }, {
        'data': 'date_of_submission'
      }, {
        'data': 'published_date'
      }, {
        'data': 'last_updated'
      }, {
        'data': 'last_updated_by'
      }, {
        'data': 'status'
      }
    ]
  });

  $('.jobsearchinput').change(function() {
    jobsTable.ajax.reload();
  });

  $('#datatable-jobs').on('click', '.update_status', function() {
    var id, job_name, status_id;
    id = $(this).attr('job-id');
    status_id = $(this).attr('job-status');
    job_name = $(this).attr('job-name');
    $("#job_id").val(id);
    $("span[id='job-title']").text(job_name);
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
    $('.multi-dd').each(function() {
      return $(this).multiselect('deselectAll', false).change();
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
            $('.bulk-status-update').addClass('hidden');
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
      $(".bulk-status-update").removeClass('hidden');
      status_id = parseInt(serachStatus[0]);
      return updateStatusValues(status_id, 'bulk-update-job-status');
    } else {
      $('input[name="job_check[]"]').addClass('hidden').prop('checked', false);
      $('input[name="job_check_all"]').addClass('hidden').prop('checked', false);
      return $(".bulk-status-update").addClass('hidden');
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
            setTimeout((function() {
              $('.alert-success').removeClass('active');
            }), 2000);
          } else {
            $('.alert-failure #message').html("Failed to updated job status.");
            $('.alert-failure').addClass('active');
            setTimeout((function() {
              $('.alert-failure').removeClass('active');
            }), 2000);
          }
          $('#updateStatusModal').modal('hide');
        },
        error: function(request, status, error) {
          throwError();
        }
      });
    }
  });

}).call(this);
