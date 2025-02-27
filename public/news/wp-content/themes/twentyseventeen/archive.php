<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<header class="page-header header-image">

				<?php if(is_archive()){
				?> 

				<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
			 
				<?php 	
				}?>


			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	<?php endif; ?>
<div class="wrap">


	<div id="primary" class="content-area">
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
 	
<?php  
	  $current_featured_tags_html =""; 
	  /*$posttags = get_the_tags($post->ID);	  

	  if($posttags){
	  		$current_featured_tags_html = get_tags_markup($posttags,false); 
	  }*/
?>	         
  
  <div class="featured-content">
  <a href="<?php the_permalink() ?>" title="Link to <?php the_title_attribute() ?>">  <h5><?php the_title(); ?></h5> </a>
    <?php the_excerpt(30); ?>
    <?php echo $current_featured_tags_html; ?>
<div class="featured-meta">
	<img src="<?php echo site_url()."/wp-content/themes/twentyseventeen/assets/images/abstract-user.png"; ?>" />

<?php 
$show_categories = true;
$categories = wp_get_post_categories( $post->ID );
// We don't want to show the categories if there is a single category and it is "uncategorized"
if ( count( $categories ) == 1 && in_array( 1, $categories ) ) :
  $show_categories = false;
endif;

/* category display disabled  */
$show_categories = false;


?>

By <?php the_author_posts_link(); ?><br> on <?php the_time('F jS, Y'); ?>  <?php if($show_categories==true){ ?> in <?php the_category(', '); ?>  <?php } ?>
</div>   
   </div>
   <?php /* <div class="featured-image" <?php  if($backgroundImg!=false && $backgroundImg!=""){ ?> 
			style="background-image: url('<?php echo $backgroundImg[0];?> ')" <?php }?>></div> */ ?>

	<?php if($backgroundImg!=false && $backgroundImg!=""){ ?>
	<img src="<?php echo $backgroundImg[0];?>"  class="featured-image " />
	<?php } ?>


   <div class="clear"></div>
</div>
   
</li>
<?php
			endwhile; // End of the loop.

			global $wp_query; // you can remove this line if everything works for you


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

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
