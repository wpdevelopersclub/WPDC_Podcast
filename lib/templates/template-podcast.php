<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Template Name: Podcast
 *
 * Podcast
 *
 * @package     WPDevsClub\Templates
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Support\Base_Template;
use WPDevsClub_Core\Models\Base as Model;

class Podcast extends Base_Template {

	/**************************
	 * Instantiate & Initialize
	 *************************/

	/**
	 * Initialize Properties
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_properties() {

		$this->body_classes = array(
			'wpdevsclub-podcast',
		);

		$this->config = array(
			'views'     => array(
				'main'          => '',
				'header'        => CHILD_DIR . '/lib/views/podcast/header.php',
				'section'       => CHILD_DIR . '/lib/views/podcast/section.php',
			),
		);
	}

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init() {

		$this->init_model();

		$this->init_page_hooks();
	}

	/**
	 * Initialize the Model
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_model() {

		$config = array(
			'meta_keys'                     => array(
				'wpdevsclub_podcast_sections'  => false,
			),
		);

		$this->model = new Model( $config, $this->post_id );
	}

	protected function init_page_hooks() {
		add_action( 'genesis_header',                           array( $this, 'do_header' ) );
		add_action( 'genesis_after_header',                     'genesis_do_subnav', 15 );

		// Remove primary navigation
		remove_action( 'genesis_before_content_sidebar_wrap',   'genesis_do_nav' );

		remove_action( 'genesis_loop',                          'genesis_do_loop' );
		add_action( 'genesis_loop',                             array( $this, 'render_sections' ) );

		remove_all_actions( 'genesis_entry_content' );
		remove_all_actions( 'genesis_entry_footer' );
		remove_all_actions( 'genesis_after_entry' );
	}

	public function do_header() {
		global $post;
		$content = do_shortcode( $post->post_content );
		$content = wpautop( $content );

		if ( is_readable( $this->config['views']['header'] ) ) {
			include( $this->config['views']['header'] );
		}
	}

	/**
	 * Render each of the sections
	 *
	 * @since 1.0.1
	 *
	 * @return null
	 */
	public function render_sections() {

		for ( $section = 1; $section <= 5; $section ++ ) {
			if ( ! $this->model->get_meta( "_section{$section}_content" ) ) {
				continue;
			}

			$id         = 'home-section-' . $section;

			$class      = $this->model->get_meta( "_section{$section}_class" );
			$class      = sprintf( 'section-%s home-section%s', $section, $class ? ' ' . $class : '' );

			$content    = do_shortcode( $this->model->get_meta( "_section{$section}_content" ) );
			$content    = intval( $this->model->get_meta( "_section{$section}_content_wpautop", 0 ) ) ? wpautop( $content ) : $content;

			if ( is_readable( $this->config['views']['header'] ) ) {
				include( $this->config['views']['section'] );
			}
		}
	}
}

global $post;

new Podcast( $post->ID );

genesis();