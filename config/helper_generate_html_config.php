<?php

use App\Description;

$descriptions = Description::where('active',1)->get();
$config = [];
foreach ($descriptions as $description) {
	$array = json_decode($description->meta,true);
	foreach ($array as $config_key => $config_data) {
		if(!isset($config[$config_key])) $config[$config_key]=[];
		$config_data['content'] = $description->description;
		if($config_key == 'enquiry_popup_display') $config[$config_key][$description->value] = $config_data;
		else $config[$config_key][] = $config_data;
	}
}


return $config;
	/*	[
			<$reference-Key> => [
				....
				array( "type" ->  <Type of tag i.e checkbox, input, email, password, etc >, "css_classes" -> "< a string which has all the css_classes>",
				"id" -> <ID for the Tag>, "name" => "Name for the tag. For group please append '[]' after the name, ex: 'name' => 'description[]' ", "value" => "<Value to be assigned for tag>",
				"for" => "<Define the 'for' tag for mapping it to any html Tag ID>", "title" => "Main Label to be displayed. Note: This value is not added to the HTML tag, instead it is passed seperately in array", "content" => "<The content to be displayed> (optional)"),
				....
			]
		]

		* The function generateHTML($reference) uses this config where, "$reference" will be the Key & html is generated based on that.
		* The Response will be:
		* [
		*	array("html" => "<html in string>1", "title" => <String: title1>, "content" => <String: content1>),
		*	array("html" => "<html in string>2", "title" => <String: title2>, "content" => <String: content2>),
		*	....
		* ]
		* Ex: $reference = "register_description"
	*/
	// return [
	// 	"register_description" => [
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "hospitality", "for" => "hospitality", "title" => "Hospitality Business Owner",
	// 				"content" => "If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "professional", "for" => "professional", "title" => "Working Professional",
	// 				"content" => "If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "vendor", "for" => "vendor", "title" => "Vendor/Supplier/Service provider",
	// 				"content" => "If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "student", "for" => "student", "title" => "Hospitality Student",
	// 				"content" => "If you are pursuing your education in hospitality sector currently"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "enterpreneur", "for" => "enterpreneur", "title" => "Prospective Entrepreneur",
	// 				"content" => "If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "others", "for" => "others", "title" => "Others",
	// 				"content" => "Consultants, Media, Investors, Foodie, etc"
	// 			)
	// 	],
	// 	"listing_enquiry_description" => [
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "hospitality", "for" => "hospitality", "title" => "Hospitality Business Owner",
	// 				"content" => "If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business", "parsley" => ["data-parsley-mincheck" => "1", "data-required" => "true", "data-parsley-errors-container" => "#describes-best-error"]
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "professional", "for" => "professional", "title" => "Working Professional",
	// 				"content" => "If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "vendor", "for" => "vendor", "title" => "Vendor/Supplier/Service provider",
	// 				"content" => "If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "student", "for" => "student", "title" => "Hospitality Student",
	// 				"content" => "If you are pursuing your education in hospitality sector currently"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "enterpreneur", "for" => "enterpreneur", "title" => "Prospective Entrepreneur",
	// 				"content" => "If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"
	// 			),
	// 		array(
	// 				"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "others", "for" => "others", "title" => "Others",
	// 				"content" => "Consultants, Media, Investors, Foodie, etc", "required" => "true"
	// 			)
	// 	],
	// 	"enquiry_popup_display" => [
	// 		"hospitality" => array(
	// 				"type" => "li_label", "css_classes" => "x-small", "id" => "", "name" => "", "value" => "", "for" => "hospitality", "title" => "Hospitality Business Owner",
	// 				"content" => "If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business", "parsley" => ["data-parsley-mincheck" => "1", "data-required" => "true", "data-parsley-errors-container" => "#describes-best-error"]
	// 			),
	// 		"professional" => array(
	// 				"type" => "li_label", "css_classes" => "x-small", "id" => "", "name" => "", "value" => "", "for" => "professional", "title" => "Working Professional",
	// 				"content" => "If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"
	// 			),
	// 		"vendor" => array(
	// 				"type" => "li_label", "css_classes" => "x-small", "id" => "", "name" => "", "value" => "", "for" => "vendor", "title" => "Vendor/Supplier/Service provider",
	// 				"content" => "If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"
	// 			),
	// 		"student" => array(
	// 				"type" => "li_label", "css_classes" => "x-small", "id" => "", "name" => "", "value" => "", "for" => "student", "title" => "Hospitality Student",
	// 				"content" => "If you are pursuing your education in hospitality sector currently"
	// 			),
	// 		"enterpreneur" => array(
	// 				"type" => "li_label", "css_classes" => "x-small", "id" => "", "name" => "", "value" => "", "for" => "enterpreneur", "title" => "Prospective Entrepreneur",
	// 				"content" => "If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"
	// 			),
	// 		"others" => array(
	// 				"type" => "li_label", "css_classes" => "x-small", "id" => "", "name" => "", "value" => "", "for" => "others", "title" => "Others",
	// 				"content" => "Consultants, Media, Investors, Foodie, etc", "required" => "true"
	// 			)
	// 	],
	// 	"list_view_enquiry_description" => [
	// 		array(
	// 				"type" => "option", "css_classes" => "", "id" => "", "name" => "description[]", "value" => "hospitality", "for" => "hospitality", "title" => "Hospitality Business Owner",
	// 				"content" => "If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business", "parsley" => ["data-parsley-mincheck" => "1", "data-required" => "true", "data-parsley-errors-container" => "#describes-best-error"]
	// 			),
	// 		array(
	// 				"type" => "option", "css_classes" => "", "id" => "", "name" => "description[]", "value" => "professional", "for" => "professional", "title" => "Working Professional",
	// 				"content" => "If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"
	// 			),
	// 		array(
	// 				"type" => "option", "css_classes" => "", "id" => "", "name" => "description[]", "value" => "vendor", "for" => "vendor", "title" => "Vendor/Supplier/Service provider",
	// 				"content" => "If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"
	// 			),
	// 		array(
	// 				"type" => "option", "css_classes" => "", "id" => "", "name" => "description[]", "value" => "student", "for" => "student", "title" => "Hospitality Student",
	// 				"content" => "If you are pursuing your education in hospitality sector currently"
	// 			),
	// 		array(
	// 				"type" => "option", "css_classes" => "", "id" => "", "name" => "description[]", "value" => "enterpreneur", "for" => "enterpreneur", "title" => "Prospective Entrepreneur",
	// 				"content" => "If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"
	// 			),
	// 		array(
	// 				"type" => "option", "css_classes" => "", "id" => "", "name" => "description[]", "value" => "others", "for" => "others", "title" => "Others",
	// 				"content" => "Consultants, Media, Investors, Foodie, etc", "required" => "true"
	// 			)
	// 	],
	// ];