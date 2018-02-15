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
    	// $categories    = DB::select("SELECT nodes.category_id as id, nodes.name as name, nodes.core as core, info.id as branchID, info.name as branch, info.parent as parent, info.icon as icon from (select `category_id`,categories.name,categories.parent_id, `core` from listing_category join categories on listing_category.category_id = categories.id where `listing_id` = ? ) as nodes join (select  categories.id, categories.name, categories.slug, p_categ.name AS parent, p_categ.id AS parentID, p_categ.slug AS parent_slug, p_categ.icon_url AS icon from categories join categories as p_categ on categories.parent_id = p_categ.id where categories.id in (select parent_id from listing_category join categories on listing_category.category_id = categories.id where `listing_id` = ? group by parent_id)) as info on nodes.parent_id = info.id ", [$listing_id, $listing_id]);
        $categories = DB::select(
            'SELECT nodes.category_id AS id, nodes.name AS name, nodes.slug as slug, nodes.core AS core, info.id AS branchID, info.slug AS branch_slug, info.name AS branch, info.parent AS parent, info.parent_slug AS parent_slug, info.parentID AS parentID, info.icon AS icon
            FROM (
                SELECT  `category_id` , categories.name, categories.slug, categories.parent_id,  `core` 
                FROM listing_category
                JOIN categories ON listing_category.category_id = categories.id
                WHERE  `listing_id` =?
            ) AS nodes
            JOIN (
                SELECT categories.id, categories.name, categories.slug, p_categ.name AS parent, p_categ.id AS parentID, p_categ.slug AS parent_slug, p_categ.icon_url AS icon
                FROM categories
                JOIN categories AS p_categ ON categories.parent_id = p_categ.id
                WHERE categories.id
                IN (
                    SELECT parent_id
                    FROM listing_category
                    JOIN categories ON listing_category.category_id = categories.id
                    WHERE  `listing_id` =?
                    GROUP BY parent_id
                )
            ) AS info ON nodes.parent_id = info.id',
            [$listing_id, $listing_id]);
            $category_json = array();
            foreach ($categories as $category) {
                if (!isset($category_json["$category->branchID"])) {
                    $category_json["$category->branchID"] = array(
                        'branch' => "$category->branch",
                        'branch_id' => "$category->branchID",
                        'branch_slug' => "$category->branch_slug",
                        'parent' => "$category->parent",
                        'parent_id' => "$category->parentID",
                        'parent_slug' => "$category->parent_slug", 
                        'image-url' => "$category->icon", 
                        'nodes' => array()
                    );
                }
                $category_json["$category->branchID"]['nodes']["$category->id"] = array(
                    'name' => "$category->name", 
                    'slug' => "$category->slug", 
                    'id' => "$category->id", 
                    'core' => "$category->core"
                );
            }
        return $category_json;
    }

    public static function getCategoryJsonTag($listing_id){
        $categories = DB::select(
            'SELECT nodes.category_id AS id, nodes.name AS name, nodes.slug as slug, nodes.core AS core, info.id AS branchID, info.slug AS branch_slug, info.name AS branch, info.parent AS parent, info.parent_slug AS parent_slug, info.parentID AS parentID, info.icon AS icon
            FROM (
                SELECT  `category_id` , categories.name, categories.slug, categories.parent_id,  `core` 
                FROM listing_category
                JOIN categories ON listing_category.category_id = categories.id
                WHERE  `listing_id` =?
            ) AS nodes
            JOIN (
                SELECT categories.id, categories.name, categories.slug, p_categ.name AS parent, p_categ.id AS parentID, p_categ.slug AS parent_slug, p_categ.icon_url AS icon
                FROM categories
                JOIN categories AS p_categ ON categories.parent_id = p_categ.id
                WHERE categories.id
                IN (
                    SELECT parent_id
                    FROM listing_category
                    JOIN categories ON listing_category.category_id = categories.id
                    WHERE  `listing_id` =?
                    GROUP BY parent_id
                )
            ) AS info ON nodes.parent_id = info.id',
            [$listing_id, $listing_id]);
        $array = [];
        foreach ($categories as $category) {
            $array[$category->parent_slug] = $category->parent;
            $array[$category->branch_slug] = $category->branch;
            $array[$category->slug] = $category->name;
        }
        return json_encode(array_unique($array));
    }
}
