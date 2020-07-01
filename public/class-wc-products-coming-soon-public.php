<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://aroundtheweb.in
 * @since      1.0.0
 *
 * @package    Wc_Products_Coming_Soon
 * @subpackage Wc_Products_Coming_Soon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wc_Products_Coming_Soon
 * @subpackage Wc_Products_Coming_Soon/public
 * @author     Dipak Kumar Pusti <sipu.dipak@gmail.com>
 */
class Wc_Products_Coming_Soon_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-products-coming-soon-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-products-coming-soon-public.js', array( 'jquery' ), $this->version, false );
	}

	public function availibility_status( $availability, $_product ) {

		if ( $_product->is_in_stock() )
			return $availability;

		$set_coming_soon	= get_post_meta( $_product->id, '_pcs_enable', true );
		$coming_soon_label	= get_post_meta( $_product->id, '_pcs_label', true );
		
		if ( !empty( $set_coming_soon ) && $set_coming_soon == 'yes' ) {
			if ( !empty( $coming_soon_label ) ) {
				$availability['availability'] = $coming_soon_label;
			} else {
				$availability['availability'] = __( 'Coming Soon', 'wc-coming-soon-product' );
			}
			
			$availability['class'] = 'out-of-stock coming-soon';
		}

		return $availability;
	}

	public function coming_soon_timer() {

		global $post;
		
		$product_id = $post->ID;
		$product 	= wc_get_product( $product_id );
		$content 	= '';

		if ( $product->is_in_stock() )
			return $availability;

		$set_coming_soon 	= get_post_meta( $post->ID, '_pcs_enable', true );
		$show_countdown 	= get_post_meta( $post->ID, '_pcs_show_countdown', true );
		$countdown_date 	= get_post_meta( $post->ID, '_pcs_available_date', true );

		if ( !empty( $set_coming_soon ) && $set_coming_soon == 'yes' && !empty( $show_countdown ) && $show_countdown == 'yes' && $countdown_date > date('Y-m-d')) {
			$content = 
				'<div id="pcs_clock">
				  <div>
				    <span class="days"></span>
				    <div class="smalltext">Days</div>
				  </div>
				  <div>
				    <span class="hours"></span>
				    <div class="smalltext">Hours</div>
				  </div>
				  <div>
				    <span class="minutes"></span>
				    <div class="smalltext">Minutes</div>
				  </div>
				  <div>
				    <span class="seconds"></span>
				    <div class="smalltext">Seconds</div>
				  </div>
				</div>
				<script type="text/javascript">
					(function( $ ) {
						\'use strict\';
						$(function() {
							function getTimeRemaining(endtime) {
							  var t = Date.parse(endtime) - Date.parse(new Date());
							  var seconds = Math.floor((t / 1000) % 60);
							  var minutes = Math.floor((t / 1000 / 60) % 60);
							  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
							  var days = Math.floor(t / (1000 * 60 * 60 * 24));

							  return {
							    \'total\': t,
							    \'days\': days,
							    \'hours\': hours,
							    \'minutes\': minutes,
							    \'seconds\': seconds
							  };
							}

							function initializeClock(id, endtime) {
							  var clock = document.getElementById(id);
							  var daysSpan = clock.querySelector(\'.days\');
							  var hoursSpan = clock.querySelector(\'.hours\');
							  var minutesSpan = clock.querySelector(\'.minutes\');
							  var secondsSpan = clock.querySelector(\'.seconds\');

							  function updateClock() {
							    var t = getTimeRemaining(endtime);

							    daysSpan.innerHTML = t.days;
							    hoursSpan.innerHTML = (\'0\' + t.hours).slice(-2);
							    minutesSpan.innerHTML = (\'0\' + t.minutes).slice(-2);
							    secondsSpan.innerHTML = (\'0\' + t.seconds).slice(-2);

							    if (t.total <= 0) {
							      clearInterval(timeinterval);
							    }
							  }

							  updateClock();
							  var timeinterval = setInterval(updateClock, 1000);
							}

							var deadline = new Date("'.$countdown_date.'");
							initializeClock("pcs_clock", deadline);
						});

					})( jQuery );
				</script>';
		}

		echo $content;
	}
}