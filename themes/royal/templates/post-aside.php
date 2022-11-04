<?php global $isMasonry; ?>
<?php $title = get_the_title( ); ?>

<?php if ( ! $isMasonry ) : ?>
	<header>
		<?php if ( ! is_single( ) and ! empty( $title ) ) : ?>
		<h2><a href="<?php the_permalink( ); ?>" title="<?php the_title_attribute( ); ?>"><?php the_title( ); ?></a></h2>
		<?php endif; ?>
		<?php the_post_thumbnail( ); ?>
		<div class="info">
			<span><?php the_author_link( ); ?></span>
			<?php RoyalTheme::postCategories( get_the_ID( ), '<span>', '</span>' ); ?>
			<span><?php echo( ( empty( $title ) ? '<a href="' . get_the_permalink( ) . '">' : '' ) ); ?><?php the_time( get_option( 'date_format' ) ); ?><?php echo( ( empty( $title ) ? '</a>' : '' ) ); ?></span>
			<?php if ( comments_open( ) ) : ?>
			<span>
			<?php comments_popup_link( esc_html__( 'Leave a reply', 'royal' ), esc_html__( '1 Comment', 'royal' ), esc_html__( '% Comments', 'royal' ) ); ?>
			</span>
			<?php endif; ?>
			<?php edit_post_link( esc_html__( 'Edit', 'royal' ), '<span>', '</span>' ); ?>
		</div>
	</header>
<?php else : ?>
	<header>
		<?php if ( ! empty( $title ) ) : ?>
		<h3><a href="<?php the_permalink( ); ?>" title="<?php the_title_attribute( ); ?>"><?php the_title( ); ?></a></h3>
		<?php endif; ?>
		<?php the_post_thumbnail( ); ?>
		<div class="info">
			<span><?php the_author_link( ); ?></span>
			<?php RoyalTheme::postCategories( get_the_ID( ), '<span>', '</span>' ); ?>
		</div>
	</header>
<?php endif; ?>

<?php if ( is_search( ) ) : ?>
<?php the_excerpt( ); ?>
<?php else : ?>
<div class="format-holder aside">
	<?php the_content( esc_html__( 'Read More', 'royal' ) ); ?>
</div>
<?php endif; ?>