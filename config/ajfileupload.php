<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', 'jpeg', 'gif'],
	'valid_file_formats' => ['jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'png', 'pdf', 'ppt', 'pptx', 'pps', 'ppsx'],
	'sizes' => [
		'400X300' => [
			'width' => 400,
			'height' => 300,
			'watermark' => [
				'image_path' => public_path().'/img/fnb_watermark_60x60.png',
				'position'=>'bottom-left', 
				'x'=> 10, 
				'y'=>10
			],
		],
		'200x150' => [
			'width' => 200,
			'height' => 150,
			'watermark' => [
				'image_path' => public_path().'/img/fnb_watermark_30x30.png',
				'position'=>'bottom-left', 
				'x'=> 10, 
				'y'=>10
			],
		],
		'65x65' => [
			'width' => 65,
			'height' => 65,
			'watermark' => [
				'image_path' => public_path().'/img/fnb_watermark_30x30.png',
				'position'=>'bottom-left', 
				'x'=> 0, 
				'y'=>0
			],
		],
		'company_logo' => [
			'width' => 150,
			'height' => 150,
			'watermark' => [
				'image_path' => public_path().'/img/fnb_watermark_30x30.png',
				'position'=>'bottom-left', 
				'x'=> 10, 
				'y'=>10
			],
		],
		'company_thumb' => [
			'width' => 80,
			'height' => 80,
			'watermark' => [
				'image_path' => public_path().'/img/fnb_watermark_30x30.png',
				'position'=>'bottom-left', 
				'x'=> 10, 
				'y'=>10
			],
		],
		
	],
	'model' => [
		'App\Company' => [
			'base_path' => 'company',
			'slug_column' => 'slug',
			'sizes' => ['company_logo','company_thumb']
 		],
		'App\Listing' => [
			'base_path' => 'Listings',
			'slug_column' => 'slug',
			'sizes' => ['400X300','200x150']
		],
		'App\Category' => [
			'base_path' => 'Categories',
			'slug_column' => 'id',
			'sizes' => ['65x65']
		],
		'App\Update' => [
			'base_path' => 'Listings/Updates',
			'slug_column' => 'id',
			'sizes' => ['400X300','200x150']
		],
	],
];