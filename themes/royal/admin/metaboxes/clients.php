<?php
class RoyalClients {
	// Initialization
	public static function init( ) {
		if ( class_exists( 'RoyalAdmin' ) ) {
			RoyalAdmin::addMetaBox('clients');
		}
	}

	// Metabox
	public static function content( $post ) {
		// Styles
		wp_enqueue_style( 'royal-meta-sections', get_template_directory_uri( ) . '/admin/metaboxes/styles.css' );
		
		wp_nonce_field( 'athenastudio_nonce_safe', 'athenastudio_nonce' );
		$meta = get_post_meta( $post->ID );

		$output = '<p><strong>' . esc_html__( 'Website URL', 'royal' ) . '</strong></p>
				   <input type="text" class="meta-item-full" name="url" value="' . ( isset( $meta['url'][0] ) ? esc_attr( $meta['url'][0] ) : '' ) . '">';

		echo wp_specialchars_decode( $output );
	}

	// Save
	public static function save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST['athenastudio_nonce'] ) || ! wp_verify_nonce( $_POST['athenastudio_nonce'], 'athenastudio_nonce_safe' ) ) return;
		if ( ! current_user_can( 'edit_posts' ) ) return;

		if ( isset( $_POST['url'] ) ) {
			update_post_meta( $post_id, 'url', sanitize_text_field( $_POST['url'] ) );
		}
	}
}

if ( class_exists( 'RoyalAdmin' ) ) {
	RoyalAdmin::addAction('clients');
}

add_action( 'save_post', array( 'RoyalClients', 'save' ) );
