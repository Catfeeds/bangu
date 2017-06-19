<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_msg.php';
//"线路"控制器

class Line extends T33_Controller {

	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_union_bank_model','b_union_bank_model');
		$this->load->model('admin/t33/common_model','common_model');
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
	}
	/**
	 * 线路列表
	 * */
	public function all()
	{
		$this->load->view("admin/t33/line/all");
	}
	/**
	 * 线路列表：接口
	 * */
	public function api_all()
	{
		$type=trim($this->input->post("type",true)); //1是直属供应商，2是非直属供应商
		$dest_id=trim($this->input->post("dest_id",true));
		$startplace=trim($this->input->post("startplace",true));
		$linename=trim($this->input->post("linename",true));
		$linecode=trim($this->input->post("linecode",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$days_start=trim($this->input->post("days_start",true));
		$days_end=trim($this->input->post("days_end",true));
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
		$supplier_name=trim($this->input->post("supplier_name",true));
		$line_classify=trim($this->input->post("line_classify",true));
		$linkman=trim($this->input->post("linkman",true));

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
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";


			$where['type']=$type;
			$where['union_id']=$union_id;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($linename))
				$where['linename']=$linename;
			if(!empty($linecode))
				$where['linecode']=$linecode;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($days_start))
				$where['days_start']=$days_start;
			if(!empty($days_end))
				$where['days_end']=$days_end;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($line_classify))
				$where['line_classify']=$line_classify;
			if(!empty($linkman))
				$where['linkman']=$linkman;

			$return=$this->u_line_model->line_all($where,$from,$page_size);
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );

			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql'=>$return['sql'],
					'result'=>$result
			);
			$this->__data($output);
		}

	}
	/**
	 * 线路审核
	 * */
	public function setting()
	{
		$lineid=$this->input->get("id",true);
		$supplier_id=$this->input->get("supplier_id",true); //供应商id
		$union_id=$this->get_union();
		$line=$this->u_line_model->row(array('id'=>$lineid));
		if($line['producttype']=="0")
			$agent_type="1";
		else 
			$agent_type="2";
		$data['agent_type']=$agent_type;
		$data['agent'] = $this ->u_line_model->line_agent($supplier_id,$union_id,$agent_type); //佣金（按人群、比例）
		$approve_line=$this->u_line_model->approve_line($supplier_id,$union_id,$lineid);
		$data['id']=$approve_line['id'];
		$data['lineid']=$lineid;
		$data['line']=$this->u_line_model->row(array('id'=>$lineid)); //线路详情
		$data['days'] = $this ->u_line_model->day_agent($supplier_id,$union_id,$agent_type); //按天佣金
		$this->load->view("admin/t33/line/setting",$data);
	}
	/**
	 * @method t33,帮游同步通过线路
	 * 线路审核通过:api
	 * */
	public function api_setting_deal()
	{
		$id=$this->input->post("id",true);  // b_union_line_agent表id
		$reply=$this->input->post("reply",true);
		if(empty($id))  $this->__errormsg('id不能为空');
		$user=$this->userinfo();
		$now=date("Y-m-d H:i:s");
		$union_id=$this->get_union();  //旅行社id
		$this->db->trans_start();
			
		//T33联盟供应商提交线路，同时提交帮游，T33审核后帮游同步通过
		$row=$this->u_line_model->approve_row($id,$union_id);
		if($row['producttype']==0 &&$row['status']!=2 ) //包团的线路 不同步
		{
			  //上线时间为空时，才更新上线时间
			  if(empty($row['lonline_time'])){
			  	$status=$this->u_line_model->update(array('status'=>'2','online_time'=>$now,'modtime'=>$now,'confirm_time'=>$now),array('id'=>$row['line_id']));
			  }else{
			  	$status=$this->u_line_model->update(array('status'=>'2','modtime'=>$now,'confirm_time'=>$now),array('id'=>$row['line_id']));
			  }
		}
		$this->u_line_model->update(array('admin_id'=>0),array('id'=>$row['line_id']));
		//管家申请线路的状态 --author xml
		$this->load->model ( 'admin/a/line_apply_model', 'line_apply_model' );
		$this->line_apply_model->update(array('status'=>2,'modtime'=>date('Y-m-d H:i:s' ,time())),array('status'=>5,'line_id'=>$row['line_id']));
	
		if(empty($row['online_time'])){
			$status=$this->u_line_model->approve_ok(array('status'=>'2','modtime'=>$now,'remark'=>$reply,'employee_name'=>$user['realname'],'confirm_time'=>$now,'online_time'=>$now),array('id'=>$id));
		}else{
			$status=$this->u_line_model->approve_ok(array('status'=>'2','modtime'=>$now,'remark'=>$reply,'employee_name'=>$user['realname'],'confirm_time'=>$now),array('id'=>$id));
		}

		$this->db->trans_complete();
		$re=$this->db->trans_status();
		
		if($re){
			//获取线路ID用于发送消息
			$lineData = $this ->u_line_model ->getUnionLineRow($id);
			if (!empty($lineData['id']))
			{
				$msg = new T33_msg();
				$msgArr = $msg ->sendMsgLine($lineData['id'],2,$this->session->userdata('employee_realname'));
			}
			$this->__data('已通过');
		}else
			$this->__errormsg('操作异常');
	}
	/**
	 * 线路审核通过:api
	 * */
	public function api_setting_refuse()
	{
		$id=$this->input->post("id",true);  // b_union_line_agent表id
		$reply=$this->input->post("reply",true);
		if(empty($reply)) $this->__errormsg('审核意见不能为空');
		if(empty($id))  $this->__errormsg('id不能为空');
		$status=$this->u_line_model->approve_ok(array('status'=>'3','modtime'=>date("Y-m-d H:i:s"),'remark'=>$reply),array('id'=>$id));
		if($status)
		{
			//获取线路ID用于发送消息
			$lineData = $this ->u_line_model ->getUnionLineRow($id);
			if (!empty($lineData['id']))
			{
				$msg = new T33_msg();
				$msgArr = $msg ->sendMsgLine($lineData['id'],2,$this->session->userdata('employee_realname'));
			}
			$this->__data('已拒绝');
		}
		else
			$this->__errormsg('操作异常');
	}
	/**
	 * 线路下线、退回申请中:api
	 * */
	public function api_setting_offline()
	{
		$id=$this->input->post("id",true);  // b_union_line_agent表id
		$status=$this->input->post("status",true);
		if(empty($id))  $this->__errormsg('id不能为空');
		if(empty($status))  $this->__errormsg('status不能为空');

		$this->db->trans_start();
		
		//帮游线路,如该供应商同是t33供应商.同步下线
		
		$this->load->model('admin/t33/sys/b_union_approve_line_model','b_union_approve_line_model');
		$user=$this->userinfo();
		$ret=$this->b_union_approve_line_model->update(array('status'=>$status,'modtime'=>date("Y-m-d H:i:s"),'employee_name'=>$user['realname']),array('id'=>$id));
		
		$union_id=$this->get_union();  //旅行社id
		$row=$this->u_line_model->approve_row($id,$union_id);
		if($row['producttype']==0&&$row['status']!=4) //包团的线路 不同步
		{
			//帮游线路下线
			if($status==3 || $status==1){
				if($status==3){
					$line_status=4;
				}else{
					$line_status=$status;
				}
				$appline=$this->b_union_approve_line_model->row(array('id'=>$id));
				if($appline['line_id']){
					$dataArr = array(
							'status' =>$line_status,
							'modtime' =>date('Y-m-d H:i:s' ,time()),
							'line_status' =>1,
							'admin_id'=>0,
					);
					$this ->u_line_model ->update($dataArr ,array('id' =>$appline['line_id']));
				}
			}
			
		}
		
		//管家申请线路的状态----author xml
		$this->load->model ( 'admin/a/line_apply_model', 'line_apply_model' );
		$this->line_apply_model->update(array('status'=>5,'modtime'=>date('Y-m-d H:i:s' ,time())),array('status'=>2,'line_id'=>$row['line_id']));
		
		$this->db->trans_complete();
		$re=$this->db->trans_status();
		
		if($re)
		{
			if($status=="1")
			    $this->__data('已退回申请中');
			else if($status=="3")
				$this->__data('已下线');
		}
		else
			$this->__errormsg('操作异常');
	}
	/**
	 *线路审核:api
	 * */
	public function api_setting()
	{
		$id=$this->input->post("id",true);  //b_union_line_agent表id
		$line_id=$this->input->post("line_id",true);
		$man=$this->input->post("man",true);
		$oldman=$this->input->post("oldman",true);
		$child=$this->input->post("child",true);
		$childnobed=$this->input->post("childnobed",true);
		$userinfo=$this->userinfo();
		$this->load->model('admin/t33/sys/b_union_line_agent_model','b_union_line_agent_model');
		$addtime=date("Y-m-d H:i:s");
		if(empty($id))
		{
			$data=array(
				'line_id'=>$line_id,
				'union_id'=>$userinfo['union_id'],
				'employee_id'=>$userinfo['id'],
				'man'=>$man,
				'oldman'=>$oldman,
				'child'=>$child,
				'childnobed'=>$childnobed,
				'addtime'=>$addtime,
				'modtime'=>$addtime
			);
			$exist=$this->b_union_line_agent_model->row(array('union_id'=>$userinfo['union_id'],'line_id'=>$line_id));
			if(empty($exist))
			$status=$this->b_union_line_agent_model->insert($data);
			else
				$this->__errormsg('操作异常');
		}
		else
		{
			$data=array(
					'man'=>$man,
					'oldman'=>$oldman,
					'child'=>$child,
					'childnobed'=>$childnobed,
					'modtime'=>$addtime
			);
			$status=$this->b_union_line_agent_model->update($data,array('id'=>$id));
		}

		//结果
		if($status)
			$this->__data('设置成功');
		else
			$this->__errormsg('操作失败');
	}
	/**
	 * 线路列表
	 * */
	public function line_list()
	{
		$this->load->view("admin/t33/line/line_list");
	}
	/**
	 * 线路列表：接口
	 * */
	public function api_line_list()
	{
		$type=trim($this->input->post("type",true)); //1是直属供应商，2是非直属供应商
		$dest_id=trim($this->input->post("dest_id",true));
		$startplace=trim($this->input->post("startplace",true));
		$linename=trim($this->input->post("linename",true));
		$linecode=trim($this->input->post("linecode",true));

		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$days_start=trim($this->input->post("days_start",true));
		$days_end=trim($this->input->post("days_end",true));
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
		$team_code=trim($this->input->post("team_code",true));
		

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
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";


			$where['type']=$type;
			$where['union_id']=$union_id;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($linename))
				$where['linename']=$linename;
			if(!empty($linecode))
					$where['linecode']=$linecode;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($days_start))
				$where['days_start']=$days_start;
			if(!empty($days_end))
				$where['days_end']=$days_end;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($team_code))
				$where['team_code']=$team_code;

			$return=$this->u_line_model->line_list($where,$from,$page_size);
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );

			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql1'=>$return['sql1'],
					'sql2'=>$return['sql2'],
					'sql3'=>$return['sql3'],
					'result'=>$result
			);
			$this->__data($output);
		}

	}
	/**
	 * 线路详情
	 * */
	public function detail()
	{
		$line_id=$this->input->get("id",true);
		$line = $this->F_line_detail_more($line_id);
		$data['line']=$line;
		$this->load->model ( 'admin/b1/user_shop_model' );
		//上车地点
   		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$line_id));
	//	var_dump($data['line']);exit;
		$this->load->view("admin/t33/line/detail",$data);
	}
	//套餐详情
	public function getProductPriceJSON(){
		$this->load->model ( 'admin/b1/user_shop_model' );

		$lineId = $this->get("lineId");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId);
		}
		//echo $this->db->last_query();
		echo $productPrice;
	}
	/**
	 * 线路行程
	 * */
	public function trip()
	{
		$line_id=$this->input->get("id",true);
		$dayid=$this->input->get("dayid",true);
		$return = $this ->u_line_model ->line_trip($line_id);
		
		$this->load->model ( 'admin/t33/sys/u_line_suit_price_model', 'u_line_suit_price_model' );
		$data['suit']=$this->u_line_suit_price_model->row(array('dayid'=>$dayid));

		
		$data['list'] = $return['result'];
		$union_id=$this->get_union();
		$this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model');
		$data['logo']=$this->b_union_log_model->row(array('union_id'=>$union_id));
		$data['line']=$this->F_line_detail_more($line_id);
		$data['dayid']=$dayid;
		//var_dump($data);
		$this->load->view("admin/t33/line/trip",$data);
	}
	/**
	 * 单项产品
	 * */
	public function single()
	{
		$this->load->view("admin/t33/line/single");
	}
	/**
	 * 单项产品：接口
	 * */
	public function api_single()
	{
		$type=trim($this->input->post("type",true)); //1是直属供应商，2是非直属供应商
		$dest_id=trim($this->input->post("dest_id",true));
		$startplace=trim($this->input->post("startplace",true));
		$linename=trim($this->input->post("linename",true));
		$linecode=trim($this->input->post("linecode",true));

		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$days_start=trim($this->input->post("days_start",true));
		$days_end=trim($this->input->post("days_end",true));
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));

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
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";


			$where['type']=$type;
			$where['union_id']=$union_id;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($linename))
				$where['linename']=$linename;
			if(!empty($linecode))
				$where['linecode']=$linecode;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($days_start))
				$where['days_start']=$days_start;
			if(!empty($days_end))
				$where['days_end']=$days_end;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;

			$return=$this->u_line_model->single_list($where,$from,$page_size);
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );

			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql'=>$return['sql'],

					'result'=>$result
			);
			$this->__data($output);
		}

	}
	/**
	 * 单项产品
	 *
	 * */
	public function add_single()
	{
		$union_id=$this->get_union();
		$expert_list=$this->u_expert_model->union_expert($union_id);
		$data['expert_list']=$expert_list;
		$data['supplier']=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id));

		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$data['server_list']=$this->b_server_range_model->all(array('union_id'=>$union_id,'status'=>'1'));
		$data['m_date']=date("ymd");

		$this->load->view("admin/t33/line/add_single",$data);
	}
	/**
	 * 单项产品:销售对象模糊搜索
	 *
	 * */
	public function api_single_expert()
	{
		$content=$this->input->post("content");
		$union_id=$this->get_union();
		$expert_list=$this->u_expert_model->union_expert($union_id,$content);
		$this->__data($expert_list);
	}
	/**
	 * 单项产品:服务类型模糊搜索
	 *
	 * */
	public function api_single_server()
	{
		$content=$this->input->post("content");
		$union_id=$this->get_union();
		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$server_list=$this->b_server_range_model->all(array('union_id'=>$union_id,'status'=>'1','server_name like'=>'%'.$content.'%'));
		$this->__data($server_list);
	}
	/**
	 * 单项产品:供应商模糊搜索
	 *
	 * */
	public function api_single_supplier()
	{
		$content=$this->input->post("content");
		$supplier_code=$this->input->post("supplier_code");
		$union_id=$this->get_union();
		$supplier=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id,'brand'=>$content,'supplier_code'=>$supplier_code,'status'=>'1'));
		$this->__data($supplier);
	}
	/*
	 * 接口: 添加单项
	 * 1、单项编号生成规则：
	 *                 如：  AFIT-160929nyfq001
	 *                  第一个A：（出境A、国内B、省内周边C） ；
	 *                  FIT固定要加；
	 *                  160929 年月日 ；
	 *                  nyfq 供应商代码；
	 *                  001 旅行社对应供应商流水号
	 * */
	public function api_add_single()
	{
		$dest_id=$this->input->post("dest_id");
		$startplace=$this->input->post("startplace");
		$linecode=$this->input->post("linecode");
		$linename=$this->input->post("linename");
		$server_range=$this->input->post("server_range");
		$sell_object=$this->input->post("sell_object");
		$car_list=$this->input->post("car_list",true);
		$supplier_id=$this->input->post("supplier_id");
		$number=$this->input->post("number");
		$day=$this->input->post("day");
		$book_notice=$this->input->post("book_notice");
		$single_file_path=$this->input->post("single_file_path");
		$single_file_name=$this->input->post("single_file_name");

		$adultprice=$this->input->post("adultprice");
		$childprice=$this->input->post("childprice");
		$childnobedprice=$this->input->post("childnobedprice");
		$oldprice=$this->input->post("oldprice");
		$adultjs=$this->input->post("adultjs");
		$childjs=$this->input->post("childjs");
		$childnobedjs=$this->input->post("childnobedjs");
		$oldjs=$this->input->post("oldjs");


		$agent_object=$this->input->post("agent_object");
		$item=$this->input->post("item");
		$agent_rate=$this->input->post("agent_rate");
		$adult_agent=$this->input->post("adult_agent");
		$child_agent=$this->input->post("child_agent");
		$childnobed_agent=$this->input->post("childnobed_agent");
		$old_agent=$this->input->post("old_agent");

		$line_classify=$this->input->post("line_classify");
		$liushui_code=$this->input->post("liushui_code"); //流水号
		$object_name=$this->input->post("object_name");

		//if(empty($dest_id)) $this->__errormsg('目的地不能为空');
		if(empty($startplace)) $this->__errormsg('出发地不能为空');
		if(empty($linecode)) $this->__errormsg('单项编号不能为空');
		if(empty($linename)) $this->__errormsg('单项名称不能为空');
		if($supplier_id=="-1") $this->__errormsg('供应商不能为空');
		$today=date("Y-m-d");
		if($day<$today) $this->__errormsg('计划时间不能小于今天');
		//if(empty($single_file_name)) $this->__errormsg('行程文件不能为空');
		if(empty($adultprice)) $this->__errormsg('成人销售价不能为空');
		if(empty($agent_object)) $this->__errormsg('佣金收取对象不能为空');
		if($item=="1")
		{
		//if(empty($agent_rate)) $this->__errormsg('佣金比不能为空');
		}
		else if($item=="2")
		{
		//if(empty($adult_agent)) $this->__errormsg('成人佣金不能为空');
		//if(empty($child_agent)) $this->__errormsg('儿童占床佣金不能为空');
		//if(empty($childnobed_agent)) $this->__errormsg('儿童不占床佣金不能为空');
		//if(empty($oldprice)) $this->__errormsg('老人佣金不能为空');
		}

		//判断单项
		$linecodeArr=explode('-',$linecode);
		if(!empty($linecodeArr[1])){
			$codestr=substr($linecodeArr[1], 0, 6);
			$timedate=date("ymd",strtotime($day));
			if($codestr!=$timedate){
				$this->__errormsg('单项编号出错,请重新选择出团日期');
			}
		}else{
			$this->__errormsg('单项编号出错');
		}
		
		$this->db->trans_begin();
		//1、线路表
		$union_id=$this->get_union();
		$addtime=date("Y-m-d H:i:s");
		$overcity=$line_classify;
		/* if($overcity=="3")
			$overcity="2"; */
		$line_data=array(
			'producttype'=>'0',
			'linename'=>$linename,
			'linecode'=>$linecode,
			'overcity'=>$dest_id.$overcity,
			'overcity2'=>$dest_id,
			'book_notice'=>$book_notice,
			'addtime'=>$addtime,
			'modtime'=>$addtime,
			'supplier_id'=>$supplier_id,
			'status'=>'2',
			'linetitle'=>$linename,
			'online_time'=>$addtime,
			'line_classify'=>$line_classify,
			'line_kind'=>'2' //单项
		);
		$line_id=$this->u_line_model->insert($line_data);  //线路id
		$exist=$this->b_company_supplier_model->row(array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		if($exist['code']<$liushui_code)
		$this->b_company_supplier_model->update(array('code'=>$liushui_code),array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		else $this->__errormsg('单项编号已被占用，请重新选择供应商');
		//1.2线路：上车地点
		$this->load->model('admin/t33/sys/u_line_on_car_model','u_line_on_car_model');
		if(!empty($car_list))
		{
			foreach ($car_list as $car=>$car_value)
			{
				$this->u_line_on_car_model->insert(array('line_id'=>$line_id,'on_car'=>$car_value['on_car']));
			}
		}
		//2、出发城市
		$this->load->model('admin/t33/sys/u_line_startplace_model','u_line_startplace_model');
		$this->u_line_startplace_model->insert(array('line_id'=>$line_id,'startplace_id'=>$startplace));
		//2.2、目的地城市
		$this->load->model('admin/t33/sys/u_line_dest_model','u_line_dest_model');
		$this->u_line_dest_model->insert(array('line_id'=>$line_id,'dest_id'=>$line_classify));
		//3.1、套餐
		$suit=array(
			'lineid'=>$line_id,
			'suitname'=>'标准价',
			'description'=>''
		);
		$this->load->model('admin/t33/sys/u_line_suit_model','u_line_suit_model');
		$suit_id=$this->u_line_suit_model->insert($suit);
		//3、套餐价格
		$suit_data=array(
			'lineid'=>$line_id,
			'suitid'=>$suit_id,
			'day'=>$day,
			'description'=>$linecode,
			'childprofit'=>$childjs,
			'childprice'=>$childprice,
			'oldprofit'=>$oldjs,
			'oldprice'=>$oldprice,
			'adultprofit'=>$adultjs,
			'adultprice'=>$adultprice,
			'childnobedprofit'=>$childnobedjs,
			'childnobedprice'=>$childnobedprice,
			'number'=>$number
		);
		$this->load->model('admin/t33/sys/u_line_suit_price_model','u_line_suit_price_model');
		$this->u_line_suit_price_model->insert($suit_data);
		//4、b_single_affiliated 单项表
		$user=$this->userinfo();
		$this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');

		$single_data=array('union_id'=>$union_id,'line_id'=>$line_id,'server_range'=>$server_range,'sell_object'=>$sell_object,'object_name'=>$object_name,'employee_id'=>$user['id'],'employee_name'=>$user['realname']);
		$this->b_single_affiliated_model->insert($single_data);
		//5、行程文件
		$this->load->model('admin/t33/sys/b_single_file_model','b_single_file_model');
		if(!empty($single_file_path))
		{
			$single_file_path=substr($single_file_path, 0,-1);
			$single_file_name=substr($single_file_name, 0,-1);
			$path_arr=explode(",", $single_file_path);
			$name_arr=explode(",", $single_file_name);
			foreach ($path_arr as $k=>$v)
			{
				$inset_data=array('line_id'=>$line_id,'file'=>$v,'file_name'=>$name_arr[$k]);
				$this->b_single_file_model->insert($inset_data);
			}

		}
		//6、佣金表
		$this->load->model('admin/t33/sys/b_single_agent_model','b_single_agent_model');
		if($item=="1") $type="2";else if($item=="2") $type="1";
		$agent_data=array(
			'line_id'=>$line_id,
			//'type'=>$type,
			'type'=>'1',
			'object'=>$agent_object,
			//'agent_rate'=>$agent_rate,
			'adult'=>$adult_agent,
			'child'=>$child_agent,
			'childnobed'=>$childnobed_agent,
			//'old'=>$old_agent
		);
		$this->b_single_agent_model->insert($agent_data);
		//提交
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('已通过');
		}

	}
	/**
	 * 单项产品:修改
	 *
	 * */
	public function update_single()
	{
		$id=$this->input->get("id");  //b_single_affiliated 表id
		$this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');
		$this->load->model('admin/t33/sys/u_line_on_car_model','u_line_on_car_model');
		$row=$this->b_single_affiliated_model->single_detail($id);
		//var_dump($row);
		$data['row']=$row; //单项详情

		$this->load->model('admin/t33/sys/b_single_file_model','b_single_file_model');//行程文件
		$data['files']=$this->b_single_file_model->all(array('line_id'=>$row['line_id']),"id desc");

		$union_id=$this->get_union();
		$expert_list=$this->u_expert_model->union_expert($union_id);
		$data['expert_list']=$expert_list;
		$data['supplier']=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id));
		$data['car_lsit']=$this->u_line_on_car_model->all(array('line_id'=>$row['line_id'])); //上车地点

		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$data['server_list']=$this->b_server_range_model->all(array('union_id'=>$union_id,'status'=>'1'));
		$data['m_date']=date("ymd");

		$this->load->view("admin/t33/line/edit_single",$data);
	}
	/*
	 * 接口: 修改单项
	* 1、单项编号生成规则：
	*                 如：  AFIT-160929nyfq001
	*                  第一个A：（出境A、国内B、省内周边C） ；
	*                  FIT固定要加；
	*                  160929 年月日 ；
	*                  nyfq 供应商代码；
	*                  001 旅行社对应供应商流水号
	* */
	public function api_update_single()
	{
		$id=$this->input->post("id");//b_single_affiliated 表id
		$dest_id=$this->input->post("dest_id");
		$startplace=$this->input->post("startplace");
		$linecode=$this->input->post("linecode");
		$linename=$this->input->post("linename");
		$car_list=$this->input->post("car_list",true);
		$server_range=$this->input->post("server_range");
		$sell_object=$this->input->post("sell_object");
		$supplier_id=$this->input->post("supplier_id");
		$number=$this->input->post("number");
		$day=$this->input->post("day");
		$book_notice=$this->input->post("book_notice");
		$single_file_path=$this->input->post("single_file_path");
		$single_file_name=$this->input->post("single_file_name");

		$adultprice=$this->input->post("adultprice");
		$childprice=$this->input->post("childprice");
		$childnobedprice=$this->input->post("childnobedprice");
		$oldprice=$this->input->post("oldprice");
		$adultjs=$this->input->post("adultjs");
		$childjs=$this->input->post("childjs");
		$childnobedjs=$this->input->post("childnobedjs");
		$oldjs=$this->input->post("oldjs");

		$agent_object=$this->input->post("agent_object");
		$item=$this->input->post("item");
		$agent_rate=$this->input->post("agent_rate");
		$adult_agent=$this->input->post("adult_agent");
		$child_agent=$this->input->post("child_agent");
		$childnobed_agent=$this->input->post("childnobed_agent");
		$old_agent=$this->input->post("old_agent");

		//$line_classify=$this->input->post("line_classify");
		$object_name=$this->input->post("object_name");

		//if(empty($dest_id)) $this->__errormsg('目的地不能为空');
		if(empty($startplace)) $this->__errormsg('出发地不能为空');
		if(empty($linecode)) $this->__errormsg('单项编号不能为空');
		if(empty($linename)) $this->__errormsg('单项名称不能为空');
		if($supplier_id=="-1") $this->__errormsg('供应商不能为空');
		$today=date("Y-m-d");
		if($day<$today) $this->__errormsg('计划时间不能小于今天');
		//if(empty($single_file_name)) $this->__errormsg('行程文件不能为空');
		if(empty($adultprice)) $this->__errormsg('成人销售价不能为空');
		if(empty($agent_object)) $this->__errormsg('佣金收取对象不能为空');
		if($item=="1")
		{
			//if(empty($agent_rate)) $this->__errormsg('佣金比不能为空');
		}
		else if($item=="2")
		{
			//if(empty($adult_agent)) $this->__errormsg('成人佣金不能为空');
			//if(empty($child_agent)) $this->__errormsg('儿童占床佣金不能为空');
			//if(empty($childnobed_agent)) $this->__errormsg('儿童不占床佣金不能为空');
			//if(empty($oldprice)) $this->__errormsg('老人佣金不能为空');
		}

		//判断单项
		$linecodeArr=explode('-',$linecode);
		if(!empty($linecodeArr[1])){
			$codestr=substr($linecodeArr[1], 0, 6);
			$timedate=date("ymd",strtotime($day));
			if($codestr!=$timedate){
				$this->__errormsg('单项编号出错,请重新选择出团日期');
			}
		}else{
			$this->__errormsg('单项编号出错');
		}
		$this->db->trans_begin();
		//1、b_single_affiliated 单项表
		$user=$this->userinfo();
		$this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');
		$one=$this->b_single_affiliated_model->row(array('id'=>$id));
		$line=$this->u_line_model->row(array('id'=>$one['line_id']));
		$line_classify=isset($line['line_classify'])==true?','.$line['line_classify']:'';

		$union_id=$this->get_union();

		$single_data=array('union_id'=>$union_id,'server_range'=>$server_range,'sell_object'=>$sell_object,'object_name'=>$object_name,'employee_id'=>$user['id'],'employee_name'=>$user['realname']);
		$this->b_single_affiliated_model->update($single_data,array('id'=>$id));
		
		//1.2 修改 u_line_on_car表
		$this->load->model('admin/t33/sys/u_line_on_car_model','u_line_on_car_model');
		$this->u_line_on_car_model->delete(array('line_id'=>$one['line_id']));
		if(!empty($car_list))
		{
			foreach ($car_list as $car=>$car_value)
			{
				$this->u_line_on_car_model->insert(array('line_id'=>$one['line_id'],'on_car'=>$car_value['on_car']));
			}
		}
		
		//2、线路表
		$addtime=date("Y-m-d H:i:s");
		$line_data=array(
				'linename'=>$linename,
				'linecode'=>$linecode,
				//'overcity'=>$dest_id.$line_classify,
				//'overcity2'=>$dest_id,
				'book_notice'=>$book_notice,
				'modtime'=>$addtime,
				'status'=>'2',
				'linetitle'=>$linename
		);
		$line_id=$this->u_line_model->update($line_data,array('id'=>$one['line_id']));  //线路id
		//2、出发城市
		$this->load->model('admin/t33/sys/u_line_startplace_model','u_line_startplace_model');
		$this->u_line_startplace_model->update(array('startplace_id'=>$startplace),array('line_id'=>$one['line_id']));
		//22、目的地城市
		$this->load->model('admin/t33/sys/u_line_dest_model','u_line_dest_model');
		$this->u_line_dest_model->update(array('dest_id'=>$dest_id),array('line_id'=>$one['line_id']));
		//3、套餐
		$suit_data=array(
				'day'=>$day,
				'description'=>$linecode, //团号
				'childprofit'=>$childjs,
				'childprice'=>$childprice,
				'oldprofit'=>$oldjs,
				'oldprice'=>$oldprice,
				'adultprofit'=>$adultjs,
				'adultprice'=>$adultprice,
				'childnobedprofit'=>$childnobedjs,
				'childnobedprice'=>$childnobedprice,
				'number'=>$number
		);
		$this->load->model('admin/t33/sys/u_line_suit_price_model','u_line_suit_price_model');
		$this->u_line_suit_price_model->update($suit_data,array('lineid'=>$one['line_id']));

		//5、行程文件
		$this->load->model('admin/t33/sys/b_single_file_model','b_single_file_model');
		$this->b_single_file_model->delete(array('line_id'=>$one['line_id']));
		if(!empty($single_file_path))
		{
			$single_file_path=substr($single_file_path, 0,-1);
			$single_file_name=substr($single_file_name, 0,-1);
			$path_arr=explode(",", $single_file_path);
			$name_arr=explode(",", $single_file_name);
			foreach ($path_arr as $k=>$v)
			{
				$inset_data=array('line_id'=>$one['line_id'],'file'=>$v,'file_name'=>$name_arr[$k]);
				$this->b_single_file_model->insert($inset_data);
			}

		}
		//6、佣金表
		$this->load->model('admin/t33/sys/b_single_agent_model','b_single_agent_model');
		//if($item=="1") $type="2";else if($item=="2") $type="1";
		$agent_data=array(
					'type'=>'1',
					'object'=>$agent_object,
					'adult'=>$adult_agent,
					'child'=>$child_agent,
					'childnobed'=>$childnobed_agent,
					//'old'=>$old_agent
			);

		$this->b_single_agent_model->update($agent_data,array('line_id'=>$one['line_id']));
		//提交
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('已通过');
		}

	}
	/*
	 * 单项产品：下线
	 * */
	public function api_line_offline()
	{
		$line_id=$this->input->post("line_id");//
		if(empty($line_id))  $this->__errormsg('线路id不能为空');
		$status=$this->u_line_model->update(array('status'=>'3'),array('id'=>$line_id));
		if($status) $this->__data('已下线');
		else $this->__data('操作失败');
	}
	/*
	 * 单项产品：复制
	 * */
	public function api_single_copy()
	{
		$id=$this->input->post("id");//b_single_affiliated 表id
		if(empty($id))  $this->__errormsg('id不能为空');

	    $this->db->trans_begin();

	    $this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');
	    $this->load->model('admin/t33/sys/u_line_suit_price_model','u_line_suit_price_model');
	    $this->load->model('admin/t33/sys/u_line_suit_model','u_line_suit_model');
	    $one=$this->b_single_affiliated_model->row(array('id'=>$id));

		//1、线路表
		$addtime=date("Y-m-d H:i:s");
		$line_data=$this->u_line_model->row(array('id'=>$one['line_id']));
		$suit=$this->u_line_suit_price_model->row(array('lineid'=>$one['line_id']));
		unset($line_data['id']);
		$line_data['addtime']=$line_data['modtime']=$addtime;

		//单项编号
		if($line_data['line_classify']=="1")
			$type="A";
		else if($line_data['line_classify']=="2")
			$type="B";
		else if($line_data['line_classify']=="3")
			$type="C";


		$date=date("ymd",strtotime($suit['day'])); //将出台日期 转化为指定时间

		$union_id=$this->get_union();
		$supplier=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id,'supplier_id'=>$line_data['supplier_id']));

		$liushui=$this->b_company_supplier_model->row(array('union_id'=>$union_id,'supplier_id'=>$line_data['supplier_id']));
		$liushui_code="";
		if(!empty($liushui))
		{
			$liushui_code=$liushui['code']+1;
			if($liushui_code<1000)
				$liushui_code=sprintf("%03d", $liushui_code) ;
		}
		$code=isset($supplier['result'][0]['code'])==true?$supplier['result'][0]['code']:"";
		$linecode="FIT".$type."-".$date.$code.$liushui_code;
		$line_data['linecode']=$linecode;

		$line_id=$this->u_line_model->insert($line_data);  //线路id
		$this->b_company_supplier_model->update(array('code'=>$liushui_code),array('union_id'=>$union_id,'supplier_id'=>$line_data['supplier_id']));
		//2、出发城市
		$this->load->model('admin/t33/sys/u_line_startplace_model','u_line_startplace_model');
		$startplace_data=$this->u_line_startplace_model->row(array('line_id'=>$one['line_id']));
		unset($startplace_data['id']);
		$startplace_data['line_id']=$line_id;
		$this->u_line_startplace_model->insert($startplace_data);

		//2.2 目的地
		$this->load->model('admin/t33/sys/u_line_dest_model','u_line_dest_model');
		$dest_data=$this->u_line_dest_model->row(array('line_id'=>$one['line_id']));
		unset($dest_data['id']);
		$dest_data['line_id']=$line_id;
		$this->u_line_dest_model->insert($dest_data);
		//3、套餐
		$taocan=$this->u_line_suit_model->row(array('lineid'=>$one['line_id']));
		unset($taocan['id']);
		$taocan['lineid']=$line_id;
		$suit_id=$this->u_line_suit_model->insert($taocan);
		//3.2、套餐价格
		$suit_data=$this->u_line_suit_price_model->row(array('lineid'=>$one['line_id']));
		unset($suit_data['dayid']);
		$suit_data['lineid']=$line_id;
		$suit_data['suitid']=$suit_id;
		$suit_data['description']=$linecode; //团号
		$this->u_line_suit_price_model->insert($suit_data);

		//4、b_single_affiliated 单项表
		$single_data=$one;
		unset($single_data['id']);
		$single_data['line_id']=$line_id;
		$this->b_single_affiliated_model->insert($single_data);

		//5、行程文件
		$this->load->model('admin/t33/sys/b_single_file_model','b_single_file_model');
		$all=$this->b_single_file_model->all(array('line_id'=>$one['line_id']));
		if(!empty($all))
		{
			foreach ($all as $k=>$v)
			{
				unset($v['id']);
				$v['line_id']=$line_id;
				$this->b_single_file_model->insert($v);
			}
		}

		//6、佣金表
		$this->load->model('admin/t33/sys/b_single_agent_model','b_single_agent_model');
		$agent_data=$this->b_single_agent_model->row(array('line_id'=>$one['line_id']));
		unset($agent_data['id']);
		$agent_data['line_id']=$line_id;
		$this->b_single_agent_model->insert($agent_data);
		//提交
		if ($this->db->trans_status() === FALSE)
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
	/*
	 * 供应商详情
	 **/
	public function api_supplier()
	{
		$supplier_id=$this->input->post("supplier_id");
		if(empty($supplier_id)) $this->__errormsg('供应商id不能为空');
		$union_id=$this->get_union();
		$output=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		$liushui=$this->b_company_supplier_model->row(array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		if(!empty($liushui))
		{
			$liushui_code=$liushui['code']+1;
			if($liushui_code<1000)
				$liushui_code=sprintf("%03d", $liushui_code) ;
		}
		$output['result'][0]['liushui_code']=$liushui_code;
		$this->__data($output['result'][0]);
	}
	/**
	 * 服务类型管理
	 *
	 * */
	public function server_range()
	{
		$iframeid=$this->input->get("iframeid");
		$data['iframeid']=$iframeid;
		$this->load->view("admin/t33/line/server_range",$data);
	}
	/*
	* 服务类型管理:api
	*
	* */
	public function api_server_range()
	{
		$name=$this->input->post("name");

		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');

			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];

			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = 10;
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;

			//条件筛选
			$where['union_id']=$union_id;
			$where['status']='1';
			if(!empty($name))
				$where['server_name like']='%'.$name.'%';

			$result=$this->b_server_range_model->result($where,$page,$page_size,'showorder');
			$total_rows=$this->b_server_range_model->num_rows($where);
			$total_page=ceil ( $total_rows/$page_size );

			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,

					'result'=>$result
			);
			$this->__data($output);
		}
	}
	/*
	* 添加服务类型:api
	*
	* */
	public function api_add_server()
	{
		$server_name=$this->input->post("server_name");
		$showorder=$this->input->post("showorder");
		$remark=$this->input->post("remark");
		$user=$this->userinfo();
		if(empty($server_name)) $this->__errormsg('服务名称不能为空');
		if(empty($showorder))  $this->__errormsg('排序不能为空');
		$addtime=date("Y-m-d H:i:s");
		$data=array(
			'union_id'=>$user['union_id'],
			'employee_id'=>$user['id'],
			'server_name'=>$server_name,
			'description'=>$remark,
			'showorder'=>$showorder,
			'status'=>'1',
			'addtime'=>$addtime,
			'modtime'=>$addtime
		);
		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$status=$this->b_server_range_model->insert($data);
		if($status)  $this->__data('添加成功');
		else $this->__errormsg('操作失败');
	}
	/*
	 * 添加服务类型:api
	*
	* */
	public function api_del_server()
	{
		$id=$this->input->post("id");
		if(empty($id)) $this->__errormsg('id不能为空');
		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$status=$this->b_server_range_model->update(array('status'=>'2','modtime'=>date("Y-m-d H:i:s")),array('id'=>$id));
		if($status)  $this->__data('已删除');
		else $this->__errormsg('操作失败');
	}

	public function show_travel(){
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$line_id=$this->input->get("line_id",true);
		$return = $this ->u_line_model ->line_trip($line_id);
		$data['list'] = $return['result'];
		$data['line_row'] = $this ->u_line_model ->row(array('id'=>$line_id));
		//var_dump($data['line_row']);exit();
		$this->load->view("admin/b2/show_travel_view",$data);
	}
	/*
	 * 工具： 补填suitid
	 * 对象：将没有u_line_suit套餐的单项产品  
	 * 操作：1、添加条u_line_suit记录、
	 *     2、更改u_line_suit_price表suitid、
	 *     3、更改u_member_order表的suitid   
	 * */
	public function update_suit(){
		$this->load->model('admin/t33/sys/u_line_suit_price_model','u_line_suit_price_model');
	    $this->load->model('admin/t33/sys/u_line_suit_model','u_line_suit_model');
	    $sql="SELECT l.*,lsp.suitid from u_line as l left join u_line_suit_price as lsp on lsp.lineid=l.id where line_kind=2 and lsp.suitid=0";
	    $line=$this->db->query($sql)->result_array();
	    $this->db->trans_begin();
	    foreach ($line as $key=>$value)
	    {
	    	
	    	$exist=$this->u_line_suit_model->row(array('lineid'=>$value['id']));
	    	if(empty($exist))
	    	{
	    		//echo $value['id']."<br />";
	    		$insert_data=array('lineid'=>$value['id'],'suitname'=>'标准价');
	    		$suitid=$this->u_line_suit_model->insert($insert_data);
	    		
	    		$this->u_line_suit_price_model->update(array('suitid'=>$suitid),array('lineid'=>$value['id']));
	    		
	    		$this->load->model('admin/t33/u_member_order_model','u_member_order_model');
	    		$order_row=$this->u_member_order_model->all(array('productautoid'=>$value['id']));
	    		if(!empty($order_row))
	    		{
	    			foreach ($order_row as $m=>$n)
	    			{
	    				$this->u_member_order_model->update(array('suitid'=>$suitid),array('id'=>$n['id']));
	    			}
	    		}
	    	}
	    	echo $value['id'];
	    }
	    if ($this->db->trans_status() === FALSE)
	    {
	    	$this->db->trans_rollback();
	    	$this->__errormsg('操作失败');
	    }
	    else
	    {
	    	$this->db->trans_commit();
	    	$this->__data('操作成功');
	    }
	    
	}	

}

/* End of file login.php */
