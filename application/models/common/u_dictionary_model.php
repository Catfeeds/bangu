<?php
/**
 * 网站配置模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_dictionary_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_dictionary';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 通过唯一标识获取其下级
	 * @author jiakairong
	 * @param string $code
	 */
	public function getDictCodeLower($code){
		$sql = "select d.dict_id,d.description,dict_code from u_dictionary as d where d.pid = (select ud.dict_id from u_dictionary as ud where ud.dict_code = '{$code}')";
		return $this ->db ->query($sql) ->result_array();
	}
}