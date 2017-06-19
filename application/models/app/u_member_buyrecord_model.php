<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 
 * 商城购买记录模型
 * @author zyf
 * @since 2017-1-13
 */
class u_member_buyrecord_model extends MY_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_member_buy_record';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}