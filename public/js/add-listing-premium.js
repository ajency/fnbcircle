(function() {
  $('input[type=radio][name=plan-select]').change(function() {
    if ($(this).is(':checked')) {
      $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass('active');
      if ($(this).closest('.pricing-table__cards').hasClass('free-plan')) {
        $('#subscribe-btn').prop('disabled', true);
      } else {
        $('#subscribe-btn').prop('disabled', false);
      }
    }
  });

  $('body').on('click', '#subscribe-btn', function(e) {
    var planID, url;
    planID = $('input[type=radio][name=plan-select]:checked').val();
    if (confirm('are you sure?')) {
      url = document.head.querySelector('[property="premium-url"]').content;
      $.ajax({
        type: 'post',
        url: url,
        data: {
          'plan_id': planID,
          'type': 'listing',
          'id': document.getElementById('listing_id').value
        },
        success: function(data) {
          if (data['status'] === '200') {
            $('#pending-request').html('(Request Pending)');
            return $('#subscribe-btn').remove();
          }
        }
      });
      return console.log('request sent of plan' + planID);
    }
  });

  $('input[type=radio][name=plan-select]').change();

}).call(this);
