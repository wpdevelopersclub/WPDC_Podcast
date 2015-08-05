<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Template Name: Podcast Page
 *
 * Podcast Page
 *
 * @package     WPDevsClub\Templates
 * @since       1.0.1
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

$config = include( WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'config/templates/page.php' );
new Podcast_Page( 0, $config );

genesis();