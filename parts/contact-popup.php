<div id="contact-popup" class="popup-overlay" aria-hidden="true">
    <div class="popup-content" role="dialog" aria-modal="true" aria-labelledby="contact-popup-title">
        <button id="close-contact-popup" class="popup-close" type="button" aria-label="Fermer"></button>

        <!-- Image du titre CONTACT : elle est volontairement plus large que la popup pour être coupée comme la maquette. -->
        <img
            id="contact-popup-title"
            class="img-contact"
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Contact-header.png'); ?>"
            alt="Contact"
        >

        <!-- Formulaire WPForms : on garde le shortcode pour pouvoir modifier les champs dans WordPress. -->
        <div class="popup-form">
            <?php echo do_shortcode('[wpforms id="150" title="false" description="false" ajax="true"]'); ?>
        </div>
    </div>
</div>
