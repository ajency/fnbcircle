<?php

namespace App;

use App\Http\Controllers\AdminConfigurationController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Ajency\FileUpload\FileUpload;

class Category extends Model
{
    use FileUpload;
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

    public function getHirarchyAttribute(){
        try{
            $p_id = $result = substr($this->path, 0, 5);
            $b_id = $result = substr($this->path, 5, 10);
            $parent = self::find($p_id);
            $branch = self::find($b_id);
            return $parent->name.">>".$branch->name.">>".$this->name;
        }catch (\Exception $e) {
            return 'error';
        }
    }

    public function getNameAttribute( $value ) { 
        $value = ucwords( $value );      
        return $value;
    }

    public function isPublishable()
    {
        if ($this->status == '1') {
            return true;
        } else {
            $count = Category::where('type','listing')->where('parent_id', $this->id)->where('status', '1')->count();
            if ($count > 0 or $this->level == '3') {
                $this->published_date = Carbon::now();
                return true;
            } else {
                if($this->level == 1)
                    return "Parent category cannot be published as there is no published branch category under this parent";
                if($this->level == 2)
                    return "Branch category cannot be published as there is no published node category under this branch";
            }
        }
    }
    public function isArchivable()
    {
        if ($this->status == '2') {
            return true;
        }
        if ($this->status == '0') {
            return "You cannot archive a draft category";
        }
        if ($this->status == '1') {
            $req      = new Request;
            // $level    = ["1" => "parent", "2" => "branch", "3" => "node"];
            $category = '[{"id":"' . $this->id . '","type":"' . $this->level . '"}]';
            $location = "[]";
            $req->merge(array("category" => $category, "location" => $location));
            // dd($req);
            $adc  = new AdminConfigurationController;
            $al   = $adc->getAssociatedListings($req);
            $data = json_decode(json_encode($al), true)['original'];
            // dd($data['data']['category_sibling_count'][$this->id]);
            if (count($data['data']['listings']) != 0) {
                return response()->json(array("status" => "405", "msg" => "", "data" => array('continue' => false, 'message' => 'This category has listings associated with it. <a href="#">Click here</a> to view the listings.<br>You can archive this node only once this is removed from all the listings.')));
                return ;
            }
            if ($this->level == "1") {
                return true;
            }
            if ($this->level == "2") {
                if ($data['data']['category_sibling_count'][$this->id]['branch'] == "0") {
                    return response()->json(array("status" => "400", "msg" => "", "data" => array('continue' => false, 'message' => "Warning! Archiving the branch will archive the parent too. Do you want to continue?")));
                }
                return true;
            }
            if ($this->level == "3") {
                if ($data['data']['category_sibling_count'][$this->id]['node'] == "0") {
                    $y = "Warning! Archiving the node will archive the branch too. Do you want to continue? ";
                    if ($data['data']['category_sibling_count'][$this->id]['branch'] == "0") {
                        $y = "Archiving the node will archive the branch and the parent too. Do you want to continue? ";
                    }
                    return response()->json(array("status" => "400", "msg" => "", "data" => array('continue' => false, 'message' => $y)));
                }
                return true;
            }
            return true;
        }

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
                $data = $this->getAssociatedListings();
                // dd($data);
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
                        $parent->status = "2";
                        $parent->save();
                    }
                    return true;
                }
                if ($this->level == "3") {
                    $this->status = "2";
                    if ($data['data']['category_sibling_count'][$this->id]['node'] == "0") {
                        $parent         = Category::find($this->parent_id);
                        $parent->status = "2";
                        if ($data['data']['category_sibling_count'][$this->id]['branch'] == "0") {
                            $gparent         = Category::find($parent->parent_id);
                            $gparent->status = "2";
                            $gparent->save();
                        }
                        $parent->save();
                    }
                    return true;
                }
            }
        }
    }

    public function getAssociatedListings(){
        $req      = new Request;
        $category = '[{"id":"' . $this->id . '","type":"' . $this->level . '"}]';
        $location = "[]";
        $req->merge(array("category" => $category, "location" => $location));
        $adc  = new AdminConfigurationController;
        $al   = $adc->getAssociatedListings($req);
        $data = json_decode(json_encode($al), true)['original'];
        return $data;
    }

    public function getChildrenCount(){
        return self::where('parent_id', $this->id)->count();
    }

    

}
