<?php
class RoyalAdmin {
	
	// Styles
	public static function styles( ) {
		wp_register_style( 'royal-options', plugins_url( '/styles.css', __FILE__ ) );
	}

	// Scripts
	public static function scripts( ) {
		wp_register_script( 'royal-options', plugins_url( '/functions.js', __FILE__ ), array( ), false, true );
		wp_localize_script( 'royal-options', 'royal_options_lng', array(
			'insert_media' => __( 'Insert Media', 'royal' )
		) );
	}
	
	// Metabox
	public static function addMetaBox( $box ) {
		switch ( $box ) {
			case 'clients':
				add_meta_box( 'athenastudio_client_information', esc_html__( 'Client Information', 'royal' ), array( 'RoyalClients', 'content' ), 'our-clients', 'normal', 'high' );
				break;
			case 'home':
				add_meta_box( 'royal_home_section', esc_html__( 'Home Section', 'royal' ), 'royal_home_section_callback', 'page', 'normal', 'high' );
				break;
			case 'subtitle':
				add_meta_box( 'athenastudio_subtitle', esc_html__( 'Visual Subtitle', 'royal' ), array( 'RoyalSubtitle', 'content' ), 'page', 'side' );
				add_meta_box( 'athenastudio_subtitle', esc_html__( 'Visual Subtitle', 'royal' ), array( 'RoyalSubtitle', 'content' ), 'portfolio', 'normal' );
				break;
			case 'team':
				add_meta_box( 'athenastudio_member_information', esc_html__( 'Member Information', 'royal' ), array( 'RoyalTeam', 'content' ), 'our-team', 'normal', 'high' );
				break;
		}
	}
	
	// Action
	public static function addAction( $box ) {
		switch ( $box ) {
			case 'clients':
				add_action( 'add_meta_boxes', array( 'RoyalClients', 'init' ) );
				break;
			case 'home':
				add_action( 'add_meta_boxes', 'royal_home_section_meta' );
				break;
			case 'subtitle':
				add_action( 'add_meta_boxes', array( 'RoyalSubtitle', 'init' ) );
				break;
			case 'team':
				add_action( 'add_meta_boxes', array( 'RoyalTeam', 'init' ) );
				break;
		}
	}

	// Box
	public static function box( $content ) {
		return '
		<div class="postbox">
			<div class="inside">
				' . $content . '
			</div>
		</div>';
	}

	// Wrapper
	public static function wrap( $title, $content ) {
		return '
		<div class="wrap metabox-holder">
			<h2>' . esc_html( $title ) . '</h2>
			<div style="margin-top: 15px">' . $content . '</div>
		</div>';
	}

	// Message
	public static function message( $content, $type = 'updated' ) {
		return '
		<div class="' . esc_attr( $type ) . ' settings-error" style="margin-top: 15px">
			<p><strong>' . $content . '</strong></p>
		</div>';
	}

	// Admin menu
	public static function adminMenu( ) {
		add_menu_page( __( 'Site Sections', 'royal' ), __( 'Site Sections', 'royal' ), 'manage_options', 'site-sections', array( 'RoyalAdmin', 'sections' ), 'dashicons-screenoptions', 101 );

		add_submenu_page( 'edit.php?post_type=portfolio', __( 'Reorder Items', 'royal' ), __( 'Reorder Items', 'royal' ), 'manage_options', 'portfolio-reorder', array( 'RoyalAdmin', 'portfolioItems' ) );
		add_submenu_page( 'edit.php?post_type=our-clients', __( 'Reorder Items', 'royal' ), __( 'Reorder Items', 'royal' ), 'manage_options', 'clients-reorder', array( 'RoyalAdmin', 'clientsItems' ) );
	}

	// Clients items order
	public static function clientsItems( ) {
		global $wpdb;

		wp_enqueue_script( 'royal-options' );
		wp_enqueue_style( 'royal-options' );

		if ( $_POST and isset( $_POST['posts'] ) ) {
			if ( count( $_POST['posts'] ) > 0 ) {
				$internal = 0;
				foreach ( $_POST['posts'] as $id ) {
					$internal ++;
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $internal ), array( 'ID' => intval( $id ) ) );
				}
				echo self::message( __( 'Changes saved!', 'royal' ) );
			}
		}

		$rows = get_posts( array(
			'post_type'   		=> 'our-clients',
			'suppress_filters' 	=> 0,
			'orderby'     		=> 'menu_order',
			'order'       		=> 'ASC',
			'numberposts' 		=> '-1',
		) );

		$html = '';
		$empty = true;

		if ( is_array( $rows ) and count( $rows ) > 0 ) {
			$empty = false;
			foreach ( $rows as $row ) {
				$title = apply_filters( 'the_title', $row->post_title );
				if ( strlen( $title ) > 28 ) $title = substr( $title, 0, 28 ) . '...';

				$html .= '
				<li>
					<div class="portfolio-item">
						' . get_the_post_thumbnail( $row->ID, array( 200, 200 ) ) . '
						<div class="portfolio-item-title">' . esc_html( $title ) . '</div>
						<input type="hidden" name="posts[]" value="' . esc_attr( $row->ID ) . '">
					</div>
				</li>';
			}
		}

		$html = '
		<ul class="portfolio-items">' . $html . '</ul>
		<div class="portfolio-clr"></div>

		<input type="submit" class="button button-large" value="' . esc_attr__( 'Save Changes', 'royal' ) . '" style="margin: 10px 0 0 10px;">';

		$content = self::box( $html );

		echo '<form action="" method="post">';
		echo self::wrap( __( 'Reorder Items', 'royal' ), $content );
		echo '</form>';
	}

	// Portolio items order
	public static function portfolioItems( ) {
		global $wpdb;

		wp_enqueue_script( 'royal-options' );
		wp_enqueue_style( 'royal-options' );

		if ( $_POST and isset( $_POST['posts'] ) ) {
			if ( count( $_POST['posts'] ) > 0 ) {
				$internal = 0;
				foreach ( $_POST['posts'] as $id ) {
					$internal ++;
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $internal ), array( 'ID' => intval( $id ) ) );
				}
				echo self::message( __( 'Changes saved!', 'royal' ) );
			}
		}

		$rows = get_posts( array(
			'post_type'   		=> 'portfolio',
			'suppress_filters' 	=> 0,
			'orderby'     		=> 'menu_order',
			'order'       		=> 'ASC',
			'numberposts' 		=> '-1',
		) );

		$html = '';
		$empty = true;

		if ( is_array( $rows ) and count( $rows ) > 0 ) {
			$empty = false;
			foreach ( $rows as $row ) {
				$title = apply_filters( 'the_title', $row->post_title );
				if ( strlen( $title ) > 28 ) $title = substr( $title, 0, 28 ) . '...';

				$html .= '
				<li>
					<div class="portfolio-item">
						' . get_the_post_thumbnail( $row->ID, array( 200, 200 ) ) . '
						<div class="portfolio-item-title">' . esc_html( $title ) . '</div>
						<input type="hidden" name="posts[]" value="' . esc_attr( $row->ID ) . '">
					</div>
				</li>';
			}
		}

		$html = '
		<ul class="portfolio-items">' . $html . '</ul>
		<div class="portfolio-clr"></div>

		<input type="submit" class="button button-large" value="' . esc_attr__( 'Save Changes', 'royal' ) . '" style="margin: 10px 0 0 10px;">';

		$content = self::box( $html );

		echo '<form action="" method="post">';
		echo self::wrap( __( 'Reorder Items', 'royal' ), $content );
		echo '</form>';
	}

	// List of pages
	public static function _pagesList( $selected = false ) {
		$output = '';
		$pages = get_pages( );
		
		if ( is_array( $pages ) and count( $pages ) > 0 ) {
			foreach ( $pages as $page ) {
				$output .= '<option value="' . esc_attr( $page->post_name ) . '"' . ( ( $selected !== false and $selected == $page->post_name ) ? ' selected="true"' : '' ) . '>' . esc_html( $page->post_title ) . '</option>';
			}
		}

		return $output;
	}

	// Site sections
	public static function sections( ) {
		wp_enqueue_script( 'royal-options' );
		wp_enqueue_style( 'royal-options' );

		$isImport = ( isset( $_REQUEST['do'] ) and $_REQUEST['do'] == 'import' );
		
		if ( $isImport and ! current_user_can( 'import' ) ) {
			unset( $_REQUEST['do'] );
		}
		
		// Normal State
		if ( ! $isImport ) {
			if ( $_POST and isset( $_POST['save'] ) ) {
				if ( update_option( 'royal_sections', json_encode( $_POST['sections'] ) ) ) {
					echo self::message( __( 'Sections saved!', 'royal' ) );
				} else {
					echo self::message( __( 'Sections failed to save or not changed.', 'royal' ), 'error' );
				}
			}

			$sections = ( array ) @json_decode( get_option( 'royal_sections', array( ) ), true );

			$html = '
			<ul class="site-sections">';

			$layout_types = array(
				'normal'   => __( 'Normal', 'royal' ),
				'parallax' => __( 'Section with Parallax Effect', 'royal' ),
				'video'    => __( 'Section with Video Background', 'royal' )
			);
			
			if ( isset( $sections ) and is_array( $sections ) and count( $sections ) > 0 ) {
				$count = count( $sections['page'] );
				for ( $i = 0; $i < $count; $i ++ ) {
					$post = get_page_by_path( $sections['page'][$i] );

					if ( $post !== null ) {
						$post_title = $post->post_title;
					} else {
						$post_title = __( 'Untitled', 'royal' );
					}

					$html .= '
					<li class="site-section">
						<div class="site-section-remove"><i class="fa fa-times"></i></div>
						<div class="site-section-title">
							<span class="site-section-title-text">' . esc_html( $post_title ) . '</span>
							<span class="site-section-title-type">' . esc_html( ( ! empty( $layout_types[$sections['layout'][$i]] ) ? $layout_types[$sections['layout'][$i]] : '-' ) ) . '</span>
						</div>
						<div class="site-section-area">
							<div>
								<p><strong>' . __( 'Layout Type', 'royal' ) . '</strong></p>
								<select name="sections[layout][]" class="section-layout-type">
									<option value="normal"' . ( $sections['layout'][$i] == 'normal' ? ' selected="selected"' : '' ) . '>' . __( 'Normal', 'royal' ) . '</option>
									<option value="parallax"' . ( $sections['layout'][$i] == 'parallax' ? ' selected="selected"' : '' ) . '>' . __( 'Section with Parallax Effect', 'royal' ) . '</option>
									<option value="video"' . ( $sections['layout'][$i] == 'video' ? ' selected="selected"' : '' ) . '>' . __( 'Section with Video Background', 'royal' ) . '</option>
								</select>
							</div>
							<div style="display: none">
								<p><strong>' . __( 'Section Content', 'royal' ) . '</strong></p>
								<textarea class="input-large site-sections-content" name="sections[content][]" rows="4"></textarea>
							</div>
							<div data-layout-type="normal parallax video">
								<p><strong>' . __( 'Section Content', 'royal' ) . '</strong></p>
								<select name="sections[page][]" class="section-title">
									<option value="">&mdash; ' . __( 'Select a page', 'royal' ) . ' &mdash;</option>
									' . self::_pagesList( ( ! empty( $sections['page'][$i] ) ? $sections['page'][$i] : false ) ) . '
								</select>
							</div>
							<div data-layout-type="normal">
								<p><strong>' . __( 'Background Color', 'royal' ) . '</strong></p>
								<select name="sections[background][]" class="section-background">
									<option value=""' . ( $sections['background'][$i] != 'grey' ? ' selected="selected"' : '' ) . '>' . __( 'Default', 'royal' ) . '</option>
									<option value="grey"' . ( $sections['background'][$i] == 'grey' ? ' selected="selected"' : '' ) . '>' . __( 'Grey', 'royal' ) . '</option>
								</select>
							</div>
							<div data-layout-type="parallax">
								<p><strong>' . __( 'Background Image', 'royal' ) . '</strong></p>
								<input type="text" class="input-large" name="sections[image][]" value="' . esc_url( $sections['image'][$i] ) . '" />
								<input type="button" class="button meta-item-upload" value="' . esc_attr__( 'Choose or Upload an Image', 'royal' ) . '" style="margin: -1px 0 0 5px; font-size: 12px">
							</div>
							<div data-layout-type="video">
								<p><strong>' . __( 'Video Start at', 'royal' ) . '</strong></p>
								<input type="text" class="input-small" name="sections[video-start][]" value="' . intval( $sections['video-start'][$i] ) . '" /> ' . __( 'seconds', 'royal' ) . '

								<p><strong>' . __( 'YouTube Video ID', 'royal' ) . '</strong></p>
								<input type="text" class="input-large" name="sections[video][]" value="' . esc_attr( $sections['video'][$i] ) . '" />
								<p>' . __( 'Example,', 'royal' ) . ' https://www.youtube.com/watch?v=<strong>kn-1D5z3-Cs</strong></p>
							</div>
							<div data-layout-type="parallax video">
								<p><strong>' . __( 'Overlay', 'royal' ) . '</strong></p>
								<select name="sections[overlay][]">
									<option value="disabled"' . ( $sections['overlay'][$i] == 'disabled' ? ' selected="selected"' : '' ) . '>' . __( 'Disabled', 'royal' ) . '</option>
									<option value="default"' . ( $sections['overlay'][$i] == 'default' ? ' selected="selected"' : '' ) . '>' . __( 'Default', 'royal' ) . '</option>
									<option value="primary"' . ( $sections['overlay'][$i] == 'primary' ? ' selected="selected"' : '' ) . '>' . __( 'Primary Color', 'royal' ) . '</option>
								</select>
							</div>
						</div>
					</li>';
				}

				$html = '
				<div style="margin-bottom: 20px;">
					<a href="#" class="button button-large add-new-section" style="font-size: 10px;" title="' . __( 'New Item', 'royal' ) . '"><i class="fa fa-plus"></i></a>&nbsp;
					<input type="submit" class="button button-large button-primary" value="' . esc_attr__( 'Save Changes', 'royal' ) . '" />
					' . ( current_user_can( 'import' ) ? '
					<div style="float: right;">
						<a href="?page=site-sections&do=import" class="button button-large">' . __( 'Import & Export Sections', 'royal' ) . '</a>
					</div>
					<div style="clear:both"></div>' : '' ) . '
				</div>' . $html;
			}

			$html .= '
			</ul>

			<div>
				<a href="#" class="button button-large add-new-section" style="font-size: 10px;" title="' . esc_attr__( 'New Item', 'royal' ) . '"><i class="fa fa-plus"></i></a>&nbsp;
				<input type="submit" class="button button-large button-primary" value="' . esc_attr__( 'Save Changes', 'royal' ) . '" />';

			if ( count( $sections ) == 0 and current_user_can( 'import' ) ) {
				$html .= '
				<div style="float: right;">
					<a href="?page=site-sections&do=import" class="button button-large">' . __( 'Import & Export Sections', 'royal' ) . '</a>
				</div>
				<div style="clear:both"></div>';
			}

			$html .= '</div>';

			$content = self::box( $html );

			echo '
			<form action="" method="post">
			<input type="hidden" name="save" value="true">';
			echo self::wrap( __( 'Site Sections', 'royal' ), $content );
			echo '</form>

			<ul style="display:none">
				<li class="site-section" id="new-section-mockup">
					<div class="site-section-remove"><i class="fa fa-times"></i></div>
					<div class="site-section-title">
						<span class="site-section-title-text">' . __( 'Untitled', 'royal' ) . '</span>
						<span class="site-section-title-type">' . __( 'Normal', 'royal' ) . '</span>
					</div>
					<div class="site-section-area opened">
						<div>
							<p><strong>' . __( 'Layout Type', 'royal' ) . '</strong></p>
							<select name="sections[layout][]" class="section-layout-type">
								<option value="normal" selected="selected">' . __( 'Normal', 'royal' ) . '</option>
								<option value="parallax">' . __( 'Section with Parallax Effect', 'royal' ) . '</option>
								<option value="video">' . __( 'Section with Video Background', 'royal' ) . '</option>
							</select>
						</div>
						<div style="display: none">
							<p><strong>' . __( 'Section Content', 'royal' ) . '</strong></p>
							<textarea class="input-large site-sections-content" name="sections[content][]" rows="4"></textarea>
						</div>
						<div data-layout-type="normal parallax video">
							<p><strong>' . __( 'Section Content', 'royal' ) . '</strong></p>
							<select name="sections[page][]" class="section-title">
								<option value="">&mdash; ' . __( 'Select a page', 'royal' ) . ' &mdash;</option>
								' . self::_pagesList( false ) . '
							</select>
						</div>
						<div data-layout-type="normal">
							<p><strong>' . __( 'Background Color', 'royal' ) . '</strong></p>
							<select name="sections[background][]" class="section-background">
								<option value="">' . __( 'Default', 'royal' ) . '</option>
								<option value="grey">' . __( 'Grey', 'royal' ) . '</option>
							</select>
						</div>
						<div data-layout-type="parallax" style="display: none">
							<p><strong>' . __( 'Background Image', 'royal' ) . '</strong></p>
							<input type="text" class="input-large" name="sections[image][]" value="" />
							<input type="button" class="button meta-item-upload" value="' . esc_attr__( 'Choose or Upload an Image', 'royal' ) . '" style="margin: -1px 0 0 5px; font-size: 12px">
						</div>
						<div data-layout-type="video" style="display: none">
							<p><strong>' . __( 'Video Start at', 'royal' ) . '</strong></p>
							<input type="text" class="input-small" name="sections[video-start][]" value="0" /> ' . __( 'seconds', 'royal' ) . '

							<p><strong>' . __( 'YouTube Video ID', 'royal' ) . '</strong></p>
							<input type="text" class="input-large" name="sections[video][]" value="" />
							<p>' . __( 'Example,', 'royal' ) . ' https://www.youtube.com/watch?v=<strong>kn-1D5z3-Cs</strong></p>
						</div>
						<div data-layout-type="parallax video" style="display: none">
							<p><strong>' . __( 'Overlay', 'royal' ) . '</strong></p>
							<select name="sections[overlay][]">
								<option value="disabled" selected="selected">' . __( 'Disabled', 'royal' ) . '</option>
								<option value="default">' . __( 'Default', 'royal' ) . '</option>
								<option value="primary">' . __( 'Primary Color', 'royal' ) . '</option>
							</select>
						</div>
					</div>
				</li>
			</ul>';
		} 
		
		// Import and export sections
		else {
			if ( isset( $_POST['upload'] ) ) {
				if ( self::doImport( 'import' ) ) {
					echo self::message( __( 'Sections updated!', 'royal' ) . '<br><br><a href="?page=site-sections">' . __( 'Return back', 'royal' ) . '</a>' );
				}
			}

			$html = '
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="page" value="site-sections">
				<input type="hidden" name="do" value="import">
				<input type="hidden" name="upload" value="true">

				<h3>' . __( 'Import Sections', 'royal' ) . '</h3>
				<p>' . __( 'Choose a JSON (.json) file to upload, then click Upload file and import.', 'royal' ) . '</p>
				<p><strong>' . __( 'Warning:', 'royal' ) . ' ' . __( 'This action will overwrite all existing sections.', 'royal' ) . '</strong></p>
				<div><input name="import" size="25" type="file"></div>
				<div style="margin-top: 15px;">
					<input type="submit" class="button button-large button-primary" value="' . esc_attr__( 'Upload File and Import', 'royal' ) . '">
				</div>
			</form>';

			$sections = ( array ) @json_decode( get_option( 'royal_sections', array( ) ), true );

			if ( count( $sections ) > 0 ) {
				$html .= '
				<div style="height: 30px;"></div>

				<h3>' . __( 'Export Sections', 'royal' ) . '</h3>
				<p>' . __( 'When you click the button below will create an JSON file for you to save to your computer.', 'royal' ) . '</p>
				<p>' . __( 'Once you\'ve saved the download file, you can use the Import function in another site to import the sections from this site.', 'royal' ) . '</p>
				<div style="margin-top: 20px;">
					<a href="' . plugins_url( 'inc/ajax.php?action=export-sections', dirname(__FILE__) ) . '" class="button button-large button-primary">' . __( 'Download Export File', 'royal' ) . '</a>
				</div>';
			}

			echo self::wrap( __( 'Import &amp; Export Sections', 'royal' ), self::box( $html ) );
		}
	}

	// Import sections
	public static function doImport( $field ) {
		wp_enqueue_script( 'royal-options' );
		wp_enqueue_style( 'royal-options' );

		$url = wp_nonce_url( 'themes.php?page=site-sections&do=import', 'royal-sections-import' );
		$fields = array( 'upload' );
		
		if ( false === ( $creds = request_filesystem_credentials( $url, '', false, false, $fields ) ) ) {
			return;
		}
		
		if ( ! WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( $url, '', true, false, $fields );
			return;
		}

		$file = &$_FILES[$field];
		
		if ( ! empty( $file['tmp_name'] ) and intval( $file['size'] ) > 0 and intval( $file['error'] ) === 0 ) {
			global $wp_filesystem;
			$content = $wp_filesystem->get_contents( $file['tmp_name'] );
			
			if ( $content !== false ) {
				$try = json_decode( $content, true );
				
				if ( is_array( $try ) and count( $try ) > 0 ) {
					if ( update_option( 'royal_sections', json_encode( $try ) ) ) {
						return true;
					} else {
						echo self::message( __( 'Error: Problem with saving changes.', 'royal' ), 'error' );
					}
				} else {
					echo self::message( __( 'Error: Not valid file format.', 'royal' ), 'error' );
				}
			} else {
				echo self::message( __( 'Error: Problem when opening a file.', 'royal' ), 'error' );
			}
		}
		
		return false;
	}
	
	// One click demo import
	public static function oneClickImport( $file ) {
		wp_enqueue_script( 'royal-options' );
		wp_enqueue_style( 'royal-options' );
		
		$content = wp_remote_get( $file );
			
		if ( ! is_wp_error( $content ) ) {
			$body = wp_remote_retrieve_body( $content );
			
			$try = json_decode( $body, true );			
			
			if ( is_array( $try ) and count( $try ) > 0 ) {
				if ( update_option( 'royal_sections', json_encode( $try ) ) ) {
					return true;
				} else {
					echo self::message( __( 'Error: Problem with saving changes.', 'royal' ), 'error' );
				}
			} else {
				echo self::message( __( 'Error: Not valid file format.', 'royal' ), 'error' );
			}
		} else {
			echo self::message( __( 'Error: Problem when opening a file.', 'royal' ), 'error' );
		}
		
		return false;
	}
	
}

// Admin menu
add_action( 'admin_menu', array( 'RoyalAdmin', 'adminMenu' ) );

// Styles and scripts
add_action( 'admin_enqueue_scripts', array( 'RoyalAdmin', 'styles' ) );
add_action( 'admin_enqueue_scripts', array( 'RoyalAdmin', 'scripts' ) );
