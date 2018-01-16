<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class EnquiryCategory extends Model {
    protected $fillable = ['enquiry_id', 'category_id'];


 public static function getCategories($enquiry_id){
 	$categories = DB::select(
            'SELECT nodes.category_id AS id, nodes.name AS name, nodes.slug as slug, info.id AS branchID, info.slug AS branch_slug, info.name AS branch, info.parent AS parent, info.parent_slug AS parent_slug, info.parentID AS parentID, info.icon AS icon
            FROM (
                SELECT  `category_id` , categories.name, categories.slug, categories.parent_id
                FROM enquiry_categories
                JOIN categories ON enquiry_categories.category_id = categories.id
                WHERE  `enquiry_id` =?
            ) AS nodes
            JOIN (
                SELECT categories.id, categories.name, categories.slug, p_categ.name AS parent, p_categ.id AS parentID, p_categ.slug AS parent_slug, p_categ.icon_url AS icon
                FROM categories
                JOIN categories AS p_categ ON categories.parent_id = p_categ.id
                WHERE categories.id
                IN (
                    SELECT parent_id
                    FROM enquiry_categories
                    JOIN categories ON enquiry_categories.category_id = categories.id
                    WHERE  `enquiry_id` =?
                    GROUP BY parent_id
                )
            ) AS info ON nodes.parent_id = info.id',
            [$enquiry_id, $enquiry_id]);
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
                );
            }
        return $category_json;
    }
 }