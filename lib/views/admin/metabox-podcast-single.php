<?php

$path = trailingslashit( __DIR__ ) . 'podcast-single/';

$views = array(
	'video', 'challenge', 'transcript',
);

foreach ( $views as $view_file ) {
	include( $path . $view_file . '.php' );
}