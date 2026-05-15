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
        <form class="form-filters" method="GET">

            <!-- CATEGORIE -->
            <select class="categories_format" name="categorie" onchange="this.  form.submit()">
                <option value="">CATÉGORIES</option>
                <?php
                    $categories = get_terms([
                    'taxonomy' => 'categorie',
                    'hide_empty' => false,
                    ]);

                    foreach ($categories as $cat) {
                    $selected = (isset($_GET['categorie']) && $_GET['categorie'] === $cat->slug) ? 'selected' : '';
                    echo '<option value="' . esc_attr($cat->slug) . '" ' . $selected . '>' . esc_html($cat->name) . '</option>';
                    }
                ?>
            </select>

            <!-- FORMAT -->
            <select class="categories_format" name="format" onchange="this.form.submit()">
                <option value="">FORMATS</option>
                <?php
                $formats = get_terms([
                'taxonomy' => 'format',
                'hide_empty' => false,
                ]);

                foreach ($formats as $format) {
                $selected = (isset($_GET['format']) && $_GET['format'] === $format->slug) ? 'selected' : '';
                echo '<option value="' . esc_attr($format->slug) . '" ' . $selected . '>' . esc_html($format->name) . '</option>';
                }
                ?>
            </select>

            <!-- TRI -->
            <select class="trier" name="order" onchange="this.form.submit()">
                <option value="">TRIER PAR</option>
                <option value="DESC" <?php selected($_GET['order'] ?? '', 'DESC'); ?>>Décroissant</option>
                <option value="ASC" <?php selected($_GET['order'] ?? '', 'ASC'); ?>>Croissant</option>
            </select>

        </form>

    </section>
 
<section class="cards-photos">
    <div class="grid-photos" id="grid-photos">
            
        <!-- Récupérer les valeurs de get. -->
        <?php
        $categorie = $_GET['categorie'] ?? '';
        $format    = $_GET['format'] ?? '';
        $order     = $_GET['order'] ?? 'DESC';

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
        $order = 'DESC';
        }


        $args = [
        'post_type'      => 'photographie',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
        'tax_query'      => [
            'relation' => 'AND',
        ],
        ];


        if (!empty($categorie)) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        ];
        }


        if (!empty($format)) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        ];
        }

        // loop : la boucle wordpress
        $query = new WP_Query($args);

        if ($query->have_posts()) :

        while ($query->have_posts()) : $query->the_post();

            // champ ACF "photo"
            $image = get_field('photo');
            ?>
                    <div class="photo">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    </div>

                    <?php
        endwhile;

        wp_reset_postdata();

        endif; ?>
    </div>
</section>
 <button class="cta-choix" type="button">Charger plus</button>
    <?php get_footer(); ?>