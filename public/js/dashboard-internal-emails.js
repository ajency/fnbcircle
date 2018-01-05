(function() {
  var getSelectedFilters;

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
          console.log(response);
          $('#filter-area').html(response);
          $('#submissionDate').daterangepicker({
            autoUpdateInput: false,
            maxDate: moment()
          });
          return $('#submissionDate').on('apply.daterangepicker', function(ev, picker) {
            return $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
          });
        }
      });
    }
  });

  $('body').on('show.bs.modal', '#category-select', function() {
    return getCategoryDom("#category-select #level-one-category-dom", "level_1");
  });

  getSelectedFilters = function(url_check) {
    var entry, i, j, loc_area_array, loc_city_array, type, url_count, url_send;
    type = $('input[name="mail-type"]').val();
    if (type === 'draft-listing-active' || 'draft-listing-inactive') {
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
              cities: loc_city_array
            },
            success: function(response) {
              console.log(response);
              $('#user_number').html(response['email_count']);
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
              cities: loc_city_array
            },
            success: function(response) {
              console.log(response);
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
