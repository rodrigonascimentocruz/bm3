<?php
class RoyalInit {	
	// Import demo content
	public static function importDemo( ) {
		return array(
			array(
				'import_file_name'			=> 	'Royal Demo Content',
				'import_file_url' 			=> 	esc_url( get_template_directory_uri() . '/demo/royal.wordpress.xml' )
			),
		);
	}
	
	// Import site sections
	public static function afterImportDemo( ) {
		if ( class_exists( 'RoyalAdmin' ) ) {
			RoyalAdmin::oneClickImport( esc_url( get_template_directory_uri() . '/demo/royal.sections.json' ) );
		}
	}
	
	// JavaScript files
	public static function scripts( ) {
		global $royalConfig;
		
		if ( ! is_admin( ) ) {
			wp_enqueue_script( 'modernizr', 			get_template_directory_uri( ) . '/layout/plugins/modernizr/modernizr.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'html5shiv', 			get_template_directory_uri( ) . '/layout/plugins/html5shiv/html5shiv.js' );
			wp_enqueue_script( 'respond', 				get_template_directory_uri( ) . '/layout/plugins/respond/respond.min.js' );
			wp_enqueue_script( 'bootstrap', 			get_template_directory_uri( ) . '/layout/plugins/bootstrap/js/bootstrap.min.js', array( ), false, true );
			wp_enqueue_script( 'google-maps', 			'//maps.googleapis.com/maps/api/js?key=' . $royalConfig['map-google-api'], array( ), false, true );
			wp_enqueue_script( 'retina', 				get_template_directory_uri( ) . '/layout/plugins/retina/retina.min.js', array( ), false, true );
			wp_enqueue_script( 'scrollto', 				get_template_directory_uri( ) . '/layout/plugins/scrollto/jquery.scrollto.min.js', array( ), false, true );
			wp_enqueue_script( 'mbytplayer', 			get_template_directory_uri( ) . '/layout/plugins/mb/jquery.mb.ytplayer.min.js', array( ), false, true );
			wp_enqueue_script( 'parallax', 				get_template_directory_uri( ) . '/layout/plugins/parallax/jquery.parallax.min.js', array( ), false, true );
			wp_enqueue_script( 'royal-isotope', 		get_template_directory_uri( ) . '/layout/plugins/isotope/jquery.isotope.min.js', array( ), false, true );
			wp_enqueue_script( 'nav', 					get_template_directory_uri( ) . '/layout/plugins/nav/jquery.nav.min.js', array( ), false, true );
			wp_enqueue_script( 'knob', 					get_template_directory_uri( ) . '/layout/plugins/knob/jquery.knob.min.js', array( ), false, true );
			wp_enqueue_script( 'twitter', 				get_template_directory_uri( ) . '/layout/plugins/twitter/jquery.tweet.min.js', array( ), false, true );
			wp_enqueue_script( 'royal-main', 			get_template_directory_uri( ) . '/layout/js/main.js', array( ), false, true );
			
			wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
			wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

			// Add parameters for main
			wp_localize_script('royal-main', 'js_load_parameters',
				array(
					'theme_default_path' => get_template_directory_uri(),
					'theme_site_url' => get_home_url()
				)
			);

			if ( is_singular( ) && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( "comment-reply" );
			}
			
			if ( isset( $royalConfig ) and $royalConfig['settings'] ) {
				wp_enqueue_script( 'cookie', 			get_template_directory_uri( ) . '/layout/plugins/settings/jquery.cookies.min.js', array( ), false, true );
				wp_enqueue_script( 'royal-settings', 	get_template_directory_uri( ) . '/layout/plugins/settings/settings.js', array( ), false, true );
			}
		} else {
			$currentPage = ( isset( $_GET['page'] ) ) ? $_GET['page'] : '';

			if ( $currentPage == 'site-sections' or
				 $currentPage == 'portfolio-reorder' or
				 $currentPage == 'clients-reorder' or
				 isset( $_GET['post'] )
				) {
					wp_enqueue_media( );
					wp_enqueue_script( 'jquery-ui-core' );
					wp_enqueue_script( 'jquery-ui-dropable' );
					wp_enqueue_script( 'jquery-ui-dragable' );
					wp_enqueue_script( 'jquery-ui-sortable', 'jquery' );
			}
		}
	}

	// CSS files
	public static function styles( ) {
		global $royalConfig;

		if ( ! is_admin( ) ) {
			wp_enqueue_style( 'bootstrap', 				get_template_directory_uri( ) . '/layout/plugins/bootstrap/css/bootstrap.min.css' );
			wp_enqueue_style( 'font-awesome', 			get_template_directory_uri( ) . '/layout/plugins/fontawesome/css/font-awesome.min.css' );
			wp_enqueue_style( 'linea-arrows', 			get_template_directory_uri( ) . '/layout/plugins/linea/arrows/styles.css' );
			wp_enqueue_style( 'mbytplayer', 			get_template_directory_uri( ) . '/layout/plugins/mb/css/jquery.mb.ytplayer.min.css' );
			wp_enqueue_style( 'royal-style', 			get_template_directory_uri( ) . '/layout/style.css' );
			wp_enqueue_style( 'royal-wp-style', 		get_template_directory_uri( ) . '/style.css' );
			wp_enqueue_style( 'royal-media', 			get_template_directory_uri( ) . '/layout/media.css' );
			wp_enqueue_style( 'royal-isotope', 			get_template_directory_uri( ) . '/layout/plugins/isotope/isotope.css' );
			wp_enqueue_style( 'royal-color-schema', 	get_template_directory_uri( ) . '/layout/colors/' . $royalConfig['styling-schema'] . '.css' );
			
			// Settings
			if ( isset( $royalConfig ) and $royalConfig['settings'] ) {
				wp_enqueue_style( 'royal-settings', 	get_template_directory_uri( ) . '/layout/plugins/settings/settings.css' );
			}
			
			// Custom font style
			$isDynamic = false;
			if ( isset( $royalConfig ) ) {
				if (   ! empty( $royalConfig['header-bgcolor'] ) 	&& $royalConfig['header-bgcolor'] 	!= "#ffffff"
					or ! empty( $royalConfig['footer-bgcolor'] ) 	&& $royalConfig['footer-bgcolor'] 	!= "#262626"
					or ! empty( $royalConfig['body-bgcolor'] ) 		&& $royalConfig['body-bgcolor'] 	!= "#ffffff"
					or ! empty( $royalConfig['loader-bgcolor'] )	&& $royalConfig['loader-bgcolor'] 	!= "#ffffff"
					or $royalConfig['typography-content']['font-family']    != 'Open Sans' or intval( $royalConfig['typography-content']['font-size'] ) != 14
					or $royalConfig['typography-headers-h1']['font-family'] != 'Open Sans' or intval( $royalConfig['typography-headers-h1']['font-size'] ) != 60
					or $royalConfig['typography-headers-h2']['font-family'] != 'Open Sans' or intval( $royalConfig['typography-headers-h2']['font-size'] ) != 40
					or $royalConfig['typography-headers-h3']['font-family'] != 'Open Sans' or intval( $royalConfig['typography-headers-h3']['font-size'] ) != 32
					or $royalConfig['typography-headers-h4']['font-family'] != 'Open Sans' or intval( $royalConfig['typography-headers-h4']['font-size'] ) != 22
					or $royalConfig['typography-headers-h5']['font-family'] != 'Open Sans' or intval( $royalConfig['typography-headers-h5']['font-size'] ) != 18
					or $royalConfig['typography-headers-h6']['font-family'] != 'Open Sans' or intval( $royalConfig['typography-headers-h6']['font-size'] ) != 16
				) $isDynamic = true;
			}

			if ( $isDynamic ) {
				$custom_css = RoyalTheme::customCSS( );
				wp_add_inline_style( 'royal-style', $custom_css );
			}
			
			// Custom logo height
			if ( isset( $royalConfig ) and ( int ) $royalConfig['logo-height'] != 25 ) {
				$height = $royalConfig['logo-height'];
				$translateY = $height + 65;
				$margin = ( int ) ( ( $height - 25 ) / 2 ) + 2 ;
				
				$custom_css = '.navbar .navbar-header {
									height:' . $height . 'px;
								}
								
								.navbar .navbar-nav {
									margin-top:' . $margin . 'px;
								}';
								
				wp_add_inline_style( 'royal-style', $custom_css );
			}
		} else {
			wp_enqueue_style( 'font-awesome', 			get_template_directory_uri( ) . '/layout/plugins/fontawesome/css/font-awesome.min.css' );
			wp_enqueue_style( 'royal-admin-style', 		get_template_directory_uri( ) . '/admin/css/admin.css' );
		}
	}

	// Google fonts
	public static function fonts( ) {
		global $royalConfig;

		$fonts = array( 'typography-content', 'typography-headers-h1', 'typography-headers-h2', 'typography-headers-h3', 'typography-headers-h4', 'typography-headers-h5', 'typography-headers-h6' );
		foreach ( $fonts as $key ) {
			if ( $royalConfig[$key]['font-family'] == 'Open Sans' ) {
				wp_deregister_style( 'open-sans' );
				wp_deregister_style( 'options-google-fonts' );
				break;
			}
		}

		$fonts = array( );
		for ( $i = 1; $i <= 6; $i ++ ) {
			$key = 'typography-headers-h' . $i;
			
			if ( (boolean) json_decode( $royalConfig[$key]['google'] ) ) {
				$name = strtolower( str_replace( ' ', '-', $royalConfig[$key]['font-family'] ) );
				if ( ! in_array( $name, $fonts ) ) {
					$fonts[] = $name;
					$google = str_replace( ' ', '+', $royalConfig[$key]['font-family'] );					
					$font_url = add_query_arg( 'family', $google . urlencode( ':300,300italic,400,400italic,500,500italic,600,600italic,700,700italic' ), "//fonts.googleapis.com/css" );

					wp_enqueue_style( $name, $font_url );
				}
			}
		}
		
		if ( (boolean) json_decode( $royalConfig['typography-content']['google'] ) ) {
			$name = strtolower( str_replace( ' ', '-', $royalConfig['typography-content']['font-family'] ) );
			
			if ( ! in_array( $name, $fonts ) ) {
				$fonts[] = $name;
				$google = str_replace( ' ', '+', $royalConfig['typography-content']['font-family'] );
				$font_url = add_query_arg( 'family', $google . urlencode( ':300,300italic,400,400italic,500,500italic,600,600italic,700,700italic' ), "//fonts.googleapis.com/css" );

				wp_enqueue_style( $name, $font_url );
			}
		}
	}

	// Initialization
	public static function init( ) {
		// Removing demo mode (Redux Framework)
		if ( class_exists('ReduxFrameworkPlugin') ) {
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance( ), 'admin_notices' ) );
		}

		// Register menus
		register_nav_menu( 'header-menu', esc_html__( 'Primary Menu', 'royal' ) );
	}

	// After setup theme
	public static function setup( ) {
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		// Let WordPress manage the document title
		add_theme_support( 'title-tag' );
		
		// Enable support for post thumbnails on posts and pages
		add_theme_support( 'post-thumbnails', array( 'post', 'our-clients', 'our-team', 'portfolio' ) );
		
		// Enable support for post formats
		add_theme_support( 'post-formats', array( 'gallery', 'aside', 'status', 'quote', 'link' ) );
		
		// Switch default core markups to output valid HTML5
		add_theme_support( 'html5', array( 'search-form' ) );
		
		// Set up the WordPress core custom header feature
		add_theme_support( 'custom-header' ); 
		
		// Set up the WordPress core custom background feature
		add_theme_support( 'custom-background' );
		
		// Add support for responsive embeds
		add_theme_support( 'responsive-embeds' );
		
		// Gutenberg wide and full images support
		add_theme_support( 'align-wide' );
		
		// Add custom colors to Gutenberg
		add_theme_support(
			'editor-color-palette', array(				
				array(
					'name'  => esc_html__( 'Green', 'royal' ),
					'slug' => 'green',
					'color' => '#24bca4',
				),
				array(
					'name'  => esc_html__( 'Blue', 'royal' ),
					'slug' => 'blue',
					'color' => '#4e9cb5',
				),
				array(
					'name'  => esc_html__( 'Red', 'royal' ),
					'slug' => 'red',
					'color' => '#f25454',
				),
				array(
					'name'  => esc_html__( 'Turquoise', 'royal' ),
					'slug' => 'turquoise',
					'color' => '#46cad7',
				),
				array(
					'name'  => esc_html__( 'Purple', 'royal' ),
					'slug' => 'purple',
					'color' => '#c86f98',
				),
				array(
					'name'  => esc_html__( 'Orange', 'royal' ),
					'slug' => 'orange',
					'color' => '#ee8f67',
				),
				array(
					'name'  => esc_html__( 'Yellow', 'royal' ),
					'slug' => 'yellow',
					'color' => '#e4d20c',
				),
				array(
					'name'  => esc_html__( 'Grey', 'royal' ),
					'slug' => 'grey',
					'color' => '#6b798f',
				),
				array(
					'name'  => esc_html__( 'Black', 'royal' ),
					'slug' => 'black',
					'color' => '#282828',
				),
				array(
					'name'  => esc_html__( 'White', 'royal' ),
					'slug' => 'white',
					'color' => '#ffffff',
				),
			)
		);
	}

	// Main menu attributes
	public static function menuAtts( $atts, $item, $args = array( ) ) {
		if ( ! isset( $args->theme_location ) or $args->theme_location != 'header-menu' ) {
			return $atts;
		}

		if ( get_option( 'show_on_front', 'posts' ) == 'page' and get_option( 'page_on_front', 0 ) > 0 ) {
			$is_front_page = RoyalTheme::isFrontPage( get_the_ID( ) );

			if ( $is_front_page ) {
				$front_id = get_option( 'page_on_front' );
				if ( intval( $front_id ) == $item->object_id and $item->object_id == get_the_ID( ) ) {
					$atts['href'] = '#intro';
				}
			}

			if ( $item->object == 'page' ) {
				if ( $slug = self::sectionID( $item->object_id ) ) {
					if ( $is_front_page ) {
						$atts['href'] = '#' . $slug;
					} else {
						$atts['href'] = esc_url( home_url( '/' ) . '#' . $slug );
					}
				}
			}
		}

		return $atts;
	}

	// Main menu classes
	public static function menuClasses( $classes, $item, $args ) {
		if ( ! isset( $args->theme_location ) or $args->theme_location != 'header-menu' ) {
			return $classes;
		}

		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'dropdown';
		}

		return $classes;
	}

	// Fallback menu
	public static function menuFallback( $menu, $args = array( ) ) {
		if ( isset( $args['royal_fallback'] ) and isset( $args['royal_class'] ) ) {
			$menu = preg_replace( '/ class="' . $args['menu_class'] . '"/', '', $menu );
			$menu = preg_replace( '/<ul>/', '<ul class="' . esc_attr( $args['royal_class'] ) . '">', $menu );
		}

		return $menu;
	}

	// Section ID on front page
	public static function sectionID( $post_id ) {
		$sections = ( array ) @json_decode( get_option( 'royal_sections', true ), true );

		if ( count( $sections ) > 0 ) {
			$post = get_post( $post_id );
			if ( $post !== null ) {
				if ( in_array( $post->post_name, $sections['page'] ) ) {
					return $post->post_name;
				}
			}
		}

		return false;
	}

	// More link
	public static function moreLink( $link, $text ) {
		return str_replace( 'more-link', 'more-link btn btn-default', $link );
	}

	// Widgets
	public static function widgets( ) {
		// Sidebars
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'royal' ),
			'id'            => 'sidebar-primary',
			'description'   => esc_html__( 'Widgets in this area will be shown in the sidebar.', 'royal' ),
			'before_widget' => '<div id="%1$s" class="row sidebar widget %2$s"><div class="col-md-12 col-sm-12">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<header><h4>',
			'after_title'   => '</h4></header>'
		) );
		
		register_sidebar(array(
			'name' => esc_html__( 'Footer', 'royal' ),
			'id' => 'footer',
			'description' => esc_html__( 'Widgets in this area will be shown in the footer.', 'royal' ),
			'before_widget' => '<div id="%1$s" class="row footer widget %2$s"><div class="col-md-12 col-sm-12">',
			'after_widget' => '</div></div>',
			'before_title' => '<header><h4>',
			'after_title' => '</h4></header>',
		));
	}

	// Embed video
	public static function embed( $source, $url = '' ) {
		$before = '<div class="embed-container">';
		$after = '</div>';
		
		if ( substr_count( $url, 'twitter.' ) > 0 ) {
			$before = $after = '';
		}
		
		return $before . $source . $after;
	}

	// Left link attributes (Navigation for posts & comments)
	public static function navLinkLeft( $atts = '' ) {
		$atts .= ( ! empty( $atts ) ? ' ' : '' ) . 'class="pull-left"';
		return $atts;
	}

	// Right Link Attributes (Navigation for posts & comments)
	public static function navLinkRight( $atts = '' ) {
		$atts .= ( ! empty( $atts ) ? ' ' : '' ) . 'class="pull-right"';
		return $atts;
	}

	// Password form (Protected posts)
	public static function passwordForm( ) {
		global $post;
		
		return '<div class="nothing-found">
		<form class="search-form" action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<div style="padding-bottom:20px">' . esc_html__( 'To view this protected post, enter the password below:', 'royal' ) . '</div>
		<input name="post_password" type="password" class="search-field" size="20" maxlength="20" /><input type="submit" name="Submit" class="search-submit" value="' . esc_attr__( 'Submit', 'royal' ) . '" /></form></div>';
	}
	
	// Gutenberg editor styles
	public static function editorStyles() {
		wp_enqueue_style( 'royal-editor-block-style', get_template_directory_uri( ) . '/layout/editor-blocks.css' );
		wp_enqueue_style( 'royal-fonts', RoyalInit::fontsUrl( ), array(), null );
	}
	
	// Register custom fonts
	public static function fontsUrl() {
		global $royalConfig;
		
		$fonts_url = '';
	
		if ( isset( $royalConfig['typography-content']['google'] ) ) {
			$font_families = array();
	
			$font_families[] = $royalConfig['typography-content']['font-family'] . ':300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800';
			
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
	
			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}
	
		return esc_url_raw( $fonts_url );
	}
}

// Import demo
add_action( 'pt-ocdi/after_import', array( 'RoyalInit', 'afterImportDemo' ) );
add_filter( 'pt-ocdi/import_files', array( 'RoyalInit', 'importDemo' ), 10, 3 );

// Enqueue scripts
add_action( 'wp_enqueue_scripts', array( 'RoyalInit', 'fonts' ) );
add_action( 'wp_enqueue_scripts', array( 'RoyalInit', 'styles' ) );
add_action( 'wp_enqueue_scripts', array( 'RoyalInit', 'scripts' ) );
add_action( 'admin_enqueue_scripts', array( 'RoyalInit', 'styles' ) );
add_action( 'admin_enqueue_scripts', array( 'RoyalInit', 'scripts' ) );

// Init
add_action( 'init', array( 'RoyalInit', 'init' ) );
add_action( 'after_setup_theme', array( 'RoyalInit', 'setup' ) );
add_action( 'widgets_init', array( 'RoyalInit', 'widgets' ) );
add_action( 'the_content_more_link', array( 'RoyalInit', 'moreLink' ), 10, 2 );
add_filter( 'the_password_form', array( 'RoyalInit', 'passwordForm' ) );

// Menu
add_filter( 'nav_menu_link_attributes', array( 'RoyalInit', 'menuAtts' ), 10, 3 );
add_filter( 'nav_menu_css_class', array( 'RoyalInit', 'menuClasses' ), 10, 3 );
add_filter( 'wp_page_menu', array( 'RoyalInit', 'menuFallback' ), 10, 2 );

// Previus / Next buttons
add_filter( 'next_posts_link_attributes', array( 'RoyalInit', 'navLinkLeft' ) );
add_filter( 'previous_posts_link_attributes', array( 'RoyalInit', 'navLinkRight' ) );
add_filter( 'previous_comments_link_attributes', array( 'RoyalInit', 'navLinkLeft' ) );
add_filter( 'next_comments_link_attributes', array( 'RoyalInit', 'navLinkRight' ) );

// Embed video
add_filter( 'embed_oembed_html', array( 'RoyalInit', 'embed' ), 10, 3 );
add_filter( 'video_embed_html', array( 'RoyalInit', 'embed' ) );

// Enqueue editor styles
add_editor_style( array( 'layout/editor-style.css', RoyalInit::fontsUrl( ) ) );
add_action( 'enqueue_block_editor_assets', array( 'RoyalInit', 'editorStyles' ) );






