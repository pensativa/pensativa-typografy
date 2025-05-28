<?php
function mytheme_setup() {
  // Регистрируем меню
  register_nav_menus([
    'main_menu' => 'Главное меню',
  ]);
}
add_action('after_setup_theme', 'mytheme_setup');

function mytheme_assets() {
  wp_enqueue_style('mytheme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_assets');

function register_case_post_type() {
  register_post_type('case', [
    'labels' => [
      'name' => 'Работы',
      'singular_name' => 'Работа'
    ],
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'portfolio'],
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    'taxonomies' => ['post_tag'],
    'menu_icon' => 'dashicons-portfolio',
  ]);
}
add_action('init', 'register_case_post_type');
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');

require get_template_directory() . '/enqueue.php';