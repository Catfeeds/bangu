<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年8月31日18:30:53
 * @author		zhy
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Per_list extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/per_list_model', 'per_list_model' );
		$this->load->library ( 'callback' );
	}
	//站点配置展示
	public function perivi_list() {
		$id= $this ->session ->userdata('a_user_id');
		$sql = "select * from u_admin where id = {$id}";
		$query = $this ->db ->query($sql);
		$data = $query ->row();
		$this->load_view ( 'admin/a/ui/user/per_list',$data);
	}
	
	//编辑网站配置
	public function edit_user() {
		
		$id=$_POST['id'];$username=$_POST['username'];$realname=$_POST['realname'];$email=$_POST['email'];$qq=$_POST['qq'];$mobile=$_POST['mobile'];$beizu=$_POST['beizu'];
		$this->load->helper('regexp');
			if (!regexp('realname' ,$realname)) {
				$sql = "select realname from u_admin where (realname='$realname')";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)>1) {
					$this->callback->set_code ( 4000 ,"此姓名已存在");
					$this->callback->exit_json();
				}
			}
			if (!regexp('email' ,$email)) {
				$this->callback->set_code ( 4000 ,"请填写正确的邮箱号");
				$this->callback->exit_json();
			} else {
				$sql = "select email from u_admin where (email='$email')";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)>1) {
					$this->callback->set_code ( 4000 ,"此邮箱已存在");
					$this->callback->exit_json();
				}
			}
		if (!regexp('mobile' ,$mobile)) {
				$this->callback->set_code ( 4000 ,"请填写正确的手机号");
				$this->callback->exit_json();
			} else {
				$sql = "select mobile from u_admin where (mobile='$mobile')";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)>1) {
					$this->callback->set_code ( 4000 ,"此号码已存在");
					$this->callback->exit_json();
				}
			}
					if (!regexp('qq' ,$qq)) {
				$this->callback->set_code ( 4000 ,"请填写正确的qq号");
				$this->callback->exit_json();
			} else {
				$sql = "select qq from u_admin where (qq='$qq')";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)>1) {
					$this->callback->set_code ( 4000 ,"此qq号码已存在");
					$this->callback->exit_json();
				}
			}
		$data=array('id'=>$id,'username'=>$username,'realname'=>$realname,'email'=>$email,'mobile'=>$mobile,'qq'=>$qq,'beizu'=>$beizu);
		$this->db->where('id', $id);
		$status = $this->db->update('u_admin', $data);
		$this->callback->set_code ( 2000 ,"更新成功！");
		$this->callback->exit_json();
	}
 
	

}