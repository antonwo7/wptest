<?php

function custom_enqueue_scripts()
{
    wp_enqueue_style('unite_child_styles', get_stylesheet_directory_uri() . '/assets/css/main.css', false, null);
}

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts', 100);