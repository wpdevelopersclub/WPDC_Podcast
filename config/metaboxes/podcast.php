<?php namespace WPDC_Podcast;

/**
 * Podcast Metabox Configuration
 *
 * @package     WPDC_Podcast
 * @since       1.1.0
 * @author      WPDevelopersClub, hellofromTonya, Alain Schlesser, Gary Jones
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

return array(
	'classname'          => 'WPDevsClub_Core\Admin\Metabox\Metabox',
	'view'               => WPDC_PODCAST_PLUGIN_DIR . 'src/views/admin/metabox-podcast.php',
	/****************************
	 * Meta config parameters
	 ****************************/
	'meta_name'          => 'wpdevsclub_podcast_sections',
	'meta_single'        => array(),
	'meta_array'         => array(
		'meta_key'      => 'wpdevsclub_podcast_sections',
		'meta_defaults' => array(
			'_section1_content'         => '',
			'_section1_class'           => '',
			'_section1_content_wpautop' => 0,
			'_section2_content'         => '',
			'_section2_class'           => '',
			'_section2_content_wpautop' => 0,
		),
		'sanitize'      => array(
			'_section1_content'         => 'wp_kses_post',
			'_section1_class'           => 'strip_tags',
			'_section1_content_wpautop' => 'intval',
			'_section2_content'         => 'wp_kses_post',
			'_section2_class'           => 'strip_tags',
			'_section2_content_wpautop' => 'intval',
		),
	),
	/****************************
	 * Metabox config parameters
	 ****************************/

	'limit_to_template'  => array(
		'template' => 'templates/template-podcast.php',
		'screen'   => array( 'page' ),
	),
	'nonce_action'       => 'wpdevsclub_podcast_sections_save',
	'nonce_name'         => 'wpdevsclub_podcast_sections_nonce',
	'id'                 => 'inpost_podcast_sections_metabox',
	'title'              => __( 'Podcast Sections', 'wpdc' ),
	'screen'             => array( 'page' ),
	'context'            => 'normal',
	'priority'           => 'default',
	/****************************
	 * Extra args
	 ****************************/

	'number_of_sections' => 2,
);