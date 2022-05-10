<?php
include_once 'includes/customizerAdjustments.php';

const NLS_FLOW_ELEMENTS = 3;
const NLS_FBF_FOOTER_LOGO = 'nls_fbf_footer_logo';

/**
 * Add child theme styles
 */
add_action('wp_enqueue_scripts', 'nls_fbf_theme_enqueue_styles', 20);

function nls_fbf_theme_enqueue_styles()
{
    $parent_style = 'twenty-twenty-one-style';

    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style-rtl.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}


/**
 * Add child theme translations
 */
/**
 * Loads the child theme textdomain.
 */
function nls_fbf_child_theme_setup()
{
    load_child_theme_textdomain('nls_fbf', get_stylesheet_directory() . '/languages/');
}

add_action('after_setup_theme', 'nls_fbf_child_theme_setup');
