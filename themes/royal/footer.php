<?php global $royalConfig; ?>

<footer class="footer offsetTop offsetBottom">
	<div class="container">
		
		<div class="row">			
			<div class="col-md-12 text-center">
				
				<?php if ( $royalConfig['footer-button-top'] or $royalConfig === null ) : ?>
				<!-- Back to top -->
				<a class="to-top"><i class="fa fa-angle-up"></i></a>
				<?php endif; ?>
				
				<!-- Footer logo -->
				<?php $footer_logo = ! empty( $royalConfig['footer-logo']['url'] ) ? $royalConfig['footer-logo']['url'] : get_template_directory_uri( ) . '/images/icon/icon-footer.png'; ?>
				<p class="footer-logo">
					<img src="<?php echo esc_url( $footer_logo ); ?>" alt="Logo" data-rjs="2">
				</p>
				
				<!-- Social links -->
				<div class="social">
					<?php echo RoyalTheme::socialIcons( '<a href="%3$s" title="%2$s" target="_blank"><i class="fa %1$s"></i></a>' ); ?>
				</div>
				
				<!-- Copyright -->
				<p class="copyright"><?php echo do_shortcode( wp_kses_post( $royalConfig['footer-text'] ) ); ?></p>
				
			</div>	
		</div>
		
		<?php 
			if( is_active_sidebar( 'footer' ) ) {
				dynamic_sidebar( 'footer' );	
			} 
		?>
		
	</div>
</footer>

<?php RoyalTheme::inlineScripts( get_the_ID( ) ); ?>

<?php wp_footer( ); ?>
</body>
</html>