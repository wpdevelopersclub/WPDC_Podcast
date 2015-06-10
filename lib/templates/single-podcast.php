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
use WPDevsClub_Core\Structures\Post\Post;
use WPDevsClub_Core\Structures\Post\Post_Info;
use WPDevsClub_Core\Structures\Post\Post_Meta;
use WPDevsClub_Core\Structures\Related;
use WPDevsClub_Core\Structures\Comments;

class Single_Podcast extends Base_Template {

	protected $post_type;

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
		add_filter( 'genesis_attr_podcast-content', 'genesis_attributes_content' );
		add_action( 'genesis_before_entry',         array( $this, 'main_markup_open' ) );
		add_action( 'genesis_after_entry',          array( $this, 'main_markup_close' ), 98 );

		// Remove the content HTML
		remove_filter( 'genesis_attr_content',      'genesis_attributes_content' );
		add_filter( 'genesis_markup_content',       function( $pre, $args ) {
			return true;
		}, 10, 2 );
		add_filter( 'genesis_markup_',              function( $pre, $args ) {
			return '</main>' == $args['html5'] ? true : $pre;
		}, 10, 2 );

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
		global $tonya_debug;

		$this->render_video();

		$code_challenge = do_shortcode( $this->model->get_meta( '_code_challenge_content', 'wpdevsclub_podcast' ) );
		$transcript     = do_shortcode( $this->model->get_meta( '_transcript', 'wpdevsclub_podcast' ) );

		$view = WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/single/podcast.php';
		if ( is_readable( $view ) ) {
			include( $view );
		}
	}

	/**
	 * Render the video
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function render_video() {
		$video_src = $this->model->get_meta( '_video', 'wpdevsclub_podcast', false );
		if ( false == $video_src ) {
			return;
		}
		$video = sprintf( '[video src="%s" width="853" height="480"]', esc_url( $video_src ) );
		echo do_shortcode( $video );
	}

	/**
	 * Initialize the Post Title
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_post_info() {

		$config = array(
			'views'         => array(
				'main'      => WPDEVSCLUB_PODCAST_PLUGIN_DIR . 'lib/views/podcast/single/post-info.php',
			),
		);

		new Post_Info( $this->model, $config, $this->post_id, 0 );
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

	public function init_sidebar() {

//		$numnber_of_sponsors_oa = $this->model->get_meta( '_number_sponsor_oa', 'wpdevsclub_podcast' );
//		$numnber_of_sponsors    = $this->model->get_meta( '_number_sponsor', 'wpdevsclub_podcast' );
//		$content                = $this->model->get_meta( '_sidebar_content', 'wpdevsclub_podcast' );
//
//		$views = array();
//		if ( $numnber_of_sponsors_oa > 0 ) {
//			$views['sponsor_oa'] = CHILD_DIR . '/lib/views/sidebar/sponsor/sponsor-oa.php';
//		}
//		if ( $numnber_of_sponsors > 0 ) {
//			$views['sponsor']   = CHILD_DIR . '/lib/views/sidebar/sponsor/sponsor.php';
//		}
//		if ( $content ) {
//			$content            = do_shortcode( stripslashes( $content ) );
//			$views['content']   = CHILD_DIR . '/lib/views/sidebar/sponsor/content.php';
//		}
//
//		include( CHILD_DIR . '/lib/views/sidebar/sponsors.php' );
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
$tonya_debug = false;
global $post;

new Single_Podcast( $post->ID );

genesis();