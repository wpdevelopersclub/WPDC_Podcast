<?php namespace WPDC_Podcast;

/**
 * Podcast Single Metabox Configuration
 *
 * @package     WPDC_Podcast
 * @since       1.1.0
 * @author      WPDevelopersClub, hellofromTonya, Alain Schlesser, Gary Jones
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

return array(
	'view'         => WPDC_PODCAST_PLUGIN_DIR . 'src/views/admin/metabox-podcast-single.php',
	/****************************
	 * Meta config parameters
	 ****************************/
	'meta_name'    => 'wpdevsclub_podcast',
	'meta_single'  => array(),
	'meta_array'   => array(
		'meta_key'      => 'wpdevsclub_podcast',
		'meta_defaults' => array(
			'_video'                  => '',
			'_airdate'                => '',
			'_runtime'                => '',
			'_highlights'             => '',
			'_code_challenge_content' => '',
			'_transcript'             => '',
		),
		'sanitize'      => array(
			'_video'                  => 'strip_tags',
			'_airdate'                => 'strip_tags',
			'_runtime'                => 'strip_tags',
			'_highlights'             => 'wp_kses_post',
			'_code_challenge_content' => '',
			'_transcript'             => 'wp_kses_post',
		),
	),
	/****************************
	 * Metabox config parameters
	 ****************************/

	'nonce_action' => 'wpdevsclub_podcast_save',
	'nonce_name'   => 'wpdevsclub_podcast_nonce',
	'id'           => 'inpost_podcast_sections_metabox',
	'title'        => __( 'Podcast Sections', 'wpdc' ),
	'screen'       => array( 'podcast' ),

	/****************************
	 * Extra args
	 ****************************/
);