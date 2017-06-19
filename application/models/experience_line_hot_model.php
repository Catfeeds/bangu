<?php
/**
 * @method 热门体验线路
 * @since  2015-06-25
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Experience_line_hot_model extends MY_Model {
	protected  $table_name = 'cfg_experience_line_hot';

    function __construct() {
        parent::__construct($this ->table_name);
    }
    /**
     * @method 获取热门体验线路
     * @param array $whereArr 查询条件
     * @param number $page_new 当前分页
     * @param number $number 每页条数
     * @param number $is_page 是否分页
     */
    public function get_line_hot_data ($whereArr ,$page_new =1 ,$number =10 ,$is_page =1) {
    	$this ->db ->select('l.id,elh.pic,l.linename,l.lineprice,l.overcity');
    	$this ->db ->from($this ->table_name .' as elh');
    	$this ->db ->join( 'u_line as l' ,'l.id = elh.line_id' ,'left');
    	$this ->db ->where($whereArr);
    	 
    	$this ->db ->order_by('showorder' ,'asc');
    	if ($is_page == 1) {
    		$number = empty($number) ? 10 :$number;
    		$page_new = empty($page_new) ? 1 : $page_new;
    		$offect = ($page_new - 1) * $number;
    		$this ->db ->limit ($number ,$offect);
    	}
    	$query = $this->db->get();
    	return $query->result_array();
    }
}
