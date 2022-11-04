<?php global $royalConfig; ?>
<!DOCTYPE html>
<html class="no-js <?php echo ( is_admin_bar_showing( ) ? 'wp-bar' : '' ); ?>" <?php language_attributes( ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head( ); ?>
</head>
<body <?php body_class( ( $royalConfig['header-sticky'] ? 'nav-sticky' : null ) ); ?>>
	<?php $logo_dark = ! empty( $royalConfig['logo-dark']['url'] ) ? $royalConfig['logo-dark']['url'] : get_template_directory_uri( ) . '/images/logo/logo-' . $royalConfig['styling-schema'] . '.png'; ?>
	
	<?php if ( $royalConfig['preloader'] and ! $royalConfig['preloader-only-home'] ) : ?>
	<div class="page-loader">
        <div class="content">
            <div class="loader-logo"><img src="<?php echo esc_url( $logo_dark ); ?>" alt="Logo" data-rjs="2"></div>
			<div class="loader-icon"><span class="spinner"></span><span></span></div>
        </div>
    </div>
	<?php endif; ?>