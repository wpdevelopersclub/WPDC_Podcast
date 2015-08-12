<?php

return array(
	'args'                  => array(
		'label'     	    => 'Podcast',
		'labels'            => array(
			'menu_name'     => 'Podcast',
			'add_new'       => 'Add a New Show',
		),
		'description'       => 'Articles for the Podcast',
		'public'            => true,
		'menu_position'     => 50,
		'hierarchical'	    => true,
		'rewrite'           => array(
			'slug'          => 'podcast',
		),
		'taxonomies'        => array( 'category', 'post_tag' ),
	),
	'columns_filter'        => array(
		'cb'    	        => true,
		'title' 	        => __( 'Show Title', 'wpdevsclub' ),
		'cat'               => __( 'Categories', 'wpdevsclub' ),
		'tags'              => __( 'Tags', 'wpdevsclub' ),
		'author' 	        => __( 'Author', 'wpdevsclub' ),
		'date'		        => __( 'Date', 'wpdevsclub' ),
	),
	'columns_data'          => array(
		'cat'               => array(
			'callback'      => 'wpdevsclub_get_joined_list_of_terms',
			'echo'          => true,
			'args'          => array( 'category' ),
		),
		'tags'              => array(
			'callback'      => 'wpdevsclub_get_joined_list_of_terms',
			'echo'          => true,
			'args'          => array( 'post_tag' ),
		),
		'date'	            => array(
			'callback'      => 'the_date',
			'echo'          => false,
			'args'          => array(),
		),
	),
);