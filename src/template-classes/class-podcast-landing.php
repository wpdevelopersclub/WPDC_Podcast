<?php namespace WPDC_Podcast\Templates_Classes;

/**
 * Podcast Landing
 *
 * @package     WPDC_Podcast\Templates
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Support\Template;
use WP_Query;
use WPDevsClub_Core\Models\I_Model;

class Podcast_Landing extends Template {

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
	 * Indicates whether to show the Title Header Section
	 *
	 * @var bool
	 */
	protected $is_new_section = true;

	/**
	 * Indicates if the upcoming episoder header has
	 * already been rendered
	 *
	 * @var bool
	 */
	protected $upcoming_episode_header_rendered = false;

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

	protected function init_child_events() {
		add_action( 'genesis_header',                           array( $this, 'render_page_header' ) );
		remove_action( 'genesis_before_content_sidebar_wrap',   'genesis_do_nav' );

		add_action( 'genesis_before_loop',                      array( $this, 'render_sections') );
		remove_action( 'genesis_loop',                          'genesis_do_loop' );

		add_action( 'genesis_before_loop',                      array( $this, 'do_the_grid' ), 20 );
		add_action( 'genesis_after_header',                     'genesis_do_subnav', 11 );
	}

	/*****************
	 * Callbacks
	 ****************/

	/**
	 * Render the content's HTML
	 *
	 * @since 1.1.1
	 *
	 * @return null
	 */
	public function do_the_grid() {
		global $wp_query;
		$wp_query = new WP_Query( $this->core['config']['podcast_query_args'] );

		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				$this->render_podcast();
				$this->is_new_section = false;
			endwhile;
			genesis_numeric_posts_nav();
			wp_reset_query();
		endif;
	}

	/**
	 * Initialize the Related Articles
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function init_related() {
		do_action( 'wpdevsclub_do_related_articles', $this->core['model'], $this->core['post_id'], $this->config->related );
	}

	/**
	 * Time to do the sticky footer
	 *
	 * @since 1.1.1
	 *
	 * @uses action event 'wpdevsclub_do_sticky_footer'
	 *
	 * @return null
	 */
	public function do_sticky_footer() {
		do_action( 'wpdevsclub_do_sticky_footer', $this->core['model'], $this->config['sticky_footer'], $this->core['post_id'], $this->core );
	}

	/*****************
	 * Helpers
	 ****************/

	/**
	 * Render the Podcast Episode
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function render_podcast() {
		$model = $this->fetch_model();

		$content = wpautop( $model->get_meta( '_tldr', 'wpdevsclub_page_options' ) );
		$this->fetch_dates( $model );

		include ( $this->config->views['episode'] );
	}

	/**
	 * Fetch the model out of the Container
	 *
	 * @since 1.0.0
	 *
	 * @return I_Model
	 */
	protected function fetch_model() {
		$this->core['podcast_post_id'] = get_the_ID();

		return $this->core['podcast.model'];
	}

	/**
	 * Fetch the episodes dates
	 *
	 * @since 1.0.0
	 *
	 * @param I_Model $model
	 */
	protected function fetch_dates( I_Model &$model ) {
		$this->airdate              = $model->get_meta( '_airdate', 'wpdevsclub_podcast' );
		$this->formatted_airdate    = wpdevsclub_format_string_to_datetime(
			$this->airdate,
			$this->is_upcoming_episode ? $this->core['date_formats']['upcoming'] : $this->core['date_formats']['past']
		);

		$this->is_upcoming_episode  = wpdevsclub_is_later_than_now( $this->airdate );
		$this->is_ok_to_display_new_section();
		$this->is_past_episode      = ! $this->is_upcoming_episode;
	}

	/**
	 * Check if it's ok to display the new section header
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function is_ok_to_display_new_section() {
		$this->is_new_section = ( $this->is_upcoming_episode && ! $this->upcoming_episode_header_rendered ) ||
		                        ( ! $this->is_upcoming_episode && ! $this->is_past_episode );

		if ( $this->is_upcoming_episode && $this->is_new_section ) {
			$this->upcoming_episode_header_rendered = true;
		}
	}

	/**
	 * Fetch the entry attributes
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function fetch_entry_attr() {
		$entry_attr     = genesis_attr( 'entry' );
		return $this->is_upcoming_episode ? str_replace( 'class="', 'class="upcoming ', $entry_attr ) : $entry_attr;
	}
}