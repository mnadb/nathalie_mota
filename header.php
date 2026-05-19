<?php
/**
 * Header Template
 *
 * @package WordPress
 * @subpackage Nathalie Mota
 * @since 1.0
 */
?>



<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@7/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7/dist/ionicons/ionicons.js"></script>
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>


    <header class="site-header">
        <nav class="main-navigation">

            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo Nathalie Mota">
            </a> 
             <!-- Menu Mobile -->
        <button
            class="burger"
            type="button"
            aria-label="Ouvrir le menu"
            aria-expanded="false"
            aria-controls="nav-menu"
            >
            <span></span>
            <span></span>
            <span></span>
        </button>
            <div class="page-contact">



            <?php
                    wp_nav_menu(array( // Affiche le menu principal
                        'theme_location' => 'header',
                        'container' => false,
                        'menu_class' => 'nav-menu',
                        'menu_id'    => 'nav-menu',
                    ));
                ?>
          
        </nav>
    </header>