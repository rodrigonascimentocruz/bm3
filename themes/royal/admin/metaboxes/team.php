<?php
class RoyalTeam {
	// Initialization
	public static function init( ) {
		if ( class_exists( 'RoyalAdmin' ) ) {
			RoyalAdmin::addMetaBox('team');
		}
	}

	// Metabox
	public static function content( $post ) {
		// Styles
		wp_enqueue_style( 'royal-meta-sections', get_template_directory_uri( ) . '/admin/metaboxes/styles.css' );
		
		wp_nonce_field( 'athenastudio_nonce_safe', 'athenastudio_nonce' );
		$meta = get_post_meta( $post->ID );

		$output = '
		<p><strong>' . esc_html__( 'Member Activity', 'royal' ) . '</strong></p>
		<input type="text" class="meta-item-full" name="activity" value="' . ( isset( $meta['activity'][0] ) ? esc_attr( $meta['activity'][0] ) : '' ) . '">

		<p><strong>' . esc_html__( 'Twitter URL', 'royal' ) . '</strong></p>
		<input type="text" class="meta-item-full" name="twitter" value="' . ( isset( $meta['twitter'][0] ) ? esc_attr( $meta['twitter'][0] ) : '' ) . '">

		<p><strong>' . esc_html__( 'Facebook URL', 'royal' ) . '</strong></p>
		<input type="text" class="meta-item-full" name="facebook" value="' . ( isset( $meta['facebook'][0] ) ? esc_attr( $meta['facebook'][0] ) : '' ) . '">

		<p><strong>' . esc_html__( 'LinkedIn URL', 'royal' ) . '</strong></p>
		<input type="text" class="meta-item-full" name="linkedin" value="' . ( isset( $meta['linkedin'][0] ) ? esc_attr( $meta['linkedin'][0] ) : '' ) . '">

		<p><strong>' . esc_html__( 'Instagram URL', 'royal' ) . '</strong></p>
		<input type="text" class="meta-item-full" name="instagram" value="' . ( isset( $meta['instagram'][0] ) ? esc_attr( $meta['instagram'][0] ) : '' ) . '">
		
		<p><strong>' . esc_html__( 'Dribbble URL', 'royal' ) . '</strong></p>
		<input type="text" class="meta-item-full" name="dribbble" value="' . ( isset( $meta['dribbble'][0] ) ? esc_attr( $meta['dribbble'][0] ) : '' ) . '">';

		echo wp_specialchars_decode( $output );
	}

	// Save
	public static function save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST['athenastudio_nonce'] ) || ! wp_verify_nonce( $_POST['athenastudio_nonce'], 'athenastudio_nonce_safe' ) ) return;
		if ( ! current_user_can( 'edit_posts' ) ) return;

		if ( isset( $_POST['activity'] ) ) {
			update_post_meta( $post_id, 'activity', sanitize_text_field( $_POST['activity'] ) );
		}
		if ( isset( $_POST['twitter'] ) ) {
			update_post_meta( $post_id, 'twitter', sanitize_text_field( $_POST['twitter'] ) );
		}
		if ( isset( $_POST['facebook'] ) ) {
			update_post_meta( $post_id, 'facebook', sanitize_text_field( $_POST['facebook'] ) );
		}
		if ( isset( $_POST['linkedin'] ) ) {
			update_post_meta( $post_id, 'linkedin', sanitize_text_field( $_POST['linkedin'] ) );
		}
		if ( isset( $_POST['instagram'] ) ) {
			update_post_meta( $post_id, 'instagram', sanitize_text_field( $_POST['instagram'] ) );
		}
		if ( isset( $_POST['dribbble'] ) ) {
			update_post_meta( $post_id, 'dribbble', sanitize_text_field( $_POST['dribbble'] ) );
		}
	}
}

if ( class_exists( 'RoyalAdmin' ) ) {
	RoyalAdmin::addAction('team');
}

add_action( 'save_post', array( 'RoyalTeam', 'save' ) );
