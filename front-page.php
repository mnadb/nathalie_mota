<?php 
/**
 * Template Name : Accueil
 * 
 * @package Nathalie Mota
 */
?>

<?php get_header(); ?>

<main id="primary" class="site-main">
    <!-- HERO : affiche le contenu ajouté dans l'éditeur WordPress de la page d'accueil. -->
    <section class="hero">
        <?php the_content(); ?>
    </section>
 
   <section class="filters">
  <form class="form-filters" id="form-filters">
    <select class="categories_format js-photo-filter" name="photo_categorie" aria-label="Filtrer par catégorie">
      <option value="">CATÉGORIES</option>
      <?php
      $categories = get_terms([
        'taxonomy' => 'categorie',
        'hide_empty' => false,
      ]);

      $selected_category = isset($_GET['photo_categorie']) ? sanitize_text_field(wp_unslash($_GET['photo_categorie'])) : '';

      foreach ($categories as $cat) {
        echo '<option value="' . esc_attr($cat->slug) . '" ' . selected($selected_category, $cat->slug, false) . '>' . esc_html($cat->name) . '</option>';
      }
      ?>
    </select>

    <select class="categories_format js-photo-filter" name="photo_format" aria-label="Filtrer par format">
      <option value="">FORMATS</option>
      <?php
      $formats = get_terms([
        'taxonomy' => 'format',
        'hide_empty' => false,
      ]);

      $selected_format = isset($_GET['photo_format']) ? sanitize_text_field(wp_unslash($_GET['photo_format'])) : '';

      foreach ($formats as $format) {
        echo '<option value="' . esc_attr($format->slug) . '" ' . selected($selected_format, $format->slug, false) . '>' . esc_html($format->name) . '</option>';
      }
      ?>
    </select>

    <select class="trier js-photo-filter" name="photo_order" aria-label="Trier les photos">
      <option value="">TRIER PAR</option>
      <option value="DESC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'DESC'); ?>>Récente</option>
      <option value="ASC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'ASC'); ?>>Ancienne</option>
    </select>
  </form>
</section>

<section class="cards-photos">
  <div class="grid-photos" id="grid-photos">
    <?php
    $args = [
      'post_type'      => 'photographie',
      'posts_per_page' => 8,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
        get_template_part('parts/overlay');
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p class="no-photos">Aucune photo ne correspond à ces filtres.</p>';
    endif;
    ?>
  </div>
</section>

<button class="cta-choix" type="button" id="load-more-photos">Charger plus</button>

 <!-- Structure HTML de la lightbox utilisée quand on clique sur l'icône plein écran. -->
 <?php get_template_part('parts/lightbox'); ?>

 </main>

<?php get_footer(); ?>
