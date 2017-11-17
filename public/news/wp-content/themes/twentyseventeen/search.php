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
	<header class="header-image page-header text-center">

		<H1 class="bold-t" >FnB Circle News</H1>
	<div class="search-container">
		<!-- <select>
		  <option value="volvo">Panjim</option>
		  <option value="saab">Mumbai</option>
		  <option value="mercedes">Kerala</option>
		  <option value="audi">Pune</option>
		</select> -->

		<?php 
		$city_drop_down_options ='show_option_none=All City&exclude=1&value_field=slug';

		if(get_query_var( 'cat' )!==null && get_query_var( 'cat' )!=''){
			$category_id = get_query_var( 'cat' );
			 
			$category_data  = get_category( $category_id );
			 
			$sel_city_slug = $category_data->slug;

			$city_drop_down_options ='selected='.$sel_city_slug.'&show_option_none=All City&exclude=1&value_field=slug';
		}
		

		?>
		 <label class="search-label">
		 <i class="fa fa-map-marker" aria-hidden="true"></i>
		<?php wp_dropdown_categories($city_drop_down_options); ?>
		</label>
	<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
		
		 <label>
	        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
	        <i class="fa fa-search" aria-hidden="true"></i>
	        <input type="search" class="search-field"
	            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
	            value="<?php echo get_search_query() ?>" name="s"
	            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
	    </label>
	    <input type="button" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
	</form>
	<div class="clear"></div>
</div>
	</header><!-- .page-header -->

<div class="wrap">


	<div id="primary" class="content-area">
	<?php if ( have_posts() ) : ?>

			<?php if(get_query_var( 'cat' )==null){ ?>
			<h3 class=""><?php printf( __( 'Search Results for: %s', 'twentyseventeen' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
			<?php }
			else{ 
				$category_id = get_query_var( 'cat' );
				$category_name = get_cat_name( $category_id );
				?>
			<h3><?php printf( __( 'Search Results for: %s  in city   %s ', 'twentyseventeen' ), '<span>' . get_search_query() ,$category_name. '</span>' ); ?></h3>
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
				echo '<div class="misha_loadmore">More posts</div>'; // you can use <a> as well
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
