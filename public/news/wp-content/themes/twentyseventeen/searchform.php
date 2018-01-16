<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
$queried_object = get_queried_object();
$action_url = esc_url( home_url( '/' ) );

if(isset($queried_object->taxonomy)){

	if($queried_object->taxonomy=="category"){
		$action_url = esc_url( home_url( '/' ).$queried_object->slug."/" );
	}
}

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<?php /*<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">	 */ ?>
<form role="search" method="get" class="search-form" action="<?php echo $action_url; ?>">	
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'twentyseventeen' ); ?></span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'twentyseventeen' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><?php echo twentyseventeen_get_svg( array( 'icon' => 'search' ) ); ?><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'twentyseventeen' ); ?></span></button>
</form>
