<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php if ( have_posts() ) :
	 while ( have_posts() ) : 
	 	the_post(); ?>


    <section class="hero">
		<?php the_content(); ?>
  	</section>
    <form id="filter-form">
     <section class="filters">
        <select class="categories_format" name="categories">
          <option value="">CATÉGORIES</option>
          <option value="reception">Réception</option>
          <option value="television">Télévision</option>
          <option value="concert">Concert</option>
          <option value="mariage">Mariage</option>
          <option value="label5">Label5</option>
        </select>

        <select class="categories_format" name="formats">
          <option value="">FORMATS</option>
          <option value="portrait">Portrait</option>
          <option value="paysage">Paysage</option>
        </select>

        <select class="trier" name="sort">
          <option value="">TRIER PAR</option>
          <option value="recent">Récent</option>
          <option value="popular">Populaire</option>
        </select>
      </section>
     </form>
<div id="results"></div>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>