<?php
if ( ! class_exists( 'RoyalRedux' ) ) {
	class RoyalRedux {
		public $args        = array( );
		public $sections    = array( );
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {
			if ( ! class_exists( 'ReduxFramework' ) ) {
				return;
			}
			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings( );
			} else {
				add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
			}
		}

		public function initSettings( ) {
			if ( is_admin( ) ) {
				load_textdomain( 'royal', get_template_directory( ) . '/languages/' . get_locale( ) . '.mo' );
			}
			
			$this->setArguments( );
			$this->setSections( );

			if ( ! isset( $this->args['opt_name'] ) ) {
				return;
			}

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		public function setSections( ) {
			
			// General
			$this->sections[] = array(
				'title'     => esc_html__( 'General', 'royal' ),
				'icon'      => 'el-icon-website',
				'fields'    => array(
					array(
						'id'        => 'home-page-title',
						'type'      => 'text',
						'title'     => esc_html__( 'Home Page Title', 'royal' ),
						'desc'      => esc_html__( 'This title used only for navigation menu', 'royal' ),
						'default'   => esc_html__( 'Home', 'royal' )
					),
					array(
						'id'        => 'preloader',
						'type'      => 'switch',
						'title'     => esc_html__( 'Page Loader', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'preloader-only-home',
						'type'      => 'switch',
						'title'     => esc_html__( 'Page Loader Location', 'royal' ),
						'on'        => esc_html__( 'Only Home Page', 'royal' ),
						'off'       => esc_html__( 'All Pages', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'animations',
						'type'      => 'switch',
						'title'     => esc_html__( 'Animations on Scroll', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'multiple-videos',
						'type'      => 'switch',
						'title'     => esc_html__( 'Multiple Video Sections', 'royal' ),
						'subtitle'  => esc_html__( 'Per page', 'royal' ),
						'on'        => esc_html__( 'Allow', 'royal' ),
						'off'       => esc_html__( 'Deny', 'royal' ),
						'default'   => false
					),
					array(
						'id'        => 'settings',
						'type'      => 'switch',
						'title'     => esc_html__( 'Settings Panel', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => false
					),
				),
			);

			// Logo
			$this->sections[] = array(
				'title'     => esc_html__( 'Logo', 'royal' ),
				'icon'      => 'el-icon-picasa',
				'fields'    => array(
					array(
						'id'        => 'logo-dark',
						'type'      => 'media',
						'title'     => esc_html__( 'Dark Logo', 'royal' ),
						'subtitle'  => esc_html__( 'Normal size', 'royal' ),
						'mode'      => false,
						'desc'      => esc_html__( 'Upload a logotype image that will represent your website', 'royal' )
					),
					array(
						'id'        => 'logo-light',
						'type'      => 'media',
						'title'     => esc_html__( 'Light Logo', 'royal' ),
						'subtitle'  => esc_html__( 'Normal size', 'royal' ),
						'mode'      => false,
						'desc'      => esc_html__( 'Upload a logotype image that will represent your website', 'royal' )
					),
					array(
						'id'        => 'logo-dark-retina',
						'type'      => 'media',
						'title'     => esc_html__( 'Dark Logo (2X)', 'royal' ),
						'subtitle'  => esc_html__( 'Double size (for Retina displays)', 'royal' ),
						'mode'      => false,
						'desc'      => esc_html__( 'Name it same with the dark logo ending by @2x (image_name@2x.jpg)', 'royal' )
					),
					array(
						'id'        => 'logo-light-retina',
						'type'      => 'media',
						'title'     => esc_html__( 'Light Logo (2X)', 'royal' ),
						'subtitle'  => esc_html__( 'Double size (for Retina displays)', 'royal' ),
						'mode'      => false,
						'desc'      => esc_html__( 'Name it same with the light logo ending by @2x (image_name@2x.jpg)', 'royal' )
					),
					array(
						'id'        => 'logo-height',
						'type'      => 'slider',
						'title'     => esc_html__( 'Logo Height on Scroll', 'royal' ),
						'mode'      => false,
						'desc'      => esc_html__( 'Use numbers only', 'royal' ),
						'default'       => 25,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 100,
                        'display_value' => 'text'
					),
				),
			);
			
			// Header
			$this->sections[] = array(
				'title'     => esc_html__( 'Header', 'royal' ),
				'icon'      => 'el-icon-star-empty',
				'fields'    => array(
					array(
						'id'        => 'header-sticky',
						'type'      => 'switch',
						'title'     => esc_html__( 'Header Mode', 'royal' ),
						'on'        => esc_html__( 'Sticky', 'royal' ),
						'off'       => esc_html__( 'Normal', 'royal' ),
						'default'   => true
					),
					array(
                        'id'        => 'header-bgcolor',
                        'type'      => 'color',
                        'title'     => esc_html__( 'Header Background Color', 'royal' ),
                        'desc'  => esc_html__( 'Leave blank or pick a color for the header. (default: #ffffff).', 'royal' ),
                        'default'   => '#ffffff',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),
				),
			);
			
			// Footer
			$this->sections[] = array(
				'title'     => esc_html__( 'Footer', 'royal' ),
				'icon'      => 'el-icon-minus',
				'fields'    => array(
					array(
						'id'        => 'footer-button-top',
						'type'      => 'switch',
						'title'     => esc_html__( 'Back to Top Button', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'footer-logo',
						'type'      => 'media',
						'title'     => esc_html__( 'Footer Logo', 'royal' ),
						'mode'      => false,
					),
					array(
						'id'        => 'footer-logo-retina',
						'type'      => 'media',
						'title'     => esc_html__( 'Footer Logo (2X)', 'royal' ),
						'subtitle'  => esc_html__( 'Double size (for Retina displays)', 'royal' ),
						'mode'      => false,
						'desc'      => esc_html__( 'Name it same with the footer logo ending by @2x (image_name@2x.jpg)', 'royal' )
					),
					array(
                        'id'        => 'footer-bgcolor',
                        'type'      => 'color',
                        'title'     => esc_html__( 'Footer Background Color', 'royal' ),
                        'desc'  => esc_html__( 'Leave blank or pick a color for the footer. (default: #262626).', 'royal' ),
                        'default'   => '#262626',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),
					array(
						'id'        => 'footer-text',
						'type'      => 'editor',
						'title'     => esc_html__( 'Footer Text', 'royal' ),
						'desc'      => esc_html__( 'You can use the shortcodes in your footer text', 'royal' ),
						'default'   => esc_html__( '2020 &copy; Royal. All rights reserved.', 'royal' )
					),
				),
			);
			
			// Blog
			$this->sections[] = array(
				'title'     => esc_html__( 'Blog', 'royal' ),
				'icon'      => 'el-icon-pencil',
				'fields'    => array(
					array(
						'id'        => 'allow-share-posts',
						'type'      => 'switch',
						'title'     => esc_html__( 'Allow Sharing Posts', 'royal' ),
						'subtitle'  => esc_html__( 'Via Social Networks', 'royal' ),
						'on'        => esc_html__( 'Yes', 'royal' ),
						'off'       => esc_html__( 'No', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'breadcrumbs',
						'type'      => 'switch',
						'title'     => esc_html__( 'Breadcrumbs', 'royal' ),
						'subtitle'  => esc_html__( 'Breadcrumbs on single pages', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'    => 'opt-divide',
						'type'  => 'divide'
					),
					array(
						'id'        => 'layout-standard',
						'type'      => 'image_select',
						'compiler'  => false,
						'title'     => esc_html__( 'Standard Pages Layout', 'royal' ),
						'subtitle'  => esc_html__( 'Select one of layouts for standard pages', 'royal' ),
						'options'   => array(
							'1' => array( 'alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
							'2' => array( 'alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
							'3' => array( 'alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
						),
						'default'   => '1'
					),
					array(
						'id'        => 'layout-archive',
						'type'      => 'image_select',
						'compiler'  => false,
						'title'     => esc_html__( 'Archive Pages Layout', 'royal' ),
						'subtitle'  => esc_html__( 'Select one of layouts for archive pages', 'royal' ),
						'options'   => array(
							'1' => array( 'alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
							'2' => array( 'alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
							'3' => array( 'alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
						),
						'default'   => '3'
					),
					array(
						'id'        => 'layout-search',
						'type'      => 'image_select',
						'compiler'  => false,
						'title'     => esc_html__( 'Search Page Layout', 'royal' ),
						'subtitle'  => esc_html__( 'Select one of layouts for search page', 'royal' ),
						'options'   => array(
							'1' => array( 'alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
							'2' => array( 'alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
							'3' => array( 'alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
						),
						'default'   => '3'
					),
				),
			);

			// Typography
			$this->sections[] = array(
				'title'     => esc_html__( 'Typography', 'royal' ),
				'icon'      => 'el-icon-text-height',
				'fields'    => array(
					array(
						'id'            => 'typography-content',
						'type'          => 'typography',
						'title'         => esc_html__( 'Content &mdash; Font', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '14',
							'google'        => true,
						),
					),
					array(
						'id'            => 'typography-headers-h1',
						'type'          => 'typography',
						'title'         => esc_html__( 'Headers &mdash; H1', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-family'   => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '60',
							'google'        => true,
						),
					),
					array(
						'id'            => 'typography-headers-h2',
						'type'          => 'typography',
						'title'         => esc_html__( 'Headers &mdash; H2', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-family'   => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '40',
							'google'        => true,
						),
					),
					array(
						'id'            => 'typography-headers-h3',
						'type'          => 'typography',
						'title'         => esc_html__( 'Headers &mdash; H3', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-family'   => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '32',
							'google'        => true,
						),
					),
					array(
						'id'            => 'typography-headers-h4',
						'type'          => 'typography',
						'title'         => esc_html__( 'Headers &mdash; H4', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-family'   => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '22',
							'google'        => true,
						),
					),
					array(
						'id'            => 'typography-headers-h5',
						'type'          => 'typography',
						'title'         => esc_html__( 'Headers &mdash; H5', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-family'   => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '18',
							'google'        => true,
						),
					),
					array(
						'id'            => 'typography-headers-h6',
						'type'          => 'typography',
						'title'         => esc_html__( 'Headers &mdash; H6', 'royal' ),
						'google'        => true,
						'update_weekly' => true,
						'font-family'   => true,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'   => false,
						'subsets'       => false,
						'font-size'     => true,
						'line-height'   => false,
						'text-align'    => false,
						'color'         => false,
						'preview'       => array(
							'text'          => 'Lorem ipsum dolor sit amet.'
						),
						'default'       => array(
							'font-family'   => 'Open Sans',
							'font-size'     => '16',
							'google'        => true,
						),
					),
				),
			);
			
			// Styling
			$this->sections[] = array(
				'title'     => esc_html__( 'Styling', 'royal' ),
				'icon'      => 'el-icon-asterisk',
				'fields'    => array(
					array(
						'id'        => 'styling-schema',
						'type'      => 'select',
						'title'     => esc_html__( 'Color Schema', 'royal' ),
						'desc'      => esc_html__( 'Select a predefined color schema', 'royal' ),
						'options'   => array(
							'green'         => esc_html__( 'Green', 'royal' ),
							'blue'       	=> esc_html__( 'Blue', 'royal' ),
							'red'      	 	=> esc_html__( 'Red', 'royal' ),
							'turquoise'     => esc_html__( 'Turquoise', 'royal' ),							
							'purple'        => esc_html__( 'Purple', 'royal' ),
							'orange'        => esc_html__( 'Orange', 'royal' ),
							'yellow'        => esc_html__( 'Yellow', 'royal' ),
							'grey'     	 	=> esc_html__( 'Grey', 'royal' )
						),
						'default'   => 'green'
					),
					array(
                        'id'        => 'body-bgcolor',
                        'type'      => 'color',
                        'title'     => esc_html__( 'Body Background Color', 'royal' ),
                        'desc'  	=> esc_html__( 'Leave blank or pick a color for the body. (default: #ffffff).', 'royal' ),
                        'default'   => '#ffffff',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'loader-bgcolor',
                        'type'      => 'color',
                        'output'    => array('background-color' => 'html body'),
                        'title'     => esc_html__( 'Page Loader Background Color', 'royal' ),
                        'desc'  	=> esc_html__( 'Leave blank or pick a color for the page loader. (default: #ffffff).', 'royal' ),
                        'default'   => '#ffffff',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),
				),
			);

			// Social
			$this->sections[] = array(
				'title'     => esc_html__( 'Social', 'royal' ),
				'icon'      => 'el-icon-heart',
				'fields'    => array(					
					array(
						'id'		=> 'social-link',
						'type' 		=> 'social',
						'title' 	=> esc_html__( 'Social Links', 'royal' ),
						'options' 	=> RoyalFontAwesomeIcons(),
						'default_show' => false,
						'default' 	=> ''
					)
				),
			);

			// Home
			$this->sections[] = array(
				'title'     => esc_html__( 'Home', 'royal' ),
				'icon'      => 'el-icon-home',
				'fields'    => array(
					array(
						'id'        => 'home-magic-mouse',
						'type'      => 'switch',
						'title'     => esc_html__( 'Animated Magic Mouse', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'    => 'opt-divide',
						'type'  => 'divide'
					),
					array(
						'id'        => 'home-video-play-btn',
						'type'      => 'switch',
						'title'     => esc_html__( 'Video Play Button', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'home-video-mutted',
						'type'      => 'switch',
						'title'     => esc_html__( 'Video Mutted', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'on'        => esc_html__( 'Yes', 'royal' ),
						'off'       => esc_html__( 'No', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'home-video-loop',
						'type'      => 'switch',
						'title'     => esc_html__( 'Video Loop', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'on'        => esc_html__( 'Yes', 'royal' ),
						'off'       => esc_html__( 'No', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'home-video-start-at',
						'type'      => 'text',
						'title'     => esc_html__( 'Start Video At', 'royal' ),
						'desc'      => esc_html__( 'Enter value in seconds', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'default'   => '0'
					),
					array(
						'id'        => 'home-video-stop-at',
						'type'      => 'text',
						'title'     => esc_html__( 'Stop Video At', 'royal' ),
						'desc'      => esc_html__( 'Enter value in seconds', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'default'   => '0'
					),
					array(
						'id'        => 'home-video-overlay',
						'type'      => 'slider',
						'title'     => esc_html__( 'Video Overlay Opacity', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'desc'      => esc_html__( 'In percents (0% &ndash; fully transparent)', 'royal' ),
						'default'   => '40',
						'min'           => 0,
						'step'          => 1,
						'max'           => 100,
						'display_value' => 'text'
					),
					array(
						'id'        => 'home-video-placeholder',
						'type'      => 'media',
						'title'     => esc_html__( 'Video Callback Image', 'royal' ),
						'desc'      => esc_html__( 'This image will be shown if browser does not support fullscreen video background', 'royal' ),
						'subtitle'  => esc_html__( 'Fullscreen Video Mode', 'royal' ),
						'mode'      => false,
					),
					array(
						'id'    => 'opt-divide',
						'type'  => 'divide'
					),
					array(
						'id'        => 'home-slideshow-timeout',
						'type'      => 'text',
						'title'     => esc_html__( 'Slideshow Timeout', 'royal' ),
						'desc'      => esc_html__( 'Enter value in seconds', 'royal' ),
						'subtitle'  => esc_html__( 'Slideshow Mode', 'royal' ),
						'default'   => '10'
					),
				),
			);

			// Contact
			$this->sections[] = array(
				'title'     => __( 'Contact', 'royal' ),
				'icon'      => 'el-icon-phone',
				'fields'    => array(
					array(
						'id'        => 'contact-email',
						'type'      => 'text',
						'title'     => esc_html__( 'Target Email Address', 'royal' ),
						'default'   => ''
					),
					array(
						'id'        => 'contact-template',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Email Template', 'royal' ),
						'desc'      => esc_html__( 'Available tags &ndash; {from}, {email}, {phone}, {message}, {date}, {ip}', 'royal' ),
						'default'   => esc_html__( "Dear Administrator,\nYou have one message from {from} ({email}).\n\n{message}\n\n{date}\n{phone}", 'royal' )
					),
				),
			);

			// Map
			$this->sections[] = array(
				'title'     => __( 'Map', 'royal' ),
				'icon'      => 'el-icon-map-marker',
				'fields'    => array(
					array(
						'id'        => 'map-latitude',
						'type'      => 'text',
						'title'     => esc_html__( 'Latitude of a Point', 'royal' ),
						'desc'      => esc_html__( 'Example, 37.800976', 'royal' ),
						'default'   => '37.800976'
					),
					array(
						'id'        => 'map-longitude',
						'type'      => 'text',
						'title'     => esc_html__( 'Longitude of a Point', 'royal' ),
						'desc'      => esc_html__( 'Example, -122.428502', 'royal' ),
						'default'   => '-122.428502'
					),
					array(
						'id'            => 'map-zoom-level',
						'type'          => 'slider',
						'title'         => esc_html__( 'Zoom Level', 'royal' ),
						'desc'          => esc_html__( 'Zoom level between 0 to 21', 'royal' ),
						'default'       => 14,
						'min'           => 0,
						'step'          => 1,
						'max'           => 21,
						'display_value' => 'text'
					),
					array(
						'id'        => 'map-google-api',
						'type'      => 'text',
						'title'     => esc_html__( 'Google Maps JavaScript API Key', 'royal' ),
						'default'   => ''
					),
					array(
						'id'           => 'map-color',
						'type'         => 'color',
						'transparent'  => false,
						'title'        => esc_html__( 'Map Color', 'royal' ),
						'desc'         => esc_html__( 'Pick a color', 'royal' ),
						'default'      => '#24bca4'
					),
					array(
						'id'        => 'map-marker-state',
						'type'      => 'switch',
						'title'     => esc_html__( 'Map Marker', 'royal' ),
						'on'        => esc_html__( 'Enabled', 'royal' ),
						'off'       => esc_html__( 'Disabled', 'royal' ),
						'default'   => true
					),
					array(
						'id'        => 'map-marker',
						'type'      => 'media',
						'title'     => esc_html__( 'Marker Image', 'royal' ),
						'mode'      => false,
					),
					array(
						'id'        => 'map-marker-popup-title',
						'type'      => 'text',
						'title'     => esc_html__( 'Marker Popup Title', 'royal' ),
						'default'   => esc_html__( 'Royal Main Office', 'royal' )
					),
					array(
						'id'        => 'map-marker-popup-text',
						'type'      => 'editor',
						'title'     => esc_html__( 'Marker Popup Text', 'royal' ),
						'default'   => esc_html__( 'Donec arcu nulla, semper et urna ac, laoreet porta.<br>Vivamus sodales efficitur massa at rhoncus.', 'royal' )
					),
				),
			);

		}

		public function setArguments( ) {
			$theme = wp_get_theme( );

			$this->args = array(
				'opt_name'           => 'royalConfig',
				'display_name'       => $theme->get( 'Name' ),
				'display_version'    => $theme->get( 'Version' ),
				'menu_type'          => 'menu',
				'allow_sub_menu'     => true,
				'menu_title'         => esc_html__( 'Royal', 'royal' ),
				'page_title'         => esc_html__( 'Theme Options', 'royal' ),
				'google_api_key'     => '',
				'async_typography'   => false,
				'admin_bar'          => false,
				'global_variable'    => '',
				'dev_mode'           => false,
				'output'             => false,
				'compiler'           => false,
				'customizer'         => true,
				'page_priority'      => 102,
				'page_parent'        => 'themes.php',
				'page_permissions'   => 'manage_options',
				'menu_icon'          => 'dashicons-art',
				'last_tab'           => '',
				'page_icon'          => 'icon-themes',
				'page_slug'          => 'theme-options',
				'save_defaults'      => true,
				'default_show'       => false,
				'default_mark'       => '',
				'update_notice'      => false,
			);
			
			//Custom links in the footer of Redux panel
			$this->args['share_icons'][] = array(
				'url'   => 'https://themeforest.net/user/athenastudio',
				'title' => esc_html__( 'AthenaStudio', 'royal' ),
				'icon'  => 'el el-globe-alt'
			);
			
			$this->args['share_icons'][] = array(
				'url'   => 'https://twitter.com/AthenaStudio87',
				'title' => esc_html__( 'Twitter', 'royal' ),
				'icon'  => 'el el-twitter'
			);
			
			$this->args['share_icons'][] = array(
				'url'   => 'https://dribbble.com/AthenaStudio',
				'title' => esc_html__( 'Dribbble', 'royal' ),
				'icon'  => 'el el-dribbble'
			);
			
		}

	}
	
	global $royalInstance;
	$royalInstance = new RoyalRedux( );
}
