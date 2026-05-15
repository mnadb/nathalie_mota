<?php
/**
 * The template for displaying all single pages
 *
 * @package WordPress
 * @subpackage Nathalie Mota
 * @since 1.0
 */
?>


<?php get_header(); ?>

<main id="primary" class="site-main">

    <?php if ( have_posts() ) :
	 while ( have_posts() ) : 
	 	the_post(); ?>
    <?php endwhile; endif; ?>
	
</main>
<?php get_footer(); ?>
