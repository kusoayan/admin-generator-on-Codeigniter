<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Variable Helper
 **/

/**
 * 增加過濾變數是否存在
 * 含isset判斷.
 *
 * @param	mixed
 * @return	bool
 */	
if ( ! function_exists('v'))
{
	function v( &$var )
	{
		if ( isset($var) )
		{
			return $var;
		}
		return FALSE;
	}	
}

/* End of file variable_helper.php */
/* Location: ./application/helpers/variable_helper.php */
