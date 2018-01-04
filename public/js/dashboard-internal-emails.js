(function() {
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

  $('body').on('click', '#mail-check', function() {
    var entry, i, j, loc_area_array, loc_city_array, type, url;
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
      url = document.head.querySelector('[property="mail-count"]').content;
      return $.ajax({
        url: url,
        type: 'post',
        data: {
          type: type,
          areas: loc_area_array,
          cities: loc_city_array
        },
        success: function(response) {
          return console.log(response);
        }
      });
    }
  });

}).call(this);
