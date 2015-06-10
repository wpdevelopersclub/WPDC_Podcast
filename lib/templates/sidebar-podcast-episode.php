<?php namespace WPDevsClub_Podcast\Templates;

/**
 * Sidebar Podcast Episode
 *
 * @package     WPDevsClub_Podcast\Templates
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

//* Output secondary sidebar structure
genesis_markup( array(
	'html5'   => '<aside %s>',
	'xhtml'   => '<div id="sidebar-alt" class="sidebar widget-area">',
	'context' => 'sidebar-podcast-episode',
) );

do_action( 'wpdevsclub_before_sidebar_alt_widget_area' );
do_action( 'genesis_sidebar_alt' );
do_action( 'genesis_after_sidebar_alt_widget_area' );

genesis_markup( array(
	'html5' => '</aside>', // end .sidebar-podcast-episode
	'xhtml' => '</div>', // end #sidebar-podcast-episode
) );