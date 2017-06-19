<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月3日16:43
* @method 		文章管理
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Plate extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		//$this->load->model ( 'admin/a/article_attr_model', 'attr_model' );
		$this->load->model ( 'admin/a/sale_model', 'sale_model' );
	}
	
	public function index() {
		$this ->load_view('admin/a/sale/plate');
	}
	public function getPlate() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$type_name = $this ->input ->post('type_name');
		
		if (!empty($type_name)) {
			$whereArr ['typeName like '] = "%".$type_name."%";
		}
		
		//获取数据  
		$data['list'] = $this ->sale_model ->result($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE,'sort');
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count,sys_constant::A_PAGE_SIZE);
		echo json_encode($data);
	}
	/**
	 * 请求错误信息接口
	 * @param string $msg
	 * @param string $code
	 */
	public function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			$this->result_msg = "data error";
		} else {
			$this->result_msg = $msg;
		}
	
		$this->resultJSON = json_encode ( array(
				"code" => $this->result_code,
				"msg" => $this->result_msg,
		) );
		echo $this->resultJSON;
		exit ();
	}
	/**
	 * 图片上传
	 * */
	public function upload_img()
	{
		$inputname=$this->input->post("inputname",true); //file文本域的name属性值
	
		$typeArr = array("jpg", "jpeg","png", "gif");//允许上传文件格式
		$time = date('Ymd',time());
	
		$path ="./file/upload/".$time."/"; //上传路径
		$return="/file/upload/".$time."/"; //返回的路径
		if (!file_exists($path))
		{
			$status = mkdir($path ,0777 ,true);
			if ($status == false)
				$this->__errormsg('图片上传失败');
		}
		//上传
		if (!empty($_FILES))
		{
			$name = $_FILES[$inputname]['name'];
			$size = $_FILES[$inputname]['size'];
			$name_tmp = $_FILES[$inputname]['tmp_name'];
				
			if (empty($name))
				$this->__errormsg('您还未选择图片');
			$type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
			if (!in_array($type, $typeArr))
				$this->__errormsg('请上传jpg,png或gif类型的图片！');
	
			$pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
			$pic_url = $path . $pic_name;//上传后图片路径+名称
			$return_url=$return.$pic_name;
	
			if (move_uploaded_file($name_tmp, $pic_url))
			{    //临时文件转移到目标文件夹
				echo json_encode(array("code"=>"2000","msg"=>"success","imgurl"=>$return_url));
					
			}
			else
			{
				$this->__errormsg('上传有误，清检查服务器配置！');
	
			}
		}
		else
		{
			$this->__errormsg('请选择图片');
		}
	
	}
	
	
	//添加文章分类
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		try {
			if (empty($postArr['typeName'])) {
				throw new Exception('请填写版块名称');
			} else {
				$attrData = $this ->sale_model ->row(array('typeName' =>$postArr['typeName']) ,'arr');
				if (!empty($attrData)) {
					throw new Exception('版块名称已存在');
				}
			}
			if (empty($postArr['sort'])) {
				throw new Exception('请填写排序');
			}
			if (empty($postArr['plate_pic'])) {
				throw new Exception('请上传图片');
			}
			
			$array = array(
				'typeName' =>$postArr['typeName'],
				'sort' =>$postArr['sort'],
				'pic' =>$postArr['plate_pic']
			);
			$status = $this ->sale_model ->insert($array);
			if (empty($status)) {
				throw new Exception('添加失败');
			} else {
				
				$this->callback->set_code ( 2000 ,'添加成功');
				$this->callback->exit_json();
			}
			
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
	}
	
	//编辑文章分类
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		try {
		if (empty($postArr['typeName'])) {
				throw new Exception('请填写版块名称');
			} else {
				$attrData = $this ->sale_model ->row(array('typeName' =>$postArr['typeName']) ,'arr');
				if (!empty($attrData)&&$attrData['typeId']!=$postArr['id']) {
					throw new Exception('版块名称已存在');
				}
			}
			if (empty($postArr['sort'])) {
				throw new Exception('请填写排序');
			}
			if (empty($postArr['plate_pic'])) {
				throw new Exception('请上传图片');
			}
			
			$array = array(
					'typeName' =>$postArr['typeName'],
					'sort' =>$postArr['sort'],
					'pic' =>$postArr['plate_pic']
			);
			$status = $this ->sale_model ->update($array ,array('typeId' =>$postArr['id']));
			if (empty($status)) {
				throw new Exception('编辑失败');
			} else {
				
				$this->callback->set_code ( 2000 ,'编辑成功');
				$this->callback->exit_json();
			}
				
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
	}
	
	
	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('typeId'=>$id);
		$data=$this ->sale_model ->row($whereArr);
		if (!empty($data)) {
			echo json_encode($data);
		}
	}
	//删除
	public function delete() {
		$id = intval($this ->input ->post('id'));
		$status = $this ->sale_model ->delete(array('typeId' =>$id));
			if (empty($status)) {
				$this->callback->set_code ( 4000 ,"删除失败");
				$this->callback->exit_json();
			}
			else {
				$this->callback->set_code ( 2000 ,"删除成功");
				$this->callback->exit_json();
			}
		
	}
	
}
