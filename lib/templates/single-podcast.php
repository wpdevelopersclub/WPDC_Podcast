<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Single Podcast
 *
 * @package     WPDevsClub_Podcast\Templates
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Support\Base_Template;
use WPDevsClub_Core\Models\Base as Model;
use WPDevsClub_Core\Structures\Post\Post_Title;
use WPDevsClub_Core\Structures\Post\Post_Meta;
use WPDevsClub_Core\Structures\Comments;

class Single_Podcast extends Base_Template {

	protected $post_type;

	protected $use_sidebar = false;

	protected $upcoming = false;

	protected $past_episode = false;

	protected $airdate = '';

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
	}

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init() {
		$this->init_hooks();

		$this->init_object_factory();
	}

	/**
	 * Initialize the Model
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_object_factory() {

		$this->model = new Model( $this->config['model'], $this->post_id );
		new Post_Title( $this->model, $this->config['post_title'], $this->post_id );
		new Post_Meta( $this->config['post_meta'], $this->post_id );
		new Comments( $this->config['comments'] );
	}

	/**
	 * Initialize the hooks
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_hooks() {

		add_action( 'genesis_meta',                 array( $this, 'init_related' ) );
		add_action( 'genesis_after_header',         'genesis_do_subnav', 11 );

		remove_all_actions( 'genesis_entry_header' );

		// Replace the content HTML with this new version to allow
		// sidebar to be only within the content area.
		if ( $this->use_sidebar ) {
			add_filter( 'genesis_attr_podcast-content', 'genesis_attributes_content' );
			add_action( 'genesis_before_entry', array( $this, 'main_markup_open' ) );
			add_action( 'genesis_after_entry', array( $this, 'main_markup_close' ), 98 );

			// Remove the content HTML
			remove_filter( 'genesis_attr_content',  'genesis_attributes_content' );
			add_filter( 'genesis_markup_content', function ( $pre, $args ) {
				return true;
			}, 10, 2 );
			add_filter( 'genesis_markup_', function ( $pre, $args ) {
				return '</main>' == $args['html5'] ? true : $pre;
			}, 10, 2 );

		} else {
			remove_action( 'genesis_before_loop',   'genesis_do_breadcrumbs' );
			add_action( 'genesis_entry_content',    'genesis_do_breadcrumbs', 1 );
		}

		add_action( 'genesis_entry_content',        array( $this, 'render_content' ) );
		remove_action( 'genesis_entry_content',     'genesis_do_post_image', 8 );
		remove_action( 'genesis_entry_content',     'genesis_do_post_content' );

		add_action( 'genesis_after_content',        array( $this, 'do_sticky_footer' ) );

		// Comments
		remove_action( 'genesis_after_entry',       'genesis_get_comments_template' );
		add_action( 'genesis_after_entry',          'genesis_get_comments_template', 99 );
	}

	/*****************
	 * Callbacks
	 ****************/

	/**
	 * Time to do the sticky footer
	 *
	 * @since 1.0.0
	 *
	 * @uses action event 'wpdevsclub_do_sticky_footer'
	 *
	 * @return null
	 */
	public function do_sticky_footer() {
		do_action( 'wpdevsclub_do_sticky_footer', $this->model, $this->config['sticky_footer'], $this->post_id );
	}

	/**
	 * Relocating the <main> markup to before the entry to encase the content + related posts
	 *
	 * Note:    This is necessary to allow comments to appear at the bottom of the page in mobile
	 *          devices, i.e. as we want the sidebar to be before comments.
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function main_markup_open() {
		genesis_markup( array(
			'html5'   => '<section class="content"><main %s>',
			'xhtml'   => '<div id="podcast-content" class="hfeed">',
			'context' => 'podcast-content',
		) );
	}

	/**
	 * Close up the main markup and add in the sidebar
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function main_markup_close() {
		echo '</main>';
		$this->init_sidebar();
		echo '</section>';
	}

	public function render_content() {
		$now                    = wpdevsclub_get_current_datetime();
		$raw_airdate            = $this->model->get_meta( '_airdate', 'wpdevsclub_podcast' );

		$this->upcoming         = wpdevsclub_is_later_than_now( $raw_airdate, $now );
		$this->airdate          = wpdevsclub_format_string_to_datetime( $raw_airdate, $this->upcoming ? 'g:ia \C\S\T \o\n l jS F' : 'jS F Y' );
		$publish_datetime       = wpdevsclub_add_hours_to_datetime( 1, $raw_airdate );

		$this->past_episode     = $now >= $publish_datetime ? true : false;

		$view                   = WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/single/episode.php';
		if ( is_readable( $view ) ) {
			include( $view );
		}
	}

	/**
	 * Initialize the Related Articles
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function init_related() {
		do_action( 'wpdevsclub_do_related_articles', $this->model, $this->post_id, $this->config['related'] );
	}
}

$config = include( WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'config/templates/single.php' );
new Single_Podcast( 0, $config );

genesis();