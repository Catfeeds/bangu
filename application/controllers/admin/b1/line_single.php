<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2016-10-30
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_single extends UB1_Controller {
	function __construct() {
	
		parent::__construct ();

		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
			'form', 
			'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/line_single_model',"u_line_model" );

		$this->load->model('admin/t33/u_line_model','u_line');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');

		header ( "content-type:text/html;charset=utf-8" );
				
	}
	public function index(){

		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view("admin/b1/line/line_single");
		$this->load->view ( 'admin/b1/footer.html' );
	}
	/**
	 * 单项产品：接口
	 * */
	public function api_single()
	{
		$type=trim($this->input->post("type",true)); //
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
	/*	if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{*/
			$supplier = $this->getLoginSupplier();
			$union=$this->u_line_model->get_company_supplier($supplier['id']);
			
			if(empty($union['union_id'])){
				$union_id=0;
			}else{
				$union_id=$union['union_id'];	
			}
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
			/*$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];*/
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = sys_constant::B_PAGE_SIZE;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);	
			$supplier = $this->getLoginSupplier();
			$where['type']=$type;
			$where['supplier_id']=$supplier['id'];
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
			//echo $this->db->last_query();
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );
	
			if(empty($result)){
				$output= json_encode ( array (
					'code' =>"4001",
					'msg' =>"data empty",
					"data" => array(),
				) );
				echo  $output;exit;
			}  
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql'=>$return['sql'],
					'result'=>$result
			);
		//	$this->__data($output);
			$output= json_encode ( array (
				"code" => 2000,
				"msg" => '请求成功',
				"data" => $output,
			) );
			echo $output;
		//}			
	}

	/**
	 * 单项产品
	 * 
	 * */
	public function add_single()
	{

		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		// echo $this->db->last_query();
		if(!empty($union['union_id'])){
			$union_id=$union['union_id'];	
		}else{
			$union_id=0;	
		}
		
		//$expert_list=$this->u_expert_model->union_expert($union_id);
		//echo $this->db->last_query();
		$expert_list=$this->u_expert_model->supplier_union_expert($supplier['id']);

		$data['expert_list']=$expert_list;

        //服务类型
		$data['server_list']=$this->u_expert_model->get_server_range($supplier['id']);

		/*$data['supplier']=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id));
		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$data['server_list']=$this->b_server_range_model->all(array('union_id'=>$union_id,'status'=>'1'));*/


		$data['m_date']=date("ymd");
		$data['supplier_id']=$supplier['id'];
		$this->load->view("admin/b1/line/add_single",$data);
	}

	/* 
	 * 供应商详情
	 **/
	public function api_supplier()
	{
		$supplier_id=$this->input->post("supplier_id");
		if(empty($supplier_id)){
			//$this->__errormsg('供应商id不能为空');
			$output= json_encode ( array (
				'code' =>"4001",
				'msg' =>"供应商id不能为空",
				"data" => array(),
			) );
			echo  $output;exit;	
		} 
		//$union_id=$this->get_union();
		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		$union_id=$union['union_id'];	

		$output=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		$liushui=$this->b_company_supplier_model->row(array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		if(!empty($liushui))
		{
			$liushui_code=$liushui['code']+1;
			if($liushui_code<1000)
		    $liushui_code=sprintf("%03d", $liushui_code) ;
		}
		$output['result'][0]['liushui_code']=$liushui_code;

		//$this->__data($output['result'][0]);
		$output= json_encode ( array (
				"code" => 2000,
				"msg" => '请求成功',
				"data" => $output['result'][0],
			) );
		echo $output;
	}
	/* 
	 * 接口: 添加单项
	 * 1、单项编号生成规则：   
	 *  如：  AFIT-160929nyfq001   
	 *  第一个A：（出境A、国内B、省内周边C） ；
	 *  FIT固定要加；
	 *  160929 年月日 ； 
	 *  nyfq 供应商代码； 
	 *  001 旅行社对应供应商流水号
	 * */
	public function api_add_single()
	{
		$dest_id=$this->input->post("dest_id");
		$startplace=$this->input->post("startplace");
		$linecode=$this->input->post("linecode");
		$linename=$this->input->post("linename");
		$server_range=$this->input->post("server_range");
		$sell_object=$this->input->post("sell_object");
		$sell_object_id=$this->input->post("sell_object_id");
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

		if($linecode=='AFIT-' || $linecode=='BFIT-' || $linecode=='CFIT-' ){
			if(empty($linecode)) $this->__errormsg('单项编号出错,请重新选择出团时间');
		}
    
		if(empty($sell_object)) $this->__errormsg('销售对象不能为空!');
		if(empty($object_name)){ $this->__errormsg('请选择列表下的销售对象或公司!'); }
		
		//if(empty($dest_id)) $this->__errormsg('目的地不能为空');
		if(empty($startplace)) $this->__errormsg('出发地不能为空');
		if(empty($linecode)) $this->__errormsg('单项编号不能为空');
		if(empty($linename)) $this->__errormsg('单项名称不能为空');
		
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

		if(empty($adultprice)) $this->__errormsg('成人销售价不能为空');
		//if(empty($agent_object)) $this->__errormsg('佣金收取对象不能为空');
	
		if(intval($adultjs)>intval($adultprice)){
		    $this->__errormsg('成人结算价不能大于销售价');
		}
		if(intval($childjs)>intval($childprice)){
		    $this->__errormsg('儿童占床价结算价不能大于销售价');
		}
		if(intval($childnobedjs)>intval($childnobedprice)){
		    $this->__errormsg('儿童不占床价结算价不能大于销售价');
		}
		//var_dump($linename);exit;
		$this->db->trans_begin();
		//1、线路表
		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		$supplier_id=$supplier['id'];
		$union_id=$union['union_id'];

		$addtime=date("Y-m-d H:i:s");
		$overcity=$line_classify;
		if($overcity=="3")
			$overcity="2";
		$line_data=array(
			'producttype'=>'0',
			'linename'=>$linename,
			'linecode'=>$linecode,
			'overcity'=>$line_classify,
			'overcity2'=>$line_classify,
			'book_notice'=>$book_notice,
			'addtime'=>$addtime,
			'modtime'=>$addtime,
			'supplier_id'=>$supplier_id,
			'status'=>'2',
			'linetitle'=>$linename,
			'online_time'=>$addtime,
			'line_classify'=>$line_classify,
			'line_kind'=>'3' //供应商单项
		);

		$line_id=$this->u_line->insert($line_data);  //线路id
		$exist=$this->b_company_supplier_model->row(array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		

		if($exist['code']<$liushui_code)
		$this->b_company_supplier_model->update(array('code'=>$liushui_code),array('union_id'=>$union_id,'supplier_id'=>$supplier_id));
		else $this->__errormsg('单项编号已被占用，请重新选择供应商');

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

		$this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');
		
		if($sell_object=='-1'){
			$union_id=$sell_object_id;	
		}
		$single_data=array(
				'union_id'=>$union_id,
				'line_id'=>$line_id,
				'server_range'=>$server_range,
				'sell_object'=>$sell_object,
				'object_name'=>$object_name,
				'employee_id'=>$supplier_id,
				'employee_name'=>$supplier['login_realname'],
		);
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
/*		$this->load->model('admin/t33/sys/b_single_agent_model','b_single_agent_model');
		if($item=="1") $type="2";else if($item=="2") $type="1";
		$agent_data=array(
			'line_id'=>$line_id,
			'type'=>$type,
			'object'=>$agent_object,
			'agent_rate'=>$agent_rate,
			'adult'=>$adult_agent,
			'child'=>$child_agent,
			'childnobed'=>$childnobed_agent,
			'old'=>$old_agent
		);
		$this->b_single_agent_model->insert($agent_data);*/
		//提交
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			//$this->__data('已通过');
			$output= json_encode ( array (
				"code" => 2000,
				"msg" => '已通过',
				"data" => array(),
			) );
			echo $output;
		}
		
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
	 * 单项产品:修改
	 *
	 * */
	public function update_single()
	{
		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		$union_id=$union['union_id'];	

		$id=$this->input->get("id");  //b_single_affiliated 表id
		$this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');
		$row=$this->u_line_model->single_detail($id);
		//echo $this->db->last_query();
		$data['row']=$row; //单项详情
	
		$this->load->model('admin/t33/sys/b_single_file_model','b_single_file_model');//行程文件
		$data['files']=$this->b_single_file_model->all(array('line_id'=>$row['line_id']),"id desc");
	
		//$union_id=$this->get_union();

		//$expert_list=$this->u_expert_model->union_expert($union_id);
		$expert_list=$this->u_expert_model->supplier_union_expert($supplier['id']);
		$data['expert_list']=$expert_list;
		$data['supplier']=$this->b_company_supplier_model->get_supplier(array('union_id'=>$union_id));
	
/*		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$data['server_list']=$this->b_server_range_model->all(array('union_id'=>$union_id,'status'=>'1'));*/
		 //服务类型
		$data['server_list']=$this->u_expert_model->get_server_range($supplier['id']);

		$data['m_date']=date("ymd");
	
		$this->load->view("admin/b1/line/edit_single",$data);
	}

	/*
	* 接口: 修改单项
	* 1、单项编号生成规则：
	* 如：  AFIT-160929nyfq001
	* 第一个A：（出境A、国内B、省内周边C） ；
	* FIT固定要加；
	* 160929 年月日 ；
	* nyfq 供应商代码；
	* 001 旅行社对应供应商流水号
	* */
	public function api_update_single()
	{
		$id=$this->input->post("id");//b_single_affiliated 表id
		$dest_id=$this->input->post("dest_id");
		$startplace=$this->input->post("startplace");
		$linecode=$this->input->post("linecode");
		$linename=$this->input->post("linename");
		$server_range=$this->input->post("server_range");
		$sell_object=$this->input->post("sell_object");
		$sell_object_id=$this->input->post("sell_object_id");

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
	
		if($linecode=='AFIT-' || $linecode=='BFIT-' || $linecode=='CFIT-' ){
			if(empty($linecode)) $this->__errormsg('单项编号出错,请重新选择出团时间');
		}
		//$line_classify=$this->input->post("line_classify");
		$object_name=$this->input->post("object_name");
		if(empty($sell_object)) $this->__errormsg('销售对象不能为空!');
		if(empty($object_name)){ $this->__errormsg('请选择列表下的销售对象或公司!'); }
		//if(empty($dest_id)) $this->__errormsg('目的地不能为空');
		if(empty($startplace)) $this->__errormsg('出发地不能为空');
		if(empty($linecode)) $this->__errormsg('单项编号不能为空');
		if(empty($linename)) $this->__errormsg('单项名称不能为空');
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
		
		if(empty($adultprice)) $this->__errormsg('成人销售价不能为空');
		if(intval($adultjs)>intval($adultprice)){
		    $this->__errormsg('成人结算价不能大于销售价');
		}
		
		if(intval($childjs)>intval($childprice)){
		    $this->__errormsg('儿童占床价结算价不能大于销售价');
		}
		if(intval($childnobedjs)>intval($childnobedprice)){
		    $this->__errormsg('儿童不占床价结算价不能大于销售价');
		}
	
		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		$supplier_id=$supplier['id'];
		$union_id=$union['union_id'];


		$this->db->trans_begin();
		//1、b_single_affiliated 单项表
		//$user=$this->userinfo();
		$this->load->model('admin/t33/sys/b_single_affiliated_model','b_single_affiliated_model');
		$one=$this->b_single_affiliated_model->row(array('id'=>$id));
		$line=$this->u_line->row(array('id'=>$one['line_id']));
		$line_classify=isset($line['line_classify'])==true?$line['line_classify']:'';
		
		if($sell_object=='-1'){
			$union_id=$sell_object_id;	
		}

		$single_data=array('union_id'=>$union_id,'server_range'=>$server_range,'sell_object'=>$sell_object,'object_name'=>$object_name);
		$this->b_single_affiliated_model->update($single_data,array('id'=>$id));
		//echo $this->db->last_query();
		//2、线路表
		$addtime=date("Y-m-d H:i:s");
		$line_data=array(
				'linename'=>$linename,
				'linecode'=>$linecode,
				'overcity'=>$line_classify,
				'overcity2'=>$line_classify,
				'book_notice'=>$book_notice,
				'modtime'=>$addtime,
				'linetitle'=>$linename,
				'status'=>2,
		);
		$line_id=$this->u_line->update($line_data,array('id'=>$one['line_id']));  //线路id
		//2、出发城市
		$this->load->model('admin/t33/sys/u_line_startplace_model','u_line_startplace_model');
		$this->u_line_startplace_model->update(array('startplace_id'=>$startplace),array('line_id'=>$one['line_id']));
		//22、目的地城市
		$this->load->model('admin/t33/sys/u_line_dest_model','u_line_dest_model');
		$this->u_line_dest_model->update(array('dest_id'=>$line_classify),array('line_id'=>$one['line_id']));
		//3、套餐
		$suit_data=array(
				'day'=>$day,
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

		//提交
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			//$this->__data('已通过');

			$this->db->trans_commit();
			//$this->__data('已通过');
			$output= json_encode ( array (
				"code" => 2000,
				"msg" => '已通过',
				"data" => array(),
			) );
			echo $output;

		}
	
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
		$line_data=$this->u_line->row(array('id'=>$one['line_id']));
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
		
		//$union_id=$this->get_union();
		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		$supplier_id=$supplier['id'];
		$union_id=$union['union_id'];

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
		
		$line_id=$this->u_line->insert($line_data);  //线路id
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
			//$this->__data('已复制');
			$output= json_encode ( array (
				"code" => 2000,
				"msg" => '已复制',
				"data" => array(),
			) );
			echo $output;
		}
		
	}

		/*
	 * 单项产品：下线
	 * */
	public function api_line_offline()
	{
		$line_id=$this->input->post("line_id");//
		if(empty($line_id))  $this->__errormsg('线路id不能为空');
		$status=$this->u_line->update(array('status'=>'3'),array('id'=>$line_id));
		if($status){
			$output= json_encode ( array (
				"code" => 2000,
				"msg" => '已下线',
				"data" => array(),
			) );
			echo $output;
		} 
		else{
			$output= json_encode ( array (
				"code" => 2000,
				"msg" => '操作失败',
				"data" => array(),
			) );
			echo $output;

		} //$this->__data('操作失败');
		
	}

/**
	 * 文件上传
	 * */
	public function upload_file()
	{
		$inputname=$this->input->post("inputname",true); //file文本域的name属性值
	
		$typeArr = array("jpg", "jpeg","png", "gif");//允许上传文件格式
		$time = date('Ymd',time());
	
		$path ="./file/t33/".$time."/"; //上传路径
		$return="/file/t33/".$time."/"; //返回的路径
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
				$this->__errormsg('您还未选择文件');
			$type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
			
			$pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
			$pic_url = $path . $pic_name;//上传后图片路径+名称
			$return_url=$return.$pic_name;
	
			if (move_uploaded_file($name_tmp, $pic_url))
			{    //临时文件转移到目标文件夹
				echo json_encode(array("code"=>"2000","msg"=>"success","imgurl"=>$return_url,"filename"=>$name));
					
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

	/**
	 * 服务类型管理
	 *
	 * */
	public function server_range()
	{
		$iframeid=$this->input->get("iframeid");
		$data['iframeid']=$iframeid;

		$this->load->view("admin/b1/line/server_range",$data);
	}

		/*
	* 服务类型管理:api
	*
	* */
	public function api_server_range()
	{
		$name=$this->input->post("name");

	/*	$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{*/
			$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
			
			//$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			//$union_id=$employee['union_id'];

			$supplier = $this->getLoginSupplier();
			$union=$this->u_line_model->get_company_supplier($supplier['id']);
			$union_id=$union['union_id'];	

		
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
		
			if(empty($result)){
				$output= json_encode ( array (
					"code" => 2000,
					"msg" => '操作失败',
					"data" => $result,
				) );
				echo $output;exit;
			}  
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'result'=>$result
			);
			$outdata= json_encode ( array (
					"code" => 2000,
					"msg" => '获取数据成功',
					"data" => $output,
			) );
			echo $outdata;
			//$this->__data($output);
		//}
	}
		/*
	 * 添加服务类型:api
	*
	* */
	public function api_del_server()
	{
		$id=$this->input->post("id");
		//if(empty($id)) $this->__errormsg('id不能为空');
		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$status=$this->b_server_range_model->update(array('status'=>'2','modtime'=>date("Y-m-d H:i:s")),array('id'=>$id));
		if($status){
			$outdata= json_encode ( array (
					"code" => 2000,
					"msg" => '已删除',
					"data" => array(),
			) );
			echo $outdata;
		} 
		// $this->__data('已删除');
		else $this->__errormsg('操作失败');
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
		$supplier = $this->getLoginSupplier();
		$union=$this->u_line_model->get_company_supplier($supplier['id']);
		$union_id=$union['union_id'];	
		//$user=$this->userinfo();
		if(empty($server_name)) $this->__errormsg('服务名称不能为空');
		if(empty($showorder))  $this->__errormsg('排序不能为空');
		$addtime=date("Y-m-d H:i:s");
		$data=array(
			'union_id'=>$union_id,
			//'employee_id'=>$user['id'],
			'server_name'=>$server_name,
			'description'=>$remark,
			'showorder'=>$showorder,
			'status'=>'1',
			'addtime'=>$addtime,
			'modtime'=>$addtime
		);
		$this->load->model('admin/t33/sys/b_server_range_model','b_server_range_model');
		$status=$this->b_server_range_model->insert($data);
		if($status){
			$outdata= json_encode ( array (
					"code" => 2000,
					"msg" => '添加成功',
					"data" => array(),
			) );
			echo $outdata;

		} 
		// $this->__data('添加成功');
		else $this->__errormsg('操作失败');
	}


		/**
	 * 数型数据:营业部
	 * */
/*	public function api_depart_list()
	{
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$result=$this->b_depart_model->all_depart(array('union_id'=>$union_id));
		$this->__data($result);
	}*/
	
		/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function __data($reDataArr,$common=array()) {
		$len="1";
		if(empty($reDataArr))
		{
			$code="4001";
			$msg="data empty";
			$data=array();
		}
		else
		{
			if(is_array($reDataArr))
				$len=count($reDataArr);
	
			$reDataArr = strip_slashes ( $reDataArr );
			$data=$reDataArr;
			$code="2000";
			$msg="success";
		}
	
		$output= json_encode ( array (
				"code" => $code,
				"msg" => $msg,
				"data" => $data,
				"total" => $len,
				'common'=>$common
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	
		echo $output;
		exit ();
	}

	/**
	 * 数型数据:出发地
	 * */
	public function api_tree_startplace()
	{
	
		$this->load->model('admin/t33/common_model','common_model');
		$result=$this->common_model->tree_startplaceData(array('level'=>'3'));
		$outdata= json_encode ( array (
				"code" => 2000,
				"msg" => '添加成功',
				"data" => $result,
		) );
		echo $outdata;
	}
}