<div id="contact-popup" class="popup-overlay" aria-hidden="true">
    <div class="popup-content" role="dialog" aria-modal="true" aria-labelledby="contact-popup-title">
        <button id="close-contact-popup" class="popup-close" type="button" aria-label="Fermer">×</button>

        <h2 id="contact-popup-title" class="screen-reader-text">Contact</h2>

        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Contact-header.png'); ?>" alt="">

        <div class="popup-form">
            <?php echo do_shortcode('[wpforms id="150" title="false" description="false" ajax="true"]'); ?>
        </div>
    </div>
</div>
