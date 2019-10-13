<?php
$pre_comic_content = apply_filters( 'cominovel_comic_content', false );
if ( empty( $pre_comic_content ) ) {
	$total_images = count( $chapter->chapter_images );
	foreach ( $chapter->chapter_images as $index => $image ) {
		do_action( 'cominovel_content_before_image', $index, $total_images );
		cominovel_template( 'loop/image', compact( 'index', 'image' ) );
		do_action( 'cominovel_content_after_image', $index, $total_images );
	}
} else {
	cominovel_template( 'single/chapter-custom', array( 'content' => $pre_comic_content ) );
}
