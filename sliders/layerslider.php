<?php
/**
 * 
 * LayerSlider Field
 * 
 */
if ( !defined( 'ABSPATH' )) die(-1); 

class WPPress_LayerSlider_ACF_Field extends WPPress_ACF_Field
{

	
	function __construct() {
		$this->label = 'LayerSlider';
		parent::__construct();
	}
	/**
	 * will return
	 * @method get_slider_output
	 * @author Sovit Tamrakar
	 * @param  [type] $data accepts data in array or string/integer
	 * @return string output data for slider html
	 */
	function slider_output($data=NULL){
		return do_shortcode("[layerslider id=\"".$data."\"]");
	}
	/**
	 * Will return all the Gallery Slider in array in format(id=>name)
	 * @method sliders_data
	 * @author Sovit Tamrakar
	 * @return array id=>label
	 */
	function slider_data(){
		$sliders = LS_Sliders::find(array(
			'limit' => 100
		));
		$data=array();
		if($sliders){
			foreach($sliders as $slide){
				$data[$slide['id']]=$slide['name'];
			}
		}
		return $data;
	}
}

new WPPress_LayerSlider_ACF_Field();