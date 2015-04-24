<?php
/* Plugin Name: WooCommerce Payment Methods
 * Plugin URI:  https://vendocr.at/
 * Description: <strong>Easily display your accepted payment methods from WooCommerce.</strong> Handcrafted with &hearts; by <a href='https://vendocr.at/'>vendocrat</a> in Vienna.
 * Version:     1.1.2
 * Author:      vendocrat
 * Author URI:  https://vendocr.at/
 * License:     vendocrat Split License
 * License URI: https://vendocr.at/legal/licenses
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// require classes
require_once( 'classes/class-wc-payment-methods.php' );

global $vendocrat_wc_payment_methods;
$vendocrat_wc_payment_methods = new vendocrat_WC_Payment_Methods( __FILE__ );
$vendocrat_wc_payment_methods->version = '1.1.2';

/*
 * E fatto!
 */