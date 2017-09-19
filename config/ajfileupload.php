<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', ],
	'valid_file_formats' => ['doc', 'docx', 'pdf'],
	'sizes' => [
		'thumb' => [
			'width' => 250,
			'height' => 188,
			'watermark' => [
				'image_path' => public_path().'/img/facebook.png',
				'position'=>'bottom-right', 
				'x'=> 10, 
				'y'=>10
			],
		],
	],
	'model' => [
		'App\City' => [
			'base_path' => 'cities',
			'slug_column' => 'slug',
			'sizes' => ['thumb']
		],
	],
];