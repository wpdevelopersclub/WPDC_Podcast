<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Template Name: Podcast Page
 *
 * Podcast Page
 *
 * @package     WPDevsClub\Templates
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Podcast\Support\Base_Template;

class Podcast_Page extends Base_Template {

	protected function init_podcast_page_hooks() {
		add_action( 'genesis_after_header',     'genesis_do_subnav', 11 );
	}
}

global $post;

$config = array(
	'body_classes'  => array(
		'wpdevsclub-podcast-page',
	),
);

new Podcast_Page( $post->ID, $config );

genesis();