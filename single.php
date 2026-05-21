<?php
/**
 * Single Post Template
 * 
 * @package Nathalie Mota
 */
?>

<?php get_header(); ?>

<main id="main" class="single-photo-page">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- On récupère les champs personnalisés ACF de la photo. -->
<?php
$image      = get_field('photo');
$reference  = get_field('reference');
$format     = get_field('format');
$type       = get_field('type');
$annee      = get_field('annee');

// On récupère la photo précédente et la photo suivante.
$prev_post = get_previous_post();
$next_post = get_next_post();
?>

<!-- Section principale : infos de la photo + image. -->
<section <?php post_class('photo-detail'); ?>>

    <div class="photo-info">

        <!-- Métadonnées de la photo : titre, référence, catégorie, format, type, année. -->
        <div class="photo-meta">
            <h1><?php the_title(); ?></h1>

            <ul>
                <?php if ( $reference ) : ?>
                    <li><strong>Référence :</strong> <?php echo esc_html($reference); ?></li>
                <?php endif; ?>

                <?php
                // On récupère les catégories liées à cette photo.
                $categories = get_the_terms(get_the_ID(), 'categorie');
                if ($categories && !is_wp_error($categories)) :
                    $category_names = wp_list_pluck($categories, 'name');
                ?>
                    <li><strong>Catégorie :</strong> <?php echo esc_html(join(', ', $category_names)); ?></li>
                <?php endif; ?>

                <li><strong>Format :</strong> <?php echo esc_html($format ?: 'Portrait'); ?></li>
                <li><strong>Type :</strong> <?php echo esc_html($type ?: 'Numérique'); ?></li>
                <li><strong>Année :</strong> <?php echo esc_html($annee ?: '2022'); ?></li>
            </ul>
        </div>

        <!-- Grande image de la photo. -->
        <div class="photo-image">
            <?php if ( ! empty($image) ) : ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            <?php endif; ?>

            <!-- Navigation vers la photo précédente ou suivante. -->
            <div class="photo-navigation">

                <!-- Miniature affichée au-dessus des flèches. -->
                <div class="nav-thumbnail">
                    <?php
                    // On affiche une miniature : d'abord la suivante, sinon la précédente.
                    $thumb_post = $next_post ?: $prev_post;

                    if ( $thumb_post ) :
                        $thumb = get_field('photo', $thumb_post->ID);
                        if ( ! empty($thumb) ) :
                    ?>
                        <img 
                            id="nav-preview"
                            src="<?php echo esc_url($thumb['url']); ?>" 
                            alt="<?php echo esc_attr($thumb['alt']); ?>"
                        >
                    <?php endif; endif; ?>
                </div>

                <!-- Flèches précédent / suivant. -->
                <div class="nav-arrows">
                    <?php if ( $prev_post ) :
                        $prev_img = get_field('photo', $prev_post->ID);
                    ?>
                        <a 
                            href="<?php echo esc_url(get_permalink($prev_post)); ?>" 
                            class="navigation-arrow"
                            data-preview="<?php echo esc_url($prev_img['url'] ?? ''); ?>"
                        >
                            ←
                        </a>
                    <?php endif; ?>

                    <?php if ( $next_post ) :
                        $next_img = get_field('photo', $next_post->ID);
                    ?>
                        <a 
                            href="<?php echo esc_url(get_permalink($next_post)); ?>" 
                            class="navigation-arrow"
                            data-preview="<?php echo esc_url($next_img['url'] ?? ''); ?>"
                        >
                            →
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

</section>

<!-- Zone contact : le bouton ouvre la popup et envoie la référence de la photo. -->
<section class="photo-contact">
    <p>Cette photo vous intéresse ?</p>
    <button
        type="button"
        class="contact-button js-open-contact-popup"
        data-reference="<?php echo esc_attr($reference); ?>"
    >
        Contact
    </button>
</section>

<!-- Photos similaires affichées sous la fiche photo. -->
<section class="related">
    <h2>VOUS AIMEREZ AUSSI</h2>

    <div class="related-grid">

        <?php
        // Requête pour afficher 2 photos similaires.
        $related_args = array(
            'post_type'      => get_post_type(),
            'posts_per_page' => 2,
            'post__not_in'   => array(get_the_ID()),
        );

        // Si la photo a une catégorie, on cherche des photos de la même catégorie.
        if ( ! empty($categories) && ! is_wp_error($categories) ) {
            $related_args['tax_query'] = array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'term_id',
                    'terms'    => wp_list_pluck($categories, 'term_id'),
                ),
            );
        }

        // Boucle des photos similaires.
        $related_query = new WP_Query($related_args);

        if ( $related_query->have_posts() ) :
            while ( $related_query->have_posts() ) : $related_query->the_post();

                $related_image = get_field('photo');
        ?>

            <!-- Carte d'une photo similaire. -->
            <article class="card">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( ! empty($related_image) ) : ?>
                        <img src="<?php echo esc_url($related_image['url']); ?>" alt="<?php echo esc_attr($related_image['alt']); ?>">
                    <?php endif; ?>
                </a>
            </article>

        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

    </div>
</section>

<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
