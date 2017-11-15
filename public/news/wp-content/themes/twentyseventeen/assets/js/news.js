jQuery(document).ready(function($) {

    var bus_cat_fetch_url ="";

    if(page_category!=" "){
        bus_cat_fetch_url = LARAURL + '/'+page_category+'/business-listings-card';
    }
    else{
         bus_cat_fetch_url = LARAURL + '/business-listings-card';
    }

    $.get(bus_cat_fetch_url, {
        
        /*category: self.category,
        limit_posts: self.limit_posts*/

    }, function(response) { 
    	 

    	$('#laravel-business-cats-container').html(response);

    });


    $.get(LARAURL + '/wp-laravel-header', {

    }, function(response) { 


    	/*console.log('LARAVEL HEADER')
    	console.log(response)*/
    	 

    	$('#laravel-header-container').html(response);

    });




    $.get(LARAURL + '/wp-laravel-footer', {
    }, function(response) { 
    	 
		/*console.log('LARAVEL FOOTER')
    	console.log(response)*/
    	$('#laravel-footer-container').html(response);

    });


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


    $("#login_form_modal_btn").live('click',function() {
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


    // Login

    $('.forget-link').live("click",function(){
    	event.preventDefault();
    	$('.forget-password').addClass('active');
    });

    $('.back-login').live("click",function(){
    	$('.forget-password').removeClass('active');
    });
    
    $('#login-modal').live('hidden.bs.modal', function (e) {
      $('.forget-password').removeClass('active');
    })




    $('.home_recent_pagination .page-numbers').live('click',function(evt){
       evt.preventDefault();
       var href = $(evt.target).attr('href');
       var href_ar = href.split('=');

       var sel_city = $('.search-container>#cat').val();
       var paged = href_ar[1];

       fetch_recent_home_news(sel_city,paged)

        
    })


    function fetch_recent_home_news(sel_city,paged){

        //RECENT NEWS
        $('.site-main').find('.list-layout').find('li').remove();
        $('.site-main').find('.list-layout').find('.pagination').remove();

        $('.site-main').find('.list-layout').find('.no-posts-msg').remove();
        $('.site-main').find('.list-layout').append('<i class="fa fa-circle-o-notch fa-spin fa-2x recent-loader" style="color:#EC6D4B"></i>');
        if(typeof sel_city =='undefined' || sel_city =='-1'){
            sel_city = '';
        }
        if(typeof paged =='undefined'){
            paged = '1';
        }


         
        $.post(ajax_url, {
                    action:"get_recent_news_by_city",
                    city:sel_city,
                    paged:paged
                    
                    /*category: self.category,
                    limit_posts: self.limit_posts*/

                }, function(response) { 

                   $('.site-main').find('.list-layout').find('.recent-loader').remove()
                    $(".site-main .list-layout").prepend(response.html)

                    console.log(response.html)

                    /*$(".wrap p:first").after(response.html);
                     

                    $('#laravel-business-cats-container').html(response);*/

                }); 

    }



    $('.search-container>#cat').live("change",function(evt){
       

        var sel_city =  $(evt.target).val();
        console.log(sel_city)

         

        $('.wrap').find('.featured-post').remove();
        $('.wrap').find('.no-posts-msg').remove();
        

        $('.wrap').append('<i class="fa fa-circle-o-notch fa-spin fa-2x featured-loader" style="color:#EC6D4B"></i>')


        ///FEATURED NEWS
         $.post(ajax_url, {
            action:"get_featured_news_by_city",
            city:sel_city
            
            /*category: self.category,
            limit_posts: self.limit_posts*/

        }, function(response) { 

            $('.wrap').find('.featured-loader').remove();

            $(".wrap p:first").after(response.html)

            console.log(response.html)

            /*$(".wrap p:first").after(response.html);
             

            $('#laravel-business-cats-container').html(response);*/

        }); 


        //RECENT NEWS
        fetch_recent_home_news(sel_city,1) ;

         


        /* $('.nav-links').live( 'click', function( event ) {
        event.preventDefault();

        alert('clicked nav') })*/



         


    })

})


/* var table = document.getElementsByClassName('page-numbers');

        table.addEventListener('click', function(e) {
        alert('test')
            
            var target = e.target;
            if (target.tagName == 'A') {
                return false;
            }
            
            if (target.tagName == 'TD') {
                var win = window.open(target.parentNode.getAttribute('data-url'));
                win.focus();
            }
        }, false);*/