<?php

// enregistrer le menu //
function register_my_menu() {
    register_nav_menu( 'header' , 'En tête du menu' );
    register_nav_menu( 'footer' , 'Pied de page' );
}
add_action( 'after_setup_theme', 'register_my_menu' );


function nathalie_mota_enqueue_assets() {
    $theme_dir = get_template_directory();

    // Style principal du thème WordPress : style.css à la racine //
    wp_enqueue_style(
        'nathalie-mota-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // Select2 : transforme les <select> en menus personnalisables.
    wp_enqueue_style(
        'select2-style',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        array(),
        '4.1.0-rc.0'
    );

    // Style compilé depuis Sass : sass/style.css//
    wp_enqueue_style(
        'nathalie-mota-main-style',
        get_template_directory_uri() . '/assets/sass/style.css',
        array('nathalie-mota-style', 'select2-style'),
        filemtime($theme_dir . '/assets/sass/style.css')
    );

    // JavaScript : script.js à la racine
    wp_enqueue_script(
        'nathalie-mota-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'),
        filemtime($theme_dir . '/assets/js/script.js'),
        true
    );

    // Select2 : bibliothèque utilisée pour les filtres de la page d'accueil.
    wp_enqueue_script(
        'select2-script',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        array('jquery'),
        '4.1.0-rc.0',
        true
    );

    // Initialisation simple de Select2 sur les filtres.
    wp_enqueue_script(
        'filters-select2',
        get_template_directory_uri() . '/assets/js/filters-select2.js',
        array('jquery', 'select2-script'),
        filemtime($theme_dir . '/assets/js/filters-select2.js'),
        true
    );
    //single-photo //
    wp_enqueue_script(
        'single-photo',
        get_template_directory_uri() . '/assets/js/single-photo.js',
        array(),
        '1.0',
        true
    );
    // popup //
     wp_enqueue_script(
        'contact-popup-js',
        get_template_directory_uri() . '/assets/js/contact-popup.js',
        array(),
        filemtime($theme_dir . '/assets/js/contact-popup.js'),
        true
    );
    // Overlay-lightbox //
   
    wp_enqueue_script(
        'lightbox-js',
        get_template_directory_uri() . '/assets/js/overlay-lightbox.js',
        array(),
        filemtime($theme_dir . '/assets/js/overlay-lightbox.js'),
        true
    );
}

add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_assets');
