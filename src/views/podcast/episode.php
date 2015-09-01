<?php
if ( $this->is_new_section ) :
	if ( $this->is_upcoming_episode ) : ?>

<section class="podcast-episodes upcoming">
	<header class="section-header">
		<i class="fa fa-microphone"></i>
		<h2><?php _e( 'Upcoming Episodes', 'wpdc' ); ?></h2>
		<hr class="third lime">
	</header>

	<?php else : ?>

<section class="podcast-episodes past">
	<header class="section-header">
		<i class="fa fa-microphone-slash"></i>
		<h2><?php _e( 'Past Episodes', 'wpdc' ); ?></h2>
		<hr class="third lime">
	</header>

	<?php endif; ?>
<?php endif; ?>

	<article <?php echo $this->fetch_entry_attr(); ?>>

		<time <?php echo genesis_attr( 'entry-time' ); ?>>
			<span class="airs-label"><?php esc_html_e( $this->is_upcoming_episode ? __( 'Airs', 'wpdc' ) : __( 'Aired on', 'wpdc' ) ); ?></span>
			<?php esc_html_e( $this->formatted_airdate ); ?>
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

<?php if ( $this->is_new_section ) : ?>
</section>
<?php endif; ?>