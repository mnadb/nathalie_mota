<?php

// enregistrer le menu
function register_my_menu() {
    register_nav_menu( 'header' , 'En tête du menu' );
    register_nav_menu( 'footer' , 'Pied de page' );
}
add_action( 'after_setup_theme', 'register_my_menu' );


function nathalie_mota_enqueue_assets() {

    // Style principal du thème WordPress : style.css à la racine
    wp_enqueue_style(
        'nathalie-mota-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // Style compilé depuis Sass : sass/style.css
    wp_enqueue_style(
        'nathalie-mota-main-style',
        get_template_directory_uri() . '/assets/sass/style.css',
        array('nathalie-mota-style'),
        '1.0'
    );

    // JavaScript : script.js à la racine
    wp_enqueue_script(
        'nathalie-mota-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array(),
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_assets');
