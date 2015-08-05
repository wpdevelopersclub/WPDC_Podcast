<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Template Name: Podcast FAQ
 *
 * Podcast FAQ
 *
 * @package     WPDevsClub\Templates
 * @since       1.0.1
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Podcast\Support\Base_Template;

class Podcast_FAQ extends Base_Template {

	protected function init_podcast_page_hooks() {
		add_action( 'genesis_after_header',     'genesis_do_subnav', 11 );
		add_action( 'genesis_after_content',    array( $this, 'do_sticky_footer' ) );
	}

	public function do_sticky_footer() {
		do_action( 'wpdevsclub_do_sticky_footer', $this->model, $this->config['sticky_footer'], $this->post_id );
	}
}

$config = include( WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'config/templates/faq.php' );
new Podcast_FAQ( 0, $config );

genesis();