(function() {
  var loadUpdates, offset, order;

  $('#shareRoundIcons').jsSocials({
    showLabel: false,
    showCount: false,
    shares: ['email', 'twitter', 'facebook', 'googleplus', 'linkedin', 'pinterest', 'stumbleupon', 'whatsapp']
  });

  offset = 0;

  order = 0;

  loadUpdates = function() {
    return $.ajax({
      url: document.head.querySelector('[property="get-posts-url"]').content,
      type: 'get',
      data: {
        'type': 'listing',
        'id': document.getElementById('listing_id').value,
        'offset': offset,
        'order': order
      },
      success: function(data) {
        var button, html;
        if (data['status'] === '200') {
          $('.update-display-section').find('.view-more-updates').remove();
          if (data['data']['updates'].length !== 0) {
            offset += data['data']['updates'].length;
            html = '';
            $.each(data['data']['updates'], function(i, element) {
              html += '<div class="update-sec sidebar-article"> <div class="update-sec__body update-space"> <p class="element-title update-sec__heading m-t-15 bolder">' + element.title + '</p> <p class="update-sec__caption text-lighter">' + element.contents + '</p> <ul class="flex-row update-img">';
              $.each(element.images, function(j, item) {
                html += '<li><img src="' + item['200x150'] + '" alt="" width="80"></li>';
              });
              return html += '</ul> <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted on ' + element.updated + '</p> </div> </div>';
            });
            $('.update-display-section').append(html);
            if (data['data']['updates'].length === 5) {
              button = '<div class="m-t-10 text-center view-more-updates"> <a href="#" class="btn fnb-btn secondary-btn full border-btn default-size">+ View More</a> </div>';
              return $('.update-display-section').append(button);
            }
          }
        }
      }
    });
  };

  $('body').on('click', '.view-updates', function() {
    offset = 0;
    order = 0;
    $('select[name="update-sort"]').val('0');
    $('.update-display-section').html('');
    return loadUpdates();
  });

  $('body').on('change', 'select[name="update-sort"]', function() {
    order = this.value;
    offset = 0;
    $('.update-display-section').html('');
    return loadUpdates();
  });

  $('body').on('click', '.view-more-updates a', function() {
    return loadUpdates();
  });

}).call(this);
