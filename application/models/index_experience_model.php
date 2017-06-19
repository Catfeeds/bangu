<?php
/**
 * @method 首页体验师
 * @since  2015-06-26
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_experience_model extends MY_Model {
	protected $table_name = 'cfg_index_experience';

    function __construct() {
        parent::__construct($this ->table_name);
    }
	
    /**
     * @method 获取首页体验师数据
     * @param array $whereArr 查询条件
     * @param number $page_new 当前分页
     * @param number $number 每页条数
     */
    public function get_expertience_data ($whereArr ,$page_new =1 ,$number =10 ) {
    	$this ->db ->select('ie.pic,,m.nickname,m.litpic,m.mid,m.city,m.talk,a.name as city_name,(select mo.productname from u_member_order as mo where status >= 5 and mo.memberid = m.mid  order by mo.id desc limit 1 ) as linename,(select mo.productautoid from u_member_order as mo where status >= 5 and mo.memberid = m.mid order by mo.id desc limit 1 ) as line_id');
    	$this ->db ->from($this ->table_name .' as ie');
    	$this ->db ->join( 'u_member as m' ,'m.mid = ie.member_id' ,'left');
    	$this ->db ->join( 'u_member_experience as me' ,'m.mid = me.member_id' ,'left');
    	$this ->db ->join( 'u_area as a' ,'a.id = m.city' ,'left' );
    	$this ->db ->where($whereArr);
    	
    	$this ->db ->order_by('showorder' ,'asc');
    	
    	$number = empty($number) ? 10 :$number;
    	$page_new = empty($page_new) ? 1 : $page_new;
    	$offect = ($page_new - 1) * $number;
    	$this ->db ->limit ($number ,$offect);
    	
    	$query = $this->db->get();
    	//echo $this ->db ->last_query();
    	return $query->result_array();
    }
}
