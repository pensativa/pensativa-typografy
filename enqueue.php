<?php

function theme_enqueue_assets() {
    // Основные стили и скрипты
    wp_enqueue_style('theme-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0');
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0', true);

    // Отдельная логика для кейсов
    if (is_singular('cases')) {
        wp_enqueue_style('cases-style', get_template_directory_uri() . '/assets/css/cases.css', [], '1.0');
        wp_enqueue_script('cases-script', get_template_directory_uri() . '/assets/js/cases.js', [], '1.0', true);
    }

    // Шаблон страницы портфолио
    if (is_singular('case')) {
        wp_enqueue_style('portfolio-style', get_template_directory_uri() . '/assets/css/portfolio.css', [], '1.1');
        wp_enqueue_script('portfolio-script', get_template_directory_uri() . '/assets/js/portfolio.js', [], '1.1', true);
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');
