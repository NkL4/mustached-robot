<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Help display a message error for the form */
if ( ! function_exists('msg_error'))
{
	function msg_error($errors = array())
	{
		$CI =& get_instance();
		$content = '<ul>';
		foreach($errors as $error)
		{
			$content .= '<li>'.$error.'</li>'; 
		}
		$content .= '</ul>';
		return array('type' => 'error', 'content' => $content);
	}
}

/* Help display a generic message */
if ( ! function_exists('user_message'))
{
	function user_message($type, $content)
	{
		return array(
			'msg' => array(
				'type'    => $type, 
				'content' => $content
			)
		);
	}
}


/* Help set flash message */
if ( ! function_exists('flash_message'))
{
	function flash_message($type, $content)
	{
		$CI =& get_instance();
		return $CI->session->set_flashdata(user_message($type, $content));
	}
}

/* Function set_stropdown_array
 * Help set associative array for form_dropdown from a datamapper object 
 * For instance, this function transforms array(1 => array("x-small" => "Xtra Small"), 2 => array("x-large" => "Xtra Large")) into array("x-small" => "Xtra small", "x-large" => "Xtra large")
 *
 * @param $items array of associative array as returned by datamapper's all_to_array function (see http://datamapper.wanwizard.eu/pages/extensions/array.html)
 * @param $key_name string name of the key to return 
 * @param $value_name string name of the value 
 * @return array associative array 
 */

if ( ! function_exists('set_dropdown_array'))
{
	function set_dropdown_array($items, $key_name, $value_name)
	{
		$array = array();
		foreach($items as $item)
		{
			$array[$item[$key_name]] = $item[$value_name];			
		}
		return $array;
	}
}