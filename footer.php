 <footer class="menu_footer">
         <?php
        wp_nav_menu(array(
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'menu',
        ));
    ?>
<?php get_template_part('parts/contact-popup'); ?>

<?php wp_footer(); ?>
</footer>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
