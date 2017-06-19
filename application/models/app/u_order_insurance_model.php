<?php
/**
 * 日志
 *
 * @author wenwenbin
 * @time 2015-11-14   
 */
class U_order_insurance_model extends MY_Model {	
	/**
	 * 模型表名称: 订单保险
	 * 
	 * @by zhy
	 * 2015年10月20日 09:42:45
	 */
	private $table_name = 'u_order_insurance';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}
