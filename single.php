<?php get_header(); ?>

<main id="main" class="single-photo-page">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<!-- Je récupérer les champs personnalisés d'ACF et la photo prev et next -->
<?php
$image      = get_field('photo');
$reference  = get_field('reference');
$format     = get_field('format');
$type       = get_field('type');
$annee      = get_field('annee');

$prev_post = get_previous_post();
$next_post = get_next_post();
?>
<!-- ajout automatique des classes WP au post -->
<section <?php post_class('photo-detail'); ?>>

    <div class="photo-info">

        <div class="photo-meta">
            <h1><?php the_title(); ?></h1>

            <ul>
                <?php if ( $reference ) : ?>
                    <li><strong>Référence :</strong> <?php echo esc_html($reference); ?></li>
                <?php endif; ?>

                <?php
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
        <!-- Affichage de la grande photo -->
        <div class="photo-image">
            <?php if ( ! empty($image) ) : ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            <?php endif; ?>

            <div class="photo-navigation">
                <!-- affichage de la miniature -->
                <div class="nav-thumbnail">
                    <?php
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

<section class="photo-contact">
    <p>Cette photo vous intéresse ?</p>
    <button type="button" class="contact-button">Contact</button>
</section>

<section class="related">
    <h2>VOUS AIMEREZ AUSSI</h2>

    <div class="related-grid">

        <?php
        $related_args = array(
            'post_type'      => get_post_type(),
            'posts_per_page' => 2,
            'post__not_in'   => array(get_the_ID()),
        );

        if ( ! empty($categories) && ! is_wp_error($categories) ) {
            $related_args['tax_query'] = array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'term_id',
                    'terms'    => wp_list_pluck($categories, 'term_id'),
                ),
            );
        }

        $related_query = new WP_Query($related_args);

        if ( $related_query->have_posts() ) :
            while ( $related_query->have_posts() ) : $related_query->the_post();

                $related_image = get_field('photo');
        ?>

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