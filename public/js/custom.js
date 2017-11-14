
$(function(){

	$("#login-modal").on('shown.bs.modal', function() {
		var url = '';

		$('#login-modal .login-container .alternate-login').keypress(function(e){
		 	if(e.which == 13){//Enter key pressed
	            $("#login_form_modal_btn").trigger('click'); // Trigger the Login button
	        }
	    });

		$('#login-modal .forget-password').keypress(function(e){
		 	if(e.which == 13){//Enter key pressed
	            $("#forgot-password-form-btn").trigger('click'); // Trigger the Forgot button
	            e.preventDefault();
	        }
	    });


		if (window.location.search && window.location.search.indexOf("login=") < 0) {
			url = window.location.search + '&login=true';
		} else if (!window.location.search) {
			url = '?login=true';
		}

		if (window.location.hash) {
			url += window.location.hash;
		}

		window.history.pushState('', '', url);
	});

	$("#login-modal").on('hidden.bs.modal', function() {
		var url = '?';

		if (window.location.search.indexOf("login=") >= 0) {
			var url_split = window.location.search.split('?')[1].split('&');
			for(i = 0; i < url_split.length; i++) {
				if(url_split[i] != "login=true" && url_split[i].indexOf("message=") < 0) { // Remove 'login' & 'message' Params
					url += (url == '?' ? '?': '&') + url_split[i];
				}
			}
		} else {
			url = window.location.search;
		}

		// Some pages are adding "??" on modal close //
		url = url.replace("??", "?");

		if (window.location.hash) {
			url += window.location.hash;
		}

		window.history.pushState('', '', url);
	});

	$('.alert').on('closed.bs.alert', function (e) {
       var url = '/';

		if (window.location.search.indexOf("message=") >= 0) {
			var url_split = window.location.search.split('?')[1].split('&');
			for(i = 0; i < url_split.length; i++) {
				if(url_split[i].indexOf("message=") < 0) { // Remove 'login' & 'message' Params
					url += (url == '/' ? '?': '&') + url_split[i];
				}
			}
		} else {
			url = window.location.search;
		}

		if (window.location.hash) {
			url += window.location.hash;
		}

		window.history.pushState('', '', url); 
    });

	$(window).scroll(function (event) {
	    var scroll = $(window).scrollTop();
	    if($('.sticky-section').length){
		    $('.sticky-section').toggleClass('fixed',
		     //add 'ok' class when div position match or exceeds else remove the 'ok' class.
		      scroll >= $('.listed').offset().top - 100
		    );
	    }
	 //    if($('.sticky-section').hasClass('fixed')){

		// 	$('.enquiry-btn').show(300);
		// }
		// else{
		// 	$('.enquiry-btn').hide(300);
		// }
	});

	if ($(window).width() >= 769) {
		$(window).scroll(function() {
			var scroll = $(window).scrollTop();
			 //console.log(scroll);
			if (scroll >= 100) {
			    //console.log('a');
			    $(".trans-header").addClass("change");
			    $('.sticky-bottom').addClass('active');
			} else {
			    //console.log('a');
			    $(".trans-header").removeClass("change");
			    $('.sticky-bottom').removeClass('active');
			}
			if (scroll >= 10) {
			    $('.preview-header').addClass('active');
			} else {
			    $('.preview-header').removeClass('active');
			}
		});

		// Check if height is equal or greater then actual scroll

		var scrollHeader = $(window).scrollTop();

	    if(scrollHeader  > 100) {
	        $(".trans-header").addClass("change");
	    }
	    // calculate sticky preview height
		var previewHeight = $('.preview-header').outerHeight();
		$('.header-shifter').css('height',previewHeight);
	}


    // sticky bottom scroll

	if ($(window).width() < 769) {
		$(window).scroll(function() {
			var scroll = $(window).scrollTop();
			if (scroll >= 100) {
			    $('.sticky-bottom').addClass('active');
			} else {
			    $('.sticky-bottom').removeClass('active');
			}
			 if($(window).scrollTop() + $(window).height() > ($(document).height() - 100) ) {
       			$(".sticky-bottom").removeClass('active');
   			}
		});
		$('.tab-con').addClass('tab-content');
		$('.mobile-collapse').addClass('collapse');
	}


	// Custom menu click and scroll to particular ID

	var topMenu = jQuery(".nav-info__tabs"),
        offset = 15,
        topMenuHeight = topMenu.outerHeight()+offset,
        // All list items
        menuItems =  topMenu.find('a[href*="#"]'),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function(){
          var href = jQuery(this).attr("href"),
          id = href.substring(href.indexOf('#')),
          item = jQuery(id);
          //console.log(item)
          if (item.length) { return item; }
        });

    // so we can get a fancy scroll animation
    menuItems.click(function(e){
      var href = jQuery(this).attr("href"),
        id = href.substring(href.indexOf('#'));
          offsetTop = href === "#" ? 0 : jQuery(id).offset().top-topMenuHeight+10;
      jQuery('html, body').stop().animate({
          scrollTop: offsetTop
      }, 1000);
      e.preventDefault();
    });

    // Bind to scroll
    jQuery(window).scroll(function(){
       // Get container scroll position
       var fromTop = jQuery(this).scrollTop()+topMenuHeight;

       // Get id of current scroll item
       var cur = scrollItems.map(function(){
         if (jQuery(this).offset().top < fromTop)
           return this;
       });

       // Get the id of the current element
       cur = cur[cur.length-1];
       var id = cur && cur.length ? cur[0].id : "";

       menuItems.removeClass("active");
       if(id){
            menuItems.parent().end().filter("[href*='#"+id+"']").addClass("active");
       }

    });


    // Form id scroll

	$(".enquiry-btn").click(function() {
	    $('html, body').animate({
	        scrollTop: $(".enquiry-form").offset().top - 90
	    }, 2000);
	});


	// Go to map

	$(".map-link").click(function() {
	    $('html, body').animate({
	        scrollTop: $(".detail-3").offset().top
	    }, 2000);
	});

	// Go to enquiry form

	$(".send-enq").click(function() {
	    $('html, body').animate({
	        scrollTop: $(".send-enquiry-section").offset().top - 100
	    }, 2000);
	});

	// modify search click

	$(".modify-search").click(function() {
	    $('html, body').animate({
	        scrollTop: 0
	    }, 2000);
	});

	setTimeout((function() {
	  $('.page-shifter').addClass('animate-row');
	}), 2000);




	// Global tooltip call
	
	$('[data-toggle="tooltip"]').tooltip()

	// if($('.sticky-section').hasClass('fixed')){
	// 	alert();
	// 	$('.enquiry-btn').show(300);
	// }
	// else{
	// 	$('.enquiry-btn').hide(300);
	// }
	// if($('.description').length){
	// 	$('.description').readmore({
	// 	   speed: 25,
	// 	   collapsedHeight: 158,
	// 	   moreLink: '<a href="#" class="more default-size secondary-link">View more</a>',
	// 	   lessLink: '<a href="#" class="default-size less secondary-link">View Less</a>'
	// 	 });
	// }
	// Smooth scroll

	$("html").easeScroll();

	// Easing options

	// frameRate: 60,
 //  	animationTime: 1000,
 //  	stepSize: 120,
 //  	pulseAlgorithm: 1,
	// pulseScale: 8,
 //  	pulseNormalize: 1,
 //  	accelerationDelta: 20,
 //  	accelerationMax: 1,
 //  	keyboardSupport: true,
 //  	arrowScroll: 50,
 //  	touchpadSupport: true,
 //  	fixedBackground: true


	// Bootstrap Lightbox

	// $(document).on('click', '[data-toggle="lightbox"]', function(event) {
 	//    	event.preventDefault();
	//     $(this).ekkoLightbox();
	// });

		function validateEmail(email, error_path) { // Check if User has entered Email ID & is valid
			if(email.length > 0) {
				var email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if(email_re.test(email)) {
					$(error_path).addClass("hidden");
					return true;
				} else {
					$(error_path).removeClass("hidden").text("Please enter a valid Email ID");
					return false;
				}
			} else {
				$(error_path).removeClass("hidden").text("Please enter your Email address");
				return false;
			}
		}

		function validateContact(contact, error_path, region_code) { // Check if Contact Number entered is Valid
			contact = contact.replace(/\s/g, '').replace(/-/g,''); // Remove all the <spaces> & '-' 

			if((contact.indexOf("+") == 0 || !region_code) && !isNaN(contact.substring(1, contact.length))) {
				if (region_code)
					var contact_sub = contact.substring(1, contact.length); // Exclude the +
				else
					contact_sub = contact;

				if((!region_code && contact_sub.length <= 0) || (region_code && contact_sub.length <= 2)) {
					$(error_path).removeClass("hidden").text("Please enter your contact number");
				} else if(contact_sub.length < 10) {
					$(error_path).removeClass("hidden").text("Contact number too short");
				} else if((region_code && contact_sub.length > 13) || (!region_code && contact_sub.length > 10)) { // If excluding <region_code> & length is greater than 10, then
					$(error_path).removeClass("hidden").text("Contact number too long");
				} else {
					$(error_path).addClass("hidden");
					return true;
				}
			} else {
				$(error_path).removeClass("hidden").text("Please enter a valid Contact number");
			}
			return false;
		}

		function validatePassword(password, confirm_password, parent_path, child_path) {
			// Password should have 8 or more characters with atleast 1 lowercase, 1 UPPERCASE, 1 No or Special Chaaracter
			// var expression = /^(?=.*[0-9!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])(?!.*\s).{8,}$/;
			// Password should have 8 or more characters with 1 No
			var expression = /^(?=.*[0-9])(?=.*[^a-zA-Z])(?!.*\s).{8,}$/;
			var message = '', status = true;

			if(expression.test(password)) {
				if (confirm_password != '' && confirm_password == password) { // Confirm_password isn't empty & is Same
					status = true;
				} else if (confirm_password == '') { // Just validate Password
					status = true;
				} else { // confirm_password != '' && password != confirm_password
					message = "Password & Confirm Password are not matching";
					status = false;
				}
			} else { // Else password not Satisfied the criteria
				if(password.length > 0) {
					// message = "Please enter a password of minimum 8 characters and has atleast 1 lowercase, 1 UPPERCASE, and 1 Number or Special character";
					message = "Please enter a password of minimum 8 characters and has atleast 1 number.<br/><div class='note-popover popover top'><div class='arrow'></div> <div class='popover-content'><b class='fnb-errors'>Note:</b> Don’t use obvious passwords or easily guessable like your or your pet’s name. Also try and avoid using passwords you may have on a lot of other sites.</div></div>";
				} else {
					message = "Please enter a Password";
				}
				status = false;
			}

			if(!status && parent_path !== '') {
				$(parent_path + " " + child_path).removeClass('hidden').html(message);
			} else if(status && parent_path !== '') {
				//$(parent_path + " " + child_path).addClass('hidden');
				$(parent_path + " " + "#password_errors").addClass('hidden');
				$(parent_path + " " + "#password_confirm_errors").addClass('hidden');
			}
			return status;
		}

		function validateDropdown(path, error_path, error_msg) {
			if($(path).val() == '' || $(path).val == 0) {
				$(error_path).removeClass('hidden').text(error_msg);
				return false;
			} else {
				$(error_path).addClass('hidden');
				return true;
			}
		}

		function validateUser(data, parent_path) {
			var flag = true;

			if (data.hasOwnProperty("name") && !data["name"]) {
				$(parent_path + " #name-error").removeClass("hidden").text("Please enter your name");
				flag = false;
			} else {
				$(parent_path + " #name-error").addClass("hidden");
			}

			if (data.hasOwnProperty("email")) {
				flag = validateEmail(data["email"], parent_path + " #email-error");
			}

			if (data.hasOwnProperty('contact') && data["contact"]) { // The count includes +<region code> <contact No>
				validateContact(data["contact"], parent_path + " #contact-error", false);
			} else {
				$(parent_path + " #contact-error").removeClass("hidden").text("Please enter your contact");
				flag = false;
			}

			if (!(data.hasOwnProperty("description") && data["description"].length > 0)) { // If description doesn't exist or if exist & count <= 0, then return False
				$(parent_path + " #description-error").removeClass("hidden").text("Please select atleast one description.");
				flag = false;
			} else {
				$(parent_path + " #description-error").addClass("hidden");
			}

			if (data.hasOwnProperty("area") && data.hasOwnProperty("city") && data["area"] && data["city"]) {
				flag = flag ? true : false;
			} else {
				flag = validateDropdown(parent_path + " select[name='area']", parent_path + " label#area-error", "Please select a city") ? flag : false;
				flag = validateDropdown(parent_path + " select[name='city']", parent_path + " label#city-error", "Please select a state")? flag : false;
			}

			return flag;
		}

		function forgotPassword(email) {
			$("#forget-password-div #forgot-password-form-btn .fa-circle-o-notch").removeClass("hidden");

			$.ajax({
				type: 'post',
				url: '/forgot-password',
				data: {
					'email': email
				},
				success: function(data) {
					$("#forget-password-div #email-error-container").text("");
					$("#forget-password-div .forgot-link-sent").removeClass("hidden");
					$("#forget-password-div #forgot-password-form-btn .fa-circle-o-notch").addClass("hidden");

					$('#forget-password-div .forgot-link-sent').on('close.bs.alert', function (e) {
						$("#forget-password-div .forgot-link-sent").addClass("hidden");
						e.preventDefault();
					});

				},
				error: function(request, status, error) {
					$("#forget-password-div #forgot-password-form-btn .fa-circle-o-notch").addClass("hidden");
					console.log(status);
					console.log(error);
					if(request.responseJSON) {
						$("#forget-password-div #email-error-container").text(request.responseJSON["message"]);
					}
					//throw Error();
				}
			});

		}

		$(document).ready(function() {

			if($("#reset-password-form").length > 0) {
				/* Reset password form section */

				$("#reset-password-form input[type='password'][name='password']").on('focus, input', function(){
					// console.log(validatePassword($(this).val(), $("#reset-password-form input[type='password'][name='password_confirmation']").val()));
					if(!validatePassword($(this).val(), $("#reset-password-form input[type='password'][name='password_confirmation']").val(), "#reset-password-form", "#new-pass-error")) {
						return false;
					} else {
						$("#reset-password-form #new-pass-error").addClass("hidden");
						return true;
					}
				});

				/*$("#reset-password-form input[type='password'][name='password_confirmation']").on('focus, input', function(){
					// console.log(validatePassword($(this).val(), $("#reset-password-form input[type='password'][name='password_confirmation']").val()));
					if(!validatePassword($("#reset-password-form input[type='password'][name='password']").val(), $(this).val(), "#reset-password-form", "#confirm-password-error")) {
						// $("#reset-password-form #confirm-password-error").removeClass("hidden").text("Password and Confirm password are not matching");
						return false;
					} else {
						$("#reset-password-form #confirm-password-error").addClass("hidden");
						return true;
					}
				});*/
			}

			if(window.location.hash.length > 0 && window.location.hash.indexOf("_=_") > -1) { // If "_=_" exist in the URL (appears post FB login)
				hash_array = window.location.hash.split("_=_");
				window.location.hash = hash_array[0] + hash_array[1]; // Remove the _=_ from the URL
			}

			if ($("#register_form").length) { // Load only if #register_form exist in the Page
				$("#register_form input[name='contact']").intlTelInput(); // Initialize
			}

			if ($("#requirement_form").length && $("#requirement_form input[type='hidden'].contact-country-code").val().length <= 0) { // Load only if #register_form exist in the Page
				//$("#requirement_form input[name='contact']").intlTelInput(); // Initialize
				// Assign the country code to the hidden if the hidden tag is empty
				$("#requirement_form input[type='hidden'].contact-country-code").val($("#requirement_form input[name='contact']").intlTelInput("getSelectedCountryData").dialCode);
			}

			if($('.image-link').length){
			  $('.image-link').magnificPopup({type:'image'});
			}

			if($("#require-modal").length > 0) {

				// If the tel value is empty, then display an error message
				$("#require-modal #requirement_form a.contact-verify-link").on('click', function() {
					if($("#require-modal #requirement_form input[type='tel'][name='contact']").val().length <= 0) {
						$("#require-modal #requirement_form #contact-error").removeClass("hidden").val("Please enter the contact number");
					} else {
						$("#require-modal #requirement_form #contact-error").addClass("hidden");
					}
				});

				if($("#require-modal select[name='city']").val()) {
					// IF the State (City) value is available then populate the Select options for City (Area)
					var city, html = '<option value="">City</option>';
					
					$('#require-modal select[name="area"]').html(html);
					city = $("#require-modal select[name='city']").val();

					$.ajax({
						type: 'post',
						url: '/get_areas',
						data: {
							'city': city
						},
						success: function(data) {
							var key, area = $("#require-modal input[type='hidden'][name='user_area']").val();

							for (key in data) {
								if(area && area == data[key]["id"]) { // If inpput-hidden value exist & is matching, then "select" that option
									html += '<option value="' + data[key]["id"] + '" selected="true">' + data[key]["name"] + '</option>';
								} else {
									html += '<option value="' + data[key]["id"] + '">' + data[key]["name"] + '</option>';
								}
							}
							$('#require-modal select[name="area"]').html(html);
						},
						error: function(request, status, error) {
							throw Error();
						}
					});
				}
			}

			
			$("#require-modal, #register_form").on('change', "select[name='city']", function() {
				var city, html, parent = $(this).closest('form').prop('id'); // ger the closest form ID - as Register & Requirement has Form-ID
				html = '<option value="">City</option>';
				$('#' + parent + ' select[name="area"]').html(html);				
				city = $(this).val();

				if (city === '') {
					return;
				}

				return $.ajax({
					type: 'post',
					url: '/get_areas',
					data: {
						'city': city
					},
					success: function(data) {
						var key;
						for (key in data) {
							html += '<option value="' + data[key]["id"] + '">' + data[key]["name"] + '</option>';
						}
						$("#" + parent + ' select[name="area"]').html(html);
					},
					error: function(request, status, error) {
						throw Error();
					}
				});
			});

			$("#require-modal input[type='text'][name='name'], #register_form input[type='text'][name='name']").on('keyup change', function() { // Check Name
				var id = $(this).closest('form').prop('id');

				if($(this).val().length > 0) {
					$("#" + id + " #name-error").addClass("hidden");
				} else {
					$("#" + id + " #name-error").removeClass("hidden").text("Please enter your name");
				}
				
			});

			$("#require-modal input[type='text'][name='email'], #register_form input[type='email'][name='email'], #login_form_modal input[type='email'][name='email']").on('keyup change', function() { // Check Email
				var id = $(this).closest('form').prop('id');
				validateEmail($(this).val(), "#" + id + " #email-error");
			});

			$("#require-modal input[type='tel'][name='contact'], #register_form input[type='tel'][name='contact']").on('keyup change', function() { // Check Contact
				var id = $(this).closest('form').prop('id');
				validateContact($(this).val(), "#" + id + " #contact-error", false);
			});

			$("#require-modal select[name='city'], #register_form select[name='city']").on('change', function() { // Check if State is selected
				var id = $(this).closest('form').prop('id');

				if($(this).val() == "" || $(this).val().toLowerCase() == "state") {
					$("#" + id + " #city-error").removeClass("hidden").text("Please select a State");
				} else {
					$("#" + id + " #city-error").addClass("hidden");
				}
			});

			$("#require-modal select[name='area'], #register_form select[name='area']").on('change', function() { // Check if City is selected
				var id = $(this).closest('form').prop('id');

				if($(this).val() == "" || $(this).val().toLowerCase() == "city") {
					$("#" + id + " #area-error").removeClass("hidden").text("Please select a City");
				} else {
					$("#" + id + " #area-error").addClass("hidden");
				}
			});

			$("#require-modal input[type='checkbox'][name='description[]'], #register_form input[type='checkbox'][name='description[]']").on('change', function() { // Check if State is selected
				var id = $(this).closest('form').prop('id'), descr_values = [];

	            $.each($("#" + id + " input[name='description[]']:checked"), function() {
				  descr_values.push($(this).val());
				});

				if(descr_values.length > 0) {
					$("#" + id + " #description-error").addClass("hidden");
				} else {
					$("#" + id + " #description-error").removeClass("hidden").text("Please select atleast one description.");
				}
			});

			$("#register_form input[type='password'][name='password']").on('focusin, input', function(){
				// console.log(validatePassword($(this).val(), $("#register_form input[type='password'][name='password_confirmation']").val()));
				if(!validatePassword($(this).val(), $("#register_form input[type='password'][name='password_confirmation']").val(), "#register_form", "#password_errors")) {
					return false;
				} else {
					$("#register_form #password_errors").addClass("hidden");
					return true;
				}
			});

			$("#register_form input[type='password'][name='password']").on('focusout', function(){
				// console.log(validatePassword($(this).val(), $("#register_form input[type='password'][name='password_confirmation']").val()));
				if(!validatePassword($(this).val(), $("#register_form input[type='password'][name='password_confirmation']").val(), "#register_form", "#password_errors")) {
					$("#register_form #password_errors").addClass("hidden").removeClass("hidden").text("Please enter a valid password");
					return false;
				}
			});

			$("#register_form input[type='password'][name='password_confirmation']").on('focusin, input', function(){
				// console.log(validatePassword($(this).val(), $("#register_form input[type='password'][name='password_confirmation']").val()));
				if(!validatePassword($("#register_form input[type='password'][name='password']").val(), $(this).val(), "#register_form", "#password_confirm_errors")) {
					// $("#register_form #password_confirm_errors").removeClass("hidden").text("Password and Confirm password are not matching");
					return false;
				} else {
					$("#register_form #password_confirm_errors").addClass("hidden");
					return true;
				}
			});

			$("#register_form input[type='password'][name='password_confirmation']").on('focusout', function(){
				// console.log(validatePassword($(this).val(), $("#register_form input[type='password'][name='password_confirmation']").val()));
				if(!validatePassword($("#register_form input[type='password'][name='password']").val(), $(this).val(), "#register_form", "#password_confirm_errors")) {
					$("#register_form #password_confirm_errors").addClass("hidden").removeClass("hidden").text("Please enter a valid confirm password");
					return false;
				}
			});

			$("#register_form #accept_terms_checkbox").on('change', function() {
				if(!$(this).prop("checked")) {
					$("#register_form_btn").attr("disabled","disabled");
				} else {
					$("#register_form_btn").removeAttr("disabled");
				}
			});

			if (window.location.search.indexOf("login=true") > -1) { // If login=true exist in URL, then trigger the Popup
				$("#login-modal").modal('show');
			}

			if (window.location.search.indexOf("message=") > -1) { // If login=true exist & message param exist in URL, then trigger the Popup
				var message_key = window.location.search.split("message=")[1].split("&")[0];

				var popup_message = "#login-modal .login-container .alert";
				console.log(message_key);
				if (message_key == 'is_google_account') { // Account exist & linked via Google Login
					$(popup_message + ".alert-danger .account-exist.google-exist-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'is_facebook_account') { // Account exist & linked via Facebook Login
					$(popup_message + ".alert-danger .account-exist.facebook-exist-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'is_email_account' || message_key == 'is_email_signup_account') { // Account exist & linked via Email Login
					$(popup_message + ".alert-danger .account-exist.email-exist-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'account_suspended') {
					$(popup_message + ".alert-danger .account-exist.email-suspend-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'social_permission_denied') {
					$(popup_message + ".alert-danger .no-account.no-email-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'email_confirm') {
					$(popup_message + ".alert-warning .account-inactive.email-exist-error").removeClass('hidden');
					$(popup_message + ".alert-warning").removeClass('hidden');
				} else if (message_key == 'resend_verification') {
					$(popup_message + ".alert-warning .resend-verification.resend-verification-error").removeClass('hidden');
					$(popup_message + ".alert-warning").removeClass('hidden');
				} else if (message_key == 'is_verified') {
					$(popup_message + ".alert-success").removeClass('hidden');
				} else if (message_key == 'no_account') { // Account with this email ID doesn't exist
					$(popup_message + ".alert-danger .no-account-exist.no-email-exist-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'incorrect_password') { // Account with this email ID doesn't exist
					$(popup_message + ".alert-danger .account-exist.wrong-password-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'token_expired') { // Token expired
					$(popup_message + ".alert-danger .user-token-expiry.token-expiry-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'token_already_verified') { // Token already Verfied / Used
					$(popup_message + ".alert-warning .token-already-verified.already-verified-error").removeClass('hidden');
					$(popup_message + ".alert-warning").removeClass('hidden');
				} else if (message_key == 'facebook_email_missing') {
					$(popup_message + ".alert-danger .email-missing.facebook-email-miss-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'google_email_missing') {
					$(popup_message + ".alert-danger .email-missing.google-email-miss-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				}

			}

			if (window.location.search.indexOf("required_field=true") > -1) { // If required_field=true exist in URL, then trigger the Popup
				$(".require-modal").modal('show');

				if (window.location.search.indexOf("login=") >= 0) { // check if the login=true exist in the URL, if it Does, then remove it
					var url_split = window.location.search.split('?')[1].split('&');
					for(i = 0; i < url_split.length; i++) {
						if(url_split[i] != "login=true" && url_split[i].indexOf("message=") < 0) { // Remove 'login' & 'message' Params
							url += (url == '/' ? '?': '&') + url_split[i];
						}
					}
				} else {
					url = window.location.search;
				}

				if (window.location.hash) {
					url += window.location.hash;
				}

				window.history.pushState('', '', url);
			}

			$('#requirement_form_btn').click(function(e) { // On click of Requirement Popup "Save" btn
				e.preventDefault();

	            var descr_values = [], parent = "#requirement_form";

	            $.each($(parent + " input[name='description[]']:checked"), function() {
				  descr_values.push($(this).val());
				});

				var contact = "+" + $(parent + " input[name='contact']").intlTelInput("getSelectedCountryData").dialCode + $(parent + " input[name='contact']").val();

				var redirect_url = window.location.href.split("#")[0];

	            var request_data = {
                	"name": $(parent + " input[name='name']").val(),
                	"email": $(parent + " input[name='email']").val(),
                	"contact_locality" : $(parent + " input[name='contact']").intlTelInput("getSelectedCountryData").dialCode,
                	"contact": $(parent + " input[name='contact']").val(),
                	"contact_id": $(parent + " input#requirement_contact_mobile_id").val(),
                	"area" : $(parent + " select[name='area']").val(),
                	"city" : $(parent + " select[name='city']").val(),
                	"description" : descr_values,
                	"next_url": redirect_url
                };

                if($(parent +" .col-sm-3 .verified span.verified-icon").length > 0) {
                	request_data["is_contact_verified"] = true;
                } else {
                	request_data["is_contact_verified"] = false;
                }

                if(validateUser(request_data, parent)) {
					$("#requirement_form_btn i.fa-spin").removeClass("hidden");
		            $.ajax({
		                url: '/api/requirement',
		                method: 'post',             
		                data: request_data,
		                success: function(data){
		                	$("#requirement_form_btn i.fa-spin").addClass("hidden");
		                	$("#require-modal").modal("hide");
		                	console.log(data);
		                	//window.location.href = "/listing/create";
		                	if(data.hasOwnProperty("url")) {
		                    	window.location.href = data["url"];
		                	} else if (data.hasOwnProperty("redirect_url")) {
		                		window.location.href = data["redirect_url"];
		                	} else if (data.hasOwnProperty("next_url")) {
		                		window.location.href = data["next_url"];
		                	}
		                },
		                error: function(error){
		                	$("#requirement_form_btn i.fa-spin").addClass("hidden");
		                },
		            });
		        } else {
		        	console.log("fields not filled");
		        }

		        e.stopImmediatePropagation();
	        });

	        $("#register_form_btn").click(function(e) { // On Register form submit btn click
	        	e.preventDefault();

	        	var parent = "#register_form";
	        	var contact = "+" + $(parent + " input[name='contact']").intlTelInput("getSelectedCountryData").dialCode + $(parent + " input[name='contact']").val();//$(parent + " input[name='contact']").intlTelInput("getNumber");//$(parent + " input[name='contact_locality']").val() + $(parent + " input[name='contact']").val();
				var descr_values = [];

	            $.each($(parent + " input[name='description[]']:checked"), function() {
				  descr_values.push($(this).val());
				});

				var request_data = {
                	"name": $(parent + " input[name='name']").val(),
                	"email": $(parent + " input[name='email']").val(),
                	"contact_locality" : $(parent + " input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode,
                	"contact": $(parent + " input[name='contact']").val(),
                	"area" : $(parent + " select[name='area']").val(),
                	"city" : $(parent + " select[name='city']").val(),
                	"description" : descr_values
                };

                validatePassword($(parent + " input[type='password'][name='password']").val(), $(parent + " input[type='password'][name='password_confirmation']").val(), parent, "#password_errors");

                if(validateUser(request_data, parent) && validatePassword($(parent + " input[type='password'][name='password']").val(), $(parent + " input[type='password'][name='password_confirmation']").val(), parent, "#password_errors")) { // If the validate User details, password & terms & conditions are satisfied, then Submit the form
                	if($("#accept_terms_checkbox").prop("checked")) {
                		return $(parent).submit(); // Submit the form
                	} else {
                		$("#accept_terms_checkbox").removeClass("hidden");
                	}
                }

                e.stopImmediatePropagation();
                return false;
	        });

	        $("#login_form_modal_btn").click(function() {
	        	var parent = "#login_form_modal";
        		$(parent + " #login_form_modal_btn i").removeClass("hidden");

	        	if(validateEmail($(parent + " input[type='email'][name='email']").val()) && $(parent + " input[type='password'][name='password']").val()) {
	        		return $("#login_form_modal").submit(); // Submit the form
	        	} else {
	        		if(!$(parent + " input[type='email'][name='email']").val()) { // If Email is not filled
	        			$(parent + " #email-error").removeClass("hidden").text("Please enter your Email ID");
	        		} else {
	        			$(parent + " #email-error").addClass("hidden");
	        			validateEmail($(parent + " input[type='email'][name='email']").val(), parent + " #email-error");
	        		}
	        		if(!$(parent + " input[type='password'][name='password']").val()) { // If password is not filled
	        			$(parent + " #password-error").removeClass("hidden").text("Please enter the password");
	        		} else {
	        			$(parent + " #password-error").addClass("hidden");
	        		}
	        		$(parent + " #login_form_modal_btn i").addClass("hidden"); // Hide the loader
	        	}
	        });

	        if($(document).find("#forgot-password-form").length > 0) { // If this container exist, then execute the below conditions
	        	if($("#forgot_password_email").val().length <= 0) {
	        		$("#forgot-password-form-btn").prop('disabled', true);
	        	}

	        	$("#forgot-password-form #forgot_password_email").on("change keyup", function() {
	        		if($(this).val().length <= 0 || !validateEmail($(this).val(), "#as")) {
	        			$("#forgot-password-form-btn").prop('disabled', true);
	        			$("#email-error-container").text("");
	        		} else {
	        			$("#forgot-password-form-btn").prop('disabled', false);
	        		}
	        	});

		        $("#forgot-password-form-btn").click(function() {
		        	if($("#forgot-password-form").parsley().validate()) {
		        		forgotPassword($("#forgot-password-form #forgot_password_email").val());
		        	}
		        });
	        }
		});

		if($('.photo-gallery').length){
			$('.photo-gallery').magnificPopup({
				delegate: 'a',
				type: 'image',
				gallery:{
				enabled:true
				},
				zoom: {
					enabled: true,
					duration: 300 // don't foget to change the duration also in CSS
				}
			});
		}

		// orientationchange reload

		if (window.DeviceOrientationEvent) {
		    window.addEventListener('orientationchange', function() { location.reload(); }, false);
		}


		// detaching sections

		if ($(window).width() <= 768) {
	  //   	var coreCat = $('.detach-col-1').detach();
			// $('.sell-re').after(coreCat);

			var businessListing = $('.businessListing').detach();
			$('.addShow').after(businessListing);
			
			$('.filter-data').each(function(){

				var detailrow = $(this).find('.recent-updates__content');
				var detailbtn = $(this).find('.detail-move').detach();
				$(detailrow).append(detailbtn);

				var recentrow = $(this).find('.updates-dropDown');
				var recentData = $(this).find('.recent-data').detach();
				$(recentrow).append(recentData);

				var publishedAdd = $(this).find('.stats');
				var publisherow = $(this).find('.rat-pub').detach();
				$(publishedAdd).append(publisherow);

				var power = $(this).find('.power-seller-container');
				var powerseller = $(this).find('.power-seller').detach();
				$(power).append(powerseller);

			});


			var advAdd = $('.adv-row').detach();
			$('.adv-after').append(advAdd);

			$('#lookingfor').removeClass('in');

			// $('.recent-updates__content').append(detailbtn);

			// var recentData = $('.recent-data').detach();
			// $('.updates-dropDown').append(recentData);

			$(".show-info").click(function() {
			    $('html, body').animate({
			        scrollTop: '+=200px'
			    }, 1000);
			});
		}

		// mobile side-menu

		$('.sideMenu').click(function(){
			$('.m-side-bar').addClass('active');
			$('.site-overlay').addClass('active');
			$('body').addClass('blocked');
		});

		// remaning number click reveal

		$('.more-show').click(function(event){
			event.preventDefault();
			$(this).addClass('hidden');
			$('.line').addClass('hidden');
			$(this).parent().addClass('expand-more');

		});

		// Fly out toggles

		$('.form-toggle').click(function(){
			$('.fly-out').addClass('active');
		});

		$('.filter-by').click(function(){
			$('body').addClass('full-overflow');
			$('.filterBy').addClass('active');
		});

		$('.search-by').click(function(){
			$('.searchBy').addClass('active');
		});

		$('.back-icon').click(function(){
			$('.fly-out').removeClass('active');
			$('body').removeClass('full-overflow');
		});

		$(document).mouseup(function(e) {
		  var Click_todo;
		  Click_todo = jQuery('.m-side-bar');
		  if (!Click_todo.is(e.target) && Click_todo.has(e.target).length === 0) {
		    jQuery('.m-side-bar,.site-overlay').removeClass('active');
		    jQuery('body').removeClass('blocked');
		  }
		});

		$('.close-sidebar').click(function(){
			jQuery('.m-side-bar,.site-overlay').removeClass('active');
		    jQuery('body').removeClass('blocked');
		});

		// toggle icon

		$('.filter-group__header').click(function(){
			$(this).find('.arrow').toggleClass('active');
		});

		$('.more-area').click(function(){
			$(this).addClass('hidden');
		});

		$(".recent-updates__text").click(function() {
		    $(this).parent('.recent-updates').siblings('.updates-dropDown').slideToggle('slow');
		    $(this).toggleClass('active');
		    $(this).find('.arrowDown').toggleClass('fa-rotate-180');
		});

		// Tags call
		if($('.flexdatalist').length){
			$('.flexdatalist').flexdatalist();
		}
		$('body').on('click', '.level-two-toggle', function() {
		  $('.level-one').addClass('hidden');
		  $('.level-two').addClass('shown');
		  $('.mobile-back').addClass('desk-level-two');
		  $('.mobile-back').removeClass('hidden');
		});


		$('body').on('hidden.bs.modal', '.multilevel-modal', function() {
		  $('.level-one').removeClass('hidden');
		  $('.level-two').removeClass('shown');
		  $('.mobile-back').removeClass('desk-level-two');
		});

		$('.float-input').on('focus', function() {
		  $(this).siblings('.float-label').addClass('filled focused');
		});

		$('.float-input').on('blur', function() {
		  $(this).siblings('.float-label').removeClass('focused');

		  if (this.value === '') {
		    $(this).siblings('.float-label').removeClass('filled')
		  }
		});

		$('.floatInput').on('focus', function() {
		  $(this).parent().closest('.form-group').find('.float-label').addClass('filled focused');
		});

		$('.floatInput').on('blur', function() {
		  $(this).parent().closest('.form-group').find('.float-label').removeClass('focused');

		  if (this.value === '') {
		    $(this).parent().closest('.form-group').find('.float-label').removeClass('filled')
		  }
		});


		// value checking floating label

		function checkForInput(element) {
		  // element is passed to the function ^

		  const $label = $(element).siblings('label');

		  if ($(element).val().length > 0) {
		    $label.addClass('filled lab-color');
		  } else {
		    $label.removeClass('filled lab-color');
		  }
		}

		// The lines below are executed on page load
		$('.float-input').each(function() {
		  checkForInput(this);
		});

		// function checkForInputPhone(element) {

		//   const $label = $(element).parent().closest('.form-group').find('.float-label');

		//   if ($(element).val().length > 0) {
		//   	alert('hasvalue');
		//     $label.addClass('filled lab-color');
		//   } else {
		//   	alert('novalue');
		//     $label.removeClass('filled lab-color');
		//   }
		// }


		// $('.floatInput').each(function() {
		//   checkForInputPhone(this);
		// });

		// Bootstrap multiselect
		if($('.multi-select,.default-area-select').length > 0){
			$('.multi-select').multiselect({
	            includeSelectAllOption: true,
	            numberDisplayed: 1
	        });
	        // different select init
	        $('.default-area-select').multiselect({
	            includeSelectAllOption: true,
	            numberDisplayed: 5,
        		delimiterText:',',
	            nonSelectedText: 'Select City'
	        });
		}

		// Category add
  		$('.cat-add-data').on('change:flexdatalist', function () {
	        value = $(this).val();
	        // console.log('Changed to: ' + value);
	        // updateValue($(this));
	        if( $(this).val().length != 0 ) {
	        	$(this).closest('.categories-select').find('.categories__points').append('<li><label class="flex-row"><input type="checkbox" class="checkbox" for="chicken-re"><p class="text-medium categories__text flex-points__text text-color" id="chicken-re">'+ value +'</p></label></li>');
	        }
	        $(this).val('');
	        // $(this).val('');
	        // $('.flexdatalist-multiple .value').remove();
	    });

		$('.verification-modal').on('hidden.bs.modal', function (e) {
		  	$('.content-data').removeClass('hidden');
  			$('.success-stuff').addClass('hidden');
		});

  		$('.success-toggle').click(function(){
  			$('.content-data').addClass('hidden');
  			$('.success-stuff').removeClass('hidden');
  		});

  		// ".add-areas" class exist in the HTML, only then access the function
  		if($(".add-areas").length > 0) {
	  		$('.add-areas').click(function(e){
	  			var area_group, area_group_clone;
			    e.preventDefault();
			    area_group = $(this).closest('.areas-select').find('.area-append');
			    area_group_clone = area_group.clone();
			    area_group_clone.removeClass('area-append hidden');
			    area_group_clone.find('.areas-appended').addClass('newly-created');
			    console.log(area_group_clone);
			    area_group_clone.find('.selectCity').attr('data-parsley-required','');
			    area_group_clone.find('.selectCity').attr('data-parsley-required-message','Select a city where the job is located.');
			    area_group_clone.find('.newly-created').attr('data-parsley-required','');
			    area_group_clone.find('.newly-created').attr('data-parsley-required-message','Select an area where the job is located.');
			    area_group_clone.find('.newly-created').multiselect({
			    	includeSelectAllOption: true,
		            numberDisplayed: 1,
		            nonSelectedText: 'Select Area(s)'
			    });
			    area_group_clone.insertBefore(area_group);
	  		});
	  	}



		$('body').on('click', '.remove-select-col', function() {
  			$(this).closest('.location-select').remove();
  			if($('.areas-select').find('.location-select').length ==1){
  				$('.add-areas').click();
  			}
  			 
  		});


		

		$('.sub-row .fnb-btn').click(function() {
		    $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass('active');	    
		});

		// cards equal heights
		if ($(window).width() > 769){
			// var getheight = $('.design-2-card').outerHeight();
			// $('.equal-col').css('height',getheight);
			
				$('.open-sidebar').click(function(){
					event.preventDefault();
					$('.animate-row').addClass('body-slide');
					// setTimeout((function() {
					// 	if ($('.post-gallery').length) {
					// 	  $('.post-gallery').magnificPopup({
					// 	    delegate: 'a',
					// 	    type: 'image',
					// 	    gallery: {
					// 	      enabled: true
					// 	    },
					// 	    zoom: {
					// 	      enabled: true,
					// 	      duration: 300
					// 	    }
					// 	  });
					// 	}
					// }), 500);
				});

			$('.article-back').click(function(){
				event.preventDefault();
				$('.animate-row').removeClass('body-slide');
			});

			$(document).mouseup(function(e) {
			  var Click_todo;
			  Click_todo = $('.page-sidebar,.mfp-ready');
			  if (!Click_todo.is(e.target) && Click_todo.has(e.target).length === 0) {
			    $('.animate-row').removeClass('body-slide');
			  }
			});
		}
		// detach sort
		if ($(window).width() < 768){
			$('.open-sidebar').click(function(){
				event.preventDefault();
				$('.side-toggle').toggleClass('active');
				var sort = $('.page-sidebar .sort').detach();
				$('.page-sidebar').closest('.fly-out').find('.right').append(sort);
			});
		}

		// Login

		$('.forget-link').click(function(){
			event.preventDefault();
			$('.forget-password').addClass('active');
		});

		$('.back-login').click(function(){
			$('.forget-password').removeClass('active');
		});
		
		$('#login-modal').on('hidden.bs.modal', function (e) {
		  $('.forget-password').removeClass('active');
		})


		// homepage search

		$('.mobile-fake-search').click(function(){
			$('.searchArea').addClass('active');
		})


		// only number in input phone
		function isNumberKey(evt){
		    var charCode = (evt.which) ? evt.which : event.keyCode
		    if (charCode > 31 && (charCode < 48 || charCode > 57))
		        return false;
		    return true;
		} 

		$('.number-code__value').keypress(function(){
			return isNumberKey(event);
		});

		// Multiselect options for signup

		if($('#describe-best').length){
			// setTimeout((function() {
	  			$('.describe-best').multiselect({
					nonSelectedText: 'What describes you the best?',
					numberDisplayed: 1,
					includeSelectAllOption: true,
					selectAllValue: 'select-all-value',
					enableHTML: true,
					optionClass: function(element) {
		                var value = $(element).val();
		 
		                if (value == 'hospital') {
		                    return 'hospital';
		                }
		                else if(value == 'pro') {
		                    return 'pro';
		                }
		                else if(value == 'vendor') {
		                    return 'vendor';
		                }
		                else if(value == 'student') {
		                    return 'student';
		                }
		                else if(value == 'enterpreneur') {
		                    return 'enterpreneur';
		                }
		                else if(value == 'others') {
		                    return 'others';
		                }
		            }

				});
			// }), 500);
		}

		$('.hospital').tooltip({
		    placement: 'top',
		    container: 'body',
		    title: function () {
		        // put whatever you want here
		        var value = 'If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business';
		        return value;
		    }
		});


		$('.pro').tooltip({
		    placement: 'top',
		    container: 'body',
		    title: function () {
		        // put whatever you want here
		        var value = 'If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc';
		        return value;
		    }
		});

		$('.vendor').tooltip({
		    placement: 'top',
		    container: 'body',
		    title: function () {
		        // put whatever you want here
		        var value = 'If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food & Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers';
		        return value;
		    }
		});

		$('.student').tooltip({
		    placement: 'top',
		    container: 'body',
		    title: function () {
		        // put whatever you want here
		        var value = 'If you are pursuing your education in hospitality sector currently';
		        return value;
		    }
		});


		$('.enterpreneur').tooltip({
		    placement: 'top',
		    container: 'body',
		    title: function () {
		        // put whatever you want here
		        var value = 'If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future';
		        return value;
		    }
		});

		$('.others').tooltip({
		    placement: 'top',
		    container: 'body',
		    title: function () {
		        // put whatever you want here
		        var value = 'Consultants, Media, Investors, etc';
		        return value;
		    }
		});
		var infoIcon = '<i class="fa fa-info-circle p-l-5" aria-hidden="true"></i>'
		$('.multipleOptions .multiselect-container li:not(.multiselect-all) .checkbox').append(infoIcon);




		// /* exported initSample */

		// if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
		// 	CKEDITOR.tools.enableHtml5Elements( document );

		// // The trick to keep the editor in the sample quite small
		// // unless user specified own height.
		// CKEDITOR.config.height = 150;
		// CKEDITOR.config.width = 'auto';

		// var initSample = ( function() {
		// 	var wysiwygareaAvailable = isWysiwygareaAvailable(),
		// 		isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

		// 	return function() {
		// 		var editorElement = CKEDITOR.document.getById( 'editor' );

		// 		// :(((
		// 		if ( isBBCodeBuiltIn ) {
		// 			editorElement.setHtml(
		// 				'Hello world!\n\n' +
		// 				'I\'m an instance of [url=http://ckeditor.com]CKEditor[/url].'
		// 			);
		// 		}

		// 		// Depending on the wysiwygare plugin availability initialize classic or inline editor.
		// 		if ( wysiwygareaAvailable ) {
		// 			CKEDITOR.replace( 'editor' );
		// 		} else {
		// 			editorElement.setAttribute( 'contenteditable', 'true' );
		// 			CKEDITOR.inline( 'editor' );

		// 			// TODO we can consider displaying some info box that
		// 			// without wysiwygarea the classic editor may not work.
		// 		}
		// 	};

		// 	function isWysiwygareaAvailable() {
		// 		// If in development mode, then the wysiwygarea must be available.
		// 		// Split REV into two strings so builder does not replace it :D.
		// 		if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
		// 			return true;
		// 		}

		// 		return !!CKEDITOR.plugins.get( 'wysiwygarea' );
		// 	}
		// } )();


		// initSample();



 // CKEDITOR.replace( 'editor' );


});


