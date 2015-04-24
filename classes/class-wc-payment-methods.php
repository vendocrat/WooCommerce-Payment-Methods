<?php
/**
 * Payment Methods
 *
 * @package    vendocrat
 * @subpackage Payment Methods
 *
 * @since      2014-09-08
 * @version    2015-04-24
 *
 * @author     Poellmann Alexander Manfred (@AMPoellmann)
 * @copyright  Copyright 2015 vendocrat. All Rights Reserved.
 * @link       https://vendocr.at/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'vendocrat_WC_Payment_Methods' ) ) :

class vendocrat_WC_Payment_Methods {

	/* File var */
	private $file;

	/* Basic vars */
	public $version;
	public $plugin_url;
	public $plugin_dir;

	/* Payment methods */
	public $available_methods;

	/**
	 * Constructor
	 *
	 * @since 2014-08-15
	 * @version 2014-09-22
	 **************************************************/
	function __construct( $file ) {
		// setup dir/uri
		$this->file = $file;
		$this->plugin_url = trailingslashit( plugins_url( '', $plugin = $file ) );
		$this->plugin_dir = trailingslashit( dirname( $file ) );

		// definitions
		$this->defines();

		// load functions and classes
		$this->load_functions();
		$this->load_classes();

		// load text domain
		$this->load_plugin_textdomain();

		$this->available_methods = array(
			'amazon'			=> 'Amazon',
			'american-express'	=> 'American Express',
			'atm'				=> 'ATM',
			'bank-transfer'		=> __( 'Bank Transfer', 'woocommerce-payment-methods' ),
			'bankomat'			=> 'Bankomat',
			'bitcoin'			=> 'Bitcoin',
			'braintree'			=> 'Braintree',
			'carta-si'			=> 'Carta Si',
			'cash'				=> __( 'Cash', 'woocommerce-payment-methods' ),
			'cash-on-delivery'	=> __( 'Cash on Delivery', 'woocommerce-payment-methods' ),
			'cb'				=> 'CB',
			'cirrus'			=> 'Cirrus',
		//	'cheque'			=> __( 'Pay with Cheque', 'woocommerce-payment-methods' ),
			'clickandbuy'		=> 'ClickAndBuy',
			'credit-card'		=> __( 'Credit Card', 'woocommerce-payment-methods' ),
			'diners'			=> 'Diners Club',
			'discover'			=> 'Discover',
			'ec'				=> 'EC (Electronic Cash)',
			'eps'				=> 'Eps',
			'fattura'			=> __( 'Invoice', 'woocommerce-payment-methods' ),
			'facture'			=> __( 'Invoice', 'woocommerce-payment-methods' ),
			'flattr'			=> 'Flattr',
			'giropay'			=> 'Giropay',
			'gittip'			=> 'Gittip',
			'google-wallet'		=> 'Google Wallet',
			'ideal'				=> 'Ideal',
			'invoice'			=> __( 'Invoice', 'woocommerce-payment-methods' ),
			'jcb'				=> 'JCB',
			'maestro'			=> 'Maestro',
			'mastercard'		=> 'MasterCard',
			'mastercard-securecode' => 'MasterCard Securecode',
			'ogone'				=> 'Ogone',
			'paybox'			=> 'Paybox',
			'paylife'			=> 'Paylife',
			'paymill'			=> 'Paymill',
			'paypal'			=> 'PayPal',
			'paysafecard'		=> 'paysafecard',
			'postepay'			=> 'postepay',
			'quick'				=> 'Quick',
			'invoice'			=> __( 'Invoice', 'woocommerce-payment-methods' ),
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

		// scripts and styles
		if ( ! is_admin() ) :
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		endif;

		// register widgets
		add_action( 'widgets_init', array( &$this, 'register_widgets' ) );

		// add shortcode
		add_shortcode( 'v_woo_payment_methods', array( &$this, 'get_payment_methods' ) );
		add_shortcode( 'wc_payment_methods',    array( &$this, 'get_payment_methods' ) );
	}

	/**
	 * Definitions
	 *
	 * @return void
	 *
	 * @since 2014-09-22
	 * @version 2014-09-22
	 **************************************************/
	function defines() {
		// Plugin
		define( 'WC_PAYMENT_METHODS_DIR', $this->plugin_dir );
		define( 'WC_PAYMENT_METHODS_URI', $this->plugin_url );

		// Assets
		define( 'WC_PAYMENT_METHODS_CSS_URI', trailingslashit( WC_PAYMENT_METHODS_URI . 'assets/css' ) );
		define( 'WC_PAYMENT_METHODS_IMG_URI', trailingslashit( WC_PAYMENT_METHODS_URI . 'assets/img' ) );
	}

	/**
	 * Load functions
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function load_functions() {}

	/**
	 * Load classes
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function load_classes() {}

	/**
	 * Load theme textdomain
	 *
	 * @return void
	 *
	 * @since 2014-09-08
	 * @version 2014-10-23
	 **************************************************/
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-payment-methods' );
		$dir    = trailingslashit( WP_LANG_DIR );

		/**
		 * Frontend/global Locale. Looks in:
		 * - WP_LANG_DIR/woocommerce-payment-methods/woocommerce-payment-methods-LOCALE.mo
		 * - woocommerce-payment-methods/languages/woocommerce-payment-methods-LOCALE.mo (which if not found falls back to:)
		 * - WP_LANG_DIR/plugins/woocommerce-payment-methods-LOCALE.mo
		 */
		load_textdomain( 'woocommerce-payment-methods', $dir .'woocommerce-payment-methods/woocommerce-payment-methods-'. $locale .'.mo' );
		load_plugin_textdomain( 'woocommerce-payment-methods', false, plugin_basename( $this->plugin_dir ) .'/languages/' );
	}

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
			wp_register_style( 'vendocrat-paymentfont', WC_PAYMENT_METHODS_CSS_URI .'paymentfont.min.css', array(), false, 'all' );
		}
		wp_enqueue_style( 'vendocrat-paymentfont' );

		wp_register_style( 'payment-methods', WC_PAYMENT_METHODS_CSS_URI .'payment-methods.min.css', array(), false, 'all' );
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
		require_once WC_PAYMENT_METHODS_DIR .'classes/class-widget-wc-payment-methods.php';
		register_widget( 'vendocrat_Widget_WC_Payment_Methods' );
	}

	/**
	 * Woo Accepted Payment Methods
	 *
	 * @since 2014-09-07
	 * @version 2015-04-24
	 **************************************************/
	function get_payment_methods( $atts = array(), $content = null ) {
		extract(
			shortcode_atts(
				array(
					'methods'   => false,     // comma separated list of payment methods icon slugs to be displayed, see http://paymentfont.io for available icons (new since 0.2.0)
					'style'     => 'default', // default, i/inverse, o/outline
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

		// Filter for methods (new as of v1.1.0)
		$methods = apply_filters( 'vendocrat_filter_wc_payment_methods', $methods );

		if ( ! is_array($methods) OR count($methods) <= 0 )
			return __( 'No Payment Methods available or specified.', 'woocommerce-payment-methods' );

		// remove duplicate methods
		$methods = array_unique($methods);

		// sort array
		ksort($methods);

		// let the magic happen
		$icons = '';
		foreach ( $methods as $slug ) {
			$icon = '';

			// continue if we have no corresponding icon
			if ( ! array_key_exists ( $slug, $this->available_methods ) )
				continue;

			// retrieve title
			$title = $this->available_methods[$slug];

			// build icon class
			$iclass = 'pf pf-'. $slug .' '. $slug;

			// icon markup
			$icon = '<i';
			$icon.= ($iclass) ? ' class="'. esc_attr( trim($iclass) ) .'"' : '';
			$icon.= ($title)  ? ' title="'. esc_attr( trim($title) ) .'"'  : '';
			$icon.= ($tooltip AND $placement) ? ' data-toggle="tooltip" data-placement="'. $placement .'"' : '';
			$icon.= '></i>';

			// wrap in list item tags and append to $icons
			$icons.= '<li class="'. esc_attr( trim($slug) ) .'">'. $icon .'</li>';
		}

		$icons = apply_filters( 'vendocrat_filter_wc_payment_methods_icons', $icons );

		// return $output if we have icons
		if ( $icons ) {
			$output = '<ul';
			$output.= ($class) ? ' class="'. esc_attr( trim($class) ) .'"' : '';
			$output.= '>'. $icons .'</ul>';

			return $output;
		}
	}

	/**
	 * Get available gateways
	 *
	 * @todo refactor automatic display of payment methods, eg. for PayPal & Stripe
	 *
	 * @since 2014-09-07
	 * @version 2015-04-24
	 **************************************************/
	function get_available_gateways() {
		$gateways = array();
		$methods  = '';

		// check dependencies
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
			return $gateways;

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

					case 'paymill' :
						$methods.= ' paymill';
					/*	$methods.= ' credit-card';
						$methods.= ' visa';
						$methods.= ' mastercard';
						$methods.= ' american-express';
						$methods.= ' discover';
						$methods.= ' diners';
						$methods.= ' jcb';*/
						break;

					case 'paypal' :
					//	$methods.= ' credit-card';
						$methods.= ' paypal';
					/*	$methods.= ' visa';
						$methods.= ' mastercard';
						$methods.= ' american-express';
						$methods.= ' discover';
						$methods.= ' diners';
						$methods.= ' jcb';*/
						break;

					case 'stripe' :
						$methods.= ' stripe';
					/*	$methods.= ' visa';
						$methods.= ' mastercard';
						$methods.= ' american-express';
						$methods.= ' discover';
						$methods.= ' diners';
						$methods.= ' jcb';*/
						break;

					case 'wirecard' :
						$options = get_option('woocommerce_wirecard_settings');

						if ( is_array($options) AND array_key_exists( 'paymenttype_available', $options ) AND is_array( $options['paymenttype_available'] ) ) {
							$wirecard_gateways = $options['paymenttype_available'];
						} else {
							$wirecard_gateways = array();
						}

						if ( is_array($options) AND array_key_exists( 'subs_paymenttype_options', $options ) AND is_array( $options['subs_paymenttype_options'] ) ) {
							$wirecard_gateways_subscription = $options['subs_paymenttype_options'];
						} else {
							$wirecard_gateways_subscription = array();
						}

						$wirecard_gateways = array_merge( $wirecard_gateways, $wirecard_gateways_subscription );

						if ( count($wirecard_gateways) > 0 ) {
							foreach ( $wirecard_gateways as $wirecard_gateway ) {
								$wirecard_gateway = strtolower( $wirecard_gateway );

								switch ( $wirecard_gateway ) {
									case 'select' :
										break;

									case 'ccard' :
										$methods.= ' credit-card';
									//	$methods.= ' visa';
									//	$methods.= ' mastercard';
										break;

									case 'idl' :
										$methods.= ' ideal';
										break;

									case 'paymill' :
										$methods.= ' paymill';
									/*	$methods.= ' credit-card';
										$methods.= ' visa';
										$methods.= ' mastercard';
										$methods.= ' american-express';
										$methods.= ' discover';
										$methods.= ' diners';
										$methods.= ' jcb';*/
										break;

									case 'paypal' :
									//	$methods.= ' credit-card';
										$methods.= ' paypal';
									/*	$methods.= ' visa';
										$methods.= ' mastercard';
										$methods.= ' american-express';
										$methods.= ' discover';
										$methods.= ' diners';
										$methods.= ' jcb';*/
										break;

									case 'pbx' :
										$methods.= ' paybox';
										break;

									case 'psc' :
										$methods.= ' paysafecard';
										break;

									case 'skrilldirect' :
									case 'skrillwallet' :
										$methods.= ' skrill';
										break;

									case 'sofortueberweisung' :
										$methods.= ' sofort';
										$methods.= ' bank-transfer';
										break;

									case 'elv' :
									case 'przelewy24' :
									case 'moneta' :
									case 'c2p' :
									case 'bancontact_mistercash' :
									case 'przelewy24' :
									case 'installment' :
									case 'poli' :
									case 'ekonto' :
									case 'instantbank' :
									case 'mpass' :
										break;

									default :
										$methods.= ' '. $wirecard_gateway;
										break;
								}
							}
						}
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
					case 'amazon_fps' :
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

/**
 * Output payment methods
 *
 * @since 2014-09-08
 * @version 2014-10-23
 **************************************************/
function wc_payment_methods( $atts = array() ) {
	global $vendocrat_wc_payment_methods;

	echo $vendocrat_wc_payment_methods->get_payment_methods( $atts );
}

/**
 * Output payment methods
 *
 * @deprecated 2014-10-23
 * @since 2014-09-08
 * @version 2014-09-08
 **************************************************/
function v_woo_payment_methods( $atts = array() ) {
	wc_payment_methods( $atts );
}

endif;

/*
 * E fatto!
 */