<?php
/**
 * @copyright 深圳海外国际旅行社有限公司   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Consult_detail extends UC_NL_Controller {
	
/* 	private $whereArr = array('e.status' =>2); //保存管家的搜索条件
	private $dataArr = array();//保存视图层的数据
	private $postArr = array();//搜索条件 */
	
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'consult_model', 'consult_model' );
	}
	//资讯列表页
	public function index($id){
		$id=intval($id);
		if($id>0){
			//资讯详情
			$data['consult']=$this->consult_model->all(array('id'=>$id));
			//点赞总数
			$data['zan']=$this->consult_model->point_sum($id);
			//点赞
			$this->load->library('session');
			$user_id=$this->session->userdata('c_userid');
			if($user_id>0){
				$data['hit_zan']=$this->consult_model->get_rowdata('u_consult_praise',array('member_id'=>$user_id,'consult_id'=>$id));
			}
			//人气
			$shownum=$data['consult'][0]['shownum']+1;
			$this->consult_model->update(array('shownum'=>$shownum),array('id'=>$id));
			//线路	
			if(!empty($data['consult'][0]['dest_id'])){
				$data['line']=$this->consult_model->get_line_data($data['consult'][0]['dest_id']);
			}else{
				$data['line']='';
			}

			//查询目的地
 			if(!empty($data['consult'][0]['dest_id'])){
				$this->load_model( 'member_model', 'member');
				$data['overcity'] = $this->member->getDestinationsId(explode(",",$data['consult'][0]['dest_id']));
			} 
			//旅游攻略
			if(!empty($data['consult'][0]['dest_id'])){
				$data['d_consult']=$this->consult_model->get_match_consult($data['consult'][0]['dest_id'],$id);
				//echo $this->db->last_query();
			}else{
				$data['d_consult']='';
			} 
			if(!empty($data['consult'][0]['type'])){
				$where=' and type='.$data['consult'][0]['type'];
			}else{
				$where='';
			}
			//上一条
			$data['prev_consult']=$this->consult_model->get_prev_data($id,$where);
			//下一条
			$data['next_consult']=$this->consult_model->get_next_data($id,$where);
		
			$this->load->view ( 'consult/consult_detail',$data );
		}else{
			echo "<script>alert('不存在该条资讯!');window.history.back(-1);</script>";
		}
	}
	//点赞
	function click_praise(){
		$user_id=intval($this->input->post('user_id'));
		$consult_id=intval($this->input->post('consult_id'));
		$ip=$_SERVER["REMOTE_ADDR"];
		$data=array(
				'member_id'=>$user_id,
				'consult_id'=>$consult_id,
				'addtime'=>date('Y-m-d H:i:s'),
				'ip'=>$ip,
		);
		if($consult_id>0){
			$consult=$this->consult_model->get_rowdata('u_consult_praise',array('consult_id'=>$consult_id,'member_id'=>$user_id));
			if(!empty($consult)){  //存在就取消点赞
				//delete_table
				$re=$this->consult_model->delete_table('u_consult_praise',array('consult_id'=>$consult_id,'member_id'=>$user_id));
				//var_dump($re);
				if($re){
					echo json_encode(array('status'=>1,'msg'=>'取消成功'));
				}else{
					echo json_encode(array('status'=>-1,'msg'=>'取消失败'));
				}
			}else{   //插入点赞
				$id=$this->consult_model->insert_tableData('u_consult_praise',$data);
				if($id>0){
					echo json_encode(array('status'=>1,'msg'=>'点赞成功'));
				}else{
					echo json_encode(array('status'=>-1,'msg'=>'点赞失败'));
				}
				//$id=$this->consult_model->update_tableDate('u_consult_praise',$data);
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'点赞失败'));
		}
	}
}

