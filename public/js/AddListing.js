(function() {
  var listingInformation, validateListing;

  listingInformation = function() {
    var i;
    var contact, contact_IDs, contact_verified, contact_visible, contacts, form, i, parameters, type, value;
    form = $('<form></form>');
    form.attr('method', 'post');
    form.attr('action', '/add_listing');
    contacts = {};
    contact_IDs = document.getElementsByName('contact_IDs');
    value = document.getElementsByName('contacts');
    contact_verified = document.getElementsByName('verified_contact');
    contact_visible = document.getElementsByName('visible_contact');
    i = 0;
    while (i < contact_IDs.length) {
      if (value[i].value !== '') {
        contact = {};
        contact['id'] = contact_IDs[i].value;
        contact['verify'] = contact_verified[i].checked ? '1' : '0';
        contact['visible'] = contact_visible[i].checked ? '1' : '0';
        contacts[i] = contact;
      }
      i++;
    }
    parameters = {};
    parameters['listing_id'] = null;
    parameters['step'] = 'listing_information';
    parameters['title'] = document.getElementsByName('listing_title')[0].value;
    type = document.getElementsByName('business_type');
    i = 0;
    while (i < type.length) {
      if (type[i].checked) {
        parameters['type'] = type[i].value;
      }
      i++;
    }
    parameters['primary_email'] = document.getElementsByName('primary_email')[0].checked ? '1' : '0';
    parameters['primary_phone'] = '0';
    parameters['contacts'] = JSON.stringify(contacts);
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr('type', 'hidden');
      field.attr('name', key);
      field.attr('value', value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    form.submit();
  };

  validateListing = function(event) {
    var instance;
    instance = $('#info-form').parsley();
    if (!instance.isValid()) {
      return false;
    }
    event.preventDefault();
    if ($('#listing_id').val() === '') {
      $('#duplicate-listing').modal('show');
      $('#duplicate-listing').on('hidden.bs.modal', function(e) {
        listingInformation();
      });
    } else {
      listingInformation();
    }
  };

}).call(this);
