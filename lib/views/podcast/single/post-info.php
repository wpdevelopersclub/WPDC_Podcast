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

<?php echo $this->do_comments(); ?>