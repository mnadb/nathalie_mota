<?php 
/**
 * Template Name : Accueil
 * 
 * @package Nathalie Mota
 */
?>

<?php get_header(); ?>

<main id="primary" class="site-main">
    <!-- SECTION-HERO -->
    <section class="hero">
        <?php the_content(); ?>
    </section>
 
    <!-- FILTERS -->
    <section class="filters">
        <form class="form-filters" method="GET" action="<?php echo esc_url(get_permalink()); ?>">

            <!-- CATEGORIE -->
            <select class="categories_format" name="photo_categorie" aria-label="Filtrer par catégorie" onchange="this.form.submit()">
                <option value="">CATÉGORIES</option>
                <?php
                    $categories = get_terms([
                    'taxonomy' => 'categorie',
                    'hide_empty' => false,
                    ]);

                    foreach ($categories as $cat) {
                    $selected_category = isset($_GET['photo_categorie']) ? sanitize_text_field(wp_unslash($_GET['photo_categorie'])) : '';
                    echo '<option value="' . esc_attr($cat->slug) . '" ' . selected($selected_category, $cat->slug, false) . '>' . esc_html($cat->name) . '</option>';
                    }
                ?>
            </select>

            <!-- FORMAT -->
            <select class="categories_format" name="photo_format" aria-label="Filtrer par format" onchange="this.form.submit()">
                <option value="">FORMATS</option>
                <?php
                $formats = get_terms([
                'taxonomy' => 'format',
                'hide_empty' => false,
                ]);

                foreach ($formats as $format) {
                $selected_format = isset($_GET['photo_format']) ? sanitize_text_field(wp_unslash($_GET['photo_format'])) : '';
                echo '<option value="' . esc_attr($format->slug) . '" ' . selected($selected_format, $format->slug, false) . '>' . esc_html($format->name) . '</option>';
                }
                ?>
            </select>

            <!-- TRI -->
            <select class="trier" name="photo_order" aria-label="Trier les photos" onchange="this.form.submit()">
                <option value="">TRIER PAR</option>
                <option value="DESC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'DESC'); ?>>Récente</option>
                <option value="ASC" <?php selected(strtoupper(sanitize_text_field(wp_unslash($_GET['photo_order'] ?? ''))), 'ASC'); ?>>Ancienne</option>
            </select>

        </form>

    </section>
 
<section class="cards-photos">
    <div class="grid-photos" id="grid-photos">
            
        <!-- Récupérer les valeurs de get. -->
        <?php
        $categorie = isset($_GET['photo_categorie']) ? sanitize_text_field(wp_unslash($_GET['photo_categorie'])) : '';
        $format    = isset($_GET['photo_format']) ? sanitize_text_field(wp_unslash($_GET['photo_format'])) : '';
        $order     = isset($_GET['photo_order']) ? sanitize_text_field(wp_unslash($_GET['photo_order'])) : 'DESC';

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
        $order = 'DESC';
        }


        $args = [
        'post_type'      => 'photographie',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
        ];

        $tax_query = [];


        if (!empty($categorie)) {
        $tax_query[] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        ];
        }


        if (!empty($format)) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        ];
        }

        if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
        }

        // loop : la boucle wordpress
        $query = new WP_Query($args);

        if ($query->have_posts()) :

        while ($query->have_posts()) : $query->the_post();

            get_template_part('parts/overlay');

        endwhile;

        wp_reset_postdata();

        else :
            echo '<p class="no-photos">Aucune photo ne correspond à ces filtres.</p>';
        endif; ?>
    </div>
</section>
 <button class="cta-choix" type="button">Charger plus</button>

 <?php get_template_part('parts/lightbox'); ?>

 </main>

<?php get_footer(); ?>
