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
 
    <!-- FILTRES : le formulaire recharge la page quand on choisit une option. -->
    <section class="filters">
        <form class="form-filters" method="GET" action="<?php echo esc_url(get_permalink()); ?>">

            <!-- Filtre par catégorie. la class pour Selects2 -->
            <select class="categories_format js-photo-filter" name="photo_categorie" aria-label="Filtrer par catégorie" onchange="this.form.submit()">
                <option value="">CATÉGORIES</option>
                <?php
                    // On récupère toutes les catégories de la taxonomie "categorie".
                    $categories = get_terms([
                    'taxonomy' => 'categorie',
                    'hide_empty' => false,
                    ]);

                    foreach ($categories as $cat) {
                    // On garde la catégorie sélectionnée après le rechargement de la page.
                    $selected_category = isset($_GET['photo_categorie']) ? sanitize_text_field(wp_unslash($_GET['photo_categorie'])) : '';
                    echo '<option value="' . esc_attr($cat->slug) . '" ' . selected($selected_category, $cat->slug, false) . '>' . esc_html($cat->name) . '</option>';
                    }
                ?>
            </select>

            <!-- Filtre par format. -->
            <select class="categories_format js-photo-filter" name="photo_format" aria-label="Filtrer par format" onchange="this.form.submit()">
                <option value="">FORMATS</option>
                <?php
                // On récupère tous les formats de la taxonomie "format".
                $formats = get_terms([
                'taxonomy' => 'format',
                'hide_empty' => false,
                ]);

                foreach ($formats as $format) {
                // On garde le format sélectionné après le rechargement de la page.
                $selected_format = isset($_GET['photo_format']) ? sanitize_text_field(wp_unslash($_GET['photo_format'])) : '';
                echo '<option value="' . esc_attr($format->slug) . '" ' . selected($selected_format, $format->slug, false) . '>' . esc_html($format->name) . '</option>';
                }
                ?>
            </select>

            <!-- Tri par date : récent ou ancien. -->
            <select class="trier js-photo-filter" name="photo_order" aria-label="Trier les photos" onchange="this.form.submit()">
                <option value="">TRIER PAR</option>
                <option value="DESC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'DESC'); ?>>Récente</option>
                <option value="ASC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'ASC'); ?>>Ancienne</option>
            </select>

        </form>

    </section>
 
<section class="cards-photos">
    <div class="grid-photos" id="grid-photos">
            
        <!-- On récupère les valeurs envoyées par les filtres dans l'URL. -->
        <?php
        $categorie = isset($_GET['photo_categorie']) ? sanitize_text_field(wp_unslash($_GET['photo_categorie'])) : '';
        $format    = isset($_GET['photo_format']) ? sanitize_text_field(wp_unslash($_GET['photo_format'])) : '';
        $order     = isset($_GET['photo_order']) ? sanitize_text_field(wp_unslash($_GET['photo_order'])) : 'DESC';

        // Sécurité : on accepte seulement ASC ou DESC pour le tri.
        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
        $order = 'DESC';
        }

        // wp query - Arguments de base pour récupérer les photos (Croissant et decroissant).
        $args = [
        'post_type'      => 'photographie',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
        ];

        $tax_query = [];


        // Si une catégorie est choisie, on l'ajoute à la requête.
        if (!empty($categorie)) {
        $tax_query[] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        ];
        }


        // Si un format est choisi, on l'ajoute à la requête.
        if (!empty($format)) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        ];
        }

        // Si au moins un filtre existe, on l'ajoute à WP_Query.
        if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
        }

        // Boucle WordPress : on affiche les photographies trouvées.
        $query = new WP_Query($args);

        if ($query->have_posts()) :

        while ($query->have_posts()) : $query->the_post();

            // Chaque photo est affichée avec son overlay.
            get_template_part('parts/overlay');

        endwhile;

        wp_reset_postdata();

        else :
            // Message affiché si aucun résultat ne correspond aux filtres.
            echo '<p class="no-photos">Aucune photo ne correspond à ces filtres.</p>';
        endif; ?>
    </div>
</section>
 <button class="cta-choix" type="button">Charger plus</button>

 <!-- Structure HTML de la lightbox utilisée quand on clique sur l'icône plein écran. -->
 <?php get_template_part('parts/lightbox'); ?>

 </main>

<?php get_footer(); ?>
