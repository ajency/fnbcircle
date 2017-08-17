var change = 0;

$('body').on('change', 'input', function() {
    change=1;
  });
$('body').on('change', 'select', function() {
    change=1;
  });
console.log(change);
function listingInformation() {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/listing");
    var contacts = {};
    var contact_IDs = document.getElementsByName("contact_IDs");
    var value = document.getElementsByName("contacts");
    var contact_verified = document.getElementsByName("verified_contact");
    var contact_visible = document.getElementsByName("visible_contact");
    var i = 0;
    while (i < contact_IDs.length) {
        if (value[i].value != "") {
            var contact = {};
            if($(value[i]).closest('.business-contact').hasClass('business-email')) var type = 1
            if($(value[i]).closest('.business-contact').hasClass('business-phone')) var type = 2
            if($(value[i]).closest('.business-contact').hasClass('landline')) var type = 3
            
                $.ajax({
                    type: 'post',
                    url: '/contact_save',
                    data: {
                        'value': value[i].value,
                        'type': type,
                        'id': contact_IDs[i].value
                    },
                    success: function(data) {
                        contact_IDs[i].value=data['id'];
                        console.log(data['id']);
                    },
                    async: false
                });
            
            contact['id'] = contact_IDs[i].value;
            // contact['email'] = emails[i].value;
            // contact['verify'] = (contact_verified[i].checked) ? "1" : "0";
            contact['visible'] = (contact_visible[i].checked) ? "1" : "0";
            contacts[i] = contact;
        }
        i++;
    }
    var parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-information';
    parameters['change'] = change;
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
    parameters['area'] = $('.area select').val();
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
    if (checkDuplicates()) return false;
    console.log(true);
    if (!instance.validate()) return false;
   $('.section-loader').removeClass('hidden');
    // console.log($('#listing_id').val());
    if ($('#listing_id').val() == "") {
        // console.log(true);
        var title = document.getElementsByName("listing_title")[0].value;
        var value = document.getElementsByName("contacts");
        var json = '[';
        for (var i = 0; i < value.length; i++) {
            if (value[i].value !== "") json += '{\"value\":\"' + value[i].value + '\"},'
        }
        json = json.slice(0, -1);
        json += ']';
        // console.log(json);
        $.ajax({
            type: 'post',
            url: '/duplicates',
            data: {
                'title': title,
                'contacts': json
            },
            success: function(data) {
                console.log(data);
                var myvar = '';
                for (var k in data) {
                    myvar += '<div class="list-row flex-row">' + '<div class="left">' + '<h5 class="sub-title text-medium text-capitalise list-title">' + data[k]['name'] + '</h5>';
                    for (var j in data[k]['messages']) {
                        myvar += '<p class="m-b-0 text-color text-left default-size">' + '<i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">' + data[k]['messages'][j] + '</span>' + '</p>';
                    }
                    myvar += '</div>' + '<div class="right">' + '<div class="capsule-btn flex-row">' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</a>' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border delete">Delete</a>' + '</div>' + '</div>' + '</div>';
                    // console.log(myvar);
                }
                $('.list-entries').html(myvar);
                if(myvar!=''){    
                    $('.section-loader').addClass('hidden');
                    $('#duplicate-listing').modal('show');
                    $('#duplicate-listing').on('hidden.bs.modal', function(e) {
                        event.preventDefault();
                        $('.section-loader').removeClass('hidden');
                        listingInformation();
                    });
                }else{
                    event.preventDefault();
                    $('.section-loader').removeClass('hidden');
                    listingInformation();
                }
            }

        });
        
    } else {
        // console.log(true);
         event.preventDefault();
        listingInformation();
    }
    event.preventDefault();
}
$('#info-form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});