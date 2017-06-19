<?php
/**
 * @method 数据库字典
 * @since  2015-06-08
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dictionary_model extends MY_Model {


    function __construct() {
        parent::__construct('u_dictionary');
    }
	/**
	 * @method 通过唯一识别码查询其下级
	 * @param string $code 唯一识别码
	 */
    public function get_dictionary_data ($code) {
    	$sql = "select d.* from u_dictionary as d where pid = (select ud.dict_id from u_dictionary as ud where ud.dict_code = '{$code}')";
    	return $this ->db ->query($sql) ->result_array();
    }
}
