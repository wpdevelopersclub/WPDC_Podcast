<?php

return array(

	/*************
	 * Views
	 ************/

	'views'                                 => array(
		'header'                            => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/header.php',
		'section'                           => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/section.php',
		'episode'                           => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/episode.php',
	),

	/*************
	 * Model
	 ************/

	'model'                                 => array(
		'meta_keys'                         => array(
			'wpdevsclub_page_options'       => false,
			'wpdevsclub_podcast_sections'   => false,
		),
	),

	/*************
	 * Extras
	 ************/

	'number_of_sections'                    => 2,


	/*************
	 * Podcast
	 ************/

	'podcast_model'                         => array(
		'meta_keys'                         => array(
			'wpdevsclub_page_options'       => false,
			'wpdevsclub_podcast'            => false,
		),
	),
);