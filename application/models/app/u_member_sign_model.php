<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 
 * 用户签到模型
 * @author zyf
 * @time 2016-12-14
 */
class u_member_sign_model extends MY_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_member_sign';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}