<?php

/*
Plugin Name: Advanced Custom Fields LayerSlider Field
Plugin URI: http://wppress.net
Description: Add one or more LayerSliders to a Advanced Custom Field
Version: 1.1.0
Author: WPPress.net
Author URI: http://wppress.net
*/

class WPPress_ACF_Layerslider
{

	function __construct() {
		add_action('acf/register_fields', array(
			&$this,
			'register_fields'
		));
	}

	function register_fields() {
		if (class_exists('LS_Sliders')) {
			include_once ('field.php');
		}
	}
}

new WPPress_ACF_Layerslider();
