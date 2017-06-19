<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月7日10:52:32
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends MY_Model {

	public function __construct() {
		parent::__construct('u_message');
	}

	public function messages_row( $id){
		$query_sql  ='select me.id ,me.addtime ,me.title ,ad.realname ,me.content	';
		$query_sql.='FROM u_message AS me	';
		$query_sql.='LEFT JOIN u_admin AS ad ON me.admin_id = ad.id	';
		$query_sql.='where me.id='.$id;
		$query = $this->db->query($query_sql);
		return $query->row_array();
	}





	public function system_row($whereArr,$page=1, $num = 10,$post_ar) {
			if($page>0){
             $res_str =" `n`.`id`,`n`.`title`,`n`.`addtime`,`n`.`notice_type`,`n`.`id` IN
  					(SELECT nr.notice_id FROM u_notice_read AS nr  WHERE FIND_IN_SET(1,nr.notice_type)>0  AND nr.userid = {$post_ar} AND n.id = nr.notice_id ) AS isread ";
            }else{
                 $res_str = 'count(*) AS num';
            }
            if($page==0){
            	$page=1;
            }
            $offset = ($page - 1) * $num;
	  	$sql="SELECT {$res_str } FROM (`u_notice` AS n)  where {$whereArr}  GROUP BY `n`.`id` ORDER BY `n`.`addtime` DESC   limit  {$offset},{$num} ";
		if ($page > 0) {
			$query = $this->db->query($sql);
			return $query->result_array();
		}else{
			$query = $this->db->query($sql);
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}

	}

	public function get_system_message($whereArr, $where='',$userid,$page = 1, $num = 10){

		if(empty($where)){
		   $whereArr=($whereArr);
		   $kk='and';
		}else{
			$whereArr="";
			 $kk='';
		}



		$offset = ($page -1) * $num;
$reDataArr = $this->db->query ( "SELECT   `n`.`id`,`n`.`title`,`n`.`addtime`,`n`.`notice_type`, `n`.`id` IN (SELECT nr.notice_id FROM u_notice_read AS nr  WHERE FIND_IN_SET(1,nr.notice_type)>0 AND nr.userid = {$userid} AND n.id = nr.notice_id ) AS isread FROM u_notice AS n WHERE    n.`id` NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE FIND_IN_SET(1,nr.`notice_type`)>0 AND nr.`userid`={$userid} AND nr.`status`=0) AND {$whereArr} {$kk}  FIND_IN_SET(1,n.`notice_type`)>0 GROUP BY `n`.`id` ORDER BY `n`.`addtime` DESC limit  {$offset},{$num} ")->result_array ();


		// $this->db->select('*');
		// $this->db->from('u_message');
		// $this->db->where($whereArr);
		// if(!empty($where)){
		   // $this->db->where($where);
		// }
		// $this->db->order_by('addtime', 'desc');

		// if ($page > 0) {
			// $offset = ($page -1) * $num;
			// $this->db->limit($num, $offset);
		// }
		// $query = $this->db->get();
		// $result = $query->result_array();

		return $reDataArr;
	}

	public function system_data($id){
		$query_sql  ='select n.id,n.title ,n.addtime ,a.realname ,n.content ,n.attachment ';
		$query_sql.=' FROM u_notice AS n';
		$query_sql.=' left JOIN u_admin AS a ON n.admin_id = a.id	';
		$query_sql.=' WHERE n.id = '.$id;
		$query = $this->db->query($query_sql);
		return $query->row_array();
	}
	public function get_message($whereArr, $where='',$page = 1, $num = 10){
		$this->db->select('*');
		$this->db->from('u_message');
		$this->db->where($whereArr);
		if(!empty($where)){
		   $this->db->where($where);
		}
		$this->db->order_by('addtime', 'desc');

		if ($page > 0) {
			$offset = ($page -1) * $num;
			$this->db->limit($num, $offset);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}
	//遍历表
	public function sel_data($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table)->row_array();
		return $query;
	}

	function get_msg_count($expert_id){
		$sql = "SELECT * FROM (`u_message`) WHERE `msg_type` = 1 AND `receipt_id` = $expert_id AND `read` >= 0";
		$total_num = $this->getCount($sql,'');
		return $total_num;
	}

	//标记消息已经读过了
	function update_msg_status($id){
		$sql = "UPDATE u_message as m SET m.read=1,m.modtime=now() WHERE id=$id";
		$status = $this->db->query($sql);
		return $status;
	}

	//删除消息数据
	function delete_msg($msg_id){
		$sql = 'UPDATE u_message SET `read`=-1 WHERE id='.$msg_id;
		$status = $this->db->query($sql);
		return $status;
	}

	function delete_public_msg($msg_id){
		$sql = 'UPDATE u_notice_read  SET `status`=-1 WHERE id='.$msg_id;
		$status = $this->db->query($sql);
		return $status;
	}


}