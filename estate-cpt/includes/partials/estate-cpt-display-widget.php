<?php
if ( ! empty( $instance['title'] ) ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
}

if ( ! empty( $title ) ) {
	echo $before_title . $title . $after_title;
}

// include filter
include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/estate-cpt-filter.php'; 