<?php global $royalConfig; ?>
<?php $isFrontPage = RoyalTheme::isFrontPage( get_the_ID( ) ); ?>
<!DOCTYPE html>
<html class="no-js <?php echo ( is_admin_bar_showing( ) ? 'wp-bar' : '' ); ?> <?php echo ( ( $royalConfig['header-sticky'] and ! $isFrontPage ) ? 'nav-sticky' : '' ); ?> <?php echo ( is_admin_bar_showing( ) ? 'wp-bar' : '' ); ?>" <?php language_attributes( ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head( ); ?>
	<script src="//tag.goadopt.io/injector.js?website_code=7612c540-a15c-4583-89ba-aa9cf703a5e5" class="adopt-injector"></script>
</head>
<body <?php body_class( ( $royalConfig['header-sticky'] ? 'nav-sticky' : null ) ); ?>>
	<?php $logo_dark = ! empty( $royalConfig['logo-dark']['url'] ) ? $royalConfig['logo-dark']['url'] : get_template_directory_uri( ) . '/images/logo/logo-' . $royalConfig['styling-schema'] . '.png'; ?>
	<?php $logo_light = ! empty( $royalConfig['logo-light']['url'] ) ? $royalConfig['logo-light']['url'] : get_template_directory_uri( ) . '/images/logo/logo-white.png'; ?>
					
	<?php if ( $royalConfig['preloader'] or $royalConfig === null ) : ?>
		<?php if ( ( $royalConfig['preloader-only-home'] and $isFrontPage ) or ! $royalConfig['preloader-only-home'] or $royalConfig == null ) : ?>
		<div class="page-loader">
			<div class="content">
				<div class="loader-logo"><img src="<?php echo esc_url( $logo_dark ); ?>" alt="Logo" data-rjs="2"></div>
				<div class="loader-icon"><span class="spinner"></span><span></span></div>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $isFrontPage ) : ?>
	<div class="navbar" role="navigation">
	<?php else : ?>
	<div class="navbar <?php echo esc_attr( $royalConfig['header-sticky'] ? 'navbar-fixed-top' : '' ); ?> floating positive" role="navigation">
	<?php endif; ?>
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( $isFrontPage ) : ?>
					<img src="<?php echo esc_url( $logo_light ); ?>" data-alt="<?php echo esc_url( $logo_dark ); ?>" alt="Logo" data-rjs="2">
					<?php else : ?>
					<img src="<?php echo esc_url( $logo_dark ); ?>" alt="Logo" data-rjs="2">
					<?php endif; ?>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<?php echo RoyalTheme::mainMenu( get_the_ID( ), 'nav navbar-nav navbar-right' ); ?>
			</div>
		</div>
	</div>