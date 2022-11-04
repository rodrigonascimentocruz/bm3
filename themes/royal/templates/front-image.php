<?php global $royalConfig; ?>
<?php $height = get_post_meta( get_the_ID( ), 'section-height', true ); ?>
<?php $height = ! empty( $height ) ? $height : '100%'; ?>

<section class="intro" id="intro" data-type="single-image" data-source="<?php echo esc_url( get_post_meta( get_the_ID( ), 'single-image', true ) ); ?>" style="height: <?php echo esc_attr( $height ); ?>;">
	<div class="container">
		<div class="content">
			<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID( ), 'content-image', true ) ); ?>
		</div>
	</div>
	
	<?php if ( $royalConfig['home-magic-mouse'] ) : ?>
	<div class="mouse hidden-xs">
		<div class="wheel"></div>
	</div>
	<?php endif; ?>
</section>