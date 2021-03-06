<?php if ( $this->is_upcoming_episode ) : ?>
<section class="upcoming-episode wpdevsclub-info-box info">
	<i class='fa fa-microphone'></i>
	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<span class="airs-label"><?php _e( 'Airs', 'wpdc' ); ?></span>
		<?php esc_html_e( $this->formatted_airdate ); ?>
	</time>
</section>
<?php endif; ?>

<?php
if ( false != $video_src ) : ?>
	<section id="episode-video">
		<?php
		$video = sprintf( '[video src="%s" width="853" height="480"]', esc_url( $video_src ) );
		echo do_shortcode( $video );
		?>
	</section>
<?php endif; ?>

<p class="entry-post-info">
	<?php if ( $this->is_past_episode ) : ?>
	<span class="video-runtime" itemprop="text">
		<i class="fa fa-clock-o"></i>
		<?php printf( '%s: %s',
			__( 'Video Runtime', 'wpdc' ),
			esc_html( $this->get_meta( '_runtime', 'wpdevsclub_podcast' ) ) ); ?>
	</span>
	<?php endif; ?>

	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<i class='fa fa-calendar'></i>
		<?php esc_html_e( $this->formatted_airdate ); ?>
	</time>

	<?php
		$shortcode = sprintf( '[post_comments before="%s" more="%%" one="1" zero="0"]', "<i class='fa fa-comments'></i>"  );
		echo do_shortcode( $shortcode );
	?>
</p>

<section id="podcast-highlights" class="highlights clearfix">
	<header class="section-header">
		<i class='fa fa-bullhorn'></i>
		<h2><?php _e( 'Highlights', 'wpdc' ); ?></h2>
	</header>
	<?php
	$highlights = do_shortcode( $this->get_meta( '_highlights', 'wpdevsclub_podcast' ) );
	echo wpautop( $highlights );
	?>
</section>

<section id="code-challenge" class="code-challenge clearfix">
	<header class="section-header">
		<i class='fa fa-code'></i>
		<h2><?php _e( 'Code Challenge', 'wpdc' ); ?></h2>
	</header>
	<?php
	// CHGD 07.07.2015 as SyntaxHighlighter needs to handle it's shortcode separately
	$code_challenge = $this->get_meta( '_code_challenge_content', 'wpdevsclub_podcast' );
	if ( class_exists( 'SyntaxHighlighter' ) ) {
		global $SyntaxHighlighter;
		$code_challenge = $SyntaxHighlighter->parse_shortcodes( $code_challenge );
	}

	$code_challenge = do_shortcode( $code_challenge );
	echo wpautop( $code_challenge );
	?>
</section>

<?php if ( $this->is_past_episode || current_user_can( 'manage_categories' ) ) : ?>
<section id="show-notes" class="show-notes">
	<header class="section-header">
		<i class="fa fa-university"></i>
		<h2><?php _e( 'Podcast Show Notes & Tutorial', 'wpdc' ); ?></h2>
	</header>
	<?php the_content(); ?>
</section>

<?php endif; ?>