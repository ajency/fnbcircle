jQuery(function($){
	$('.aj_cust_loadmore').click(function(){
 
		
		   


		if(typeof aj_featured_loadmore_params !=='undefined' ){
			loadmore_params = aj_featured_loadmore_params;
			 
		}
		else{
			loadmore_params = aj_loadmore_params;
		}


		var button = $(this),
		 data = {
			'action': 'loadmore',
			'query': loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : loadmore_params.current_page,
			'featured' : loadmore_params.featurednews

		};
 
		$.ajax({
			url : ajax_url, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				if( data ) { 
					//$(".site-main .list-layout").append( data.html ); 
					button.text( 'More posts' ).prev().before(data.html); // insert new posts
					
					loadmore_params.current_page++;

					var cust_max_page ;
					if(typeof aj_maxpages !=='undefined'){
						cust_max_page = aj_maxpages
					}
					else{
						cust_max_page = loadmore_params.max_page
					}
 
					if ( loadmore_params.current_page == cust_max_page ) 
						button.remove(); // if last page, remove the button
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});
});