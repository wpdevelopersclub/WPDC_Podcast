<?php

if ( ! function_exists( 'wpdevsclub_get_sponsor_types' ) ) {
	/**
	 * Build the Sponsors Select Options per passed in query args
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args
	 * @param int   $number_of_sponsors
	 * @param array $selected_sponsors
	 * @return array
	 */
	function wpdevsclub_get_sponsors_select_options( array $query_args, $number_of_sponsors, array $selected_sponsors ) {
		$sponsors = array();

		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			$post_id    = get_the_ID();
			$title      = get_the_title();
			for ( $index = 0; $index < $number_of_sponsors; $index++ ) {
				$sponsors[ $index ] .= sprintf( '<option value="%s"%s>%s</option>',
					$post_id,
					selected( $post_id, $selected_sponsors[ $index ], false ),
					$title
				);
			}

		endwhile; endif;

		// Restore original query
		wp_reset_query();

		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		return $sponsors;
	}
}