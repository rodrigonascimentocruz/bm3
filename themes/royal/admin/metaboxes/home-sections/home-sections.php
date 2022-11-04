<?php
function royal_home_section_meta( ) {
	global $post;

	if ( $post !== null and get_post_meta( $post->ID, '_wp_page_template', true ) == 'templates/front.php' ) {
		if ( class_exists( 'RoyalAdmin' ) ) {
			RoyalAdmin::addMetaBox('home');
		}
		remove_post_type_support( 'page', 'editor' );
		remove_post_type_support( 'page', 'revisions' );
	}
}

function royal_home_section_callback( $post ) {
	// Styles
	wp_enqueue_style( 'royal-meta-sections', get_template_directory_uri( ) . '/admin/metaboxes/styles.css' );
	
	// Scripts
	wp_register_script( 'royal-home-sections', get_template_directory_uri( ) . '/admin/metaboxes/home-sections/functions.js', array( ), false, true );
	wp_localize_script( 'royal-home-sections', 'royal_home_lng', array(
		'insert_media' => esc_html__( 'Insert Media', 'royal' ),
		'image'        => esc_html__( 'Image', 'royal' ),
		'remove'       => esc_html__( 'Remove', 'royal' )
	) );
	wp_enqueue_script( 'royal-home-sections' );

	// Core
	wp_nonce_field( 'theme_nonce_safe', 'theme_nonce' );
	$meta = get_post_meta( $post->ID );

	if ( isset( $meta['header-section'] ) and ! empty( $meta['header-section'][0] ) and $meta['header-section'][0] != 'none' ) {
		$header_section = $meta['header-section'][0];
	} else {
		$header_section = false;
	}

	$section_height = get_post_meta( $post->ID, 'section-height', true );

	if ( empty( $section_height ) ) {
		$section_height = '100%';
	}
	?>

	<p><strong><?php esc_html_e( 'Section Type', 'royal' ); ?></strong></p>
	<select name="header-section" class="meta-item-m" id="header-section">
		<option value="none" <?php if ( ! isset( $meta['header-section'] ) or $meta['header-section'] == 'none' ) echo ' selected="selected"'; ?>><?php esc_html_e( 'None', 'royal' ); ?></option>
		<option value="slideshow" <?php if ( isset( $meta['header-section'] ) ) selected( $meta['header-section'][0], 'slideshow' ); ?>><?php esc_html_e( 'Slideshow and Text Slider', 'royal' ); ?></option>
		<option value="image" <?php if ( isset( $meta['header-section'] ) ) selected( $meta['header-section'][0], 'image' ); ?>><?php esc_html_e( 'Fullscreen Image', 'royal' ); ?></option>
		<option value="video" <?php if ( isset( $meta['header-section'] ) ) selected( $meta['header-section'][0], 'video' ); ?>><?php esc_html_e( 'Video Background', 'royal' ); ?></option>
	</select>

	<p><strong><?php esc_html_e( 'Section Height', 'royal' ); ?></strong></p>
	<input type="text" class="meta-item-m" name="section-height" value="<?php echo esc_attr( $section_height ); ?>">
	<p><?php esc_html_e( 'Example, <strong>100%</strong> &ndash; in percents, <strong>700px</strong> &ndash; in pixels', 'royal' ); ?></p>

	<div data-header-section="slideshow" <?php echo esc_attr( $header_section != 'slideshow' ? 'class="meta-hidden"' : '' ); ?>>
		<div id="slideshow-add-button">
			<p><strong><?php esc_html_e( 'Background Images', 'royal' ); ?></strong></p>
			<input type="button" class="button meta-item-upload" data-area="#slideshow-fields" data-multiple="true" value="<?php esc_attr_e( 'Choose or Upload Images', 'royal' ); ?>">
		</div>
		<div id="slideshow-fields">
			<?php
			$limit = 20;
			for ( $i = 1; $i <= $limit; $i ++ ) {
				?>
				<div class="meta-item-row meta-mt-20 meta-hidden" id="slideshow-field-<?php echo esc_attr( $i ); ?>">
					<hr>
					<div>
						<?php
						wp_editor( empty( $meta['slideshow-slide-'.$i][0] ) ? '' : $meta['slideshow-slide-'.$i][0], 'slideshow_slide_' . $i, array( 'textarea_name' => 'slideshow-slide[' . $i . ']', 'media_buttons' => false, 'textarea_rows' => 15 ) );
						?>
						<p>
							<?php esc_html_e( 'Background Image', 'royal' ); ?>
							<input type="text" class="meta-item-l alt" name="slideshow-field[<?php echo esc_attr( $i ); ?>]" value="" />
						</p>
						<p><input type="button" value="<?php esc_attr_e( 'Remove Slide', 'royal' ); ?>" class="button" data-remove-slide="true"></p>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	
	<div data-header-section="image" <?php echo esc_attr( $header_section != 'image' ? 'class="meta-hidden"' : '' ); ?>>
		<p><strong><?php esc_html_e( 'Background Image', 'royal' ); ?></strong></p>
		<input type="text" class="meta-item-l" name="single-image" id="single-image-field" value="<?php echo esc_attr( get_post_meta( $post->ID, 'single-image', true ) ); ?>">
		<input type="button" class="button meta-item-upload" data-area="#single-image-field" value="<?php esc_attr_e( 'Choose or Upload an Image', 'royal' ); ?>">
		<div class="meta-mt-20">
			<hr>
			<div>
				<?php
				wp_editor( empty( $meta['content-image'][0] ) ? '' : $meta['content-image'][0], 'content_image', array( 'textarea_name' => 'content-image', 'media_buttons' => false, 'textarea_rows' => 15 ) );
				?>
			</div>
		</div>
	</div>	

	<div data-header-section="video" <?php echo esc_attr( $header_section != 'video' ? 'class="meta-hidden"' : '' ); ?>>
		<p><strong><?php esc_html_e( 'Background Video ID', 'royal' ); ?></strong></p>
		<input type="text" class="meta-item-m" name="video-id" value="<?php echo esc_attr( get_post_meta( $post->ID, 'video-id', true ) ); ?>">
		<p><?php esc_html_e( 'Example', 'royal' ); ?>, https://www.youtube.com/watch?v=<strong>kvJxX7fk0gI</strong></p>
		<div class="meta-mt-20">
			<hr>
			<div>
				<?php
				wp_editor( empty( $meta['content-video'][0] ) ? '' : $meta['content-video'][0], 'content_video', array( 'textarea_name' => 'content-video', 'media_buttons' => false, 'textarea_rows' => 15 ) );
				?>
			</div>
		</div>
	</div>	
	
	<?php
		$slidesContent = '';
	
		if ( ! empty( $meta['slideshow-images'][0] ) ) {
			$i = 0;
			$explode = explode( ',', $meta['slideshow-images'][0] );
	
			if ( count( $explode ) > 0 ) {
				foreach ( $explode as $name ) {
					$i ++;
	
					if ( ! empty( $name ) ) {
			
						$slidesContent .= 	'royalSlidesContent[royalSlidesContent.length] = {
												id:' . json_encode( $i ) .', 
												url:\'' . json_encode( $name ) . '\'
										   	 };';
					
					}
				}
			}
		}		
		
		wp_add_inline_script( 'royal-home-sections', 
			'var royalSlidesContent = [];' . 
			$slidesContent,
		'before');
	?>

	<?php
}

function royal_home_section_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['theme_nonce'] ) || ! wp_verify_nonce( $_POST['theme_nonce'], 'theme_nonce_safe' ) ) return;
	if ( ! current_user_can( 'edit_posts' ) ) return;
	
	// Home section type
	if ( isset( $_POST['header-section'] ) ) {
		update_post_meta( $post_id, 'header-section', sanitize_text_field( $_POST['header-section'] ) );
	}

	// Section height
	if ( isset( $_POST['section-height'] ) ) {
		update_post_meta( $post_id, 'section-height', sanitize_text_field( $_POST['section-height'] ) );
	}
	
	// Slideshow and text slider
	if ( $_POST['header-section'] == 'slideshow' ) {
		if ( isset( $_POST['slideshow-field'] ) and count( $_POST['slideshow-field'] ) > 0 ) {
			update_post_meta( $post_id, 'slideshow-images', sanitize_text_field( implode( ',', $_POST['slideshow-field'] ) ) );
		} else if ( $_POST['header-section'] == 'slideshow' ) {
			update_post_meta( $post_id, 'slideshow-images', '' );
		}

		if ( isset( $_POST['slideshow-slide'] ) and count( $_POST['slideshow-slide'] ) > 0 ) {
			$i = 0;
			$string = '';
			$array = array( );

			foreach ( $_POST['slideshow-slide'] as $text ) {
				$i ++;

				if ( ! empty( $text ) or ! empty( $_POST['slideshow-field'][$i] ) ) {
					update_post_meta( $post_id, 'slideshow-slide-' . $i, wp_kses_post( $text ) );
				} else if ( empty( $text ) and empty( $_POST['slideshow-field'][$i] ) ) {
					update_post_meta( $post_id, 'slideshow-slide-' . $i, wp_kses_post( $text ) );
				}
			}
		}
	}
	
	// Fullscreen image
	if ( $_POST['header-section'] == 'image' ) {
		if ( isset( $_POST['single-image'] ) ) {
			update_post_meta( $post_id, 'single-image', sanitize_text_field( $_POST['single-image'] ) );
		}
		if ( isset( $_POST['content-image'] ) ) {
			update_post_meta( $post_id, 'content-image', wp_kses_post( $_POST['content-image'] ) );
		}
	}

	// Video background
	if ( $_POST['header-section'] == 'video' ) {
		if ( isset( $_POST['video-id'] ) ) {
			update_post_meta( $post_id, 'video-id', sanitize_text_field( $_POST['video-id'] ) );
		}
		if ( isset( $_POST['content-video'] ) ) {
			update_post_meta( $post_id, 'content-video', wp_kses_post( $_POST['content-video'] ) );
		}
	}	
}

if ( class_exists( 'RoyalAdmin' ) ) {
	RoyalAdmin::addAction('home');
}

add_action( 'save_post', 'royal_home_section_save' );
