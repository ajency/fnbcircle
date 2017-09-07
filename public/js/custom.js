
$(function(){

	$("#login-modal").on('shown.bs.modal', function() {
		var url = '';

		if (window.location.search && window.location.search.indexOf("login=") < 0) {
			url = window.location.search + '&login=true';
		} else if (!window.location.search) {
			url = '/?login=true';
		}

		if (window.location.hash) {
			url += window.location.hash;
		}

		window.history.pushState('', '', url);
	});

	$("#login-modal").on('hidden.bs.modal', function() {
		var url = '/';

		if (window.location.search.indexOf("login=") >= 0) {
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
	});

	$(window).scroll(function (event) {
	    var scroll = $(window).scrollTop();
	    if($('.sticky-section').length){
		    $('.sticky-section').toggleClass('fixed',
		     //add 'ok' class when div position match or exceeds else remove the 'ok' class.
		      scroll >= $('.update-sec').offset().top - 100
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
	if($('.description').length){
		$('.description').readmore({
		   speed: 25,
		   collapsedHeight: 170,
		   moreLink: '<a href="#" class="more vm text-secondary">View more</a>',
		   lessLink: '<a href="#" class="vm less text-secondary">View Less</a>'
		 });
	}
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

		$(document).ready(function() {
			if($('.image-link').length){
			  $('.image-link').magnificPopup({type:'image'});
			}

			if (window.location.search.indexOf("login=true") > -1) { // If login=true exist in URL, then trigger the Popup
				$("#login-modal").modal('show');
			}

			if (window.location.search.indexOf("message=") > -1) { // If login=true exist in URL, then trigger the Popup
				var message_key = window.location.search.split("message=")[1].split("&")[0];

				var popup_message = "#login-modal .login-container .alert";
				
				if (message_key == 'is_google_account') { // Account exist & linked via Google Login
					$(popup_message + ".alert-danger .account-exist.google-exist-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'is_facebook_account') { // Account exist & linked via Facebook Login
					$(popup_message + ".alert-danger .account-exist.facebook-exist-error").removeClass('hidden');
					$(popup_message + ".alert-danger").removeClass('hidden');
				} else if (message_key == 'is_email_account') { // Account exist & linked via Email Login
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
				} else if (message_key == 'is_verified') {
					$(popup_message + ".alert-success").removeClass('hidden');
				}
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
	    	var coreCat = $('.detach-col-1').detach();
			$('.sell-re').after(coreCat);

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
			$('.filterBy').addClass('active');
		});

		$('.search-by').click(function(){
			$('.searchBy').addClass('active');
		});

		$('.back-icon').click(function(){
			$('.fly-out').removeClass('active');
		});

		$(document).mouseup(function(e) {
		  var Click_todo;
		  Click_todo = jQuery('.m-side-bar');
		  if (!Click_todo.is(e.target) && Click_todo.has(e.target).length === 0) {
		    jQuery('.m-side-bar,.site-overlay').removeClass('active');
		    jQuery('body').removeClass('blocked');
		  }
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
		if($('.multi-select').length){
			$('.multi-select').multiselect({
	            includeSelectAllOption: true,
	            numberDisplayed: 1
	        });
	        // different select init
	        $('.default-area-select').multiselect({
	            includeSelectAllOption: true,
	            numberDisplayed: 1,
	            nonSelectedText: 'Select Area(s)'
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

  		$('.add-areas').click(function(e){
  			var area_group, area_group_clone;
		    e.preventDefault();
		    area_group = $(this).closest('.areas-select').find('.area-append');
		    area_group_clone = area_group.clone();
		    area_group_clone.removeClass('area-append hidden');
		    area_group_clone.find('.areas-appended').addClass('newly-created');
		    area_group_clone.find('.newly-created').multiselect({
		    	includeSelectAllOption: true,
	            numberDisplayed: 1,
	            nonSelectedText: 'Select Area(s)'
		    });
		    area_group_clone.insertBefore(area_group);
  		});

		$('input[type=radio][name=plan-select]').change(function() {
		  if ($(this).is(':checked')) {
		    $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass('active');
		  }
		});

		// cards equal heights
		if ($(window).width() > 769){
			var getheight = $('.design-2-card').outerHeight();
			$('.equal-col').css('height',getheight);

			$('.open-sidebar').click(function(){
				event.preventDefault();
				$('.animate-row').addClass('body-slide');
			});

			$('.article-back').click(function(){
				event.preventDefault();
				$('.animate-row').removeClass('body-slide');
			});

			$(document).mouseup(function(e) {
			  var Click_todo;
			  Click_todo = $('.page-sidebar');
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

});


