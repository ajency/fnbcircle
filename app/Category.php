<?php

namespace App;

use App\Http\Controllers\AdminConfigurationController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Category extends Model
{
    protected $table    = "categories";
    protected $fillable = ['name', 'path', 'level', 'parent_id'];
    public $parent, $children;
    protected $dates = [
        'created_at',
        'updated_at',
        'published_date',
    ];

    public function path()
    {
        return $this->path . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
    public function level()
    {
        return intval($this->level) + 1;
    }
    public function listing()
    {
        return $this->belongsToMany('App\Listing', 'listing_category');
    }
    public function siblingCount()
    {
        return Category::where('parent_id', $this->parent_id)->where('id', '!=', $this->id)->where('status', '1')->count();
    }
    public function isPublishable()
    {
        if ($this->status == '1') {
            return true;
        } else {
            $count = Category::where('parent_id', $this->id)->where('status', '1')->count();
            if ($count > 0 or $this->level == '3') {
                return true;
            } else {
                return "Cannot be pubished becaused no published categories under it";
            }
        }
    }
    public function isArchivable(){

    }
    public function saveStatus($status)
    {
        if ($status == '0') {
            if ($this->status == '0') {
                return true;
            } else {
                return "Once published, the status cannot be set to Draft";
            }

        }
        if ($status == '1') {
            $var = $this->isPublishable();
            if ($var != true) {
                return $var;
            }
            $this->status = "1";
            return true;
        }
        if ($status == "2") {
            if ($this->status == '2') {
                return true;
            }
            if ($this->status == '0') {
                return "You cannot archive a draft category";
            }
            if ($this->status == '1') {
                $req      = new Request;
                $level    = ["1" => "parent", "2" => "branch", "3" => "node"];
                $category = '[{"id":"' . $this->id . '","type":"' . $level[$this->level] . '"}]';
                $location = "[]";
                $req->merge(array("category" => $category, "location" => $location));
                // dd($req);
                $adc  = new AdminConfigurationController;
                $al   = $adc->getAssociatedListings($req);
                $data = json_decode(json_encode($al), true)['original'];
                if (count($data['data']['listings']) != 0) {
                    return "This Category has listings associated with it";
                }
                if ($this->level == "1") {
                    $this->status = "2";
                    return true;
                }
                if ($this->level == "2") {
                    $this->status = "2";
                    if ($data['data']['category_sibling_count'][$this->id]['branch'] == "0") {
                        $parent         = Category::find($this->parent_id);
                        $parent->status = "0";
                        $parent->save();
                    }
                    return true;
                }
                if ($this->level == "3") {
                    $this->status = "2";
                    if ($data['data']['category_sibling_count'][$this->id]['node'] == "0") {
                        $parent         = Category::find($this->parent_id);
                        $parent->status = "0";
                        if ($data['data']['category_sibling_count'][$this->id]['branch'] == "0") {
                            $gparent         = Category::find($parent->parent_id);
                            $gparent->status = "0";
                            $gparent->save();
                        }
                        $parent->save();
                    }
                    return true;
                }
            }
        }
    }

}
