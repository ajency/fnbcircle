(function() {
  var end_date, getSelectedFilters, start_date;

  start_date = "";

  end_date = "";

  $('body').on('change', '#internal-email-type', function() {
    var url;
    if (this.value !== "") {
      url = document.head.querySelector('[property="mailtype-change-url"]').content;
      return $.ajax({
        type: 'post',
        url: url,
        data: {
          type: this.value
        },
        success: function(response) {
          $('#filter-area').html(response);
          $('#submissionDate').daterangepicker({
            autoUpdateInput: false,
            maxDate: moment()
          });
          start_date = "";
          end_date = "";
          $('#submissionDate').on('apply.daterangepicker', function(ev, picker) {
            $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            start_date = picker.startDate.format('YYYY-MM-DD');
            return end_date = picker.endDate.format('YYYY-MM-DD');
          });
          return $('select[name="listing_source"],select[name="description"]').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Type'
          });
        }
      });
    }
  });

  $('body').on('show.bs.modal', '#category-select', function() {
    return getCategoryDom("#category-select #level-one-category-dom", "level_1");
  });

  getSelectedFilters = function(url_check) {
    var description_filter, entry, i, j, loc_area_array, loc_city_array, source_filter, type, url_count, url_send;
    type = $('input[name="mail-type"]').val();
    if (type === 'draft-listing-active' || type === 'draft-listing-inactive') {
      source_filter = $('select[name="listing_source"]').val();
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
      console.log('cities=', loc_city_array);
      console.log('areas=', loc_area_array);
      url_count = document.head.querySelector('[property="mail-count"]').content;
      url_send = document.head.querySelector('[property="mail-send"]').content;
      switch (url_check) {
        case url_count:
          $.ajax({
            url: url_count,
            type: 'post',
            data: {
              type: type,
              areas: loc_area_array,
              cities: loc_city_array,
              categories: JSON.stringify(getLeafNodes()),
              source: source_filter
            },
            success: function(response) {
              if (type === 'draft-listing-active') {
                $('#confirm-mail-message').html('There are total ' + response['email_count'] + ' active users whose listings are in draft. Are you sure you want to send email to all the users?');
              } else if (type === 'draft-listing-inactive') {
                $('#confirm-mail-message').html('There are total ' + response['email_count'] + ' inactive users whose listings are in draft. Are you sure you want to send email to all the users?');
              }
              return $('#confirmBox').modal('show');
            }
          });
          return;
        case url_send:
          $.ajax({
            url: url_send,
            type: 'post',
            data: {
              type: type,
              areas: loc_area_array,
              cities: loc_city_array,
              categories: JSON.stringify(getLeafNodes()),
              source: source_filter
            },
            success: function(response) {
              $('#email-sent-message').html('Email will be sent in the background to ' + response['email_count'] + ' users.');
              return $('#messageBox').modal('show');
            }
          });
          return;
      }
    }
    if (type === 'user-activate') {
      description_filter = $('select[name="description"]').val();
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
      console.log(description_filter);
      url_count = document.head.querySelector('[property="mail-count"]').content;
      url_send = document.head.querySelector('[property="mail-send"]').content;
      switch (url_check) {
        case url_count:
          $.ajax({
            url: url_count,
            type: 'post',
            data: {
              type: type,
              areas: loc_area_array,
              cities: loc_city_array,
              description: description_filter,
              start: start_date,
              end: end_date
            },
            success: function(response) {
              $('#confirm-mail-message').html('There are total ' + response['email_count'] + ' inactive users.Are you sure you want to send email to all the users?');
              return $('#confirmBox').modal('show');
            }
          });
          break;
        case url_send:
          $.ajax({
            url: url_send,
            type: 'post',
            data: {
              type: type,
              areas: loc_area_array,
              cities: loc_city_array,
              description: description_filter,
              start: start_date,
              end: end_date
            },
            success: function(response) {
              $('#email-sent-message').html('Email will be sent in the background to ' + response['email_count'] + ' users.');
              return $('#messageBox').modal('show');
            }
          });
      }
    }
  };

  $('body').on('click', '#mail-check', function() {
    var url;
    url = document.head.querySelector('[property="mail-count"]').content;
    return getSelectedFilters(url);
  });

  $('body').on('click', '#send-mail-confirm', function() {
    var url;
    $('#confirmBox').modal('hide');
    url = document.head.querySelector('[property="mail-send"]').content;
    return getSelectedFilters(url);
  });

}).call(this);
