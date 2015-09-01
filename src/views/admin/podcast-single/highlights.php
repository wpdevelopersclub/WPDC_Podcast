<h3 style="margin-top: 20px; background-color: #ccc; color: #fff; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc;"><?php _e( 'Highlights Section', 'wpdc' ); ?></h3>
<p>
	<label for="_highlights">
		<strong><?php _e( 'Enter the Highlights Content', 'wpdc' ); ?></strong>
	</label>
</p>
<p>
	<?php
	$args = array(
		'textarea_name' => "wpdevsclub_podcast[_highlights]",
	);
	wp_editor( $meta['_highlights'], "_highlights", $args );
	?>
</p>
<p class="description">
	<?php _e( 'Tell everyone the benefits of this episode.', 'wpdc' ); ?>
</p>