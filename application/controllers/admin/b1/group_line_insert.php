<?php
/**
 * *
 * *深圳海外国际旅行社
 * *艾瑞可
 *
 * 2015-4-1 下午3:40:15
 * 2015
 * UTF-8
 * **
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Group_line_insert extends UB1_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/user_shop_model');
		header ( "content-type:text/html;charset=utf-8" );
	}
	
	public function index() {
		
		$id=0;
		$type=$this->input->get('type',true); //线路类型
		if($type=='cjy'){
			$id=1;
		}elseif($type=='gny'){
			$id=2;
		}elseif($type=='zby'){
			$id=3;
		} 
		$data['line_type']=$id;

		$supplier = $this->getLoginSupplier();
		
		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));	
		//主题游
		$data['theme']=$this->user_shop_model->get_user_shop_select('u_theme','');
		if(!empty($data['theme'])){
			$data['themeData']='';
			foreach ($data['theme'] as $k=>$v){
				$data['themeData'].=$v['id'].',';
			}
			$data['themeData']=substr($data['themeData'],0,-1);
		}
		//管家数据
		$data['expert']=$this->user_shop_model->get_user_shop_select('u_expert',array('status'=>2));
		//默认前六张的图库
		$data['dest_pic']=$this->user_shop_model->get_picture_library(array('supplier_id'=>$supplier['id']),1);
		$data['dest_two']=$this->user_shop_model->get_dest_pic($supplier['id']);
	
	    $this->load->model ( 'admin/b1/line_single_model',"u_line_model" );
	    $union=$this->u_line_model->get_company_supplier($supplier['id']);
	    if(!empty($union['union_id'])){
	    	$data['union_id']=1;
	    }else{
	    	$data['union_id']=0;
	    }
	    
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/group_line_insert', $data );
		$this->load->view ( 'admin/b1/footer.html' ); 
	}
	//线路类型
	public function destination(){
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/group_insert_destination');
		$this->load->view ( 'admin/b1/footer.html' );
	}
	public function insert() {
		$expert_id=$this->input->post('expert_id',true);
		$b_expert_id=$this->input->post('b_expert_id',true);
		$departId=$this->input->post('departId',true);
		//var_dump($expert_id);exit;

		$supplier = $this->getLoginSupplier();
		// 基础信息
		$line_classify= $this->input->post ( 'line_classify' );//线路类型
		$linename = $this->input->post ( 'linename' );//线路名称
		$lineprename = $this->input->post ( 'lineprename' );//线路主名称
		$nickname = $this->input->post ( 'nickname' );//供应商方便自己识别的名字
		$linetitle = trim($this->input->post ( 'linetitle' ));
		$startcity = $this->input->post ( 'lineCityId' );
		
		$arr_city = $this->input->post ( 'overcity' );
		$overcity2 = $this->input->post ( 'overcitystr' );
		$overcity2= substr($overcity2,0,-1);

		$lineday = $this->input->post ( 'data_num' );
		$linenight = $this->input->post ( 'data_night' );
		$linenight=($linenight=='' ? '0':$linenight);
		$linebefore = $this->input->post ( 'data_before' );
		$features = $this->input->post ( 'name_list' );
		$expert=$this->input->post ( 'expertid',true );
		$theme=$this->input->post ( 'theme',true );
		if(empty($theme)){
		    $theme=0;
		}
		$confirm_time = $this->input->post ( 'confirm_time' );
		$first_pay_rate = $this->input->post ( 'first_pay_rate' );
		$first_pay_rate=$first_pay_rate/100;
		$final_pay_before = $this->input->post ( 'final_pay_before' );
		$line_pics_arr = $this->input->post ( 'line_imgss' );//图片
		$mainpic = $this->input->post('mainpic');//主图片
		$linebefore=$this->input->post('linebefore');
		$deposit=$this->input->post('deposit',true);
		$before_day=$this->input->post('before_day',true);
		$linedatehour=$this->input->post ( 'linedatehour' ,true);  //报名截止时
		$linedateminute=$this->input->post ( 'linedateminute',true );  //报名截止时
		$car_address=$this->input->post('car_addressArr',true);

		$this->db->trans_start();  //事务开始
		
		$company=$this->user_shop_model->get_user_shop_select('b_company_supplier',array('supplier_id'=>$supplier['id'],'status'=>1));
 	
    	if(!$expert_id && !$departId && !$b_expert_id){
    			echo  json_encode(array('status'=>-1,'msg'=>'请选择定制销售人员'));exit;
    	}	
	 		
		//供应商信息
		$supplierData=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));
		//线路名称
		if($linenight==''|| $linenight==0){
			$linename=$supplierData[0]['brand'].' · '.$lineprename.$lineday.'天游';
		}else{
			$linename=$supplierData[0]['brand'].' · '.$lineprename.$linenight.'晚'.$lineday.'天游';
		}
		
		//三级目的地的父类
		$overcitystr='';
		$overcity='';
		if(!empty($arr_city)){
			//$arr_city=explode(',',$overcity2);
			foreach ($arr_city as $k=>$v){
				$city_str=$this->user_shop_model->get_user_shop_select('u_dest_base',array('id'=>$v));
				if(!empty($city_str[0]['list'])){
					$overcity=$overcity.$city_str[0]['list'].$v.',';
				}
				if(empty($overcitystr)){
					$overcitystr=$v;
				}else{
					$overcitystr=$overcitystr.','.$v;
				}
			}
		}
		$bourn=array();
		$overcityArr=array();
		if(!empty($overcity)){
			$overcityArr=explode(",",$overcity);
			$overcityArr=array_unique($overcityArr);
			$overcity=implode(',', $overcityArr);
			//二级目的地
			foreach ($overcityArr as $k=>$v){
				$dest_str=$this->user_shop_model->get_user_shop_select('u_dest_base',array('id'=>$v,'level'=>2));
				if(!empty($dest_str[0]['id'])){
					$bourn[]=$dest_str[0]['id'];
				}
			}
		}
		if(empty($overcity)){
			echo  json_encode(array('status'=>-1,'msg'=>'请重新选择一下目的地！'));exit;
		}
		$data = array(
			'line_classify'=>$line_classify,
			'linename' =>$this->filter_str($linename),
			'lineprename' => $this->filter_str($lineprename),
			'nickname' => $this->filter_str($nickname),
			'linetitle' => $this->filter_str($linetitle),
			'overcity' => $overcity,
			'overcity2' => $overcitystr,
			'lineday' => $lineday,
			'linenight' => $linenight,
			'linebefore' => $linebefore,
			'features' => $features,
			'status' => 0,
			'admin_id' => 0,
			'supplier_id' =>$supplier['id'],
			'first_pay_rate' =>$first_pay_rate,
			'final_pay_before' => '0',
			'addtime'=>date("Y-m-d H:i:s",time()),
			'modtime'=>date("Y-m-d H:i:s",time()),
			'mainpic'=>$mainpic,
			'producttype' => 1,
			'confirm_time'=>$confirm_time,
			'themeid'=>$theme,
			'ordertime'=>date("Y-m-d H:i:s",time()),
			'linebefore'=>$linebefore
		);
		//线路押金,团款
		$LineAff=array('deposit'=>$deposit,'before_day'=>$before_day,'hour'=>$linedatehour,'minute'=>$linedateminute);
		$this->checkLineData($data,$startcity,$expert); //验证线路信息
		    
	   	 //保存线路
		$lineId=$this->user_shop_model->save_linedata($supplier['id'],$data,$startcity,$line_pics_arr,$overcityArr,$LineAff);
		if($lineId==0){
			echo  json_encode(array('status'=>-1,'msg'=>'添加失败！'));exit;
		}
		//联盟审核线路表
		$union = $this->db->query("select union_id from b_company_supplier where supplier_id={$supplier['id']} and status=1")->result_array();
		if(!empty($union)){
			foreach ($union as $key => $value) {
				$insert=array(
						'status'=>0,
						'union_id'=>$value['union_id'],
						'supplier_id'=>$supplier['id'],
						'line_id'=>$lineId,
						'addtime'=>date("Y-m-d H:i:s",time()),
				);
				$this->user_shop_model->insert_data('b_union_approve_line',$insert);
			}
		}
	     
		//联盟管家
		if(!empty($expert_id)){
			foreach ($expert_id as $key =>$value) {
				$u_expertArr=array(
					'line_id'=>$lineId,
					'depart_id'=>$departId[$key],
					'expert_id'=>$value,
					'addtime'=>date("Y-m-d H:i:s",time()),
				);
				$this->user_shop_model->insert_data('u_line_package',$u_expertArr);
				//echo $this->db->last_query();
			}
		}
				
		//帮游管家
		if($b_expert_id>0){
			$expertArr=array(
					'grade'=>1,
					'line_id'=>$lineId,
					'expert_id'=>$b_expert_id,
					'status'=>2,
					'addtime'=>date("Y-m-d H:i:s",time()),
			);
			$this->user_shop_model->insert_data('u_line_apply',$expertArr);
		}
		//添加上车地点	
		if(!empty($car_address)){
			foreach($car_address as $key => $value) {
				$carArr=array(
					'line_id'=>$lineId,
					'on_car'=>$value
				);
				$this->user_shop_model->insert_data('u_line_on_car',$carArr);
			}
		}

		//产生线路编号
		$this->user_shop_model->grouplinecodeupdate($lineId);
		
		//保存二级目的地的线路图片库
		if(!empty($bourn)){
			$bourntwo=array_unique($bourn);
			if(!empty($line_pics_arr)){
				$repic=$this->user_shop_model->insert_pic_library($bourntwo,$line_pics_arr,$supplier['id']);
			}
		}
        
		//事务处理
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo  json_encode(array('status'=>-1,'msg'=>'添加失败！'));
		
		}else{
			if($lineId>0){
				echo  json_encode(array('status'=>1,'msg'=>'添加成功','line_id'=>$lineId));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'添加失败！'));
			}
		}
		

	}
	//验证提交线路的基本信息
	function checkLineData($data,$startcity){
		if($data){
			if(empty($data['linename'])){
				echo  json_encode(array('status'=>-1,'msg'=>'线路名称不能为空'));
				exit;
			}
			if(empty($data['overcity2'])){
				echo  json_encode(array('status'=>-1,'msg'=>'线路目的地不能为空'));
				exit;
			}
			if(empty($data['mainpic'])){
				echo  json_encode(array('status'=>-1,'msg'=>'线路主图片不能为空'));
				exit;
			}
			if(empty($data['features'])){
				echo  json_encode(array('status'=>-1,'msg'=>'线路特色不能为空'));
				exit;
			}
		}
		if(empty($startcity)){
			if(empty($startcity)){
				echo  json_encode(array('status'=>-1,'msg'=>'出发城市不能空！'));
				exit;
			}
		}
/*		if(empty($expert)){
			if(empty($expert)){
				echo  json_encode(array('status'=>-1,'msg'=>'定制管家不能为空！'));
				exit;
			}
		}*/
	}
	//添加产品页面
	public function toLineAdd(){
		$lineId= $this->get('id');
		$supplier = $this->getLoginSupplier();
		//访问线路的权限
		if(is_numeric($lineId)){
			$res=$this->user_shop_model->select_rowData('u_line',array('id'=>$lineId,'supplier_id'=>$supplier['id']));
			if(empty($res)){
				echo '<script>alert("您没有权限修改该线路");window.history.back(-1);</script>';exit;
			}
		}else{
			echo '<script>alert("不存在该线路");window.history.back(-1);</script>';exit;
		}
		
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		
		//获取线路的出发地
		$citystr='';
		$cityArr=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineId));
		foreach ($cityArr as $k=>$v){
			if(!empty($v['startplace_id'])){
				$citystr=$citystr.$v['startplace_id'].',';
			}
		}
		$data['cityArr']=$cityArr;
		$data['citystr']=$citystr;
		
		//获取线路的出发地
		if($data['data']['startcity']>0){
			$startcity = $this->user_shop_model->get_user_shop_select ('u_startplace' ,array('id'=>$data['data']['startcity']));
			if(!empty($startcity[0])){
				$data['startcity']=$startcity[0];
			}else{
				$data['startcity']='';
			}
		}
	 
		//获取线路的目的地
		$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] = $this->user_shop_model->getDestinationsId(explode(",",$data['data']['overcity2']));
		}
	
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}

		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);
	
		//线路图片
		$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
		if(!empty($data['imgurl'])){
			$data['imgurl_str']='';
			foreach ($data['imgurl'] as $k=>$v){
				$data['imgurl_str']=$data['imgurl_str'].$v['filepath'].',';
			}
		}

		//线路属性
		$data['attr']='';
		$attr=$this->user_shop_model->select_attr_data(array('pid'=>0,'isopen'=>1));
		if(!empty($attr)){
			foreach ($attr as $k=>$v){ //二级
				$attr[$k]['str']='';
				$attr[$k]['two']=$this->user_shop_model->select_attr_data(array('pid'=>$v['id'],'isopen'=>1));
				foreach ($attr[$k]['two'] as $key=>$val){
					$attr[$k]['str'].=$val['id'].',';
				}
			}
			$data['attr']=$attr;
		}
		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
		//选保险
		$data['insurance_id']=$this->user_shop_model->get_user_shop_select('u_line_insurance',array('line_id'=>$lineId,'status'=>1));
		$data['insurance']=$this->user_shop_model->sel_line_insurance($lineId,array('supplier_id'=>$supplier['id'],'status'=>1));
		//主题游
		$data['theme']=$this->user_shop_model->get_user_shop_select('u_theme','');
		if(!empty($data['theme'])){
			$data['themeData']='';
			foreach ($data['theme'] as $k=>$v){
				$data['themeData'].=$v['id'].',';
			}
			$data['themeData']=substr($data['themeData'],0,-1);
		}
		$data['themeid']='';
		if(!empty($data['data']['themeid'])){
			$data['themeid']=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$data['data']['themeid']));
		}
		//礼品管理
		$data['gift']=$this->user_shop_model->get_gift_data($lineId);
		
		// 管家数据
		$data['expert']=$this->user_shop_model->get_group_expert($lineId);
	//	echo $this->db->last_query();
	/* 	$data['expertId']=$this->user_shop_model->get_user_shop_select('u_expert_upgrade',array('line_id'=>$lineId));
		$data['expert']=$this->user_shop_model->get_user_shop_select('u_expert',array('status'=>2)); */

		//默认前六张的图库
		$data['dest_pic']=$this->user_shop_model->get_picture_library(array('supplier_id'=>$supplier['id']),1);
		$data['dest_two']=$this->user_shop_model->get_dest_pic($supplier['id']);
		
		//线路类型
        		$line_overcity=explode(',', $data['data']['overcity']);
		if(in_array("1", $line_overcity)){ 
			$data['line_type']=1;
		}else{
			$data['line_type']=2;
		} 

		//线路景点
   		$data['spot']=$this->user_shop_model->select_line_spot($lineId);
   		$data['spotid']='';
   		if(!empty($data['spot'])){
   			foreach ($data['spot'] as $key => $value) {
   			        	if($data['spotid']==''){
                             			$data['spotid']=$value['spot_id'];
   			        	}else{
					$data['spotid'].=$data['spotid'].','.$value['spot_id'];
   			        	}	
   			}
   		}
		//线路押金,团款
   		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
   		//附件	
   		$data['protocol']=$this->user_shop_model->select_data('u_line_protocol',array('line_id'=>$lineId));
   		
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/group_line_add', $data );
		$this->load->view ( 'admin/b1/footer.html' );			
	}

	
	//获取市
	function get_area(){
		$id=$this->input->post('id');
		$city = $this->user_shop_model->get_user_shop_select ( 'u_startplace' ,array('pid'=>$id)); // 始发地
		echo json_encode($city);
	}
}
