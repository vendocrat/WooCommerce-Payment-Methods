<?php
/**
 * vendocrat Payment Methods widget
 *
 * @package		vendocrat
 * @subpackage	Payment Methods/Classes
 *
 * @since		2014-09-08
 * @version		2014-09-08
 *
 * @author		Poellmann Alexander Manfred <alex@vendocr.at>
 * @copyright	Copyright 2014 vendocrat. All Rights Reserved.
 * @link		http://vendocr.at/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class vendocrat_Widget_Payment_Methods extends WP_Widget {

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
		$this->slug = 'vendocrat_widget_payment_methods';
		$this->name = __( 'Payment Methods', 'vendocrat-payment-methods' );
		$this->desc = __( 'Easily display your accepted payment methods', 'vendocrat-payment-methods' );
		$this->title = __( 'Accepted Payment Methods', 'vendocrat-payment-methods' );
		
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
	 * @version 2014-09-08
	 **************************************************/
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$tooltip = ($instance['tooltip'] != 'true') ? false : true;
		$style   = $instance['style'];
		$xclass  = $instance['xclass'];

		echo $tooltip;
		extract($args);

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		global $vendocrat_woo_payment_methods;

		$atts = array(
			'style'   => $style,
			'tooltip' => $tooltip,
			'xclass'  => $xclass,
		);
		echo $vendocrat_woo_payment_methods->get_payment_methods( $atts );

		echo $after_widget;
	}

	/**
	 * Back-end widget form
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @since 2014-09-08
	 * @version 2014-09-08
	 **************************************************/
	public function form( $instance ) {
		$defaults = array(
			'title'   => $this->title,
			'style'   => 'default',
			'tooltip' => 'false',
			'xclass'  => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'vendocrat-payment-methods' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style', 'vendocrat-payment-methods' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>">
				<option value="default"<?php selected( $instance['style'], 'default' ); ?>><?php _e( 'Default', 'vendocrat-payment-methods' ); ?></option>
				<option value="inverse"<?php selected( $instance['style'], 'inverse' ); ?>><?php _e( 'Inverse', 'vendocrat-payment-methods' ); ?></option>
				<option value="o"<?php selected( $instance['style'], 'o' ); ?>><?php _e( 'Outline', 'vendocrat-payment-methods' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tooltip' ); ?>"><?php _e( 'Add Tooltip markup?', 'vendocrat-payment-methods' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'tooltip' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'tooltip' ); ?>">
				<option value="false"<?php selected( $instance['tooltip'], 'false' ); ?>><?php _e( 'No', 'vendocrat-payment-methods' ); ?></option>
				<option value="true"<?php selected( $instance['tooltip'], 'true' ); ?>><?php _e( 'Yes', 'vendocrat-payment-methods' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('xclass'); ?>"><?php _e( 'Extra classes', 'vendocrat-payment-methods' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('xclass'); ?>" name="<?php echo $this->get_field_name('xclass'); ?>" type="text" value="<?php echo esc_attr( $instance['xclass'] ); ?>" />
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

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['style']   = esc_attr( $new_instance['style'] );
		$instance['tooltip'] = esc_attr( $new_instance['tooltip'] );
		$instance['xclass']  = esc_attr( $new_instance['xclass'] );

		return $instance;
	}

} // END Class

/*
 * NO MORE LOVE TO GIVE
 */