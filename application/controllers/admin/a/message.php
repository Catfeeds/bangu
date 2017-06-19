<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Message extends UA_Controller {
	const pagesize = 10;
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/notice_model', 'notice_model' );
	}
	/**
	 * 贾开荣
	 * 消息列表页
	 */
	public function message_list() {
		$where = array ();
		$like = array();
		$this->load->helper ( 'url' );
		$this->load->library ( 'session' );
		$page_new = $this ->input ->get('page' ,true);
		$page_new = empty($page_new)?1:$page_new;
	
		$this->load->library ( 'Page' ); // 加载分页类
		$config ['pagecount'] = $this->notice_model->num_rows_total ( $where ,$like); // 获取查询结果的条数
		$config ['pagesize'] = self::pagesize;
		$config ['base_url'] = '/admin/a/message/message_list?page=';
		$config ['page_now'] = $page_new;
		$this->page->initialize ( $config );
		
		$data ['attachment'] = '';
		$data ['addtime'] = 0;
		$data ['title'] = null;
		$data ['line'] = $this->notice_model->get_line_list ( $where, $page_new, $config ['pagesize'], $type = 'arr' ,$like);

		$this->load_view ( 'admin/a/ui/base/message_list', $data );
	}

	/**
	 * 贾开荣
	 * 消息列表条件搜索
	 */
	public function search() {
		$where = array ();
		$like = array ();
		$this->load->helper ( 'url' );
		$this->load->library ( 'session' );
		$snotice = $this ->session ->userdata('snotice');
		if (!empty($_POST))
		{
			$title = $this ->input ->post('title' ,true);
			$addtime = $this ->input ->post('addtime' ,true);
		}
		elseif (!empty($snotice))
		{
			$title = $snotice ['title'];
			$addtime = $snotice ['addtime'];
		}
		else
		{
			$title = null;
			$addtime = null;
		}
		if (! empty ( $title ))
			$like ['title'] = trim($title);

		// 按时间搜索
		if ($addtime == 1) {
			$time = strtotime ( "-1 month" );
			$where ['addtime >'] = date ( 'Y-m-d H:i:s', $time );
		} elseif ($addtime == 2) {
			$time = strtotime ( "-3 month" );
			$where ['addtime >'] = date ( 'Y-m-d H:i:s', $time );
		} elseif ($addtime == 3) {
			$time = strtotime ( "-6 month" );
			$where ['addtime >'] = date ( 'Y-m-d H:i:s', $time );
		}
		$data = array(
			'title' =>$title,
			'addtime' =>$addtime
		);
		$notice ['snotice'] = $data;
		$this ->session ->set_userdata($notice);

		$this->load->library ( 'Page' ); // 加载分页类
		$config ['pagecount'] = $this->notice_model->num_rows_total ( $where, $like ); // 获取查询结果的条数
		$config ['pagesize'] = self::pagesize;
		$config ['base_url'] = '/admin/a/message/search/';

		$config ['page_now'] = $this->uri->segment ( 5, 0 );
		$this->page->initialize ( $config );

		$data ['line'] = $this->notice_model->get_line_list ( $where, $this->uri->segment ( 5, 0 ), $config ['pagesize'], $type = 'arr', $like );
		$data ['attachment'] = '';
		$this->load_view ( 'admin/a/ui/base/message_list', $data );
	}
	/**
	 * 贾开荣
	 * 添加消息
	 */
	public function addNotice() {
		$title = $this->input->post ( 'title', true ); // 标题
		$content = $this->input->post ( 'content', true ); // 内容
		$attachment = $this ->input ->post('attachment' ,true);
		$notice_type_1 = $this->input->post ( 'type_1' ); // 接收人为专家
		$notice_type_2 = $this->input->post ( 'type_2' ); // 接受人为供应商
		$notice_type_3 = $this->input->post ( 'type_3' ); // 接收人为平台内部
		$id = $this ->input ->post('id' ,true);
		if (empty ( $title )) {
			echo json_encode(array('status' =>-1 ,'msg' =>'请填写标题'));
			exit;
		}
		if (empty ( $content )) {
			echo json_encode(array('status' =>-2 ,'msg' =>'请填写内容'));
			exit;
		}
		if (empty ( $notice_type_1 ) && empty ( $notice_type_2 ) && empty ( $notice_type_3 )) {
			echo json_encode(array('status' =>-3 ,'msg' =>'请填写接收人'));
			exit;
		} else {
			if (empty($notice_type_2)) {
				$type = trim ( $notice_type_1 . ',' . $notice_type_3 );
			} else {
				$type = trim ( $notice_type_1 . ',' . $notice_type_2 . ',' . $notice_type_3 );
			}
		}
		$type = trim($type ,',');
		$this->load->library ( 'session' );
		$admin_id = $this->session->userdata ( 'a_user_id' );

		$notice = array (
				'title' => $title,
				'content' => $content,
				'addtime' => date('Y-m-d H:i:s' ,time()),
				'notice_type' => $type,
				'admin_id' => $admin_id,
				'attachment' =>$attachment
		);

		if (empty($id))
		{
			$status = $this->db->insert ( 'u_notice', $notice );
			$log_type = 1;
			$id = $this ->db ->insert_id();
			$log_message = "平台新增消息,记录ID:{$id}";
		}
		else
		{
			$this ->db ->where(array('id' =>$id));
			$status = $this ->db ->update ( 'u_notice', $notice );
			$log_type = 3;
			$log_message = "平台编辑消息,记录ID:{$id}";
		}
		if (empty($status))
		{
			echo json_encode(array('status' =>-4 ,'msg' =>'操作失败'));
			exit;
		}
		else
		{
			$this ->log($log_type,3,'平台基础设置->消息管理',$log_message);
			echo json_encode(array('status' =>1 ,'msg' =>'操作成功'));
			exit;
		}
	}
	/**
	 * 贾开荣
	 * 返回一条数据
	 */
	public function get_one() {
		$id = intval($_POST['id']);
		$this ->db ->select('title,content,addtime,admin_id,notice_type');
		$this ->db ->where(array('id' =>$id));
		$this ->db ->from('u_notice');
		//$this ->db ->join('u_admin as a','m.admin_id = a.id' ,'left');
		$query = $this->db->get ();
		$data = $query->result_array ();
		$data = $data[0];

		$type = explode(',' ,$data ['notice_type']);
		$type_name = null;
		foreach($type as $val)
		{
			if (empty($val))
				continue;
			switch ($val)
			{
				case 1:
					$type_name .= "专家,";
					break;
				case 2:
					$type_name .= "供应商,";
					break;
				case 3:
					$type_name .= "平台内部,";
					break;
				default :
					break;
			}
		}
		$type_name = trim($type_name ,',');
		$data ['type_name'] = $type_name;
		unset($data ['notice_type']);

		$this ->db ->select('username');
		$this ->db ->from('u_admin');
		$this ->db ->where(array('id' =>$data ['admin_id']));
		$query = $this ->db ->get();
		$expert = $query ->result_array();
		$data ['username'] = $expert[0]['username'];
		unset($data ['admin_id']);
		echo json_encode($data);
		//var_dump($data);
	}
	/**
	 * 功能：上传文件
	 * 作者：贾开荣 v1.0.0
	 * 时间：2015-04-23
	 */
	public function up_file() {
		$name_str = $this ->input ->post('filename' ,true);

		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/a/upload/';
		$config['allowed_types'] = 'doc|txt|xls';
		$config['max_size'] = '40000';
		$file_name = $name_str.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>'上传失败'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/a/upload/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'msg' =>'上传成功' ,'url' =>$url ));
			exit;
		}
	}
	/**
	 * 贾开荣
	 * 获取一条数据的信息
	 */
	public function get_one_data() {
		$id = intval($_POST['id']);
		$this ->db ->select('*');
		$this ->db ->from('u_notice');
		$this ->db ->where(array('id' =>$id));
		$query = $this ->db ->get();
		$data = $query ->result_array();
		$data = $data [0];
		$notice_type = explode(',' ,$data ['notice_type']);
		foreach($notice_type as $val) {
			switch ($val)
			{
				case 1:
					$type1 = "checked='checked'";
					break;
				case 2:
					$type2 = "checked='checked'";
					break;
				case 3:
					$type3 = "checked='checked'";
					break;
				default:
					break;
			}

		}
		$data ['type1'] = empty($type1)?0:$type1;
		$data ['type2'] = empty($type2)?0:$type2;
		$data ['type3'] = empty($type3)?0:$type3;
		echo json_encode($data);
	}

}