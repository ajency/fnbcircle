(function() {
  var profileWidth;

  $('.activity-action .toggle__check').change(function() {
    if ($(this).is(':checked')) {
      $('.recent-activity').addClass('checked');
      $('.all-activity').removeClass('checked');
    } else {
      $('.all-activity').addClass('checked');
      $('.recent-activity').removeClass('checked');
    }
  });

  if ($(window).width() > 769) {
    profileWidth = $('.fixed-profile-info').outerWidth();
    $('.person-info').css({
      'width': profileWidth - 60
    });
  }

}).call(this);
