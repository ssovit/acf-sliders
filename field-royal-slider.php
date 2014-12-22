<?php
/**
 *
 * Royal Touch Slider Field
 *
 * 
 */
if ( !defined( 'ABSPATH' )) die(-1); 

class WPPress_RoyalSlider_ACF_Field extends WPPress_ACF_Field
{
	
	function __construct() {
		$this->label = 'Royal Slider';
		parent::__construct();
	}
	function slider_output($data = NULL) {
		$slider=get_new_royalslider( $data);
		return $slider;
	}
	
	/**
	 * Will return all the Gallery Slider in array in format(id=>name)
	 * @method sliders_data
	 * @author Sovit Tamrakar
	 * @return array id=>label
	 */
	function slider_data() {
		global $wpdb;
		$table = NewRoyalSliderMain::get_sliders_table_name();
		$sliders = $wpdb->get_results( $wpdb->prepare("SELECT id, name FROM $table WHERE active=1  AND type!=%s",'gallery') );
		$data = array();
		if (!empty($sliders)) {
			foreach ($sliders as $slider) {
				$data[$slider->id] = $slider->name;
			}
		}
		return $data;
	}
}

new WPPress_RoyalSlider_ACF_Field();
