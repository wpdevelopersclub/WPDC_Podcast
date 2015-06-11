<article <?php echo $entry_attr; ?>>

	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<i class='fa fa-calendar'></i>
		<span class="airs-label"><?php esc_html_e( $upcoming ? __( 'Airs', 'wpdevsclub' ) : __( 'Aired on', 'wpdevsclub' ) ); ?></span>
		<?php esc_html_e( wpdevsclub_format_string_to_datetime( $airdate, $date_format ) ); ?>
	</time>

	<header <?php echo genesis_attr( 'entry-header' ); ?>>
		<h3 class="episode-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>
		<h4 class="episode-subtitle"><?php esc_html_e( $model->get_subtitle() ); ?></h4>
	</header>
	<div class="episode-content"><?php echo wp_kses_post( $content ); ?></div>
</article>