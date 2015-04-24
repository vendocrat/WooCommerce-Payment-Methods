<?php
/**
 * Payment Methods widget
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

class vendocrat_Widget_WC_Payment_Methods extends WP_Widget {

	public $slug;
	public $name;
	public $desc;
	public $title;

	/**
	 * Construct Widget
	 *
	 * @since 2014-09-08
	 * @version 2014-09-08
	 **************************************************/
	function __construct() {
		$this->slug  = 'vendocrat_payment_methods';
		$this->name  = __( 'Payment Methods', 'woocommerce-payment-methods' );
		$this->desc  = __( 'Easily display your accepted payment methods', 'woocommerce-payment-methods' );
		$this->title = __( 'Accepted Payment Methods', 'woocommerce-payment-methods' );
		
		parent::__construct(
			$this->slug,
			'vendocrat: '. $this->name,
			array(
				'description' => $this->desc,
			)
		);
	}

	/**
	 * Front-end display of widget
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 * @return void
	 *
	 * @since 2014-09-08
	 * @version 2014-09-15
	 **************************************************/
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$methods   = $instance['methods'];
		$style     = $instance['style'];
		$tooltip   = ($instance['tooltip'] != 'true') ? false : true;
		$placement = $instance['placement'];
		$xclass    = $instance['xclass'];

		extract($args);

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		global $vendocrat_wc_payment_methods;

		$atts = array(
			'methods'   => $methods,
			'style'     => $style,
			'tooltip'   => $tooltip,
			'placement' => $placement,
			'xclass'    => $xclass,
		);
		echo $vendocrat_wc_payment_methods->get_payment_methods( $atts );

		echo $after_widget;
	}

	/**
	 * Back-end widget form
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @since 2014-09-08
	 * @version 2014-09-15
	 **************************************************/
	public function form( $instance ) {
		$defaults = array(
			'title'     => $this->title,
			'methods'   => '',
			'style'     => 'default',
			'tooltip'   => 'false',
			'placement' => 'bottom',
			'xclass'    => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'woocommerce-payment-methods' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style', 'woocommerce-payment-methods' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>">
				<option value="default"<?php selected( $instance['style'], 'default' ); ?>><?php _e( 'Default', 'woocommerce-payment-methods' ); ?></option>
				<option value="inverse"<?php selected( $instance['style'], 'inverse' ); ?>><?php _e( 'Inverse', 'woocommerce-payment-methods' ); ?></option>
				<option value="o"<?php selected( $instance['style'], 'o' ); ?>><?php _e( 'Outline', 'woocommerce-payment-methods' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tooltip' ); ?>"><?php _e( 'Add Tooltip markup?', 'woocommerce-payment-methods' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'tooltip' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'tooltip' ); ?>">
				<option value="false"<?php selected( $instance['tooltip'], 'false' ); ?>><?php _e( 'No', 'woocommerce-payment-methods' ); ?></option>
				<option value="true"<?php selected( $instance['tooltip'], 'true' ); ?>><?php _e( 'Yes', 'woocommerce-payment-methods' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'placement' ); ?>"><?php _e( 'Placement', 'woocommerce-payment-methods' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'placement' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'placement' ); ?>">
				<option value="top"<?php selected( $instance['placement'], 'top' ); ?>><?php _e( 'Top', 'woocommerce-payment-methods' ); ?></option>
				<option value="right"<?php selected( $instance['placement'], 'right' ); ?>><?php _e( 'Right', 'woocommerce-payment-methods' ); ?></option>
				<option value="bottom"<?php selected( $instance['placement'], 'bottom' ); ?>><?php _e( 'Bottom', 'woocommerce-payment-methods' ); ?></option>
				<option value="left"<?php selected( $instance['placement'], 'left' ); ?>><?php _e( 'Left', 'woocommerce-payment-methods' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('xclass'); ?>"><?php _e( 'Extra classes', 'woocommerce-payment-methods' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('xclass'); ?>" name="<?php echo $this->get_field_name('xclass'); ?>" type="text" value="<?php echo esc_attr( $instance['xclass'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('methods'); ?>"><?php _e( 'Payment Methods', 'woocommerce-payment-methods' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('methods'); ?>" name="<?php echo $this->get_field_name('methods'); ?>" type="text" value="<?php echo esc_attr( $instance['methods'] ); ?>" />
			<i><?php echo '<strong>'. __( 'Optional', 'woocommerce-payment-methods' ) . ':</strong> ' . sprintf( __( 'Specify payment methods to be shown manually by entering their slugs comma separated (eg. "paypal,visa,mastercard" for PayPal, Visa and MasterCard). See %s for available payment methods an their slugs! If left blank the widget will try to automatically fetch available payment methods from WooCommerce.', 'woocommerce-payment-methods' ), '<a href="http://paymentfont.io" target="_blank">PaymentFont.io</a>' ); ?></i>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 **************************************************/
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['methods']   = esc_attr( $new_instance['methods'] );
		$instance['style']     = esc_attr( $new_instance['style'] );
		$instance['tooltip']   = esc_attr( $new_instance['tooltip'] );
		$instance['placement'] = esc_attr( $new_instance['placement'] );
		$instance['xclass']    = esc_attr( $new_instance['xclass'] );

		return $instance;
	}

} // END Class

/*
 * E fatto!
 */