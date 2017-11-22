<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->
		<div class="container">
			<?php /*<div id="laravel-footer-container"><i class="loader-center2 fa fa-circle-o-notch fa-spin fa-2x" style="color:#EC6D4B"></i></div></div>*/ ?>
			<?php $laravel_footer = wp_get_laravel_footer(); ?>
			<div id="laravel-footer-container"><?php echo $laravel_footer; ?></div></div>
		</div>
		
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>
 
</body>
</html>
