(function() {
  var filterJobs;

  filterJobs = function() {
    return $.ajax({
      type: 'post',
      url: 'jobs/get-filtered-jobs',
      data: {
        'job_name': '',
        'company_name': '',
        'job_status': '',
        'city': '',
        'category': '',
        'keywords': ''
      },
      success: function(data) {},
      error: function(request, status, error) {
        throwError();
      }
    });
  };

}).call(this);
