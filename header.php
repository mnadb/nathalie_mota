<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
  <title><?php bloginfo('name'); ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <nav class="main-navigation">

        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            <img 
                src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" 
                alt="Logo Nathalie Mota"
            >
        </a>

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
  <main id="primary" class="site-main">
      <section class="hero">
        <img src="http://localhost:8080/nathalie_Mota/wp-content/uploads/2026/05/nathalie-11-scaled.jpeg" alt="Soirée dansante" />
        <h1>PHOTOGRAPHE EVENT</h1>
      </section>
