<?php

function custom_enqueue_scripts()
{
    wp_enqueue_style('unite_bootstrap_styles', get_template_directory_uri() . '/inc/css/bootstrap.min.css', false, null);
    wp_enqueue_style('unite_child_styles', get_stylesheet_directory_uri() . '/assets/css/main.css', false, null);
}

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts', 100);