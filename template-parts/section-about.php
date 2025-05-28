<?php
// vars
$list1 = get_field('about_list');
$list2 = get_field('about_list_2');
$list3 = get_field('about_list_3');

?>

<section class="about">
    <div class="container">
        <h2 class="about__title"><?php the_field('about_title'); ?></h2>
        <ol class="about__list">
            <li class="about__item">
                <?php if( $list1 ): ?>
                    <h3 class="about__subtitel"><?php echo $list1['title'] ?></h3>
                    <p class="about__text"><?php echo $list1['description'] ?></p>
                <?php endif; ?>
            </li>
            <li class="about__item">
                <?php if( $list2 ): ?>
                    <h3 class="about__subtitel"><?php echo $list2['title'] ?></h3>
                    <p class="about__text"><?php echo $list2['description'] ?></p>
                <?php endif; ?>
            </li>
            <li class="about__item">
                <?php if( $list3 ): ?>
                    <h3 class="about__subtitel"><?php echo $list3['title'] ?></h3>
                    <p class="about__text"><?php echo $list3['description'] ?></p>
                <?php endif; ?>
            </li>
        </ol>
    </div>
</section>