<?php

class Agency
{
    public function __construct()
    {
        add_action('init', [ $this, 'agency_custom_post_type' ]);

        add_action('widgets_init', [ $this, 'register_agencies_widget' ]);
    }

    public function agency_custom_post_type()
    {
        register_post_type( 'agency', [
            'labels' => [
                'name'               => __('Agencies', 'unite-child'),
                'singular_name'      => __('Agency', 'unite-child'),
                'add_new'            => __('Add agency', 'unite-child'),
                'add_new_item'       => __('Add new agency', 'unite-child'),
                'edit_item'          => __('Edit agency', 'unite-child'),
                'new_item'           => __('New agency', 'unite-child'),
                'view_item'          => __('View agency', 'unite-child'),
                'search_items'       => __('Search agency', 'unite-child'),
                'not_found'          => __('Agencies not found', 'unite-child'),
                'not_found_in_trash' => __('Not found in trash', 'unite-child'),
                'parent_item_colon'  => __('', 'unite-child'),
                'menu_name'          => __('Agencies', 'unite-child'),
            ],
            'public'              => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'capability_type'   => 'post',
            'hierarchical'        => false,
            'supports'            => ['title', 'editor', 'thumbnail'],
            'has_archive'         => true,
            'rewrite'             => true,
            'query_var'           => true,
        ] );
    }

    public function register_agencies_widget() {
        register_widget('AgenciesWidget');
    }

    public static function get_agencies()
    {
        $agency_query = new WP_Query([
            'post_type' => 'agency',
            'posts_per_page' => -1
        ]);

        if($agency_query->have_posts())
            return $agency_query->posts;

        return false;
    }

    public static function get_agency_url($agency_id)
    {
        return add_query_arg('agency_id', $agency_id, get_current_url());
    }

    public static function get_agency_name_by_id($agency_id)
    {
        return get_post_type($agency_id) == 'agency' ? get_the_title($agency_id) : '';
    }

    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }
}