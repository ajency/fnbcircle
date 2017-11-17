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
          
  
  <div class="featured-content">
  <a href="<?php the_permalink() ?>" title="Link to <?php the_title_attribute() ?>">  <h5><?php the_title(); ?></h5> </a>
    <?php the_excerpt(15); ?>
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
   <div class="featured-image" <?php  if($backgroundImg!=false && $backgroundImg!=""){ ?> 
			style="background-image: url('<?php echo $backgroundImg[0];?> ')" <?php }?>></div>
   <div class="clear"></div>
</div>
   
</li>
<?php
			endwhile; // End of the loop.

			the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
