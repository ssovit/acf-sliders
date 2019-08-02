<?php
/**
 *
 * Revolution Slider Field
 * 
 */
if ( !defined( 'ABSPATH' )) die(-1); 
class WPPress_RevolutionSlider_ACF_Field extends WPPress_ACF_Field
{
	
	function __construct() {
		$this->label = 'Revolution Slider';
		parent::__construct();
	}
	/**
	 * will return
	 * @method get_slider_output
	 * @author Sovit Tamrakar
	 * @param  [type] $data accepts data in array or string/integer
	 * @return string output data for slider html
	 */
	function slider_output($data = NULL) {
		ob_start();
		$rev = RevSliderOutput::putSlider($data);
		$slider = ob_get_contents();
		ob_clean();
		ob_end_clean();
		return $slider;
	}
	
	/**
	 * Will return all the Gallery Slider in array in format(id=>name)
	 * @method sliders_data
	 * @author Sovit Tamrakar
	 * @return array id=>label
	 */
	function slider_data() {
		$slider = new RevSlider();
		$sliders = $slider->getArrSlidersShort();
		$data = array();
		if (!empty($sliders)) {
			foreach ($sliders as $key => $val) {
				$data[$key] = $val;
			}
		}
		return $data;
	}
}

new WPPress_RevolutionSlider_ACF_Field();
