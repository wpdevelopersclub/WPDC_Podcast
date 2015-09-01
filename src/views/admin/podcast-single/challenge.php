<h3 style="margin-top: 20px; background-color: #ccc; color: #fff; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc;"><?php _e( 'Code Challenge Section', 'wpdc' ); ?></h3>
<p>
	<label for="_code_challenge_content">
		<strong><?php _e( 'Enter the Challenge Content', 'wpdc' ); ?></strong>
	</label>
</p>
<p>
	<?php
	$args = array(
		'textarea_name' => "wpdevsclub_podcast[_code_challenge_content]",
	);
	wp_editor( $meta['_code_challenge_content'], "_code_challenge_content", $args );
	?>
</p>
<p class="description">
	<?php _e( 'This entire section appears just after the video section.', 'wpdc' ); ?>
</p>