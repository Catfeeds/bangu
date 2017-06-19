<?php
/**
 * @method 体验师
 * @since  2015-06-24
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_experience_model extends MY_Model {
	private $table_name = 'u_member_experience';

    function __construct() {
        parent::__construct($this ->table_name);
    }
	
    /**
     * @method 获取体验师数据
     * @param array $whereArr 查询条件
     * @param number $page_new 当前分页
     * @param number $number 每页条数
     * @param number $is_page 是否分页
     * @param array $likeArr 模糊搜索条件
     */
    public function get_expertience_data ($whereArr ,$page_new =1 ,$num =5 ,$likeArr = array()) {
    	$whereStr = '';
    	$limitStr = '';
    	$likeStr = '';
    	if (!empty($whereArr) && is_array($whereArr)) {
    		foreach($whereArr as $key =>$val) {
    			$whereStr .= " $key='$val' and";
    		}
    	}
    	if (!empty($likeArr) && is_array($likeArr)) {
    		foreach($likeArr as $key =>$val) {
    			$likeStr .= " $key like '%$val%' and";
    		}
    	}
    	if (empty($likeStr)) {
    		$whereStr = rtrim($whereStr ,'and');
    	} else {
    		$whereStr = $whereStr.rtrim($likeStr ,'and');
    	}
    	
    	if ($page_new > 0)
    	{
    		$num = empty ( $num ) ? 10 : $num;
    		$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $num;
    		$limitStr = " limit {$offset} ,{$num} ";
    	}
    	$sql = "select me.consult_count,me.order_count,me.id,m.litpic,m.truename,a.name as city_name,m.talk,m.qrcode,m.sex,m.nickname,me.member_id,m.travel_count from u_member_experience as me left join u_member as m on m.mid = me.member_id left join u_area as a on m.city=a.id left join u_experience_dest as ed on me.member_id = ed.member_id where $whereStr group by me.id $limitStr";
    	return $this ->db ->query($sql) ->result_array();
    }
    /**
     * @method 获取体验师去过的目的地
     * @param unknown $id 会员id
     */
    public function get_expertience_dest($id) {
    	$this ->db ->select('d.kindname');
    	$this ->db ->from('u_dest_base as d');
    	$this ->db ->join('u_experience_dest as ed' ,'d.id = ed.dest_id' ,'left');
    	$this ->db ->where('ed.member_id' ,$id);
    	$this ->db ->limit(2,0);
    	return $this ->db ->get() ->result_array();
    }
}
