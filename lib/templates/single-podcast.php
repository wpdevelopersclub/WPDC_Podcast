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

		$this->init_model();
		$this->init_post_title();

		$this->init_post_meta();

		$this->init_comments();
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
				'wpdevsclub_page_options'   => false,
				'wpdevsclub_podcast'        => false,
			),
		);

		$this->model = new Model( $config, $this->post_id );
	}

	/**
	 * Initialize the Post Title
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_post_title() {
		$config = array(
			'views'         => array(
				'main'      => CHILD_DIR . '/lib/views/common/post-title.php',
			),
			'use_image'     => true,
			'use_overlay'   => true,
			'post_args'     => array(),
		);

		new Post_Title( $this->model, $config, $this->post_id );
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
	}

	public function do_sticky_footer() {
		$config = array(
			'theme_locations'   => array(
				'quick_links'   => 'sticky_footer_podcast_quick_links',
				'extras'        => 'sticky_footer_podcast_extras',
			),
		);
		do_action( 'wpdevsclub_do_sticky_footer', $this->model, $config, $this->post_id );
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

	protected function render_upcoming_episode( $view, $code_challenge ) {
		if ( is_readable( $view ) ) {
			include( $view );
		}
	}

	protected function render_past_episode( $view, $code_challenge ) {
		if ( is_readable( $view ) ) {
			include( $view );
		}
	}

	/**
	 * Initialize the Post Title
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_post_meta() {
		$config = array(
			'include_comment_link'  => true,
		);

		new Post_Meta( $config, $this->post_id );
	}

	/**
	 * Initialize the Related Articles
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function init_related() {
		$config = array(
			'post_type'     => array( 'post', 'podcast' ),
		);

		do_action( 'wpdevsclub_do_related_articles', $this->model, $this->post_id, $config );
	}

	/**
	 * Initialize the Post Title
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_comments() {
		$config = array(
			'views'        => array(
				'comments' => CHILD_DIR . '/lib/views/comments/comments.php',
			),

			'labels'                            => array(
				'title_comments'                => __( 'Share Your Thoughts', 'wpdevsclub' ),
				'reply_title'                   => __( 'Get the ball rolling', 'wpdevsclub' ),
				'title_reply_to'                => __( 'Join the Discussion for %s', 'wpdevsclub' ),
				'reply_title_has_comments'      => __( 'Join the Discussion', 'wpdevsclub' ),
				'title_reply_to_has_comments'   => __( 'Join the Discussion for %s', 'wpdevsclub' ),
			),

			'patterns'                          => array(
				'title_comments'                => '<h3>%s</h3><div class="comment-count"><div class="circle"><span>%d</span></div></div>',
				'wrap_opener'                   => '<section id="wpdevsclub-comments"><div class="wrap">',
				'wrap_closer'                   => '</div></section>',
				'comment_form_field_comment'    => '</div><div class="one-half">%s</div><div class="clearfix"></div>',
			),

			/****************************
			 * Extras
			 **************************/

			'comment_list_args'                 => array(
				'avatar_size'                   => 64,
				'reply_text'                    => '<i class="fa fa-reply"></i>',
			),
		);

		remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );
		add_action( 'genesis_after_entry', 'genesis_get_comments_template', 99 );

		new Comments( $config );
	}
}

global $post;

new Single_Podcast( $post->ID );

genesis();