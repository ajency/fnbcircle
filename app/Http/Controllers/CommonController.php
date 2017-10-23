<?php

namespace App\Http\Controllers;
use App\Area;
use App\City;
use App\Category;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function mapKey(Request $request){
    	$key = env('MAP_KEY', 'AIzaSyBHTsG4PIRcifD2o21lqOinIFsncjLHr00');
    	return response()->json(array('key'=>$key));
    }
    public function slugifyCitiesAreas(){
    	$areas = Area::all();
    	foreach ($areas as $area) {
    		$area->slug = str_slug($area->name);
    		$area->save();
    	}
    	$cities = City::all();
    	foreach ($cities as $city) {
    		$city->slug = str_slug($city->name);
    		$city->save();
    	}
    	echo "success";
    }

    public function getAreas(Request $request)
    {
        $this->validate($request, [
            'city' => 'required|min:1|integer',
        ]);
        
        

        $areaQuery = Area::where('city_id', $request->city)->where('status', '1');

        if(isset($request->area_name) && $request->area_name!=""){
             $areaQuery->where('name','like','%'.$request->area_name.'%');
        }

        $areas = $areaQuery->orderBy('order')->orderBy('name')->get();
        $res   = array();
        
        foreach ($areas as $area) {
            $res[] = array('id'=>$area->id,'name'=>$area->name);
        }
        
        return response()->json($res);
    }

    

    public function getCategories(Request $request,$type){ 
        // $this->validate($request, [
        //     'keyword' => 'required',
        // ]);

        $categories = Category::where("type",$type)->where('status',1)->where('name','like','%'.$request->keyword.'%')->orderBy('name')->get();
        
        return response()->json(['results' => $categories, 'options' => []]);
    } 

    /**
    * This function can be called in blade to generate the HTML required.
    * This function @return
    * [
    *   array("html" => "", "title" => "", "content" => ""),
    *   ....
    * ]
    * 
    * Note: This function is a duplicate of generateHTML() in app\Helper.php -> that was created for generating in blade
    *
    */
    public function generateHtml($layout_type, $css_classes="", $layout_id="", $name="", $ui_data=[], $data=[], $disabled='false') {
        $temp_html = []; $data_tag = '';
        $data_params = ["data-toggle", "data-target"];
        
        foreach ($data_params as $data_key => $data_value) { // If data tag is defined, then add to data_tag
            if (isset($data[$data_value]) && !empty($data[$data_value])) {
                $data_tag .= ' ' . $data_value . '="' . $data[$data_value] . '"';
            } else {
                $data_tag .= '';
            }
        }

        if ($disabled != 'false') { // If the html tag has to be disabled
            $disable_html = ' disabled=' . $disabled;
        } else {
            $disable_html = '';
        }

        if($layout_type == 'anchor') { // If <a> </a> i.e. Anchor tags
            if(isset($ui_data["target"]) and $ui_data['target']) { ### -- If 'target' in ui_data is True, then assign target data
                $target_ui = 'target="_blank"';
            } else {
                $target_ui = '';
            }

            if(isset($ui_data["href_url"]) && isset($ui_data['display'])) { // If this params are passed, then generate the anchor tag, else
                if (!isset($ui_data['value'])) {
                    $ui_data['value'] = '';
                }
                
                $temp_html["html"] = '<a href= "' . $ui_data['href_url'] . '" class="' . $css_classes . '" name="' . $name . '" id="' . $layout_id . '" ' . $data_tag . $disable_html . ' ' . $target_ui . ' value="'. $ui_data['value'] . '" >' . $ui_data['display'] . '</a>';
            } else {
                $temp_html["html"] = '<a href= "#" class="' . $css_classes . '" name="' . $name . '" id="' . $layout_id . '" ' . $data_tag . $disable_html . ' ' . $target_ui . ' value="'. $ui_data['value'] . '" >' . isset($ui_data['display']) ? $ui_data['display'] : '-' . '</a>';
            }
        } else if($layout_type == "checkbox") { // If checkbox
            if(isset($ui_data["checked"]) && $ui_data["checked"]) { // If checked param is passed, then enable the checkbox
                $temp_html["html"] = "<input type=\"checkbox\" class=\"" . $css_classes . "\" for=\"" . isset($ui_data["for"]) ? $ui_data["for"] : "" . "\" name=\"" . $name . "\" value=\"" . isset($ui_data["value"]) ? $ui_data["value"] : "" . "\" checked=\"true\"/>";
            } else {
                $temp_html["html"] = "<input type=\"checkbox\" class=\"" . $css_classes . "\" for=\"" . isset($ui_data["for"]) ? $ui_data["for"] : "" . "\" name=\"" . $name . "\" value=\"" . isset($ui_data["value"]) ? $ui_data["value"] : "" . "\"/>";
            }
        } else if ($layout_type == 'button') { ## If the request html layout is a button, then generate a button
            $temp_html["html"] = '<button class="' . $css_classes . '" name="' . $name . '" id="' . $layout_id . '" ' . $data_tag . $disable_html . '>' . $ui_data['display'] . '</button>';
        } else { // Else generate general text
            $temp_html["html"] = isset($ui_data['display']) ? $ui_data['display'] : '-';
        }

        if(isset($html_content["title"])) {
            $temp_html["title"] = $html_content["title"];
        }

        if(isset($html_content["content"])) {
            $temp_html["content"] = $html_content["content"];
        }

        return $temp_html;
    }

    public function checkIfEmailExist(Request $request) {
        $userauth_obj = new UserAuth;$response_data = []; $status;

        $user_data = array("email" => $request["email"], "username" => $request["email"]);

        $response_obj = $userauth_obj->checkIfUserExist($user_data, true);

        if($respone_obj["comm"] || $respone_obj["user"]) {
            $response_data = array("message" => "Email exist");
            $status = 400;
        } else {
            $response_data = array("message" => "No such email");
            $status = 200;
        }

        return response()->json($response_data, $status);
    }
}
