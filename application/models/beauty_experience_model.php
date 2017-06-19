<?php
/**
 * @method 最美体验师
 * @since  2015-06-08
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Beauty_experience_model extends MY_Model {
	protected $table_name = 'cfg_beauty_experience';

    function __construct() {
        parent::__construct($this ->table_name);
    }
	
    /**
     * @method 获取最美体验师数据
     * @param array $whereArr 查询条件
     * @param number $page_new 当前分页
     * @param number $number 每页条数
     * @param number $is_page 是否分页
     */
    public function get_beauty_expertience_data ($whereArr ,$page_new =1 ,$number =10 ,$is_page =1) {
    	$this ->db ->select('m.truename,be.pic,be.id,be.member_id,be.beizhu,m.nickname,d.dest_id');
    	$this ->db ->from($this ->table_name .' as be');
    	$this ->db ->join( 'u_member as m' ,'m.mid = be.member_id' ,'left');
		$this ->db ->join( 'u_experience_dest as d' ,'d.member_id = m.mid' ,'left');
    	$this ->db ->where($whereArr);
    	
    	$this ->db ->order_by('showorder' ,'asc');
    	if ($is_page == 1) {
    		$number = empty($number) ? 10 :$number;
    		$page_new = empty($page_new) ? 1 : $page_new;
    		$offect = ($page_new - 1) * $number;
    		$this ->db ->limit ($number ,$offect);
    	}
    	$query = $this->db->get();
		//echo $this ->db ->last_query();
    	return $query->result_array();
    }
}
