jQuery(document).ready(function($) {


 

    $.get(LARAURL + '/goa/business-listings-card', {
        
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
    	 
console.log('LARAVEL FOOTER')
    	console.log(response)
    	$('#laravel-footer-container').html(response);

    });

})