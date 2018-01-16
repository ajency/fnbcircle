<?php

namespace App\Helpers;

/**
 * Class for Fetching news posts rom wordpress.
 */
class WpNewsHelper
{

    public function __construct($params = array())
    {

    }

    /**
     *
     * @param      <type>  $params  The parameters
     *                                  array("tag"=>array("agent","accountant"),"num_of_items"=>2)  OR array("tag"=>"agent,accountant","num_of_items"=>2)
     *                                  OR array("category"=>array("goa","pune"),"num_of_items"=>2) OR array("category"=>"goa,pune","num_of_items"=>2)
     * @return     array   The news by categories.
     */
    public function getNewsByCategories_tags($params)
    {

        $news = array();

        $args = array(
            'offset'      => 0,
            'orderby'     => 'date',
            'order'       => 'DESC',
            'post_type'   => 'post',
            'post_status' => 'publish',
        );

        if (isset($params['category'])) {

            if (is_array($params['category'])) {

                $categories            = implode(",", $params['category']);
                $args['category_name'] = $categories;

            } else if (isset($params['category']) && $params['category'] != "") {

                $args['category_name'] = $params['category'];
            }

        } 


        if (isset($params['tag'])) {

            $tags = $params['tag'];
            if (!is_array($params['tag'])) {
                $tags = explode(",", $params['tag']);
            }
            

            $args['tax_query']['relation'] = "OR";
            foreach ($params['tag'] as $tg) {

                $args['tax_query'][] = array( 'taxonomy' => 'post_tag',
                                                'field'    => 'slug',
                                                'terms'    => $tg,
                                            );
            }

            /*  $args['tax_query'] = array(
        array(
        'taxonomy' => 'post_tag',
        'field' => 'slug',
        'terms' => $tags
        )
        );*/

        }

        if (isset($params['num_of_items'])) {
            $args['posts_per_page'] = $params['num_of_items'];
        }

 

        /*$custom_query = new WP_Query( $args ); 
        if ( $custom_query->have_posts() ) :  

        
            while ( $custom_query->have_posts() ) : $custom_query->the_post();   
                $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );

                if($backgroundImg!=false && $backgroundImg!=""){
                    $avatar = $backgroundImg[0];

                } 
                else{
                    $avatar = site_url().'/wp-content/themes/twentyseventeen/assets/images/abstract-user.png';
                }





                $news[] = array('title' => get_the_title(),
                    'content'               => get_the_excerpt(6),
                    'slug'                  => '',
                    'id'                    => get_the_ID(),
                    'featured_image'        => get_the_post_thumbnail(),
                    /*'date'                  => $post->post_date,* /
                    'display_date'          => get_the_time('F jS, Y'),
                    'url'                   => get_permalink(), //$post->guid,
                    'author_link'           => get_the_author_posts_link()

                );


            endwhile; 
        endif; */



 //dd($args); 
        $posts_array = get_posts($args);

        foreach ($posts_array as $post) {

            $featured_image_id = get_post_thumbnail_id($post->ID);

              $current_recent_post_tags_html ="";
              $current_recent_tags = [];
             
              $recent_posttags = get_the_tags($post->ID);
              
              if ($recent_posttags) {
                 
                
                
                foreach($recent_posttags as $tag) {
                     
                    $current_recent_tags[]= $tag->name ; 
                  
                }
                $current_recent_post_tags_html.=implode(',',$current_recent_tags);
              } 

            if ($featured_image_id == false || $featured_image_id == "") {
                $featured_image['thumbnail'] = '';
                $featured_image['medium']    = '';
                $featured_image['large']     = '';
            } else {
                $featured_image['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
                $featured_image['medium']    = get_the_post_thumbnail_url($post->ID, 'post-medium');
                $featured_image['large']     = get_the_post_thumbnail_url($post->ID, 'post-large');

            }

            $news[] = array('title' => $post->post_title,
                'content'               => strip_tags($post->post_content),
                'slug'                  => $post->post_name,
                'id'                    => $post->ID,
                'featured_image'        => $featured_image,
                'date'                  => $post->post_date,
                'display_date'          => date("F d,Y ", strtotime($post->post_date)),
                'url'                   => get_permalink($post->ID), //$post->guid,
                //'tags'                  =>$current_recent_post_tags_html,
                'tags'                  => $current_recent_tags

            );

        }

        return $news;

    }

}
