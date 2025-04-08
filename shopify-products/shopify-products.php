<?php
/**
 * Plugin Name: Shopify Products Display
 * Description: Displays Shopify products using shortcode and custom post type.
 * Version: 1.0
 * Author: Vishnu Gupta
 */

// Register Custom Post Type
function sp_register_shopify_product_post_type() {
    register_post_type('shopify_product', [
        'labels' => [
            'name' => 'Shopify Products',
            'singular_name' => 'Shopify Product',
        ],
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true, // Required for REST API
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-cart',
    ]);
}
add_action('init', 'sp_register_shopify_product_post_type');

// Enqueue JS & CSS
function sp_enqueue_assets() {
    wp_enqueue_style(
        'shopify-products-css',
        plugin_dir_url(__FILE__) . 'assets/shopify-products.css',
        [],
        '1.0'
    );

    wp_enqueue_script(
        'shopify-products-js',
        plugin_dir_url(__FILE__) . 'assets/shopify-products.js',
        [],
        '1.0',
        true
    );

    // Pass REST API URL to JS
    wp_localize_script('shopify-products-js', 'sp_data', [
        'api_url' => home_url('/wp-json/wp/v2/shopify_product')
    ]);
}
add_action('wp_enqueue_scripts', 'sp_enqueue_assets');

// Shortcode Output
function sp_render_shopify_products_shortcode() {
    ob_start(); ?>
    <div id="shopify-products-container" class="shopify-grid">
        <div id="products-placeholder">Loading...</div>
    </div>
    <?php return ob_get_clean();
}
add_shortcode('shopify_products', 'sp_render_shopify_products_shortcode');


