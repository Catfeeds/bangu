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
class Pri_manage extends UA_Controller {
	const pagesize = 10;
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/pri_resource_model','pri_model');
	}
	public function __destruct(){
		$this ->db ->close();
	}
	
	/**
	 * 权限列表
	 * @author 贾开荣
	 */
	public function pri_list() {
		$whereArr = array();
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$pid = intval($this ->input ->post('pid')); //搜索顶级
		$is = intval($this ->input ->post('is')); //是否ajax分页
		$page_new = empty($page_new)?1:$page_new;
		
		if (!empty($pid)) {
			$likeArr ["code"] = $pid;
		}

		//获取数据
		$list = $this ->pri_model ->get_pri_data($whereArr ,$page_new ,self::pagesize ,1 ,$likeArr);
		$count = $this->getCountNumber($this->db->last_query());
		$page_str = $this ->getAjaxPage($page_new ,$count);
	//	echo $this ->db ->last_query();
		//获取顶级
		$top_pri = $this ->pri_model ->get_pri_data(array('pid' => 0) ,0,0,0);
		$data = array(
			'list' =>$list,
			'page_string' =>$page_str,
			'top_pri' =>$top_pri
		);
		if ($is == 1) {
			echo json_encode($data);
			exit;
		}
		$this ->load_view('admin/a/ui/pri/pri_list' ,$data);
	}
	
	
	/**
	 * 获取一条数据
	 * @author 贾开荣
	 */
	public function get_one_data() {
		$id = intval($_POST['id']);
		$data = $this ->pri_model ->get_pri_data(array('resourceId' =>$id));
		
		$this->load_model('admin/a/pri_role_model','role_model');
		$data ['role'] = $this ->role_model ->get_pri_role_data();
		$data ['pri'] = $this ->pri_model ->get_pri_data(array(),0,0,0);
		$data ['role_id'] = $this ->get_role_id($id);
		echo json_encode($data);
	}
	//获取某条功能表记录对应的角色ID
	public function get_role_id ($id) {
		$query = $this ->db ->query("select roleId from pri_roleresource where resourceId ={$id}");
		return $query ->result_array();
	}
	
	//输出角色json数据
	public function get_role_json() {
		$this->load_model('admin/a/pri_role_model','role_model');
		$data ['role'] = $this ->role_model ->get_pri_role_data();
		$data ['pri'] = $this ->pri_model ->get_pri_data(array('code >' =>0) ,0,0,0);
		echo json_encode($data);
	}
	
	//获取管理员与功能表数据
	public function get_json_data () {
		$this->load_model('admin/a/admin_model','admin_model');
		$data ['admin'] = $this ->admin_model ->get_admin_data();
		$data ['pri'] = $this ->pri_model ->get_pri_data();
		echo json_encode($data);
	}
	
	
	//编辑角色权限
	public function edit_pri () {
		$resourceId = intval($_POST['resourceId']);
		$role = $this ->input ->post('role' ,true);
		
		$uri = trim($this ->input ->post('uri' ,true));
		$order = intval($this ->input ->post('order' ,true)); //排序
		$description = trim($this ->input ->post('description' ,true)); //描述
		$name = trim($this ->input ->post('name' ,true));
		$parent_pri = intval($this ->input ->post('parent_pri' ,true)); //上级id
		$showorder = intval($this ->input ->post('showorder')); //排序
		$showorder = empty($showorder) ? 888 :$showorder;
		if ($parent_pri == $resourceId)
		{
			echo json_encode(array('status' =>-8 ,'msg' =>'不可以选择自己作为自己的上级'));
			exit;
		}		
		
		if (empty($name))
		{
			echo json_encode(array('status' =>-1 ,'msg' =>'请填写菜单标题'));
			exit;
		}
		
		if (empty($role))
		{
			echo json_encode(array('status' =>-3 ,'msg' =>'请选择角色'));
			exit;
		}
		//获取code 根据选择的上级    若为顶级则code为自己的id前加一个0
		$sql = "select code,pid from pri_resource where resourceId = {$resourceId}";//得到原来的pid
		$query = $this ->db ->query($sql);
		$info = $query ->result_array();
		if ($info [0]['pid'] == $parent_pri) { //上级id没有改变code是原来的
			$code = $info [0]['code'];
		} 
		
		if ($this ->get_lower($resourceId) && $parent_pri != $info [0]['pid']) //有下级且上级改变
		{
			echo json_encode(array('status' =>-9 ,'msg' =>'此标题下存在下级标题，若要更改其上级标题，请先更改其下面的子级标题'));
			exit;
		}
		//写入功能表
		$data = array(
				'name' => $name,
				'description' =>$description,
				'uri' =>$uri,
				'showorder' =>$showorder
		);

		$this ->db ->where(array('resourceId' =>$resourceId));
		$status = $this ->db ->update('pri_resource' ,$data);
		
		if (empty($status))
		{
			echo json_encode(array('status' =>-4 ,'msg' =>'操作失败'));
			exit;
		}
		
		if (empty($code)) { //上级id没有改变code是原来的
			if ($parent_pri != 0)
				$code = $this ->create_code($parent_pri ,$resourceId);
			else 
				$code = $resourceId;
		}
		//修改数据的code的值
		$this ->db ->where(array('resourceId' =>$resourceId));
		$status = $this ->db ->update('pri_resource' ,array('code' =>$code ,'pid' =>$parent_pri));
		
		//删除原有的关联项,再新增
		$this ->db ->delete('pri_roleresource' ,array('resourceId' =>$resourceId));
		foreach($role as $val)
		{
			$data = array(
				'resourceId' =>$resourceId,
				'roleId' =>$val
			);
			$this ->db ->insert('pri_roleresource' ,$data);
		}
		$this ->log(3,3,"平台基础设置->权限管理","平台编辑角色权限,记录ID:{$resourceId}");
		$this ->delete_admin__nav_cache();
		echo json_encode(array('status' =>1 ,'msg' =>'编辑成功'));
	}
	//添加角色权限
	public function add_pri () {
		$role = $this ->input ->post('role' ,true);
	
		$uri = trim($this ->input ->post('uri' ,true));
		$order = intval($this ->input ->post('order' ,true)); //排序
		$description = trim($this ->input ->post('description' ,true)); //描述
		$name = trim($this ->input ->post('name' ,true));
		$parent_pri = intval($this ->input ->post('parent_pri' ,true)); //上级id
		$showorder = intval($this ->input ->post('showorder')); //排序
		$showorder = empty($showorder) ? 888 :$showorder;
		
		if (empty($name))
		{
			echo json_encode(array('status' =>-1 ,'msg' =>'请填写菜单标题'));
			exit;
		}
		
		if (empty($role))
		{
			echo json_encode(array('status' =>-3 ,'msg' =>'请选择角色'));
			exit;
		}
		//写入功能表
		$data = array(
				'name' => $name,
				'description' =>$description,
				'uri' =>$uri,
				'pid' =>$parent_pri,
				'showorder' =>$showorder
		);
	
		$status = $this ->db ->insert('pri_resource' ,$data);
		$resourceId = $this ->db ->insert_id();
		if (empty($status))
		{
			echo json_encode(array('status' =>-4 ,'msg' =>'操作失败'));
			exit;
		}
	
		//获取code 根据选择的上级    若为顶级则code为自己的id前加一个0
		if ($parent_pri != 0)
			$code = $this ->create_code($parent_pri ,$resourceId);
		else
			$code = $resourceId;
		//修改数据的code的值
		$this ->db ->where(array('resourceId' =>$resourceId));
		$status = $this ->db ->update('pri_resource' ,array('code' =>$code));
	
		foreach($role as $val)
		{
			$data = array(
					'resourceId' =>$resourceId,
					'roleId' =>$val
			);
			$this ->db ->insert('pri_roleresource' ,$data);
		}
		$this ->log(1,3,"平台基础设置->权限管理","平台添加角色权限,记录ID:{$resourceId}");
		$this ->delete_admin__nav_cache();
		echo json_encode(array('status' =>1 ,'msg' =>'添加成功'));
	}
	//删除
	public function delete() {
		$id = intval($_POST['id']);
		if ($this ->get_lower($id))
		{
			echo json_encode(array('status' =>-2 ,'msg' =>'该标题下还有下级，不可删除'));
			exit;
		}
		$this ->db ->where(array('resourceId' =>$id));
		$status = $this ->db ->delete('pri_resource');
		if (empty($status))
		{
			echo json_encode(array('status' =>-1 ,'msg' =>'删除失败'));
			exit;
		}
		$this ->log(2,3,"平台基础设置->权限管理","平台删除角色权限,记录ID:{$id}");
		$this ->delete_admin__nav_cache();
		echo json_encode(array('status' =>1 ,'msg' =>'删除成功'));
	}
	
	//查找是否有下级
	function get_lower($id) {
		$sql = "select resourceId,pid,code from pri_resource where pid = {$id}"; //查询下级
		$query = $this ->db ->query($sql);
		$data = $query ->result_array();
		if (empty($data))
			return false;
		else 
			return true;  //有下级
	}
	
	/**
	 * 生成标识码
	 * @author 贾开荣
	 * @param intval $parent_pri 上级id
	 * @param intval $resourceId 自己的id
	 * @return string
	 */
	public function create_code($parent_pri ,$resourceId) {
		//根据上级id查询出标识码最大的记录，排除它自己的  
		$sql = "select code,pid,resourceId from pri_resource where pid = {$parent_pri} and resourceId != {$resourceId}  order by code desc limit 0,1";
		$query = $this ->db ->query($sql);
		$parent = $query ->result_array();
		//var_dump($parent);
		if (empty($parent)) //选择的上级没有下级 自己除外
		{
			//得到上级的code
			$sql = "select code,pid,resourceId from pri_resource where resourceId = {$parent_pri}";
			$query = $this ->db ->query($sql);
			$parent_info = $query ->result_array();
			$code = $parent_info [0]['code'].'01';
		}
		else
		{
			$code = $parent [0]['code'];
			$last_code = substr($code ,-1);
			if ($last_code == 9)
			{
				$last_code_two = substr($code ,-2,-1);
				$first_code = substr ($code ,0 ,strlen($code) -2);
				$last_code = $last_code_two + 1;
				$code = $first_code.$last_code.'0';
			}
			else
			{
				$first_code = substr ($code ,0 ,strlen($code) -1);
				$last_code = $last_code + 1;
				$code = $first_code.$last_code;
			}
		}
		return $code;
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