<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:11
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exchange_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_exchange';

	public function __construct() {
		parent::__construct($this->table_name);
	}

/**
 * [get_cash_record 获取提现记录]
 * @return [type] [description]
 */
function get_cash_record($whereArr, $page = 1, $num = 10){
         	 if($page > 0){
                    	 $res_str ='
                    	 	addtime,
	                      	serial_number,
                    	 	approve_type,
	                      	bankname,
	                      	amount,
	                      	status,
	                      	beizhu';
                    }else{
                    	   $res_str = 'count(*) AS num';
                    }
	 $this->db->select($res_str);
	 $this->db->where($whereArr);
	 $this->db->from('u_exchange');
	 $this->db->order_by('addtime','desc');
	 if ($page > 0) {
		$offset = ($page-1) * $num;
		$this->db->limit($num, $offset);
		$result=$this->db->get()->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}else{
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr[0]['num'];
	}

}

function update_expert_amount($amount,$expert_id){
	$update_expert_amount_sql = 'update u_expert set amount=amount-'.$amount.' where id='.$expert_id;
	$status = $this->db->query($update_expert_amount_sql);
	return $status;
}

/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if($value['status']=='0'){
			$value['status']='审核中';
		}elseif($value['status']=='1'){
			$value['status']='已通过';
		}else{
			$value['status']='已拒绝';
		}
	}
}