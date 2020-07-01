<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://aroundtheweb.in
 * @since      1.0.0
 *
 * @package    Wc_Products_Coming_Soon
 * @subpackage Wc_Products_Coming_Soon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Products_Coming_Soon
 * @subpackage Wc_Products_Coming_Soon/admin
 * @author     Dipak Kumar Pusti <sipu.dipak@gmail.com>
 */
class Wc_Products_Coming_Soon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-products-coming-soon-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-products-coming-soon-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function wcpcs_tab( $tabs ) {

		$tabs['wcpcs'] = array(
			'label'    => 'Coming Soon',
			'target'   => 'wcpcs_product_data',
			'priority' => 21,
		);
		return $tabs;
	}

	public function wcpcs_panel() {

		echo '<div id="wcpcs_product_data" class="panel woocommerce_options_panel hidden">';
 
		woocommerce_wp_checkbox(
			array(
				'id'            => '_pcs_enable',
				'label'         => __( 'Enable Coming Soon?', 'wc-pcs' ),
				'desc_tip'      => true,
				'description'   => __( 'Enable coming soon for this Out of Stock product?', 'wc-pcs' ),
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'            => '_pcs_label',
				'label'         => __( 'Coming Soon Label', 'wc-pcs' ),
				'placeholder'   => __( 'Coming Soon!!', 'wc-pcs' ),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_pcs_show_countdown',
				'label'         => __( 'Show Countdown?', 'wc-pcs' ),
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'            => '_pcs_available_date',
				'label'         => __( 'Avilability Date', 'wc-pcs' ),
				'placeholder' 	=> _x( 'YYYY-MM-DD', 'placeholder', 'woocommerce' ),
				'class' 		=> 'date-picker',
			)
		);
	 
		echo '</div>';
	}

	public function wcpcs_save( $post_id ) {

		$cs_enabled = isset($_POST['_pcs_enable']) ? sanitize_text_field( $_POST['_pcs_enable'] ) : '';
		
		$cs_label 	= isset($_POST['_pcs_label']) ? sanitize_text_field( $_POST['_pcs_label'] ) : '';
		
		$cs_timer 	= isset($_POST['_pcs_show_countdown']) ? sanitize_text_field( $_POST['_pcs_show_countdown'] ) : '';
		$cs_avlblty = isset($_POST['_pcs_available_date']) ? sanitize_text_field( $_POST['_pcs_available_date'] ) : '';

		update_post_meta( $post_id, '_pcs_enable', $cs_enabled );
		update_post_meta( $post_id, '_pcs_label', $cs_label );
		update_post_meta( $post_id, '_pcs_show_countdown', $cs_timer );
		update_post_meta( $post_id, '_pcs_available_date', $cs_avlblty );
	}
}