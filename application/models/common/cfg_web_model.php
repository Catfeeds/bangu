<?php
/**
 * 网站配置模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfg_web_model extends MY_Model {
	
	private $table_name = 'cfg_web';
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取站点配置 ,现用于下单流程
	 */
	public function getOrderWebData() {
		$sql = 'select breach_tips,contract,supplement_clause,safety_tips,travel_contract_domestic,travel_contract_abroad,serverIp from cfg_web where id=1';
		return $this ->db ->query($sql) ->result_array();
	}
}