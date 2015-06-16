<?php if ( $this->upcoming ) : ?>
<section class="upcoming-episode wpdevsclub-info-box info">
	<i class='fa fa-microphone'></i>
	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<span class="airs-label"><?php _e( 'Airs', 'wpdevsclub' ); ?></span>
		<?php esc_html_e( $this->airdate ); ?>
	</time>
</section>
<?php endif; ?>

<?php
$video_src = $this->model->get_meta( '_video', 'wpdevsclub_podcast', false );
if ( false != $video_src ) : ?>
	<section id="episode-video">
		<?php
		$video = sprintf( '[video src="%s" width="853" height="480"]', esc_url( $video_src ) );
		echo do_shortcode( $video );
		?>
	</section>
<?php endif; ?>

<p class="entry-post-info">
	<?php if ( $this->past_episode ) : ?>
	<span class="video-runtime" itemprop="text">
		<i class="fa fa-clock-o"></i>
		<?php printf( '%s: %s',
			__( 'Video Runtime', 'wpdevsclub' ),
			esc_html( $this->model->get_meta( '_runtime', 'wpdevsclub_podcast' ) ) ); ?>
	</span>
	<?php endif; ?>

	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<i class='fa fa-calendar'></i>
		<?php esc_html_e( $this->airdate ); ?>
	</time>

	<?php
		$shortcode = sprintf( '[post_comments before="%s" more="%%" one="1" zero="0"]', "<i class='fa fa-comments'></i>"  );
		echo do_shortcode( $shortcode );
	?>
</p>

<section id="code-challenge" class="code-challenge clearfix">
	<header class="section-header">
		<i class='fa fa-code'></i>
		<h2><?php _e( 'Code Challenge', 'wpdevsclub' ); ?></h2>
	</header>
	<?php
	$code_challenge = do_shortcode( $this->model->get_meta( '_code_challenge_content', 'wpdevsclub_podcast' ) );
	echo wpautop( $code_challenge );
	?>
</section>

<?php if ( $this->past_episode || current_user_can( 'manage_categories' ) ) : ?>
<section id="show-notes" class="show-notes">
	<header class="section-header">
		<i class="fa fa-university"></i>
		<h2><?php _e( 'Podcast Show Notes & Tutorial', 'wpdevsclub' ); ?></h2>
	</header>
	<?php the_content(); ?>
</section>

<section id="transcript" class="transcript clearfix">
	<header class="section-header">
		<i class="fa fa-microphone"></i>
		<h2><?php _e( 'Podcast Show\'s Transcript', 'wpdevsclub' ); ?></h2>
	</header>
	<?php
	$transcript = do_shortcode( $this->model->get_meta( '_transcript', 'wpdevsclub_podcast' ) );
	echo $transcript ? wpautop( wp_kses_post( $transcript ) ) : sprintf( '<p>%s</p>', __( 'Coming soon...', 'wpdevsclub' ) );
	?>
</section>
<?php endif; ?>