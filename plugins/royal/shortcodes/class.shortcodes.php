<?php
class RoyalShortcodes {
	/*
	 * Variables
	 */

	// Accordions
	static $accordionsCounters;
	static $accordionCounters;

	// Tabs
	static $tabsCounters;
	static $tabsTitles;
	static $tabsActive;

	// Pricing tables
	static $pricingTableColumns;

	// Columns
	static $columnsCount;
	static $columnsOffset;

	/*
	 * Functions
	 */

	// Convert Columns
	public static function getColumnsNumber( $fraction ) {
		list( $x, $y ) = explode( '/', $fraction );

		$x = intval( $x ) > 0 ? intval( $x ) : 1;
		$y = intval( $y ) > 0 ? intval( $y ) : 1;

		return round( $x * ( 12 / $y ) );
	}

	// Shortcodes fix
	// https://gist.github.com/bitfade/4555047
	public static function filter( $content ) {
		$block = join( '|', array(
			'button',   	'icon',		'twitter_feed', 'details',      'map',     		'contact_form', 	'our_clients', 
			'bars',      	'bar',		'progress', 	'milestone', 	'counter',		'info_box', 		'our_team',     	
			'services',     'service', 	'portfolio',	'accordions',  	'accordion', 	'tabs',				'tab',      	
			'promotion', 	'alert',    'highlight',	'sticker',		'dropcap',		'quote',        	'pricing_table', 
			'plan',        	'blog', 	'google_map',	'video',		'section_title'
		) );

		$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
		$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );

		return $rep;
	}

	/*
	 * Shortcodes
	 */

	// Section title ([section_title])
	public static function sectionTitle( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'color'  => ''
		), $atts ) );
		
		$output = '<div class="section-title ' . $color . '"><h2>' . wp_kses( $title, 'strong' ) . '</h2>' . (strlen( $content ) > 0 ? '<p class="info">' . do_shortcode( $content ) . '</p>' : '') . '</div>';
		
		return $output;
	}
	
	public static function vc_sectionTitle() {
		vc_map( array(
		   	"name" => esc_html__("Section Title", "royal"),
		   	"base" => "section_title",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__("Royal Elements", "royal"),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Slogan", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
					"class" => "",
				 	"heading" => esc_html__("Color", 'royal'),
				 	"param_name" => "color",
				 	"value" => array(   
						esc_html__( "Dark", "royal" ) => '',
						esc_html__( "White", "royal" ) => 'white'
					),
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Button ([button])
	public static function button( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'url'     => '',
			'target'  => '',
			'icon'    => '',
			'size'    => 'normal',
			'color'   => '',
			'rounded' => '',
			'inverse' => '',
			'style'    => '',
			'class'   => 'block'
		), $atts ) );
		
		$url = vc_build_link( $url );
		$target = strlen( $url['target'] ) > 0 ? $url['target'] : $target;
		$url = strlen( $url['url'] ) > 0 ? $url['url'] : '';

		$block = ( substr_count( $class, 'block' ) > 0 );
		$classesBlock = '';
		
		if ( $block ) {
			$classesBlock = preg_replace( '/block/', '', $class );
			$class = '';
		}

		return ( $block ? '<div' . ( ! empty( $classesBlock ) ? ' class="' . esc_attr( $classesBlock ) . '"' : '' ) . '>' : '' ) . '<a href="' . esc_url( $url ) . '" class="btn btn-' . ( ! empty( $style ) ? 'link' : 'default' ) . ( $size == 'small' ? ' btn-small' : '' ) . ( ! empty( $rounded ) ? ' btn-rounded' : '' ) . ( ! empty( $inverse ) ? ' btn-inverse' : '' ) . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . '"' . ( $target != '_self' ? ' target="' . esc_attr( $target ) . '"' : '' ) . ( ! empty( $color ) ? ' style="color: ' . esc_attr( $color ) . ';"' : '' ) . '>' . ( ! empty( $icon ) ? '<i class="' . esc_attr( $icon ) . '"></i>' . ' ' : '' ) . $content . '</a>' . ( $block ? '</div>' : '' );
	}
	
	public static function vc_button() {
		vc_map( array(
		   	"name" => esc_html__("Button", "royal"),
		   	"base" => "button",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__("Royal Elements", "royal"),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					'type' 		  => 'vc_link',
					'heading' 	  => esc_html__( 'URL', 'royal' ),
					'param_name'  => 'url',
					'description' => "",
					"admin_label" => true,
			  	),
				array(
					"type" 		  => "dropdown",
					"heading" 	  => esc_html__( "Icon library", "royal" ),
					"value" 	  => array(
					  esc_html__( "Font Awesome", "royal" ) => "fontawesome",
					),
					"admin_label" => false,
					"param_name"  => "type",
					"description" => "",
				),
				array(
					"type" => "iconpicker",
					"heading" => esc_html__( "Icon", "royal" ),
					"param_name" => "icon",
					"value" => "",
					"settings" => array(
					  "emptyIcon" => true,
					  "iconsPerPage" => 4000,
					),
					"dependency" => array(
					  "element" => "type",
					  "value" => "fontawesome",
					),
				),
			  	array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__("Size", 'royal'),
				 	"param_name" => "size",
				 	"value" => array(   
						"Normal" => '',
						"Small" => 'small'
					),
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "colorpicker",
					"heading"     => esc_html__( "Color", "royal" ),
					"param_name"  => "color",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "checkbox",
					"heading"     => esc_html__( "Rounded", "royal" ),
					"param_name"  => "rounded",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "checkbox",
					"heading"     => esc_html__( "Inverse", "royal" ),
					"param_name"  => "inverse",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__("Style", 'royal'),
				 	"param_name" => "style",
				 	"value" => array(   
						"Button" => '',
						"Link" => 'link'
					),
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}	
	
	// Video control ([video])
	public static function video( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );

		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';	
		
		return '<div class="video-control animate text-center" data-hide=".container" ' . $style . '><i class="fa fa-play"></i></div>';
	}
	
	public static function vc_video() {
		vc_map( array(
		   	"name" => esc_html__( "Video Control", "royal" ),
		   	"base" => "video",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "counter"
   			),
			"show_settings_on_create" => false,
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Twitter feed ([twitter_feed])
	public static function twitter( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'account' => '',
			'limit'   => 8,
			'reply'   => 'true',
			'delay'   => 0,
			'token' => '',			// Twitter App Access Token
			'token_secret' => '',	// Twitter App Access Token Secret
			'consumer_key' => '',	// Twitter App Consumer Key
			'consumer_secret' => ''	// Twitter App Consumer Secret
		), $atts ) );

		if ( $account == '' ) {
			return;
		}

		$output = '';
		$counter = 0;
		$delay = intval( $delay );
		$tweets = RoyalTwitter::getTweets( $account, $token, $token_secret, $consumer_key, $consumer_secret );

		if ( is_array( $tweets ) and count( $tweets ) > 0 ) {
			foreach( $tweets as $tweet ) {
				if ( $counter < $limit ) {
					$srid = ( int ) $tweet->in_reply_to_user_id;
					
					if ( $srid == 0 || $reply == 'true' ) {
						$text = preg_replace( array( "/\\r/", "/\\n/" ), array( '', ' ' ), $tweet->text );
						$output .= '<li><span class="tweet_text">' . RoyalTwitter::parseLinks( $text ) . '</span></li>';
						$counter ++;
					}
				}
			}
			
			if ( $counter > 0 ) {
				$output = '
					<div class="twitter">
						<div class="twitter-feed">
							<ul class="tweet_list" data-arrows=".twitter-arrows"' . ( $delay > 0 ? ' data-delay="' . ( $delay * 1000 ) . '"' : '' ) . '>' . $output . '</ul>
						</div>
						<div class="offsetTopS">
							<a href="' . esc_url( 'https://twitter.com/' . $account ) . '" target="_blank" class="twitter-author">' . esc_html( '@' . $account ) . '</a>
						</div>
					</div>
					<div class="row arrows twitter-arrows text-center">
						<a class="arrow left"><i class="fa fa-chevron-left"></i></a><a class="arrow right"><i class="fa fa-chevron-right"></i></a>
					</div>';
			}
		}

		return $output;
	}
	
	public static function vc_twitter() {
		vc_map( array(
		   	"name" => esc_html__( "Twitter Feed", "royal" ),
		   	"base" => "twitter_feed",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Account", "royal" ),
					"param_name"  => "account",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Tweets Count", "royal" ),
					"param_name"  => "limit",
					"value"       => "5",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Auto Slideshow", "royal" ),
				 	"param_name" => "delay",
				 	"value" => array(   
						esc_html__( "Disabled", "royal" ) => '',
						esc_html__( "5 Seconds", "royal" ) => '5',
						esc_html__( "10 Seconds", "royal" ) => '10',
						esc_html__( "15 Seconds", "royal" ) => '15',
						esc_html__( "20 Seconds", "royal" ) => '20',
						esc_html__( "30 Seconds", "royal" ) => '30',
						esc_html__( "1 Minute", "royal" ) => '60'
					),
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Access Token", "royal" ),
					"param_name"  => "token",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Access Token Secret", "royal" ),
					"param_name"  => "token_secret",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Consumer Key", "royal" ),
					"param_name"  => "consumer_key",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Consumer Secret", "royal" ),
					"param_name"  => "consumer_secret",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Google maps (Section) ([map])
	public static function map( $atts, $content = null ) {
		global $royalConfig;
		
		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );
		
		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';	

		$marker = get_template_directory_uri( ) . '/layout/images/marker-' . $royalConfig['styling-schema'] . '.png';

		if ( ! $royalConfig['map-marker-state'] ) {
			$marker = false;
		} else if ( ! empty( $royalConfig['map-marker']['url'] ) ) {
			$marker = $royalConfig['map-marker']['url'];
		}
		
		return '
		<div id="google-map" ' . $style . ' data-map-zoom="' . ( $royalConfig['map-zoom-level'] > 0 ? intval( $royalConfig['map-zoom-level'] ) : 10 ) . '" data-latitude="' . ( ! empty( $royalConfig['map-latitude'] ) ? esc_attr( $royalConfig['map-latitude'] ) : '40.706279' ) . '" data-longitude="' . ( ! empty( $royalConfig['map-longitude'] ) ? esc_attr( $royalConfig['map-longitude'] ) : '-74.005121' ) . '"' . ' data-color="' . esc_attr( $royalConfig['map-color'] ) . '"' . ( $marker !== false ? ' data-marker="' . esc_url( $marker ) . '"' : '' ) . '></div>
		' . ( $marker !== false ? '<div id="map-info">
			<div id="content">
				<div id="siteNotice"></div>
				<h4 id="firstHeading" class="firstHeading">' . esc_html( $royalConfig['map-marker-popup-title'] ) . '</h4>
				<div id="bodyContent">' . apply_filters( 'the_content', do_shortcode( $royalConfig['map-marker-popup-text'] ) ) . '</div></div>
		</div>' : '' );
	}
	
	public static function vc_map() {
		vc_map( array(
		   	"name" => esc_html__( "Map", "royal" ),
		   	"base" => "map",
		   	"icon" => 'icon-vc',
			"show_settings_on_create" => false,
		   	"category" => esc_html__("Royal Elements", "royal"),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Google maps (Shortcode) ([google_map])
	public static function googleMap( $atts, $content = null ) {
		global $royalConfig;
		
		extract( shortcode_atts( array(
			'latitude'  => '',
			'longitude' => '',
			'zoom'      => '15',
			'height'    => '200px',
			'title'		=> '',
			'txt'		=> ''
		), $atts ) );
		
		$height = intval( $height );		
		$marker = get_template_directory_uri( ) . '/layout/images/marker-green.png';

		if ( ! $royalConfig['map-marker-state'] ) {
			$marker = false;
		} else if ( ! empty( $royalConfig['map-marker']['url'] ) ) {
			$marker = $royalConfig['map-marker']['url'];
		}

		return '
		<div id="google-map" data-map-zoom="' . intval( $zoom ) . '" data-latitude="' . esc_attr( $latitude ) . '" data-longitude="' . esc_attr( $longitude ) . '"' . ' data-color="' . esc_attr( $royalConfig['map-color'] ) . '"' . ( $marker !== false ? ' data-marker="' . esc_url( $marker ) . '"' : '' ) . ' style="height: ' . intval( $height ) . 'px;"></div>
		' . ( $marker !== false ? '<div id="map-info">
			<div id="content">
				<div id="siteNotice"></div>
				<h4 id="firstHeading" class="firstHeading">' . esc_html( $title ) . '</h4>
				<div id="bodyContent">' . apply_filters( 'the_content', do_shortcode( $txt ) ) . '</div></div>
		</div>' : '' );
	}
	
	public static function vc_googleMap() {
		vc_map( array(
		   	"name" => esc_html__( "Google Maps", "royal" ),
		   	"base" => "google_map",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Latitude", "royal" ),
					"param_name"  => "latitude",
					"value"       => "",
					"description" => "Please enter <a href='http://www.latlong.net/'>Latitude</a>",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Longitude", "royal" ),
					"param_name"  => "longitude",
					"value"       => "",
					"description" => "Please enter <a href='http://www.latlong.net/'>Longitude</a>",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Zoom Level", "royal" ),
					"param_name"  => "zoom",
					"value"       => "15",
					"description" => "Zoom level between 0 to 21",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Height", "royal" ),
					"param_name"  => "height",
					"value"       => "200px",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Marker Popup Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Marker Popup Text", "royal" ),
					"param_name"  => "txt",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Contact form ([contact_form])
	public static function contactForm( $atts, $content = null ) {
		return '<div id="royal-contact-form" class="contact-form field-action" data-url="' . esc_url( plugins_url( 'inc/ajax.php', dirname(__FILE__) ) ) . '">
					<div class="field">
						<input type="text" name="name" class="field-name" placeholder="' . esc_attr__( 'Name', 'royal' ) . '"></div>			
					<div class="field">
						<input type="email" name="email" class="field-email" placeholder="' . esc_attr__( 'Email', 'royal' ) . '">
					</div>
					<div class="field">
						<input type="text" name="phone" class="field-phone" placeholder="' . esc_attr__( 'Phone', 'royal' ) . '">
					</div>
					<div class="field">
						<textarea name="message" class="field-message" placeholder="' . esc_attr__( 'Message', 'royal' ) . '"></textarea>
					</div>
					
					<div>
						<button type="submit" class="btn btn-default" id="contact-submit">' . esc_attr__( 'Send Message', 'royal' ) . '</button>
					</div>
				</div>
				<div class="contact-form-result">' . do_shortcode( $content ) . '</div>';
	}
	
	public static function vc_contactForm() {
		vc_map( array(
		   	"name" => esc_html__( "Contact Form", "royal" ),
		   	"base" => "contact_form",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Form Result Text", "royal" ),
					"param_name"  => "content",
					"value"       => "<h3>Thank you so much for the Email!</h3><p>Your message has already arrived! We\'ll contact you shortly.</p><h5>Good day.</h5>",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Our clients ([our_clients])
	public static function ourClients( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'column' => '1/6',
			'limit'  => 6,
			'class'  => ''
		), $atts ) );

		$limit = intval( $limit );
		$query = array(
			'post_type'   		=> 'our-clients',
			'suppress_filters' 	=> 0,
			'numberposts' 		=> $limit,
			'orderby'     		=> 'menu_order',
			'order'       		=> 'ASC'
		);
		$rows = get_posts( $query );
		$output = '';

		if ( count( $rows ) > 0 ) {
			$output .= '<div class="row clients">';

			foreach ( $rows as $row ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $row->ID ), 'full' );
				$title = apply_filters( 'the_title', $row->post_title );
				$meta = get_post_meta( $row->ID );
				$url = $meta['url'][0];
				
				$output .= '<div class="col-md-' . self::getColumnsNumber( $column ) . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . '">'. ( ! empty( $url ) ? '<a href="' . esc_url( $url ) . '">' : '' ) . '<img src="' . $thumb[0] . '" width="' . floor( $thumb[1] / 2 ) . '" class="img-responsive center-block" alt="' . $title . '">'. ( ! empty( $url ) ? '</a>' : '' ) . '</div>';
			}

			$output .= '</div>';
		}
		
		return $output;
	}
	
	public static function vc_ourClients() {
		vc_map( array(
		   	"name" => esc_html__( "Our Clients", "royal" ),
		   	"base" => "our_clients",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2" => '1/2',
						"1/3" => '1/3',
						"1/4" => '1/4',
						"1/6" => '1/6'
					),
					"std" => "1/6",
				 	"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Limit", "royal" ),
					"param_name"  => "limit",
					"value"       => "6",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Circular bars ([bars])
	public static function bars( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );

		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';	
		
		return '<div class="row circular-bars clearfix text-center" ' . $style . '>' . do_shortcode( $content ) . '</div>';
	}
	
	public static function vc_bars() {
		vc_map( array(
		   	"name" => esc_html__( "Circular Bars", "royal" ),
		   	"base" => "bars",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "bar"
   			),
			"show_settings_on_create" => false,
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Circular bar ([bar])
	public static function bar( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'column' => '1/6',
			'value'  => 75,
			'class'  => ''
		), $atts ) );

		return '<div class="col-xs-6 col-sm-4 col-md-' . self::getColumnsNumber( $column ) . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . ' text-center"><input data-value="' . intval( $value ) . '" disabled><div class="h5">' . esc_html( $title ) . '</div></div>';
	}
	
	public static function vc_bar() {
		vc_map( array(
		   	"name" => esc_html__( "Circular Bar", "royal" ),
		   	"base" => "bar",
		   	"icon" => 'icon-vc',
			"as_child" => array(
            	"only" => "bars"
   			),
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2" => '1/2',
						"1/3" => '1/3',
						"1/4" => '1/4',
						"1/5" => '1/5',
						"1/6" => '1/6'
					),
					"std" => "1/5",
				 	"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Value", "royal" ),
					"param_name"  => "value",
					"value"       => "75",
					"description" => "Number between 0 and 100",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Progress bar ([progress])
	public static function progress( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'value'  => 75
		), $atts ) );

		return '<div class="bar"><div class="progress-heading"><h5 class="progress-title">' . esc_html( $title ) . '</h5><div class="progress-value"></div></div><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="' . intval( $value ) . '" aria-valuemin="0" aria-valuemax="100"></div></div></div>';
	}
	
	public static function vc_progress() {
		vc_map( array(
		   	"name" => esc_html__( "Progress Bar", "royal" ),
		   	"base" => "progress",
		   	"icon" => 'icon-vc',
			"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Value", "royal" ),
					"param_name"  => "value",
					"value"       => "75",
					"description" => esc_html__( "Number between 0 and 100", "royal" ),
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Milestone counters ([milestone])
	public static function milestone( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );

		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';	
		
		return '<div class="row" ' . $style . '>' . do_shortcode( $content ) . '</div>';
	}
	
	public static function vc_milestone() {
		vc_map( array(
		   	"name" => esc_html__( "Milestone Counters", "royal" ),
		   	"base" => "milestone",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "counter"
   			),
			"show_settings_on_create" => false,
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Milestone counter ([counter])
	public static function counter( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'icon'   => '',
			'from'   => '1',
			'to'     => '100',
			'column' => '1/4',
			'color'  => '',
			'class'  => '',
		), $atts ) );

		return '<div class="col-md-' . self::getColumnsNumber( $column ) . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . '"><p class="text-center"><i class="' . esc_html( $icon ). ' fa-3x fw"' . ( ! empty( $color ) ? ' style="color: ' . esc_attr( $color ) . ';"' : '' ) . '></i></p><div class="milestone"><div class="counter" data-from="' . intval( $from ) . '" data-to="' . intval( $to ) . '">' . $to . '</div><div class="description">' . esc_html( $title ) . '</div></div></div>';
	}
	
	public static function vc_counter() {
		vc_map( array(
		   	"name" => esc_html__( "Milestone Counter", "royal" ),
		   	"base" => "counter",
		   	"icon" => 'icon-vc',
			"as_child" => array(
            	"only" => "milestone"
   			),
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon library", "royal" ),
					"value" => array(
					  esc_html__( "Font Awesome", "royal" ) => "fontawesome",
					),
					"admin_label" => false,
					"param_name" => "type",
					"description" => "",
				),
				array(
					"type" => "iconpicker",
					"heading" => esc_html__( "Icon", "royal" ),
					"param_name" => "icon",
					"value" => "",
					"settings" => array(
					  "emptyIcon" => true,
					  "iconsPerPage" => 4000,
					),
					"dependency" => array(
					  "element" => "type",
					  "value" => "fontawesome",
					),
				),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "From", "royal" ),
					"param_name"  => "from",
					"value"       => "1",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "To", "royal" ),
					"param_name"  => "to",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2" => '1/2',
						"1/3" => '1/3',
						"1/4" => '1/4',
						"1/6" => '1/6'
					),
					"std" => "1/4",
				 	"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "colorpicker",
					"heading"     => esc_html__( "Color", "royal" ),
					"param_name"  => "color",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Highlight ([highlight])
	public static function highlight( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style'  => '',
		), $atts ) );

		return '<span class="highlight' . ( $style == 'dark' ? '-dark' : '' ) . '">' . do_shortcode( $content ) . '</span>';
	}
	
	public static function vc_highlight() {
		vc_map( array(
		   	"name" => esc_html__( "Highlight", "royal" ),
		   	"base" => "highlight",
		   	"icon" => 'icon-vc',
			"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Style", "royal" ),
				 	"param_name" => "style",
				 	"value" => array(   
						esc_html__('Normal', 'royal') => 'normal',
						esc_html__('Dark', 'royal') => 'dark'
					),
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}

	// Quote ([quote])
	public static function quote( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'information'  => '',
		), $atts ) );

		return '<blockquote><p>' . do_shortcode( $content ) . '</p>' . ( ! empty( $information ) ? '<footer>' . esc_html( $information ) . '</footer>' : '' ) . '</blockquote>';
	}
	
	public static function vc_quote() {
		vc_map( array(
		   	"name" => esc_html__( "Quote", "royal" ),
		   	"base" => "quote",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Author", "royal" ),
					"param_name"  => "information",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Info box (Section) ([info_box])
	public static function infoBox( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'url' => '',
			'btn' => '',
			'class' => ''
		), $atts ) );
		
		$url = vc_build_link( $url );

		if ( ! empty( $btn ) && strlen( $url['url'] ) > 0 ) {
			$btn = '<a href="' . esc_attr( $url['url'] ) . '" class="btn btn-default">' . esc_html( $btn ) . '</a>';
		}

		return '<div class="info-box row' . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . '">
					<div class="' . ( ! empty( $btn ) ? 'col-lg-6 col-md-6 col-sm-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 text-center-xs' : 'col-md-12' ) . '">' . do_shortcode( $content ) . '</div>
					' . ( ! empty( $btn ) ? '<div class="col-lg-3 col-md-4 col-sm-4 pull-right text-center-xs">'. $btn . '</div>' : '' ) . '
				</div>';
	}
	
	public static function vc_infoBox() {
		vc_map( array(
		   	"name" => esc_html__( "Info Box", "royal" ),
		   	"base" => "info_box",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					'type' => 'vc_link',
					'heading' => esc_html__( "Button URL", "royal" ),
					'param_name' => 'url',
					'description' => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Button Label", "royal" ),
					"param_name"  => "btn",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Our team ([our_team])
	public static function ourTeam( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'column' => '1/3',
			'limit'  => 3,
			'class'  => 'col-sm-4 col-xs-6'
		), $atts ) );

		$limit = intval( $limit );
		$query = array(
			'post_type' 		=> 'our-team',
			'suppress_filters' 	=> 0,
			'numberposts' 		=> $limit
		);
		$rows = get_posts( $query );
		$output = '';

		if ( count( $rows ) > 0 ) {
			$output .= '<div class="row team">';

			foreach ( $rows as $row ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $row->ID ), 'full' );
				$title = apply_filters( 'the_title', $row->post_title );

				$social = '';
				$meta = get_post_meta( $row->ID );

				if ( ! empty( $meta['twitter'][0] ) ) $social .= '<a href="' . esc_url( $meta['twitter'][0] ) . '" title="Twitter"><i class="fa fa-twitter"></i></a>';
				if ( ! empty( $meta['facebook'][0] ) ) $social .= '<a href="' . esc_url( $meta['facebook'][0] ) . '" title="Facebook"><i class="fa fa-facebook"></i></a>';
				if ( ! empty( $meta['linkedin'][0] ) ) $social .= '<a href="' . esc_url( $meta['linkedin'][0] ) . '" title="LinkedIn"><i class="fa fa-linkedin"></i></a>';
				if ( ! empty( $meta['instagram'][0] ) ) $social .= '<a href="' . esc_url( $meta['instagram'][0] ) . '" title="Instagram"><i class="fa fa-instagram"></i></a>';
				if ( ! empty( $meta['dribbble'][0] ) ) $social .= '<a href="' . esc_url( $meta['dribbble'][0] ) . '" title="Dribbble"><i class="fa fa-dribbble"></i></a>';

				$output .= '
					<div class="offsetBottomL col-md-' . self::getColumnsNumber( $column ) . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . '">
						<div class="photo">
							<img src="' . $thumb[0] . '" class="img-responsive img-rounded" alt="' . esc_attr( $title ) . '">
						</div>
						<div class="details">
							<h4 class="text-semibold">' . esc_html( $title ) . '</h4>
							<span>' . $meta['activity'][0] . '</span>
						</div>' . 
						( ! empty( $social ) ? '<div class="social">' . $social . '</div>' : '' ) . '
					</div>';
			}

			$output .= '</div>';
		}
		return $output;
	}
	
	public static function vc_ourTeam() {
		vc_map( array(
		   	"name" => esc_html__( "Our Team", "royal" ),
		   	"base" => "our_team",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2" => '1/2',
						"1/3" => '1/3',
						"1/4" => '1/4',
						"1/6" => '1/6'
					),
					"std" => "1/3",
				 	"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Limit", "royal" ),
					"param_name"  => "limit",
					"value"       => "3",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "col-sm-4 col-xs-6",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Services ([services])
	public static function services( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );

		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';	
		
		return '<div class="row services" ' . $style . '>' . do_shortcode( $content ) . '</div>';
	}
	
	public static function vc_services() {
		vc_map( array(
		   	"name" => esc_html__( "Services", "royal" ),
		   	"base" => "services",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "service"
   			),
			"show_settings_on_create" => false,
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}

	// Service ([service])
	public static function service( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'         => '',
			'column'        => '1/3',
			'icon'          => '',
			'color'         => '',
			'class'         => '',
			'sticker'       => '',
			'sticker_color' => '',
		), $atts ) );

		return '
		<div class="text-center col-sm-4 col-xs-12 col-md-' . self::getColumnsNumber( $column ) . ( ! empty( $class ) ? ' ' . esc_attr( $class ) : '' ) . '">
			<div><i class="fa ' . esc_html( $icon ) . ( ! empty( $sticker ) ? ' sticker-icon' : '' ) . '"' . ( ! empty( $color ) ? ' style="color: ' . esc_attr( $color ) . ';"' : '' ) . '>' . ( ! empty( $sticker ) ? ' ' . self::sticker( array( 'label' => $sticker, 'color' => $sticker_color ) ) : '' ) . '</i></div>
			<header><h4>' . esc_html( $title ) . '</h4></header><p>' . do_shortcode( $content ) . '</p><div class="clear offsetTopS visible-xs-block"></div></div>';
	}
	
	public static function vc_service() {
		vc_map( array(
		   	"name" => esc_html__( "Service", "royal" ),
		   	"base" => "service",
		   	"icon" => 'icon-vc',
			"as_child" => array(
            	"only" => "services"
   			),
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon library", "royal" ),
					"value" => array(
					  esc_html__( "Font Awesome", "royal" ) => "fontawesome",
					),
					"admin_label" => false,
					"param_name" => "type",
					"description" => "",
				),
				array(
					"type" => "iconpicker",
					"heading" => esc_html__( "Icon", "royal" ),
					"param_name" => "icon",
					"value" => "",
					"settings" => array(
					  "emptyIcon" => true,
					  "iconsPerPage" => 4000,
					),
					"dependency" => array(
					  "element" => "type",
					  "value" => "fontawesome",
					),
				),
				array(
					"type"        => "colorpicker",
					"heading"     => esc_html__( "Icon Color", "royal" ),
					"param_name"  => "color",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2" => '1/2',
						"1/3" => '1/3',
						"1/4" => '1/4',
						"1/6" => '1/6'
					),
					"std" => "1/3",
				 	"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Sticker Text", "royal" ),
					"param_name"  => "sticker",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "colorpicker",
					"heading"     => esc_html__( "Sticker Color", "royal" ),
					"param_name"  => "sticker_color",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Portfolio ([portfolio])
	public static function portfolio( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'order'              => 'menu_order',
			'filters'            => 'true',
			'limit'              => -1,
			'terms'              => '',
            'size_large'         => 5,
            'size_medium'        => 5,
            'size_small'         => 4,
            'size_extra_small'   => 2
		), $atts ) );

		$filters_html = '';
		$limit = intval( $limit );

		if ( $filters == 'true' ) {
			$categories = get_terms( 'portfolio-category', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 1 ) );
			$filters_html = '<a href="#" data-filter="*" class="active">' . esc_html__( 'All', 'royal' ) . '</a>';

			if ( count( $categories ) > 0 ) {
				foreach ( $categories as $row ) {
					$filters_html .= '<a href="#" data-filter=".filter-' . esc_attr( $row->slug ) . '">' . esc_html( $row->name ) . '</a>';
				}
			}
		}

		$query = array(
			'post_type'   		=> 'portfolio',
			'suppress_filters' 	=> 0,
			'numberposts' 		=> $limit,
			'order'       		=> ( ( $order == 'date' or $order == 'modified' or $order == 'rand' ) ? 'DESC' : 'ASC' ),
			'orderby'    		=> $order
		);

		if ( ! empty( $terms ) ) {
			$terms_arr = explode( ',', $terms );
			$terms_query = array( );

			if ( is_array( $terms_arr ) and count( $terms_arr ) > 0 ) {
				foreach ( $terms_arr as $term ) {
					$terms_query[] = trim( esc_sql( $term ) );
				}

				$query['tax_query'] = array(
					array(
						'taxonomy' => 'portfolio-category',
						'field'    => 'slug',
						'terms'    => $terms_query
					)
				);
			}
		}

		$rows = get_posts( $query );
		$output = $projects = '';

		if ( count( $rows ) > 0 ) {
			foreach ( $rows as $row ) {
				$info = wp_get_object_terms( $row->ID, 'portfolio-category' );
				$category = array( );
				$filter = '';

				foreach( $info as $item ) {
					$category[] = $item->name;
					$filter .= 'filter-' . $item->slug . ' ';
				}

				$category = implode( ', ', $category );
				$filter = rtrim( $filter );
				unset( $info );

				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $row->ID ), 'full' );
				$title = apply_filters( 'the_title', $row->post_title );
				$link = get_permalink( $row->ID );

				if ( get_option( 'show_on_front', 'posts' ) == 'page' and get_option( 'page_on_front', 0 ) > 0 and RoyalTheme::isFrontPage( get_the_ID( ) ) ) {
					$href = site_url( '#view-' . $row->post_name );
				} else {
					$href = $link;
				}

				$projects .= '
				<div>
					<div class="portfolio-item' . ( ! empty( $filter ) ? ' ' . esc_attr( $filter ) : '' ) . '" rel="' . esc_attr( $row->post_name ) . '">
						<img src="' . $thumb[0] . '" alt="' . esc_attr( $title ) . '">
						<div class="overlay"></div>
						<div class="details">' . esc_html( $title ) . '</div>
						<div class="href">
							<a href="' . esc_url( $href ) . '" data-url="' . esc_url( $link ) . '"></a>
						</div>
					</div>
				</div>';
			}

			if ( $filters == 'true' and ! empty( $filters_html ) ) {
				$output = '<div class="row text-center offsetTop"><div class="col-md-12 portfolio-filters">' . $filters_html . '</div></div>';
			}

			$output .= '</div></div></div></div></div><div class="container-fluid offsetTop' . ( ( $filters == 'true' and ! empty( $filters_html ) ) ? '' : 'S' ) . '"><div class="row portfolio-items clearfix" data-on-line-lg="' . $size_large . '" data-on-line-md="' . $size_medium . '" data-on-line-sm="' . $size_small . '" data-on-line-xs="' . $size_extra_small . '">' . $projects . '</div>';
		}

		return $output;
	}
	
	public static function vc_portfolio() {
		vc_map( array(
		   	"name" => esc_html__( "Portfolio", "royal" ),
		   	"base" => "portfolio",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
                    "group"       => "General",
				 	"type"        => "dropdown",
				 	"holder"      => "div",
				 	"class"       => "",
				 	"heading"     => esc_html__( "Order By", "royal" ),
				 	"param_name"  => "order",
				 	"value"       => array(
						"Default"     => 'menu_order',
						"ID"          => 'id',
						"Title"       => 'title',
						"Date"        => 'date',
						"Modified"    => 'modified',
						"Random"      => 'rand'
					),
					"std"         => "menu_order",
				 	"description" => "",
					"admin_label" => true,
			  	),
				array(
                    "group"       => "General",
					"type"        => "checkbox",
					"heading"     => esc_html__( "Filters", "royal" ),
					"param_name"  => "filters",
					"value"       => "",
					"std"         => "true",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
                    "group"       => "General",
					"type"        => "textfield",
					"heading"     => esc_html__( "Limit", "royal" ),
					"param_name"  => "limit",
					"value"       => "-1",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
                    "group"       => "General",
					"type"        => "textfield",
					"heading"     => esc_html__( "Terms", "royal" ),
					"param_name"  => "terms",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
                array(
                    "group"       => "Column Size",
					"type"        => "textfield",
					"heading"     => esc_html__( "Desktop", "royal" ),
					"param_name"  => "size_large",
					"value"       => "5",
					"description" => "",
					"admin_label" => true,
			  	),
                array(
                    "group"       => "Column Size",
					"type"        => "textfield",
					"heading"     => esc_html__( "Laptop", "royal" ),
					"param_name"  => "size_medium",
					"value"       => "5",
					"description" => "",
					"admin_label" => true,
			  	),
                array(
                    "group"       => "Column Size",
					"type"        => "textfield",
					"heading"     => esc_html__( "Tablet", "royal" ),
					"param_name"  => "size_small",
					"value"       => "4",
					"description" => "",
					"admin_label" => true,
			  	),
                array(
                    "group"       => "Column Size",
					"type"        => "textfield",
					"heading"     => esc_html__( "Phone", "royal" ),
					"param_name"  => "size_extra_small",
					"value"       => "2",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Blog posts ([blog])
	public static function blog( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'column' => '1/4',
			'limit'  => '3'
		), $atts ) );

		if ( $column == '1/2' ) {
			$count_string = 'two';
		} else if ( $column == '1/3' ) {
			$count_string = 'four';
		} else {
			$count_string = 'three';
		}

		$output = '';

		$query = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => intval( $limit )
		) );

		if ( $query->have_posts( ) ) {
			while ( $query->have_posts( ) ) {
				$query->the_post( );

				$post_title = get_the_title( );
				$attr_title = the_title_attribute( array( 'before' => '', 'after' => '', 'echo' => false ) );

				$format = get_post_format( get_the_ID( ) );
				$format_css = 'responsive-images';

				if ( $format == 'status' ) {
					$format_css = 'format-holder status';
				} else if ( $format == 'link' ) {
					$format_css = 'format-holder link';
				} else if ( $format == 'aside' ) {
					$format_css = 'format-holder aside';
				}

				if ( $format != 'gallery' ) {
					$post_content = apply_filters( 'the_content', wpautop( get_the_content( esc_html__( 'Read More', 'royal' ) ) ) );
				} else {
					$post_content = RoyalTheme::postGallery( esc_html__( 'Read More', 'royal' ), false );
				}

				$output .= '
				<article id="post-' . esc_attr( get_the_ID( ) ) . '" class="' . esc_attr( implode( ' ', get_post_class( 'blog-post masonry offsetTopS offsetBottom', get_the_ID( ) ) ) ) . '">
					<header>
						' . ( ! empty( $post_title ) ? '<h3><a href="' . esc_url( get_the_permalink( ) ) . '" title="' . $attr_title . '">' . esc_html( $post_title ) . '</a></h3>' : '' ) . '
						<div class="info">
							' . RoyalTheme::postCategories( get_the_ID( ), '<span>', '</span>', false ) . '
						</div>
					</header>
					<div class="responsive-images">
						' . $post_content . '
					</div>
				</article>';
			}
		} else {
			wp_reset_postdata( );

			return '';
		}

		wp_reset_postdata( );

		return '<div class="row"><div class="col-md-12 col-sm-12 blog-masonry blog-masonry-' . esc_attr( $count_string ) . '">' . $output . '</div></div>';
	}
	
	public static function vc_blog() {
		vc_map( array(
		   	"name" => esc_html__( "Blog Posts", "royal" ),
		   	"base" => "blog",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2" => '1/2',
						"1/3" => '1/3',
						"1/4" => '1/4'
					),
					"std" => "1/4",
				 	"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Limit", "royal" ),
					"param_name"  => "limit",
					"value"       => "3",
					"description" => "",
					"admin_label" => true,
			  	),			  	
			)
		));
	}
	
	// Accordion ([accordions])
	public static function accordions( $atts, $content = null ) {
		self::$accordionsCounters = ( self::$accordionsCounters > 0 ) ? ( int ) self::$accordionsCounters : 0;
		self::$accordionsCounters ++;

		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );

		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';		
		
		$content = do_shortcode( $content );
		
		return '<div class="panel-group" id="accordion' . self::$accordionsCounters . '" ' . $style . '>' . $content . '</div>';
	}
	
	public static function vc_accordions() {
		vc_map( array(
		   	"name" => esc_html__( "Accordion", "royal" ),
		   	"base" => "accordions",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "accordion"
   			),
			"show_settings_on_create" => false,
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}

	// Accordion tab ([accordion])
	public static function accordion( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'opened' => 'no',
		), $atts ) );

		self::$accordionCounters = ( self::$accordionCounters > 0 ) ? ( int ) self::$accordionCounters : 0;
		self::$accordionCounters ++;
		
		$opened = $opened == 'true' ? 'yes' : 'no';

		return '
		<div class="panel panel-default">
			<div class="panel-heading"><h5 class="panel-title"><a href="#collapse' . self::$accordionCounters . '" data-toggle="collapse" data-parent="#accordion' . self::$accordionsCounters . '">' . esc_html( $title ) . '</a></h5></div>
			<div id="collapse' . self::$accordionCounters . '" class="panel-collapse collapse' . ( $opened == 'yes' ? ' in' : '' ) . '"><div class="panel-body"><p>' . do_shortcode( $content ) . '</p></div></div></div>';
	}
	
	public static function vc_accordion() {
		vc_map( array(
		   	"name" => esc_html__( "Accordion Tab", "royal" ),
		   	"base" => "accordion",
		   	"icon" => 'icon-vc',
			"as_child" => array(
            	"only" => "accordions"
   			),
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "checkbox",
					"heading"     => esc_html__( "Opened", "royal" ),
					"param_name"  => "opened",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),		  	
			)
		));
	}
	
	// Pricing tables ([pricing_table])
	public static function pricingTable( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'column' => '1/3'
		), $atts ) );

		self::$pricingTableColumns = self::getColumnsNumber( $column );

		return '<div class="row pricing-tables">' . do_shortcode( $content ) . '</div>';
	}
	
	public static function vc_pricingTable() {
		vc_map( array(
		   	"name" => esc_html__( "Pricing Tables", "royal" ),
		   	"base" => "pricing_table",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "plan"
   			),
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Column", "royal" ),
				 	"param_name" => "column",
				 	"value" => array(   
						"1/2 - Two Plans" => '1/2',
						"1/3 - Three Plans" => '1/3',
						"1/4 - Four Plans" => '1/4'
					),
					"std" => "1/3",
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}

	// Pricing table plan ([plan])
	public static function plan( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'         => '',
			'price'         => '',
			'button'        => '',
			'url'           => '',
			'sticker'       => '',
			'sticker_color' => '',
		), $atts ) );
		
		$url = vc_build_link( $url );
		$target = strlen( $url['target'] ) > 0 ? $url['target'] : '';
		$url = strlen( $url['url'] ) > 0 ? $url['url'] : '';

		return '
		<div class="col-md-' . self::$pricingTableColumns . ' col-sm-' . self::$pricingTableColumns . '">
			<div class="plan">
				<header>
					<h3>' . esc_html( $title ) . ( ! empty( $sticker ) ? ' ' . self::sticker( array( 'label' => $sticker, 'color' => $sticker_color ) ) : '' ) . '</h3>
					<span class="info">' . esc_html( $price ) . '</span>
				</header>
				' . do_shortcode( $content ) . '
				<a href="' . esc_url( $url ) . '" '. ( $target != '_self' ? ' target="' . esc_attr( $target ) : '' ) .' class="btn btn-default">' . esc_html( $button ) . '</a>
			</div>
		</div>';
	}
	
	public static function vc_plan() {
		vc_map( array(
		   	"name" => esc_html__( "Plan", "royal" ),
		   	"base" => "plan",
		   	"icon" => 'icon-vc',
			"as_child" => array(
            	"only" => "pricing_table"
   			),
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Price", "royal" ),
					"param_name"  => "price",
					"value"       => "",
					"description" => "Example: 0$/month",
					"admin_label" => true,
			  	), 
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Button", "royal" ),
					"param_name"  => "button",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	), 
				array(
					'type' => 'vc_link',
					'heading' => __( "Button URL", "royal" ),
					'param_name' => 'url',
					'description' => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Sticker Text", "royal" ),
					"param_name"  => "sticker",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Color", "royal" ),
				 	"param_name" => "sticker_color",
				 	"value" => array(
						esc_html__( "Default", "royal" ) => '',
						esc_html__( "Red", "royal" ) => 'red',
						esc_html__( "Orange", "royal" ) => 'orange',
						esc_html__( "Green", "royal" ) => 'green',
						esc_html__( "Blue", "royal" ) => 'blue'
					),
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Tabs ([tabs])
	public static function tabs( $atts, $content = null ) {
		self::$tabsTitles = array( );
		self::$tabsActive = true;

		extract( shortcode_atts( array(
			'mt' => '0px',
			'mb' => '0px',
		), $atts ) );
		
		$mt = intval( $mt );
		$mb = intval( $mb );

		$style = ( $mt > 0 || $mb > 0 ) ? 'style="margin-top: ' . $mt . 'px; margin-bottom: ' . $mb . 'px;"' : '';		
		
		$content = do_shortcode( $content );
		
		$output = '<ul class="nav nav-tabs" ' . $style . '>';

		if ( count( self::$tabsTitles ) > 0 ) {
			$i = 0;
			
			foreach ( self::$tabsTitles as $id => $title ) {
				$output .= '<li' . ( $i == 0 ? ' class="active"' : '' ) . '><a href="#tab' . esc_attr( $id ) . '" data-toggle="tab">' . $title . '</a></li>';
				$i ++;
			}
		}

		$output .= '</ul><div class="tab-content">' . $content . '</div>';

		return $output;
	}
	
	public static function vc_tabs() {
		vc_map( array(
		   	"name" => esc_html__( "Tabs", "royal" ),
		   	"base" => "tabs",
		   	"icon" => 'icon-vc',
			"as_parent" => array(
            	"only" => "tab"
   			),
			"show_settings_on_create" => false,
			"js_view" => "VcColumnView",
			"category" => esc_html__( "Royal Elements", "royal" ),
			"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Top", "royal" ),
					"param_name"  => "mt",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Margin Bottom", "royal" ),
					"param_name"  => "mb",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Tab ([tab])
	public static function tab( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => ''
		), $atts ) );

		self::$tabsCounters = ( self::$tabsCounters > 0 ) ? ( int ) self::$tabsCounters : 0;
		self::$tabsCounters ++;

		self::$tabsTitles[self::$tabsCounters] = $title;

		$output = '<div class="tab-pane' . ( self::$tabsActive === true ? ' active' : '' ) . '" id="tab' . self::$tabsCounters . '"><p>' . do_shortcode( $content ) . '</p></div>';

		self::$tabsActive = false;

		return $output;
	}
	
	public static function vc_tab() {
		vc_map( array(
		   	"name" => esc_html__( "Tab", "royal" ),
		   	"base" => "tab",
		   	"icon" => 'icon-vc',
			"as_child" => array(
            	"only" => "tabs"
   			),
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Promotion boxes ([promotion])
	public static function promotion( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'style'  => 'one'
		), $atts ) );

		if ( $style == 'two' ) $classes = ' line-top';
		else if ( $style == 'three' ) $classes = ' line-top line-grey';
		else $classes = '';

		return '<div class="promotion-box' . esc_attr( $classes ) . '"><h4>' . esc_html( $title ) . '</h4><p>' . do_shortcode( $content ) . '</p></div>';
	}
	
	public static function vc_promotion() {
		vc_map( array(
		   	"name" => esc_html__( "Promotion Box", "royal" ),
		   	"base" => "promotion",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Style", "royal" ),
				 	"param_name" => "style",
				 	"value" => array(   
						"One" => 'one',
						"Two" => 'two',
						"Three" => 'three'
					),
					"std" => "info",
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Alert ([alert])
	public static function alert( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'  => '',
			'type'  => 'info'
		), $atts ) );

		if ( $type != 'success' and $type != 'info' and $type != 'warning' and $type != 'danger' ) {
			$type = 'info';
		}

		return '<div class="alert alert-' . $type . '"><h4>' . esc_html( $title ) . '</h4><p>' . do_shortcode( $content ) . '</p></div>';
	}
	
	public static function vc_alert() {
		vc_map( array(
		   	"name" => esc_html__( "Alert", "royal" ),
		   	"base" => "alert",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Title", "royal" ),
					"param_name"  => "title",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Type", "royal" ),
				 	"param_name" => "type",
				 	"value" => array(   
						esc_html__( "Information", "royal" ) => 'info',
						esc_html__( "Success", "royal" ) => 'success',
						esc_html__( "Warning", "royal" ) => 'warning',
						esc_html__( "Danger", "royal" ) => 'danger'
					),
					"std" => "info",
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Stickers ([sticker])
	public static function sticker( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'label'  => '',
			'color'  => '',
			'icon'   => '',
		), $atts ) );

		if ( $color != 'green' and $color != 'blue' and $color != 'orange' and $color != 'red' ) {
			$color = '';
		}

		return ( ! empty( $icon ) ? '<i class="' . esc_attr( $icon ) . ' sticker-icon">' : '' ) . '<span class="sticker' . ( ! empty( $color ) ? ' ' . esc_attr( $color ) : '' ) . '">' . esc_html( $label ) . '</span>' . ( ! empty( $icon ) ? '</i>' : '' );
	}
	
	public static function vc_sticker() {
		vc_map( array(
		   	"name" => esc_html__( "Sticker", "royal" ),
		   	"base" => "sticker",
		   	"icon" => 'icon-vc',
			"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Label", "royal" ),
					"param_name"  => "label",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Color", "royal" ),
				 	"param_name" => "color",
				 	"value" => array(
						esc_html__( "Default", "royal" ) => '',
						esc_html__( "Red", "royal" ) => 'red',
						esc_html__( "Orange", "royal" ) => 'orange',
						esc_html__( "Green", "royal" ) => 'green',
						esc_html__( "Blue", "royal" ) => 'blue'
					),
				 	"description" => "",
					"admin_label" => true,
			  	),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon library", "royal" ),
					"value" => array(
					  esc_html__( "Font Awesome", "royal" ) => "fontawesome",
					),
					"admin_label" => false,
					"param_name" => "type",
					"description" => "",
				),
				array(
					"type" => "iconpicker",
					"heading" => esc_html__( "Icon Button", "royal" ),
					"param_name" => "icon",
					"value" => "",
					"settings" => array(
					  "emptyIcon" => true,
					  "iconsPerPage" => 4000,
					),
					"dependency" => array(
					  "element" => "type",
					  "value" => "fontawesome",
					),
				),
	  
			)
		));
	}
	
	// Dropcap ([dropcap])
	public static function dropcap( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'letter'  => '',
			'style'   => ''
		), $atts ) );

		return '<span class="dropcap' . ( $style == 'alt' ? ' alt' : '' ) . '">' . esc_html( $letter ) . '</span>';
	}
	
	public static function vc_dropcap() {
		vc_map( array(
		   	"name" => esc_html__( "Dropcap", "royal" ),
		   	"base" => "dropcap",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Letter", "royal" ),
					"param_name"  => "letter",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
				 	"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Style", "royal" ),
				 	"param_name" => "style",
				 	"value" => array(   
						esc_html__( "Default", "royal" ) => '',
						esc_html__( "Alternative", "royal" ) => 'alt'
					),
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Portfolio project details + share ([details])
	public static function details( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'share' => 'yes'
		), $atts ) );

		$panel = '
		<div class="share-panel">
			<span>' . esc_html__( 'Share', 'royal' ) . '</span>
			<div class="social">
				<a title="Twitter" onclick="shareTo( \'twitter\', \'#share-title\', \'#share-image\', \'#view-\' + jQuery( \'#portfolio-details\' ).attr( \'data-current\' ) )"><i class="fa fa-twitter"></i></a>
				<a title="Facebook" onclick="shareTo( \'facebook\', \'#share-title\', \'#share-image\', \'#view-\' + jQuery( \'#portfolio-details\' ).attr( \'data-current\' ) )"><i class="fa fa-facebook"></i></a>
				<a title="Pinterest" onclick="shareTo( \'pinterest\', \'#share-title\', \'#share-image\', \'#view-\' + jQuery( \'#portfolio-details\' ).attr( \'data-current\' ) )"><i class="fa fa-pinterest"></i></a>
				<a title="LinkedIn" onclick="shareTo( \'linkedin\', \'#share-title\', \'#share-image\', \'#view-\' + jQuery( \'#portfolio-details\' ).attr( \'data-current\' ) )"><i class="fa fa-linkedin"></i></a>
			</div>
		</div>';

		$content = preg_replace( '/<ul/', '<ul class="fa-ul details"', $content );
		$content = preg_replace( '/<li>/', '<li><i class="fa-li fa fa-angle-right colored"></i> ', $content );

		return do_shortcode( $content ) . ( $share == 'yes' ? $panel : '' );
	}
	
	public static function vc_details() {
		vc_map( array(
		   	"name" => esc_html__( "Project Details", "royal" ),
		   	"base" => "details",
		   	"icon" => 'icon-vc',
			"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textarea_html",
					"heading"     => esc_html__( "Text", "royal" ),
					"param_name"  => "content",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
				 	"holder" => "div",
				 	"class" => "",
				 	"heading" => esc_html__( "Share", "royal" ),
				 	"param_name" => "style",
				 	"value" => array(   
						esc_html__( "Yes", "royal" ) => 'yes',
						esc_html__( "No", "royal" ) => 'no'
					),
					"std" => "yes",
				 	"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Slider ([slider])
	public static function slider( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'slide' => '',
			'class'  => ''
		), $atts ) );
		
		$output = '<div class="image-slider' . ( ! empty( $class ) ? ' ' . trim( esc_attr( $class ) ) : '' ) . '">';

		$ids = explode(',', $slide);

		foreach ( $ids as $id ) {
			$output .= '<div><img src="' . wp_get_attachment_url( $id ) . '" class="img-responsive img-rounded" alt=""></div>';
		}

		$output .= '<div class="arrows"><a class="arrow left"><i class="fa fa-chevron-left"></i></a><a class="arrow right"><i class="fa fa-chevron-right"></i></a></div></div>';
		
		return $output;
	}
	
	public static function vc_slider() {
		vc_map( array(
		   	"name" => esc_html__( "Image Slider", "royal" ),
		   	"base" => "slider",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "attach_images",
					"heading"     => esc_html__( "Images", "royal" ),
					"param_name"  => "slide",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
	// Clear ([clear])
	public static function clear( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'gap'	 => '0px',
			'class'  => ''
		), $atts ) );

		$gap = intval( $gap );
		$before = $attributes = '';

		if ( self::$columnsCount > 0 ) {
			self::$columnsCount = self::$columnsOffset = 0;
			$before = '</div>';
		}
		
		$gap = intval( $gap );

		if ( $gap > 0 ) {
			if      ( $gap == 20 )  $class .= ' offsetTopS';
			else if ( $gap == 60 )  $class .= ' offsetTop';
			else if ( $gap == 80 )  $class .= ' offsetTopL';
			else if ( $gap == 120 ) $class .= ' offsetTopX';
			else {
				$attributes = ' style="padding-top: ' . intval( $gap ) . 'px;"';
			}
		}

		return $before . '<div class="clear' . ( ! empty( $class ) ? ' ' . trim( esc_attr( $class ) ) : '' ) . '"' . $attributes . '></div>';
	}
	
	public static function vc_clear() {
		vc_map( array(
		   	"name" => esc_html__( "Clear", "royal" ),
		   	"base" => "clear",
		   	"icon" => 'icon-vc',
		   	"category" => esc_html__( "Royal Elements", "royal" ),
		   	"params" => array(
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Gap", "royal" ),
					"param_name"  => "gap",
					"value"       => "0px",
					"description" => "",
					"admin_label" => true,
			  	),
			  	array(
					"type"        => "textfield",
					"heading"     => esc_html__( "CSS Class", "royal" ),
					"param_name"  => "class",
					"value"       => "",
					"description" => "",
					"admin_label" => true,
			  	),
			)
		));
	}
	
}

// Register shortcodes
add_shortcode( 'section_title', array( 'RoyalShortcodes', 'sectionTitle' ) );
add_shortcode( 'button', 		array( 'RoyalShortcodes', 'button' ) );
add_shortcode( 'video', 		array( 'RoyalShortcodes', 'video' ) );
add_shortcode( 'accordions', 	array( 'RoyalShortcodes', 'accordions' ) );
add_shortcode( 'accordion', 	array( 'RoyalShortcodes', 'accordion' ) );
add_shortcode( 'tabs', 			array( 'RoyalShortcodes', 'tabs' ) );
add_shortcode( 'tab', 			array( 'RoyalShortcodes', 'tab' ) );
add_shortcode( 'promotion', 	array( 'RoyalShortcodes', 'promotion' ) );
add_shortcode( 'alert', 		array( 'RoyalShortcodes', 'alert' ) );
add_shortcode( 'progress', 		array( 'RoyalShortcodes', 'progress' ) );
add_shortcode( 'bars', 			array( 'RoyalShortcodes', 'bars' ) );
add_shortcode( 'bar', 			array( 'RoyalShortcodes', 'bar' ) );
add_shortcode( 'milestone', 	array( 'RoyalShortcodes', 'milestone' ) );
add_shortcode( 'counter', 		array( 'RoyalShortcodes', 'counter' ) );
add_shortcode( 'highlight', 	array( 'RoyalShortcodes', 'highlight' ) );
add_shortcode( 'quote', 		array( 'RoyalShortcodes', 'quote' ) );
add_shortcode( 'sticker', 		array( 'RoyalShortcodes', 'sticker' ) );
add_shortcode( 'dropcap', 		array( 'RoyalShortcodes', 'dropcap' ) );
add_shortcode( 'pricing_table', array( 'RoyalShortcodes', 'pricingTable' ) );
add_shortcode( 'plan', 			array( 'RoyalShortcodes', 'plan' ) );
add_shortcode( 'map', 			array( 'RoyalShortcodes', 'map' ) );
add_shortcode( 'google_map', 	array( 'RoyalShortcodes', 'googleMap' ) );
add_shortcode( 'contact_form', 	array( 'RoyalShortcodes', 'contactForm' ) );
add_shortcode( 'info_box', 		array( 'RoyalShortcodes', 'infoBox' ) );
add_shortcode( 'our_clients', 	array( 'RoyalShortcodes', 'ourClients' ) );
add_shortcode( 'our_team', 		array( 'RoyalShortcodes', 'ourTeam' ) );
add_shortcode( 'services', 		array( 'RoyalShortcodes', 'services' ) );
add_shortcode( 'service', 		array( 'RoyalShortcodes', 'service' ) );
add_shortcode( 'portfolio', 	array( 'RoyalShortcodes', 'portfolio' ) );
add_shortcode( 'twitter_feed', 	array( 'RoyalShortcodes', 'twitter' ) );
add_shortcode( 'details', 		array( 'RoyalShortcodes', 'details' ) );
add_shortcode( 'blog', 			array( 'RoyalShortcodes', 'blog' ) );
add_shortcode( 'slider', 		array( 'RoyalShortcodes', 'slider' ) );
add_shortcode( 'clear', 		array( 'RoyalShortcodes', 'clear' ) );

// Page builder actions
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_sectionTitle' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_button' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_video' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_accordions' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_accordion' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_tabs' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_tab' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_promotion' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_alert' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_progress' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_bars' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_bar' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_milestone' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_counter' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_highlight' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_quote' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_sticker' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_dropcap' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_pricingTable' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_plan' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_map' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_googleMap' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_contactForm' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_infoBox' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_ourClients' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_ourTeam' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_services' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_service' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_portfolio' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_twitter' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_details' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_blog' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_slider' ) );
add_action( 'vc_before_init', 	array( 'RoyalShortcodes', 'vc_clear' ) );

// Nested shortcodes
add_action( 'vc_before_init', function() {
	
	// Circular bars extend
	if (class_exists( 'WPBakeryShortCodesContainer' )) {
		class WPBakeryShortCode_bars extends WPBakeryShortCodesContainer {};
	}
	
	if (class_exists( 'WPBakeryShortCode' )) {
		class WPBakeryShortCode_bar extends WPBakeryShortCode {};
	}
	
	// Milestone counters extend
	if (class_exists( 'WPBakeryShortCodesContainer' )) {
		class WPBakeryShortCode_milestone extends WPBakeryShortCodesContainer {};
	}
	
	if (class_exists( 'WPBakeryShortCode' )) {
		class WPBakeryShortCode_counter extends WPBakeryShortCode {};
	}
	
	// Services extend
	if (class_exists( 'WPBakeryShortCodesContainer' )) {
		class WPBakeryShortCode_services extends WPBakeryShortCodesContainer {};
	}
	
	if (class_exists( 'WPBakeryShortCode' )) {
		class WPBakeryShortCode_service extends WPBakeryShortCode {};
	}
	
	// Accordions extend
	if (class_exists( 'WPBakeryShortCodesContainer' )) {
		class WPBakeryShortCode_accordions extends WPBakeryShortCodesContainer {};
	}
	
	if (class_exists( 'WPBakeryShortCode' )) {
		class WPBakeryShortCode_accordion extends WPBakeryShortCode {};
	}
	
	// Tabs extend
	if (class_exists( 'WPBakeryShortCodesContainer' )) {
		class WPBakeryShortCode_tabs extends WPBakeryShortCodesContainer {};
	}
	
	if (class_exists( 'WPBakeryShortCode' )) {
		class WPBakeryShortCode_tab extends WPBakeryShortCode {};
	}
	
	// Pricing Tables extend
	if (class_exists( 'WPBakeryShortCodesContainer' )) {
		class WPBakeryShortCode_pricing_table extends WPBakeryShortCodesContainer {};
	}
	
	if (class_exists( 'WPBakeryShortCode' )) {
		class WPBakeryShortCode_plan extends WPBakeryShortCode {};
	}
	
} );

// Shortcodes fix
add_filter( 'the_content', array( 'RoyalShortcodes', 'filter' ) );

