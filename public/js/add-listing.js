(function() {
  var $_GET, mapaddr, submitForm, throwError;

  $('body').on('click', '.gs-next', function() {
    return $('.gs-steps > .active').next('li').find('a').trigger('click');
  });

  $('body').on('click', '.gs-prev', function() {
    return $('.gs-steps > .active').prev('li').find('a').trigger('click');
  });

  $('.dropify').dropify({
    messages: {
      'default': 'Add Photo'
    }
  });

  window.slugify = function(string) {
    return string.toString().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
  };

  $('body').on('click', '.tips', function() {
    $(this).toggleClass('open');
    return $('.tips__steps.collapse').collapse('toggle');
  });

  $('.sample-img').magnificPopup({
    items: {
      src: 'img/sample_listing.png'
    },
    type: 'image',
    mainClass: 'mfp-fade'
  });

  $('body').on('change', 'input:checkbox.all-cities', function() {
    if ($(this).is(':checked')) {
      return $(this).closest('.tab-pane').find('input:checkbox').prop('checked', true);
    } else {
      return $(this).closest('.tab-pane').find('input:checkbox').prop('checked', false);
    }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $('body').on('click', '.add-highlight', function() {
    var highlight_group, highlight_group_clone;
    highlight_group = $(this).closest('.highlight-input-group');
    highlight_group_clone = highlight_group.clone();
    highlight_group_clone.find('.add-highlight').remove();
    highlight_group_clone.find('.delete-highlight').removeClass('hidden');
    highlight_group_clone.insertBefore(highlight_group);
    return highlight_group.find('.highlight-input').val('');
  });

  $('body').on('click', '.delete-highlight', function() {
    return $(this).closest('.highlight-input-group').remove();
  });

  $(document).on('click', 'a.review-submit-link', function(e) {
    window.submit = 1;
    return submitForm(e);
  });

  $(document).on('click', '.full.save-btn.gs-next', function(e) {
    return submitForm(e);
  });

  submitForm = function(e) {
    var step;
    step = $('input#step-name').val();
    e.preventDefault();
    if (step === 'business-information') {
      window.validateListing(e);
    }
    if (step === 'business-categories') {
      return validateCategories();
    }
  };

  $_GET = [];

  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value) {
    $_GET[name] = value;
  });

  if ($_GET['review'] !== void 0) {
    console.log($_GET['review']);
    $('#listing-review').modal('show');
  }

  if ($_GET['success'] !== void 0) {
    setTimeout((function() {
      $('.alert-success').addClass('active');
    }), 1000);
    setTimeout((function() {
      $('.alert-success').removeClass('active');
    }), 6000);
  }

  if ($('.alert.alert-failure.server-error').length !== 0) {
    setTimeout((function() {
      $('.alert-failure').addClass('active');
    }), 1000);
    setTimeout((function() {
      $('.alert-failure').removeClass('active');
    }), 6000);
  }

  mapaddr = $('.location-val').val();

  $('.save-addr').on('change', function() {
    if (this.checked) {
      $('.another-address').val(mapaddr);
    } else {
      $('.another-address').val('');
    }
  });

  $('.hours-display').change(function() {
    if ($('.dont-display').is(':checked')) {
      $('.hours-list').addClass('disable-hours');
      $('.fnb-select').prop('selectedIndex', 0);
    } else {
      $('.hours-list').removeClass('disable-hours');
    }
  });

  throwError = function() {
    $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please <a href="/login" class="secondary-link">login</a> or refresh your page</div>');
    return $('.alert-failure').addClass('active');
  };

  return;

}).call(this);
