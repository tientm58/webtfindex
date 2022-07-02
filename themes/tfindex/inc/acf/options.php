<?php

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Cài đặt Thuyền',
        'menu_title'    => 'Cài đặt Thuyền',
        'menu_slug'     => 'tfindex-settings',
        'capability'    => 'edit_posts',
        'position' => '9',
        'redirect'  => false
    ));
}
