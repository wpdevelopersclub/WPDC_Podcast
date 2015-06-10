<?php namespace WPDevsClub_Podcast;

/**
 * WPDevsClub Podcast
 *
 * @package     WPDevsClub_Podcast
 * @since       1.0.5
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

// Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

use WPDevsClub_Core\Support\Template_Manager;
use WPDevsClub_Core\Admin\Metabox\Metabox;
use WPDevsClub_Core\Custom\Custom_Post_Type;

final class Plugin {

	/**
	 * The plugin's version
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * The plugin's minimum WordPress requirement
	 *
	 * @var string
	 */
	const MIN_WP_VERSION = '3.5';

	/**
	 * Configuration parameters
	 *
	 * @var array
	 */
	protected $config = array();

	/*************************
	 * Getters
	 ************************/

	public function version() {
		return self::VERSION;
	}

	public function min_wp_version() {
		return self::MIN_WP_VERSION;
	}

	/**************************
	 * Instantiate & Initialize
	 *************************/

	/**
	 * Instantiate the plugin
	 *
	 * @since 1.0.0
	 *
	 * @param array     $config
	 * @return self
	 */
    public function __construct( array $config ) {
	    $this->config = $config;

	    $this->init_hooks();

	    do_action( 'wpdevsclub_podcast_loaded' );
    }

	/**
	 * Initialize hooks
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
    protected function init_hooks() {

	    add_action( 'wpdevsclub_admin_init',            array( $this, 'init_admin' ) );

    	add_action( 'wpdevsclub_init_object_factory',   array( $this, 'init_object_factory' ) );
    }

	public function init_admin() {
		$config = wpdevsclub_load_config( 'metaboxes.php',  $this->config['config_path'] );
		foreach ( $config as $key => $mb_config ) {
			new Metabox( $mb_config );
		}
	}

	/**
	 * Instantiate each of the plugin objects
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function init_object_factory() {
		$config = wpdevsclub_load_config( 'cpts.php',  $this->config['config_path'] );
		new Custom_Post_Type( $config, $this->config['cpt_post_type'] );

		new Template_Manager( $this->config['template_manager'] );
	}
}