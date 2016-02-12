<?php

if(!defined('THEME_VERSION')) {
    $theme = wp_get_theme();
    define('THEME_VERSION', $theme->Version);
}

/*************************************************************************
// THEME SETTINGS PAGE
 *************************************************************************/
require_once 'class/themeSettings.php';
$settings = array(

    'options_section_1' => array(
        array(
            'type'      => 'text',
            'id'        => 'field-id-1',
            'title'     => 'Label ici', 
            'value'     => 'Valeur de l\'option ici'
        ),
        array(
            'type'      => 'text',
            'id'        => 'field-id-2',
            'title'     => 'Label ici', 
            'value'     => 'Valeur de l\'option ici'
        ),
        
    ),
    
    'options_section_2' => array(

    )    
    /*
 
    '{option_section_id}' => array (
        'type'=>'{option_section_type}',
        'options' => array( 
            '{option_id}'=>'{option_value}', 
            '{option_id}'=>'{option_value}', 
        ) 
    )
    
    'colors' => array(
        'type'=>'picker', 
        'options' => array( 'primary'=>'#CC0000' )
    ),

    'layout' => array( 
        'type' => 'radio', 
        'options' => array( 
            'responsive'=>'Responsive', 
            'fixed-960'=>'Fixed 960px'
        )
    ),
  
    'sidebars' => array(
        'type' => 'text',
        'options' => array(
            'sidebar-primary' => '', 
            'sidebar-secondary' => array('label'=>'mon label ici', 'default'=>'valeur par default')
        )
    )
 */ 
);
$test = new themeSettings('Demo settings page', 'demo', $settings);
$test2 = new themeSettings('Demo settings page2', 'demo2', $settings);

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
    load_theme_textdomain('blank2016', get_template_directory() . '/language');
}
add_action('after_setup_theme', 'tribalpixel_theme_features');

/******************************************************************************/
// NAVIGATION MENUS
/******************************************************************************/
function tribalpixel_navigation_menus() {

    $locations = array(
        'nav-primary' => __('Main Navigation', 'blank2016'),
        'nav-secondary' => __('Secondary Navigation', 'blank2016'),
    );
    register_nav_menus($locations);
}
add_action('init', 'tribalpixel_navigation_menus');

/******************************************************************************/
// SIDEBARS
/******************************************************************************/
function tribalpixel_register_sidebars() {

    register_sidebar( array(
        'id' => 'sidebar-primary',
        'name' => __('Sidebar primary', 'blank2016'),
    ));

    register_sidebar( array(
        'id' => 'sidebar-secondary',
        'name' => __('Sidebar Secondary', 'blank2016'),
    ));
}
add_action('widgets_init', 'tribalpixel_register_sidebars');

/******************************************************************************/
// REGISTER CSS/JS/EXTRA SCRIPTS
/******************************************************************************/
function tribalpixel_register_scripts() {
    
    // CSS
    wp_register_script('theme-css', get_template_directory() . '/css/theme.css', false, THEME_VERSION, false);

    // Javascripts
    wp_register_script('theme-js', get_template_directory() . '/js/theme.js', array('jquery'), THEME_VERSION, true);
}

add_action('wp_enqueue_scripts', 'tribalpixel_register_scripts');

/******************************************************************************/
// FILTERS
/******************************************************************************/
function tribalpixel_title_separator($sep) {
    $sep = "|";
    return $sep;
}
add_filter( 'document_title_separator', 'tribalpixel_title_separator' );

/*************************************************************************
 // SECURITY/ANTI-HACK & CLEANING WP TRICKS 
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
