<?php
/**
 * 专家个人中心
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:01
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Line_apply extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/line_apply_model', 'line_apply');
		$this->load->model ( 'admin/b1/user_shop_model' );   //线路详情页用到
		$this ->load_model('startplace_model');
	}

	public function index()
	{
		$cityid = $this->session->userdata('location_city');
		$cityname = '';
		if ($cityid)
		{
			$startData = $this ->startplace_model ->row(array('id' =>$cityid));
			if (empty($startData))
			{
				$cityid = 0;
			}
			else 
			{
				$cityname = $startData['cityname'];
			}
		}
		$dataArr = array(
				'cityid' =>$cityid,
				'cityname' =>$cityname
		);
		$this->view('admin/b2/line_apply' ,$dataArr);
	}
	/**
	 * 管家未申请的线路
	 * @author jkr
	 * @since 2017-03-30
	 */
	public function get_apply_data()
	{
		$whereArr = array(
				'l.status =' =>2,
				'l.producttype =' =>0,
				'l.line_kind =' =>1
		);
		
		$linename = trim($this ->input ->post('linename' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$company_name = trim($this ->input ->post('company_name' ,true));
		$brand = trim($this ->input ->post('brand' ,true));
		$dest = trim($this ->input ->post('dest' ,true));
		$city = trim($this ->input ->post('city' ,true));
		$cityid = intval($this ->input ->post('cityid'));
		$destid = intval($this ->input ->post('destid'));
		
		if (!empty($linename))
		{
			$whereArr['l.linename like'] = '%'.$linename.'%';
		}
		if (!empty($linecode))
		{
			$whereArr['l.linecode like'] = '%'.$linecode.'%';
		}
		if (!empty($company_name))
		{
			$whereArr['s.company_name like'] = '%'.$company_name.'%';
		}
		if (!empty($brand))
		{
			$whereArr['s.brand like'] = '%'.$brand.'%';
		}
		
		//出发城市
		$where_str="";
		$this ->load_model('startplace_child_model');
		if ($cityid) 
		{//选定出发城市id
			//包括子站点
			$child_list= $this ->startplace_child_model ->getChildStartData($cityid);
			$child_arr=array();
			if(!empty($child_list)){
				foreach ($child_list as $k=>$v)
				{
					array_push($child_arr, $v['id']);
				} 
			}
			array_push($child_arr,$cityid);
			$child_str=join(",", $child_arr);
			$whereArr['in']=array(
					'sp.id' =>$child_str
			);
		}
		elseif (!empty($city)) 
		{//模糊搜索
			$startData = $this ->startplace_model ->all(array('cityname like' =>'%'.$city.'%'));
			if (empty($startData))
			{
				echo json_encode(array('data'=>array(),'count' =>0));
				exit;
			}
			else 
			{
				$child_arr=array();
				foreach($startData as $v)
				{
					//子站点
					$child_list= $this ->startplace_child_model ->getChildStartData($v['id']);
					if(!empty($child_list)){
						foreach ($child_list as $m=>$n)
						{
							array_push($child_arr, $n['id']);
						} 
					}
					array_push($child_arr,$v['id']);
				}
				$child_str=join(",", $child_arr);
				$whereArr['in'] = array(
						'sp.id' =>$child_str
				);
			}
		}
		//目的地
		if ($destid)
		{
			$whereArr['find_in_set'] = array(
					'l.overcity' =>array($destid)
			);
		}
		elseif (!empty($dest))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->all(array('kindname like' =>'%'.$dest.'%'));
			if (empty($destData))
			{
				echo json_encode(array('data'=>array(),'count' =>0));
				exit;
			}
			else
			{
				$ids = '';
				foreach($destData as $v)
				{
					$ids .= $v['id'].',';
				}
				$whereArr['find_in_set'] = array(
						'l.overcity' =>array(rtrim($ids ,','))
				);
			}
		}
		
		$dataArr = array(
				'data' =>$this ->line_apply ->getLineApplyData($whereArr ,$this ->expert_id ,'la.id is null'),
				'count' =>$this ->line_apply ->getLineApplyCount($whereArr ,$this ->expert_id ,'la.id is null')
		);
		//echo $this ->db ->last_query();exit;
		echo json_encode($dataArr);
	}
	/**
	 * 专家未申请的线路
	 *
	 * @param number $page	页
	 */
	public function index1($page = 1) {
		$post_arr = array();//查询条件数组
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/line_apply/index/';
		$config ['pagesize'] = 15;
		$config ['page_now'] = $this->uri->segment (5, 0);
		$post_arr = $this->get_search_condition($this->uri->segment (5), $this->is_post_mode());
		$page = $page==0 ? 1:$page;
		$config ['pagecount'] = $this->line_apply->get_line_no_apply_detail($post_arr, 0, $config['pagesize']);
		$config ['pagecount']=count($config ['pagecount'] );
		//print_r($post_arr);exit();
		$line_apply_list = $this->line_apply->get_line_no_apply_detail($post_arr, $page, $config['pagesize']);
		//print_r($this->db->last_query());exit();
		$destinations = $this->line_apply->get_destinations();
		$suppliers = $this->line_apply->get_suppliers();
		$data = array(
			'line_apply_list' 	=> $line_apply_list,
			'dest'               	=> $destinations,
			'suppliers'        	=> $suppliers,
			'destnation_check'	=> $this->session->userdata('destination'),
			'supplier_check'	=> $this->session->userdata('supplier_id'),
			'linename_check'	=> $this->session->userdata('linename'),
			'startplace_check'      => $this->session->userdata('start_place'),
			'supplier_select_id'     => $this->session->userdata('supplier_select_id'),
			'supplier_name'          => $this->session->userdata('supplier_name')
			);
		$this->page->initialize ( $config );
		$this->load_view('admin/b2/line_apply',$data);
	}


	/**
	 * 专家已经申请的路线
	 */

	public function applyed_index($page = 1){

		$post_arr = array();//查询条件数组
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/line_apply/applyed_index/';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $this->uri->segment (5, 0);
		$post_arr = $this->get_search_condition($this->uri->segment (5), $this->is_post_mode());
		$page = $page==0 ? 1:$page;
		$config ['pagecount'] = $this->line_apply->get_line_apply_detail($post_arr, 0, $config['pagesize']);
		$line_apply_list = $this->line_apply->get_line_apply_detail($post_arr, $page, $config['pagesize']);
		$destinations = $this->line_apply->get_destinations();
		$suppliers = $this->line_apply->get_suppliers();
		$data = array(
			'line_apply_list' 	=> $line_apply_list,
			'dest'          		=> $destinations,
			'suppliers'         	=> $suppliers,
			'destnation_check'	=> $this->session->userdata('destination'),
			'supplier_check'	=> $this->session->userdata('supplier_id'),
			'linename_check'	=>$this->session->userdata('linename'),
			'startplace_check'      =>$this->session->userdata('start_place'),
			'expert_grade'            => $this->session->userdata('expert_grade'),
			'linecode_check'	=>$this->session->userdata('linecode_check'),
		);
		
		$this->page->initialize ( $config );
		$this->load_view('admin/b2/line_apply_2',$data);
	}

	/**
	 * 最新线路,没有任何管家申请过
	 */

	public function new_line($page = 1){

		$post_arr = array();//查询条件数组
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/line_apply/new_line/';
		$config ['pagesize'] = 15;
		$config ['page_now'] = $this->uri->segment (5, 0);
		$post_arr = $this->get_search_condition($this->uri->segment (5), $this->is_post_mode());
		$page = $page==0 ? 1:$page;
		$config ['pagecount'] = $this->line_apply->get_new_line($post_arr, 0, $config['pagesize']);
		$line_apply_list = $this->line_apply->get_new_line($post_arr, $page, $config['pagesize']);
		//print_r($this->db->last_query());exit();
		$destinations = $this->line_apply->get_destinations();
		$suppliers = $this->line_apply->get_suppliers();
		$data = array(
			'line_apply_list' => $line_apply_list,
			'dest'               => $destinations,
			'suppliers'        => $suppliers,
			'destnation_check'	=> $this->session->userdata('destination'),
			'supplier_check'	=> $this->session->userdata('supplier_id'),
			'linename_check'	=>$this->session->userdata('linename'),
			'startplace_check'         =>$this->session->userdata('start_place')
			);
		$this->page->initialize ( $config );
		$this->load_view('admin/b2/line_apply_3',$data);
	}



	function get_search_condition($uri_segment_4, $is_post_model){
		$post = $this->security->xss_clean($_POST);
		//print_r($post);exit();
		$post_arr = array();
		if($uri_segment_4!=''){
			# 线路名称
			if ($this->session->userdata('linename') != '') {
				$post_arr['l.linename like'] = '%' . $this->session->userdata('linename') . '%';
			}
			//线路编号
			if ($this->session->userdata('linecode') != '') {
				$post_arr['l.linecode like'] = '%' . $this->session->userdata('linecode') . '%';
			}
			if ($this->session->userdata('destination') != '') {
				 $this ->db->select('*');
				 $this ->db->from('u_dest_base');
				 $this->db->where(array('kindname like' =>"%{$this->session->userdata('destination')}%"));
				 $dest = $this ->db ->get() ->result_array();
				if (!empty($dest)) {
					$dest_id = array();
					foreach($dest as $val) {
						$dest_id[] = $val['id'];
					}
					$post_arr['l.overcity'] = $dest_id;
					//$this->session->set_userdata(array('destination' => $post['destination']));
					//$whereArr['l.overcity'] = rtrim($dest_id ,',');
				}
			}else{
				$this->session->unset_userdata('destination');
			}

			//出发城市
			if ($this->session->userdata('start_place') != '') {
				 $this ->db->select('*');
				 $this ->db->from('u_startplace');
				 $this->db->where(array('cityname like' =>"%{$this->session->userdata('start_place')}%"));
				 $startcity = $this ->db ->get() ->result_array();
				if (!empty($startcity)) {
					$start_id = '';
					foreach($startcity as $val) {
						$start_id .= $val['id'].',';
					}
					$post_arr['l.startcity'] = rtrim($start_id ,',');
				}
			}else{
				$this->session->unset_userdata('start_place');
			}



			# 供应商
			if ($this->session->userdata('supplier_select_id') != '') {
				$post_arr['supplier_id']= $this->session->userdata('supplier_select_id');
			}

			if ($this->session->userdata('expert_grade') != '') {
				$post_arr['la.grade']= $this->session->userdata('expert_grade');
			}

		}else{
			unset($post_arr['l.linecode like']);
			$this->session->unset_userdata('linecode');
			unset($post_arr['l.linename like']);
			$this->session->unset_userdata('linename');
			unset($post_arr['l.overcity']);
			$this->session->unset_userdata('destination');
			unset($post_arr['supplier_id']);
			$this->session->unset_userdata('supplier_select_id');
			$this->session->unset_userdata('supplier_name');
			unset($post_arr['l.startcity']);
			$this->session->unset_userdata('start_place');
			unset($post_arr['la.grade']);
			$this->session->unset_userdata('expert_grade');
		}
		if($is_post_model){
			# 供应商
			if (!empty($post['supplier_select_id'])) {
				$post_arr['supplier_id']= $post['supplier_select_id'];
				$this->session->set_userdata(array('supplier_select_id' => $post['supplier_select_id']));
				$this->session->set_userdata(array('supplier_name' => $post['supplier_name']));
			} else {
				unset($post_arr['supplier_id']);
				$this->session->unset_userdata('supplier_select_id');
				$this->session->unset_userdata('supplier_name');
			}
			# 目的地
			if (!empty($post['destination']) && !empty($post['overcity'])) {
				//$post_arr['l.overcity'] = intval($this->input->post['overcity']);
				$post_arr['l.overcity'] = array(intval($post['overcity']));
				$this->session->set_userdata(array('destination' => $post['destination']));
			} elseif (!empty($post['destination'])) {
				 $this ->db->select('*');
				 $this ->db->from('u_dest_base');
				 $this->db->where(array('kindname like' =>"%{$post['destination']}%"));
				 $dest = $this ->db ->get() ->result_array();
				if (!empty($dest)) {
					$dest_id = array();
					foreach($dest as $val) {
						$dest_id[] = $val['id'];
					}
					$post_arr['l.overcity'] = $dest_id;
					$this->session->set_userdata(array('destination' => $post['destination']));
					//$whereArr['l.overcity'] = rtrim($dest_id ,',');
				}
			}else{
				$this->session->unset_userdata('destination');
			}

			//出发城市
			if (!empty($post['start_place']) && !empty($post['start_go_city'])) {
				//$post_arr['l.overcity'] = intval($this->input->post['overcity']);
				$post_arr['l.startcity'] = intval($post['start_go_city']);
				$this->session->set_userdata(array('start_place' => $post['start_place']));
			} elseif (!empty($post['start_place']) && empty($post['start_go_city']) ) {

				 $this ->db->select('*');
				 $this ->db->from('u_startplace');
				 $this->db->where(array('cityname like' =>"%{$post['start_place']}%"));
				 $startcity = $this ->db ->get() ->result_array();
				if (!empty($startcity)) {
					$start_id = '';
					foreach($startcity as $val) {
						$start_id .= $val['id'].',';
					}
					$post_arr['l.startcity'] = rtrim($start_id ,',');
				}
				$this->session->set_userdata(array('start_place' => $post['start_place']));
			}else{
				$this->session->unset_userdata('start_place');
			}

			# 线路编号
			if (!empty($post['linecode'])) {
				$post_arr['l.linecode like']= '%' . $this->input->post('linecode') . '%';
				$this->session->set_userdata(array('linecode' => $this->input->post('linecode')));
			}else {
				unset($post_arr['l.linecode like']);
				$this->session->unset_userdata('linecode');
			}
			# 线路名称
			if (!empty($post['linename'])) {
				$post_arr['l.linename like']= '%' . $this->input->post('linename') . '%';
				$this->session->set_userdata(array('linename' => $this->input->post('linename')));
			}else {
				unset($post_arr['l.linename like']);
				$this->session->unset_userdata('linename');
			}
		}
			if($this->input->get_post('expert_grade')!=''){
				$post_arr['la.grade']= $this->input->get_post('expert_grade');
				$this->session->set_userdata(array('expert_grade' => $this->input->get_post('expert_grade')));
			}else{
				unset($post_arr['la.grade']);
				$this->session->unset_userdata('expert_grade');
			}
		return $post_arr;
	}


	//申请提交的操作,往线路申请表里面插入一条申请记录
	function apply_line_operator(){
		$post_arr = array();
		$line_id = $this->input->post('apply_line_id');
		$insert_data['line_id'] = $line_id;
		$insert_data['expert_id'] = $this->expert_id;
		$insert_data['grade'] = 1;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		$insert_data['modtime'] = date('Y-m-d H:i:s');
		$insert_data['status'] = 2;
		//判断一下是否已经有了数据,不重复插入
		$post_arr['line_id'] = $line_id;
		$post_arr['expert_id'] = $this->expert_id;
		$this->db->select('count(*) as cunt');
		$this->db->where($post_arr);
		$this->db->from('u_line_apply');
		$result = $this->db->get()->result_array();
		if($result[0]['cunt']!=0){
			$this->db->update('u_line_apply',$insert_data,$post_arr);
			$this->line_apply->insert_expert_dest($line_id,$this->expert_id);
		}else{
			$this->db->insert('u_line_apply',$insert_data);
			$this->line_apply->insert_expert_dest($line_id,$this->expert_id);
		}

		//print_r($this->db->last_query());exit();
		echo json_encode(array('status'=>200,'msg'=>'申请成功'));
	}

	function apply_grade(){
		$post_arr = array();
		$after_level = $this->input->post('after_level',true);
		$before_level = $this->input->post('before_level',true);
		$upgrade_line_id = $this->input->post('upgrade_line_id',true);
		$insert_data['line_id'] = $upgrade_line_id;
		$insert_data['expert_id'] = $this->expert_id;
		$insert_data['grade_before'] = $before_level;
		$insert_data['grade_after'] = $after_level;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		$insert_data['status'] = 0;
		$post_arr['line_id'] = $upgrade_line_id;
		$post_arr['expert_id'] = $this->expert_id;
		$this->db->select('count(*) as cunt');
		$this->db->where($post_arr);
		$this->db->from('u_expert_upgrade');
		$result = $this->db->get()->result_array();
		if($result[0]['cunt']!=0){
			$res = $this->db->update('u_expert_upgrade', $post_arr, array('line_id' => $upgrade_line_id,'expert_id'=>$this->expert_id));
			echo json_encode($res);
		}else{
			$this->db->insert('u_expert_upgrade',$insert_data);
			echo json_encode($result);
		}


		//print_r(json_encode($line_and_grede));


	}

	/**
	 * @author xml
	 * @method 供应商制定管家线路
	 */
	function group_index($page=1){
		$post_arr = array();//查询条件数组
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/line_apply/group_index/';
		$config ['pagesize'] = 15;
		$config ['page_now'] = $this->uri->segment (5, 0);
		$post_arr = $this->get_search_condition($this->uri->segment (5), $this->is_post_mode());
		$page = $page==0 ? 1:$page;
		$config ['pagecount'] = $this->line_apply->get_group_line_detail($post_arr, 0, $config['pagesize']);
		$line_apply_list = $this->line_apply->get_group_line_detail($post_arr, $page, $config['pagesize']);  //供应商指定管家的线路
	//	echo $this->db->last_query();
/* 		if(!empty($line_apply_list)){
			foreach ($line_apply_list as $k=>$v){
				//$line_apply_list[$k]['url']=''
			}
		} */
		$destinations = $this->line_apply->get_destinations();
		$suppliers = $this->line_apply->get_suppliers();
		$data = array(
				'line_apply_list' => $line_apply_list,
				'dest'               => $destinations,
				'suppliers'        => $suppliers,
				'destnation_check'	=> $this->session->userdata('destination'),
				'supplier_check'	=> $this->session->userdata('supplier_id'),
				'linename_check'	=>$this->session->userdata('linename'),
				'startplace_check'         =>$this->session->userdata('start_place'),
				'expert_grade'               => $this->session->userdata('expert_grade'),
				'linecode_check'	=>$this->session->userdata('linecode'),
		);
		$this->page->initialize ( $config );
		$this->load_view('admin/b2/group_index',$data);
	}
	/**
	 * @author xml
	 * 保存发送会员的线路
	 */
	function save_group_lineDate(){
		$line_id=$this->input->post('line_id',true);
		$expert_id=$this->input->post('expert_id',true);
		$member_id=$this->input->post('member_id',true);
		if($line_id>0 && $expert_id>0 && $member_id>0){
			$where=array(
				'member_id'=>$member_id,
				'expert_id'=>$expert_id,
				'line_id'=>$line_id,
			);
			$res=$this->line_apply->select_data('u_customize_recommend_line',$where);
			if(empty($res)){
					$insertArr=array(
							'member_id'=>$member_id,
							'expert_id'=>$expert_id,
							'line_id'=>$line_id,
							'addtime'=>date('Y-m-d H:i:s'),
					);
				  $id=$this->line_apply->save_recommend_line($insertArr);
				  if($id>0){
				  	$member=$this->line_apply->select_data('u_member',array('mid'=>$member_id)); //会员信息
				  	$expert=$this->line_apply->select_data('u_expert',array('id'=>$expert_id)); //管家信息

				  	$this->get_code($member['mobile'],$expert['realname'],$line_id);//发短信
				  	echo json_encode(array('status'=>1,'msg'=>'推送成功！'));
				  }else{
				  	echo json_encode(array('status'=>-1,'msg'=>'推送失败！'));
				  }
			}else{
				echo json_encode(array('status'=>1,'msg'=>'已推送了！'));
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'推送失败！'));
		}
	}
	//发短信
	public function get_code ($mobile,$expert,$line_id,$Arr=array()) {

		$this->load->library ( 'callback' );

		if(!empty($mobile)){
			//读取短信模板
			$this->load->model ( 'sms_template_model' ,'sms_model' );
			$template = $this ->sms_model ->row(array('msgtype' =>'customize_line_member'));
			$template = $template ['msg'];

			//将验证码放入模板中
			$content = str_replace("{#NAME#}", $expert ,$template);
			$content = str_replace("{#LINEID#}", 'B'.$line_id ,$content);
			//发送短信
			$status = $this ->send_message($mobile ,$content);

		}else{

		}
	}

	/**
	 * @author xml
	 *  线路详情
	 */
	function line_detial(){

		$lineId= $this->get('id');
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		$data['user_shop'] = $this->user_shop_model->get_user_shop_select ( 'u_startplace' ); // 始发地
		$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
		$this->load_model ( 'admin/a/destinations_model', 'destinations_model' );
		$data['line_attr'] = $this->lineattr_model->getLineattrTreeDate();
		//$data['destinations'] = $this->destinations_model->getDestinationsTreeDate();
		//var_dump($data['data']);exit;
		$data['overcity_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$whereArr = array(
					'in' =>array('id' =>trim($data['data']['overcity2'] ,','))
			);
			$data['overcity_arr'] = $this->dest_base_model->getDestBaseAllData($whereArr);
		}
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}
		//供应商信息
		$supplierData=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$data['data']['supplier_id']));
		//线路名称
		if($data['data']['linenight']==''|| $data['data']['linenight']==0){
			$data['data']['linename']=$data['data']['lineprename'].$data['data']['lineday'].'天游';
		}else{
			$data['data']['linename']=$data['data']['lineprename'].$data['data']['linenight'].'晚'.$data['data']['lineday'].'天游';
		}
		$data['data']['brand']=$supplierData[0]['brand'];
		$data['suits'] = $this->user_shop_model->getLineSuit($lineId);
		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);
		//线路的出发地
		$citystr='';
		$cityData=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineId));
		foreach ($cityData as $k=>$v){
			$citystr=$citystr.$v['cityname'].'&nbsp;&nbsp;';
		}
		$data['citystr']=$citystr;
		//线路图片
		$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
		//交通方式
		$data['transport']=$this->user_shop_model->description_data('DICT_TRANSPORT');
		//星际酒店概述
		$data['hotel']=$this->user_shop_model->description_data('DICT_HOTEL_STAR');
		//是否是主题游
		$data['themeid']='';
		if(!empty($data['data']['themeid'])){
			$data['themeid']=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$data['data']['themeid']));
		}
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
		//礼品管理
		//$data['gift']=$this->user_shop_model->get_gift_data($lineId);
		//线路押金,团款,时分截止时间
   		$data['line_aff']=$this->user_shop_model->get_user_shop_select('u_line_affiliated',array('line_id'=>$lineId));

   		//上车地点
   		$data['carAddress']=$this->user_shop_model->get_user_shop_select('u_line_on_car',array('line_id'=>$lineId));

		$this->load->view ( 'admin/b2/line_detial', $data );

	}

	/**
	 * 谢明丽
	 *  线路详情
	 */
	function line_detial_apply(){

		$lineId= $this->get('id');
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		$data['user_shop'] = $this->user_shop_model->get_user_shop_select ( 'u_startplace' ); // 始发地
		$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
		$this->load_model ( 'admin/a/destinations_model', 'destinations_model' );
		$data['line_attr'] = $this->lineattr_model->getLineattrTreeDate();
		$data['destinations'] = $this->destinations_model->getDestinationsTreeDate();
		//var_dump($data['data']);exit;
		$data['overcity_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity_arr'] = $this->destinations_model->getDestinations(explode(",",$data['data']['overcity2']));
		}
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}
		//供应商信息
		$supplierData=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$data['data']['supplier_id']));
		//线路名称
		if($data['data']['linenight']==''|| $data['data']['linenight']==0){
			$data['data']['linename']=$data['data']['lineprename'].$data['data']['lineday'].'天游';
		}else{
			$data['data']['linename']=$data['data']['lineprename'].$data['data']['linenight'].'晚'.$data['data']['lineday'].'天游';
		}
		$data['data']['brand']=$supplierData[0]['brand'];
        //套餐
		$data['suits'] = $this->user_shop_model->getLineSuit($lineId);
		//线路的出发地
		$citystr='';
	 	$cityData=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineId));
		foreach ($cityData as $k=>$v){
			 $citystr=$citystr.$v['cityname'].'&nbsp;&nbsp;';
		}
		$data['citystr']=$citystr;
		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);

		//线路图片
		$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
		//交通方式
		$data['transport']=$this->user_shop_model->description_data('DICT_TRANSPORT');
		//星际酒店概述
		$data['hotel']=$this->user_shop_model->description_data('DICT_HOTEL_STAR');
		//是否是主题游
		$data['themeid']='';
		if(!empty($data['data']['themeid'])){
			$data['themeid']=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$data['data']['themeid']));
		}
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
		//礼品管理
	//	$data['gift']=$this->user_shop_model->get_gift_data($lineId);


   		//线路押金,团款,时分截止时间
   		$data['line_aff']=$this->user_shop_model->get_user_shop_select('u_line_affiliated',array('line_id'=>$lineId));

   		//上车地点
   		$data['carAddress']=$this->user_shop_model->get_user_shop_select('u_line_on_car',array('line_id'=>$lineId));

		$this->load->view ( 'admin/b2/line_detial_apply', $data );

	}

	function give_up(){
		$line_id = $this->input->post('line_id');
		$sql = "update u_line_apply set status=4 where line_id=$line_id and expert_id=$this->expert_id";
		if($this->db->query($sql)){
			echo json_encode(array('code'=>200,'msg'=>'操作成功'));
		}else{
			echo json_encode(array('code'=>400,'msg'=>'操作失败'));
		}
	}


	public function switchover_desc(){
		$lineId=$this->input->post('suitId');
		$data['suits'] = $this->user_shop_model->select_rowData('u_line_suit',array('id'=>$lineId));
		echo json_encode($data['suits']);
	}

	public function getProductPriceJSON(){
		$lineId = $this->get("lineId");
		$suitId = $this->get("suitId");
		$startDate = $this->get("startDate");
		$productPrice = "[]";
		if(null!=$suitId && ""!=$suitId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId,$suitId,$startDate);
		}
		echo $productPrice;
	}
}