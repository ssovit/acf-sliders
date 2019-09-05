<?php
abstract class WPPress_ACF_Field extends acf_field
{
	var $label = "WPPress Slider";
	function __construct() {
		$this->name = $this->_create_name();
		$this->category = __("Sliders", 'acf');
		parent::__construct();
	}
	abstract protected function slider_output($data = false);
	abstract protected function slider_data();
	private function _create_name() {
		return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', "wpp_acf_" . $this->label) , '_'));
	}

	
	
	function format_value($value, $field) {
		
		if (!$value || $value == 'null') {
			return false;
		}
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				$f = $this->slider_output($v);
				$value[$k] = array();
				$value[$k] = $f;
			}
		} else {
			$value = $this->slider_output($value);
		}
		
		return $value;
	}
	function render_field($field) {
		$field['multiple'] = isset($field['multiple']) ? $field['multiple'] : false;
		$field['disabled'] = isset($field['disabled']) ? $field['disabled'] : [];
		$multiple = '';
		if ($field['multiple']) {
			$multiple = ' multiple="multiple" size="5" ';
			$field['name'].= '[]';
		}
		echo '<select id="' . $field['name'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';
		if ($field['allow_null']) {
			echo '<option value="null"> - Select - </option>';
		}
		$sliders = $this->slider_data();
		$disabled_slides=array_values($field['disabled']);
		if (!empty($sliders)) {
			foreach ($sliders as $key => $value) {
				if(!in_array($key,$disabled_slides)){
				$selected = '';
				if (is_array($field['value'])) {
					if (in_array($key, $field['value'])) {
						$selected = 'selected="selected"';
					}
				} else {
					if ($key == $field['value']) {
						$selected = 'selected="selected"';
					}
				}
				
				echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
			}
				
			}
		}
		
		echo '</select>';
	}
	
	function render_field_settings($field) {
		
		print_r($field);
		$key = $field['name'];
		
		$choices = $this->slider_data();
		
		
		acf_render_field_setting($field, array(
			'label' => __('Disabled Slides:'.json_encode($field['disabled']), 'acf') ,
			'type' => 'select',
			'name' => 'disabled',
			'multiple' => 1,
			'ui'			=> 1,
			'allow_null'	=> 1,
			'choices' => $choices,
			'layout' => 'horizontal',
		));
		// allow_null
		acf_render_field_setting( $field, array(
			'label'			=> __('Allow Null?','acf'),
			'instructions'	=> '',
			'name'			=> 'allow_null',
			'type'			=> 'true_false',
			'ui'			=> 1,
		));
		
		
		// multiple
		acf_render_field_setting( $field, array(
			'label'			=> __('Select multiple values?','acf'),
			'instructions'	=> '',
			'name'			=> 'multiple',
			'type'			=> 'true_false',
			'ui'			=> 1,
		));
		
	}
}

