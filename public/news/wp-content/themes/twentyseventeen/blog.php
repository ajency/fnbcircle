<?php /* Template Name: news*/ 

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">


<?php
$custom_query_args = array(
  'post_type'  => 'post',
  'meta_key'   => '_is_ns_featured_post',
  'meta_value' => 'yes',
  );
// Get current page and append to custom query parameters array
$custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$custom_query = new WP_Query( $custom_query_args ); ?>
<?php
// Pagination fix
global $wp_query;
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $custom_query;
?>
<?php if ( $custom_query->have_posts() ) : ?>

  <!-- the loop -->
  <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php the_excerpt(); ?>

  <?php endwhile; ?>
  <!-- end of the loop -->

  <!-- pagination here -->
  <?php
  // Custom query loop pagination
  previous_posts_link( 'Older Posts' );
  next_posts_link( 'Newer Posts', $custom_query->max_num_pages );
  ?>

<?php else:  ?>
  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
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

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
