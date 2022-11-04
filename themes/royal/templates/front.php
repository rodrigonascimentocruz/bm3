<?php
/**
 * Template Name: Front Page
 */
?>

<?php get_header( ); ?>

<?php if ( RoyalTheme::frontPage( get_the_ID( ) ) ) : ?>
<?php echo "\n" . RoyalTheme::frontSections( ); ?>
<?php endif; ?>

<?php get_footer( ); ?>