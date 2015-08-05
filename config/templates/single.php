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
	 * Post Meta
	 ******************/

	'post_meta' => array(
		'include_comment_link'  => true,
	),


	/*******************
	 * Related
	 ******************/

	'related' => array(
		'post_type'     => array( 'post', 'podcast' ),
	),

	/*******************
	 * Comments
	 ******************/

	'comments' => array(
		'views'        => array(
			'comments' => CHILD_DIR . '/lib/views/comments/comments.php',
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
	 * Sticky Footer
	 ******************/

	'sticky_footer' => array(
		'theme_locations'   => array(
			'quick_links'   => 'sticky_footer_podcast_quick_links',
			'extras'        => 'sticky_footer_podcast_extras',
		),
	),
);