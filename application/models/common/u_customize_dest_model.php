<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
	*
	*        do    customize  city  
	*
	*        by    zhy
	*
	*        at    2016年1月22日 14:07:53
	*
	*/
class U_customize_dest_model extends MY_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_customize_dest';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}