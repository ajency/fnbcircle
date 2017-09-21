<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListingCategory extends Model
{
    protected $table = "listing_category";
    // protected $primaryKey = ['listing_id', 'category_id'];
    protected $fillable=['listing_id','category_id'];

    public static function getCategories($listing_id){
    	$categories    = DB::select("SELECT nodes.category_id as id, nodes.name as name, nodes.core as core, info.id as branchID, info.name as branch, info.parent as parent, info.icon as icon from (select `category_id`,categories.name,categories.parent_id, `core` from listing_category join categories on listing_category.category_id = categories.id where `listing_id` = ? ) as nodes join (select categories.id, categories.name, p_categ.name as parent, p_categ.icon_url as icon from categories join categories as p_categ on categories.parent_id = p_categ.id where categories.id in (select parent_id from listing_category join categories on listing_category.category_id = categories.id where `listing_id` = ? group by parent_id)) as info on nodes.parent_id = info.id ", [$listing_id, $listing_id]);
            $category_json = array();
            foreach ($categories as $category) {
                if (!isset($category_json["$category->branchID"])) {
                    $category_json["$category->branchID"] = array('branch' => "$category->branch", 'parent' => "$category->parent", 'image-url' => "$category->icon", 'nodes' => array());
                }
                $category_json["$category->branchID"]['nodes']["$category->id"] = array('name' => "$category->name", 'id' => "$category->id", 'core' => "$category->core");
            }
        return $category_json;
    }
}
