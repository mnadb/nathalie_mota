<?php

// enregistrer le menu //
function register_my_menu() {
    register_nav_menu( 'header' , 'En tête du menu' );
    register_nav_menu( 'footer' , 'Pied de page' );
}
add_action( 'after_setup_theme', 'register_my_menu' );


function nathalie_mota_enqueue_assets() {
    $theme_dir = get_template_directory();

    wp_enqueue_style(
        'nathalie-mota-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    wp_enqueue_style(
        'select2-style',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        array(),
        '4.1.0-rc.0'
    );

    wp_enqueue_style(
        'nathalie-mota-main-style',
        get_template_directory_uri() . '/assets/sass/style.css',
        array(),
        filemtime($theme_dir . '/assets/sass/style.css')
    );

    wp_enqueue_script(
        'nathalie-mota-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'),
        filemtime($theme_dir . '/assets/js/script.js'),
        true
    );

    wp_enqueue_script(
        'loader-photos',
        get_template_directory_uri() . '/assets/js/loader-photos.js',
        array('jquery'),
        filemtime($theme_dir . '/assets/js/loader-photos.js'),
        true
    );

    wp_localize_script('loader-photos', 'loaderPhotosData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('loader_photos_nonce'),
        'posts_per_page' => 8,
    ]);

    wp_enqueue_script(
        'single-photo',
        get_template_directory_uri() . '/assets/js/single-photo.js',
        array(),
        '1.0',
        true
    );

    wp_enqueue_script(
        'contact-popup-js',
        get_template_directory_uri() . '/assets/js/contact-popup.js',
        array(),
        filemtime($theme_dir . '/assets/js/contact-popup.js'),
        true
    );

    wp_enqueue_script(
        'lightbox-js',
        get_template_directory_uri() . '/assets/js/overlay-lightbox.js',
        array(),
        filemtime($theme_dir . '/assets/js/overlay-lightbox.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_assets');

add_action('wp_ajax_filter_photos', 'nathalie_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'nathalie_filter_photos');

function nathalie_filter_photos() {
    check_ajax_referer('loader_photos_nonce', 'nonce');

    $categorie = isset($_POST['categorie']) ? sanitize_text_field(wp_unslash($_POST['categorie'])) : '';
    $format    = isset($_POST['format']) ? sanitize_text_field(wp_unslash($_POST['format'])) : '';
    $order     = isset($_POST['order']) ? strtoupper(sanitize_text_field(wp_unslash($_POST['order']))) : 'DESC';
    $paged     = isset($_POST['paged']) ? absint($_POST['paged']) : 1;

    if (!in_array($order, ['ASC', 'DESC'], true)) {
        $order = 'DESC';
    }

    $args = [
        'post_type'      => 'photographie',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
        'paged'          => $paged,
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

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('parts/overlay');
        }
    } else {
        echo '<p class="no-photos">Aucune photo ne correspond à ces filtres.</p>';
    }

    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'max_pages' => $query->max_num_pages,
        'paged' => $paged,
    ]);
}