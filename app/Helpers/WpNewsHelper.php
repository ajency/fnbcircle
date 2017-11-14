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
 //dd($args); 
        $posts_array = get_posts($args);

        foreach ($posts_array as $post) {

            $featured_image_id = get_post_thumbnail_id($post->ID);

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
                'content'               => $post->post_content,
                'slug'                  => $post->post_name,
                'id'                    => $post->ID,
                'featured_image'        => $featured_image,
                'date'                  => $post->post_date,
                'display_date'          => date("F d,Y ", strtotime($post->post_date)),
                'url'                   => get_permalink($post->ID), //$post->guid,

            );

        }

        return $news;

    }

}
