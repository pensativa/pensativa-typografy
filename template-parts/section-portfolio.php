<section class="portfolio">
  <div class="container">
    <div class="portfolio__header">
      <h2 class="portfolio__title"><?php the_field('projects_title'); ?></h2>
      <p class="portfolio__text"><?php the_field('projects_text'); ?></p>
    </div>
    <div class="portfolio__projects">
      <?php
      $cases = new WP_Query(['post_type' => 'case', 'posts_per_page' => 4]);
      while ($cases->have_posts()) : $cases->the_post(); ?>
        <div class="project">
          <a class="project__link" href="<?php the_permalink(); ?>">
            <h3 class="project__title"><?php the_title(); ?></h3>
            <div class="project__preview"><?php the_post_thumbnail('medium'); ?></div>
          </a>
          <?php
            $tags = get_the_tags();
            if ($tags) :
                echo '<ul class="project__tags">';
                foreach ($tags as $tag) {
                    echo '<li class="project__tag"><a href="' . get_tag_link($tag) . '">' . esc_html($tag->name) . '</a></li>';
                }
                echo '</ul>';
            endif;
          ?>
        </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
