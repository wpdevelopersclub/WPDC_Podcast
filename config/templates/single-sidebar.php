<?php

return array(

	/*******************
	 * Model
	 ******************/

	'model'                             => array(
		'meta_keys'                     => array(
			'wpdevsclub_page_options'   => false,
			'wpdevsclub_podcast'        => false,
		),
	),


	/*******************
	 * Post Title
	 ******************/

	'post_title' => array(
		'views'         => array(
			'main'      => CHILD_DIR . '/lib/views/common/post-title.php',
		),
		'use_image'     => true,
		'use_overlay'   => true,
		'post_args'     => array(),
	),


	/*******************
	 * Post
	 ******************/

	'post' => array(
		'views'             => array(
			'tldr'          => CHILD_DIR . '/lib/views/common/tldr.php',
		),
		'layout'            => '__genesis_return_full_width_content',
		'body_classes'      => array(
			'wpdevsclub-podcast',
		),
	),


	/*******************
	 * Post Meta
	 ******************/

	'post_meta' => array(
		'include_comment_link'  => true,
	),


	/*******************
	 * Related
	 ******************/

	'related'               => array(
		'post_type'         => array( 'post', 'podcast' ),
		'views'             => array(
			'main'          => CHILD_DIR . '/lib/views/post/related.php',
			'post_nav'      => CHILD_DIR . '/lib/views/post/post-nav.php',
			'post_image'    => CHILD_DIR . '/lib/views/post/post-image.php',
		),
		'number_posts'      => 4,
		'post_info'         => array(
			'views'         => array(
				'main'      => CHILD_DIR . '/lib/views/post/post-info.php',
			),
			'avatar_size'   => 32,
		),
		'patterns'          => array(
			'opening_tag'   => sprintf( '<section id="related-posts"><div class="wrap"><h4 class="related-title">%s</h4>', __( 'More Articles to Explore', 'wpdevsclub' ) ),
			'closing_tag'   => '</div></section>',
		),
	),

	/*******************
	 * Comments
	 ******************/

	'comments'                              => array(
		'views'                             => array(
			'comments'                      => CHILD_DIR . '/lib/views/comments/comments.php',
		),

		'labels'                            => array(
			'title_comments'                => __( 'Share Your Thoughts', 'wpdevsclub' ),
			'reply_title'                   => __( 'Get the ball rolling', 'wpdevsclub' ),
			'title_reply_to'                => __( 'Join the Discussion for %s', 'wpdevsclub' ),
			'reply_title_has_comments'      => __( 'Join the Discussion', 'wpdevsclub' ),
			'title_reply_to_has_comments'   => __( 'Join the Discussion for %s', 'wpdevsclub' ),
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

	/*******************
	 * Sidebar
	 ******************/

	'sidebars'              => array(
		'views'             => array(
			'sponsors'      => CHILD_DIR . '/lib/views/sidebar/sponsors.php',
			'sponsor_oa'    => CHILD_DIR . '/lib/views/sidebar/sponsor/sponsor-oa.php',
			'sponsor'       => CHILD_DIR . '/lib/views/sidebar/sponsor/sponsor.php',
			'content'       => CHILD_DIR . '/lib/views/sidebar/sponsor/content.php',
		),
	),


	/*******************
	 * Sticky Footer
	 ******************/

	'sticky_footer' => array(
		'theme_locations'   => array(
			'quick_links'   => 'sticky_footer_podcast_quick_links',
			'extras'        => 'sticky_footer_podcast_extras',
		),
	),
);