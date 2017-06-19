<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日11:59:53
 * @author		jiakaiorng
 *
 */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sms_template_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_sms_template' );
	}
}