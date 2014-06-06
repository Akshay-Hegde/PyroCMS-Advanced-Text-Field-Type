<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Advanced Text Field Type
 *
 * @package		PyroCMS Field Types
 * @author		AFBora
 * @copyright	Copyright (c) 2014, Code Qube
 * @link		http://www.codeqube.com/
 */
 
class Field_advanced_text
{
	public $field_type_name			= 'Advanced Text';
	public $field_type_slug			= 'advanced_text';
	public $db_col_type				= 'varchar';
	public $version					= '1.0.0';
	public $author					= array('name'=>'AFBora', 'url'=>'http://www.codeqube.com/');
	public $custom_parameters		= array('mode', 'max_length', 'default_value');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{		
		if ($data['custom']['mode'] == "hidden")
		{			
			return form_hidden($data['form_slug'], $data['value']);
		}
		else
		{
			$options['name'] 	= $data['form_slug'];
			$options['value']	= $data['value'];
			$options['id']		= $data['form_slug'];
		
			if (isset($data['max_length']) and is_numeric($data['max_length']))
			{
				$options['maxlength'] = $data['max_length'];
			}
		
			if ($data['custom']['mode'] == "readonly")
			{
				$options['readonly'] = "readonly";
			}
			
			if ($data['custom']['mode'] == "disabled")
			{
				$options['disabled'] = "disabled";
			}
			
			return form_input($options);
		}
	}
	
	/**
     * Process before saving to database
     *
     * @access	public
     * @param	float
     * @param	object
     * @return	string
     */
    public function pre_save($input, $field)
    {
		// return nothing if input mode disabled because of missing data
        if ( $field->field_data['mode'] != "disabled" ) 
		{
            return $input;
        }
    }
	
	/**
     * Input Mode
     *
     * Normal Text Input
	 * Hidden Text Input
	 * Readonly Text Input
	 * Disabled Text Input
	 *
     * @return	string
     */
    public function param_mode( $value = 'normal')
    {
        return form_dropdown('mode', array(	'normal' => lang('streams:advanced_text.normal'), 
											'hidden' => lang('streams:advanced_text.hidden'), 
											'readonly' => lang('streams:advanced_text.readonly'), 
											'disabled' => lang('streams:advanced_text.disabled')
										), $value ?: 'normal');
    }

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No PyroCMS tags in text input fields.
	 *
	 * @return string
	 */
	public function pre_output($input)
	{
		$this->CI->load->helper('text');
		return escape_tags($input);
	}
	
	
	/**
	 * Event
	 *
	 * Add required assets
	 *
	 * @return void
	 */
	public function event($field)
	{
		$this->CI->type->add_js('advanced_text', 'advanced_text.js');
	}
}