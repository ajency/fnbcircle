(function() {
  var day, getUserActivities;

  day = "";

  getUserActivities = function() {
    var container, url;
    container = $('#recent-activity');
    url = document.head.querySelector('[property="get-activities-url"]').content;
    $('.post-loader').removeClass('hidden');
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
          container.append('<div id="load-more-container" class="heavier sub-title text-center text-color m-t-30"><i class="fa fa-frown-o p-r-5 text-darker" aria-hidden="true"></i> No activities found</div>');
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
          container.append('<div id="load-more-container"><div class="text-center text-primary m-t-20 hidden post-loader"><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></div><button type="button" id="load-more-action">Load More</button></div>');
        }
      }
    });
  };

  getUserActivities();

  setTimeout((function() {
    $('[data-toggle="tooltip"]').tooltip();
  }), 1000);

  $('body').on('click', '#load-more-action', function() {
    return getUserActivities();
  });

}).call(this);
