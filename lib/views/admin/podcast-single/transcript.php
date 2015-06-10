<h3 style="margin-top: 20px; background-color: #ccc; color: #fff; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc;"><?php _e( 'Transcript Section', 'wpdevsclub' ); ?></h3>
<p>
	<label for="_transcript">
		<strong><?php _e( 'Enter the Transcript Content', 'wpdevsclub' ); ?></strong>
	</label>
</p>
<p>
	<?php
	$args = array(
		'textarea_name' => "wpdevsclub_podcast[_transcript]",
	);
	wp_editor( $meta['_transcript'], "_transcript", $args );
	?>
</p>
<p class="description">
	<?php _e( 'This section is for the transcript.', 'wpdevsclub' ); ?>
</p>