<?php namespace WPDC_Podcast;

/**
 * Runtime Configuration file.
 *
 * @package     WPDC_Podcast
 * @since       1.1.1
 * @author      WPDevelopersClub, hellofromTonya, Alain Schlesser, Gary Jones
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 */

use WPDevsClub_Core\Config\Arr_Config;
use WPDevsClub_Core\Admin\Metabox\Metabox;
use WPDevsClub_Core\Custom\Custom_Post_Type;
use WPDevsClub_Core\Support\Template_Manager;

return array(

	/*********************************************************
	 * Initial Core Parameters, which are loaded into the
	 * Container before anything else occurs.
	 *
	 * Format:
	 *    $unique_id => $value
	 ********************************************************/

	'initial_parameters'        => array(
		'podcast_plugin_dir'    => WPDC_PODCAST_PLUGIN_DIR,
		'podcast_plugin_url'    => WPDC_PODCAST_PLUGIN_URL,
		'podcast_config_dir'    => WPDC_PODCAST_PLUGIN_DIR . 'config/',
	),

	/*********************************************************
	 * Back-End Service Providers -
	 * These service providers are loaded when 'admin_init' fires.
	 *
	 * Format:
	 *    $unique_id => array(
	 *      // When true, the instance is fetched out of the
	 *      // Container.
	 *      'autoload' => true|false,
	 *      // Closure that is loaded into the Container.
	 *      'concrete' => Closure,
	 ********************************************************/

	'be_service_providers'      => array(
		'metabox.podcast.podcast' => array(
			'autoload'          => true,
			'concrete'          => function( $container ) {
				return new Metabox(
					new Arr_Config(
						$container['podcast_config_dir'] . 'metaboxes/podcast.php',
						$container['core_config_defaults_dir'] . 'metabox.php'
					)
				);
			},
		),
		'metabox.podcast.podcast_single' => array(
			'autoload'          => true,
			'concrete'          => function( $container ) {
				return new Metabox(
					new Arr_Config(
						$container['podcast_config_dir'] . 'metaboxes/podcast-single.php',
						$container['core_config_defaults_dir'] . 'metabox.php'
					)
				);
			},
		),
	),

	/*********************************************************
	 * Front-End Service Providers -
	 * These service providers are loaded when 'genesis_init'
	 * fires and not in back-end.
	 *
	 * Format:
	 *    $unique_id => array(
	 *      // When true, the instance is fetched out of the
	 *      // Container.
	 *      'autoload' => true|false,
	 *      // Closure that is loaded into the Container.
	 *      'concrete' => Closure,
	 ********************************************************/

	'fe_service_providers'  => array(),

	/*********************************************************
	 * Front-End Service Providers -
	 * These service providers are loaded when 'genesis_init' fires.
	 *
	 * Format:
	 *    $unique_id => array(
	 *      // When true, the instance is fetched out of the
	 *      // Container.
	 *      'autoload' => true|false|callback,
	 *      // Closure that is loaded into the Container.
	 *      'concrete' => Closure,
	 ********************************************************/

	'both_service_providers'    => array(
		'cpt.podcast' => array(
			'autoload'          => true,
			'concrete'          => function( $container ) {
				return new Custom_Post_Type(
					new Arr_Config( $container['podcast_config_dir'] . 'cpts/podcast.php' ),
					'podcast'
				);
			},
		),
		'podcast.template_manager' => array(
			'autoload'          => true,
			'concrete'          => function( $container ) {
				return new Template_Manager(
					new Arr_Config(
						$container['podcast_config_dir'] . 'template-manager.php',
						$container['core_config_defaults_dir'] . 'support/template-manager.php'
					)
				);
			},
		),
	),

	/*********************************************************
	 * Extra Configuration Parameters -
	 * These are not loaded into the Container.
	 ********************************************************/

	'metaboxes' => array(
		'metabox.podcast.podcast',
		'metabox.podcast.podcast_single',
	),
);