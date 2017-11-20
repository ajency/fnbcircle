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
        for (key in response) {
          if (!response.hasOwnProperty(key)) {
            continue;
          }
          console.log(key);
          container.append('<p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> ' + key + '</span></p>');
          day = key;
          activity = response[key];
          for (act in activity) {
            if (!activity.hasOwnProperty(act)) {
              continue;
            }
            container.append(activity[act]['html']);
          }
        }
      }
    });
  };

  getUserActivities();

}).call(this);
