function listingInformation() {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/add_listing");
    var contacts = {};
    var contact = {};
    // contact['id'] = "1";
    // contact['verify'] = "0";
    // contact['visible'] = "1";
    // contacts[0] = contact;
    // contact['id'] = "1";
    // contact['verify'] = "1";
    // contact['visible'] = "0";
    // contacts[0] = contact;
    var email_IDs=document.getElementsByName("email_IDs");
    var emails=document.getElementsByName("emails");
    var email_verified=document.getElementsByName("verified_emails");
    var email_visible=document.getElementsByName("visible_emails");
    for (var i = 0; i < emails.length; i++) {
        contact['id']=email_IDs[i].value;
        contact['email']=emails[i].value;
        contact['verify']=(email_verified[i].checked)?1:0;
        contact['visible']=(email_visible[i].checked)?1:0;
        contacts[i]=contact;
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
    parameters['primary_email'] = (document.getElementsByName("primary_email")[0].checked)?1:0;
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
    // $(document.body).append(form);
    // form.submit();
}