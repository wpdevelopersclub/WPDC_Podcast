<?php namespace WPDC_Podcast;

/**
 *Podcast Landing Page Runtime Configuration
 *
 * @package     WPDC_Podcast
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Core;
use WPDevsClub_Core\Config\Arr_Config;
use WPDevsClub_Core\Models\Model;

global $post;
$core = Core::getCore();

return array(

	/*********************************************************
	 * Initial Core Parameters, which are loaded into the
	 * Container before anything else occurs.
	 *
	 * Format:
	 *    $unique_id => $value
	 ********************************************************/

	'initial_parameters'            => array(
		'post_id'                   => $post->ID,
		'podcast_post_id'           => 0,
		'date_formats'              => array(
			'upcoming'              => 'g:ia \C\S\T \o\n l jS F',
			'past'                  => 'jS F Y',
		),
		'site_layout'               => '__genesis_return_full_width_content',
		'grid_component_prefix'     => 'podcast.',
		'body_classes'              => array(
			'wpdevsclub-podcast-landing',
			'hero-header',
		),
		'config' => new Arr_Config(
			array(
				'model'                                 => array(
					'meta_keys'                         => array(
						'wpdevsclub_page_options'       => false,
						'wpdevsclub_podcast_sections'   => false,
					),
				),
				'podcast_model'                         => array(
					'meta_keys'                         => array(
						'wpdevsclub_page_options'       => false,
						'wpdevsclub_podcast'            => false,
					),
				),
				'podcast_query_args'                    => array(
					'post_type'                         => 'podcast',
					'paged'                             => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
				),
			)
		)
	),

	/*********************************************************
	 * Service Providers - Loaded into the Container
	 ********************************************************/

	'fe_service_providers'      => array(
		'model'                 => array(
			'autoload'          => false,
			'concrete'          => function( $container ) {
				return new Model( new Arr_Config( $container['config']->model ), $container['post_id'] );
			},
		),
		'podcast.model'         => array(
			'autoload'          => false,
			'concrete'          => $core->factory( function( $container ) {
				return new Model( new Arr_Config( $container['config']->podcast_model ), $container['podcast_post_id'] );
			} ),
		),
	),

	/*********************************************************
	 * Extras
	 ********************************************************/

	'use_get_post_for_header_page_content' => true,

	'sections'                  => array(
		'number_of_sections'    => 2,
		'prefix'                => 'podcast-section-',
		'class_prefix'          => 'podcast',
		'meta_key'              => 'wpdevsclub_podcast_sections',
		'patterns'              => array(
			'class'             => '_section%d_class',
			'content'           => '_section%d_content',
			'wpautop'           => '_section%d_content_wpautop',
		),
	),

	'views'             => array(
		'header'        => WPDC_PODCAST_PLUGIN_DIR . 'src/views/podcast/header.php',
		'section'       => WPDC_PODCAST_PLUGIN_DIR . 'src/views/podcast/section.php',
		'episode'       => WPDC_PODCAST_PLUGIN_DIR . 'src/views/podcast/episode.php',
	),
);
