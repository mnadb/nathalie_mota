<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Playpen+Sans+Hebrew:wght@100..800&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet" />

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