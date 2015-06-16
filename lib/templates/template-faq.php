<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Template Name: Podcast FAQ
 *
 * Podcast FAQ
 *
 * @package     WPDevsClub\Templates
 * @since       1.0.0
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

global $post;

$config = array(
	'body_classes'          => array(
		'wpdevsclub-podcast-faq'
	),
	'sticky_footer'         => array(
		'theme_locations'   => array(
			'quick_links'   => 'sticky_footer_podcast_faq_quick_links',
			'extras'        => 'sticky_footer_podcast_faq_extras',
		),
	),
);

new Podcast_FAQ( $post->ID, $config );

genesis();