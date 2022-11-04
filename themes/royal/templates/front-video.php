<?php global $royalConfig; ?>
<?php $height = get_post_meta( get_the_ID( ), 'section-height', true ); ?>
<?php $height = ! empty( $height ) ? $height : '100%'; ?>

<section class="intro" id="intro" data-type="video" 
	data-source="<?php echo esc_attr( get_post_meta( get_the_ID( ), 'video-id', true ) ); ?>" 
	data-on-error="<?php echo ( ( isset( $royalConfig['home-video-placeholder'] ) and isset( $royalConfig['home-video-placeholder']['url'] ) ) ? esc_url( $royalConfig['home-video-placeholder']['url'] ) : '' ); ?>" 
	data-mute="<?php echo ( ( $royalConfig['home-video-mutted'] or $royalConfig['home-video-mutted'] === null ) ? 'true' : 'false' ) ?>" 
	data-start="<?php echo intval( $royalConfig['home-video-start-at'] ); ?>" 
	data-overlay="<?php echo ( ( $royalConfig['home-video-overlay'] === null ? 40 : intval( $royalConfig['home-video-overlay'] ) ) / 100 ); ?>" 
	data-stop="<?php echo intval( RoyalTheme::option( 'home-video-stop-at', 0 ) ); ?>" 
	data-loop="<?php echo ( RoyalTheme::option( 'home-video-loop', true ) ? 'true' : 'false' ); ?>" 
	style="height: <?php echo esc_attr( $height ); ?>;"
>
	<div class="container">
		<div class="content">
			<div class="text-center">
				<div class="row">
					<div class="col-md-12">
						<?php if ( $royalConfig['home-video-play-btn'] ) : ?>
						<div class="video-control animate" id="video-mode">
							<i class="fa fa-play"></i>
						</div>
						<?php endif; ?>
						<header>
							<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID( ), 'content-video', true ) ); ?>
						</header>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php if ( $royalConfig['home-magic-mouse'] ) : ?>
	<div class="mouse hidden-xs">
		<div class="wheel"></div>
	</div>
	<?php endif; ?>
</section>