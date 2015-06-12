<?php
if ( $upcoming ) :
	if ( ! $upcoming_title_shown ) :
?>
<section class="podcast-episodes upcoming">
	<header class="section-header">
		<i class="fa fa-microphone"></i>
		<h2><?php _e( 'Upcoming Episodes', 'wpdevsclub' ); ?></h2>
		<hr class="third lime">
	</header>
<?php
	endif;
elseif ( ! $past_shown ) :
?>
<section class="podcast-episodes past">
	<header class="section-header">
		<i class="fa fa-microphone-slash"></i>
		<h2><?php _e( 'Past Episodes', 'wpdevsclub' ); ?></h2>
		<hr class="third lime">
	</header>
<?php endif; ?>

<article <?php echo $entry_attr; ?>>

	<time <?php echo genesis_attr( 'entry-time' ); ?>>
		<span class="airs-label"><?php esc_html_e( $upcoming ? __( 'Airs', 'wpdevsclub' ) : __( 'Aired on', 'wpdevsclub' ) ); ?></span>
		<?php esc_html_e( wpdevsclub_format_string_to_datetime( $airdate, $date_format ) ); ?>
	</time>

	<div class="episode-content-container">
		<header <?php echo genesis_attr( 'entry-header' ); ?>>
			<h3 class="episode-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h3>
			<h4 class="episode-subtitle"><?php esc_html_e( $model->get_subtitle() ); ?></h4>
		</header>
		<div class="episode-content"><?php echo wp_kses_post( $content ); ?></div>
	</div>
</article>

<?php
if ( ( $upcoming && ! $upcoming_title_shown ) || $past_shown ) : ?>
</section>
<?php endif; ?>