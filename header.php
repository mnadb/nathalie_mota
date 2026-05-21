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
    <meta name="description" content="Découvrez le portfolio de Nathalie Mota, photographe professionnelle spécialisée dans les mariages, concerts et événements, capturant chaque instant avec émotion et authenticité.">
    <meta name="keywords" content="photographe professionnelle, événementiel, mariage, concert, portrait, paysage, reportage photo, artistique, photo concert live, cérémonie, authentique, lifestyle, soirée privée, portfolio photographe, photographe émotions, shooting photo professionnel">
    <meta name="author" content="Nathalie Mota">
    <meta name="title" content="Nathalie Mota - photographe professionnelle">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
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
