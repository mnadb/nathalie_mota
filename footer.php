</main>

 <footer class="menu_footer">
         <?php
        wp_nav_menu(array(
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'menu',
        ));
    ?>



<?php wp_footer(); ?>
</footer>


</body>
</html>