<?php namespace WPDevsClub_Podcast\Support;

/**
 * Base Template
 *
 * @package     WPDevsClub_Podcast\Support
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Support\Base_Template as Base;
use WPDevsClub_Core\Models\Base as Model;
use WPDevsClub_Core\Structures\Post\Post_Title;
use WPDevsClub_Core\Structures\Post\Post;

abstract class Base_Template extends Base {

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
		$this->body_classes = $this->config['body_classes'];
	}

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init() {
		$this->init_model();
		$this->init_post_title();
		$this->init_post();

		$this->init_podcast_page_hooks();
	}

	abstract protected function init_podcast_page_hooks();

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
			'remove_actions'    => array(
				array(
					'hook'      => 'genesis_entry_header',
					'callback'  => 'genesis_do_post_format_image',
					'priority'  => 4,
				),
				array(
					'hook'      => 'genesis_entry_header',
					'callback'  => 'genesis_do_post_title',
					'priority'  => 10,
				),
			),
			'use_image'     => true,
			'use_overlay'   => true,
			'post_args'     => array(),
		);

		new Post_Title( $this->model, $config, $this->post_id );
	}

	/**
	 * Initialize the Post Title
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_post() {
		$config = array(
			'views'             => array(
				'tldr'          => CHILD_DIR . '/lib/views/common/tldr.php',
			),
			'layout'            => '__genesis_return_full_width_content',
			'body_classes'      => $this->config['body_classes'],
			'labels'            => array(
				'tldr'          => __( 'tl;dr', 'wpdevsclub' ),
			),
		);

		new Post( $this->model, $config, $this->post_id );
	}
}