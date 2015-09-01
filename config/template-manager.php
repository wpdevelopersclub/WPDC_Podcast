<?php namespace WPDC_Podcast;


return array(
	'template_folder_path'      => WPDC_PODCAST_PLUGIN_DIR . 'src/templates/',
	'post_type'                 => 'podcast',
	'use_single'                => true,
	'use_archive'               => false,
	'use_catagory'              => false,
	'use_tax'                   => false,
	'use_tag'                   => false,
	'use_page_templates'        => true,
	'templates'                 => array(
		'template-podcast.php'  => __( 'Podcast Landing', 'wpdc' ),
		'template-page.php'     => __( 'Podcast Page', 'wpdc' ),
		'template-faq.php'      => __( 'Podcast FAQ', 'wpdc' ),
	),
);