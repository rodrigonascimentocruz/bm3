<?php global $royalConfig; ?>

<?php if ( have_posts( ) ) : ?>
	<?php global $more; $more = 0; ?>
	<?php while ( have_posts( ) ) : the_post( ); ?>
		<article id="post-<?php the_ID( ); ?>" <?php post_class( 'row blog-post offsetTopS offsetBottomS' . ( is_single( ) ? ' is-single' : '' ) ); ?>>
			<?php if ( ! is_single( ) ) : ?>
			<div class="col-md-12 col-sm-12">
			<?php else : ?>
			<div class="col-md-12 col-sm-12" id="share-image">
			<?php endif; ?>
				<?php RoyalTheme::postContent( ); ?>
				
				<?php if ( is_single( ) ) : ?>
				<?php wp_link_pages( array( 'before' => '<div class="pages-navigation text-center"><span class="pages">' . esc_html__( 'Pages:', 'royal' ) . '</span>', 'after' => '</div>', 'separator' => '&nbsp; ' ) ); ?>
				<?php endif; ?>
			</div>

			<?php if ( is_single( ) and $royalConfig['allow-share-posts'] ) : ?>
			<div class="col-md-12 share-panel">
				<span><?php esc_html_e( 'Share', 'royal' ); ?></span>
				<div class="social">
					<a title="Twitter" onclick="shareTo( 'twitter', '#share-title', '#share-image' )"><i class="fa fa-twitter"></i></a>
					<a title="Facebook" onclick="shareTo( 'facebook', '#share-title', '#share-image' )"><i class="fa fa-facebook"></i></a>
					<a title="Pinterest" onclick="shareTo( 'pinterest', '#share-title', '#share-image' )"><i class="fa fa-pinterest"></i></a>
					<a title="LinkedIn" onclick="shareTo( 'linkedin', '#share-title', '#share-image' )"><i class="fa fa-linkedin"></i></a>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( is_single( ) ) : ?>
			<?php echo get_the_tag_list( '<div class="col-md-12 tags-list"><span>Tags</span>', esc_html__( ', ', 'royal' ), '</div>' ); ?>
			<?php endif; ?>
		</article>

		<?php if ( is_single( ) ) : ?>
		<?php comments_template( ); ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php else : ?>
<?php get_template_part( 'templates/no-content' ); ?>
<?php endif; ?>