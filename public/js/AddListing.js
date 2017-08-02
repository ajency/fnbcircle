function listingInformation() {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/add_listing");
    var contacts = {};
    var contact_IDs = document.getElementsByName("contact_IDs");
    var value = document.getElementsByName("contacts");
    var contact_verified = document.getElementsByName("verified_contact");
    var contact_visible = document.getElementsByName("visible_contact");
    var i = 0;
    while (i < contact_IDs.length) {
        if (value[i].value != "") {
            var contact = {};
            contact['id'] = contact_IDs[i].value;
            // contact['email'] = emails[i].value;
            contact['verify'] = (contact_verified[i].checked) ? "1" : "0";
            contact['visible'] = (contact_visible[i].checked) ? "1" : "0";
            contacts[i] = contact;
        }
        i++;
    }
    var parameters = {};
    parameters['listing_id'] = null;
    parameters['step'] = 'listing_information';
    parameters['title'] = document.getElementsByName("listing_title")[0].value;
    var type = document.getElementsByName("business_type");
    for (var i = 0; i < type.length; i++) {
        if (type[i].checked) {
            parameters['type'] = type[i].value;
        }
    }
    // parameters['type'] = '11';
    parameters['primary_email'] = (document.getElementsByName("primary_email")[0].checked) ? "1" : "0";
    parameters['primary_phone'] = '0';
    parameters['contacts'] = JSON.stringify(contacts);
    $.each(parameters, function(key, value) {
        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);
        form.append(field);
        console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    form.submit();
}

function validateListing(event) {
    var instance = $('#info-form').parsley();
    if (!instance.isValid()) return false;
    event.preventDefault();
    if ($('#listing_id').val() == "") {
        // console.log(true);
        $('#duplicate-listing').modal('show');
        $('#duplicate-listing').on('hidden.bs.modal', function(e) {

            listingInformation();
        });
    } else {
        // console.log(true);
        listingInformation();
    }
}

function contact_submit(event) {
     $('.verify-click').click(function(){
        event.preventDefault();
        var test = $(this).closest('.test-row').find('.fnb-input').val();
        console.log(test);
    });
}