<?php
define( 'WP_THEME', dirname( dirname( __FILE__ ) ) );
define( 'WP_ROOT', dirname( dirname( dirname( dirname( dirname(__FILE__ ) ) ) ) ) );

include_once WP_ROOT . '/wp-load.php';
include_once WP_ROOT . '/wp-includes/wp-db.php';

$action = $_REQUEST['action'];
$response = array( );

// Contact form
if ( $action == 'contact' ) {
	check_ajax_referer( 'royal-nonce', 'security' );
	
	$name = trim( $_POST['name'] );
	$email = trim( $_POST['email'] );
	$phone = trim( $_POST['phone'] );
	$message = trim( $_POST['message'] );
	$date = date( 'F j, Y, H:i (h:i A) (\G\M\T O)' );
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if ( empty( $name ) ) {
		$response = array( 'status' => 'error', 'error' => 'name' );
	} else if ( empty( $message ) ) {
		$response = array( 'status' => 'error', 'error' => 'message' );
	} else if ( empty( $email ) or ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$response = array( 'status' => 'error', 'error' => 'email' );
	} else {	
		$variables = array( '{from}', '{email}', '{phone}', '{message}', '{date}', '{ip}' );
		$values = array( $name, $email, $phone, $message, $date, $ip );
		$text = trim( str_replace( $variables, $values, $royalConfig['contact-template'] ) );
		$headers = array( 'From: ' . $name . ' <' . $email . '>' );
		
		if ( ! empty( $royalConfig['contact-email'] ) ) {
			if ( wp_mail( $royalConfig['contact-email'], esc_html__( 'A new message from', 'royal' ) . ' ' . $name, $text, $headers ) ) {
				$response = array( 'status' => 'success' );
			} else {
				$response = array( 'status' => 'error', 'error' => 'send' );
			}
		}
	}
	
	echo json_encode( $response );
} 

// Export Site Sections
else if ( $action == 'export-sections' ) {
	if ( ! current_user_can( 'import' ) ) {
		die( );
	}

	$sections = ( array ) @json_decode( get_option( 'royal_sections', true ), true );

	if ( ! is_array( $sections ) or count( $sections ) < 1 ) {
		die( );
	}

	$sitename = sanitize_key( get_bloginfo( 'name' ) );
	if ( ! empty( $sitename ) ) $sitename .= '.';
	$filename = $sitename . 'sections.' . date( 'Y-m-d' ) . '.json';

	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: attachment; filename=' . $filename );
	header( 'Content-Type: text/json; charset=' . get_option( 'blog_charset' ), true );

	echo json_encode( $sections );
} 

// No action
else {
	echo json_encode( array( 'status' => 'error', 'error' => 'action' ) );
}