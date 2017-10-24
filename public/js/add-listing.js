(function() {
  var $_GET, getID, previewL, submitForm;

  $('body').on('click', '.gs-next', function() {
    return $('.gs-steps > .active').next('li').find('a').trigger('click');
  });

  $('body').on('click', '.gs-prev', function() {
    return $('.gs-steps > .active').prev('li').find('a').trigger('click');
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

  $(document).on('click', 'a.review-submit-link', function(e) {
    window.submit = 1;
    return submitForm(e);
  });

  $(document).on('click', 'a.archive-submit-link', function(e) {
    window.archive = 1;
    return submitForm(e);
  });

  $(document).on('click', 'a.publish-submit-link', function(e) {
    window.publish = 1;
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
      validateCategories();
    }
    if (step === 'business-location-hours') {
      validateLocationHours();
    }
    if (step === 'business-details') {
      validateBusinessDetails();
    }
    if (step === 'business-photos-documents') {
      validatePhotosDocuments();
    }
    if (step === 'business-premium') {
      validatePremium();
    }
    if (step === 'business-updates') {
      return updateActions();
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

  if ($(window).width() > 769) {
    getID = $('.gs-form .tab-pane').attr('id');
    $('.gs-steps .form-toggle').each(function() {
      if ($(this).attr('id') === getID) {
        $(this).parent().addClass('active');
      }
    });
  }

  $('body').on('click', '.review-submit', function(e) {
    e.preventDefault();
    $('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary');
    $('.draft-status').attr('data-original-title', 'Listing is under process');
    return $(this).addClass('hidden');
  });

  previewL = $('.detach-preview').detach();

  $('.preview-detach').append(previewL);

  window.throwError = function() {
    $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please <a href="/login" class="secondary-link">login</a> or refresh your page</div>');
    return $('.alert-failure').addClass('active');
  };

  return;

}).call(this);
