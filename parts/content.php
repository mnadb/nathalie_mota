 <?php // champ ACF "photo"
    $image = get_field('photo');
      ?>
      <div class="photo">
      <img 
        src="<?php echo esc_url($image['url']); ?>" 
        alt="<?php echo esc_attr($image['alt']); ?>"
      />
      <div class="overlay">
            <div class="un">▶️</div>
            <div class="deux"><a href="<?php the_permalink(); ?>">👁️</a>a></div>
            <div class="trois"><p><?php the_title(); ?></p><p>TITRE 2</p></div>
      </div>
      </div>