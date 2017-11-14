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

loginCreateWpUserByLaravelEMail();
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

<!-- -->	
<div id="laravel-header-container"><i class="fa fa-circle-o-notch fa-spin fa-2x" style="color:#EC6D4B"></i></div>


<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>



	<?php

	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if ( ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) ) :
		?>

	


<?php $post_id = get_the_ID() ; 
$thumb = get_the_post_thumbnail_url(get_the_ID()); ?>
<div id="post" class="single-featured-image-header" >
	<div class="container">
		<div class="row">

			<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
			
		<div class="title-content">

			<?php echo the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<?php
if ( has_post_thumbnail() ) { ?>


			<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
<img src="<?php echo $url ?>" />
<?php } ?>
		<h4>By <?php $author_id=$post->post_author; ?> <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author_meta( 'user_nicename' , $author_id ); ?></a> posted on <?php echo get_the_date(); ?>
			<?php $cats = get_the_category_list(  ',',   '', $post_id = false ); 
			if($cats!=""){
				echo " in ".$cats;
			}  
			?>

		</h4>

		

		<?php echo do_shortcode('[addtoany buttons="facebook,twitter,google_plus,linkedin,whatsapp"]'); ?>

		</div>
	</div>
	</div>
	
</div>
  
<?php 	endif; ?>
	<div class="site-content-contain">
		<div id="content" class="site-content">
