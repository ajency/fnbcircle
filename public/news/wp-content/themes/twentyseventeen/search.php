<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
	<header class="header-image page-header text-center news-banner">
<div class="search-container custom-search">
		<!-- <select>
		  <option value="volvo">Panjim</option>
		  <option value="saab">Mumbai</option>
		  <option value="mercedes">Kerala</option>
		  <option value="audi">Pune</option>
		</select> -->

		<?php 
		$city_drop_down_options ='show_option_none=All&exclude=1&value_field=slug';

		if(get_query_var( 'cat' )!==null && get_query_var( 'cat' )!=''){
			$category_id = get_query_var( 'cat' );
			 
			$category_data  = get_category( $category_id );
			 
			$sel_city_slug = $category_data->slug;

			$city_drop_down_options ='selected='.$sel_city_slug.'&show_option_none=All&exclude=1&value_field=slug';
		}
		

		?>

		 <label class="search-label search_page_city_container hidden">
		 <i class="fa fa-map-marker" aria-hidden="true"></i>
		<?php wp_dropdown_categories($city_drop_down_options); ?>
		</label>
	<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
		
		<?php /*
		 <label class="hidden">
	        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
	        <i class="fa fa-search" aria-hidden="true"></i>
	        <input type="search" class="search-field"
	            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
	            value="<?php echo get_search_query() ?>" name="s"
	            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />

	    </label>
	    <?php /* <input type="button" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" /> */ ?>

	    
	    <div class="expandSearch">
		    	<input type="search" class="search-field custom-expand-search"
		            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
		            value="<?php echo get_search_query() ?>" name="s"
		            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
		            <a href="#">
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="375.045 607.885 30.959 30.33" enable-background="new 375.045 607.885 30.959 30.33" xml:space="preserve">
							<path fill="#fff" d="M405.047,633.805l-7.007-6.542c-0.129-0.121-0.267-0.226-0.408-0.319c1.277-1.939,2.025-4.258,2.025-6.753 c0-6.796-5.51-12.306-12.307-12.306s-12.306,5.51-12.306,12.306s5.509,12.306,12.306,12.306c2.565,0,4.945-0.786,6.916-2.128 c0.122,0.172,0.257,0.337,0.418,0.488l7.006,6.542c1.122,1.048,2.783,1.093,3.709,0.101 C406.327,636.507,406.169,634.853,405.047,633.805z M387.351,629.051c-4.893,0-8.86-3.967-8.86-8.86s3.967-8.86,8.86-8.86 s8.86,3.967,8.86,8.86S392.244,629.051,387.351,629.051z"/>
						</svg>
					</a>
		    </div>
	    <input type="button" class="search-submit hidden" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
 
	</form>
	<div class="clear"></div>
</div>
		<!-- <H1 class="bold-t" >FnB Circle News</H1> -->
<h1 class="bold-t">
	<div class="newsLogo">
		<div class="dis-inline custom-logo">FnB</div><div class="dis-inline news-tag">News</div>
	</div>
</h1>

<div class="news-banner__overlay"></div>		
	
	</header><!-- .page-header -->

<div class="wrap">


	<div id="primary" class="content-area">
	<?php if ( have_posts() ) : ?>

			<?php if(get_query_var( 'cat' )==null){ ?>
			<h3 class=""><?php printf( __( 'Search Results for: \'%s\'', 'twentyseventeen' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
			<?php }
			else{ 
				$category_id = get_query_var( 'cat' );
				$category_name = get_cat_name( $category_id );
				?>
			<h3><?php printf( __( 'Search Results for: \'%s\'  in city   \'%s\' ', 'twentyseventeen' ), '<span>' . get_search_query() ,$category_name. '</span>' ); ?></h3>
			<?php } ?>

		<?php else : ?>
			<h2 class="text-center"><i class="fa fa-frown-o text-lighter" aria-hidden="true"></i> </h2>
			<h5 class="text-center p-0"> <?php _e( 'Nothing Found', 'twentyseventeen' ); ?></h5>
		<?php endif; ?>
		<hr>
		<main id="main" class="site-main" role="main">

<ul class="list-layout">
		<?php
		if ( have_posts() ) :
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				// get_template_part( 'template-parts/post/content', 'excerpt' );
			?>
 <li>
    
      <div class="list-post" <?php if ( has_post_thumbnail() ) { ?>
        id="featured-img"
    <?php } ?>>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
          
  
  <div class="featured-content">
  <a href="<?php the_permalink() ?>" title="Link to <?php the_title_attribute() ?>"  target ="_blank" >  <h5><?php the_title(); ?></h5> </a>
    <?php the_excerpt(15); ?>
<div class="featured-meta">
	<img src="<?php echo site_url()."/wp-content/themes/twentyseventeen/assets/images/abstract-user.png"; ?>" />

By <?php the_author_posts_link(); ?><br> on <?php the_time('F jS, Y'); ?>  <?php /* commented on client request in <?php the_category(', '); ?> */ ?>
</div>   
   </div>
   <div class="featured-image" <?php  if($backgroundImg!=false && $backgroundImg!=""){ ?> 
			style="background-image: url('<?php echo $backgroundImg[0];?> ')" <?php }?>></div>
   <div class="clear"></div>
</div>
   
</li>
<?php
			endwhile; // End of the loop.
			//global $wp_query; // you can remove this line if everything works for you
			 
			// don't display the button if there are not enough posts
			if (  $wp_query->max_num_pages > 1 ){
				echo '<div class="aj_cust_loadmore">More posts</div>'; // you can use <a> as well
			}
echo " ";
			/*the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );*/

		else : ?>

			<p class="text-center"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
			<?php
			

		endif;
		?>
</ul>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
