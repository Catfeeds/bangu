<?php
/**
 * 评论管理
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月27日11:59:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Comment  extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/comment_model', 'comment' );
	}


	/**
	 * 客户给专家的评论首页列表数据
	 *
	 * @param number $page 页
	 */
	public function index($page = 1) {


		$member_data = $this->comment->get_member_data();
		$expert_data = $this->comment->get_expert_data();
		$supplier_data = $this->comment->get_supplier_data();
                      $data = array(
                      	   'expert_data' => $expert_data,
                      	   'member_data'=>$member_data,
                      	   'supplier_data'=>$supplier_data
                      	);
		$this->load_view ( 'admin/a/ui/line/comment', $data);
	}


/**
 * reply_comment 回复评论
 */
	function reply_comment(){
		$comment_id = $this->input->post('comment_id');
		$comment_content = $this->input->post('content');
		if(mb_strlen($comment_content,'UTF8')>50){
			echo json_encode(array('status'=>-200,'msg'=>'回复内容最多五十个字'));
			exit();
		}else{
			$comment_sql = "UPDATE u_comment SET reply2='$comment_content' where id=".$comment_id;
			$this->db->query($comment_sql);
			echo json_encode(array('status' =>200 ,'msg' =>'回复成功'));
			exit();
		}

	}


	/**
	 * 新申诉
	 */
	function new_comment(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr = $this->get_search_condition();
		$new_comment_list = $this->comment->get_new_comment($post_arr, $page, $number);
		$pagecount = count($this->comment->get_new_comment($post_arr));
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $new_comment_list
            	);
		echo json_encode($data);
	}


	/**
	 * 已通过申诉
	 */
	function pass_comment(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr = $this->get_search_condition();
		$pass_comment_list = $this->comment->get_pass_comment($post_arr, $page, $number);
		$pagecount = count($this->comment->get_pass_comment($post_arr));
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $pass_comment_list
            	);
		echo json_encode($data);
	}

	/**
	 * 已拒绝申诉
	 */
	function refuse_comment(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr = $this->get_search_condition();
		$refuse_comment_list = $this->comment->get_refuse_comment($post_arr, $page, $number);
		$pagecount = count($this->comment->get_refuse_comment($post_arr));
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $refuse_comment_list
            	);
		echo json_encode($data);
	}


	/**
	 * 已删除申诉
	 */
	function delete_comment(){

		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr = $this->get_search_condition();
		$delete_comment_list = $this->comment->get_delete_comment($post_arr, $page, $number);
		$pagecount = count($this->comment->get_delete_comment($post_arr));
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $delete_comment_list
            	);
		echo json_encode($data);
	}

	/**
	 * 全部申诉
	 */
	function all_comment(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr = $this->get_search_condition();
		$all_comment_list = $this->comment->get_all_comment($post_arr, $page, $number);
		$pagecount = count($this->comment->get_all_comment($post_arr));
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $all_comment_list
            	);
		echo json_encode($data);
	}


	/**
	 * 获取查询条件
	 */
	function get_search_condition(){
		 $line_name = $this->input->post('line_name', true);
       		 $member_id = $this->input->post('member_id', true);
       		 $comment_time = $this->input->post('comment_time', true);
       		 $expert_id = $this->input->post('expert_id', true);
       		$supplier_id = $this->input->post('supplier_id', true);
		$post_arr = array();
		if(!empty($line_name)){
			$post_arr['l.linename LIKE '] = '%'.$line_name.'%';
		}
		if(!empty($member_id)){
			$post_arr['m.mid'] = $member_id;
		}
		if(!empty($expert_id)){
			$post_arr['c.expert_id'] = $expert_id;
		}
		if(!empty($supplier_id)){
			$post_arr['l.supplier_id'] = $supplier_id;
		}

		if (!empty($comment_time)) {
			$usedata_arr = explode(' - ',$comment_time);
			$start_date_arr = explode('-',$usedata_arr[0]);
                                $start_date = $start_date_arr[0].'-'.$start_date_arr[2].'-'.$start_date_arr[1];
                                $end_date_arr = explode('-',$usedata_arr[1]);
                                $end_date = $end_date_arr[0].'-'.$end_date_arr[2].'-'.$end_date_arr[1];
			$post_arr['c.addtime >='] = $start_date.' 00:00:00';
			$post_arr['c.addtime <='] = $end_date.' 23:59:59';
		}
		return $post_arr;
	}

	function ajax_pass(){
		$cm_id = $this->input->post('cm_id',true);
		$cmp_id = $this->input->post('cmp_id',true);
		$expert_id = $this->input->post('expert_id',true);
		$line_id = $this->input->post('line_id',true);

		$cmp_sql = 'UPDATE u_comment_complain SET STATUS=1 WHERE id='.$cmp_id;
		$cm_sql = 'UPDATE u_comment SET isshow=0 WHERE id='.$cm_id;
		$expert_sql = 'UPDATE u_expert SET comment_count = comment_count-1 WHERE id='.$expert_id;
		$line_sql = 'UPDATE u_line SET comment_count = comment_count-1 WHERE id='.$line_id;
		$this->db->trans_start();
		$this->db->query($cmp_sql);
		$this->db->query($cm_sql);
		$this->db->query($expert_sql);
		$this->db->query($line_sql);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			echo 'Fail';
		}else{
			//删除首页缓存
			$this->cache->redis->delete('SYhomeComment');
			echo 'Success';
		}

	}

	function ajax_refuse(){
		$cm_id = $this->input->post('cm_id',true);
		$cmp_id = $this->input->post('cmp_id',true);
		$cmp_sql = 'UPDATE u_comment_complain SET STATUS=2 WHERE id='.$cmp_id;
		$cm_sql = 'UPDATE u_comment SET isshow=1 WHERE id='.$cm_id;
		$this->db->query($cmp_sql);
		$this->db->query($cm_sql);
		echo 'Success';
	}

	function ajax_delete(){
		$cm_id = $this->input->post('cm_id',true);
		$cm_sql = 'UPDATE u_comment SET isshow=0,status=0 WHERE id='.$cm_id;
		$this->db->query($cm_sql);
		echo 'Success';
	}
}