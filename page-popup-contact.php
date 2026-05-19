<?php
/*
Template Name: Contact Popup
*/
?>
<?php
get_yyyheader();
?>

<p>Je voir bleu</p>
<div class="page-contact">
 

  <div id="contact-popup" class="popup-overlay" aria-hidden="true">
    <div class="popup-content" role="dialog" aria-modal="true" aria-labelledby="contact-popup-title">
      <button id="close-contact-popup" class="popup-close" type="button" aria-label="Fermer">×</button>

      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Contact-header.png' ); ?>" alt="titre modale">

      <div class="popup-form">
        <?php echo do_shortcode('[wpforms id="150" title="false" description="false" ajax="true"]'); ?>
      </div>
    </div>
  </div>



<?php get_footer(); ?> 
