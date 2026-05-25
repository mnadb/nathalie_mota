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
 
   <!-- Filtres envoyes en AJAX pour changer les photos sans recharger la page. -->
   <section class="filters">
  <form class="form-filters" id="form-filters">
    <!-- Filtre par categorie. -->
    <select class="categories_format js-photo-filter" name="photo_categorie" aria-label="Filtrer par catégorie">
      <option value="">CATÉGORIES</option>
      <?php
      // Recupere les categories disponibles.
      $categories = get_terms([
        'taxonomy' => 'categorie',
        'hide_empty' => false,
      ]);

      // Garde la categorie deja selectionnee si elle existe.
      $selected_category = isset($_GET['photo_categorie']) ? sanitize_text_field(wp_unslash($_GET['photo_categorie'])) : '';

      foreach ($categories as $cat) {
        echo '<option value="' . esc_attr($cat->slug) . '" ' . selected($selected_category, $cat->slug, false) . '>' . esc_html($cat->name) . '</option>';
      }
      ?>
    </select>

    <!-- Filtre par format. -->
    <select class="categories_format js-photo-filter" name="photo_format" aria-label="Filtrer par format">
      <option value="">FORMATS</option>
      <?php
      // Recupere les formats disponibles.
      $formats = get_terms([
        'taxonomy' => 'format',
        'hide_empty' => false,
      ]);

      // Garde le format deja selectionne s'il existe.
      $selected_format = isset($_GET['photo_format']) ? sanitize_text_field(wp_unslash($_GET['photo_format'])) : '';

      foreach ($formats as $format) {
        echo '<option value="' . esc_attr($format->slug) . '" ' . selected($selected_format, $format->slug, false) . '>' . esc_html($format->name) . '</option>';
      }
      ?>
    </select>

    <!-- Tri par date. -->
    <select class="trier js-photo-filter" name="photo_order" aria-label="Trier les photos">
      <option value="">TRIER PAR</option>
      <option value="DESC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'DESC'); ?>>Récente</option>
      <option value="ASC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'ASC'); ?>>Ancienne</option>
    </select>
  </form>
</section>

<!-- Grille des photographies. -->
<section class="cards-photos">
  <div class="grid-photos" id="grid-photos" aria-live="polite">
    <?php
    // Affiche les huit premieres photos au chargement.
    $args = [
      'post_type'      => 'photographie',
      'posts_per_page' => 8,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ];

    // Lance la requete WordPress.
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

<!-- Le bouton ajoute huit autres photos avec AJAX. -->
<button class="cta-choix" type="button" id="load-more-photos" data-max-pages="<?php echo esc_attr($query->max_num_pages); ?>"<?php disabled($query->max_num_pages <= 1); ?>>Charger plus</button>

 <!-- Structure HTML de la lightbox utilisée quand on clique sur l'icône plein écran. -->
 <?php get_template_part('parts/lightbox'); ?>

 </main>

<?php get_footer(); ?>
