<section id="podcast-section-<?php esc_attr_e( $section ); ?>" class="<?php esc_attr_e( $class ); ?>">
	<div class="wrapper">
		<?php echo wp_kses_post( $content ); ?>
	</div>
</section>