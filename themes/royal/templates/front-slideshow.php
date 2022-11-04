<?php global $royalConfig; ?>
<?php $height = get_post_meta( get_the_ID( ), 'section-height', true ); ?>
<?php $height = ! empty( $height ) ? $height : '100%'; ?>

<section class="intro" id="intro" data-type="slideshow" data-images=".images-list" data-content=".content" data-to-left=".intro-arrow.left" data-to-right=".intro-arrow.right" data-delay="<?php echo esc_attr( $royalConfig['home-slideshow-timeout'] >= 5 ? intval( $royalConfig['home-slideshow-timeout'] ) : 5 ); ?>" style="height: <?php echo esc_attr( $height ); ?>;">
	
	<!-- Images list -->
	<div class="images-list">
		<?php echo RoyalTheme::slideshowImages( '<img src="%s" alt="slideshow-image">', get_post_meta( get_the_ID( ), 'slideshow-images', true ) ); ?>
	</div>
	
	<!-- Content -->
	<div class="container">
		<div class="content">
			
			<?php $slides = RoyalTheme::slideshowSlides( get_the_ID( ) ); ?>
			
			<?php if ( $slides !== false ) : ?>			
				<?php foreach( $slides as $slide ) : ?>
					<!-- Slide -->
					<div>
						<?php echo apply_filters( 'the_content', $slide ); ?>
					</div>
				<?php endforeach; ?>
			
				<!-- Arrows -->
				<a class="intro-arrow left"><div class="icon icon-arrows-left"></div></a>
				<a class="intro-arrow right"><div class="icon icon-arrows-right"></div></a>
			<?php endif; ?>
			
		</div>
	</div>
	
	<?php if ( $royalConfig['home-magic-mouse'] ) : ?>
		<!-- Magic mouse -->
		<div class="mouse hidden-xs">
			<div class="wheel"></div>
		</div>
	<?php endif; ?>
	
</section>