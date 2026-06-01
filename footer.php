
<!--Récupération de l'URL de la politique de confidentialité -->
<?php
$privacy_url = get_privacy_policy_url();
?>

<footer class="menu_footer">
    <ul class="menu">
        <li>
            <a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>">Mentions légales</a>
        </li>
<!-- vérification l'existance du lien -->
        <?php if ($privacy_url) : ?>
            <li>
                <a href="<?php echo esc_url($privacy_url); ?>">Vie privée</a>
            </li>
        <?php endif; ?>

        <li>
            <span>Tous droits réservés</span>
        </li>
    </ul>
   

</footer>

<?php get_template_part('parts/contact-popup'); ?>

<?php wp_footer(); ?>

</body>
</html>
