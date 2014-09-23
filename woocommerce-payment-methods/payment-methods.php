<?php
/**
/* Plugin Name: WooCommerce Payment Methods
 * Plugin URI:  http://vendocr.at/
 * Description: <strong>Easily display your accepted payment methods from WooCommerce.</strong> Handcrafted with &hearts; by <a href='http://vendocr.at/'>vendocrat</a> in Vienna.
 * Version:     0.2.2
 * Author:      vendocrat
 * Author URI:  http://vendocr.at/
 * License:     GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
	return;

if ( ! class_exists( 'vendocrat_Woo_Payment_Methods' ) ) :

class vendocrat_Woo_Payment_Methods {

	public $payment_methods;

	/**
	 * Constructor
	 *
	 * @since 2014-08-15
	 * @version 2014-09-22
	 **************************************************/
	function __construct() {
		define( 'PAYMENT_METHODS_DIR', plugin_dir_path( __FILE__ ) );
		define( 'PAYMENT_METHODS_URI', plugin_dir_url( __FILE__ ) );

		define( 'PAYMENT_METHODS_CSS_URI', trailingslashit( PAYMENT_METHODS_URI . 'assets/css' ) );
		define( 'PAYMENT_METHODS_IMG_URI', trailingslashit( PAYMENT_METHODS_URI . 'assets/img' ) );

		$this->load_functions();
		$this->load_classes();

		// load text domain
		add_action( 'plugins_loaded', array( &$this, 'load_plugin_textdomain' ) );

		// wirt payment methods array
		add_action( 'plugins_loaded', array( &$this, 'payment_methods' ) );

		// scripts and styles
		if ( ! is_admin() ) :
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		endif;

		// register widgets
		add_action( 'widgets_init', array( &$this, 'register_widgets' ) );

		// add shortcode
		add_shortcode( 'v_woo_payment_methods', array( &$this, 'get_payment_methods' ) );
	}

	/**
	 * Load theme textdomain
	 *
	 * @return void
	 * 
	 * @since 2014-09-08
	 * @version 2014-09-08
	 **************************************************/
	static function load_plugin_textdomain() {
		load_plugin_textdomain( 'payment-methods', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Override some WooCommerce plugin functionality
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function load_functions() {}

	/**
	 * Override some WooCommerce plugin functionality
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function load_classes() {}

	/**
	 * Enqueue Styles
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-21
	 **************************************************/
	function enqueue_styles() {
		if ( ! wp_style_is( 'vendocrat-paymentfont', 'registered' ) ) {
			wp_register_style( 'vendocrat-paymentfont', PAYMENT_METHODS_CSS_URI .'paymentfont.min.css', array(), false, 'all' );
		}
		wp_enqueue_style( 'vendocrat-paymentfont' );

		wp_register_style( 'payment-methods', PAYMENT_METHODS_CSS_URI .'payment-methods.css', array(), false, 'all' );
		wp_enqueue_style( 'payment-methods' );
	}

	/**
	 * Enqueue Scripts
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function enqueue_scripts() {}

	/**
	 * Register Widgets
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-08
	 **************************************************/
	function register_widgets() {
		require_once PAYMENT_METHODS_DIR .'classes/class-widget-payment-methods.php';
		register_widget( 'vendocrat_Widget_Payment_Methods' );
	}


	/**
	 * Payment Methods array
	 *
	 * @return void
	 *
	 * @since 2014-09-21
	 * @version 2014-09-22
	 **************************************************/
	function payment_methods() {
		$this->payment_methods = array(
			'amazon'			=> 'Amazon',
			'american-express'	=> 'American Express',
			'atm'				=> 'ATM',
			'bank-transfer'		=> __( 'Bank Transfer', 'payment-methods' ),
			'bankomat'			=> 'Bankomat',
			'bitcoin'			=> 'Bitcoin',
			'braintree'			=> 'Braintree',
			'carta-si'			=> 'Carta Si',
			'cash'				=> __( 'Cash', 'payment-methods' ),
			'cash-on-delivery'	=> __( 'Cash on Delivery', 'payment-methods' ),
			'cb'				=> 'CB',
			'cirrus'			=> 'Cirrus',
		//	'cheque'			=> __( 'Pay with Cheque', 'payment-methods' ),
			'clickandbuy'		=> 'ClickAndBuy',
			'credit-card'		=> 'Credit Card',
			'diners'			=> 'Diners Club',
			'discover'			=> 'Discover',
			'ec'				=> 'EC (Electronic Cash)',
			'eps'				=> 'Eps',
			'fattura'			=> __( 'Invoice', 'payment-methods' ),
			'facture'			=> __( 'Invoice', 'payment-methods' ),
			'flattr'			=> 'Flattr',
			'giropay'			=> 'Giropay',
			'gittip'			=> 'Gittip',
			'google-wallet'		=> 'Google Wallet',
			'ideal'				=> 'Ideal',
			'invoice'			=> __( 'Invoice', 'payment-methods' ),
			'jcb'				=> 'JCB',
			'maestro'			=> 'Maestro',
			'mastercard'		=> 'Mastercard',
			'mastercard-securecode' => 'Mastercard Securecode',
			'ogone'				=> 'Ogone',
			'paybox'			=> 'PayBox',
			'paylife'			=> 'Paylife',
			'paypal'			=> 'PayPal',
			'paysafecard'		=> 'paysafecard',
			'postepay'			=> 'postepay',
			'quick'				=> 'Quick',
			'invoice'			=> __( 'Invoice', 'payment-methods' ),
			'ripple'			=> 'Ripple',
			'skrill'			=> 'Skrill',
			'sofort'			=> 'SofortÜberweisung',
			'square'			=> 'Square',
			'stripe'			=> 'Stripe',
			'truste'			=> 'Truste',
			'unionpay'			=> 'Unionpay',
			'verified-by-visa'	=> 'Verified By Visa',
			'verisign'			=> 'Verisign',
			'visa'				=> 'Visa',
			'visa-electron'		=> 'Visa Electron',
			'western-union'		=> 'Western Union',
			'wirecard'			=> 'Wirecard',
		);
	}

	/**
	 * Woo Accepted Payment Methods
	 *
	 * @since 2014-09-07
	 * @version 2014-09-21
	 **************************************************/
	function get_payment_methods( $atts = array(), $content = null ) {
		extract(
			shortcode_atts(
				array(
					'methods'   => false,     // comma separated list of payment methods icon slugs to be displayed, see http://paymentfont.io for available icons (new since 0.2.0)
					'style'     => 'default', // default, inverse, o/outline
					'tooltip'   => false,     // adds data attributes to icon to be used for diplaying tooltips (made for Bootstrap)
					'placement' => 'bottom',  // set tooltip placement (new since 0.1.2)
					'xclass'    => false,     // add any extra classes, seperated by a space
				), $atts
			)
		);

		$class = 'payment-methods';
		$class.= ($style)  ? ' payment-methods-'. $style : '';
		$class.= ($xclass) ? ' '. $xclass : '';

		// use the passed methods array if it's not empty, otherwhise use available gateways/methods
		if ( ! $methods ) {
			$gateways = $this->get_available_gateways();
			$methods  = $gateways['methods'];
		}

		if ( $methods ) {
			$methods = explode( ',', $methods );

			foreach ( $methods as $key => $slug ) {
				if ( $slug )
					$methods[$slug] = $slug;
			}

			$methods = array_flip( $methods );
		}

		if ( count($methods) > 0 ) {
			// remove duplicate methods
			$methods = array_unique($methods);

			// sort array
			ksort($methods);

			// let the magic happen
			$icons = '';
			foreach ( $methods as $slug ) {
				$icon = '';

				// continue if we have no corresponding icon
				if ( ! array_key_exists ( $slug, $this->payment_methods ) )
					continue;

				// retrieve title
				$title = $this->payment_methods[$slug];

				// build icon class
				$iclass = 'pf pf-'. $slug .' '. $slug;

				// icon markup
				$icon = '<i';
				$icon.= ($iclass) ? ' class="'. esc_attr( trim($iclass) ) .'"' : '';
				$icon.= ($title)  ? ' title="'. esc_attr( trim($title) ) .'"'  : '';
				$icon.= ($tooltip AND $placement) ? ' data-toggle="tooltip" data-placement="'. $placement .'"' : '';
				$icon.= '></i>';

				// wrap in list item tags and append to $icons
				$icons.= '<li>'. $icon .'</li>';
			}

			// return $output if we have icons
			if ( $icons ) {
				$output = '<ul';
				$output.= ($class) ? ' class="'. esc_attr( trim($class) ) .'"' : '';
				$output.= '>'. $icons .'</ul>';

				return $output;
			}
		}
	}

	/**
	 * Get available gateways
	 *
	 * @since 2014-09-07
	 * @version 2014-09-08
	 **************************************************/
	function get_available_gateways() {
		$gateways = array();
		$methods  = '';

		if ( $available_gateways = WC()->payment_gateways->get_available_payment_gateways() ) {

			foreach ( $available_gateways as $gateway ) {
				$gateway_id    = $gateway->id;
				$gateway_title = $gateway->get_title();
				$gateway_desc  = $gateway->get_description();
				$gateway_icon  = $gateway->get_icon();

				switch ( $gateway_id ) {
					case 'bacs' :
						$methods.= ' bank-transfer';
						break;

					case 'cheque' :
						$methods.= ' cheque';
						break;

					case 'paypal' :
						$methods.= ' paypal';
						$methods.= ' visa';
						$methods.= ' mastercard';
						$methods.= ' american-express';
						$methods.= ' discover';
						$methods.= ' diners';
						$methods.= ' jcb';
						break;

					case 'stripe' :
						$methods.= ' stripe';
						$methods.= ' visa';
						$methods.= ' mastercard';
						$methods.= ' american-express';
						$methods.= ' discover';
						$methods.= ' diners';
						$methods.= ' jcb';
						break;

					case 'wirecard' :
						$methods.= ' wirecard';
						$methods.= ' paypal';
						$methods.= ' visa';
						$methods.= ' mastercard';
						$methods.= ' american-express';
						$methods.= ' discover';
						$methods.= ' diners';
						$methods.= ' jcb';
						$methods.= ' maestro';
						$methods.= ' quick';
						$methods.= ' paybox';
						$methods.= ' paysafecard';
						$methods.= ' bank-transfer';
						$methods.= ' invoice';
						break;

					case 'ClickAndBuy' :
					case 'clickandbuy' :
						$methods.= ' clickandbuy';
						$methods.= ' bank-transfer';
						break;

					case 'sofortgateway' :
						$methods.= ' sofort';
						$methods.= ' bank-transfer';
						break;

					case 'amazon' :
					case 'amazon-fps' :
						$methods.= ' amazon';
						break;

					case 'google' :
					case 'wallet' :
					case 'google-wallet' :
						$methods.= ' clickandbuy';
						break;

					case 'bitpay' :
					case 'coinbase' :
					case 'bitcoin' :
						$methods.= ' bitcoin';
						break;

					case 'cash_on_delivery' :
						$methods.= ' cash-on-delivery';
						break;

					default :
						break;
				}

				$methods = str_replace( ' ', ',', trim($methods) );

				$gateways[$gateway_id] = array(
					'id'      => $gateway_id,
					'title'   => $gateway_title,
					'desc'    => $gateway_desc,
					'icon'    => $gateway_icon,
				);
			}

		}

		// add methods array to gateways array
		$gateways['methods'] = $methods;

		return $gateways;
	}

} // END Class

global $vendocrat_woo_payment_methods;
$vendocrat_woo_payment_methods = new vendocrat_Woo_Payment_Methods();

/**
 * Output payment methods
 *
 * @since 2014-09-08
 * @version 2014-09-08
 **************************************************/
function v_woo_payment_methods( $atts = array() ) {
	global $vendocrat_woo_payment_methods;

	echo $vendocrat_woo_payment_methods->get_payment_methods( $atts );
}

endif;

/*
 * E fatto!
 */