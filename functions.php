<?php

define('THEME_TEXT_DOMAIN', 'blank2016');
define('THEME_VERSION', '1.0');

/*************************************************************************
// THEME SETUP
 *************************************************************************/

// Set content width value based on the theme's design
if (!isset($content_width)) { $content_width = 960; }

// Register Theme Features
function tribalpixel_theme_features() {

    // Add theme support for Featured Images
    add_theme_support('post-thumbnails');

    // Add theme support for HTML5 Semantic Markup
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Add theme support for document Title tag
    add_theme_support('title-tag');

    // Add theme support for custom CSS in the TinyMCE visual editor
    add_editor_style();

    // Add theme support for Automatic Feed Links
    add_theme_support('automatic-feed-links');

    // Add theme support for Custom Background
    $background_args = array(
        'default-color' => 'FFFFFF',
        //'default-image' => '%1$/images/background.jpg',
        'default-repeat' => 'no-repeat',
        'default-position-x' => 'center',
            //'wp-head-callback'       => '',
            //'admin-head-callback'    => '',
            //'admin-preview-callback' => '',
    );
    add_theme_support('custom-background', $background_args);

    // Add theme support for Translation
    load_theme_textdomain(THEME_TEXT_DOMAIN, get_template_directory() . '/language');
}
add_action('after_setup_theme', 'tribalpixel_theme_features');

/******************************************************************************/
// Register Navigation Menus
/******************************************************************************/
function tribalpixel_navigation_menus() {

    $locations = array(
        'nav-primary' => __('Main Navigation', THEME_TEXT_DOMAIN),
        'nav-secondary' => __('Secondary Navigation', THEME_TEXT_DOMAIN),
    );
    register_nav_menus($locations);
}
add_action('init', 'tribalpixel_navigation_menus');

/******************************************************************************/
// Register Sidebars
/******************************************************************************/
function tribalpixel_sidebars() {

    register_sidebar( array(
        'id' => 'sidebar-primary',
        'name' => __('Sidebar primary', THEME_TEXT_DOMAIN),
    ));

    register_sidebar( array(
        'id' => 'sidebar-secondary',
        'name' => __('Sidebar Secondary', THEME_TEXT_DOMAIN),
    ));
}
add_action('widgets_init', 'tribalpixel_sidebars');

/******************************************************************************/
// Register Script
/******************************************************************************/
function tribalpixel_add_scripts() {
    
    // CSS
    wp_register_script('theme-css', get_template_directory() . '/css/theme.css', false, THEME_VERSION, false);

    // Javascripts
    wp_register_script('theme-js', get_template_directory() . '/js/theme.js', array('jquery'), THEME_VERSION, true);
}

add_action('wp_enqueue_scripts', 'tribalpixel_add_scripts');

/*************************************************************************
 // SECURITY & ANTI-HACK & CLEANING WP TRICKS 
 *************************************************************************/

// Remove fucking emoji nobody use
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove version of wordpress in head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'qtranxf_wp_head_meta_generator');

// Remove file editor in wordpress admin
define('DISALLOW_FILE_EDIT', true);
