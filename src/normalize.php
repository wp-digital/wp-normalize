<?php

namespace Innocode\WPNormalize;

function remove_custom_fields_support() {
    foreach ( get_post_types() as $post_type ) {
        remove_post_type_support( $post_type, 'custom-fields' );
    }
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\remove_custom_fields_support', 1 );

function remove_custom_fields_meta_box() {
    foreach ( get_post_types() as $post_type ) {
        remove_meta_box( 'postcustom', $post_type, 'normal' );
    }
}

add_action( 'do_meta_boxes', __NAMESPACE__ . '\remove_custom_fields_meta_box', 1 );

function unregister_default_widgets() {
    global $wp_widget_factory;

    foreach ( array_keys( $wp_widget_factory->widgets ) as $widget ) {
        unregister_widget( $widget );
    }
}

add_action( 'widgets_init', __NAMESPACE__ . '\unregister_default_widgets', 1 );

function remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}

add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\remove_dashboard_widgets', 1 );

/**
 * @param array  $args
 * @param string $post_type
 * @return array
 */
function post_type_defaults( array $args, $post_type ) {
    if ( $post_type == 'post' ) {
        $args['show_in_nav_menus'] = false;
    }

    return $args;
}

add_filter( 'register_post_type_args', __NAMESPACE__ . '\post_type_defaults', 1, 2 );

/**
 * @param array  $args
 * @param string $taxonomy
 * @return array
 */
function taxonomy_defaults( array $args, $taxonomy ) {
    if ( $taxonomy == 'post_tag' ) {
        $args['show_in_nav_menus'] = false;
    }

    return $args;
}

add_filter( 'register_taxonomy_args', __NAMESPACE__ . '\taxonomy_defaults', 1, 2 );

function remove_admin_bar_bump_cb() {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

add_action( 'admin_bar_init', __NAMESPACE__ . '\remove_admin_bar_bump_cb', 1 );

/**
 * @return string
 */
function excerpt_more() {
    return '&hellip;';
}

add_filter( 'excerpt_more', __NAMESPACE__ . '\excerpt_more', 1 );

/**
 * @param array $classes
 * @return array
 */
function disable_login_page_default_ui( array $classes ) {
    if ( false !== ( $key = array_search( 'wp-core-ui', $classes ) ) ) {
        unset( $classes[ $key ] );
    }

    return $classes;
}

add_filter( 'login_body_class', __NAMESPACE__ . '\disable_login_page_default_ui', 1 );

function add_theme_supports() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script',
    ] );
    add_theme_support( 'title-tag' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\add_theme_supports', 1 );

function clear_head() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\clear_head', 1 );

function remove_headers() {
    remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\remove_headers', 1 );

/**
 * @param array $settings
 * @return array
 */
function tiny_mce_settings( array $settings ) {
    $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';

    return $settings;
}

add_action( 'tiny_mce_before_init', __NAMESPACE__ . '\tiny_mce_settings', 1 );

function check_browser_js_support() {
    include dirname( __DIR__ ) . '/public/check-js-support.php';
}

add_action( 'wp_head', __NAMESPACE__ . '\check_browser_js_support', 1 );

/**
 * @return string
 */
function login_header_url() {
    return home_url( '/' );
}

add_filter( 'login_headerurl', __NAMESPACE__ . '\login_header_url' );

/**
 * @return string
 */
function login_header_text() {
    return get_bloginfo( 'name' );
}

add_filter( 'login_headertext', __NAMESPACE__ . '\login_header_text' );

/**
 * @return string[]
 */
function allowed_block_types() {
    return [
        'core/paragraph',
        'core/image',
        'core/heading',
        'core/list',
        'core/quote',
        'core/shortcode',
        'core/button',
        'core/buttons',
        'core/columns',
        'core/column',
        'core/embed',
        'core/file',
        'core/group',
        'core/media-text',
        'core/missing',
        'core/more',
        'core/preformatted',
        'core/pullquote',
        'core/separator',
        'core/block',
        'core/social-links',
        'core/social-link',
        'core/spacer',
        'core/subhead',
        'core/table',
        'core/text-columns',
        'core/video',
    ];
}

add_filter( 'allowed_block_types', __NAMESPACE__ . '\allowed_block_types' );

function enqueue_block_editor_assets() {
    // Domain mapping processes mu-plugins directory wrong.
    $has_domain_mapping = remove_filter( 'plugins_url', 'domain_mapping_plugins_uri', 1 );

    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $script_url = plugins_url( "public/js/blocks$suffix.js", INNOCODE_NORMALIZE_FILE );

    if ( $has_domain_mapping ) {
        add_filter( 'plugins_url', 'domain_mapping_plugins_uri', 1 );
    }

    wp_enqueue_script(
        'innocode-normalize-blocks',
        $script_url,
        [ 'wp-edit-post' ],
        INNOCODE_NORMALIZE_VERSION,
        true
    );

    $allowed_embed_variations = apply_filters( 'innocode_normalize_allowed_embed_block_variations', [
        'youtube',
        'vimeo',
    ] );

    wp_add_inline_script(
        'innocode-normalize-blocks',
        sprintf(
            'var innocodeNormalizeAllowedEmbedBlockVariations = %s;',
            json_encode( $allowed_embed_variations )
        ),
        'before'
    );
}

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );
