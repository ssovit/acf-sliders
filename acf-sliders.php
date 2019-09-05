<?php

/*
Plugin Name: Advanced Custom Fields: Sliders Field
Plugin URI: http://wppress.net/acf-slider-fields
Description: Support for some premium and Free sliders for Advanced Custom Fields
Version: 1.2.0
Author: WPPress.net
Author URI: http://wppress.net
*/
if (!defined('ABSPATH')) {
	/* Prevent Direct Access */
	die(-1);
}

class WPPress_ACF_WPPress_Sliders
{
	
	function __construct() {
		/* For ACF Pro 5+ */
		add_action('acf/include_fields', array(&$this,
			'register_fields'
		));
	}
	
	function register_fields() {
		include_once (dirname(__FILE__) . '/slider.class.php');
		if (class_exists('LS_Sliders')) {
			include_once ('sliders/layerslider.php');
		}
		if (class_exists('RevSlider')) {
			include_once ('sliders/revslider.php');
		}
		if (class_exists('NewRoyalSliderMain')) {
			include_once ('sliders/royal-slider.php');
		}
	}
}

new WPPress_ACF_WPPress_Sliders();
