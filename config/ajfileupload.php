<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', ],
	'valid_file_formats' => ['doc', 'docx', 'pdf'],
	'sizes' => [
		'thumb' => [
			'width' => 300,
			'height' => 150,
			'watermark' => [
				'image_path' => public_path().'/img/logo-fnb.png',
				'position'=>'bottom-right', 
				'x'=> 10, 
				'y'=>10
			],
		],
	],
	'model' => [
		'App\Company' => [
			'base_path' => 'company',
			'slug_column' => 'slug',
			'sizes' => ['thumb']
		],
	],
];