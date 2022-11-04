<header class="offsetBottomS">
	<h2><?php esc_html_e( 'Nothing Found', 'royal' ); ?></h2>
</header>

<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'royal' ); ?></p>

<div class="offsetTopS nothing-found">
	<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'royal' ); ?>" value="" name="s" title="<?php esc_attr_e( 'Search for:', 'royal' ); ?>" />
		<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'royal' ); ?>" />
	</form>
</div>