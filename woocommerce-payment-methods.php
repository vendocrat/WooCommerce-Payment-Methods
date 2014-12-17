<?php
/* Plugin Name: WooCommerce Payment Methods
 * Plugin URI:  http://vendocr.at/
 * Description: <strong>Easily display your accepted payment methods from WooCommerce.</strong> Handcrafted with &hearts; by <a href='http://vendocr.at/'>vendocrat</a> in Vienna.
 * Version:     1.0.0
 * Author:      vendocrat
 * Author URI:  http://vendocr.at/
 * License:     vendocrat Split License
 * License URI: http://vendocr.at/legal/licenses
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// check dependencies
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
	return;

// require classes
require_once( 'classes/class-wc-payment-methods.php' );

global $vendocrat_wc_payment_methods;
$vendocrat_wc_payment_methods = new vendocrat_WC_Payment_Methods( __FILE__ );
$vendocrat_wc_payment_methods->version = '1.0.0';

/*
 * E fatto!
 */