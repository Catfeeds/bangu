<?php
/**
 * **
 * 深圳海外国际旅行社
 * 艾瑞可
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Sales_apply extends UB1_Controller {
	function __construct() {

		parent::__construct ();

		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		//$this->load->model ( 'admin/b1/user_shop_model' );
		$this->load->model ( 'admin/b1/sales_apply_model','sales_apply_model');
		header ( "content-type:text/html;charset=utf-8" );	
				
	}
	
	public function index() {
		
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param = array();
		$data['pageData'] = $this->sales_apply_model->get_line_sales($param,$this->getPage ());
		//echo $this->db->last_query();exit;
	    //促销类型
	    $data['sales_type']=$this->sales_apply_model->select_data('u_sales_type',array());
	     
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/sales/sales_apply_view', $data );
		$this->load->view ( 'admin/b1/footer.html' );
	}
	
	function indexData(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		
		$linecode=trim($this->input->post('linecode',true));
		$linename=trim($this->input->post('linename',true));
		$sales_name=trim($this->input->post('sales_name',true));

		$param=array();
		if(!empty($linecode)){
			$param['linecode']=$linecode;
		}
		if(!empty($linename)){
			$param['linename']=$linename;
		}
        if(!empty($sales_name)){
        	$param['sales_name']=$sales_name;
        }
	
		$data = $this->sales_apply_model->get_line_sales($param,$this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	//添加促销价
	function sales_apply_box(){
		$data=array();
		$this->load->view ( 'admin/b1/sales/sales_apply_box', $data );
	}
	
	//线路数据
	public function getLineJson()
	{
		$arr=$this->session->userdata ( 'loginSupplier' );
		$this ->load_model('admin/a/line_model' ,'line_model');
		$whereArr = array(
				'l.status =' =>2,
				's.status =' =>2,
				'l.producttype =' =>0,
				'l.line_kind =' => 1,
				'l.supplier_id =' =>$arr['id']
		);
		$destArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		$keyword = trim($this ->input ->post('keyword' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$themeId = intval($this ->input ->post('themeId'));
		$city_id = intval($this ->input ->post('city_id')); //配合周边游的始发地城市
		$dest_id = intval($this ->input ->post('dest_id'));
		if (!empty($keyword))
		{
			//$whereArr['s.company_name like'] = '%'.$keyword.'%';
			$whereArr['l.linename like'] = '%'.$keyword.'%';
		}
		if (!empty($city))
		{
			$whereArr['ls.startplace_id ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr['sp.pid ='] = $province;
		}
		if (!empty($themeId))
		{
			$whereArr['l.themeid ='] = $themeId;
		}
		if (!empty($dest_id))
		{
			if ($dest_id == 3 && $city_id > 0) //周边游
			{
				//获取城市的周边游目的地
				$this ->load_model('round_trip_model');
				$tripData = $this ->round_trip_model ->getRoundTripDest($city_id);
				if (empty($tripData))
				{
					$data = array(
							'list' =>''
					);
					echo json_encode($data);exit;
				}
				else
				{
					foreach($tripData as $val)
					{
						$destArr[] = $val['dest_id'];
					}
				}
			}
			else
			{
				$destArr = array($dest_id);
			}
		}
	
		$data['list'] = $this ->line_model ->getCfgB1LineData($whereArr ,$page_new ,9 ,$destArr);
	
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count ,9);
	
		foreach ($data['list'] as $k=>$v){
			$time=date("Y-m-d",time());
			$s_sql="SELECT adultprice from u_line_suit_price as ls where '{$time}'<day and lineid={$v['lineid']} and is_open=1 LIMIT 1";
			$lineprice=$this ->db ->query($s_sql) ->row_array();
			//echo $this->db->last_query();
			if(!empty($lineprice['adultprice'])){
				$data['list'][$k]['s_price']=$lineprice['adultprice'];
			}else{
				$data['list'][$k]['s_price']=0;
			}
		}
		echo json_encode($data);
	}
	
	//添加线路促销产品
	function add_line_sales(){
		$line_id=$this->input->post('line_id',true);
		//$typeId=$this->input->post('typeId',true);
		$sort=$this->input->post('sort',true);
		$lineName=$this->input->post('lineName',true);
		$salse_pic=$this->input->post('salse_pic',true);
		if(empty($line_id)){
			echo json_encode(array('stauts'=>-1,'msg'=>'请选择线路'));exit;
		}
		if(empty($salse_pic)){
			echo json_encode(array('stauts'=>-1,'msg'=>'请选择图片'));exit;
		}
	/* 	if(empty($typeId)){
			echo json_encode(array('stauts'=>-1,'msg'=>'请选择促销类型'));exit;
		} */
		
		$line=$this->db->select('*')->where(array('id'=>$line_id))->get('u_line')->row_array();
	//	$data['lineName']=$line['linename'];
		if(empty($line)){
			echo json_encode(array('stauts'=>-1,'msg'=>'请选择线路'));exit;
		}
		
		if(empty($lineName)){
			echo json_encode(array('stauts'=>-1,'msg'=>'促销标题不能为空'));exit;
		}
		//判断线路是否有选中
		$sel=$this->sales_apply_model->select_data('u_sales_line',array('lineId'=>$line_id));
		if(!empty($sel[0])){
			echo json_encode(array('stauts'=>-1,'msg'=>'该线路已是促销线路'));exit;
		}
		
		$data=array(
			'lineId'=>$line_id,
			'sort'=>100,
			'pic'=>$salse_pic,
			'lineName'=>$lineName,
		);
		$re = $this->sales_apply_model->add_linesales_Data($data);
		if($re){
			echo json_encode(array('stauts'=>1,'msg'=>'添加成功','data'=>array('lineId'=>$line_id,'linename'=>$line['linename'])));exit;
		}else{
			echo json_encode(array('stauts'=>-1,'msg'=>'添加失败'));exit;
		}
	}

	//编辑促销线路
	function edit_line_sales(){
 		$line_id=$this->input->post('edit_line_id',true);
		$sort=$this->input->post('edit_sort',true);
		$lineName=$this->input->post('edit_lineName',true);
		$salse_pic=$this->input->post('edit_salse_pic',true);
	/* 	if(empty($line_id)){
			echo json_encode(array('stauts'=>-1,'msg'=>'请选择线路'));exit;
		} */
		if(empty($salse_pic)){
			echo json_encode(array('stauts'=>-1,'msg'=>'请选择图片'));exit;
		}

		//判断线路是否有选中
	/* 	$sel=$this->sales_apply_model->select_data('u_sales_line',array('lineId'=>$line_id));
		if(!empty($sel[0])){
			echo json_encode(array('stauts'=>-1,'msg'=>'该线路已是促销线路'));exit;
		} */
		
		$data=array(
				'lineId'=>$line_id,
				'sort'=>100,
	     		'lineName'=>$lineName,
				'pic'=>$salse_pic
		);
		$re = $this->sales_apply_model->edit_linesales_Data($data);
		if($re){
			echo json_encode(array('stauts'=>1,'msg'=>'添加成功'));exit;
		}else{
			echo json_encode(array('stauts'=>-1,'msg'=>'添加失败'));exit;
		} 
	}
	//get_line_price获取线路价格
	function get_line_price(){
		  $lineId=$this->input->get('lineId',true);
		  $data['lineId']=$lineId;
		  if(!empty($lineId)){
		  	  //获取线路价格的原价
		  	$this->load->view ( 'admin/b1/sales/sales_price_box',$data );
		  }else{
		  	  echo '<script>alert("获取数据失败!");</script>';
		  }
	}
	//促销价格数据
	function get_salesPrice(){
		$this->load->model ( 'admin/b1/user_shop_model','user_shop_model');
		$lineId = $this->get("lineId");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->sales_apply_model->getSalesPriceByLineId($lineId);
		}
		echo $productPrice;
	}
	//保存价格套餐
	function saveSalesPrice(){
		$prices=$_POST['prices'];
		$suit_arr = json_decode($prices,true);
		
		$lineId = $this->get("lineId");
		$unit=$this->input->post('unit');		
		//保存促销价格套餐
		$re= $this->sales_apply_model->saveSalesLinePrice($suit_arr,$lineId);
		echo json_encode($re);
	}
	
	//上传促销图片
	function uploadImg(){

		$config['upload_path']="./file/b1/sales";//文件上传目录
		if(!file_exists("./file/b1/sales/")){
			mkdir("./file/b1/sales/",0777,true);//原图路径
		}
		if(!empty($_FILES['weixin_image']['name'])){
			if($_FILES['weixin_image']['error']==0){
				$pathinfo=pathinfo($_FILES["weixin_image"]['name']);
				$extension=$pathinfo['extension'];
				$file_url=$config['upload_path'].'/'.'sales_'.date("Ymd").time().".".$extension;
				$file_arr=array('gif','jpg','png','jpeg');
		
				if(!in_array($extension, $file_arr)){
					echo json_encode(array('code' => -1,'msg' =>'上传格式出错,请选择doc,docx格式的文件'));
					exit;
				}
				if(!move_uploaded_file ($_FILES['weixin_image']['tmp_name'], $file_url)){
					echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
					exit;
				}else{
					$linedoc=substr($file_url,1 );
					$linename=$_FILES['weixin_image']['name'];
					
 					//压缩图片
					$picSrc=$linedoc;
					$picName = substr($picSrc ,0 ,strrpos($picSrc ,'.')).'_thumb'.substr($picSrc, strrpos($picSrc ,'.'));
							
					$config['image_library'] = 'gd2';
					$config['source_image'] =dirname(BASEPATH).$picSrc;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']     = 452;
					$config['height']   = 280;
					
					$this->load->library('image_lib', $config);
					$status = $this->image_lib->resize(); 
					
					echo json_encode(array('code' =>200, 'msg' =>$picName));
				}				
				
			}else{
				echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
				exit;
			}
		}else{
			echo json_encode(array('code' => -1,'msg' =>'请选择文件'));
			exit;
		}
		
	}
	

	function get_sales_data(){
		$lineId=$this->input->post('lineId',true);
		if(!empty($lineId)){
			$data = $this->sales_apply_model->sel_sales(array('lineId'=>$lineId));
			if(!empty($data)){
				echo json_encode(array('status' => 1,'data' =>$data));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'获取数据失败'));
				exit;
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'获取数据失败'));
			exit;
		}
		
	}
	//取消促销线路
	function cancel_sales_data(){
		$lineId=$this->input->post('lineId',true);
		if(!empty($lineId)){
			$re=$this->sales_apply_model->dis_sales_line($lineId);
			if($re){
				echo json_encode(array('status' => 1,'msg' =>'操作成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg' =>'操作失败!'));exit;
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'操作失败!'));
			exit;
		}
		
	}
	////////-------------------------------用来添加促销线路关联的管家----------------------------------------------
    //添加大促产品关联管家
/*     function get_sales_expert(){
    	$expertArr[0]=array('name'=>'袁艳君','mobile'=>'13662671203');
    	$expertArr[1]=array('name'=>'董珂','mobile'=>'13823177350');
    	$expertArr[2]=array('name'=>'王晓明','mobile'=>'13823672101');
    	$expertArr[3]=array('name'=>'李洋','mobile'=>'15999672383');
    	$expertArr[4]=array('name'=>'曹甜','mobile'=>'13828876260');
    	$expertArr[5]=array('name'=>'梁杏花','mobile'=>'13924642766');
    	$expertArr[6]=array('name'=>'张平','mobile'=>'15820481054');
    	$expertArr[7]=array('name'=>'马成莹','mobile'=>'13028887375');
    	$expertArr[8]=array('name'=>'曾雪艺','mobile'=>'13632533419');
    	$expertArr[9]=array('name'=>'李凯丽','mobile'=>'13760474544');
    	$expertArr[10]=array('name'=>'郭丁莎','mobile'=>'13612981863');
    	$expertArr[11]=array('name'=>'高其宝','mobile'=>'18825253287');
    	$expertArr[12]=array('name'=>'刘结贤','mobile'=>'13431706062');
    	$expertArr[13]=array('name'=>'袁明凤','mobile'=>'13058006972');
    	$expertArr[14]=array('name'=>'张艳琼','mobile'=>'13509633897'); 
    	return $expertArr;
    }
    //关联管家
    function get_expert(){
    	$expertArr=$this->get_sales_expert();
    	foreach ($expertArr as $k=>$v){   //遍历管家
    		$this->load->model ( 'admin/a/expert_model','expert_model');
    		$expert=$this->expert_model->row(array("mobile"=>trim($v["mobile"])));
    		if(!empty($expert)){
    			echo  'name=>'.$expert['realname'].',mobile=>'.$expert['mobile'];
    			echo '<br>';
    		}	
    	}
    }
    // 运行线路关联管家
    function insert_sales_expert(){
    	$this->db->trans_start ();
    	
    	//遍历线路
    	$saleLine=$this->sales_apply_model->select_data('u_sales_line',array());
    	foreach ($saleLine as $key=>$val){  //促销线路
    		$expertArr=$this->get_sales_expert();
    		foreach ($expertArr as $k=>$v){   //遍历管家
	    		$this->load->model ( 'admin/a/expert_model','expert_model');
	    		$expert=$this->expert_model->row(array('realname'=>trim($v['name']),'mobile'=>trim($v['mobile'])));
	    		if(!empty($expert)){
	    		    //查看是否已存在售卖线路
	    			$lineApply=$this->sales_apply_model->select_data('u_line_apply',array('line_id'=>$val['lineId'],'expert_id'=>$expert['id']));
	    			if(empty($lineApply[0])){
	    				$Apply=array(
	    					'grade'=>1,
	    					'modtime'=>date('Y-m-d H:i:s',time()),
	    					'addtime'=>date('Y-m-d H:i:s',time()),
	    					'line_id'=>$val['lineId'],
	    					'expert_id'=>$expert['id'],
	    					'status'=>2
	    				);
	    				$this->db->insert('u_line_apply',$Apply);
	    			}
	    		}
    		} 
    		
    	}
    	

    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}else{
    		echo true;
    	}
    	
    } */
}
