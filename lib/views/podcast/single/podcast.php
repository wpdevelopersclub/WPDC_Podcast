<p class="entry-post-info">
	<span class="video-runtime" itemprop="text">
		<i class="fa fa-clock-o"></i>
		<?php printf( '%s: %s',
			__( 'Video Runtime', 'wpdevsclub' ),
			esc_html( $this->model->get_meta( '_runtime', 'wpdevsclub_podcast' ) ) ); ?>
	</span>

	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<i class='fa fa-calendar'></i>
		<?php esc_html_e( $this->model->get_meta( '_airdate', 'wpdevsclub_podcast' ) ); ?>
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
	<?php echo wpautop( wp_kses_post( $code_challenge ) ); ?>
</section>

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
	<?php echo wpautop( wp_kses_post( $transcript ) ); ?>
</section>