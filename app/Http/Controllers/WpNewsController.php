<?php

namespace App\Http\Controllers;

use App\Category;
use App\Defaults;
use Auth;
use Conner\Tagging\Model\Tag;

/**
 *  Class to get the  Header, footer etc from laravel into wordpress news
 */
class WpNewsController extends Controller
{
    public function getLaravelHeaderForWp()
    {
        return view('wpnews.wp-header');
    }

    public function getLaravelFooterForWp()
    {

        return view('wpnews.wp-footer');
    }

    public function getLaravelLoggedInUser()
    {
        if (Auth::check()) {
            return response()->json(Auth::user());
        } else {
            return response()->json(false);
        }
    }

    public function getJobBusinessTags()
    {

        ini_set('max_execution_time', 600);

        $error = array();

        $wp_tag_slugs = array();
        $wp_tags      = get_tags();

        foreach ($wp_tags as $tag) {
            $wp_tag_slugs[] = $tag->slug;
        }

        $listing_cats = Category::where('type', 'listing')->where('status', 1)->whereNotIn('slug', $wp_tag_slugs)->orderBy('order')->orderBy('name')->get(array('name', 'slug'));
        foreach ($listing_cats as $key => $listing_cat) {
            $result = wp_insert_term($listing_cat->name, // the term
                'post_tag', // the taxonomy
                array('description' => '',
                    'slug'              => $listing_cat->slug)
            );

            if (is_wp_error($result)) {
                $error_string = $result->get_error_message();
                $error[]      = array('name' => $listing_cat->name, 'slug' => $listing_cat->slug, 'error' => $error_string);
            }

            //$selected_tags_to_add[] = $listing_cat->slug;
        }

        $default_labels = Defaults::where('type', 'job_keyword')->get(array('label'));
        foreach ($default_labels as $default_label) {

            $default_label_slug = strtolower(preg_replace('/[^\w-]/', '', str_replace(' ', '-', $default_label->label)));

            if (!in_array($default_label_slug, $wp_tag_slugs)) {
                $result = wp_insert_term($default_label->label, // the term
                    'post_tag', // the taxonomy
                    array('description' => '',
                        'slug'              => $default_label_slug)
                );
                if (is_wp_error($result)) {
                    $error_string = $result->get_error_message();
                    $error[]      = array('name' => $default_label->label, 'slug' => $default_label_slug, 'error' => $error_string);
                }

                //$selected_tags_to_add[] = $default_label_slug;
            }
        }

        $tag_cats = Tag::where('tag_group_id', 1)->whereNotIn('slug', $wp_tag_slugs)->get(array('name', 'slug'));

        foreach ($tag_cats as $tag_cat) {
            $result = wp_insert_term($tag_cat->name, // the term
                'post_tag', // the taxonomy
                array('description' => '',
                    'slug'              => $tag_cat->slug)
            );
            if (is_wp_error($result)) {
                $error_string = $result->get_error_message();
                $error[]      = array('name' => $tag_cat->name, 'slug' => $tag_cat->slug, 'error' => $error_string);
            }
            //$selected_tags_to_add[] = $tag_cat->slug;
        }

        /*$wp_tags2 = get_tags();

        foreach ($wp_tags2 as $tag) {
        $wp_tag_slugs2[] = $tag->slug;
        }
        echo"<pre>";
        print_r(array_diff($selected_tags_to_add, $wp_tag_slugs2));    */

        //$data = array('listing_cats'=>$listing_cats, 'default_cats'=>$default_cats, 'tag_cats'=>$tag_cats);
        return response()->json($error);

    }

}
