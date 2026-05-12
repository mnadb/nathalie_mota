<?php get_header(); ?>

<?php if ( have_posts() ) :
     while ( have_posts() ) :
      the_post(); ?>

 <main id="primary" class="site-main"<?php post_class(); ?>>
    <section  class="hero id="post-<?php the_ID(); ?>" >
        <?php 
        $image = get_field('photo');
            if( !empty( $image ) ): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
        <?php endif; ?>
        <h1><?php the_title(); ?></h1>
    </section>


   

<div class="entry-content" itemprop="mainContentOfPage">
<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
<?php the_content(); ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
</section>
<?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>