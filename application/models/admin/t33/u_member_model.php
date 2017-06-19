<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:11
 * @author		温文斌
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class U_member_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_member';
	
	public function __construct() 
	{
		parent::__construct($this->table_name);
	}
	
	
	
}