<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php if ( have_posts() ) :
	 while ( have_posts() ) : 
	 	the_post(); ?>


    <section class="hero">
		<h1>PHOTOGRAPHE EVENT</h1>
 
  	</section>


    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1> <?php edit_post_link(); ?>

        <div class="entry-content" itemprop="mainContentOfPage">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
            <?php the_content(); ?>
            <div class="entry-links"><?php wp_link_pages(); ?></div>
        </div>
    </article>
    <?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>