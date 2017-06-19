<?php 
/****
 * 深圳海外国际旅行社
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opportunity extends UB1_Controller {
	function __construct(){
		//$this->need_login = true;
		parent::__construct();
	    $this->load->helper(array('form', 'url'));
	    $this->load->helper('url');
		$this->load->database();
		$this->load->model('admin/b1/opportunity_model','opportunity');
		$this->load->library('session');
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index()
	{   

		$param['status'] = 0;
		$data['pageData']=$this->opportunity->get_opportunity_list($param,$this->getPage ()); 
		//echo $this->db->last_query();
		$this->load->view('admin/b1/header.html');
		$this->load->view("admin/b1/opportunity",$data);
		$this->load->view('admin/b1/footer.html');
	}
	
	/*分页查询*/
	public function indexData(){
	
		$param = $this->getParam(array('status','op_title'));
		$data = $this->opportunity->get_opportunity_list($param,$this->getPage ());
		echo  $data ; 
	}
	
	/*添加培训*/
	function add_opportunity(){
		$this->load->library ( 'callback' );
		$data = $this->security->xss_clean($_POST);
		foreach($data as $key =>$val)
		{
			$data [$key] = trim($val);
		}
		if (empty($data['title']))
		{
			$this->callback->set_code ( 4000 ,"请填写主题");
			$this->callback->exit_json();
		}
		if (empty($data['address']))
		{
			$this->callback->set_code ( 4000 ,"请填写地址");
			$this->callback->exit_json();
		}
		if (empty($data['sponsor']))
		{
			$this->callback->set_code ( 4000 ,"请填写主办方");
			$this->callback->exit_json();
		}
		
		if (empty($data['starttime']) || empty($data['endtime']) || empty($data['begintime'])) {
			$this->callback->set_code ( 4000 ,"请填写培训开始时间与截止时间与报名开始时间");
			$this->callback->exit_json();
		} else {
			if ($data['begintime'] > $data['endtime']) {
				$this->callback->set_code ( 4000 ,"报名开始开始时间应小于截止时间");
				$this->callback->exit_json();
			}
			if ($data['starttime'] < $data['endtime']) {
				$this->callback->set_code ( 4000 ,"培训开始时间应大于截止时间");
				$this->callback->exit_json();
			}
		}
		if (empty($data['people'])) {
			$this->callback->set_code ( 4000 ,"请填写容纳人数");
			$this->callback->exit_json();
		}
		$this->load->helper('regexp');
		if (!regexp('numberInteger' ,$data ['spend'])) {
			$this->callback->set_code ( 4000 ,"请填写正确的培训时长");
			$this->callback->exit_json();
		}
		if (empty($data['content'])) {
			$this->callback->set_code ( 4000 ,"请填写培训内容");
			$this->callback->exit_json();
		}
		
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$data ['publisher_type'] = 2;
		$data ['publisher_id'] = $login_id;
		$data ['addtime'] = date('Y-m-d H:i:s' ,time());
		if (empty($data['id'])) {
			// 新增
			if ($data['is'] == 1) { //保存(新增)
				$data ['status'] = 0;
			} elseif ($data['is'] == 2) { //保存并发布（新增）
				$data ['status'] = 1;
				//发布同时给管家一条系统通知
				$noticeArr = array(
						'title' =>'有新的培训学习机会',
						'content' =>'详情请查学习机会',
						'addtime' =>$data['addtime'],
						'notice_type' =>1,
						'admin_id' =>$login_id
				);
			}
			unset($data['id']);
			unset($data['is']);
			$status = $this ->db ->insert('u_opportunity' ,$data);
			$id = $this ->db ->insert_id();
			$log_type = 1;
			$content = "供应商新增培训公告,记录ID：{$id}";
		} else {
			unset($data['is']);
			//编辑
			$whereArr = array('id' =>$data['id']);
			$this ->db ->where($whereArr);
			$status = $this ->db ->update('u_opportunity' ,$data);
			$log_type = 1;
			$content = "供应商编辑培训公告,记录ID：{$data['id']}";
		}
		
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		}
		else
		{
		/* 	if (!empty($noticeArr)) {
				$this ->db ->insert('u_notice' ,$noticeArr);
			} */
			$this ->log($log_type,3,"培训公告管理",$content);
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}
	}
	
	//上传附件
	public function up_file() {
		$config['upload_path']="./file/b1/uploads/";//文件上传目录
		if(!file_exists("./file/b1/uploads/")){
			mkdir("./file/b1/uploads/",0777,true);//原图路径
		} 
		
		if($_FILES['upfile']['error']==0){
			$pathinfo=pathinfo($_FILES["upfile"]['name']);
			$extension=$pathinfo['extension'];
			$file_url=$config['upload_path'].'/'.date("Ymd").time().".".$extension;
			$file_arr=array('doc','docx','xlsx','xls');
		
			if(!in_array($extension, $file_arr)){
				echo json_encode(array('code' => -1,'msg' =>'上传格式出错,请选择doc,docx,xlsx,xls格式的文件'));
				exit;
			}
			if(!move_uploaded_file ($_FILES['upfile']['tmp_name'], $file_url)){
				echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
				exit;
			}else{
				$linedoc=substr($file_url,1 );
				$linename=$_FILES['upfile']['name'];
				echo json_encode(array('code' =>200, 'msg' =>$linedoc));
			}
		}else{
			echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		}		
	}
	//查看公告详情
	function get_opp_data(){
		$id = intval($_POST['id']);
		$data = $this ->opportunity ->get_line_list ( array('a.id' =>$id));
		if (empty($data)) {
			echo false;
		} else {
			switch($data[0]['publisher_type']) {
				case 1:
					$this ->load_model('admin/a/expert_model' ,'expert_model');
					$info = $this ->expert_model ->row(array('id' =>$data [0]['publisher_id']));
					$data [0]['publisher_name'] = $info['realname'];
					$data [0]['publisher_type'] = '专家';
					break;
				case 2:
					$this ->load_model('admin/a/supplier_model' ,'supplier_model');
					$info = $this ->supplier_model ->row(array('id' =>$data [0]['publisher_id']));
					$data [0]['publisher_name'] = $info['company_name'];
					$data [0]['publisher_type'] = '商家';
					break;
				case 3:
					$this ->load_model('admin/a/admin_model' ,'admin_model');
					$info = $this ->admin_model ->row(array('id' =>$data [0]['publisher_id']));
					$data [0]['publisher_name'] = $info['username'];
					$data [0]['publisher_type'] = '平台';
					break;
			}
			switch($data[0]['status']) {
				case 0:
					$data [0]['sname'] = '保存';
					break;
				case 1:
					$data [0]['sname'] = '已发布';
					break;
				case 2:
					$data [0]['sname'] = '已取消';
					break;
			}
			echo json_encode($data[0]);
		}
	
	}
	public function release() {
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$oppArr = array(
				'status' =>1,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->opportunity ->update($oppArr ,array('id' =>$id));
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'发布失败');
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,"培训公告管理","供应商发布培训公告：公告ID:{$id}");
			//给管家发送系统通知
/* 			$noticeArr = array(
					'title' =>'有新的培训学习机会',
					'content' =>'详情请查学习机会',
					'addtime' =>date('Y-m-d H:i:s' ,time()),
					'notice_type' =>1,
					'admin_id' =>$this ->admin_id
			);
			$this ->db ->insert('u_notice' ,$noticeArr); */
			$this->callback->set_code ( 2000 ,'发布成功');
			$this->callback->exit_json();
		}
	}
	public function cancel(){
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$oppArr = array(
				'status' =>2,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->opportunity ->update($oppArr ,array('id' =>$id));
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'取消失败');
			$this->callback->exit_json();
		} else {
			$this ->log(2,3,"培训公告管理","供应商取消培训公告：公告ID:{$id}");
			$data = $this ->opportunity ->row('id' ,$id);
			//给已报名的人发送消息
			$oppData = $this ->opportunity ->get_opp_apply_data($id);
			if (!empty($oppData)) {
				foreach($oppData as $val) {
					$this ->add_message("培训标题:{$data['title']}", 1, $val['expert_id'] ,'供应商取消一个培训机会');
				}
			} 
			$this->callback->set_code ( 2000 ,'取消成功');
			$this->callback->exit_json();
		}
	}
	public function delete() {
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$oppArr = array(
				'status' =>-1,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->opportunity ->update($oppArr ,array('id' =>$id));
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'删除失败');
			$this->callback->exit_json();
		} else {
			$this ->log(2,3,"培训公告管理","供应商删除培训公告：公告ID:{$id}");
			$this->callback->set_code ( 2000 ,'删除成功');
			$this->callback->exit_json();
		}
	}
}
