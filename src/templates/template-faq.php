<?php namespace WPDC_Podcast\Templates;

/**
 * Template Name: Podcast FAQ
 *
 * Podcast FAQ
 *
 * @package     WPDC_Podcast\Templates
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Core;
use WPDC_Podcast\Templates_Classes\Page;
use WPDevsClub_Core\Config\Factory;

$core = Core::getCore();
new Page(
	Factory::create( WPDC_PODCAST_PLUGIN_DIR . 'config/templates/faq.php', $core['core_service_providers_dir'] . 'page.php' ),
	$core
);

genesis();