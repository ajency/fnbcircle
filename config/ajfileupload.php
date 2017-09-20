<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', ],
	'valid_file_formats' => ['doc', 'docx', 'pdf'],
	'sizes' => [
		'400X300' => [
			'width' => 400,
			'height' => 300,
			'watermark' => [
				'image_path' => public_path().'/img/ksl_watermark_new.png',
				'position'=>'bottom-left', 
				'x'=> 10, 
				'y'=>10
			],
		],
		'200x150' => [
			'width' => 200,
			'height' => 150,
			'watermark' => [
				'image_path' => public_path().'/img/ksl_watermark_new.png',
				'position'=>'bottom-left', 
				'x'=> 10, 
				'y'=>10
			],
		],
	],
	'model' => [
		'App\Listing' => [
			'base_path' => 'Listings',
			'slug_column' => 'slug',
			'sizes' => ['400X300','200x150']
		],
	],
];