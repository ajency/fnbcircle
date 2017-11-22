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


   /* $.get(LARAURL + '/wp-laravel-header', {

    }, function(response) { 


    	//console.log('LARAVEL HEADER')
    	//console.log(response)
    	 

    	$('#laravel-header-container').html(response);

    });*/




    /*$.get(LARAURL + '/wp-laravel-footer', {
    }, function(response) { 
    	 
		//console.log('LARAVEL FOOTER')
    	//console.log(response)
    	$('#laravel-footer-container').html(response);

    });*/


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



    $('body').on("click","#login_form_modal_btn",function() {
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

    $('body').on("click",".forget-link",function() {        
    	event.preventDefault();
    	$('.forget-password').addClass('active');
    });

    $('body').on("click",".back-login",function() {            
    	$('.forget-password').removeClass('active');
    });
    
    $('body').on("hidden.bs.modal","#login-modal",function(e) {  
     
      $('.forget-password').removeClass('active');
    })




    $('.home_recent_pagination .page-numbers').live('click',function(evt){
       evt.preventDefault();
       var href = $(evt.target).attr('href');

       var href_ar = href.split('=');

       if(typeof href_ar !=='undefined'){
        //var sel_city = $('.search-container>#cat').val();
        var sel_city = $('.home_city_select_label > #cat').val();
        var paged = href_ar[1];

        var page_link_clicked = 'yes'

         

        fetch_recent_home_news(sel_city,paged,page_link_clicked) 
       }

       

        
    })


    function fetch_recent_home_news(sel_city,paged,page_link_clicked){

        //RECENT NEWS
        $('.site-main').find('.list-layout').find('li').remove();
        $('.site-main').find('.list-layout').find('.pagination').remove();

        $('.site-main').find('.list-layout').find('.no-posts-msg').remove();
        $('.site-main').find('.list-layout').append('<i class="loader-center fa fa-circle-o-notch fa-spin fa-2x recent-loader" style="color:#EC6D4B"></i>');
        if(typeof sel_city =='undefined' || sel_city =='-1'){
            sel_city = '';
        }
        if(typeof paged =='undefined'){
            paged = '1';
        }

        var this_page_link_clicked = page_link_clicked
         
        $.post(ajax_url, {
                    action:"get_recent_news_by_city",
                    city:sel_city,
                    paged:paged
                    
                    /*category: self.category,
                    limit_posts: self.limit_posts*/

                }, function(response) { 



                   $('.site-main').find('.list-layout').find('.recent-loader').remove()
                    $(".site-main .list-layout").prepend(response.html)

                    /*if( (typeof this_page_link_clicked !=='undefined') ){
                        if(this_page_link_clicked=='yes'){
                            $('html, body').animate({
                                   scrollTop: $(".recent_news_title").offset().top
                               }, 0);        
                        }
                    }*/
                    

                    console.log(response.html)

                    /*$(".wrap p:first").after(response.html);
                     

                    $('#laravel-business-cats-container').html(response);*/

                }); 

    }


    $('body').on("change",".home_city_select_label > #cat",function(evt) {
    //$('.home_city_select_label > #cat').change(function(evt){
       
       

        var sel_city =  $(evt.target).val();
        console.log(sel_city)

         

        $('.wrap').find('.featured-post').remove();
        $('.wrap').find('.no-posts-msg').remove();
        

        $(".wrap p:first").after('<i class="loader-center fa fa-circle-o-notch fa-spin fa-2x featured-loader" style="color:#EC6D4B"></i>')

        if(typeof sel_city =='undefined' || sel_city =='-1'){
            sel_city = '';
        }
         

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

     
    if(jQuery('.custom-expand-search').val() != ''){
     
        jQuery('.expandSearch').addClass('showSearch');
    }

})

jQuery(document).ready(function($){
    $('.search-submit').on("click",function(){

        if($('#cat').val()!="-1"){
            location.href = SITEURL+$('#cat').val()+"/?s="+$('input[name=s]').val();
        }
        else{
            location.href = SITEURL+"?s="+$('input[name=s]').val();
        }
        
    })

})
jQuery(window).scroll(function() {    
    var scroll = jQuery(window).scrollTop();

    if (scroll >= 500) {
        jQuery(".fnb-header ").addClass("fixed-header");
    } else {
        jQuery(".fnb-header").removeClass("fixed-header");
    }
});
// mobile side-menu
setTimeout((function() {


        jQuery('.sideMenu').click(function(){
            jQuery('.m-side-bar').addClass('active');
            jQuery('.site-overlay').addClass('active');
            jQuery('body').addClass('blocked');
        });



        jQuery(document).mouseup(function(e) {
          var Click_todo;
          Click_todo = jQuery('.m-side-bar');
          if (!Click_todo.is(e.target) && Click_todo.has(e.target).length === 0) {
            jQuery('.m-side-bar,.site-overlay').removeClass('active');
            jQuery('body').removeClass('blocked');
          }
        });

     }), 1800);   
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

// Expand Search 

(function() {
  "use strict";

  var expandSearch = {
    init: function() {
      var _this = this,
        _searchContainers = document.querySelectorAll(".expandSearch");

      for (var _index in _searchContainers) {
        if (typeof _searchContainers[_index] === "object") {
          _this.searchFunctions(_searchContainers[_index]);
        }
      }
    },

    searchFunctions: function(_thisSearch) {
      var _nodes = _thisSearch.childNodes;

      //a click
      _nodes[3].addEventListener("click", function(e) {
        if (_thisSearch.attributes.class.value.indexOf("showSearch") > -1) {
          _thisSearch.attributes.class.value = "expandSearch";
        } else {
          _thisSearch.attributes.class.value = "expandSearch showSearch";
        }

        if (!e.preventDefault()) {
          e.returnValue = false;
        }
        
      });
      // if(_thisSearch.attributes.class.value != ''){
      //       _thisSearch.attributes.class.value = "expandSearch showSearch";
      //   }
    }
  };

  //execute
  expandSearch.init();
})();









        
