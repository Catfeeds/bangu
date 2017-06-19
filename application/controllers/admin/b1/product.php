<?php
/**
 * **
 * 深圳海外国际旅行社
 * 艾瑞可
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
include_once './application/controllers/msg/t33_msg.php';
class Product extends UB1_Controller {
	function __construct() {
	
		parent::__construct ();

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
	public function test(){
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/test' );
		$this->load->view ( 'admin/b1/footer.html' );
	}
	public function index() {
      	$data['type']=$this->input->get('type');  
		$data['pageData'] = $this->user_shop_model->get_user_shop ( array('status'=>'0'),$this->getPage () );
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/user_shop_last', $data );
		$this->load->view ( 'admin/b1/footer.html' );
	}
	
	public function indexData() {
		$page = $this->getPage ();
		$arr = array('status','productName','lineday','sn');
		$destcity=$this->input->post('destcity');
		$cityName=$this->input->post('cityName');
		if($destcity){
			$dest['cityid']=$destcity;
		}else{
			$dest['cityid']='';
		}
		$dest['cityname']=trim($cityName);
		$param = $this->getParam($arr,array('status'=>'0'));
		$data = $this->user_shop_model->get_user_shop ( $param , $page,$dest);
		//echo $this->db->last_query();
		echo  $data ;
	}
	//线路提交审核
	public  function commitLine(){
		$lineId=$this->get('id');
		$type=$this->get('type');
		//判断是否有套餐价格
		$re=$this->user_shop_model->get_suitPrice_data(array('sp.lineid'=>$lineId,'sp.day >'=>date('Y-m-d')));
		
		$supplier = $this->getLoginSupplier();
		
		//线路信息
		$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$lineId));
		
		//联盟线路
		$line_app=$this->user_shop_model->select_rowData('b_union_approve_line',array('line_id'=>$lineId,'supplier_id'=>$supplier['id']));
     
		//联盟供应商
		$union = $this->db->query("select union_id from b_company_supplier where supplier_id={$supplier['id']} and status=1")->result_array();
		if(!empty($union)){
			if(!empty($line_app)){
				if($line_app['status']!="2"){
					foreach ($union as $k=>$v){
						if($v['union_id']){
							$flag=$this->user_shop_model->update_approve_line($lineId,$supplier['id'],1,$v['union_id']);
						}
					}   
				}	
			}		
		}
		
		//帮游供应商
		if($line['status']!="2"){
			$flag = $this->user_shop_model->update_examine_line($lineId,$supplier['id'],1);
		}
		 
		if($flag){
			if($type==1){
				//发送消息jkr
				$msg = new T33_msg();
				$loginData = $this ->session ->userdata('loginSupplier');
				$msgArr = $msg ->sendMsgLine($lineId ,1 ,$loginData['linkman']);
			}
 
			echo  json_encode(array('status'=>1,'msg'=>'操作成功!'));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	//定制团提交审核
	public function commitApp(){
		 $lineId=$this->get('id');
		 $type=$this->get('type');
		 //判断是否有套餐价格
		 $re=$this->user_shop_model->get_suitPrice_data(array('sp.lineid'=>$lineId,'sp.day >'=>date('Y-m-d')));

       	 $supplier = $this->getLoginSupplier();
       	 if($type==1){  //联盟供应商
    		  $union_id=$this->get('union_id');
    			if(empty($union_id)){
    				echo  json_encode(array('status'=>-1,'msg'=>'没有选择联盟单位'));exit;
    			}else{
    				$flag=$this->user_shop_model->update_approve_line($lineId,$supplier['id'],1,$union_id);	
    			}
       	  }else{  //帮游供应商
			    $flag = $this->user_shop_model->update_examine_line($lineId,$supplier['id'],1);
       	  }
     
    	  if($flag){
    			if($type==1){
	    			//发送消息jkr
	    			$msg = new T33_msg();
	    			$loginData = $this ->session ->userdata('loginSupplier');
	    			$msgArr = $msg ->sendMsgLine($lineId ,1 ,$loginData['linkman']);
    			}
    			
    			echo  json_encode(array('status'=>1,'msg'=>'操作成功!'));
    	  }else{
    			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
    	  }
	}
	//判断线路是否在线
	function is_line(){
		$id=$this->input->post('id');
		$supplier = $this->getLoginSupplier();
		if(is_numeric($id)){
			$res=$this->user_shop_model->get_user_shop_select('u_line',array('id'=>$id,'supplier_id'=>$supplier['id']));
			$app_line=$this->user_shop_model->get_user_shop_select('b_union_approve_line',array('line_id'=>$id,'supplier_id'=>$supplier['id']));
			if(!empty($res[0])){
				if($res[0]['producttype']==1){  //定制团
					//帮游
					if($res[0]['status']==2){
						echo  json_encode(array('status'=>-1,'msg'=>'该条线路在帮游定制团中上线了,需下线再修改'));
						exit;
					}
					if($res[0]['status']==1){
						echo  json_encode(array('status'=>-1,'msg'=>'该条线路在帮游定制团审核中,需中断申请再修改'));
						exit;
					}
					if(!empty($app_line[0])){
						if($app_line[0]['status']==2){
							echo  json_encode(array('status'=>-1,'msg'=>'该条线路在定制团中上线了,需下线再修改'));
							exit;
						}
						if($app_line[0]['status']==1){
							echo  json_encode(array('status'=>-1,'msg'=>'该条线路在定制团审核中,需中断申请再修改'));
							exit;
						}
					}
					//b_union_approve_line	
				}else{  //线路
					if($res[0]['status']==2){
						echo  json_encode(array('status'=>-1,'msg'=>'该条线路在帮游产品中上线了,需下线再修改'));	
						exit;	
					}
					if($res[0]['status']==1){
						echo  json_encode(array('status'=>-1,'msg'=>'该条线路在帮游产品审核中,需中断申请再修改'));	
						exit;	
					}
					if(!empty($app_line[0])){
						if($app_line[0]['status']==2){
							echo  json_encode(array('status'=>-1,'msg'=>'该条线路在产品汇总中上线了,需下线再修改'));
							exit;
						}
						if($app_line[0]['status']==1){
							echo  json_encode(array('status'=>-1,'msg'=>'该条线路在产品汇总审核中,需中断申请再修改'));
							exit;
						}
					}
					
				}	
				
			}
			echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
		}
	}
	//取消
	public function cancelApp(){
		//return $this->updateStatus( $this->get('id'),0 );
		$supplier = $this->getLoginSupplier();
		$type=$this->get('type');
		//var_dump($supplier);
		if($type==1){  //联盟供应商
			$union_id=$this->get('union_id');
			if(empty($union_id)){
				echo  json_encode(array('status'=>1,'msg'=>'操作失败'));exit;
			}else{
				$re=$this->user_shop_model->update_approve_line($this->get('id'),$supplier['id'],0,$union_id);	
			}
		}else{  //帮游
			$re= $this->user_shop_model->update_examine_line($this->get('id'),$supplier['id'],0);
		}
 		
 		if($re){
			echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
 		}else{
 			echo  json_encode(array('status'=>-1,'msg'=>'中断申请失败,可能获取不到线路ID或者登录失效了,请重新操作！'));
 		}
	}
	//下线
	public function offline(){
		$supplier = $this->getLoginSupplier();
		$type=$this->get('type');

		//if($type==1){  //联盟供应商
			//$union_id=$this->get('union_id');
			$union = $this->db->query("select union_id from b_company_supplier where supplier_id={$supplier['id']} and status=1")->result_array();
			if(!empty($union)){
				foreach ($union as $k=>$v){
					if($v['union_id']){
						$id=$this->user_shop_model->update_approve_line($this->get('id'),$supplier['id'],0,$v['union_id']);
					}
				}
			}
			/* if(empty($union_id)){
				$id=0;
			}else{
				$id=$this->user_shop_model->update_approve_line($this->get('id'),$supplier['id'],0,$union_id);	
			}
 */
		//}else{ //帮游
			$id=$this->user_shop_model->update_examine_line($this->get('id'),$supplier['id'],0);
		//}

		if($id){  //删除首页缓存
			$this->cache->redis->delete('SYDestLine');
			$this->cache->redis->delete('SYhomeLineRanking');	
		}
		
		echo $id;
	}
	
	//删除 
	public function del(){
		
		$this->db->trans_start();
		
		$flag=1;		
		$lineid=$this->get('id');
	
		$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$lineid));
	
			
		$type=$this->get('type');
		if($type==1){  //联盟供应商
			$union_id=$this->get('union_id');
			if(empty($union_id)){
				$flag=0;
			}else{
				$supplier = $this->getLoginSupplier();
				$id=$this->user_shop_model->update_approve_line($lineid,$supplier['id'],-1,$union_id);
			}
		}else{
			 $flag=$this->updateStatus($lineid,-1);	
			 //促销线路
			 $this->user_shop_model->del_data('u_sales_line',array('lineId'=>$lineid));
			 $this->user_shop_model->del_data('u_sales_line_suit_price',array('lineId'=>$lineid));
		}

		//t33
		//$this->user_shop_model->update_rowdata('b_union_approve_line',array('stauts'=>-1),array('line_id'=>$lineid))			
		$this->db->trans_complete();
		$re=$this->db->trans_status();
		echo $re;
	}
	
	private function updateStatus($lineId,$status){
		$row = $this->user_shop_model->updateLineStatus($lineId,$status);	
		return $row>0 ? 1 : 0;
	}
	//编辑线路
	public function toLineEdit() {	
		$lineId= $this->get('id');
		$type=$this->get('type');    
		$supplier = $this->getLoginSupplier();
		//访问线路的权限
		if(is_numeric($lineId)){
			if(empty($type)){
				$res=$this->user_shop_model->get_user_shop_select('u_line',array('id'=>$lineId,'supplier_id'=>$supplier['id']));
				if(empty($res)){
				 	echo '<script>alert("您没有权限访问该线路");window.history.back(-1);</script>';exit;	
				}
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
		
		//获取线路的出发地
		$data['startcity']='';
		if($data['data']['startcity']>0){
			$startcity = $this->user_shop_model->get_user_shop_select ('u_startplace' ,array('id'=>$data['data']['startcity']));
			$data['startcity']=$startcity[0];
		}
		//获取线路的目的地
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] = $this->user_shop_model->get_lineDestData(explode(",",$data['data']['overcity2']));
		}
	     
		//线路的标签
		/*$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}*/

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
   		//$data['rout']=$this->user_shop_model->getLineRout($lineId);
   		//echo $this->db->last_query();
   		//供应商信息
   		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));
   		//管家培训
   		//$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
   		//选保险 
   		//$data['insurance_id']=$this->user_shop_model->get_user_shop_select('u_line_insurance',array('line_id'=>$lineId,'status'=>1));
  		//$data['insurance']=$this->user_shop_model->sel_line_insurance($lineId,array('supplier_id'=>$supplier['id'],'status'=>1));
    
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

		//礼品管理
		//$data['gift']=$this->user_shop_model->get_gift_data($lineId);
		//$this->load->model ( 'admin/b1/gift_manage_model','gift_manage' );
		//$where=' and ( g.status=0 or g.status=1)  ';
		//$data['pageData1'] = $this->gift_manage->get_gift_list( array('linelistID'=>$lineId),$where,$this->getPage () );

        //线路类型
        $line_overcity=explode(',', $data['data']['overcity']);
		if(in_array("1", $line_overcity)){ 
			$data['line_type']=1;
		}else{
			$data['line_type']=2;
		} 

        //默认前六张的图库
   		$data['dest_two']=$this->user_shop_model->get_dest_pic($supplier['id']);

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

   		//线路押金,团款,时分截止时间
   		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));

   		//上车地点
   		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));

   		$data['type']=$type;
   	
		//编辑页面
		$this->load->view ( 'admin/b1/header.html' );
    	$this->load->view ( 'admin/b1/line/line_edit', $data );
    	$this->load->view ( 'admin/b1/footer.html' );
			
	}
	//显示行程
	public function getLineRoutData(){
		$id= $this->input->post('id',true);
		$datas['data'] = $this->user_shop_model->get_user_shop_byid($id);
		//行程安排
		$datas['rout']=$this->user_shop_model->getLineRout($id);
		$datas['linetype']=1;
		$string=$this->load->view ( 'admin/b1/line/line_rout', $datas );
		echo $string;
	}
	//显示套餐
	function showLineSuit(){
		$id= $this->input->post('id',true);
		//获取套餐的信息
		$data['suits'] =$this->user_shop_model->getLineSuit($id);
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($id);
		//线路押金,团款
   		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$id));

		$string=$this->load->view ( 'admin/b1/line/line_suit', $data );
		echo $string;
	}
	//显示费用说明
	function showLineFee(){
		$id= $this->input->post('id',true);
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($id);
	
		$string=$this->load->view ( 'admin/b1/line/line_fee', $data );
		echo $string;
	}
	//显示参团须知
	function showLineOffere(){
		$id= $this->input->post('id',true);
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($id);
		//附件	
   		$data['protocol']=$this->user_shop_model->select_data('u_line_protocol',array('line_id'=>$id));
   		//$data['type']=$type;

		$string=$this->load->view ( 'admin/b1/line/line_offere', $data );
		echo $string;
	}
	//显示产品标签
	function showLineLabel(){
		$id= $this->input->post('id',true);

		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($id);

		//线路的标签
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}

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

		$string=$this->load->view ( 'admin/b1/line/line_label', $data );
		echo $string;
	}
	//显示管家培训
	function showLineTrain(){
		$id= $this->input->post('id',true);
		$data['type']= $this->input->post('type',true);

		$data['type_train']=$this->input->post('type_train',true);
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($id);
 		//管家培训
       	$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$id,'status'=>1));

		//判断是否是联盟的供应商
   		$is_union=$this->session->userdata('is_union');
   		if(empty($is_union)){
   			$is_union=0;	
   		}
   		$data['is_union']=$is_union;

       	$string=$this->load->view ( 'admin/b1/line/line_train', $data );
		echo $string;
	}
	 //显示抽奖礼品
	function showLineGift(){
		$id= $this->input->post('id',true);
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($id);

		$data['gift']=$this->user_shop_model->get_gift_data($id);
        $this->load->model ( 'admin/b1/gift_manage_model','gift_manage' );
        $where=' and ( g.status=0 or g.status=1)  ';
        $data['pageData1'] = $this->gift_manage->get_gift_list( array('linelistID'=>$id),$where,$this->getPage () );

        $string=$this->load->view ( 'admin/b1/line/line_gift', $data );
		echo $string;
	}
	/**
	*访问线路的权限
	*/
/* 	function auth_line(){
		$lineId= $this->get('line_id');	
	    $supplier = $this->getLoginSupplier();
		
		//访问线路的权限
		if(is_numeric($lineId)){	
			$res=$this->user_shop_model->get_user_shop_select('u_line',array('id'=>$lineId,'supplier_id'=>$supplier['id']));
			if(empty($res)){
			 	echo  json_encode(array('status'=>-1,'msg'=>'您没有权限访问该线路'));exit;	
			}		
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'该线路不存在'));exit;	
		} 
		echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
	} */
 	//线路详情
/*  	function show_line_detail(){
 		$lineId= $this->get('id'); 
		$supplier = $this->getLoginSupplier();
		
		//访问线路的权限
		if(is_numeric($lineId)){	
			$res=$this->user_shop_model->get_user_shop_select('u_line',array('id'=>$lineId,'supplier_id'=>$supplier['id']));
			if(empty($res)){
			 	echo '<script>alert("您没有权限访问该线路");window.history.back(-1);</script>';exit;	
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
		$data['suits'] =$this->user_shop_model->getLineSuit($lineId);

		//去掉复制的标识
		$linename=str_replace("— 复制","",$data['data']['linename']);
		$this->user_shop_model->update_rowdata('u_line',array('linename'=>$linename),array('id'=>$lineId));
		
		//获取线路的出发地
		$data['startcity']='';
		if($data['data']['startcity']>0){
			$startcity = $this->user_shop_model->get_user_shop_select ('u_startplace' ,array('id'=>$data['data']['startcity']));
			$data['startcity']=$startcity[0];
		}
		//获取线路的目的地
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] = $this->user_shop_model->getDestinationsData($lineId);
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

        //线路类型
        $line_overcity=explode(',', $data['data']['overcity']);
		if(in_array("1", $line_overcity)){ 
			$data['line_type']=1;
		}else{
			$data['line_type']=2;
		} 

        //默认前六张的图库
   		$data['dest_two']=$this->user_shop_model->get_dest_pic($supplier['id']);

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
   		//指定营业部
   		$data['package']=$this->user_shop_model->select_line_package($lineId);

        // 定制管家数据
		$data['expert']=$this->user_shop_model->get_group_expert($lineId);

		//上车地点
   		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));
   		
		$data['line']=$data;			
		$this->load->view ( 'admin/b1/line_detail_box' ,$data);
 	} */	
	function product_indexData(){
		$page = $this->getPage ();
		$arr = array('status','productName','lineday','sn');
		$destcity=$this->input->post('destcity');
		$cityName=$this->input->post('cityName');
		if($destcity){
			$dest['cityid']=$destcity;
		}else{
			$dest['cityid']='';
		}
		$dest['cityname']=trim($cityName);
		$param = $this->getParam($arr,array('status'=>'0'));
		$data = $this->user_shop_model->get_product_list ( $param , $page,$dest);
		//echo $this->db->last_query();
		echo  $data ;
	}
	//查看行程
	public function lookRout(){
		$lineId= $this->get('id');
	
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		//套餐
		$data['suits'] = $this->user_shop_model->getLineSuit($lineId);
		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);
		
		$data['lineday']=$this->get('lineday');//旅游天数(原来的)
		$data['data_num']=$this->get('data_num'); //修改后的天数
	    $outday=$data['data_num']-$data['lineday'];  
	    $data['changeRout']='';
       	if( $outday>0){
        		$data['changeRout']=$data['lineday']; 
       	 /* 	$outday=$data['data_num']-$data['lineday'];
        		$where=array('jie.lineid'=>$lineId,'jie.day > '=>$data['lineday']);
        		$data['changeRout']=$this->user_shop_model->get_change_lineRout($where,$outday); */
      	}/* else{
        		$shotday=$data['lineday']-$data['data_num'];
       	} */
        
		$string=$this->load->view ( 'admin/b1/line_rout', $data );
		echo $string;
	}
	
	/*
	*@method 根据目的地找景点
	*/
	public function get_scenic_spot(){
		$line_id =$this->input->post('line_id',true);
		//线路的目的地
		$line=$this->user_shop_model->get_user_shop_select('u_line',array('id'=>$line_id));
		//$scenic=array();
		$line_spot=$this->user_shop_model->get_user_shop_select('u_line_spot',array('line_id'=>$line_id));
		$spotstr='';
		if(!empty($line_spot)){
			foreach ($line_spot as $key => $value) {
				if($spotstr==''){
					$spotstr= $value['spot_id'];
				}else{
					$spotstr=$spotstr.','.$value['spot_id'];
				}
			}
		}
		$spot='';
		if(!empty($line[0]['overcity2'])){
            $overcity=explode(',', $line[0]['overcity2']);
            foreach ($overcity as $key => $value) {
                if(!empty($spotstr)){
	                  $where="city_id = {$value} and (status=0 or status=1) and id not in ({$spotstr})";
                }else{
	                  $where="city_id = {$value} and (status=0 or status=1) ";
                }
                	
                $dest=$this->user_shop_model->get_user_shop_select('u_dest_base',array('id'=>$value));
                $spot=$this->user_shop_model->get_user_shop_select('scenic_spot',$where);  
                $scenic[$key]['kindname']=$dest[0]['kindname'];
                $scenic[$key]['dest_id']=$dest[0]['id']; 
                $scenic[$key]['spot']=$spot;                               	
            }     
		}
		echo  json_encode(array('status'=>1,'scenic'=>$scenic,'spot'=>$spot));
	}
	public function get_dest_scenic(){
		$dest_id=$this->input->post('dest_id',true);
		$spot='';
		if($dest_id>0){
			$spot=$this->user_shop_model->get_user_shop_select('scenic_spot',array('city_id'=>$dest_id));  
		}
		echo  json_encode(array('status'=>1,'spot'=>$spot));
	}
	//保存线路景点
	public function save_line_spot(){
		$postArr = $this->security->xss_clean($_POST);
		$name = trim($postArr['name']);
		//$phone = trim($postArr['phone']);
		$address = trim($postArr['address']);
		//$money = floatval($postArr['money']);
		$lat = trim($postArr['lat']);
		$lng = trim($postArr['lng']);
		$geohash = trim($postArr['geohash']);
	/*	$country_id = intval($postArr['country_id']);
		$province_id = intval($postArr['province_id']);*/
		$city_id = intval($postArr['city_id']);
		//$id = empty($postArr['id']) ? '' : intval($postArr['id']);
		$piclist = trim($postArr['piclist']);
		$index = trim($postArr['index']);
		if (empty($lat) || empty($lng) || empty($geohash))
		{
			echo  json_encode(array('status'=>-1,'msg'=>'获取经纬度错误'));
			exit;
		}
		if ($city_id < 1) {
			echo  json_encode(array('status'=>-1,'msg'=>'请选择景点地区'));
			exit;
		}
		if (empty($name))
		{
			echo  json_encode(array('status'=>-1,'msg'=>'请填写景点名称'));
			exit;
		}
		if (empty($piclist))
		{
			echo  json_encode(array('status'=>-1,'msg'=>'请上传图片'));
			exit;
		}
		$picArr = explode(',', trim($piclist ,','));
		$mainpic = $this ->compressImg(ltrim($picArr[$index],'/'));
		
		$scenicArr = array(
			'name' =>$name,
			'address' =>$address,
			//'description' =>trim($postArr['description']),
			'longitude' =>$lng,
			'latitude' =>$lat,
			'geohash' =>$geohash,
			'displayorder' =>9999,
			'mainpic' =>$mainpic,
			'rawPic' =>$picArr[$index],
			'pic_num' =>count($picArr),
			'open_time' =>date('Y-m-d H:i:s' ,time()),
			'city_id' =>$city_id,
			'status'=>0
		);
		
		$scenicArr['open_time'] = date('Y-m-d H:i:s' ,time());

		/*$scenic=array('name'=>'tesat','scenic_spot_id'=>5);
		echo  json_encode(array('status'=>1,'msg'=>'添加成功','scenic'=>$scenic));
		exit;*/
		$id=$this ->user_shop_model ->insertScenic($scenicArr ,$picArr);
		if($id>0){
			$scenic=array('name'=>$name,'scenic_spot_id'=>$id);
			echo  json_encode(array('status'=>1,'msg'=>'添加成功','scenic'=>$scenic));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'添加失败'));
		}
		

	}
	//压缩图片
	public function compressImg($picSrc)
	{
		$picName = substr($picSrc ,0 ,strrpos($picSrc ,'.')).'_thumb'.substr($picSrc, strrpos($picSrc ,'.'));
		if (file_exists($picName)) {
			return $picName;			
		}
		$config['image_library'] = 'gd2';
		$config['source_image'] = $picSrc;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']     = 135;
		$config['height']   = 100;

		$this->load->library('image_lib', $config);
		$status = $this->image_lib->resize();
		if ($status == true)
		{
			return $picName;
		}
		else 
		{
			return $picSrc;	
		}
	}
	//修改线路的基础信息
	public function updateLine() {
		$supplier = $this->getLoginSupplier();
		
		$type=$this->input->post('type',true); //线路类型,区别包团和散团

		$expert_id=$this->input->post('expert_id',true);
		$b_expert_id=$this->input->post('b_expert_id',true);
		$departId=$this->input->post('departId',true);
            
		// 基础信息
		$line_classify=$this->input->post ( 'line_classify' ,true);//线路名称
		$id = $this->input->post ( 'id' );//线路名称
		$linename = $this->input->post ( 'linename' );//线路主名称
		$lineprename = $this->input->post ( 'lineprename' );//线路全名称
		$nickname = $this->input->post ( 'nickname' );//供应商方便自己识别的名字
		$linetitle= trim($this->input->post ( 'linetitle' )); //线路副标题
		$startcity = $this->input->post('lineCityId');    //出发城市

		if(empty($startcity)){
			echo  json_encode(array('status'=>-1,'msg'=>'出发城市不能为空'));exit;
		}
		$arr_city = $this->input->post ( 'overcity',true );		//目的地
		$overcity2 = $this->input->post ('overcitystr',true);	
		if(empty($overcity2)){
			echo  json_encode(array('status'=>-1,'msg'=>'目的地不能为空'));exit;
		}
		$overcity2= substr($overcity2,0,-1);
		$lineday = $this->input->post ( 'data_num' );    //天数
		$linenight = $this->input->post ( 'data_night' );   //晚数
		$linenight=($linenight=='' ? '0':$linenight);
		$linebefore = $this->input->post ( 'data_before' );
		$features = $this->input->post ( 'name_list' );   //线路特色

		$confirm_time = $this->input->post ( 'confirm_time' );
	
		$final_pay_before = $this->input->post ( 'final_pay_before' );
		$line_pics_arr = $this->input->post ( 'line_imgss' ); //行程图片
		$theme= $this->input->post ( 'theme' );  //主题
		$mainpic=$this->input->post ( 'mainpic' );//主图片
		if(empty($mainpic)){
			echo  json_encode(array('status'=>-1,'msg'=>'线路宣传图的主图片不能为空'));exit;
		}
		$linebefore=$this->input->post ( 'linebefore' );
		$linedatehour=$this->input->post ( 'linedatehour' );  //报名截止时
		$linedateminute=$this->input->post ( 'linedateminute' );  //报名截止时
		$car_address=$this->input->post('car_addressArr',true);  //上车地点
	
		if(''==$theme){
			$theme = 0;
		}
		//供应商信息
		$supplierData=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));
		//线路名称
		if($linenight==''|| $linenight==0){
			$linename=$supplierData[0]['brand'].' · '.$lineprename.$lineday.'天游';
		}else{
			$linename=$supplierData[0]['brand'].' · '.$lineprename.$linenight.'晚'.$lineday.'天游';
		}

		$this->db->trans_start();  //事务处理开始
		
	    //获取线路的信息
	   	$lineData= $this->user_shop_model->get_user_shop_byid($id);
	   	
	   	if(!empty($lineData['producttype'])){
		$company=$this->user_shop_model->get_user_shop_select('b_company_supplier',array('supplier_id'=>$supplier['id'],'status'=>1));
	   	 	if($lineData['producttype']==1){
	   	 		if(!$expert_id && !$departId && !$b_expert_id){
	   	 			echo  json_encode(array('status'=>-1,'msg'=>'请选择定制销售人员'));exit;
	   	 		}	
	   	 	}
	   	 }
 	
		//三级目的地的父类
	   	 $overcitystr='';
	   	 $overcity='';
	   	 if(!empty($arr_city)){
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
	   	 //照片二级目的地
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
			'supplier_id' =>$supplier['id'],
			'final_pay_before' => '0',
			'modtime' => date("Y-m-d H:i:s",time()),
			'confirm_time'=>$confirm_time,
			'themeid'=>$theme,
			'mainpic'=>$mainpic,
			'ordertime'=>date('Y-m-d H:i:s',strtotime('+7 day')),
			'linebefore'=>$linebefore
		);
		//线路押金,团款
		$LineAff=array('hour'=>$linedatehour,'minute'=>$linedateminute);
		$this->checkLineData($data,$startcity); //验证线路信息

		//添加上车地点
		$this->db->where(array('line_id'=>$id))->delete('u_line_on_car');
		if(!empty($car_address)){
			foreach($car_address as $key => $value) {
				$carArr=array(
					'line_id'=>$id,
					'on_car'=>$value
				);
				$this->user_shop_model->insert_data('u_line_on_car',$carArr);
			}
		}

		//保存线路
		$flag=$this->user_shop_model->save_line_base($type,$data,$startcity,$line_pics_arr,$expert_id,$overcityArr,$id,$LineAff,$b_expert_id,$departId);
        //删除线路详情静态文件
		$this->del_cache($id);
		//保存二级目的地的线路图片地址
 		if(!empty($bourn)){
			$bourntwo=array_unique($bourn);
			if(!empty($line_pics_arr)){
			      $repic=$this->user_shop_model->insert_pic_library($bourntwo,$line_pics_arr,$supplier['id']);
			}
		} 

	   	 if(!empty($lineData['mainpic'])){
	    		$mainpic=$lineData['mainpic'];
	   	 }else{
	    		$mainpic='';
	  	 }
	   	 //遍历线路图片
	     $imgurl=$this->user_shop_model->select_imgdata($id);
	    	
	     $this->db->trans_complete();
	     if ($this->db->trans_status() === FALSE)
	     {
	     	echo  json_encode(array('status'=>-1,'msg'=>'保存失败'));
	     }else{
	     	echo  json_encode(array('status'=>1,'imgurl_str'=>$imgurl,'mainpic'=>$mainpic));
	     	
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
	/*保存,编辑行程安排*/
	public function updateRouting(){
		
		$id = $this->input->post ( 'id' );//线路id
		if($id>0){
			$this->db->trans_start();

			$routid = $this->input->post ( 'routid' );
			//echo $id;
			$day=$this->input->post('day');  //第几天的天数
			$title=$this->input->post('title');  //第几天的标题
			$breakfirsthas=$this->input->post('breakfirsthas');//早餐
			$breakfirst=$this->input->post('breakfirst');//早餐描述
			$transport=$this->input->post('transport');//早餐描述
			$lunchhas=$this->input->post('lunchhas');//午餐
			$lunch=$this->input->post('lunch');//午餐
			$supperhas=$this->input->post('supperhas');
			$supper=$this->input->post('supper');
			$hotel=$this->input->post('hotel');
			$stay=$this->input->post('stay');
			$line_pic_arr=$this->input->post('line_pic_arr');//线路图片	
			$line_beizhu=$this->input->post('line_beizhu');//行程的温馨提示
			$jieshao=$this->input->post('jieshao');
			//行程的温馨提示
			$lineArr=array(
				'line_beizhu'=>$line_beizhu,
				'ordertime'=>date('Y-m-d H:i:s',strtotime('+7 day')),
				'modtime'=>date("Y-m-d H:i:s",time()),
			);
			$this->user_shop_model->update_rowdata('u_line',$lineArr,array('id'=>$id));
			// 删除线路详情静态文件
			$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$id));
			$this->del_cache($id);
            //保存行程    
		    $selRout=$this->user_shop_model->select_data('u_line_jieshao',array('lineid'=>$id));//行程线路表
				foreach ($day as $key=>$val){	
				 		$data['lineid']=$id;
				 		$data['day']=$day[$key];
				 		$data['breakfirsthas']=(!empty($breakfirsthas[$key])) ? $breakfirsthas[$key]:0;
				 		if($data['breakfirsthas']>0){  //不勾选，文本框输入了内容或不输内容，为“无”；
				 			if(!empty($breakfirst[$key])){ //勾选了，文本框为空，为“含”；
				 				if($breakfirst[$key]=='无'){
				 					$breakfirst[$key]='含';
				 				}
				 				$data['breakfirst']=$breakfirst[$key]; 
				 			}else{
				 				$data['breakfirst']='含';
				 			}
				 			
				 		}else{
				 			$data['breakfirst']='无';
				 		}
				 		$data['lunchhas']=(!empty($lunchhas[$key])) ? $lunchhas[$key]:0;
				 		if($data['lunchhas']>0){ //不勾选，文本框输入了内容或不输内容，为“无”；
				 			if(!empty($lunch[$key])){ //勾选了，文本框为空，为“含”；
				 				if($lunch[$key]=='无'){
				 					$lunch[$key]='含';
				 				}
				 				$data['lunch']=$lunch[$key];
				 			}else{
				 				$data['lunch']='含';
				 			}
				 		}else{
				 			$data['lunch']='无';
				 		}
				 		
				 		$data['supperhas']=(!empty($supperhas[$key])) ? $supperhas[$key]:0;	
				 		if($data['supperhas']>0){ //不勾选，文本框输入了内容或不输内容，为“无”；
				 			if(!empty($supper[$key])){
				 				if($supper[$key]=='无'){
				 					$supper[$key]='含';
				 				}
				 				$data['supper']=$supper[$key];
				 			}else{
				 				$data['supper']='含';
				 			}	
				 		}else{
				 			$data['supper']='无';
				 		}	 
				 		
				 		$data['hotel']=$hotel[$key];
				 		$data['jieshao']=$jieshao[$key];
				 		$data['title']=$title[$key];
				 		$data['transport']=$transport[$key];
				 		if($data['hotel']==''){  //住宿情况
				 			if(!empty($stay[$key])){
				 				$data['hotel']=$stay[$key];
				 			}
				 		}
				 		
				 		if(empty($selRout)){  //--------没存在行程则插入	-------------			 		
					 		//插入表
					 	 	$res=$this->user_shop_model->get_user_line_jieshao($data); 	
					 	 	//插入行程图片
					 	 	if(!empty($line_pic_arr[$key])){
					 	 		$this->user_shop_model->insert_data ( 'u_line_jieshao_pic', array('jieshao_id'=>$res,'pic'=>$line_pic_arr[$key],'addtime'=>date("Y-m-d H:i:s",time())) );
					 	 	}
				 		}else{    //--------------行程有数据 ，有则修改------------
		
				 		    if(!empty($selRout[$key]['day']) && $selRout[$key]['day']==$day[$key]){  //已有就编辑
  											
				 		    	$where=array(
				 		    			'lineid'=>$id,
				 		    			'day'=>$selRout[$key]['day']
				 		    	);    	

				 		    	$res=$this->user_shop_model->updata_jieshao_data($where,$data);
				 		    	//修改行程图片
				 		    	$jieshao_pic=$this->user_shop_model->select_rowData('u_line_jieshao_pic',array('jieshao_id'=>$routid[$key]));
				 		    	
				 		    	if(!empty($jieshao_pic)){ //修改 				 		 
				 		    		$jieshao_pic=$this->user_shop_model->update_rowdata('u_line_jieshao_pic',array('pic'=>$line_pic_arr[$key]),array('jieshao_id'=>$routid[$key]));

				 		    	}else{					//插入
				 		    		//插入行程图片
				 		    		if(!empty($line_pic_arr[$key])){
				 		    			$this->user_shop_model->insert_data ( 'u_line_jieshao_pic', array('jieshao_id'=>$routid[$key],'pic'=>$line_pic_arr[$key],'addtime'=>date("Y-m-d H:i:s",time())) );
				 		    		}
				 		    	}
					   	     }else{      //--------------行程在有数据 没有的插入------------------
				 		    	
					 		    	if(empty($routid[$key])){  	
					 		    		//插入表
					 		    		$res=$this->user_shop_model->get_user_line_jieshao($data);
					 		    		//插入行程图片
					 		    		if(!empty($line_pic_arr[$key])){
					 		    		 	$this->user_shop_model->insert_data ( 'u_line_jieshao_pic', array('jieshao_id'=>$res,'pic'=>$line_pic_arr[$key],'addtime'=>date("Y-m-d H:i:s",time())) );
					 		    		}
					 		    	}	
				 		     }	

				 	}
				 	//--------------记录二级目录的图片地址---------------	
					if($line_pic_arr[$key]){
						$bourn='';
						$bourntwo=explode(';', $line_pic_arr[$key]);
						//获取线路的信息
						$line = $this->user_shop_model->get_user_shop_byid($id);
						$arr_city=explode(',',$line['overcity']);

						foreach ($arr_city as $k=>$v){
							if($v>0){
								$city_str=$this->user_shop_model->get_user_shop_select('u_dest_base',array('id'=>$v,'level'=>2));
							}
							if(!empty($city_str[0])){
								$bourn[]=$city_str[0]['id'];
							}
						}
						if(!empty($bourn)){
							$bourntwo=array_unique($bourn);  //二级目的地
						}
						
						if(!empty($bourntwo)&&!empty($line['supplier_id'])){  
							$this->user_shop_model->second_pic_library($line_pic_arr[$key],$bourntwo,$line['supplier_id']);//插入表line_picture_library
						}  
					} 
					//---------------------end-----------------------
			 	} 
			 	//-----------------------------遍历行程---------------------------------
			    //------------------------------------设置景点----------------------------
			 	$scenicData=$this->input->post('scenicData',true);
			 	$this->user_shop_model->save_line_spot($scenicData,$id);

			    if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					echo  false;
				}
				else
				{
					echo  true;
				}

		}else{
			echo false;
		}

	}
	//搜索景点
	public function search_scenic_spot(){
		$city_id=$this->input->post('city_id',true);
		$searchName=$this->input->post('searchName',true);
		$spotStr=$this->input->post('spotStr',true);
		//景点
		$spot='';
		if(!empty($city_id)){
			if(!empty($spotStr)){
				$where="city_id = {$city_id} and (status=0 or status=1) and id not in ({$spotStr}) and name like '%{$searchName}%'";
			}else{
				$where="city_id = {$city_id} and (status=0 or status=1)  and name like '%{$searchName}%'";
			}  
          //$dest=$this->user_shop_model->get_user_shop_select('u_dest_base',array('id'=>$value));
            $spot=$this->user_shop_model->get_user_shop_select('scenic_spot',$where);        
          //$scenic['kindname']=$dest[0]['kindname'];
            $scenic['dest_id']=$city_id; 
            $scenic['spot']=$spot;                               	
		}
		echo  json_encode(array('status'=>1,'scenic'=>$scenic));

	}

	//清空套餐价格
	public function deleteSuitprice(){
		$id=$this->input->post('id');
		if($id>0){
			$this->db->trans_start();
			
		  //  $re=$this->user_shop_model->update_rowdata('u_line_suit_price',array('is_open'=>0),array('suitid'=>$id));
			$date=date('Y-m-d',time());
			$this->db->query("INSERT INTO u_line_suit_price_del SELECT * FROM u_line_suit_price WHERE suitid={$id} and day>='{$date}' ");
			$this->db->query("DELETE FROM u_line_suit_price WHERE suitid={$id} and day>='{$date}'");
		    
		    $this->db->trans_complete();
		    if ($this->db->trans_status() === FALSE)
		    {
		    	echo json_encode(array('status' => -1,'msg' =>'删除失败!'));
		    }else{
		    	echo json_encode(array('status' => 1,'msg' =>'删除成功!'));
		    }
	
		}else{
			echo json_encode(array('status' => -2,'msg' =>'删除失败!'));
		}
	}
	//保存费用说明
	public function updatelineFee(){
		$id = $this->input->post ( 'id' );//线路id
		echo $id;
		if(is_numeric($id)){
			$data['feeinclude']=$this->input->post('feeinclude');
			$data['feenotinclude']=$this->input->post('feenotinclude');
			$data['insurance']=$this->input->post('insurance');
			$data['visa_content']=$this->input->post('visa_content');
			$data['other_project']=$this->input->post('other_project');
			$data['modtime'] =date("Y-m-d H:i:s",time());
			$data['ordertime']=date('Y-m-d H:i:s',strtotime('+7 day'));
		   	$re=$this->user_shop_model->updata_line_fee($id,$data,'');
		   	// 删除线路详情静态文件
			$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$id));
			$this->del_cache($id);	    
		}
		echo $id;
	}
	//预定须知
	public function updateBookNotice(){
		$id = $this->input->post ( 'id' );//线路id
		echo $id;
		if(is_numeric($id)){
			$attachment['name']=$this->input->post('attachment_name',true);
			$attachment['url']=$this->input->post('attachment',true);
			$data['beizu']=$this->input->post('beizu');
			$data['safe_alert']=$this->input->post('safe_alert');
			$data['modtime'] =date("Y-m-d H:i:s",time());
			$data['ordertime'] =date('Y-m-d H:i:s',strtotime('+7 day'));
			$data['special_appointment']= $this->input->post ('special_appointment');
			$re=$this->user_shop_model->updata_line_fee($id,$data,$attachment);
			// 删除线路详情静态文件
			$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$id));
			$this->del_cache($id);
		}
		echo $id;
	}
	//管家培训
	public function updateTrain(){
		$id = $this->input->post ( 'id' );//线路id
		
	 	if(is_numeric($id)){
	 		$question=$this->input->post('question');
	 		$answer=$this->input->post('answer');
	 		$train_id=$this->input->post('train_id');
	 		if(!empty($question)){	
	 			 foreach ($question as $k=>$v){
	 			 	if(!empty($question[$k])){
	 			 		if($train_id[$k]>0){ //修改管家培训
	 			 			$update_data=array('question'=>$question[$k],'answer'=>$answer[$k]);
	 			 			$this->user_shop_model->update_rowdata('u_expert_train',$update_data,array('id'=>$train_id[$k]));
	 			 		}else{ //插入管家培训
	 			 			$insert_data=array('question'=>$question[$k],'answer'=>$answer[$k],'line_id'=>$id,'status'=>1);
	 			 			$this->user_shop_model->insert_data('u_expert_train',$insert_data);
	 			 		}
	 			 	}
	 			} 
	 		}
	 		
	 		// 删除线路详情静态文件
			$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$id));
			$this->del_cache($id);

	 		//管家培训
	 		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$id,'status'=>1));
	 		echo json_encode(array('status' => 1,'msg' =>'保存成功!','train'=>$data['train']));
	 		exit;
		}else{
			//管家培训
			$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$id,'status'=>1));
			echo json_encode(array('status' => -1,'msg' =>'保存失败!','train'=>$data['train']));
			exit;
			//echo $id;
		}		
	} 
	
	//管家培训
	public function train_expert(){
		$lineId= $this->get('id');
		$supplier = $this->getLoginSupplier();
		if(is_numeric($lineId)){
			$res=$this->user_shop_model->select_rowData('u_line',array('id'=>$lineId,'supplier_id'=>$supplier['id']));
			if(empty($res)){
				echo '<script>alert("您没有权限修改该线路");window.history.back(-1);</script>';exit;
			}
		}else{
			echo '<script>alert("不存在该线路");window.history.back(-1);</script>';exit;
		}
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
		$data['tyle']='1';
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/train_expert',$data);
		$this->load->view ( 'admin/b1/footer.html' );
	}
	//删除管家培训
	public function deleteTrain(){
		$id=$this->input->post('id');
		if(is_numeric($id)){
			$re=$this->user_shop_model->update_rowdata('u_expert_train',array('status'=>0),array('id'=>$id));
			if($re){
				echo true;
			}else{
				echo false;
			}
		}else{
			echo false;
		}
	}
	//添加抽奖管理
	function addGift(){
		$insert['gift_name']=$this->input->post('gift_name');
		$insert['starttime']=$this->input->post('startdatetime');
		$insert['endtime']=$this->input->post('enddatetime');
		$insert['account']=$this->input->post('account');
		$insert['worth']=$this->input->post('worth');
		$insert['logo']=$this->input->post('logo');
		$insert['description']=$this->input->post('description');
		$insert['modtime']=date("Y-m-d H:i:s",time());
		$supplier = $this->getLoginSupplier();
		$insert['supplier_id']=$supplier['id'];
		$line_id=$this->input->post('line_id');
		$gift_id=$this->input->post('gift_id');
		
		/*********************修改礼品 ************************/
		if($gift_id>0){ 
		    	$glineArr=array(
		    		'modtime'=>date("Y-m-d H:i:s",time()),
		    		'gift_num'=>$insert['account'],
		    	);
		    	$where=array(
		    		'gift_id'=>$gift_id,
		    		'line_id'=>$line_id,
		    	);
		    	$re=$this->user_shop_model->update_gift($insert,$glineArr,$where);
		    	if(!$re){
		    		echo json_encode(array('status' => 2,'msg' =>'修改成功!','id'=>$gift_id));
		    		exit;
		    	}else{
		    		echo json_encode(array('status' => -2,'msg' =>'修改失败!'));
		    		exit;
		    	}	
		/*********************添加礼品 ************************/
		 }else{
		    	$insert['addtime']=date("Y-m-d H:i:s",time());
		    	$insert['status']=0;
		    	//查询线路的礼品
		    	$giftArr=$this->user_shop_model->select_rowData('luck_gift_line',array('line_id'=>$line_id));
		    	$id=$this->user_shop_model->insert_gift_data($insert,$line_id);
		    	if(!empty($giftArr['id'])){ //判断线路是否有礼品
		    		$gift=1;
		    	}else{
		    		$gift=0;
		    	}
		    	if($id>0){
		    		echo json_encode(array('status' => 1,'msg' =>'提交成功!','gift'=>$gift,'id'=>$id,'result'=>$insert));
		    		exit;
		    	}else{
		    		echo json_encode(array('status' => -1,'msg' =>'提交成败!','gift'=>$gift));
		    		exit;
		    	} 	
		 }
	}
	//编辑礼品
	function editGift(){
		$gift_id=$this->input->post('id');
		if($gift_id>0){
		    $giftArr=$this->user_shop_model->select_rowData('luck_gift',array('id'=>$gift_id));
		    if(!empty($giftArr)){
		    	echo json_encode(array('status' => 1,'gift'=>$giftArr));
		    }else{
		    	echo json_encode(array('status' => -1,'msg'=>'获取数据失败!'));
		    }
		}else{
		    echo json_encode(array('status' => -1,'msg'=>'获取数据失败!'));
		}
	}
	//上架,下架礼品
	function upGift(){
		$gift_id=$this->input->post('id');
		$status=$this->input->post('status');
		if($gift_id>0){
			$re=$this->user_shop_model->update_rowdata('luck_gift',array('status'=>$status),array('id'=>$gift_id));
			if($re){
				echo json_encode(array('status' => 1,'msg'=>'操作成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
			}
		}else{
			echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
		}
	}
	//删除礼品
	function delLineGift(){
		$gift_id=$this->input->post('id');
		if($gift_id>0){
			$re=$this->user_shop_model->update_rowdata('luck_gift_line',array('status'=>-1),array('id'=>$gift_id));
			if($re){
				echo json_encode(array('status' => 1,'msg'=>'操作成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
			}
		}else{
			echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
		}
	}
	//修改产品标签
	public function lineLabelForm(){
		$id = $this->input->post ( 'id' );//线路id
		echo $id;
		if(is_numeric($id)){
			$linetype = $this->input->post ( 'linetype' );
			$data['linetype']=$linetype;
			$data['modtime'] =date("Y-m-d H:i:s",time());
			$data['ordertime'] =date('Y-m-d H:i:s',strtotime('+7 day'));
			$re=$this->user_shop_model->updata_line_fee($id,$data);

			// 删除线路详情静态文件
			$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$id));
			$this->del_cache($id);
		} 
		echo $id;
	}
	//礼品分页
	public function giftData(){
		$giftlistArr=array();
		$param = $this->getParam(array('status','title','linelistID'));
		$this->load->model ( 'admin/b1/gift_manage_model','gift_manage' );
		$where=' and ( g.status=0 or g.status=1)  ';
		$data  = $this->gift_manage->get_gift_list($param,$where,$this->getPage () );
		echo  $data ;
	}
	//选择礼品
	public function save_gift(){
		$giftId=$this->input->post('luck_gift_id');
		$line_id=$this->input->post('line_id');
		$gift_num=$this->input->post('gift_num');
	
		if(empty($giftId)){
			echo json_encode(array('status' =>-1,'msg' =>'请选择礼品'));
			exit;
		}
		//查询礼品
		$giftArr=$this->user_shop_model->select_rowData('luck_gift_line',array('line_id'=>$line_id));
		if(!empty($giftArr['id'])){ //判断线路是否有礼品
			$gid=1;
		}else{
			$gid=0;
		}
		//插入选中的礼品
		//$re=$this->user_shop_model->sel_gift_data($giftId,$gift_num,$line_id);
		//查询线路礼品
	/* 	if($line_id>0){
			$gift=$this->user_shop_model->get_gift_data($line_id);
		} */
		$where='';
		if($giftId){
			foreach ($giftId as $k=>$v){
				if($k<(count($giftId)-1)){
					$where.='id = '.$v.' or ';
				}else{
					$where.='id = '.$v;
				}
			}
		}
		$gift=$this->user_shop_model->select_data('luck_gift',$where);
		
		if(!empty($gift)){
			echo json_encode(array('status' => 1,'msg' =>'提交成功','gift'=>$gift,'gid'=>$gid,'gift_num'=>$gift_num));
		}else{
			echo json_encode(array('status' =>-1,'msg' =>'提交失败'));
		}
	}
	
   	 //保存礼品
	function save_gift_data(){
		$lineid=$this->input->post('id');
		if($lineid>0){
			$giftId=$this->input->post('giftID');
			$gift_num=$this->input->post('gift_num');
			$re=$this->user_shop_model->sel_gift_data($giftId,$gift_num,$lineid);
			if(!$re){
				echo json_encode(array('status' =>1,'msg' =>'保存成功'));
			}else{
				echo json_encode(array('status' =>-1,'msg' =>'保存失败'));
			}
		}else{
			echo json_encode(array('status' =>-1,'msg' =>'保存失败'));
		}
	
	}
	//上传附件
/*	public function up_file() {
		$config['upload_path']="./file/b1/uploads/".date("Y/m-d");//文件上传目录
		if(!file_exists("./file/b1/uploads/".date("Y/m-d"))){
			mkdir("./file/b1/uploads/".date("Y/m-d"),0777,true);//原图路径
		}
		
		$name_str = $this ->input ->post('filename' ,true);
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
	//	$config['upload_path'] = './file/a/upload/';
		$config['allowed_types'] = 'doc|docx|rar|zip|txt|xls|ppt|pdf|psd|xlsx';
		$config['max_size'] = '40000';
		$file_name = $name_str.'_'.date("YmdHd").time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/b1/uploads/'.date("Y/m-d").'/'.$file_info ['upload_data'] ['file_name'];
			//if(!move_uploaded_file ($url, )){
			echo json_encode(array('status' =>1, 'url' =>$url,'msg' =>'上传成功！' ));
			exit;
			//}
			
		}
	}*/
	//日历价格
	public function getProductPriceJSON(){ 
		$lineId = $this->get("lineId");
// 		$suitId = $this->get("suitId");
// 		$startDate = $this->get("startDate");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId);
		}
		//echo $this->db->last_query();
		echo $productPrice;
	}
	public function switchover_desc(){
		$lineId=$this->input->post('suitId');
		$data['suits'] = $this->user_shop_model->select_rowData('u_line_suit',array('id'=>$lineId));
		echo json_encode($data['suits']);	
	}
	public function delSuit(){
		
		$suitId = $this->get("suitId");
		$productPriceDao = D ( 'Product\ProductPrice' );
		$productPriceDao->deleteProductPriceByPackageId($packageId);
	}
	//删除套餐
	public function deleteSuit(){
		$suitId = $this->input->post("suitId");

		if(intval($suitId)>0){
			$this->db->trans_start();
			
			$this->db->query("INSERT INTO u_line_suit_del SELECT * FROM u_line_suit WHERE id={$suitId}");
			$this->user_shop_model->del_data('u_line_suit',array('id'=>$suitId));
		  //$re=$this->user_shop_model->update_rowdata('u_line_suit',array('is_open'=>0),array('id'=>$suitId));
		    $date=date('Y-m-d',time());
			$this->db->query("INSERT INTO u_line_suit_price_del SELECT * FROM u_line_suit_price WHERE suitid={$suitId} and day>='{$date}' ");
			//echo $this->db->last_query();
			$this->db->query("DELETE FROM u_line_suit_price WHERE suitid={$suitId} and day>='{$date}'");
			//$re=$this->user_shop_model->del_data('u_line_suit_price',array('suitid'=>$suitId));
			//$data=$this->user_shop_model->update_rowdata('u_line_suit_price',array('is_open'=>0),array('suitid'=>$suitId));
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo false;
			}else{
				echo true;
			}
	
		
		}else{
		     echo false;
		}
		//$productPriceDao = D ( 'Product\ProductPrice' );
	//	$productPriceDao->deleteProductPriceByPackageId($packageId);
	}
	//保存套餐
 	public function saveSuit(){
		$prices=$_POST['prices'];
		$suit_arr = json_decode($prices,true);

		$lineId = $this->get("lineId");
		$unit=$this->input->post('unit');
		$lineArr['lineprice']=$this->input->post('lineprice');//促销价
		$lineArr['saveprice']=$this->input->post('saveprice');
		$lineArr['marketprice']=$this->input->post('saveprice')+$lineArr['lineprice'];

		$lineAffil['deposit']=$this->input->post('deposit');//押金
		$lineAffil['before_day']=$this->input->post('before_day');//提前几天交款

		$lineArr['child_description']=$this->input->post('child_description');
		$lineArr['old_description']=$this->input->post('old_description');
		$lineArr['special_description']=$this->input->post('special_description');
		$lineArr['child_nobed_description']=$this->input->post('child_nobed_description');
		// 删除线路详情静态文件
		$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$lineId));
		$this->del_cache($lineId);

		//判断定金是否大于售价
		
		foreach ($suit_arr as $k=>$v){	
            if(!empty($v['data'])){
                foreach ($v['data'] as $key=>$val){
                    if(!empty($val['adultprice'])){
                        if($lineAffil['deposit']>$val['adultprice']){
                            echo json_encode(array('status'=>-1,'msg'=>'定金('.$lineAffil['deposit'].')大于出团日期'.$val['day'].'的成人售价('.$val['adultprice'].')'));
                            exit;
                        } 
                    }else{
                    	 if(!empty($val['childnobedprice']) || !empty($val['adultprice'])){
                    	 	echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$val['day'].'的成人价格不能为空或0'));
                    	 	exit;
                    	 }                       
                    }
                    //佣金不能大于售卖价
                    if(intval($val['agent_rate_int'])>intval($val['adultprice'])){
                        echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$val['day'].'成人价格的管家佣金不能大于售卖价'));
                        exit;
                    }
                    if(!empty($val['childprice'])){
                        if($lineAffil['deposit']>$val['childprice']){
                            echo json_encode(array('status'=>-1,'msg'=>'定金('.$lineAffil['deposit'].')大于出团日期'.$val['day'].'的儿童占床售价('.$val['childprice'].')'));
                            exit;
                        }
                    }
                    //佣金不能大于售卖价
                    if(intval($val['agent_rate_child'])>intval($val['childprice'])){
                        echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$val['day'].'儿童占床价的管家佣金不能大于售卖价'));
                        exit;
                    }
                    if(!empty($val['childnobedprice'])){
                        if($lineAffil['deposit']>$val['childnobedprice']){
                            echo json_encode(array('status'=>-1,'msg'=>'定金('.$lineAffil['deposit'].')大于出团日期'.$val['day'].'的儿童不占床('.$val['childnobedprice'].')'));
                            exit;
                        }            
                    }
                    //佣金不能大于售卖价
                    if(intval($val['agent_rate_childno'])>intval($val['childnobedprice'])){
                        echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$val['day'].'儿童不占床价的管家佣金不能大于售卖价'));
                        exit;
                    
                    }
                  //  var_dump($val['number']);
                    if(intval($val['number'])<0){
                    	echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$val['day'].'余位不能为负数'));
                    	exit;
                    } 
                }      
            }

		}
		//已保存的售价
		$date=date('Y-m-d',time());
		$s_where="lineid = {$lineId} and day >= '{$date}' and is_open=1 ";
		$suitP=$this->user_shop_model->select_data('u_line_suit_price',$s_where);
	    if(!empty($suitP)){
	          foreach ($suitP as $key => $value) {
	          	if(!empty($value['adultprice'])){
					if($lineAffil['deposit']>$value['adultprice']){
						echo json_encode(array('status'=>-1,'msg'=>'定金('.$lineAffil['deposit'].')大于'.$value['day'].'成人售价('.$value['adultprice'].')'));
						exit;
					}
				}

				if(!empty($value['childprice'])){
					if($lineAffil['deposit']>$value['childprice']){
						echo json_encode(array('status'=>-1,'msg'=>'定金('.$lineAffil['deposit'].')大于'.$value['day'].'儿童占床售价('.$value['childprice'].')'));
						exit;
					}
				}

				if(!empty($value['childnobedprice'])){
					if($lineAffil['deposit']>$value['childnobedprice']){
						echo json_encode(array('status'=>-1,'msg'=>'定金('.$lineAffil['deposit'].')大于'.$value['day'].'儿童不占床('.$value['childnobedprice'].')'));
						exit;
					}
				}
			
				/* if(intval($value['number'])<0){
					echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$value['day'].'余位不能为负数'));
					exit;
				} */

	         }
	     }

	    //保存价格套餐	
		$suitId = $this->user_shop_model->saveProductPrice($lineArr,$suit_arr,$lineId,$unit,$lineAffil);
		//var_dump($suitId );exit;
		if($suitId){
			if($suitId=='-1'){
		 	 	 echo json_encode(array('status'=>-1,'msg'=>'保存失败!,团号有重复'));
			}else{
				 echo json_encode(array('status'=>1,'suitId'=>$suitId));	
			}
		}else{
			  echo json_encode(array('status'=>-1,'msg'=>'保存失败'));
		}
	}
	//修改线路库存
	function saveSuitPrice(){
	 	
	 	$prices=$_POST['prices'];
	 	$suit_arr = json_decode($prices,true);
	 	$lineId = $this->get("lineId");
	 	$unit=$this->input->post('unit');
	 	$lineAffil='';
	 	foreach ($suit_arr as $k=>$v){
	 		if(!empty($v['data'])){
	 			foreach ($v['data'] as $key=>$val){
	 				if(isset($val['number'])){
	 					if(intval($val['number'])<0){
	 						echo json_encode(array('status'=>-1,'msg'=>'出团日期'.$val['day'].'余位不能为负数'));
	 						exit;
	 					}	
	 				}	
	 			}
	 		}
	 	}
	 	
	 	$suitId = $this->user_shop_model->saveProductPrice($lineArr='',$suit_arr,$lineId,$unit,$lineAffil);
	 	if($suitId){
	 		echo json_encode(array('status'=>1,'suitId'=>$suitId,'msg'=>'保存成功'));
	 	}else{
	 		echo json_encode(array('status'=>-1,'msg'=>'保存失败'));
	 	}
	 	
	 }
	//获取价格信息
	public function getinputprice(){
		$lineId = $this->get("lineId");
		$suitId = $this->get("suitId");
		$productPrice='';
		if(null!=$suitId && ""!=$suitId){
			$productPrice = $this->user_shop_model->getProductPriceBylineID($lineId,$suitId);
			echo json_encode($productPrice);
		}else{
			echo false;
		}
	}
	//批量修改和插入价格
	public function updataSuitPrice(){
		//修改价格
		$line_id=$this->input->post('line_id');
		$suit_id=$this->input->post('suit_id');
		$startDate=$this->input->post('startDate');
		$suit_name=$this->input->post('suit_name');
		$suit_unit=$this->input->post('suit_unit');
		$people=$this->input->post('people');
		$adult_price=$this->input->post('adult_price',true);
		$chil_price=$this->input->post('chil_price',true);
		$chil_nobedprice=$this->input->post('chil_nobedprice',true);
		$room_fee=$this->input->post('room_fee',true);
		$agent_room_fee=$this->input->post('agent_room_fee',true);
		$agent_rate_childno=$this->input->post('agent_rate_childno',true);
		$typeid=$this->input->post('typeid',true);
		$p_befor_day=$this->input->post('p_befor_day',true);
		$p_hour=$this->input->post('p_hour',true);
		$p_minute=$this->input->post('p_minute',true);
		$agent_rate_int=$this->input->post('agent_rate_int',true);
		$agent_rate_child=$this->input->post('agent_rate_child',true);
		$deposit=$this->input->post('deposit',true); //定金
	    //  var_dump($suit_name);
    	if($typeid=='-1'){
			$suit_name="标准价";
		}  
		if(!empty($startDate)){ //是否填入日期,有则插入或修改

		    	$insertData=array(
		    		'suitname'=>$suit_name,
		    		'lineid'=>$line_id,
		    		'unit'=>$suit_unit,	
		    	);
		    	if($line_id>0){
		    		$suit_id=$suit_id;
		    	}else{
		    		$suit_id=0;
		    	}
		    	$priceArr=array(
		    		'number'=>intval($people),
		    		'adultprice'=>intval($adult_price),
		    		'childprice'=>intval($chil_price),
		    		'childnobedprice'=>intval($chil_nobedprice),
		    		//'oldprice'=>$old_price,
		    		'lineid'=>$line_id,
		    		'before_day'=>intval($p_befor_day),
		    		'hour'=>intval($p_hour),
		    		'minute'=>intval($p_minute),
		    		'agent_rate_int'=>intval($agent_rate_int),
		    		'agent_rate_child'=>intval($agent_rate_child),
		    		'room_fee'=>intval($room_fee),
		    		'agent_room_fee'=>intval($agent_room_fee),
		    		'agent_rate_childno'=>intval($agent_rate_childno),
		    	);
		    	$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$line_id));
		    	if($deposit>$adult_price){
		    	    echo json_encode(array('status'=>-1,'msg'=>'定金不能大于成人售卖价'));
		    	    exit;
		    	}
		    	if(!empty($chil_price)){
		    	    if($deposit>$chil_price){
		    	        echo json_encode(array('status'=>-1,'msg'=>'定金不能大于儿童占床价售卖价'));
		    	        exit;
		    	    }  
		    	}
		    	if(!empty($chil_nobedprice)){
    		    	if($deposit>$chil_nobedprice){
    		    	    echo json_encode(array('status'=>-1,'msg'=>'定金不能大于儿童不占床价售卖价'));
    		    	    exit;
    		    	}
		    	}
		    	if($agent_rate_int>$adult_price){
        			  echo json_encode(array('status'=>-1,'msg'=>'成人价的管家佣金不能大于售卖价'));
        			  exit; 
		    	  
		    	}
		    	if($agent_rate_child>$chil_price){
		  
    			    echo json_encode(array('status'=>-1,'msg'=>'儿童占床价的管家佣金不能大于售卖价'));
    			    exit;
		
		    	}
		    	if($agent_rate_childno>$chil_nobedprice){
		    
    			     echo json_encode(array('status'=>-1,'msg'=>'儿童不占床价的管家佣金不能大于售卖价'));
    			     exit;
		   
		    	}
		    	if(intval($people)<0){
		    		echo json_encode(array('status'=>-1,'msg'=>'余位不能为负数'));
		    		exit;
		    	}
		    	$suit_id=$this->user_shop_model->insert_line_price($insertData,$priceArr,$startDate,$suit_id,$line_id);
		    
		    	if($suit_id>0){
			    	echo json_encode(array('status' =>1,'msg' =>$suit_id));
		    	}else{
		    		if($suit_id==-1){
					      echo json_encode(array('status' => -1,'msg' =>'保存失败!团号有重复'));
					      exit;
		    		}else{
		    			echo json_encode(array('status' => -1,'msg' =>'批量上传出错!'));
					    exit;	
		    		}
		    		
		        } 
		    }else{
		    	echo json_encode(array('status' => -1,'msg' =>'请选择日期!'));
		    	exit;
		    }
		
	}
	//上传图片
	 function up_img(){

	 	$config['upload_path']="./file/b1/account";//文件上传目录
	 	if(!file_exists("./file/b1/account/")){
	 		mkdir("./file/b1/account/",0777,true);//原图路径
	 	}
       	if(!empty($_FILES['upfile']['name'])){
		 	if($_FILES['upfile']['error']==0){
		 		$pathinfo=pathinfo($_FILES["upfile"]['name']);
		 		$extension=$pathinfo['extension'];
		 		$file_url=$config['upload_path'].'/'.date("Ymd").time().".".$extension;
		 		$file_arr=array('gif','jpg','png','jpeg');

		 		if(!in_array($extension, $file_arr)){
		 			echo json_encode(array('code' => -1,'msg' =>'上传格式出错,请选择doc,docx格式的文件'));
		 			exit;
		 		}
		 		if(!move_uploaded_file ($_FILES['upfile']['tmp_name'], $file_url)){
		 			echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
		 			exit;
		 		}else{
		 			$linedoc=substr($file_url,1 );
		 			$linename=$_FILES['upfile']['name'];
		 			echo json_encode(array('code' =>200, 'msg' =>$linedoc));
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
/*	public function update_mainpic(){
		
		$config['upload_path']="./file/b1/images/mainpic/".date("Y/m-d");//文件上传目录
		if(!file_exists("./file/b1/images/mainpic/".date("Y/m-d"))){
			mkdir("./file/b1/images/mainpic/".date("Y/m-d"),0777,true);//原图路径
		}
		
		$name_str = $this ->input ->post('filename' ,true);
	
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));

		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['max_size'] = '40000';
		$file_name = $name_str.'_'.date("YmdHd").time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/b1/images/mainpic/'.date("Y/m-d").'/'.$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));		
		}	
	}*/
	
	//删除图片
	public function del_img(){
		$imgId=$this->input->post('data');
		$prowhere['id']=$imgId;
		$imgdata=$this->user_shop_model->select_data('u_line_pic',$prowhere);	
		if(!empty($imgdata[0])){
			$pic=$this->user_shop_model->select_data('u_line_album',array('id'=>$imgdata[0]['line_album_id']));	
		//	unlink('.'.$pic[0]['filepath']); //删除旧目录下的文件
			$this->user_shop_model->del_imgdata('u_line_album',array('id'=>$imgdata[0]['line_album_id']));
			
		}
		$this->user_shop_model->del_imgdata('u_line_pic',$prowhere);
		echo $imgId;
	}
	//上传文件
	public function up_attachment(){
		$config['upload_path']="./file/b1/uploads/line";//文件上传目录
		if(!file_exists("./file/b1/uploads/line")){
			mkdir("./file/b1/uploads/line",0777,true);//原图路径
		}
		
		if($_FILES['upfile']['error']==0){
			$pathinfo=pathinfo($_FILES["upfile"]['name']);
			$extension=$pathinfo['extension'];
			$file_url=$config['upload_path'].'/'.date("Ymd").time().".".$extension;
			$file_arr=array('doc','docx','xlsx','xls');
		
			if(!in_array($extension, $file_arr)){
				echo json_encode(array('status' => -1,'msg' =>'上传格式出错,请选择doc,docx,xlsx,xls格式的文件'));
				exit;
			}
			if(!move_uploaded_file ($_FILES['upfile']['tmp_name'], $file_url)){
				echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
				exit;
			}else{
				$linedoc=substr($file_url,1 );
				$linename=$_FILES['upfile']['name'];
				echo json_encode(array('status' =>1, 'url' =>$linedoc,'urlname'=>$linename));
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		}
	}
	
	//行程附件
/*	function update_line_file(){
		
		$config['upload_path']="./file/b1/uploads/line";//文件上传目录
		if(!file_exists("./file/b1/uploads/line")){
			mkdir("./file/b1/uploads/line",0777,true);//原图路径
		}

		if($_FILES['line_file_url']['error']==0){
			$pathinfo=pathinfo($_FILES["line_file_url"]['name']);
			$extension=$pathinfo['extension'];
			$file_url=$config['upload_path'].'/'.date("Ymd").time().".".$extension;
			$file_arr=array('doc','docx','xlsx','xls');
		
			if(!in_array($extension, $file_arr)){
				echo json_encode(array('status' => -1,'msg' =>'上传格式出错,请选择doc,docx,xlsx,xls格式的文件'));
				exit;
			}
			if(!move_uploaded_file ($_FILES['line_file_url']['tmp_name'], $file_url)){
				echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
				exit;
			}else{
				$linedoc=substr($file_url,1 );
				$linename=$_FILES['line_file_url']['name'];
				echo json_encode(array('status' =>1, 'url' =>$linedoc,'urlname'=>$linename));
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		} 		
	}*/
	
	//多图片上传的时候的处理程序
/*	function upload_pics(){
		$this->load->helper ( 'url' );
		$config['upload_path'] = './file/b1/images/line/';
		if(!file_exists($config['upload_path'])){
			mkdir($config['upload_path'],0777,true);//原图路径
		}	
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '40000';
		$file_name = 'b1_'.date('Y_m_d', time()).'_'.sprintf('%02d', rand(0,9999));
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			echo json_encode(array('status' => -1,'msg' =>$this->upload->display_errors()));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/b1/images/line/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}*/
	//目的地 、 线路属性的搜索
	public  function search_destination(){
		$name=$this->input->post('name');
		$type=$this->input->post('type');
		$data['type']=$type;
	   	if($type=='destinations'){
			if(!empty($name)){
				$data['linkename'] = $this->user_shop_model->destinations($name);
				if($data['linkename']){
					$data['status']=1;
					echo  json_encode($data);
				}else{
					$data['status']=-2;
					echo  json_encode($data);
				}
			}else{
				$data['status']=0;
				echo  json_encode($data);
			}
	   	}elseif($type=='attr'){
	   	
		   	if(!empty($name)){
		   		$data['linkename'] = $this->user_shop_model->search_atrr($name);
		   		if($data['linkename']){
		   			$data['status']=1;
		   			echo  json_encode($data);
		   		}else{
		   			$data['status']=-2;
		   			echo  json_encode($data);
		   		}
		   	}else{
		   		$data['status']=0;
		   		echo  json_encode($data);
		   	} 
	  	}
	}
	
	//修改标签
	 function update_tab($lineId){
		  $overcity = $this->user_shop_model->select_destinations($lineId);
	      echo   json_encode(array('status'=>1,'data'=>$overcity));
	 }
	 //待审核
	 function updateLineType(){
	 	$lineid=$this->input->post('lineId');
	 	if($lineid>0){
	 		$this->user_shop_model->updateLine(array('status'=>1),$lineid);
	 		echo true;
	 	}else{
	 		echo false;
	 	}
	 }
	 //停售线路
	 function disbuy(){
	 	$lineid=$this->input->post('id',true);
	 	if($lineid>0){
	 		$data=$this->user_shop_model->get_line_online($lineid);
	 	//	echo $this->db->last_query();
	 		if(!empty($data)){
	 			echo   json_encode(array('status'=>-1,'msg'=>'您已停售了!'));
	 			exit;
	 		}
	 		$data=array(
	 			'line_status'=>0,
	 		  	 // 'online_time'=>'',
	 		);
	 		$re=$this->user_shop_model->update_rowdata('u_line',$data,array('id'=>$lineid));
	 		if($re){
	 			echo   json_encode(array('status'=>1,'msg'=>'操作成功!'));
	 		}else{
	 			echo   json_encode(array('status'=>-1,'msg'=>'操作失败!'));
	 		}
	 	}else{
	 		echo   json_encode(array('status'=>-1,'msg'=>'操作失败!'));
	 	}
	 }
	 //复制线路
	 function copy(){
	 	$lineid=$this->input->post('id');
	 	if(is_numeric($lineid)){

	 		$this->db->trans_start();
	 		
			$supplier = $this->getLoginSupplier();
	 		$group=$this->input->post('type');
	 		if($group=='group'){
	 		   	$status=$this->user_shop_model->copy_line($lineid,$group); //包团
	 		}else{
	 			
	 			$group='line';
	 			$status=$this->user_shop_model->copy_line($lineid,$group); //跟团
	 			//添加线路到直属管家
	 			
				$expert=$this->user_shop_model->get_user_shop_select('u_expert',array('supplier_id'=>$supplier['id'],'status'=>2));
				if(!empty($expert)){
					foreach ($expert as $key => $value) {
						$lineApply['line_id']=$status;
						$lineApply['grade']=1;
						$lineApply['addtime']=date('Y-m-d H:i:s');
						$lineApply['modtime']=date('Y-m-d H:i:s');
						$lineApply['expert_id']=$value['id'];
						$lineApply['status']=2;
						$this->user_shop_model->insert_data('u_line_apply',$lineApply);
					}
				}
	 		}
	 		
	 		//操作日志
	 		$url = './application/logs/line_log';
	 		$filename=$url.'/log'.date('Y-m-d').'.txt';
	 		if (!file_exists($url)) {
	 			mkdir($url ,0777 ,true);
	 			
	 		}
	 		if(file_exists($filename)){
	 			file_put_contents($filename, '复制线路ID={'.$status.'}.',FILE_APPEND);		
	 		}else{
	 			$file=fopen($filename, "w");
	 			file_put_contents($filename, '复制线路ID={'.$status.'}.',FILE_APPEND);
	 			fclose($file);
	 		}
	 		
	 		
	 		if($status>0){
	 			//复制线路的出发地
	 		  	$startplace=$this->user_shop_model->copy_startplace($lineid);
	 		   	if(!empty($startplace)){
	 		   		foreach ($startplace as $k=>$v){
	 		   			$startplaceArr[$k]=array(
	 		   				'startplace_id'=>$v['startplace_id'],
	 		   				'line_id'=>$status
	 		   			);
	 		   			$city_id=$this->user_shop_model->insert_data('u_line_startplace',$startplaceArr[$k]);
	 		   		}
	 		  	 }	
	 			//复制目的地
	 		  	$dest=$this->user_shop_model->copy_line_dest($lineid);
	 		   	if(!empty($dest)){
	 		   		foreach ($dest as $k=>$v){
	 		   			$destplaceArr[$k]=array(
	 		   				'dest_id'=>$v['dest_id'],
	 		   				'line_id'=>$status
	 		   			);
	 		   			$this->user_shop_model->insert_data('u_line_dest',$destplaceArr[$k]);
	 		   		}
	 		  	 }
	 		  	 
	 		  	 //复制标签
	 		  	 $line_type=$this->user_shop_model->copy_line_type($lineid);
	 		  	 if(!empty($line_type)){
	 		  	 	foreach ($line_type as $k=>$v){
	 		  	 		$typeArr[$k]=array(
	 		  	 				'attr_id'=>$v['attr_id'],
	 		  	 				'line_id'=>$status
	 		  	 		);
	 		  	 		$this->user_shop_model->insert_data('u_line_type',$typeArr[$k]);
	 		  	 	}
	 		  	 } 
	 		  	 
	 			//复制行程
	 			$rout=$this->user_shop_model->copy_rout($lineid);
	 			if(!empty($rout)){
	 				foreach ($rout as $k=>$v){
	 					$data[$k]=$rout[$k];
	 					$routArr[$k]=array(
 							'lineid'=>$status,
 							'day'=>$rout[$k]['day'],
 							'title'=>$rout[$k]['title'],
 							'breakfirst'=>$rout[$k]['breakfirst'],
 							'breakfirsthas'=>$rout[$k]['breakfirsthas'],
 							'transport'=>$rout[$k]['transport'],
 							'hotel'=>$rout[$k]['hotel'],
 							'jieshao'=>$rout[$k]['jieshao'],
 							'lunchhas'=>$rout[$k]['lunchhas'],
 							'lunch'=>$rout[$k]['lunch'],
 							'supper'=>$rout[$k]['supper'],
 							'supperhas'=>$rout[$k]['supperhas'],
	 					);
	 					$rout_id=$this->user_shop_model->insert_data('u_line_jieshao',$routArr[$k]);
	 					$picArr[$k]=array(
	 						'pic'=>$rout[$k]['pic'],
	 						'jieshao_id'=>$rout_id,
	 						'addtime'=>date('Y-m-d',time()),
	 					);
	 					$this->user_shop_model->insert_data('u_line_jieshao_pic',$picArr[$k]);
	 				}
	 			}
	 			//复制图片
	 			$pic_str=$this->user_shop_model->copy_pic($lineid);
	 			if(!empty($pic_str)){
	 				foreach ($pic_str as $key=>$val){
	 					$pic_id=$this->user_shop_model->insert_data('u_line_album ',array('filepath'=>$val['filepath']));
	 					$this->user_shop_model->insert_data('u_line_pic',array('line_album_id'=>$pic_id,'line_id'=>$status));
	 				}
	 			}	
	 			//管家培训
	 			$train=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineid,'status'=>1));
	 			if(!empty($train)){
	 				foreach ($train as $k=>$v){
	 					$trainArr[$k]=array(
	 						'question'=>$v['question'],
	 						'answer'=>$v['answer'],
	 						'line_id'=>$status,
	 						'status'=>$v['status'],
	 					);
	 					$train_id=$this->user_shop_model->insert_data('u_expert_train',$trainArr[$k]);
	 				}
	 			}
	 			//复制线路保险
	 			$insurance=$this->user_shop_model->get_user_shop_select('u_line_insurance',array('line_id'=>$lineid));
	 			if(!empty($insurance)){
	 				foreach ($insurance as $k=>$v){
	 					$insuranceArr[$k]=array(
	 						'insurance_id'=>$v['insurance_id'],
	 						'line_id'=>$status,
	 						'addtime'=>date("Y-m-d H:i:s",time()),
	 						'status'=>$v['status'],
	 						'isdefault'=>$v['isdefault'],
	 					);
	 					$insurance_id=$this->user_shop_model->insert_data('u_line_insurance',$insuranceArr[$k]);
	 				}
	 			}
	 			//复制线路押金表
	 			$deposit=$this->user_shop_model->copy_deposit($lineid);
	 			if(!empty($deposit)){
	 				foreach ($deposit as $k=>$v) {
	 					$depositArr[$k]=array(
	 						'deposit'=>$v['deposit'],
	 						'before_day'=>$v['before_day'],
	 						'line_id'=>$status
	 					);
	 					$this->user_shop_model->insert_data('u_line_affiliated',$depositArr[$k]);
	 				}
	 			}

	 			//复制联盟审核线路表
				//$union = $this->db->query("select union_id from b_union_approve_line where line_id={$lineid}")->result_array();
	 			$union = $this->db->query("select union_id from b_company_supplier where supplier_id={$supplier['id']} and status=1")->result_array();
				if(!empty($union)){
					foreach ($union as $key => $value) {
						$insert=array(
							'status'=>0,
							'union_id'=>$value['union_id'],
							'supplier_id'=>$supplier['id'],
							'line_id'=>$status,
							'addtime'=>date("Y-m-d H:i:s",time()),
							'modtime'=>date("Y-m-d H:i:s",time()),
						);
						$this->db->insert('b_union_approve_line',$insert);	
					}
				}
				if($group=='group'){ 
					//定制团,指定销售人员
					$package = $this->db->query("select * from u_line_package where line_id={$lineid} ")->result_array();
					if(!empty($package)){
						foreach ($package as $key => $value) {
							$pack_insert=array(
								'line_id'=>$status,
								'depart_id'=>$value['depart_id'],
								'expert_id'=>$value['expert_id'],
								'addtime'=>date("Y-m-d H:i:s",time())
							);
							$this->db->insert('u_line_package',$pack_insert);	
						}
					}
					//指定帮游管家
					$lineApp= $this->db->query("select approve_status,enable,grade,addtime,modtime,line_id,expert_id,status from u_line_apply where line_id={$lineid} ")->result_array();
					if(!empty($lineApp)){
						foreach ($lineApp as $key => $value) {
							$pack_insert=array(
								'line_id'=>$status,
								'approve_status'=>$value['approve_status'],
								'enable'=>$value['enable'],
								'grade'=>$value['grade'],
								'addtime'=>date("Y-m-d H:i:s",time()),
								'modtime'=>date("Y-m-d H:i:s",time()),
								'expert_id'=>$value['expert_id'],
								'status'=>$value['status']
							);
							$this->db->insert('u_line_apply',$pack_insert);	
						}	
					}
				}
				//管家培训
				$train = $this->db->query("select * from u_expert_train where line_id={$lineid} and status=1 ")->result_array();
				if(!empty($train)){
					foreach ($train as $key => $value) {
						$train_insert=array(
							'status'=>0,
							'question'=>$value['question'],
							'answer'=>$value['answer'],
							'line_id'=>$status
						);
						$this->db->insert('u_expert_train',$train_insert);	
					}
				}

				//上车地点u_line_on_car
				$caraddress = $this->db->query("select * from u_line_on_car where line_id={$lineid}")->result_array();
				if(!empty($caraddress)){
					foreach ($caraddress as $key => $value) {
						$car_insert=array(
							'line_id'=>$status,
							'on_car'=>$value['on_car']
						);
						$this->db->insert('u_line_on_car',$car_insert);	
					}
				}

				//u_line_package
 				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					echo  json_encode(array('status'=>-1,'msg'=>'复制线路失败!'));
				}else{
					echo  json_encode(array('status'=>1,'msg'=>'复制线路成功，已自动粘贴至待提交列表，产品编号','lineid'=>$status));
				}
	
	 		}else{
	 			echo  json_encode(array('status'=>-1,'msg'=>'复制线路失败!'));
	 		} 		
	 	}else{
	 	 	echo  json_encode(array('status'=>-1,'msg'=>'复制线路失败!'));
	 	}
	 }
	 //线路目的
	 function get_dest(){
	 	$id=$this->input->post('id');
	 	$dest_three=array();
	 	if(is_numeric($id)){
	 		$dest['two']=$this->user_shop_model->select_dest_data(array('pid'=>$id));
	  		if(!empty($dest['two'])){   //三级目的地
	 			foreach ($dest['two'] as $key=>$val){
	 				$dest_three[$key]=$this->user_shop_model->select_dest_data(array('pid'=>$val['id']));
	 			}
	 		} 
	 	}
	 	echo  json_encode($dest_three);
	 }
     /*线路的出发地*/
	 //获取出发城市
	 public function get_startcity_data () {
	 	$this ->load_model('admin/a/startplace_model' ,'start_model');
	 	$startplace = $this ->start_model ->all(array('isopen' =>1,'level'=>3),'id asc');
	 	echo json_encode($startplace);
	 }

	 //获取分类的图片
	 function  get_classify_pic(){
    	 $id=intval($this->input->post('id'));
    	 $supplier = $this->getLoginSupplier();
    	 if($id>0){
    	 		$where=array(
    	 			'pl.supplier_id'=>$supplier['id'],
    	 			'dest_id'=>$id
    	 		);
    	 		$pic=$this->user_shop_model->get_picture_library($where,0,1);
    	 }else{
    	 		$pic=$this->user_shop_model->get_picture_library(array('supplier_id'=>$supplier['id']),1);
    	 }
    	 echo  json_encode($pic);
	 }
	 //获取相册分类-----------------------------------------
	 function get_product_pic(){
    	 	$supplier = $this->getLoginSupplier();
    		$whereArr = array();
    		$likeArr = array();
    		$page_new = intval($this ->input ->post('page_new'));
    		$page_new = empty($page_new) ? 1: $page_new;
    		$name = trim($this ->input ->post('name' ,true));
    		$consult_type = intval($this ->input ->post('type'));
    		$is = intval($this ->input ->post('is'));
    		$pagesize = intval($this ->input ->post('pagesize'));
    		$pagesize = empty($pagesize) ? self::PAGESIZE :$pagesize;
    		//搜索名称
    		if($consult_type>0){
    			$likeArr ['pl.dest_id'] = $consult_type;
    		}
    		$whereArr['pl.supplier_id']=$supplier['id'];
    		
    		//获取数据
    	 	$list = $this ->user_shop_model ->line_picture_library($whereArr ,$page_new ,$pagesize ,1 ,$likeArr);
    	//	echo $this->db->last_query();
    		$count = $this->getCountNumber($this->db->last_query());
    		//var_dump($count);
    		$page_str = $this ->getAjaxPage($page_new ,$count,16);
    		if($pagesize>=$count){
    			$page_str='';
    		}
    		$data = array(
    			'page_string' =>$page_str,
    			'list' =>$list
    		);
    	
    		echo json_encode($data);
    		exit; 
	 }
	 

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */