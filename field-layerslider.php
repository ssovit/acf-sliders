<?php
class WPPress_LayerSlider_ACF_Field extends acf_field
{
	
	function __construct() {
		$this->name = 'wppress_acf_layerslider';
		$this->label = __('LayerSlider');
		parent::__construct();
	}
	
	function load_value($value, $post_id, $field) {
		return $value;
	}
	
	function update_value($value, $field, $post_id) {
		return $value;
	}
	
	function format_value($value, $field) {
		return $value;
	}
	
	function format_value_for_api($value, $field) {
		
		if (!$value || $value == 'null') {
			return false;
		}
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				$f = do_shortcode('[layerslider id="' . $v . '"]');
				$value[$k] = array();
				$value[$k] = $f;
			}
		} else {
			$value = do_shortcode('[layerslider id="' . $value . '"]');
		}
		
		return $value;
	}
	
	function load_field($field) {
		return $field;
	}
	
	function update_field($field, $post_id) {
		return $field;
	}
	function create_field($field) {
		$field['multiple'] = isset($field['multiple']) ? $field['multiple'] : false;
		$field['disable'] = isset($field['disable']) ? $field['disable'] : false;
		$field['hide_disabled'] = isset($field['hide_disabled']) ? $field['hide_disabled'] : false;
		$multiple = '';
		if ($field['multiple'] == '1') {
			$multiple = ' multiple="multiple" size="5" ';
			$field['name'].= '[]';
		}
		echo '<select id="' . $field['name'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';
		if ($field['allow_null'] == '1') {
			echo '<option value="null"> - Select - </option>';
		}
		$sliders = LS_Sliders::find(array(
			'limit' => 100
		));
		
		if ($sliders) {
			foreach ($sliders as $item) {
				$key = $item['id'];
				$value = empty($item['name']) ? 'Unnamed' : $item['name'];
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
				if (in_array(($key) , $field['disable'])) {
					if ($field['hide_disabled'] == 0) {
						echo '<option value="' . $key . '" ' . $selected . ' disabled="disabled">' . $value . '</option>';
					}
				} else {
					echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
				}
			}
		}
		
		echo '</select>';
	}
	
	function create_options($field) {
		$defaults = array(
			'multiple' => 0,
			'allow_null' => 0,
			'default_value' => '',
			'choices' => '',
			'disable' => '',
			'hide_disabled' => 0,
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
?>
      <tr class="field_option field_option_<?php
		echo $this->name; ?>">
          <td class="label">
            <label><?php
		_e("Disabled Slides:", 'acf'); ?></label>
            <p class="description"><?php
		_e("You will not be able to select these LayerSliders", 'acf'); ?></p>
          </td>
          <td>
            <?php
		$sliders = LS_Sliders::find(array(
			'limit' => 100
		));
		$choices = array();
		$choices[0] = '---';
		foreach ($sliders as $f) {
			$choices[$f['id']] = empty($f['name']) ? 'Unnamed' : $f['name'];
		}
		do_action('acf/create_field', array(
			'type' => 'select',
			'name' => 'fields[' . $key . '][disable]',
			'value' => $field['disable'],
			'multiple' => '1',
			'allow_null' => '0',
			'choices' => $choices,
			'layout' => 'horizontal',
		));
?>
          </td>
      </tr>
      <tr class="field_option field_option_<?php
		echo $this->name; ?>">
          <td class="label">
            <label><?php
		_e("Allow Null?", 'acf'); ?></label>
          </td>
          <td>
            <?php
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
?>
          </td>
      </tr>
      <tr class="field_option field_option_<?php
		echo $this->name; ?>">
          <td class="label">
            <label><?php
		_e("Select Multiple?", 'acf'); ?></label>
          </td>
          <td>
            <?php
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
?>
          </td>
      </tr>
      <tr class="field_option field_option_<?php
		echo $this->name; ?>">
          <td class="label">
            <label><?php
		_e("Hide disabled Slides?", 'acf'); ?></label>
          </td>
          <td>
            <?php
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields[' . $key . '][hide_disabled]',
			'value' => $field['hide_disabled'],
			'choices' => array(
				1 => __("Yes", 'acf') ,
				0 => __("No", 'acf') ,
			) ,
			'layout' => 'horizontal',
		));
?>
          </td>
      </tr>
    <?php
	}
	
	function input_admin_enqueue_scripts() {
	}
	
	function input_admin_head() {
	}
	
	function field_group_admin_enqueue_scripts() {
	}
	
	function field_group_admin_head() {
	}
}

new WPPress_LayerSlider_ACF_Field();
