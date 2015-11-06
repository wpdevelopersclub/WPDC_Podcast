<?php namespace WPDC_Podcast\Templates_Classes;

/**
 * Single Podcast
 *
 * @package     WPDC_Podcast\Templates
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Support\Template;

class Single extends Template {

	/**
	 * Indicates an upcoming episode
	 *
	 * @var bool
	 */
	protected $is_upcoming_episode = false;

	/**
	 * Indicates a past episode
	 *
	 * @var bool
	 */
	protected $is_past_episode = false;

	/**
	 * Episode Air Date (raw from meta)
	 *
	 * @var string
	 */
	protected $airdate = '';

	/**
	 * Episode Air Date Formatted for rendering
	 *
	 * @var string
	 */
	protected $formatted_airdate = '';

	/**************************
	 * Instantiate & Initialize
	 *************************/

	/**
	 * Initialize child events
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_child_events() {
		add_action( 'genesis_meta',                 array( $this, 'init_related' ) );
		add_action( 'genesis_after_header',         'genesis_do_subnav', 11 );

		remove_all_actions( 'genesis_entry_header' );


		remove_action( 'genesis_before_loop',       'genesis_do_breadcrumbs' );
		add_action( 'genesis_entry_content',        'genesis_do_breadcrumbs', 1 );

		add_action( 'genesis_entry_content',        array( $this, 'render_content' ) );
		remove_action( 'genesis_entry_content',     'genesis_do_post_image', 8 );
		remove_action( 'genesis_entry_content',     'genesis_do_post_content' );

		add_action( 'genesis_after_content', array( $this, 'do_sticky_footer' ) );

		remove_action( 'genesis_after_entry',       'genesis_get_comments_template' );
		add_action( 'genesis_after_entry',          'genesis_get_comments_template', 99 );
	}

	/*****************
	 * Callbacks
	 ****************/

	/**
	 * Render the content's HTML
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function render_content() {
//		$model      = $this->core['model'];
		$video_src  = $this->core['model']->get_meta( '_video', 'wpdevsclub_podcast', false );
		$this->fetch_dates();

		$view  = WPDC_PODCAST_PLUGIN_DIR . 'src/views/podcast/single/episode.php';
		if ( is_readable( $view ) ) {
			include( $view );
		}
	}

	/**
	 * Fetch the episodes dates
	 *
	 * @since 2.0.1
	 *
	 * @return null
	 */
	protected function fetch_dates() {
		$now                        = wpdevsclub_get_current_datetime();
		$this->airdate              = $this->get_meta( '_airdate', 'wpdevsclub_podcast' );
		$this->is_upcoming_episode  = wpdevsclub_is_later_than_now( $this->airdate, $now );
		
		$this->formatted_airdate    = wpdevsclub_format_string_to_datetime(
			$this->airdate,
			$this->is_upcoming_episode ? $this->core['date_formats']['upcoming'] : $this->core['date_formats']['past']
		);

		$this->is_past_episode      = $now >= wpdevsclub_add_hours_to_datetime( 1, $this->airdate ) ? true : false;
	}

	/**
	 * Initialize the Related Articles
	 *
	 * @since 1.0.0
	 *
	 * @uses action event 'wpdevsclub_do_related_articles'
	 *
	 * @return null
	 */
	public function init_related() {
		do_action( 'wpdevsclub_do_related_articles',
			$this->core['single.config.related'],
			$this->core['model'],
			$this->core['post_id'],
			$this->core
		);
	}
}