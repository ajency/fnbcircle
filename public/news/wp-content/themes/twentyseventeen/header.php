<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="stylesheet" type="text/css" href="<?php echo site_url()."/wp-content/themes/twentyseventeen/assets/css/news.css"; ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php get_template_part( 'template-parts/header/header', 'image' ); ?>

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>

	</header><!-- #masthead -->

	<?php

	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if ( ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) ) :
		?>

	


<?php $post_id = get_the_ID() ; 
$thumb = get_the_post_thumbnail_url(get_the_ID()); ?>
<div id="post" class="single-featured-image-header" 
		<?php  if($thumb!=false && $thumb!=""){ ?> 
			style="background-image: url('<?php echo $thumb;?> ')" <?php }?>>
	<div class="container">
		<div class="row">

			<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
			
		<div class="title-content">

			<?php echo the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		
		<h4>By <?php $author_id=$post->post_author; ?> <?php the_author_meta( 'user_nicename' , $author_id ); ?> posted on <?php echo get_the_date(); ?></h4>
		<?php echo do_shortcode('[addtoany buttons="facebook,twitter,google_plus"]'); ?>
		</div>
	</div>
	</div>
	<div class="overlay">
	</div>
</div>
  
<?php 	endif; ?>
	<div class="site-content-contain">
		<div id="content" class="site-content">
