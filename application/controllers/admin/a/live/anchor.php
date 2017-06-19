<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @since 2015年5月24日10:19:53
 * @author xml    
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Anchor extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( '/live/anchor_model', 'anchor_model' );
	}
	
	/**
	 * @method 直播会员列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function index()
	{
		
		$data['pageData']=$this->anchor_model->get_anchor(array('status'=>1),$this->getPage ());
		//var_dump($data['pageData']);
		//echo $this->db->last_query();		 
		$this->load_view ( 'admin/a/live/anchor',$data);
	}
	/**
	 * @method 直播会员分页,查询
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function indexData() {
		$page = $this->getPage ();
		$city=$this->input->post('city',true);
		if($city>0){
			$param = $this->getParam(array('status','realname','name','mobile','city','type'));
		}else{
			$param = $this->getParam(array('status','realname','name','mobile','type'));
		}
		//var_dump($param);
		$data = $this->anchor_model->get_anchor ( $param , $page);
		echo  $data ;
	}
           
       	/**
	 * @method 直播会员详情
	 * @author xml
	 * @since  2016-5-24 
	 */
       	public  function getLiveAnchor(){
       		$id=$this->input->post('id',true);
       		if($id>0){
			$data=$this->anchor_model->get_anchor_detail($id);
			if(!empty($data)){
				$data['live_anchor'] = trim(base_url(''),'/').$data['live_anchor'];
				$data['photo'] = trim(base_url(''),'/').$data['photo'];												
				$data['idcard'] = trim(base_url(''),'/').$data['idcard'];
				$data['idcardconpic'] = trim(base_url(''),'/').$data['idcardconpic'];					
			}			
			echo json_encode($data);
       		}else{
                                echo json_encode(array('code'=>2000,'msg'=>'获取数据失败'));
       		}

       	}
       	  /**
	 * @method 直播会员通过,拒绝操作
	 * @author xml
	 * @since  2016-5-24 
	 */
       	public function through_anchor(){
       		$id=$this->input->post('id',true);
       		$type=$this->input->post('type',true);
       		if($id>0){
				$data=$this->anchor_model->get_anchor_detail($id);
				if(empty($data)){
					echo json_encode(array('code'=>4000,'msg'=>'该主播不存在'));
					exit;
				}
				//获取用户id
				$mid=$this->anchor_model->get_userid($id);
       			if($type==1){  //通过申请
       				$re=$this->anchor_model->update(array('status'=>2,'is_anchor'=>1),array('anchor_id'=>$id));
       				if($re){
       					$content="通过主播审核";
       					if (!empty($mid)){
       						$u_data=$this->db->query("select if_anchor from u_member where mid={$mid}")->row_array();
       						if (empty($u_data['if_anchor'])){
       							$this->config->load('integral'); //加载积分的配置
       							$integral_config=$this->config->item('integral_config');
       							//积分记录
       							$this->record_integration($mid, $integral_config['anchor_reward'], $content, 1, time(),0,array());
       							$this->db->update('u_member',array('if_anchor'=>1),array('mid'=>$mid));
       						}
       						$insertArr=array(
       								's_title'=>'申请主播成功',
       								's_content'=>'恭喜您成为帮游的主播，精彩的帮游直播需要您给观众带来更多的优质内容',
       								'from'=>2, //1、帮游管家 2、帮游直播 3、帮游产品
       								's_time'=>time(),
       								's_type'=>4,
       								'link_param'=>'',
       								'mid'=>$mid
       						);
       						$this->db->insert('u_system_notify',$insertArr);//系统通知记录
       					}
						//发送短信
						$mobile = $data['mobile'];
						if($mobile){
							$this ->send_message($mobile ,'恭喜您，您的主播身份申请已被通过，请开始您精彩的直播吧 【一帮一游】');							
						}
       					echo json_encode(array('code'=>4000,'msg'=>'申请成功'));
       				}else{
					echo json_encode(array('code'=>4000,'msg'=>'申请失败'));
       				}
       			}elseif($type==2){  //拒绝申请
       				$refuse_reasion=$this->input->post('refuse_reasion',true);
       				$refuseArr=array(
       						'modtime'=>date("Y-m-d H:i:s",time()),
       						'status'=>3,
       						'refuse_reason'=>$refuse_reasion		
       					);
       				$re=$this->anchor_model->update($refuseArr,array('anchor_id'=>$id));
       				if($re){
						//发送短信
						$mobile = $data['mobile'];
						if($mobile){
							$this ->send_message($mobile ,'很遗憾，您的主播身份申请未通过，您可继续完善申请资料，并保证资料真实性，并再次申请 【一帮一游】');							
						}	
						$insertArr=array(
								's_title'=>'申请主播未通过',
								's_content'=>'很遗憾，您的主播申请未通过审核，请确保提交资料完整有效后重新提交申请',
								'from'=>2, //1、帮游管家 2、帮游直播 3、帮游产品
								's_time'=>time(),
								's_type'=>7,
								'link_param'=>'',
								'mid'=>$mid
						);
						$this->db->insert('u_system_notify',$insertArr);//系统通知记录
       					echo json_encode(array('code'=>4000,'msg'=>'拒绝成功'));
       				}else{
					echo json_encode(array('code'=>4000,'msg'=>'拒绝失败'));
       				}
       			}else{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));
       			}
       			
       		}else{
 			echo json_encode(array('code'=>4000,'msg'=>'操作失败'));
       		}

       	}

       	/**
       	 * 记录积分及更新用户积分数据
       	 * @author: 张允发
       	 * @param:$member_id 用户id
       	 * @param:$up_arr 更新数据的数组
       	 * @param:$point 操作的积分数
       	 * @param:$add 是否增加更新的参数，默认为0
       	 * @param:$content 说明
       	 * @param:$type 操作积分的类型 1为获取2为扣除
       	 * @param:$time 时间
       	 * @return: boolean
       	 */
       	protected function record_integration($member_id,$point,$content,$type=1,$time,$add=0,$up_arr=array())
       	{
       		$member_id = intval($member_id);
       		$this->load->model('app/u_member_model', 'mm_model');
       		$this->load->model('app/u_member_points_log_model', 'points_log_model');//用户积分记录模型
       		$data=$this->db->query("SELECT integral FROM u_member WHERE mid=$member_id")->row_array();
       		if(empty($data)) return FALSE;
       		if ($type == 1)
       		{
       			$point_after = $data['integral']+$point;
       		}else if($type == 2)
       		{
       			$point_after = $data['integral']-$point;
       		}else
       		{
       			return FALSE;
       		}
       		$log_data=array(
       				'member_id'=>$member_id,
       				'point_before'=>$data['integral'],  //操作前的积分数
       				'point'=>$point,	//本次操作的积分数
       				'point_after'=>$point_after,  //操作后的积分数
       				'content'=>$content,
       				'time'=>$time,	//获得积分的时间
       				'type'=>$type    //积分类型(1为获得,2为扣除)
       		);
       		$update_arr = array('integral'=>$point_after);
       		if (!empty($add))
       		{
       			$update_arr+=$up_arr;
       		}
       		//用户积分及登录时间更新
       		$res=$this->mm_model->update($update_arr,array('mid'=>$member_id));
       		if ($res)
       		{
       			//积分记录
       			$result=$this->points_log_model->insert($log_data);
       			if ($result)
       			{
       				return TRUE;
       			}
       		}
       		return FALSE;
       	}
	
}