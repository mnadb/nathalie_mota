<?php

// Enregistre les deux menus du theme.
function register_my_menu() {
    register_nav_menu( 'header' , 'En tête du menu' );
    register_nav_menu( 'footer' , 'Pied de page' );
}
add_action( 'after_setup_theme', 'register_my_menu' );

/**
 * Chargement des filtres personnalisés + Select2
 */
function mota_enqueue_filters_assets() {
    $theme_dir = get_template_directory();

    // Le formulaire de filtres appartient uniquement a la page d'accueil.
    if (!is_front_page()) {
        return;
    }

    // Charge la feuille de style du composant qui transforme les listes.
    wp_enqueue_style(
        'select2-css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        array(),
        '4.1.0'
    );

    // Charge le plugin Select2 apres la bibliotheque jQuery de WordPress.
    wp_enqueue_script(
        'select2-js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        array('jquery'),
        '4.1.0',
        true
    );

    // Initialise les champs visuels personnalises de la maquette.
    wp_enqueue_script(
        'custom-filters',
        get_template_directory_uri() . '/assets/js/custom-filters.js',
        array('jquery', 'select2-js'),
        filemtime($theme_dir . '/assets/js/custom-filters.js'),
        true
    );

}
add_action('wp_enqueue_scripts', 'mota_enqueue_filters_assets');


// Charge les styles et les scripts du theme.
function nathalie_mota_enqueue_assets() {
    $theme_dir = get_template_directory();

    // Charge la feuille de style declaree par WordPress.
    wp_enqueue_style(
        'nathalie-mota-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // Charge les styles principaux du site.
    wp_enqueue_style(
        'nathalie-mota-main-style',
        get_template_directory_uri() . '/assets/sass/style.css',
        array(),
        filemtime($theme_dir . '/assets/sass/style.css')
    );

    // Charge le menu mobile.
    wp_enqueue_script(
        'nathalie-mota-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'),
        filemtime($theme_dir . '/assets/js/script.js'),
        true
    );

    // Charge les filtres AJAX seulement sur la page d'accueil.
    if (is_front_page()) {
        wp_enqueue_script(
            'loader-photos',
            get_template_directory_uri() . '/assets/js/loader-photos.js',
            array('jquery', 'custom-filters'),
            filemtime($theme_dir . '/assets/js/loader-photos.js'),
            true
        );

        // Transmet l'adresse AJAX et la cle de securite au JavaScript.
        wp_localize_script('loader-photos', 'loaderPhotosData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('loader_photos_nonce'),
        ]);
    }

    // Charge l'apercu de navigation sur une page photo.
    wp_enqueue_script(
        'single-photo',
        get_template_directory_uri() . '/assets/js/single-photo.js',
        array(),
        '1.0',
        true
    );

    // Charge la fenetre de contact.
    wp_enqueue_script(
        'contact-popup-js',
        get_template_directory_uri() . '/assets/js/contact-popup.js',
        array(),
        filemtime($theme_dir . '/assets/js/contact-popup.js'),
        true
    );

    // Charge l'affichage des photos en plein ecran.
    wp_enqueue_script(
        'lightbox-js',
        get_template_directory_uri() . '/assets/js/overlay-lightbox.js',
        array(),
        filemtime($theme_dir . '/assets/js/overlay-lightbox.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_assets');

// Autorise la requete AJAX pour les visiteurs connectes ou non.
add_action('wp_ajax_filter_photos', 'nathalie_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'nathalie_filter_photos');

// Filtre les photos et renvoie le HTML a afficher.
function nathalie_filter_photos() {
    // Verifie que la requete vient bien du site.
    check_ajax_referer('loader_photos_nonce', 'nonce');

    // Recupere les valeurs choisies dans les filtres.
    $categorie = isset($_POST['categorie']) ? sanitize_text_field(wp_unslash($_POST['categorie'])) : '';
    $format    = isset($_POST['format']) ? sanitize_text_field(wp_unslash($_POST['format'])) : '';
    $order     = isset($_POST['order']) ? strtoupper(sanitize_text_field(wp_unslash($_POST['order']))) : 'DESC';
    $paged     = isset($_POST['paged']) ? absint($_POST['paged']) : 1;

    // Accepte seulement les deux ordres de tri prevus.
    if (!in_array($order, ['ASC', 'DESC'], true)) {
        $order = 'DESC';
    }

    // Charge huit photographies pour la page demandee.
    $args = [
        'post_type'      => 'photographie',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
        'paged'          => $paged,
    ];

    $tax_query = [];

    // Ajoute le filtre categorie s'il est choisi.
    if (!empty($categorie)) {
        $tax_query[] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        ];
    }

    // Ajoute le filtre format s'il est choisi.
    if (!empty($format)) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        ];
    }

    // Combine les filtres choisis dans la requete.
    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    // Lance la recherche de photos.
    $query = new WP_Query($args);

    ob_start();

    // Prepare les cartes photo envoyees au navigateur.
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('parts/overlay');
        }
    } elseif (1 === $paged) {
        echo '<p class="no-photos">Aucune photo ne correspond à ces filtres.</p>';
    }

    wp_reset_postdata();

    $html = ob_get_clean();

    // Renvoie les cartes et le nombre de pages disponibles.
    wp_send_json_success([
        'html' => $html,
        'max_pages' => $query->max_num_pages,
        'paged' => $paged,
    ]);
}
