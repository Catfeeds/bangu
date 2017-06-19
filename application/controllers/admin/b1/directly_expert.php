<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directly_expert extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load->model ( 'admin/b1/directly_expert_model','directly_expert');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
}
	public function index()
	{
		//获取国家
		$country =  $this ->get_area_data(0);
		$data = array(
			'country' =>$country
		);
        		$data['type']=$this->input->get('type');
		$param['status']=1;
		$page = $this->getPage ();
		$data['pageData'] = $this->directly_expert->get_expert_list($param,$page );
	
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/directly_expert',$data);
		$this->load->view('admin/b1/footer.html');
	}
	
	/*线路管理的分页查询*/
	public function indexData(){		
		$page = $this->getPage ();
		$param = $this->getParam(array('status','realname','mobile','country','province_id','city_id'));
		$data =  $this->directly_expert->get_expert_list($param,$page );
		//echo $this->db->last_query();
		echo  $data ;
	}
	/*新增直属管家*/
	public function registered_expert(){
		//供应商信息
		$supplier = $this->getLoginSupplier();
		$this->load->model ( 'admin/b1/view_model','view' );
		$data['supplier']=$this->view->select_rowData('u_supplier',array('id'=>$supplier['id']));
		$data['logindatetime']=$supplier['logindatetime'];
		
		//获取当前城市的地区
		$cityName = $this ->session ->userdata('city_location');
		$data['areaData'] =$this->directly_expert->get_cityName($cityName);
		//目的地
		$data['destArr'] = $this ->getDestData();
		
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/registered_expert',$data);
		$this->load->view('admin/b1/footer.html');
	}
	
	public function getDestData()
	{
		$destArr = array();
		$this->load_model('dest/dest_base_model' ,'dest_model');
		$destData = $this ->dest_model ->all(array('level <=' =>2) ,'level asc');
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				if ($val['level'] == 1)
				{
					$destArr[$val['id']] = $val;
				}
				elseif ($val['level'] == 2)
				{
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][] = $val;
					}
				}
			}
		}
		return $destArr;
	}
	/*保存直属管家*/
	function save_expert(){
		$insertArr['mobile']=$this->input->post('mobile');
		$insertArr['password']=$this->input->post('password');
		$insertArr['password']=md5($insertArr['password']);
		$insertArr['nickname']=$this->input->post('nickname');
		$insertArr['login_name']=$this->input->post('mobile');
		$insertArr['sex']=$this->input->post('sex');
		$insertArr['email']=$this->input->post('email');
		$insertArr['realname']=$this->input->post('realname');
		$insertArr['weixin']=$this->input->post('weixin');
		$insertArr['big_photo']=$this->input->post('big_photo');
		$insertArr['small_photo']=$this->input->post('big_photo');
		$insertArr['idcardpic']=$this->input->post('idcardpic');
		$insertArr['idcardconpic']=$this->input->post('idcardconpic');
		$insertArr['province']=$this->input->post('province1');
		$insertArr['city']=$this->input->post('city');
		$insertArr['expert_dest']=$this->input->post('expert_dest');
		$insertArr['expert_dest']=substr($insertArr['expert_dest'], 0, -1);
		$expert_dest=$insertArr['expert_dest'];
		$insertArr['type']=$this->input->post('title');
		$insertArr['talk']=$this->input->post('talk');
		$insertArr['travel_title']=$this->input->post('travel_title');
		$insertArr['expert_type']=2;
		$idcard1=$this->input->post('idcard1');
		$idcard=$this->input->post('idcard');
		if(!empty($idcard)){
			$insertArr['idcard']=$idcard;
		}else{
			$insertArr['idcard']=$idcard1;
		}
		$insertArr['idcardtype']=$this->input->post('idcardtype');
		$school=$this->input->post('school');
		$job_name=$this->input->post('job_name');
		$year=intval($this->input->post('year'));
		$countryType=$this->input->post('countryType');
		$visit_service=$this->input->post('visit_service');
		$visit_service1=$this->input->post('visit_service1');
		$all_select=$this->input->post('all_select');
		$insertArr['beizhu']='毕业于'.$school.';旅游从业岗位：'.$job_name.';'.$year.'年从业经验'; 
		$insertArr['school']=$school;
		$insertArr['profession']=$job_name;
		$insertArr['working']=$year;
		//上门服务
		if($countryType==2){//1,境内       2,境外 
			if(isset($all_select) && $all_select==1){
				$insertArr['country']=2;
				//$insertArr['visit_service']=0;
				$insertArr['visit_service']=implode(',', $visit_service);
			}else{
				if(!empty($visit_service)){
					$insertArr['country']=2;
					$insertArr['visit_service']=implode(',', $visit_service); 
				}
			}
			//$insertArr['login_name']=$this->input->post('email');
		}else{
			$insertArr['country']=1;
			$insertArr['visit_service']=$visit_service1;
			
		}
		//验证手机号码
		$moblie=$this->directly_expert->get_expert_msg(array('mobile'=>$insertArr['mobile']));
		if(!empty($moblie)){
		    	echo json_encode(array('status'=>-1,'msg'=>'该手机号码已存在！'));
		    	exit();
		}
		//验证邮箱
		$email=$this->directly_expert->get_expert_msg(array('email'=>$insertArr['email']));
		if(!empty($email)){
		    	echo json_encode(array('status'=>-1,'msg'=>'该邮箱已存在！'));
		    	exit();
		}
		//荣誉证书
		$insertC['certificate']=$this->input->post('certificate');
		$insertC['certificatepic']=$this->input->post('certificatepic');
		//个人简历
		$insertR['starttime']=$this->input->post('starttime');
		$insertR['endtime']=$this->input->post('endtime');
		$insertR['company_name']=$this->input->post('company_name');
		$insertR['job']=$this->input->post('job');
		$insertR['description']=$this->input->post('description');
		
		$supplier = $this->getLoginSupplier();
		$visit_service=$insertArr['visit_service'];

		//添加直属管家
 		$expert_id=$this->directly_expert->insert_directly_expert($insertArr,$insertC,$insertR,$supplier['id'],$expert_dest,$visit_service);
		if($expert_id>0){
			echo json_encode(array('status'=>1,'msg'=>'添加成功！'));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'添加失败！'));
		}  
	}
	
	/*查看管家信息*/
	public function get_expert(){
		$id=$this->input->post('id');
		if($id>0){
			//管家信息
			$expert=$this->directly_expert->get_expert_data($id);
			//荣誉证书
			$expert_resume=$this->directly_expert->get_expert_resume(array('expert_id'=>$id));
			//从业经历
			$expert_certificate=$this->directly_expert->get_expert_certificate(array('expert_id'=>$id));
			//擅长的目的
			$dest=array();
			$expert_dest=explode(",",$expert['expert_dest']);
			foreach ($expert_dest as $k=>$v){
				if(!empty($v)){
					$dest[$k]=$v;
				}
			}
			$dest_data=$this->expert->getDestattr($dest);

			echo json_encode(array('status'=>1,'expert'=>$expert,'expert_resume'=>$expert_resume,'expert_certificate'=>$expert_certificate,'dest'=>$dest_data));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败！'));
		}
	}
	/*终止合作*/
	public function update_expert_status(){
		$id=$this->input->post('id');
		if($id>0){
			$re=$this->directly_expert->update_status($id,array('status'=>-1));
			if($re){
				echo json_encode(array('status'=>1,'msg'=>'操作成功！'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'操作失败！'));
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'操作失败！'));
		}
	}
	/**
	 * @method 获取地区
	 */
	public function get_area_data ($pid) {
		$re=$this->directly_expert->sel_city($pid);
		return $re;
	}
	//城市联动
	public function get_area_json() {
		$id = intval($this ->input ->post('id'));
		$this ->load_model('admin/a/area_model' ,'area_model');
		$whereArr = array(
				'isopen' =>1,
				'pid' =>$id
		);
		$area = $this ->area_model ->all($whereArr);
		if (empty($area)) {
			echo false;exit;
		} else {
			echo json_encode($area);
		}
	}
}
