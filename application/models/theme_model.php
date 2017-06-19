<?php
/**
 * @method 主题
 * @since  2015-06-08
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Theme_model extends MY_Model {


    function __construct() {
        parent::__construct('u_theme');
    }
    
    /**
     * @method 通过一组id获取数据
     * @author jiakairong
     * @since  2015-11-14
     * @param unknown $ids
     */
    public function getThemeInData($themeids) {
    	$sql = 'select id,name from u_theme where id in ('.$themeids.')';
    	return $this ->db ->query($sql) ->result_array();
    }
}
