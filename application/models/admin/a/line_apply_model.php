<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_apply_model extends MY_Model
{
	private $table_name = 'u_line_apply';
	
	function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取地区数据，用于平台管理 
	 * @param array $whereArr
	 */
}
