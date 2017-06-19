<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		贾开荣
*
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Pri_role extends UA_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/pri_role_model','role_model');
	}
	public function __destruct(){
		$this ->db ->close();
	}

	public function role_list() {
		$data ['list'] = $this ->role_model ->get_pri_role_data();

		$this ->load_view('admin/a/ui/pri/role_list' ,$data);
	}


	//获取管理员数据
	public function get_admin_json() {
		$this ->load_model ('admin/a/admin_model' ,'admin_model');

		$list = $this ->admin_model ->get_admin_data();
		echo json_encode($list);
	}

	//添加角色
	public function add_role() {
		$user = $this ->input ->post('user' ,true);
		$roleName = trim($this ->input ->post('roleName' ,true));
		$description = trim($this ->input ->post('description' ,true));
		if (empty($roleName))
		{
			echo json_encode(array('status' =>-1 ,'msg' =>'请填写角色名'));
			exit;
		}
		if (empty($user))
		{
			echo json_encode(array('status' =>-2 ,'msg' =>'请选择对应管理员'));
			exit;
		}
		//插入角色表
		$data = array(
			'roleName' =>$roleName,
			'description' =>$description
		);
		$status = $this -> db ->insert('pri_role' ,$data);
		$role_id = $this ->db ->insert_id();
		//插入用户角色关联表
		if (is_array($user))
		{
			foreach($user as $val)
			{
				$data = array(
						'adminId' =>$val,
						'roleId' =>$role_id
				);
				$this ->db ->insert('pri_adminrole' ,$data);
			}
		}
		$this ->log(1,3,"平台基础设置->角色管理","平台添加角色,记录ID:{$role_id}");
		$this ->delete_admin__nav_cache();
		echo json_encode(array('status' =>1 ,'msg' =>'添加成功'));
	}

	//编辑角色
	public function edit_role (){
		$id = intval($_POST['roleId']);
		$roleName = trim($this ->input ->post('roleName' ,true));
		$user = $this ->input ->post('user' ,true);
		$description = trim($this ->input ->post('description' ,true));
		if (empty($roleName))
		{
			echo json_encode(array('status' =>-1 ,'msg' =>'请填写角色名'));
			exit;
		}
		if (empty($user))
		{
			echo json_encode(array('status' =>-2 ,'msg' =>'请选择对应管理员'));
			exit;
		}
		//修改角色表
		$data = array(
			'roleName' =>$roleName,
			'description' =>$description
		);
		$this ->db ->where(array('roleId' =>$id));
		$status = $this -> db ->update('pri_role' ,$data);
		//修改用户角色关联表
		//删除原有关联项 再插入
		$this ->db ->delete('pri_adminrole' ,array('roleId' =>$id));
		if (is_array($user))
		{
			foreach($user as $val)
			{
				$data = array(
						'adminId' =>$val,
						'roleId' =>$id
				);
				$this ->db ->insert('pri_adminrole' ,$data);
			}
		}
		$this ->log(3,3,"平台基础设置->角色管理","平台编辑角色,记录ID:{$id}");
		$this ->delete_admin__nav_cache();
		echo json_encode(array('status' =>1 ,'msg' =>'编辑成功'));

	}

	//获取某个角色的信息
	public function get_one_json() {
		$id = intval($_POST['id']);
		$role = $this ->role_model ->get_pri_role_data(array('roleId' =>$id));
		$data ['role'] = $role [0];

		//获取角色对应的管理员
		$sql = "select adminId from pri_adminrole where roleId = {$id}";
		$query = $this ->db ->query($sql);
		$data ['admin_id'] = $query ->result_array();
		//获取管理员
		$this ->load_model ('admin/a/admin_model' ,'admin_model');

		$data ['admin'] = $this ->admin_model ->get_admin_data();
		echo json_encode($data);
	}
	//删除角色
	public function delete() {
		$id = intval($_POST['id']);
		$where = array('roleId' =>$id);
		//删除角色表
		$this ->db ->where($where);
		$this ->db ->delete('pri_role');
		//删除功能角色表
		$sql = "delete from pri_roleresource where roleId = {$id}";
		$this ->db ->query($sql);
		//删除用户角色关联表
		$sql = "delete from pri_adminrole where roleId = {$id}";
		$this ->db ->query($sql);
		$this ->delete_admin__nav_cache();
		echo json_encode(array('status' =>1 ,'msg' =>'删除成功'));
	}
	//删除管理员的导航缓存
	public function delete_admin__nav_cache() {
		$this->load->model ( 'admin/a/admin_model', 'admin_model' );
		//获取管理员
		$admin_list = $this ->admin_model ->all(array());
		if (!empty($admin_list)) {
			$this->load->helper ( 'common' ); //加载缓存方法
			foreach($admin_list as $val) {
				//删缓存
				cache_del($val['username'].'_'.$val['id']);
			}
		}
	}
}