jQuery(function($){
	$('.aj_cust_loadmore').click(function(){
 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': aj_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : aj_loadmore_params.current_page
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
					
					aj_loadmore_params.current_page++;
 
					if ( aj_loadmore_params.current_page == aj_loadmore_params.max_page ) 
						button.remove(); // if last page, remove the button
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});
});