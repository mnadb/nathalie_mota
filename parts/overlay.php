<?php
// On récupère l'image ACF de la photo.
$image = get_field('photo');

// Si aucune image n'existe, on n'affiche rien.
if (empty($image)) {
    return;
}

// Données utilisées dans l'overlay et dans la lightbox.
$reference = get_field('reference') ?: get_the_title();
$categories = get_the_terms(get_the_ID(), 'categorie');
$category_name = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->name : '';
?>

<!-- Carte photo : les data-* servent au JavaScript de la lightbox. -->
<article
    class="photo"
    data-full="<?php echo esc_url($image['url']); ?>"
    data-ref="<?php echo esc_attr($reference); ?>"
    data-category="<?php echo esc_attr($category_name); ?>"
>
    <img
        src="<?php echo esc_url($image['url']); ?>"
        alt="<?php echo esc_attr(($image['alt'] ?? '') ?: get_the_title()); ?>"
    >

    <!-- Overlay affiché au survol de la photo. -->
    <div class="photo-overlay">
        <!-- Bouton pour ouvrir la photo en lightbox. -->
        <button class="photo-overlay__fullscreen js-open-lightbox" type="button" aria-label="Ouvrir la photo en plein écran"></button>

        <!-- Lien vers la page single de la photo. -->
        <a class="photo-overlay__eye" href="<?php the_permalink(); ?>" aria-label="Voir la fiche de la photo">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Icon_eye.svg'); ?>" alt="">
        </a>

        <!-- Informations affichées en bas de l'overlay. -->
        <div class="photo-overlay__infos">
            <span><?php echo esc_html($reference); ?></span>
            <span><?php echo esc_html($category_name); ?></span>
        </div>
    </div>
</article>
