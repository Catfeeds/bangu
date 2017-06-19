<?php
/**
 * @method 主题
 * @since  2015-06-08
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Line_attr_model extends MY_Model {


    function __construct() {
        parent::__construct('u_line_attr');
    }
    
    /**
     * @method 通过一组id获取数据
     * @author jiakairong
     * @since  2015-11-14
     * @param unknown $ids
     */
    public function getAttrInData($ids) {
    	$sql = 'select id,attrname as name,pid from u_line_attr where id in ('.$ids.')';
    	return $this ->db ->query($sql) ->result_array();
    }
}
