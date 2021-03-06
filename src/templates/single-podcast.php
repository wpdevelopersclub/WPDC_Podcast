<?php namespace WPDC_Podcast\Templates;

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

use WPDevsClub_Core\Core;
use WPDC_Podcast\Templates_Classes\Single;
use WPDevsClub_Core\Config\Factory;

$core = Core::getCore();

$config = Factory::create( WPDC_PODCAST_PLUGIN_DIR . 'config/templates/single.php', $core['core_service_providers_dir'] . 'single.php' );

do_action( 'wpdevclub_setup_related_articles',
	Factory::create( $config->initial_parameters['config']['related'], $core['related.config.plugin'] )
);

new Single( $config, $core );

genesis();