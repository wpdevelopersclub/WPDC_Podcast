<?php namespace WPDC_Podcast;

/**
 * Podcast Plugin
 *
 * @package     WPDC_Podcast
 * @since       1.1.1
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

// Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

use WPDevsClub_Core\Addons\Addon;

final class Podcast extends Addon {

	/**
	 * The plugin's version
	 *
	 * @var string
	 */
	const VERSION = '1.1.1';

	/**
	 * The plugin's minimum WordPress requirement
	 *
	 * @var string
	 */
	const MIN_WP_VERSION = '3.5';

	/*************************
	 * Instantiate & Init
	 ************************/

	/**
	 * Addons can overload this method for additional functionality
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_addon() {
		do_action( 'wpdevsclub_podcast_loaded' );
	}
}