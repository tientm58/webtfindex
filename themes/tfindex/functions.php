<?php

/**
 * Theme functions and definitions
 *
 * @author phuonghx
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define( 'TFINDEX_THEME_DIR', get_stylesheet_directory() );
define( 'TFINDEX_THEME_URI', get_stylesheet_directory_uri() );


function tfindex_register_scripts(){
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css');

    wp_enqueue_style( 'tfindex-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ));

    wp_enqueue_script( 'tfindex-script', get_stylesheet_directory_uri() . '/assets/js/script.js', [ 'jquery' ], false, true );

}
add_action( 'wp_enqueue_scripts', 'tfindex_register_scripts' );


/**
 * functions.php
 */
require_once (TFINDEX_THEME_DIR . '/inc/functions.php');
