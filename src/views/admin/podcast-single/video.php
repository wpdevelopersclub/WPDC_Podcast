<h3 style="margin-top: 20px; background-color: #ccc; color: #fff; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc;"><?php _e( 'Video Content', 'wpdc' ); ?></h3>
<p>
	<label for="_video">
		<strong><?php _e( 'Video Link', 'wpdc' ); ?></strong>
	</label>
</p>
<p>
	<input class="large-text" type="text" name="wpdevsclub_podcast[_video]" value="<?php echo esc_url( $meta['_video'] ); ?>" />
</p>
<p class="description">
	<?php _e( 'Enter the YouTube video link.', 'wpdc' ); ?>
</p>

<p>
	<label for="_airdate">
		<strong><?php _e( 'Air Date', 'wpdc' ); ?></strong>
	</label>
</p>
<p>
	<input class="text" type="text" name="wpdevsclub_podcast[_airdate]" value="<?php echo esc_attr( $meta['_airdate'] ); ?>" />
</p>
<p class="description">
	<?php _e( 'Enter the show\'s air date.', 'wpdc' ); ?>
</p>

<p>
	<label for="_runtime">
		<strong><?php _e( 'Video Runtime', 'wpdc' ); ?></strong>
	</label>
</p>
<p>
	<input class="text" type="text" name="wpdevsclub_podcast[_runtime]" value="<?php echo esc_attr( $meta['_runtime'] ); ?>" />
</p>
<p class="description">
	<?php _e( 'Enter the video runtime (obviously after the show is published on YouTube).', 'wpdc' ); ?>
</p>