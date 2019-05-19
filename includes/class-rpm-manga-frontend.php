<?php
class RPM_Manga_Frontend {
	public static function init() {
		add_action( 'admin_bar_menu', array( __CLASS__, 'change_edit_chapter_link_to_manga' ), 999 );
		add_filter( 'ramphor_manga_edit_manga_node', array( __CLASS__, 'edit_manga_node' ), 10, 2 );
	}

	public function change_edit_chapter_link_to_manga( $wp_admin_bar ) {
		$manga_object = get_post_type_object( 'manga' );
		if ( ! isset( $manga_object->labels->edit_item ) ) {
			return;
		}

		$all_toolbar_nodes = $wp_admin_bar->get_nodes();
		foreach ( $all_toolbar_nodes as $node ) {
			if ( $node->title === $manga_object->labels->edit_item && ! $node->parent && $node->id === 'edit' ) {
				$queried_object = get_queried_object();
				$args           = apply_filters( 'ramphor_manga_edit_manga_node', $node, $queried_object, $manga_object );
				$wp_admin_bar->add_node( $args );
			}
		}
	}

	public static function edit_manga_node( $node, $queried_object ) {
		if ( $queried_object->post_parent === 0 ) {
			$node->href = get_edit_post_link( $queried_object );
			return $node;
		}
		return self::edit_manga_node( $node, get_post( $queried_object->post_parent ) );
	}
}

RPM_Manga_Frontend::init();