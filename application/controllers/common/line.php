<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		贾开荣
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line extends MY_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/b1/user_shop_model' );
	}

	function show_line_detail(){
		$lineId= $this->get('id');
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
		$data['suits'] =$this->user_shop_model->getLineSuit($lineId);
	
		//获取线路的目的地
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] =$this->user_shop_model->getDestinationsData($lineId);
			//$data['overcity2_arr'] = $this->getDestinationsID(explode(',', $data['data']['overcity2']));
		}
	
		//线路的标签
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}
	
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
		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);
		//echo $this->db->last_query();
		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$data['data']['supplier_id']));
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));

	
		//主题游
		$data['theme']=$this->user_shop_model->get_user_shop_select('u_theme','');
		if(!empty($data['theme'])){
			$data['themeData']='';
			foreach ($data['theme'] as $k=>$v){
				if(empty($data['themeData'])){
					$data['themeData']=$v['id'];
				}else{
					$data['themeData'].=','.$v['id'];
				}
			}
		}
		$data['themeid']='';
		if(!empty($data['data']['themeid'])){   //被选中的主题游
			$data['themeid']=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$data['data']['themeid']));
		}
		//线路押金,团款
		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
	
		//指定营业部
		$data['package']=$this->user_shop_model->select_line_package($lineId);
	
		// 定制管家数据
		$data['expert']=$this->user_shop_model->get_group_expert($lineId);
	
		//上车地点
		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));
		 
		$data['line']=$data;
	
		$type=$this->get('type');
		if($type==1){
			$this->load->view ( 'common/line_detail_box' ,$data);
		}else if($type==2){
			$this->load->view ( 'common/line_detail' ,$data);
		}else if($type==3){
			$this->load->view ( 'common/sales_line_detail' ,$data);
		}else{
			$this->load->view ( 'common/line_detail' ,$data);
		}
	}

	//日历价格
	public function getProductPriceJSON(){
		$lineId = $this->get("lineId");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId);
		}
		echo $productPrice;
	}
	//促销价格数据
	function get_salesPrice(){
		$this->load->model ( 'admin/b1/sales_apply_model','sales_apply_model');
		$lineId = $this->get("lineId");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->sales_apply_model->getSalesPriceByLineId($lineId);
		}
		echo $productPrice;
	}
	
	public function getDestinationsID($ids = null){
		if(null!=$ids){
			$sql = 'SELECT id,kindname as name FROM u_dest_base WHERE id!=0  and level>2';
			$sql.=" AND id IN (";
			$i=0;
			foreach($ids as $v){
				if(!empty($v)){
					if($i>0){
						$sql.=',';
					}
					$sql.=$v;
					$i++;
				}
			}
			$sql.=" )";
			$query = $this->db->query($sql,$ids);
			$rows = $query->result_array();
		}
		return $rows;
	} 
	//促销线路线路
/* 	function show_sales_detail(){
		
	} */
}
