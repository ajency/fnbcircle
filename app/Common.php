<?php
namespace App;

use Illuminate\Support\Facades\DB;

class Common
{

    public static function verify_id($id, $table)
    {
        $row = DB::table($table)->where('id', $id)->count();
        if ($row > 0) {
            return true;
        }

        return false;
    }

    public static function authenticate($controller, $instance){
    	$instance->middleware('auth');
    }

}
