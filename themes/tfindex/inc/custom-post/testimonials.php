<?php

if ( ! function_exists('testimonials_post_type') ) {

// Register Custom Post Type
    function testimonials_post_type() {

        $labels = array(
            'name'                  => _x( 'Testimonials', 'Post Type General Name', 'tfindex' ),
            'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'tfindex' ),
            'menu_name'             => __( 'Testimonials', 'tfindex' ),
            'name_admin_bar'        => __( 'Testimonials', 'tfindex' ),
            'archives'              => __( 'Item Archives', 'tfindex' ),
            'attributes'            => __( 'Item Attributes', 'tfindex' ),
            'parent_item_colon'     => __( 'Parent Item:', 'tfindex' ),
            'all_items'             => __( 'All Items', 'tfindex' ),
            'add_new_item'          => __( 'Add New Item', 'tfindex' ),
            'add_new'               => __( 'Add New', 'tfindex' ),
            'new_item'              => __( 'New Item', 'tfindex' ),
            'edit_item'             => __( 'Edit Item', 'tfindex' ),
            'update_item'           => __( 'Update Item', 'tfindex' ),
            'view_item'             => __( 'View Item', 'tfindex' ),
            'view_items'            => __( 'View Items', 'tfindex' ),
            'search_items'          => __( 'Search Item', 'tfindex' ),
            'not_found'             => __( 'Not found', 'tfindex' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'tfindex' ),
            'featured_image'        => __( 'Featured Image', 'tfindex' ),
            'set_featured_image'    => __( 'Set featured image', 'tfindex' ),
            'remove_featured_image' => __( 'Remove featured image', 'tfindex' ),
            'use_featured_image'    => __( 'Use as featured image', 'tfindex' ),
            'insert_into_item'      => __( 'Insert into item', 'tfindex' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'tfindex' ),
            'items_list'            => __( 'Items list', 'tfindex' ),
            'items_list_navigation' => __( 'Items list navigation', 'tfindex' ),
            'filter_items_list'     => __( 'Filter items list', 'tfindex' ),
        );
        $args = array(
            'label'                 => __( 'Testimonial', 'tfindex' ),
            'description'           => __( 'What client say?', 'tfindex' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
//			'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-format-quote',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => false,
            'capability_type'       => 'page',
        );
        register_post_type( 'testimonials', $args );

    }
    add_action( 'init', 'testimonials_post_type', 0 );

}
