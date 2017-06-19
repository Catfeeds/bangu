<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_Roll_Pic_model extends MY_Model {

    private $table_name = 'cfg_index_roll_pic';   // 魏勇编辑,将cfg_index_roll_pic改为cfgm_index_roll_pic
    //private $table_name = 'cfgm_index_roll_pic'; 
    public function __construct() {
        parent::__construct($this->table_name);
    }

    /**
     * @method 获取轮播图数据
     * @author jiakairong
     * @since  2016-02-26
     * @param array $whereArr
     */
    public function getRollPicData(array $whereArr = array()) {
        $sql = 'select * from cfg_index_roll_pic';
        return $this->getCommonData($sql, $whereArr, 'id desc');
    }

    /**
     * method 获取轮播图数据
     * @author weiyong
     * @since 2016-10-21 15:38:31
     * @param array $whereArr
     */
    public function getRollPicDataNew(array $whereArr = array()) {
        $sql = 'SELECT * FROM cfgm_index_roll_pic';
        return $this->getCommonData($sql, $whereArr, 'id desc');
    }

}
