<?php
namespace App;

use Illuminate\Support\Facades\DB;


public class Common{

public static function verify_id($id,$table){
    $row = DB::table($table)->where('id', $id)->count();
    if($row>0) return true;
    return false;
}

}
 ?>
