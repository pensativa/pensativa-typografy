<?php get_header(); ?>

<main class="case">

  <section class="case__hero">
    <div class="container">
      <h1 class="case__title"><?php the_title(); ?></h1>
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
  </section>

  <section class="case__intro">
    <div class="container">
      <h2><?php the_field('goal_title'); ?></h2>
      <p><?php the_field('goal_text'); ?></p>
    </div>
  </section>

    <section class="case-solution">
      <div class="container">
        <h2><?php the_field('steps_title'); ?></h2>
        <?php for ($i = 1; $i <= 5; $i++): 
            $title = get_field("solution_step_{$i}_title");
            $desc = get_field("solution_step_{$i}_description");
            if ($title || $desc): ?>
            <div class="step">
                <?php if ($title): ?><h3><?php echo esc_html($title); ?></h3><?php endif; ?>
                <?php if ($desc): ?><p><?php echo esc_html($desc); ?></p><?php endif; ?>
            </div>
        <?php endif; endfor; ?>
      </div>
    </section>

    <section class="case-gallery">
      <div class="container">
        <h2><?php the_field('gallery_title'); ?></h2>
        <div class="gallery">
          <div class="gallery__container">
            <?php for ($i = 1; $i <= 4; $i++): 
            $image = get_field("result_image_{$i}");
            if ($image): ?>
                <img class="gallery__image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
            <?php endif; endfor; ?>
          </div>
          <div class="gallery__left"></div>
          <div class="gallery__right"></div>
          <div class="gallery__dots"></div>
        </div>
      </div>
    </section>

  <section class="case-back section-padding">
    <div class="container">
      <a href="<?php echo get_post_type_archive_link('case'); ?>" class="button button--secondary"><?php the_field('case_back'); ?></a>
    </div>
  </section>

</main>

<?php get_footer(); ?>
