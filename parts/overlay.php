<?php
$image = get_field('photo');

if (empty($image)) {
    return;
}

$reference = get_field('reference') ?: get_the_title();
$categories = get_the_terms(get_the_ID(), 'categorie');
$category_name = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->name : '';
?>

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

    <div class="photo-overlay">
        <button class="photo-overlay__fullscreen js-open-lightbox" type="button" aria-label="Ouvrir la photo en plein écran"></button>

        <a class="photo-overlay__eye" href="<?php the_permalink(); ?>" aria-label="Voir la fiche de la photo">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Icon_eye.svg'); ?>" alt="">
        </a>

        <div class="photo-overlay__infos">
            <span><?php echo esc_html($reference); ?></span>
            <span><?php echo esc_html($category_name); ?></span>
        </div>
    </div>
</article>
