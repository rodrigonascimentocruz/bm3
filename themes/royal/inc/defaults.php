<?php
// Some demo content
// And variables for Redux Framework
class RoyalDefaults {
	// Initialize
	public static function init( ) {
		global $royalConfig;

		if ( ! isset( $royalConfig ) or count( $royalConfig ) == 0 ) {
			$royalConfig = self::redux( );
		}
		
		if ( ! get_option( 'royal_started', false ) ) {
			self::save( );
		}
	}

	// Save state
	public static function save( ) {
		update_option( 'royal_started', 1 );
	}

	// Default options for Redux Framework
	public static function redux( ) {
		return array(			
			'home-page-title'        => esc_html__( 'Home', 'royal' ),
			'preloader'              => 1,
			'preloader-only-home'    => 1,
			'animations'             => 1,
			'multiple-videos'        => '',
			'settings'            	 => 0,
			
			'logo-dark'              => array( 'url' => '' ),
			'logo-light'             => array( 'url' => '' ),
			'logo-dark-retina'       => array( 'url' => '' ),
			'logo-light-retina'      => array( 'url' => '' ),
			'logo-height'            => 25,
			
			'header-sticky'          => 1,
			'header-bgcolor'   		 => '#ffffff',
			
			'footer-logo'            => array( 'url' => '' ),
			'footer-logo-retina'     => array( 'url' => '' ),
			'footer-button-top'      => 1,
			'footer-bgcolor'   		 => '#262626',
			'footer-text'            => esc_html__( '2020 &copy; Royal. All rights reserved.', 'royal' ),
		
			'allow-share-posts'      => 1,
			'breadcrumbs'            => 1,
			'layout-standard'        => 1,
			'layout-archive'         => 3,
			'layout-search'          => 3,
			
			'typography-content'     => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '14px' ),
			'typography-headers-h1'  => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '60px' ),
			'typography-headers-h2'  => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '40px' ),
			'typography-headers-h3'  => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '32px' ),
			'typography-headers-h4'  => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '22px' ),
			'typography-headers-h5'  => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '18px' ),
			'typography-headers-h6'  => array( 'font-family' => 'Open Sans', 'google' => 1, 'font-size' => '16px' ),
			
			'styling-schema'         => 'green',
			'body-bgcolor'   		 => '#ffffff',
			'loader-bgcolor' 		 => '#ffffff',
			
			'home-magic-mouse'       => 1,
			'home-video-play-btn'    => 1,
			'home-video-mutted'      => 1,
			'home-video-loop'        => 1,
			'home-video-start-at'    => 0,
			'home-video-stop-at'     => 0,
			'home-video-overlay'     => 40,
			'home-video-placeholder' => array( 'url' => '' ),
			'home-slideshow-timeout' => 10,
			
			'contact-email'          => '',
			'contact-template'       => '',
			
			'map-latitude'           => '37.800976',
			'map-longitude'          => '-122.428502',
			'map-zoom-level'         => 14,
			'map-google-api'         => '',
			'map-marker-state'       => 1,
			'map-marker'             => array( 'url' => '' ),
			'map-marker-popup-title' => esc_html__( 'Royal Main Office', 'royal' ),
			'map-marker-popup-text'  => esc_html__( 'Donec arcu nulla, semper et urna ac, laoreet porta.<br>Vivamus sodales efficitur massa at rhoncus.', 'royal' ),
			
		);
	}
}

add_action( 'after_setup_theme', array( 'RoyalDefaults', 'init' ) );
