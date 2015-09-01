<?php namespace WPDC_Podcast\Templates_Classes;

/**
 * Page
 *
 * @package     WPDC_Podcast\Templates
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Support\Template;

class Page extends Template {

	/**************************
	 * Instantiate & Initialize
	 *************************/

	/**
	 * Initialize Child Events
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_child_events() {
		add_action( 'genesis_after_header',     'genesis_do_subnav', 11 );
		if ( $this->core->has( 'config.sticky_footer' ) ) {
			add_action( 'genesis_after_content', array( $this, 'do_sticky_footer' ) );
		}
	}
}