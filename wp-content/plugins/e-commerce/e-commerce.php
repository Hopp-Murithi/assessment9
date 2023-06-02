<?php
/**
 * @package E-commerce
 */

/**
 * Plugin Name: Ecommerce API
 * Description: Provides REST API endpoints for managing e-commerce products.
 * Version: 1.0.0
 * Author: Hope Murithi
 */

// Checking security
defined('ABSPATH') or die('You have been hacked!');

// Class to create products table and endpoints 
class EcommerceAPI {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_api_endpoints'));
        register_activation_hook(__FILE__, array($this, 'activate'));
    }

    // Activate plugin
    public function activate() {
        $this->create_products_table();
    }

    // Create products table
    public function create_products_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'products';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id int(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            content varchar(255) NOT NULL,
            price decimal(10, 2) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Register endpoints
    public function register_api_endpoints() {
        register_rest_route('ecommerce-api/v1', '/products', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_product'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('ecommerce-api/v1', '/products/(?P<id>\d+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_product'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('ecommerce-api/v1', '/products/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'fetch_product'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('ecommerce-api/v1', '/products/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_product'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('ecommerce-api/v1', '/token', array(
            'methods' => 'POST',
            'callback' => array($this, 'generate_bearer_token'),
            'permission_callback' => '__return_true',
        ));
    }

    // Callback function for creating a product
    public function create_product($request) {
        $product_data = $request->get_params();

        if (current_user_can('edit_posts')) {
       
            $product_id = wp_insert_post(array(
                'post_type' => 'product',
                'post_title' => $product_data['title'],
                'post_content' => $product_data['content'],
                'post_status' => 'publish',
            ));

            if (!is_wp_error($product_id)) {
                // Set the product price using custom field
                update_post_meta($product_id, 'price', $product_data['price']);

                $response = array(
                    'status' => 'success',
                    'message' => 'Product created successfully.',
                    'product_id' => $product_id,
                    'title' => $product_data['title'],
                    'content' => $product_data['content'],
                    'price' => $product_data['price'],
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to create product.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'User does not have permission to create a product.',
            );
        }

        return rest_ensure_response($response);
    }

    // Callback function for updating a product
    public function update_product($request) {
        $product_id = $request->get_param('id');
        $product_data = $request->get_params();
        $updated = wp_update_post(array(
            'ID' => $product_id,
            'post_title' => $product_data['title'],
            'post_content' => $product_data['content'],
        ));

        if (!is_wp_error($updated)) {
            update_post_meta($product_id, 'price', $product_data['price']);
            $response = array(
                'status' => 'success',
                'message' => 'Product updated successfully.',
                'product_id' => $product_id,
                'title' => $product_data['title'],
                'content' => $product_data['content'],
                'price' => $product_data['price'],
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to update product.',
            );
        }

        return rest_ensure_response($response);
    }

    // Callback function for getting a product
    public function fetch_product($request) {
        $product_id = $request->get_param('id');
        $product = get_post($product_id);

        if ($product && $product->post_type === 'product') {
            $price = get_post_meta($product_id, 'price', true);
            $response = array(
                'status' => 'success',
                'product' => array(
                    'id' => $product->ID,
                    'title' => $product->post_title,
                    'content' => $product->post_content,
                    'price' => $price,
                ),
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Product not found.',
            );
        }

        return rest_ensure_response($response);
    }

    // Callback function for deleting a product
    public function delete_product($request) {
        $product_id = $request->get_param('id');
        $deleted = wp_delete_post($product_id, true);

        if ($deleted) {
            $response = array(
                'status' => 'success',
                'message' => 'Product deleted successfully.',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to delete product.',
            );
        }

        return rest_ensure_response($response);
    }

    // Callback function to generate a  token
    public function generate_bearer_token($request) {
        $username = $request->get_param('username');
        $password = $request->get_param('password');

        $user = wp_authenticate($username, $password);

        if (!is_wp_error($user) && $user->ID !== 0) {
            $token = wp_generate_auth_cookie($user->ID, 86400, 'auth');
            $response = array(
                'status' => 'success',
                'token' => $token,
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'User authentication failed.',
            );
        }

        return rest_ensure_response($response);
    }
}

$ecommerceAPI = new EcommerceAPI();
