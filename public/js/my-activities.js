(function() {
  var day, getUserActivities;

  day = "";

  getUserActivities = function() {
    var container, url;
    container = $('#recent-activity');
    url = document.head.querySelector('[property="get-activities-url"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        email: document.head.querySelector('[property="user-email"]').content,
        day: day
      },
      success: function(response) {
        var act, activity, key;
        if (Object.keys(response['data']).length === 0) {
          container.append('<div id="load-more-container">No activities found</div>');
        }
        $('#load-more-container').remove();
        for (key in response['data']) {
          if (!response['data'].hasOwnProperty(key)) {
            continue;
          }
          container.append('<p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> ' + key + '</span></p>');
          day = key;
          activity = response['data'][key];
          for (act in activity) {
            if (!activity.hasOwnProperty(act)) {
              continue;
            }
            container.append(activity[act]['html']);
          }
        }
        console.log(day);
        if (response['more'] > 0) {
          container.append('<div id="load-more-container"><button type="button" id="load-more-action">Load More</button></div>');
        }
      }
    });
  };

  getUserActivities();

  $('body').on('click', '#load-more-action', function() {
    return getUserActivities();
  });

}).call(this);
