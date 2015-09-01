<?php namespace WPDC_Podcast\Templates;

/**
 * Single Podcast Runtime Configuration
 *
 * @package     WPDC_Podcast\Templates
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Config\Arr_Config;

return array(

	/*********************************************************
	 * Initial Core Parameters, which are loaded into the
	 * Container before anything else occurs.
	 *
	 * Format:
	 *    $unique_id => $value
	 ********************************************************/

	'initial_parameters'    => array(
		'body_classes'      => array( 'wpdevsclub-podcast' ),
		'date_formats'      => array(
			'upcoming'      => 'g:ia \C\S\T \o\n l jS F',
			'past'          => 'jS F Y',
		),
		'related.post_type' => array( 'podcast' ),
		'config'            => new Arr_Config(
			array(
				'model'                             => array(
					'meta_keys'                     => array(
						'wpdevsclub_page_options'   => false,
						'wpdevsclub_podcast'        => false,
					),
				),

				'post_title' => array(
					'views'         => array(
						'main'      => CHILD_DIR . '/lib/views/common/post-title.php',
					),
					'use_image'     => true,
					'use_overlay'   => true,
					'post_args'     => array(),
				),

				'post_meta' => array(
					'include_comment_link'  => true,
				),

				'comments' => array(
					'views'        => array(
						'comments' => CHILD_DIR . '/lib/views/comments/comments.php',
					),

					'labels'                            => array(
						'title_comments'                => __( 'Share Your Thoughts', 'wpdc' ),
						'reply_title'                   => __( 'Get the ball rolling', 'wpdc' ),
						'title_reply_to'                => __( 'Join the Discussion for %s', 'wpdc' ),
						'reply_title_has_comments'      => __( 'Join the Discussion', 'wpdc' ),
						'title_reply_to_has_comments'   => __( 'Join the Discussion for %s', 'wpdc' ),
					),

					'patterns'                          => array(
						'title_comments'                => '<h3>%s</h3><div class="comment-count"><div class="circle"><span>%d</span></div></div>',
						'wrap_opener'                   => '<section id="wpdevsclub-comments"><div class="wrap">',
						'wrap_closer'                   => '</div></section>',
						'comment_form_field_comment'    => '</div><div class="one-half">%s</div><div class="clearfix"></div>',
					),

					/****************************
					 * Extras
					 **************************/

					'comment_list_args'                 => array(
						'avatar_size'                   => 64,
						'reply_text'                    => '<i class="fa fa-reply"></i>',
					),
				),

				'related'               => array(
					'post_type'         => array( 'podcast' ),
					'post_info'         => array(
						'views'         => array(
							'main'      => WPDC_RELATED_ARTICLES_DIR . 'src/views/post-info.php',
						),
						'avatar_size'   => 32,
					),
				),
				'sticky_footer'         => array(
					'theme_locations'   => array(
						'quick_links'   => 'sticky_footer_podcast_quick_links',
						'extras'        => 'sticky_footer_podcast_extras',
					),
				),
			)
		),
	),

	/*********************************************************
	 * Extras
	 ********************************************************/
);
