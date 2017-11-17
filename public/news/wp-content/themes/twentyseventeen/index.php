<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
//$user_state = "pune";

get_header(); 
/* commented on client request 
$laravel_user_state = Cookie::get('user_state');
if(isset($laravel_user_state)){
	if($laravel_user_state!=''){
		$user_state = $laravel_user_state;
	}
}*/
 
?>
<div class="header-image text-center">
	<div class="search-container custom-search">
			<!-- <select>
			  <option value="volvo">Panjim</option>
			  <option value="saab">Mumbai</option>
			  <option value="mercedes">Kerala</option>
			  <option value="audi">Pune</option>
			</select> -->
			 <label class="search-label home_city_select_label hidden">
			 <i class="fa fa-map-marker" aria-hidden="true"></i>
			<?php wp_dropdown_categories('show_option_none=All City&exclude=1&value_field=slug'); ?>
			</label>
		<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
			
			 <label class="hidden">
		        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
		        <i class="fa fa-search" aria-hidden="true"></i>
		        
		    </label>
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
	<H1 class="bold-t" >FnB Circle News</H1>

</div>
<div class="wrap">
<h3 class="bold-t">Featured News on FnB</h3>
<p class="text-lighter">What's trending on FnB Circle right now.</p>	
	<?php
$custom_query_args = array(
  'post_type'  => 'post',
  'meta_key'   => '_is_ns_featured_post',
  'meta_value' => 'yes',
  );
if(isset($user_state)){
	if($user_state!=""){
		$custom_query_args['category_name'] =str_replace(" ", "-", strtolower($user_state)) ;
	}
}
// Get current page and append to custom query parameters array
$custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$custom_query = new WP_Query( $custom_query_args ); ?>
<?php
// Pagination fix
global $wp_query;
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $custom_query;

$featured_cnt =0;
?>
<?php if ( $custom_query->have_posts() ) : ?>

  <!-- the loop -->
  <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

  <?php if($featured_cnt<4) : ?>	
<div class="featured-post">
	<div class="border-layout">
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
          
  <div class="featured-image" <?php  if($backgroundImg!=false && $backgroundImg!=""){ ?> 
			style="background-image: url('<?php echo $backgroundImg[0];?> ')" <?php }?>></div>
  <div class="featured-content">

    <h5 class="font-weight-bold"><a href="<?php the_permalink(); ?>" target ="_blank" ><?php the_title(); ?></a></h5>
    <?php the_excerpt(6); ?>
<div class="featured-meta">
<img src="<?php echo site_url()."/wp-content/themes/twentyseventeen/assets/images/abstract-user.png"; ?>" />

<?php 
/* commented on client request 
$show_categories = true;
$categories = wp_get_post_categories( $post->ID );
// We don't want to show the categories if there is a single category and it is "uncategorized"
if ( count( $categories ) == 1 && in_array( 1, $categories ) ) :
  $show_categories = false;
endif;*/
$show_categories =false;

?>

By <?php the_author_posts_link(); ?><br> on <?php the_time('F j, Y'); ?>  <?php if($show_categories==true){ ?>in <?php the_category(', '); ?>  <?php } ?>
</div>   
   </div>
   <div class="clear"></div>
</div>
</div>
<?php $featured_cnt++; ?>
<?php endif ?>
  <?php endwhile; ?>
  <?php 
	 if($custom_query->post_count>4){
		echo "<a href='javascript:void(0);'>View more...</a>";
	}
  ?>
  <!-- end of the loop -->

  <!-- pagination here -->
  <?php
  // Custom query loop pagination
  /*previous_posts_link( 'Older Posts' );
  next_posts_link( 'Newer Posts', $custom_query->max_num_pages );*/
  ?>

<?php else:  ?>
  <p><span class="no-posts-msg"><i class="fa fa-frown-o" aria-hidden="true"></i> <h6>Sorry, no featured news matched your criteria.</h6></span><?php /*_e( 'Sorry, no posts matched your criteria.' ); */ ?></p>
<?php endif; ?>

<?php
// Reset postdata
wp_reset_postdata();
?>

<?php
// Reset main query object
$wp_query = NULL;
$wp_query = $temp_query;
?>
<div class="clear"></div>
<br>


<h3 class="bold-t recent_news_title">Recent News on FnB</h3>
<p class="text-lighter">What's trending on FnBCircle right now.</p>	

<hr>
<!-- 	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : ?>
	<header class="page-header">
		<h2 class="page-title"><?php _e( 'Posts', 'twentyseventeen' ); ?></h2>
	</header>
	<?php endif; ?> -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php
			function TrimStringIfToLong($s) {
    $maxLength = 60;

    if (strlen($s) > $maxLength) {
        echo substr($s, 0, $maxLength - 5) . ' ...';
    } else {
        echo $s;
    }
}

?>

<ul class="list-layout">
<?php
$query = array( 'posts_per_page' => 10, 'orderby'     => 'date',
            'order'       => 'DESC','post_status'=>'publish' );

$query['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

if(isset($user_state)){
	if($user_state!=""){
		$query['category_name'] =str_replace(" ", "-", strtolower($user_state)) ;
	}
}


$wp_query = new WP_Query($query);

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<li>
    
      <div class="list-post" <?php if ( has_post_thumbnail() ) { ?>
        id="featured-img"
    <?php } ?>>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
          
  
  <div class="featured-content">
 <?php $my_post_meta = get_post_meta($post->ID, '_is_ns_featured_post', true); ?>
  
  <a href="<?php the_permalink() ?>" title="Link to <?php the_title_attribute() ?>"  target ="_blank" >  <h5><?php the_title(); ?></h5> </a>
    <?php the_excerpt(15); ?>
<div class="featured-meta">
	<img src="<?php echo site_url()."/wp-content/themes/twentyseventeen/assets/images/abstract-user.png"; ?>" />


<?php 
/*$show_categories = true;
$categories = wp_get_post_categories( $post->ID );
// We don't want to show the categories if there is a single category and it is "uncategorized"
if ( count( $categories ) == 1 && in_array( 1, $categories ) ) :
  $show_categories = false;
endif;*/
$show_categories = false;

?>


By <?php the_author_posts_link(); ?><br> on <?php the_time('F j, Y'); ?>  <?php if($show_categories==true) { ?>in <?php the_category(', '); ?> <?php } ?>
</div>   
   </div>
   <div  class="featured-image " <?php  if($backgroundImg!=false && $backgroundImg!=""){ ?> 
			style="background-image: url('<?php echo $backgroundImg[0];?> ')" <?php }?>></div>
   <div class="clear"></div>
</div>
   
</li>
<?php endwhile; 


global $wp_query; // you can remove this line if everything works for you
 
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 ){
	echo '<div class="aj_cust_loadmore">More posts</div>'; // you can use <a> as well
}

/* $recent_news_pagination_html=vb_ajax_pager($wp_query,1,'home_recent_pagination');
echo $recent_news_pagination_html;*/

echo " ";

/*the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );*/

else: ?>
<p><span class="no-posts-msg"><i class="fa fa-frown-o" aria-hidden="true"></i> <h6>Sorry, no recent news matched your criteria.</h6></span><?php /* _e('Sorry, no posts published so far.'); */ ?></p>
<?php endif; ?>
</ul>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->


<script type="text/javascript">



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

      
	/*jQuery(document).ready(function($){
		$('.search-submit').on("click",function(){

			if($('#cat').val()!="-1"){
				location.href = "< ?php echo esc_url( home_url( '/' ) ); ?>"+$('#cat').val()+"/?s="+$('input[name=s]').val();
			}
			else{
				location.href = "< ?php echo esc_url( home_url( '/' ) ); ?>?s="+$('input[name=s]').val();
			}
			
		})

	})*/
</script>
  <div class="site-overlay"></div>

<?php get_footer();
