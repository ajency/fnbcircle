<?php
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
	return [
		"register_description" => [
			array(
					"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "hospitality", "for" => "hospitality", "title" => "Hospitality Business Owner",
					"content" => "If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business"
				),
			array(
					"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "professional", "for" => "professional", "title" => "Working Professional",
					"content" => "If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"
				),
			array(
					"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "vendor", "for" => "vendor", "title" => "Vendor/Supplier/Service provider",
					"content" => "If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"
				),
			array(
					"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "student", "for" => "student", "title" => "Hospitality Business Owner",
					"content" => "Consultants, Media, Investors, Foodie, etc"
				),
			array(
					"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "enterpreneur", "for" => "enterpreneur", "title" => "Prospective Entrepreneur",
					"content" => "If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"
				),
			array(
					"type" => "checkbox", "css_classes" => "checkbox", "id" => "", "name" => "description[]", "value" => "others", "for" => "others", "title" => "Others",
					"content" => "Consultants, Media, Investors, etc"
				)
		]		
	];