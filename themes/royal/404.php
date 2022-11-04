<?php get_header( '404' ); ?>

<section class="section" id="error-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header class="text-center offsetBottomS">
					<div class="icon largest colored offsetBottomS"><i class="fa fa-chain-broken"></i></div>
					<h2 class="offsetTopS"><?php esc_html_e( 'Something has gone wrong!', 'royal' ); ?></h2>
					<p class="info">
						<?php esc_html_e( 'The page you are trying to reach doesn\'t seem to exist.', 'royal' ); ?>
					</p>
				</header>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default"><?php esc_html_e( 'Take me back', 'royal' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer( '404' ); ?>