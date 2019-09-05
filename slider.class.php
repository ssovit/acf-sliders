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
	function format_value_for_api($value, $field) {
		
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
	function create_field($field) {
		$field['multiple'] = isset($field['multiple']) ? $field['multiple'] : false;
		$field['disable'] = isset($field['disable']) ? $field['disable'] : false;
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
		if (!empty($sliders)) {
			foreach ($sliders as $key => $value) {
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
		
		echo '</select>';
	}
	
	function create_options($field) {
		$defaults = array(
			'multiple' => false,
			'allow_null' => false,
			'default_value' => '',
			'choices' => '',
			'disable' => '',
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Disabled Slides:", 'acf') . '</label>';
		echo '<p class="description">' . __("You will not be able to select these Slides", 'acf') . '</p>';
		echo '</td>';
		echo '<td>';
		$sliders = $this->slider_data();
		
		$choices = array_merge(array(
			0 => "---"
		) , $sliders);
		do_action('acf/create_field', array(
			'type' => 'select',
			'name' => 'fields[' . $key . '][disable]',
			'value' => $field['disable'],
			'multiple' => false,
			'allow_null' => false,
			'choices' => $choices,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Allow Null?", 'acf') . '</label>';
		echo '</td>';
		echo '<td>';
		
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields[' . $key . '][allow_null]',
			'value' => $field['allow_null'],
			'choices' => array(
				1 => __("Yes", 'acf') ,
				0 => __("No", 'acf') ,
			) ,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Select Multiple?", 'acf') . '</label>';
		echo '</td>';
		echo '<td>';
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields[' . $key . '][multiple]',
			'value' => $field['multiple'],
			'choices' => array(
				1 => __("Yes", 'acf') ,
				0 => __("No", 'acf') ,
			) ,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';
		
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
		$field['disable'] = isset($field['disable']) ? $field['disable'] : false;
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
		if (!empty($sliders)) {
			foreach ($sliders as $key => $value) {
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
		
		echo '</select>';
	}
	
	function render_field_settings($field) {
		$defaults = array(
			'multiple' => 0,
			'allow_null' => 0,
			'default_value' => '',
			'choices' => '',
			'disable' => '',
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		
		$sliders = $this->slider_data();
		
		$choices = array_merge(array(
			0 => "---"
		) , $sliders);
		acf_render_field_setting($field, array(
			'label' => __('Disabled Slides:', 'acf') ,
			'type' => 'select',
			'name' => 'fields[' . $key . '][disable]',
			'value' => $field['disable'],
			'multiple' => '1',
			'allow_null' => '0',
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

