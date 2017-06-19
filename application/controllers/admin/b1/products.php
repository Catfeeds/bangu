<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends UB1_Controller {

	function __construct(){
		// $this->need_login = true;
		parent::__construct ();
		// $this->load->helper("url");
		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/user_shop_model' );
		header ( "content-type:text/html;charset=utf-8" );
			
}
	//产品汇总
	function product_list(){
		$data['type']=$this->input->get('type');  
		$data['pageData'] = $this->user_shop_model->get_product_list ( array('status'=>'0'),$this->getPage () );
		//echo $this->db->last_query();exit;
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/user_shop_list', $data );
		$this->load->view ( 'admin/b1/footer.html' );
	}
		//编辑线路
	public function toLineEdit() {	
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
		
		//获取套餐的信息
		//$data['suits'] =$this->user_shop_model->getLineSuit($lineId);
		//去掉复制的标识
		$linetitle=str_replace("— 复制","",$data['data']['linetitle']);
		$this->user_shop_model->update_rowdata('u_line',array('linetitle'=>$linetitle),array('id'=>$lineId));
		
		//获取线路的出发城市
		$data['startcity']='';
		if(!empty($data['data']['startcity'])){
			if($data['data']['startcity']>0){
				$startcity = $this->user_shop_model->get_user_shop_select ('u_startplace' ,array('id'=>$data['data']['startcity']));
				if(!empty($startcity[0])){
					$data['startcity']=$startcity[0];
				}else{
					$data['startcity']='';
				}				
			}
		}	
		
		//获取线路的目的地
		$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );	
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] = $this->user_shop_model->get_lineDestData(explode(",",$data['data']['overcity2']));
		
		}	
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}

		//行程安排
		//$data['rout']=$this->user_shop_model->getLineRout($lineId);
		
		//线路图片
		$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
		if(!empty($data['imgurl'])){
			$data['imgurl_str']='';
			foreach ($data['imgurl'] as $k=>$v){
				$data['imgurl_str']=$data['imgurl_str'].$v['filepath'].',';
			}
		}
		$data['imgurl_str']='';
		 	
		//线路属性
	/*	$data['attr']='';
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
		}*/
		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));
		//管家培训
	//	$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
		//选保险
		//$data['insurance_id']=$this->user_shop_model->get_user_shop_select('u_line_insurance',array('line_id'=>$lineId,'status'=>1));
	//	$data['insurance']=$this->user_shop_model->sel_line_insurance($lineId,array('supplier_id'=>$supplier['id'],'status'=>1));

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
		//判断是否是询价单转来的定制团 的管家佣金
		$this->load->model ( 'admin/b1/enquiry_model','enquiry' );
		$data['query'] = $this->enquiry->select_enquiry_data($lineId,$supplier['id']); 
			
        		// 管家数据
		$data['expert']=$this->user_shop_model->get_group_expert($lineId);
     		//   var_dump($data['expert']);
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
   	/*	$data['spot']=$this->user_shop_model->select_line_spot($lineId);
   		$data['spotid']='';
   		if(!empty($data['spot'])){
   			foreach ($data['spot'] as $key => $value) {
   			        	if($data['spotid']==''){
                             			$data['spotid']=$value['spot_id'];
   			        	}else{
					$data['spotid'].=$data['spotid'].','.$value['spot_id'];
   			        	}	
   			}
   		}*/
   		//线路押金,团款
   		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
   		//附件	
   		//$data['protocol']=$this->user_shop_model->select_data('u_line_protocol',array('line_id'=>$lineId));

   		//u_line_package
   		$data['package']=$this->user_shop_model->select_line_package($lineId);
   		
   		//上车地点
   		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));

   		$data['type']=$this->get('type');
		$style=$this->get('style');

   		if($style==1){
   			$this->load->view ( 'admin/b1/header.html' );
			$this->load->view ( 'admin/b1/line/group_line_edit', $data );
			$this->load->view ( 'admin/b1/footer.html' );
   		}else{
   			//编辑页面
			$this->load->view ( 'admin/b1/header.html' );
    			$this->load->view ( 'admin/b1/line/line_edit', $data );
    			$this->load->view ( 'admin/b1/footer.html' );
   		}
		

   		
	}
	//修改库存
	public function line_stock(){
	    $lineId= $this->get('id');
	    $data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
	    $data['user_shop'] = $this->user_shop_model->get_user_shop_select ( 'u_startplace' ); // 始发地
	    $data['suits'] = $this->user_shop_model->getLineSuit($lineId);
	    $this->load->view ( 'admin/b1/header.html' );
	    $this->load->view ( 'admin/b1/line_stock', $data );
	    $this->load->view ( 'admin/b1/footer.html' );
	}
	/*public function product_list(){
		$lineId= $this->get('id');
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		if(empty($data['data'])){
			$data['status']=2;  //判断是否存在产品的状态
			$this->load->view ( 'admin/b1/product_list', $data );
			$this->load->view ( 'admin/b1/footer.html' );
				
		}else{
		   	$data['status']=1; //判断是否存在产品的状态  1存在 2不存在
			$data['user_shop'] = $this->user_shop_model->get_user_shop_select ( 'u_startplace' ); // 始发地
			$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
			$this->load_model ( 'admin/a/destinations_model', 'destinations_model' );
			$data['line_attr'] = $this->lineattr_model->getLineattrTreeDate();
			$data['destinations'] = $this->destinations_model->getDestinationsTreeDate();
			//var_dump($data['data']);exit;
			$data['overcity_arr'] = array();
			if(""!=$data['data']['overcity']){
				$data['overcity_arr'] = $this->destinations_model->getDestinations(explode(",",$data['data']['overcity']));
			}
			$data['line_attr_arr'] = array();
			if(""!=$data['data']['linetype']){
				$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
			}
			
			$data['suits'] = $this->user_shop_model->getLineSuit($lineId);
			//行程安排
			$data['rout']=$this->user_shop_model->getLineRout($lineId);
			 
			//线路图片
			$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
			//交通方式
			$data['transport']=$this->user_shop_model->description_data('DICT_TRANSPORT');
			//星际酒店概述
			$data['hotel']=$this->user_shop_model->description_data('DICT_HOTEL_STAR');
	
		
			$this->load->view ( 'admin/b1/product_list', $data );
			$this->load->view ( 'admin/b1/footer.html' );
		}
		//echo $this->db->last_query();exit;
	}*/
	
}