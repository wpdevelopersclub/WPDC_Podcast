<?php namespace WPDC_Podcast\Templates;

/**
 * Template Name: Podcast
 *
 * Podcast
 *
 * @package     WPDC_Podcast\Templates
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Core;
use WPDevsClub_Core\Config\Factory;
use WPDC_Podcast\Templates_Classes\Podcast_Landing;

$core = Core::getCore();
new Podcast_Landing(
	Factory::create( WPDC_PODCAST_PLUGIN_DIR . 'config/templates/podcast-landing.php' ),
	$core
);

genesis();