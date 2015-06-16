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
use WP_Query;

class Podcast_Landing extends Base_Template {

	/**
	 * Instance of the Post Model
	 *
	 * @var Model
	 */
	protected $podcast_model;

	/**
	 * Podcast's Post ID
	 *
	 * @var int
	 */
	protected $podcast_id;

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
			'wpdevsclub-podcast-landing',
			'hero-header',
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

		$this->init_config();

		$this->init_page();
		add_action( 'genesis_before_loop', array( $this, 'init_grid' ), 20 );
		add_action( 'genesis_after_header',     'genesis_do_subnav', 11 );
	}

	/**
	 * Initialize the Model
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_config() {
		$this->config = array(
			'views'                                 => array(
				'header'                            => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/header.php',
				'section'                           => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/section.php',
				'episode'                           => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/episode.php',
			),
			'model'                                 => array(
				'meta_keys'                         => array(
					'wpdevsclub_page_options'       => false,
					'wpdevsclub_podcast_sections'   => false,
				),
			),
			'number_of_sections'                    => 2,
		);
	}

	/**
	 * Initialize the Page
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_page() {

		$this->model = new Model( $this->config['model'], $this->post_id );
		add_action( 'genesis_header',                           array( $this, 'do_header' ) );
		remove_action( 'genesis_before_content_sidebar_wrap',   'genesis_do_nav' );

		add_action( 'genesis_before_loop',                      array( $this, 'render_sections') );
		remove_action( 'genesis_loop',                          'genesis_do_loop' );
	}

	/**
	 * Do the hero header
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function do_header() {
		$post       = get_post( $this->post_id );
		$content    = do_shortcode( $post->post_content );
		$content    = wpautop( $content );

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

		for ( $section = 1; $section <= $this->config['number_of_sections']; $section ++ ) {

			if ( ! $this->model->get_meta( "_section{$section}_content", 'wpdevsclub_podcast_sections' ) ) {
				continue;
			}

			$id         = 'podcast-section-' . $section;

			$class      = $this->model->get_meta( "_section{$section}_class", 'wpdevsclub_podcast_sections' );
			$class      = sprintf( 'section-%s podcast-section%s', $section, $class ? ' ' . $class : '' );

			$content    = do_shortcode( $this->model->get_meta( "_section{$section}_content", 'wpdevsclub_podcast_sections' ) );
			$content    = intval( $this->model->get_meta( "_section{$section}_content_wpautop", 'wpdevsclub_podcast_sections', 0 ) ) ? wpautop( $content ) : $content;

			if ( is_readable( $this->config['views']['header'] ) ) {
				include( $this->config['views']['section'] );
			}
		}
	}

	/**
	 * Initialize the Grid
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function init_grid() {
		$upcoming_title_shown = $past_shown = false;

		$query_args = array(
			'post_type' => 'podcast',
			'paged'     => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		);

		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) : $query->the_post();
				$podcast_id     = get_the_ID();
				$model          = $this->init_podcast_model( $podcast_id );
				$content        = wpautop( $model->get_meta( '_tldr', 'wpdevsclub_page_options' ) );
				$airdate        = $model->get_meta( '_airdate', 'wpdevsclub_podcast' );
				$upcoming       = wpdevsclub_is_later_than_now( $airdate );
				$date_format    = $upcoming ? 'g:ia \C\S\T \o\n l jS F' : 'jS F Y';

				$entry_attr     = genesis_attr( 'entry' );
				$entry_attr     = $upcoming ? str_replace( 'class="', 'class="upcoming ', $entry_attr ) : $entry_attr;

				include ( $this->config['views']['episode'] );

				if ( $upcoming && ! $upcoming_title_shown ) {
					$upcoming_title_shown = true;
				} elseif ( ! $past_shown ) {
					$past_shown = true;
				}

			endwhile;

			wp_reset_postdata();
		endif;

	}

	public function init_podcast_model( $post_id ) {

		return new Model(
			array(
				'meta_keys'                         => array(
					'wpdevsclub_page_options'       => false,
					'wpdevsclub_podcast'            => false,
				),
			),
			$post_id
		);
	}
}

global $post;

new Podcast_Landing( $post->ID );

genesis();