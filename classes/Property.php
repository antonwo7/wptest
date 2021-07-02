<?php

class Property
{
    const PROPERTY_DATA_FIELD_SLUGS = [
        'property_square',
        'property_price',
        'property_address',
        'property_living',
        'property_floor',
        'property_agency'
    ];


    public function __construct()
    {
        add_action('init', [ $this, 'property_custom_post_type' ]);
        add_action('init', [ $this, 'property_type_taxonomy' ]);

        add_action( 'after_setup_theme', [ $this, 'property_thumb_size' ] );

        add_action('property_data', [ $this, 'property_data_output' ]);
        add_action('properties_list', [ $this, 'properties_list_output' ]);
        add_action('property_item', [ $this, 'properties_list_item_output' ]);
    }

    public function property_custom_post_type()
    {
        register_post_type( 'property', [
            'labels' => [
                'name'               => __('Properties', 'unite-child'),
                'singular_name'      => __('Property', 'unite-child'),
                'add_new'            => __('Add property', 'unite-child'),
                'add_new_item'       => __('Add new property', 'unite-child'),
                'edit_item'          => __('Edit property', 'unite-child'),
                'new_item'           => __('New property', 'unite-child'),
                'view_item'          => __('View property', 'unite-child'),
                'search_items'       => __('Search property', 'unite-child'),
                'not_found'          => __('Properties not found', 'unite-child'),
                'not_found_in_trash' => __('Not found in trash', 'unite-child'),
                'parent_item_colon'  => __('', 'unite-child'),
                'menu_name'          => __('Properties', 'unite-child'),
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

    public function property_type_taxonomy()
    {
        $labels = array(
            'name'                       => _x( 'Property Types', 'taxonomy general name', 'unite-child' ),
            'singular_name'              => _x( 'Property Type', 'taxonomy singular name', 'unite-child' ),
            'search_items'               => __( 'Search Property Types', 'unite-child' ),
            'popular_items'              => __( 'Popular Property Types', 'unite-child' ),
            'all_items'                  => __( 'All Property Types', 'unite-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Property Type', 'unite-child' ),
            'update_item'                => __( 'Update Property Type', 'unite-child' ),
            'add_new_item'               => __( 'Add New Property Type', 'unite-child' ),
            'new_item_name'              => __( 'New Property Type Title', 'unite-child' ),
            'separate_items_with_commas' => __( 'Separate property types with commas', 'unite-child' ),
            'add_or_remove_items'        => __( 'Add or remove property types', 'unite-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used property types', 'unite-child' ),
            'not_found'                  => __( 'No property types found.', 'unite-child' ),
            'menu_name'                  => __( 'Property Types', 'unite-child' ),
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );

        register_taxonomy('property_type', 'property', $args);
    }

    public static function get_property_data($property_id)
    {
        $property_data = [];

        $property_data_fields = get_field_objects($property_id);


        if($property_data_fields)
        {
            foreach($property_data_fields as $property_data_field)
            {
                if(in_array($property_data_field['name'], self::PROPERTY_DATA_FIELD_SLUGS))
                {
                    $property_data[$property_data_field['name']] = [
                        'label' => $property_data_field['label'],
                        'value' => $property_data_field['value']
                    ];
                }
            }
        }

        if(isset($property_data['property_agency']))
        {
            $agency_id = $property_data['property_agency']['value'];
            $property_data['property_agency']['value'] = Agency::get_agency_name_by_id($agency_id);
        }

        return $property_data;
    }

    public function property_data_output($property_id)
    {
        $property_data = self::get_property_data($property_id);

        include __DIR__ . '/../templates/property/property_data.php';
    }

    public static function get_properties($agency_id)
    {
        $properties_query_posts = get_transient("properties_query_agency_{$agency_id}");

        if($properties_query_posts === false)
        {
            $args = [
                'post_type' => 'property',
                'posts_per_page' => -1
            ];

            if(!empty($agency_id))
            {
                $args['meta_query'] = [
                    [
                        'key' => 'property_agency',
                        'value' => $agency_id,
                        'compare' => '='
                    ]
                ];
            }

            $properties_query = new WP_Query($args);

            if($properties_query->have_posts())
            {
                set_transient("properties_query_agency_{$agency_id}", $properties_query->posts);
                return $properties_query->posts;
            }

            return false;
        }

        return $properties_query_posts;
    }

    public function properties_list_output($agency_id)
    {
        $properties = self::get_properties($agency_id);

        if(!empty($properties))
        {
            include __DIR__ . '/../templates/property/properties.php';
        }
    }

    public function properties_list_item_output($property)
    {
        if(!empty($property))
        {
            include __DIR__ . '/../templates/property/property_list_item.php';
        }
    }

    public function property_thumb_size()
    {
        add_theme_support('post-thumbnails');

        if (function_exists('add_image_size'))
        {
            add_image_size('property-list-item', 500, 300, true);
        }
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