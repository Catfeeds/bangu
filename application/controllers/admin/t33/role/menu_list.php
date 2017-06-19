<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @method  权限管理
 * @since 2016-07-28
 * @author xml
 */
class Menu_list extends T33_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->model('admin/t33/b_role_model','role_model');
	}
	/**
	 * 旅行社菜单管理
	 * */
	public function index()
	{ 	
		//顶级菜单
		$this->load->model('admin/t33/b_directory_model','directory_model');
		$data['pdirectory']=$this->directory_model->all(array('pid'=>0),'showorder');
		//角色
		$data['roleData'] = $this ->role_model ->all(array());
		$this->load->view('admin/t33/role/menu_list_view',$data);
	}
	public function getDirectoryJson()
	{
		//分页
		$page = $this->input->post ( 'page', true );
		$page_size =15;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;

		$whereArr = array();
		$directory_id=$this->input->post('sch_directory',true);
		$name=$this->input->post('sch_name',true);
		if(!empty($directory_id))
			$whereArr['pid']=$directory_id;
		if(!empty($name))
			$whereArr['name']=$name;
		
		$data = $this ->role_model ->directory_list($whereArr,$from,$page_size); //角色
		$total_rows=$data['total_rows'];

		$total_page=ceil ($total_rows/$page_size );	
		if(empty($data))  $this->__data($data);
		$output=array(
			'page_size'=>$page_size,
			'page'=>$page,
			'total_rows'=>$total_rows,
			'total_page'=>$total_page,
			'result'=>$data['result']
		);
		$this->__data($output);
	}
	//添加菜单
	public function add_directory(){
 		$pid=$this->input->post('pid',true); 
 		$url=$this->input->post('directory_url',true); 
 		$showorder=$this->input->post('showorder',true); 
 		$isopen=$this->input->post('isopen',true); 
 		$description=$this->input->post('beizhu',true); 
 		$roleid=$this->input->post('roleid',true);  //选中的角色id
 		$name=$this->input->post('name',true);
 		$directory_id=$this->input->post('directory_id',true);  
		
 		$insertData=array(
 			'name'=>$name,
 			'url'=>$url,
 			'description'=>$description,
 			'pid'=>$pid,
 			'showorder'=>$showorder,
 			'isopen'=>$isopen
 		);
 
 		if($directory_id>0){  //编辑菜单

            $this->db->trans_start();

			$this->load->model('admin/t33/b_directory_model','directory_model');
 			$this->directory_model->update($insertData, array('directory_id'=>$directory_id));
 
			$this->db->trans_complete();
                           	if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'编辑失败'));
			}else{
				 echo json_encode(array('code'=>2000,'msg'=>'编辑成功'));
			}
 		}else{  //添加菜单

 			$this->db->trans_start();

 			//添加菜单表
 			$this->load->model('admin/t33/b_directory_model','directory_model');
			$directory_id=$this->directory_model->insert($insertData);
			//添加到旅行社统一角色中
			$admin_role=$this->role_model->row(array('roleid'=>'1','union_id'=>'0'));
			if(!empty($admin_role))
			{
				$this->db->insert('b_role_directory',array('roleid'=>$admin_role['roleid'],'directory_id'=>$directory_id));
			}
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'添加失败'));
			}else{
				 echo json_encode(array('code'=>2000,'msg'=>'添加成功'));
			}
 		}

	}
	/*
	*@method  获取菜单数据
	*/
	public function getDirectoryRow(){
		$whereArr = array();
		$directory_id=$this->input->post('directory_id',true);
		$this->load->model('admin/t33/b_directory_model','directory_model');
		$data = $this ->directory_model ->row(array('directory_id'=>$directory_id)); //角色
		$roleData= '';
		if(!empty($data)){
		      $roleData = $this ->role_model ->get_directory_role(array('directory_id' =>$directory_id)); //菜单角色
		}
		echo json_encode(array('directory'=>$data,'role'=>$roleData));
	}
	
	
	/*
	 * 全部旅行社订单
	 * */
	public function all_order()
	{
		$this->load->view("admin/t33/role/order_list");
	}
	/**
	 * 订单列表：接口
	 * */
	public function api_all_order()
	{
		$productname=trim($this->input->post("productname",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$item_code=trim($this->input->post("item_code",true));
		$expert_name=trim($this->input->post("expert_name",true));
		$destname=trim($this->input->post("destname",true));
		$startplace=trim($this->input->post("startplace",true));
		$order_code=trim($this->input->post("order_code",true)); //order 6种状态
		$dest_id=trim($this->input->post("dest_id",true));
		$supplier_name=$this->input->post("supplier_name",true);
		$depart_id=trim($this->input->post("depart_id",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = sys_constant::B_PAGE_SIZE;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=[];
			//$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
				
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($item_code))
				$where['item_code']=$item_code;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($destname))
				$where['destname']=$destname;
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($order_code))
				$where['order_code']=$order_code;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
	
			$return=$this->u_member_order_model->order_list($where,$from,$page_size);
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql'=>$return['sql'],
					'account'=>$return['account'],
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/*
	 * 复制订单：处理
	 * */
	public function api_copy_order()
	{
		$order_id=$this->input->post("order_id",true);
		$union_id=$this->input->post("union_id",true);
		$expert_id=$this->input->post("expert_id",true);
		$supplier_id=$this->input->post("supplier_id",true);
		
		if(empty($union_id)) $this->__errormsg('旅行社id不能为空');
		if(empty($expert_id))  $this->__errormsg('管家id不能为空');
		if(empty($supplier_id))  $this->__errormsg('供应商id不能为空');
		
		//加载数据模型
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
		
		$this->load->model('admin/t33/approve/u_item_apply_model','u_item_apply_model'); //交款申请表
		
		$this->load->model('admin/t33/approve/u_payable_order_model','u_payable_order_model'); //付款关联订单表
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$this->load->model('admin/t33/approve/u_payable_apply_pic_model','u_payable_apply_pic_model'); //付款流水单表
		$this->load->model('admin/t33/u_member_order_model','u_member_order_model'); //订单表
		
		$this->load->model('admin/t33/limit/b_expert_limit_apply_model','b_expert_limit_apply_model'); //信用额度使用表
		$this->load->model('admin/t33/limit/b_limit_apply_model','b_limit_apply_model'); //申请表
		
		$this->load->model('admin/t33/bill/b_depart_settlement_model','b_depart_settlement_model');  // 营业部结算申请
		$this->load->model('admin/t33/bill/u_exchange_model','u_exchange_model');  // 提现申请
		$this->load->model('admin/t33/approve/u_order_debit_model','u_order_debit_model'); //订单扣款表
		$this->load->model('admin/t33/approve/u_supplier_refund_model','u_supplier_refund_model'); //供应商退款申请
		
		$this->db->trans_begin();
		//1、复制订单表
		$order=$this->u_member_order_model->row(array('id'=>$order_id));
		$max_order=$this->u_member_order_model->row(array(),'arr','id desc','ordersn');
		unset($order['id']);
		$order['platform_id']=$union_id;
		$order['expert_id']=$expert_id;
		$order['supplier_id']=$supplier_id;
		$order['ordersn']=$max_order['ordersn']+1;
		$new_order_id=$this->u_member_order_model->insert($order);
		
		var_dump($max_order);
		exit();
		//提交
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('已复制');
		}
	}
}