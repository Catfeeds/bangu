<?php
/**
 *   @name: api
*    @version: 2.0  
* 	 @author: xml
*    @time: 2017.03.25
*
*
*	 @abstract:
*
*		method = “taobao.item.seller.get”
*		app_key = “0529a16c2faa206931a6272374616b56207a233c”
*		session = “test”	
*		format = “json”
*		v = “2.0”
*		sign_method = “md5”
*/


if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//继承MY_Controller类
class Line extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		
		$this ->load_model('line_model' ,'line_model');
		$this ->load_model('admin/b1/user_shop_model' ,'user_shop_model');
		
		date_default_timezone_set ( 'Asia/Shanghai' );
		//header ( 'Content-type: application/json;charset=utf-8' );
	}
	
	function add(){   
		$key=sha1('supplier30');
		$this->load->view('admin/t33api/addline');
	}
	function edit(){
		$data=array();
		$ky=sha1('supplier30');
		$linecode=$this->input->get('linecode');		
		$lineArr['username']='b1user';
		$lineArr['pwd']='123456';
		$lineArr['linecode']=$linecode;
		$str='username'.$lineArr['username'].'pwd'.$lineArr['pwd'].'linecode'.$lineArr['linecode'];
		$lineArr['sign']=md5($str.$ky);
		$jsonArr=http_build_query($lineArr);
				
		$ch = curl_init ();
		curl_setopt( $ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].'/t33Api/line/get_line_msg');
		curl_setopt ( $ch, CURLOPT_POST, 1);
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonArr);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		$return=json_decode($return);
		 if($return->code==200){
			 $line=$return->data;
			 $line=Array($line);
			 $data['line']=$line[0]->line;
			 $data['rout']=$line[0]->rout;
			 $data['train']=$line[0]->train;
			 $data['price']=$line[0]->price;
		} 
	
		//线路信息接口
		$this->load->view ( 'admin/t33api/editline',$data);

	}
	//线路库存
	function stock(){
		$linecode=$this->input->get('linecode');
		$lineArr['linecode']=$linecode;
		
		$this->load->view ( 'admin/t33api/stockline',$lineArr);
	}


	/* 编辑线路产品 基础信息
	 * @param username:供应商账号，pwd:密码，sign:加密后的串
	* $key=2342sdf345345234342  私钥
	* 签名算法:sha1(MD5((按顺序拼接好的参数名与参数值).$key))
	*/
	function addLine(){
		$ky=sha1('supplier30');
		$username=trim($this->input->post('username',true));
		$lineData=$this->input->post('line',true);
		$train=$this->input->post('train',true);
		$sign=$this->input->post('sign');
	
		//签名验证
		$str='username'.$username;
		if(!empty($lineData)){
			foreach ($lineData as $k=>$v){
				if($k!='mainpic' && $k!='line_img' ){
					$str=$str.$k.$v;
				}
					
			}
		}
		if(!empty($train)){
			foreach ($train as $k=>$v){
				foreach ($v as $key=>$val){
					$str=$str.$key.$val;
				}
			}
		}
	
	 
		//写入参数日志
		$this->write_log("addLine{".$str.$sign."}");
		$falg=true;	
		if($falg){ //操作数据库数据
	
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
			$username=$this->filter_str($username);
			$supplierData = $this->supplier_model ->get_supplier_msg(array('login_name'=>$username));
			if(!empty($supplierData[0])){
	
				$supplier_id=$supplierData[0]['id'];
				
				//过滤参数
				$lineData['linename']=$this->filter_str($lineData['linename']);
				$lineData['features']=$this->filter_str($lineData['features']);
				$lineData['linetitle']=$this->filter_str($lineData['linetitle']);
				$lineData['lineday']=intval($lineData['lineday']);
				$lineData['startcity']=$this->filter_str($lineData['startcity']);
				$lineData['overcity']=$this->filter_str($lineData['overcity']);
				
				if(empty($lineData['linename'])){echo json_encode(array('code'=>4000,'msg'=>'线路名称不能为空!'));exit;}
				if(empty($lineData['features'])){echo json_encode(array('code'=>4000,'msg'=>'线路特色为空!'));exit;}
				if(empty($lineData['linetitle'])){echo json_encode(array('code'=>4000,'msg'=>'线路副标题不能为空!'));exit;}
				if(empty($lineData['lineday'])){echo json_encode(array('code'=>4000,'msg'=>'线路出游天数不能为空!'));exit;}
				if(empty($lineData['mainpic'])){echo json_encode(array('code'=>4000,'msg'=>'线路主图片不能为空!'));exit;}
				if(empty($lineData['startcity'])){echo json_encode(array('code'=>4000,'msg'=>'出发城市不能为空!'));exit;}
				if(empty($lineData['overcity'])){echo json_encode(array('code'=>4000,'msg'=>'目的地不能为空!'));exit;}
				if(empty($lineData['feeinclude'])){echo json_encode(array('code'=>4000,'msg'=>'费用包含不能为空!'));exit;}
				if(empty($lineData['feenotinclude'])){echo json_encode(array('code'=>4000,'msg'=>'费用包含不能为空!'));exit;}
				if(empty($lineData['beizu'])){echo json_encode(array('code'=>4000,'msg'=>'温馨提示不能为空!'));exit;}
				if(empty($lineData['special_appointment'])){echo json_encode(array('code'=>4000,'msg'=>'特别约定不能为空!'));exit;}
				if(empty($lineData['safe_alert'])){echo json_encode(array('code'=>4000,'msg'=>'安全提示不能为空!'));exit;}
					
				$sb_munber=mb_strlen($lineData['linename'])+mb_strlen($lineData['linetitle']);
				if($sb_munber>40){echo json_encode(array('code'=>4000,'msg'=>'线路名称+副标题总字数不超过40个字!'));exit;}
					
				if(isset($lineData['linenight'])){
					$lineArr['linenight']=intval($lineData['linenight']);
				}else{
					$lineArr['linenight']=0;
				}
				//线路主表
				$lineArr['line_classify']=$lineData['line_classify'];  //线路类型
				$lineArr['supplier_id']=$supplierData[0]['id'];
				$lineArr['linename']=$supplierData[0]['brand'].' · '.$lineData['linename'].$lineArr['linenight'].'晚'.$lineData['lineday'].'天游';
				$lineArr['lineprename']=$lineData['linename'];  //线路名称
				$lineArr['lineday']=intval($lineData['lineday']);  //出游天数
				$lineArr['linetitle']=$lineData['linetitle'];  //线路副标题
				$lineArr['features']=$lineData['features'];  //线路特色
	
				if(isset($lineData['themeid'])){
					$lineArr['themeid']=$lineData['themeid'];
				}
				if(isset($lineData['linebefore'])){
					$lineArr['linebefore']=intval($lineData['linebefore']);
				}
					
				$lineArr['addtime']=date("Y-m-d H:i:s",time());
				$lineArr['modtime']=date("Y-m-d H:i:s",time());
				$lineArr['ordertime']=date("Y-m-d H:i:s",time());
				$lineArr['status']=0;
					
				$lineArr['feeinclude']=$lineData['feeinclude'];
				$lineArr['feenotinclude']=$lineData['feenotinclude'];
	
				if(isset($lineData['other_project'])){
					$lineArr['other_project']=$lineData['other_project'];
				}
				if(isset($lineData['insurance'])){
					$lineArr['insurance']=$lineData['insurance'];
				}
				if(isset($lineData['visa_content'])){
					$lineArr['visa_content']=$lineData['visa_content'];
				}
				if(isset($lineData['beizu'])){
					$lineArr['beizu']=$lineData['beizu'];
				}
				if(isset($lineData['special_appointment'])){
					$lineArr['special_appointment']=$lineData['special_appointment'];
				}
				if(isset($lineData['safe_alert'])){
					$lineArr['safe_alert']=$lineData['safe_alert'];
				}
	
				//产品标签
				if(!empty($lineData['linetype'])){
					$linetype=$lineData['linetype'];
				}
					
				//echo json_encode(array('code'=>123,'msg'=>$lineData['mainpic']));exit;
				//主图片
				if(!empty($lineData['mainpic'])){
					$lineData['mainpic']=$this->get_pic_str($lineData['mainpic']);
					if(empty($lineData['mainpic'])){
						echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
					}
	
					if(empty($lineData['mainpic'])){
						echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
					}
	
					if(empty($lineData['mainpic'])){
						echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
					}
	
					$path = "/file/b1/uploads/images/";
					$mainpic=$this->get_upload_pimg($path,$lineData['mainpic']);
					$picArr=json_decode($mainpic);
					if($picArr->code=='200'){
						$lineArr['mainpic']=$picArr->url;
					}
				}else{
					echo json_encode(array('code'=>4000,'msg'=>'主图片不能为空'));exit;
				}
	
				//验证
				if($lineArr['line_classify']=='1'){
					$classify=2;
				}else if($lineArr['line_classify']=='2'){
					$classify=1;
				}else if($lineArr['line_classify']=='3'){
					$classify=3;
				}else{
					echo json_encode(array('code'=>4000,'msg'=>'线路类型不能为空!'));exit;
				}
	
				//线路副表
				if(isset($lineData['hour'])){  //几时
					$lineAffil['hour']=intval($lineData['hour']);
				}
				if(isset($lineData['minute'])){  //几分
					$lineAffil['minute']=intval($lineData['minute']);
				}
	
					
				$startcity=$lineData['startcity'];
				$overcity=$lineData['overcity'];
				if(!empty($lineData['car_address'])){
					$car_address=$lineData['car_address'];
					$car_address=$this->security->xss_clean($car_address);
				}
					
				//过滤
				$startcity = $this->security->xss_clean($startcity);
				$overcity = $this->security->xss_clean($overcity);
				$lineArr = $this->security->xss_clean($lineArr);
				if(isset($lineAffil)){
					$lineAffil=$this->security->xss_clean($lineAffil);
				}
	
				$train=$this->security->xss_clean($train);//管家培训
				//提交产品
				//-------------------------添加产品-----------------------------
				$this->db->trans_start();
					
				//线路主表
				$line_id=$this->user_shop_model->insert_data('u_line',$lineArr);
				//产生线路编号
				$this->user_shop_model->linecodeupdate($line_id);
					
				//线路附属表
				$lineAffil['line_id']=$line_id;
				$this->line_model->insert_data('u_line_affiliated',$lineAffil);
					
				//出发城市表
				if(!empty($startcity)){
					$cityArr=explode(',', $startcity);
					foreach ($cityArr as $k=>$v){
						$city=$this->line_model->select_rowData('u_startplace',array('cityname'=>trim($v)));
						if(!empty($city['id'])){
							$this->line_model->insert_data('u_line_startplace',array('line_id'=>$line_id,'startplace_id'=>$city['id']));
						}else{
							echo json_encode(array('code'=>4000,'msg'=>'该出发城市('.$v.')不存在!'));exit;
						}
					}
				}
	
				//目的地表
				$lovercity2=array();
				$lovercity='';
				if(!empty($overcity)){
					$overcityPArr=explode(',', $overcity);
					foreach ($overcityPArr as $k=>$v){
						$dest=$this->line_model->select_rowData('u_dest_base',array('kindname'=>trim($v)));
						if(!empty($dest['id'])){
							$lovercity2[]=$dest['id'];
							if(!empty($dest['list'])){
								$lovercity=$lovercity.$dest['list'].$dest['id'].',';
							}else{
								echo json_encode(array('code'=>4000,'msg'=>'该目的地('.$v.')没有上一级分类'));exit;
								$lovercity=$lovercity.','.$dest['id'].',';
							}
						}else{
							echo json_encode(array('code'=>4000,'msg'=>'该目的地('.$v.')不存在!'));exit;
						}
						//判断目的地与线路类型是否对上
						$de_list=explode(',', $dest['list']);
						if (!in_array($classify, $de_list)){
							echo json_encode(array('code'=>4000,'msg'=>'该目的与线路类型对不上!'));exit;
						}
					}
				}
					
				//目的地所有父类
				$bourn=array();
				$overcityArr=array();
				if(!empty($lovercity)){
					$overcity2=implode(',', $lovercity2);//选中目的地
					$overcityArr=explode(",",$lovercity);
					$overcityArr=array_unique($overcityArr);
					$overcitystr=implode(',', $overcityArr);//目的地所有级别
	
					foreach ($overcityArr as $k=>$v){
						if(!empty($v)){
							$dest_str=$this->user_shop_model->get_user_shop_select('u_dest_base',array('id'=>$v,'level'=>2));
	
							if(!empty($dest_str[0]['id'])){
								$bourn[]=$dest_str[0]['id'];
							}
							$dest_id=$this->user_shop_model->insert_data('u_line_dest',array('line_id'=>$line_id,'dest_id'=>$v));
						}
					}
				}
	
				//产品标签
				$attrstr='';
				if(!empty($linetype)){
					$linetypeArr=explode(",",$linetype);
					foreach ($linetypeArr as $k=>$v){
						$attr=$this->line_model->select_rowData('u_line_attr',array('attrname'=>trim($v)));
						if(!empty($attr['id'])){
							if(empty($attrstr)){
								$attrstr=$attr['id'];
							}else{
								$attrstr=$attrstr.','.$attr['id'];
							}
							$this->user_shop_model->insert_data('u_line_type',array('attr_id'=>$attr['id'],'line_id'=>$line_id));
							$sql= $this->db->last_query();
						}
					}
				}
	
				if(!empty($attrstr)){
					$linewhere['linetype']=$attrstr;
				}
				$linewhere['overcity2']=$overcity2;
				$linewhere['overcity']=$overcitystr;
				$this->line_model->update($linewhere,array('id'=>$line_id));
	
	
				//线路图片
				 
				if(!empty($lineData['line_img'])){
						
					$path = "/file/b1/uploads/images/";
					$i=0;
					foreach ($lineData['line_img'] as $key => $val ) {
						$pics='';
						$fx_pic='';
						$i += 1;
						if ($i < 5) {
							if (!empty($val)) {
	
								$val=$this->get_pic_str($val);
								if(empty($val)){
									echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
								}
	
								$fx_pic=$this->get_upload_pimg($path,$val);
								$pics=json_decode($fx_pic);
									
								if($pics->code=='200'){
									if(!empty($pics)){
										$datas['filepath']=$pics->url;
										$datas['filename']='line';
	
										$this->line_model->insert_data('u_line_album',$datas);//插入图片表
										$reid=  $this->db->insert_id();
											
										$re['line_id']=$line_id;
										$re['line_album_id']=$reid;
										$this->line_model->insert_data('u_line_pic',$re);//插入图片表
									}
								}
									
							}
						}else{
							echo json_encode(array('code'=>4000,'msg'=>'上传的图片已超过限制数量'));exit;
						}
					}
				}
				//主图片
				if(!empty($lineArr['mainpic'])){
					$p_d['filename']='line';
					$p_d['filepath']=$lineArr['mainpic'];
					$this->line_model->insert_data('u_line_album',$p_d);//插入图片表
					$p_id=  $this->db->insert_id();
	
					$p_re['line_id']=$line_id;
					$p_re['line_album_id']=$p_id;
					$this->line_model->insert_data('u_line_pic',$p_re);//插入图片表
				}
	
				//上车地点
				if(!empty($car_address)){
					$car_addressArr=explode(',', $car_address);
					foreach ($car_addressArr as $k=>$v){
						$carArr=array(
								'line_id'=>$line_id,
								'on_car'=>$v
						);
						$this->user_shop_model->insert_data('u_line_on_car',$carArr);
					}
				}
	
	
				//保存二级目的地的线路图片库
				if(!empty($bourn)){
					$bourntwo=array_unique($bourn);
					if(!empty($line_pics_arr)){
						$repic=$this->user_shop_model->insert_pic_library($bourntwo,$line_pics_arr,$supplier_id);
					}
				}
	
				//联盟审核线路表
				$union = $this->db->query("select union_id from b_company_supplier where supplier_id={$supplier_id} and status=1")->result_array();
				if(!empty($union)){
					foreach ($union as $key => $value) {
						$insert=array(
								'status'=>0,
								'union_id'=>$value['union_id'],
								'supplier_id'=>$supplier_id,
								'line_id'=>$line_id,
								'addtime'=>date("Y-m-d H:i:s",time()),
								'modtime'=>date("Y-m-d H:i:s",time()),
						);
						$this->db->insert('b_union_approve_line',$insert);
					}
				}
	
				//添加线路到直属管家
				$expert=$this->user_shop_model->get_user_shop_select('u_expert',array('supplier_id'=>$supplier_id,'status'=>2));
				if(!empty($expert)){
					foreach ($expert as $key => $value) {
						$lineApply['line_id']=$line_id;
						$lineApply['grade']=1;
						$lineApply['addtime']=date('Y-m-d H:i:s');
						$lineApply['modtime']=date('Y-m-d H:i:s');
						$lineApply['expert_id']=$value['id'];
						$lineApply['status']=2;
						$this->user_shop_model->insert_data('u_line_apply',$lineApply);
					}
				}
	
				//管家培训
				if(!empty($train)){
					foreach ($train as $key=>$val){
						$trainArr['question']=$val['question'];
						$trainArr['answer']=$val['answer'];
						$trainArr['line_id']=$line_id;
						$trainArr['status']=1;
						$this->user_shop_model->insert_data('u_expert_train',$trainArr);
					}
				}
	
				//行程
				$this->get_line_rout($route,$line['id'],$line['lineday']);

				//价格设置
				$suit = $this->user_shop_model->save_price_api($price,$linepriceArr,$linepriceAffil,$line);	
	
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					echo json_encode(array('code'=>4000,'msg'=>'添加失败'));
				}else{
					$line=$this->user_shop_model->select_rowData('u_line',array('id'=>$line_id));
					if(!empty($line)){
						$lineDataArr=array(
								'linecode'=>$line['linecode'],
								'linename'=>$line['linename'],
								'linenight'=>$line['linenight'],
								'lineday'=>$line['lineday'],
								'linetitle'=>$line['linetitle'],
						);
						echo json_encode(array('code'=>200,'msg'=>'添加成功','linecode'=>$lineDataArr));
					}else{
						echo json_encode(array('code'=>4000,'msg'=>'添加失败'));
					}
				}
	
			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));
			}
	
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名验证失败'));
		}
	
	}
	
	
	/* 添加产品
	 * @param username:供应商账号，pwd:密码，sign:加密后的串
	 * $key=2342sdf345345234342  私钥
	 * 签名算法:sha1(MD5((按顺序拼接好的参数名与参数值).$key))
	 * 
	 * 
	 */
	function editLine(){
		//验证登录名
		$ky=sha1('supplier30');	
	
		$username=trim($this->input->post('username',true));
		$pwd=trim($this->input->post('pwd',true));
		$lineData=$this->input->post('line',true);
		$sign=$this->input->post('sign',true);
		$train=$this->input->post('train',true);
	
		//签名验证	
		$str='username'.$username.'pwd'.$pwd;
		if(!empty($lineData)){
			foreach ($lineData as $k=>$v){
				if($k!='mainpic' && $k!='line_img'){
					$str=$str.$k.$v;
				}
				
			}
		}	 
		if(!empty($train)){
			foreach ($train as $k=>$v){
				foreach ($v as $key=>$val){
					$str=$str.$key.$val;
				}
			}
		}
		//写入参数日志
		$this->write_log("editLine{".$str.$sign."}");
		$falg=true;
		/* if($sign==md5($str.$ky)){
			$falg=true;
		}else{
			$falg=false;
		}
		 */
		if($falg){ //操作数据库数据
		
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
			$username=addslashes($this->input->post('username',true));
			$pwd=addslashes($this->input->post('pwd',true));
			$supplierData = $this->supplier_model ->get_supplier_msg(array('login_name'=>$username));
			if(!empty($supplierData[0])){
			
					if(empty($lineData['linecode'])){
						echo json_encode(array('code'=>4000,'msg'=>'线路编号不能为空'));exit;
					}else{
						$linecode=$lineData['linecode'];
					}
					$lineData['linename']=$this->filter_str($lineData['linename']);
					$lineData['lineday']=intval($lineData['lineday']);
					$lineData['linenight']=intval($lineData['linenight']);
					$lineData['linetitle']=$this->filter_str($lineData['linetitle']);
					$lineData['features']=$lineData['features'];
					//线路主表
					//$lineArr['line_classify']=$lineData['line_classify'];
					$lineArr['supplier_id']=$supplierData[0]['id'];
				   
					if(empty($lineData['linename'])){echo json_encode(array('code'=>4000,'msg'=>'线路名称不能为空!'));exit;}
					if(empty($lineData['lineday'])){echo json_encode(array('code'=>4000,'msg'=>'线路出游天数不能为空!'));exit;}
					if(empty($lineData['linetitle'])){echo json_encode(array('code'=>4000,'msg'=>'线路副标题不能为空!'));exit;}
					if(empty($lineData['features'])){echo json_encode(array('code'=>4000,'msg'=>'线路特色不能为空!'));exit;}
					if(empty($lineData['mainpic'])){echo json_encode(array('code'=>4000,'msg'=>'线路主图片!'));exit;}

					$sb_munber=mb_strlen($lineData['linename'])+mb_strlen($lineData['linetitle']);
					if($sb_munber>40){echo json_encode(array('code'=>4000,'msg'=>'线路名称+副标题总字数不超过40个字!'));exit;}
						
					$lineArr['linename']=$supplierData[0]['brand'].' · '.$lineData['linename'].$lineData['linenight'].'晚'.$lineData['lineday'].'天游';
					$lineArr['lineprename']=$lineData['linename'];

					if(isset($lineData['linenight'])){
						$lineArr['linenight']=$lineData['linenight'];
					}
					
					$lineArr['lineday']=$lineData['lineday'];	
					$lineArr['linetitle']=$lineData['linetitle'];
					
					//线路主题
					if(!empty($lineData['themeid'])){
						$lineArr['themeid']=$this->filter_str($lineData['themeid']);
						$themeArr=$this->line_model->select_rowData('u_theme',array('name'=>trim($lineArr['themeid'])));
						$sql=$this->db->last_query();
	                     if(!empty($themeArr)){
	                     	$lineArr['themeid']=$themeArr['id'];
	                     }else{
	                     	echo json_encode(array('code'=>4000,'msg'=>'该主题游不存在'));exit;
	                     }
					}
				
				    if(isset($lineData['linebefore'])){
				    	$lineArr['linebefore']=intval($lineData['linebefore']);
				    }
					
					$lineArr['features']=$lineData['features'];		
					$lineArr['mainpic']=$lineData['mainpic'];
				
					$lineArr['modtime']=date("Y-m-d H:i:s",time());
					$lineArr['ordertime']=date('Y-m-d H:i:s',strtotime('+7 day'));
					$lineArr['status']=0; 
					if(isset($lineData['feeinclude'])){
						if(empty($lineData['feeinclude'])){
							echo json_encode(array('code'=>4000,'msg'=>'费用包含说明不能为空'));exit;
						}
						$lineArr['feeinclude']=$lineData['feeinclude']; //费用包含
					}
				    if(isset($lineData['feenotinclude'])){
				    	if(empty($lineData['feenotinclude'])){
				    		echo json_encode(array('code'=>4000,'msg'=>'费用不包含说明不能为空'));exit;
				    	}
				    	$lineArr['feenotinclude']=$lineData['feenotinclude'];//费用不包含
				    }
					if(isset($lineData['other_project'])){
						$lineArr['other_project']=$lineData['other_project']; //购物自费
					}
					if(isset($lineData['insurance'])){
						$lineArr['insurance']=$lineData['insurance']; //保险说明
					}
				    if(isset($lineData['visa_content'])){
				    	$lineArr['visa_content']=$lineData['visa_content'];//签证说明
				    }  
				    if(isset($lineData['beizu'])){
				    	if(empty($lineData['beizu'])){
				    		echo json_encode(array('code'=>4000,'msg'=>'温馨提示说明不能为空'));exit;
				    	}
				    	$lineArr['beizu']=$lineData['beizu'];  //备注
				    }
					if(isset($lineData['safe_alert'])){
						if(empty($lineData['safe_alert'])){
							echo json_encode(array('code'=>4000,'msg'=>'安全提示说明不能为空'));exit;
						}
						$lineArr['safe_alert']=$lineData['safe_alert'];  //安全提示
					}
					if(isset($lineData['special_appointment'])){
						if(empty($lineData['special_appointment'])){
							echo json_encode(array('code'=>4000,'msg'=>'特别约定说明不能为空'));exit;
						}
						$lineArr['special_appointment']=$lineData['special_appointment'];  //特别约定
					}
			//		if(empty($lineArr['line_classify'])){echo json_encode(array('code'=>4000,'msg'=>'线路类型不能为空!'));exit;}
					if(empty($lineArr['supplier_id'])){echo json_encode(array('code'=>4000,'msg'=>'供应商识别不了!'));exit;}
							
					//上车地点
					if(isset($lineData['car_address'])){
						$car_address=$lineData['car_address'];
						$car_address=$this->security->xss_clean($car_address);
					}
						
					//产品标签
					if(isset($lineData['linetype'])){
						$linetype=$lineData['linetype'];
						$linetype=$this->security->xss_clean($linetype);
					}
					
					//主图片
					if(!empty($lineData['mainpic'])){
						$lineData['mainpic']=$this->get_pic_str($lineData['mainpic']);
						if(empty($lineData['mainpic'])){
							echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
						}
						
					 	$path = "/file/b1/uploads/images/";
						$mainpic=$this->get_upload_pimg($path,$lineData['mainpic']);
						$picArr=json_decode($mainpic);
						if($picArr->code=='200'){
							$lineArr['mainpic']=$picArr->url;
						}		
					}
					
					//线路副表
					if(isset($lineData['hour'])){
						$lineAffil['hour']=intval($lineData['hour']);
					}
					if(isset($lineData['minute'])){
						$lineAffil['minute']=intval($lineData['minute']);
					}
					
					//出发地
                    if(isset($lineData['startcity'])){
                    	if(empty($lineData['startcity'])){echo json_encode(array('code'=>4000,'msg'=>'出发城市不能为空'));exit;}
                    	$startcity=$lineData['startcity'];
                    	$startcity=$this->security->xss_clean($startcity);
                    }
                   
                    //目的地
					if(isset($lineData['overcity'])){
						if(empty($lineData['overcity'])){echo json_encode(array('code'=>4000,'msg'=>'目的地不能不为空'));exit;}
						$overcity=$lineData['overcity'];
						$overcity=$this->security->xss_clean($overcity);
					}
					
					//过滤
					if(!empty($lineArr)){
						$lineArr = $this->security->xss_clean($lineArr);
					}
					if(!empty($lineAffil)){
						$lineAffil=$this->security->xss_clean($lineAffil);
					}
				
					$train=$this->security->xss_clean($train);
					//线路
					$dataArr=$this->line_model->select_rowData('u_line',array('linecode'=>$linecode));
				
					//提交产品
					if(!empty($dataArr['id'])){  //-------------------------添加产品-----------------------------
						$this->db->trans_start();
						$line_id=$dataArr['id'];
						//线路类型
						if($dataArr['line_classify']=='1'){
							$classify=2;
						}elseif ($dataArr['line_classify']=='2'){
							$classify=1;
						}else if($dataArr['line_classify']=='3'){
							$classify=3;
						}else{
							$classify=0;
						}							
						
						//线路附属表
						$lineAffil['line_id']=$line_id;
						$this->user_shop_model->update_rowdata('u_line_affiliated',$lineAffil,array('line_id'=>$line_id));
					
						//出发城市表	
						if(!empty($startcity)){
							$this->db->where(array('line_id'=>$line_id))->delete('u_line_startplace');
							$cityArr=explode(',', $startcity);
							foreach ($cityArr as $k=>$v){
								$city=$this->line_model->select_rowData('u_startplace',array('cityname'=>trim($v)));
								if(!empty($city['id'])){
									$this->line_model->insert_data('u_line_startplace',array('line_id'=>$line_id,'startplace_id'=>$city['id']));
											
								}else{
									echo json_encode(array('code'=>4000,'msg'=>'该出发地('.$v.')不存在!'));exit;
								}
							}
						}
						
						//目的地表
						$lovercity2=array();
						$lovercity='';
						if(!empty($overcity)){				
							$overcityPArr=explode(',', $overcity);
							foreach ($overcityPArr as $k=>$v){
								$dest=$this->line_model->select_rowData('u_dest_base',array('kindname'=>trim($v)));
								if(!empty($dest['id'])){
									$lovercity2[]=$dest['id'];
									if(!empty($dest['list'])){
										$lovercity=$lovercity.$dest['list'].$dest['id'].',';
									}else{
										echo json_encode(array('code'=>4000,'msg'=>'该目的地('.$v.')没有上一级分类'));exit;
									}
								
								}else{									
										echo json_encode(array('code'=>4000,'msg'=>'该目的地('.$v.')不存在!'));exit;		
								}
								//判断目的地与线路类型是否对上
								$de_list=explode(',', $dest['list']);
								if (!in_array($classify, $de_list)){
									echo json_encode(array('code'=>4000,'msg'=>'该目的与线路类型对不上!'));exit;
								}
							}
						}
					
						//目的地所有父类
						$bourn=array();
						$overcityArr=array();
						if(!empty($lovercity)){
							$this->db->where(array('line_id'=>$line_id))->delete('u_line_dest');
							$overcity2=implode(',', $lovercity2);//选中目的地
							$overcityArr=explode(",",$lovercity);
							$overcityArr=array_unique($overcityArr);
							$overcitystr=implode(',', $overcityArr);//目的地所有级别
							foreach ($overcityArr as $k=>$v){
								$dest_id=$this->line_model->insert_data('u_line_dest',array('line_id'=>$line_id,'dest_id'=>$v));
							}
						}
						if(!empty($overcity2)){
							$lineArr['overcity2']=$overcity2;
						}
						if(!empty($overcitystr)){
							$lineArr['overcity']=$overcitystr;
						}
						
					
						
						//线路图片					 
						if(!empty($lineData['line_img'])){					
							$path = "/file/b1/uploads/images/";
							$i=0;
							//删掉之前的主图片
							$filepic=$this->user_shop_model->get_user_shop_select('u_line_pic',array('line_id'=>$line_id));
								
							if(!empty($filepic)){
								foreach ($filepic as $k=>$v){
									$this->db->where(array('id'=>$v['id']))->delete('u_line_pic');
									$this->db->where(array('id'=>$v['line_album_id']))->delete('u_line_album');
								}
							}
							foreach ($lineData['line_img'] as $key => $val ) {								
								$pics='';
								$fx_pic='';
								$i += 1;
								if ($i < 5) {
									if (!empty($val)) {
										$val=$this->get_pic_str($val);
										if(empty($val)){
											echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
										}
										$fx_pic=$this->get_upload_pimg($path,$val);
										$pics=json_decode($fx_pic);
											
										if($pics->code=='200'){
											if(!empty($pics)){
												 $datas['filepath']=$pics->url;
												//$datas['filepath']=$val;
												$datas['filename']='line';
						
												$this->line_model->insert_data('u_line_album',$datas);//插入图片表
												$reid=  $this->db->insert_id();
										 		
												$re['line_id']=$line_id;
												$re['line_album_id']=$reid;
												$this->line_model->insert_data('u_line_pic',$re);//插入图片表
													
											}
										}
											
									  }
								}else{
									echo json_encode(array('code'=>4000,'msg'=>'上传的图片已超过限制数量'));exit;
								}
							}	
						}
						
						
						//主图片
						if(!empty($lineArr['mainpic'])){
							//删掉之前的主图片
							$file=$this->line_model->select_rowData('u_line_album',array('filepath'=>trim($dataArr['mainpic'])));
							//$sql= $this->db->last_query();
							if(!empty($file)){
								$this->db->where(array('line_id'=>$line_id,'line_album_id'=>$file['id']))->delete('u_line_pic');
								$this->db->where(array('id'=>$file['id']))->delete('u_line_album');
							}
							//echo json_encode(array('code'=>4000,'msg'=>$sql));exit;
							$p_d['filename']='line';
							$p_d['filepath']=$lineArr['mainpic'];
							$this->line_model->insert_data('u_line_album',$p_d);//插入图片表
							$p_id=  $this->db->insert_id();
						
							$p_re['line_id']=$line_id;
							$p_re['line_album_id']=$p_id;
							$this->line_model->insert_data('u_line_pic',$p_re);//插入图片表
						}

						//上车地点
						if(!empty($car_address)){
							$car_addressArr=explode(',', $car_address);
							$this->db->where(array('line_id'=>$line_id))->delete('u_line_on_car');
							foreach ($car_addressArr as $k=>$v){		
								$carArr=array(
										'line_id'=>$line_id,
										'on_car'=>$v
								);
								$this->line_model->insert_data('u_line_on_car',$carArr);
							}
						}
						
						//产品标签
						$attrstr='';
						if(!empty($linetype)){
							$this->db->where(array('line_id'=>$line_id))->delete('u_line_type');
							$linetypeArr=explode(",",$linetype);
							foreach ($linetypeArr as $k=>$v){
								$attr=$this->line_model->select_rowData('u_line_attr',array('attrname'=>trim($v)));
								if(!empty($attr['id'])){
									if(empty($attrstr)){
										$attrstr=$attr['id'];
									}else{
										$attrstr=$attrstr.','.$attr['id'];
									}
									$this->user_shop_model->insert_data('u_line_type',array('attr_id'=>$attr['id'],'line_id'=>$line_id));
								}else{
									echo json_encode(array('code'=>4000,'msg'=>"产品标签{$v}不存在!"));exit;
								}
							}
						}
						if(!empty($attrstr)){
							$lineArr['linetype']=$attrstr;
						}
					
						//----------------------------修改线路主表----------------------------------------
						if(!empty($lineArr)){
							$this->user_shop_model->update_rowdata('u_line',$lineArr,array('id'=>$line_id));
						}
						
						
						//管家培训
						if(!empty($train)){
							foreach ($train as $key=>$val){

								$trainArr['question']=$val['question'];
								$trainArr['answer']=$val['answer'];
								$trainArr['line_id']=$line_id;
								$trainArr['status']=$val['status'];	
								
								if(!empty($val['id'])){
									$this->user_shop_model->update_rowdata('u_expert_train',$trainArr,array('line_id'=>$line_id,'id'=>$val['id']));
								}else{
									$this->user_shop_model->insert_data('u_expert_train',$trainArr);
								}	
							}
						}
						
						$this->db->trans_complete();
						if ($this->db->trans_status() === FALSE)
						{
							echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));
						}else{
							echo json_encode(array('code'=>200,'msg'=>'修改成功','linecoede'=>$linecode));
						}
						 
					}else{  //-------------------------------编辑线路-----------------------------
							
						echo json_encode(array('code'=>4000,'msg'=>'线路编号不存在'));
					}
			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));
			}
		
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名验证失败'));
		}
       
	}


	/**
	 * @method 添加编辑行程 操作数据
	 * @author xml
	 */
	function get_line_rout($route,$line_id,$lineday){
		
		if(count($route)<=$lineday){
			foreach ($route as $k=>$v){
		
				unset($picArr);
				$v['day']=intval($v['day']);
				if($v['day']>$lineday){
					echo json_encode(array('code'=>4000,'msg'=>'行程天数不能大于出游天数'));exit;
				}else{
					
					if(0<$v['day']){
						if(empty($v['title'])){echo json_encode(array('code'=>4000,'msg'=>'行程标题不能为空'));exit;}
						if(empty($v['jieshao'])){echo json_encode(array('code'=>4000,'msg'=>'行程内容不能为空'));exit;}
						//行程介绍
						$jieshao=$this->user_shop_model->select_rowData('u_line_jieshao',array('lineid'=>$line_id,'day'=>trim($v['day'])));
		
						//行程图片
						if(isset($v['pic'])){
							$path='/file/upload/'.date('Ymd').'/';
							$picArr=$v['pic'];
							unset($v['pic']);
						}
		
						if(!empty($jieshao)){  //编辑
								
							$this->user_shop_model->update_rowdata('u_line_jieshao',$v,array('id'=>$jieshao['id']));
								
							//行程图片
							if(isset($picArr)){
								$picstr='';
		
								//删掉之前的图片
								$this->user_shop_model->update_rowdata('u_line_jieshao_pic',array('pic'=>''),array('jieshao_id'=>$jieshao['id']));
								if(!empty($picArr)){
									foreach ($picArr as $key=>$val){
										$i += 1;
										if ($i <4) {
											$val=$this->get_pic_str($val);
											if(empty($val)){
												echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
											}
												
											$fx_pic=$this->get_upload_pimg($path,$val);
											$pics=json_decode($fx_pic);
											if($pics->code=='200'){
												if(empty($picstr)){
													$picstr=$pics->url;
												}else{
													$picstr=$picstr.';'.$pics->url;
												}
											}
										}else{
											echo json_encode(array('code'=>4000,'msg'=>'每个行程最能上传3张图片'));exit;
										}
									}
								}
		
								//是否已存在行程图片表
								$jie_pic=$this->user_shop_model->select_rowData('u_line_jieshao_pic',array('jieshao_id'=>$jieshao['id']));
								if(!empty($jie_pic)){
									$this->user_shop_model->update_rowdata('u_line_jieshao_pic',array('pic'=>$picstr),array('jieshao_id'=>$jieshao['id']));
								}else{
									$insertpic=array('jieshao_id'=>$jieshao['id'],'pic'=>$picstr,'addtime'=>date('Y-m-d H:i:s',time()));
									$this->user_shop_model->insert_data('u_line_jieshao_pic',$insertpic);
								}
		
							}
		
						}else{  //添加
							$v['lineid']=intval($line_id);
							$jieshao_id=$this->user_shop_model->insert_data('u_line_jieshao',$v);
							//行程图片
							if(isset($picArr)){
								$picstr='';
								if(!empty($picArr)){
									$i += 1;
									if ($i <4) {
										foreach ($picArr as $key=>$val){
											$val=$this->get_pic_str($val);
											if(empty($val)){
												echo json_encode(array('code'=>4000,'msg'=>'上传的图片出错,或不存在'));exit;
											}
												
											$fx_pic=$this->get_upload_pimg($path,$val);
											$pics=json_decode($fx_pic);
											if($pics->code=='200'){
												if(empty($picstr)){
													$picstr=$pics->url;
												}else{
													$picstr=$picstr.';'.$pics->url;
												}
											}
										}
									}else{
										echo json_encode(array('code'=>4000,'msg'=>'每个行程最能上传3张图片'));exit;
									}
								}
		
								$insertpic=array('jieshao_id'=>$jieshao_id,'pic'=>$picstr,'addtime'=>date('Y-m-d H:i:s',time()));
								$this->user_shop_model->insert_data('u_line_jieshao_pic',$insertpic);
							}
						}
					}else{
						echo json_encode(array('code'=>4000,'msg'=>'行程天数格式不对'));exit;
					}
				}
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'行程天数不能大于出游天数'));exit;
		}
	}
	

	/*
	 * @method 添加编辑线路价格
	 * @author xml
	 * 
	 */
	function save_lineprice(){
		//验证登录名
		$ky=sha1('supplier30');
		
		$username=trim($this->input->post('username',true));
		$pwd=trim($this->input->post('pwd',true));
		$price=$this->input->post('price',true);
		$sign=$this->input->post('sign',true);
		$linecode=$this->input->post('linecode',true);
		
		//签名验证	
		$str='';
		foreach ($_POST as $k=>$v){		
			if($k!='price' && $k!='sign'){
				$str=$str.$k.$v;	
			}
		}

		if(!empty($price)){
			foreach ($price as $k=>$v){
				foreach ($v as $key=>$val){
					if($key=='data'){
						foreach ($val as $n=>$y){
							foreach ($y as $a=>$b){
								$str=$str.$a.$b;
							}
						}
					}else{
						$str=$str.$key.$val;
					}
				}
			}
		}

		//写入参数日志
		$this->write_log("lineprice{".$str.$sign."}");
		$falg=true;
		if($falg){ //操作数据库数据
			$this->db->trans_start();
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
		
			$pwd=$this->security->xss_clean($pwd);
			$username=$this->security->xss_clean($username);
			$supplierData = $this->supplier_model ->get_supplier_msg(array('login_name'=>$username));
			
			if(!empty($supplierData[0])){
					$linepriceArr=array();
					$linepriceAffil=array();
					//设置价格
					$linecode=$this->input->post('linecode',true);
				
					$price=$this->security->xss_clean($price);
					$deposit=$this->input->post('deposit',true);
					$before_day=$this->input->post('before_day',true);
					$before_day=$this->security->xss_clean($before_day);
					$child_description=$this->input->post('child_description',true);
					$child_nobed_description=$this->input->post('child_nobed_description',true);
					$special_description=$this->input->post('special_description',true);
					$mb_cde=mb_strlen($child_description);
					$mb_node=mb_strlen($child_nobed_description);
					$sp_node=mb_strlen($special_description);
					if($mb_cde>50){
						echo json_encode(array('code'=>4000,'msg'=>'儿童占床说明不能超过50个字'));exit;
					}
					if($mb_node>50){
						echo json_encode(array('code'=>4000,'msg'=>'儿童不占床说明不能超过50个字'));exit;
					}
					if($sp_node>50){
						echo json_encode(array('code'=>4000,'msg'=>'特殊人群说明不能超过50个字'));exit;
					}
					if(isset($deposit)){
						$linepriceAffil['deposit']=$deposit;//押金
					}
					if(isset($before_day)){
						$linepriceAffil['before_day']=$before_day;//提前几天交款
					}
				    if(isset($child_description)){
				    	$linepriceArr['child_description']=$child_description;
				    }
				    if(isset($child_nobed_description)){
				    	$linepriceArr['child_nobed_description']=$child_nobed_description;
				    }	
				    if(isset($special_description)){
				    	$linepriceArr['special_description']=$special_description;
				    }
                    	   			    
					//线路
					$line=$this->user_shop_model->select_rowData('u_line',array('linecode'=>$linecode,'supplier_id'=>$supplierData[0]['id']));
				
					if(!empty($line)){

						if($line['status']==2){
							echo json_encode(array('code'=>4000,'msg'=>'线路已上线,不能修改'));exit;
						}else{
							$suit = $this->user_shop_model->save_price_api($price,$linepriceArr,$linepriceAffil,$line);
				
						}		
					}else{
						echo json_encode(array('code'=>4000,'msg'=>'线路不存在'));exit;
					}	 					
			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));exit;
			}
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));exit;
			}else{
				if(!empty($suit['code'])){
					if($suit['code']==200){
						echo json_encode(array('code'=>200,'msg'=>'操作成功','linecode'=>$linecode,'suit'=>$suit['suitid']));exit;
					}else{
						echo json_encode(array('code'=>4000,'msg'=>$suit['msg']));exit;
					}
					
				}else{
					echo json_encode(array('code'=>4000,'msg'=>'操作失败'));exit;
				}	
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名失败'));exit;
		}
	}
	/*
	 * @method 编辑行程
	 * @author xml
	 * */
	function save_rout_data(){
		//验证登录名
		$ky=sha1('supplier30');	
	
		$username=trim($this->input->post('username',true));
		$pwd=trim($this->input->post('pwd',true));
		$route=$this->input->post('route',true);
		$sign=$this->input->post('sign',true);
		$linecode=$this->input->post('linecode',true);
		//签名验证	
		$str='username'.$username.'pwd'.$pwd.'linecode'.$linecode;
		foreach ($route as $k=>$v){
			foreach ($v as $key=>$val){
				if($key!='pic'){
					$str=$str.$key.$val;
				}	
			}
			
		}
		//写入参数日志
		$this->write_log("linerout{".$str.$sign."}");
		$falg=true;

		if($falg){ //操作数据库数据	
			
			$this->db->trans_start();
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
			$supplierData = $this->supplier_model ->get_supplier_msg(array('login_name'=>$username));
			if(!empty($supplierData[0])){
				
					//保存行程		
					$route=$this->input->post('route',true);
					$line_beizhu=$this->input->post('line_beizhu',true);		
					$linecode=$this->security->xss_clean($linecode);
					$line_beizhu=$this->security->xss_clean($line_beizhu);
					$route=$this->security->xss_clean($route,true);	
					
					if(!empty($linecode)){
						$line=$this->user_shop_model->select_rowData('u_line',array('linecode'=>$linecode));
						if(!empty($line)){
							//温馨提示
							$this->user_shop_model->update_rowdata('u_line',array('line_beizhu'=>$line_beizhu),array('id'=>$line['id']));
							
							$this->get_line_rout($route,$line['id'],$line['lineday']);
							
						}else{
							echo json_encode(array('code'=>4000,'msg'=>'线路编号不存在'));exit;
						}

					}else{
						echo json_encode(array('code'=>4000,'msg'=>'线路编号不存在'));exit;
					}

			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));exit;
			}
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));exit;
			}else{
				echo json_encode(array('code'=>200,'msg'=>'操作成功'));exit;
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名验证出错'));exit;
		} 
			
	}
	

	/*
	 * @method 添加编辑价格库存
	* @author xml
	*/
	function save_price_stock(){
		//验证登录名
		$ky=sha1('supplier30');
		
		$username=trim($this->input->post('username',true));
		$pwd=trim($this->input->post('pwd',true));
		$price=$this->input->post('price',true);
		$sign=$this->input->post('sign',true);
		$linecode=$this->input->post('linecode',true);
		//签名验证
		$str='username'.$username.'pwd'.$pwd.'linecode'.$linecode;
		if(!empty($price)){
			foreach ($price as $k=>$v){
				foreach ($v as $key=>$val){
					if($key=='data'){
						foreach ($val as $n=>$y){
							foreach ($y as $a=>$b){
								$str=$str.$a.$b;
							}
						}
					}else{
						$str=$str.$key.$val;
					}
				}
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'数据不能为空!'));exit;
		}

		
		//写入参数日志
		$this->write_log("linestock{".$str.$sign."}");
		$falg=true;
		if($falg){ //操作数据库数据	
			
			$this->db->trans_start();
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
			
			$pwd=$this->security->xss_clean($pwd);
			$username=$this->security->xss_clean($username);
			$supplierData = $this->supplier_model->get_supplier_msg(array('login_name'=>$username));
			
			if(!empty($supplierData[0])){	
				
					//设置价格
					$linecode=$this->input->post('linecode',true);						
					$price=$this->security->xss_clean($price);	
					
					//线路
					$line=$this->user_shop_model->select_rowData('u_line',array('linecode'=>$linecode,'supplier_id'=>$supplierData[0]['id']));
			
					if(!empty($line)){
			
						if($line['status']==2){
							echo json_encode(array('code'=>4000,'msg'=>'线路已上线,不能修改'));exit;
						}else{
							$suit = $this->user_shop_model->save_priceStock_api($price,$line);
						}
					}else{
						echo json_encode(array('code'=>4000,'msg'=>'线路不存在'));exit;
					}
			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));exit;
			}
				
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));exit;
			}else{

				if($suit['code']==200){
					echo json_encode(array('code'=>200,'msg'=>'操作成功','linecode'=>$linecode,'suit'=>$suit['suitid']));exit;
				}else{
					echo json_encode(array('code'=>4000,'msg'=>$suit['msg']));exit;
				}
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名失败','suit'=>$suit));exit;
		} 
	}
	
	
	/*
	 * @method  验证登录名
	 * @author xml
	 */
	function valid_login(){
		$key=sha1('supplier30');
		//获取签名结果
		$sign=$this->input->post('sign',true);
		
		//获取api传过来的数据
		$dataArr=$_POST;
		unset($dataArr['sign']);
		$str='';
		foreach ($dataArr as $k=>$v){
			$str=$str.$k.$v;
		}
		//返回签名结果
		$falg=$this->md5Verify($str,$sign,$key);
		if($falg){
			return true;
		}else{
			return false;
		}
	} 
	//添加产品接口
  	function addlineData(){	  		
  			$key=sha1('supplier30');
  			$data['username']='b1user';
  			$data['pwd']='123456';
  		//	$mainpic=$this->input->post('mainpic',true);
  		    $jsonArr=$this->get_addline($_POST,$key);  //添加线路
  		    
  		    //把参数记录到一个log
  		    $url = './application/logs/lineapi';
  		    $filename=$url.'/log_addline'.date('Y-m-d').'.php';
  		    if (!file_exists($url)) {
  		    	mkdir($url ,0777 ,true);
  		    }
  		    if(file_exists($filename)){
  		    	file_put_contents($filename, '<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
  		    }else{
  		    	$str="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>";
  		    	$file=fopen($filename, "w");
  		    	file_put_contents($filename, $str.'<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
  		    	fclose($file);
  		    }
  		    
	 		$ch = curl_init ();
			curl_setopt( $ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].'/t33Api/line/addLine');
			curl_setopt ( $ch, CURLOPT_POST, 1);
			curl_setopt ( $ch, CURLOPT_HEADER, 0 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonArr);
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	    	$return = curl_exec ( $ch );
			curl_close ( $ch );
			echo $return;
	}
	
	//编辑产品接口
	function edit_line_api(){
		$key=sha1('supplier30');
		$data['username']='b1user';
		$data['pwd']='123456';
		$mainpic=$this->input->post('mainpic',true);
		$jsonArr=$this->get_editline($_POST,$key); //编辑线路
		
		//把参数记录到一个log
		$url = './application/logs/lineapi';
		$filename=$url.'/log_editline'.date('Y-m-d').'.php';
		if (!file_exists($url)) {
			mkdir($url ,0777 ,true);
		}
		if(file_exists($filename)){
			file_put_contents($filename, '<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
		}else{
			$str="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>";
			$file=fopen($filename, "w");
			file_put_contents($filename, $str.'<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
			fclose($file);
		}
		
		$ch = curl_init ();
		curl_setopt( $ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].'/t33Api/line/editLine');
		curl_setopt ( $ch, CURLOPT_POST, 1);
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonArr);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		echo $return;
	}
	//添加编辑行程的接口
	function updateRouting(){
		$key=sha1('supplier30');
		$data['username']='b1user';
		$data['pwd']='123456';
		//$mainpic=base64_encode('http://www.1b1u.com/file/upload/20161104/147822859291533.jpg');
		
		$str=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\8181143157608739bc37cebfd85515.jpg');
		$mainpic=base64_encode($str);
          
		$jsonArr=$this->get_route_data($_POST,$key);  //行程save_rout_data

		//把参数记录到一个log
		$url = './application/logs/lineapi';
		$filename=$url.'/log_routline'.date('Y-m-d').'.php';
		if (!file_exists($url)) {
			mkdir($url ,0777 ,true);
		}
		if(file_exists($filename)){
			file_put_contents($filename, '<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
		}else{
			$str="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>";
			$file=fopen($filename, "w");
			file_put_contents($filename, $str.'<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
			fclose($file);
		}
		
		$ch = curl_init ();
		curl_setopt( $ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].'/t33Api/line/save_rout_data');
		curl_setopt ( $ch, CURLOPT_POST, 1);
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonArr);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		echo $return;
	}
	//添加编辑价格接口
	function updateLinrPrice(){
		$key=sha1('supplier30');
		$data['username']='b1user';
		$data['pwd']='123456';
		//$mainpic=base64_encode('http://www.1b1u.com/file/upload/20161104/147822859291533.jpg');
		
		$str=file_get_contents('D:/xampp/htdocs/bangu/file/b1/images/8181143157608739bc37cebfd85515.jpg');
		$mainpic=base64_encode($str);
		
	    $jsonArr=$this->get_suit_price($_POST,$key);   //行程save_rout_data
		
	    //把参数记录到一个log
	    $url = './application/logs/lineapi';
	    $filename=$url.'/log_priceline'.date('Y-m-d').'.php';
	    if (!file_exists($url)) {
	    	mkdir($url ,0777 ,true);
	    }
	    if(file_exists($filename)){
	    	file_put_contents($filename, '<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
	    }else{
	    	$str="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>";
	    	$file=fopen($filename, "w");
	    	file_put_contents($filename, $str.'<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
	    	fclose($file);
	    }
	    
		$ch = curl_init ();
		curl_setopt( $ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].'/t33Api/line/save_lineprice');
		curl_setopt ( $ch, CURLOPT_POST, 1);
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonArr);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		echo $return;
	}
	
	//获取线路信息
	function get_line_data($data,$ky){
		$data['linecode']='L31902';
		$str='';
		foreach ($data as $k=>$v){
			if($k!='price'){
				$str=$str.$k.$v;
			}
		}
		$data['sign']=md5($str.$ky);
		$jsonArr=http_build_query($data);
		return $jsonArr;
	}
	//测试套餐库存的数据
	function get_suit_stock(){
		$ky=sha1('supplier30');
		$data['username']='b1user';
		$data['pwd']='123456';
		$lp=$_POST;
		$data['linecode']=$lp['linecode'];
		if(!empty($lp['prices'])){
			$lp['prices'] = json_decode($lp['prices'],true);
			foreach($lp['prices'] as $k=>$v){
				if(!empty($v)){
					$priceA['suitId']=$v['tabId'];
					if(!empty($v['data'])){
						foreach ($v['data'] as $key=>$val){
							$priceA['data'][$key]['day']=$val['day'];
							$priceA['data'][$key]['number']=$val['number'];
						}
					}
					$data['price'][$k]=$priceA;
				}
		
			}
		}
		
/* 		$data['price']=array(
			array(
				"suitId"=>"35640",
				"data"=>array(
						array(
							"day"=>"2017-04-24",
							"number"=>"16",
						),
						array(
							"day"=>"2017-04-26",
							"number"=>"60",
						),
				),
			)
		); */
		
		$str='';
		foreach ($data as $k=>$v){
			if($k!='price'){
				$str=$str.$k.$v;
			}
		}
		if(!empty($data['price'])){
			foreach ($data['price'] as $k=>$v){
				foreach ($v as $key=>$val){
					if($key=='data'){
						foreach ($val as $n=>$y){
							foreach ($y as $a=>$b){
								$str=$str.$a.$b;
							}
						}
					}else{
						$str=$str.$key.$val;
					}
				}
			}	
		}

		
		$data['sign']=md5($str.$ky);
		$jsonArr=http_build_query($data);

		//把参数记录到一个log
		$url = './application/logs/lineapi';
		$filename=$url.'/log_stockline'.date('Y-m-d').'.php';
		if (!file_exists($url)) {
			mkdir($url ,0777 ,true);
		}
		if(file_exists($filename)){
			file_put_contents($filename, '<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
		}else{
			$str="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>";
			$file=fopen($filename, "w");
			file_put_contents($filename, $str.'<br/>'.date('Y-m-d H:i').'{'.$jsonArr.'}',FILE_APPEND);
			fclose($file);
		}
		
		$ch = curl_init ();
		curl_setopt( $ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].'/t33Api/line/save_price_stock');
		curl_setopt ( $ch, CURLOPT_POST, 1);
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $jsonArr);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		echo $return;
		
	}
	//测试套餐价格
	function get_suit_price($priceArr,$ky){
		$data=array();
		$data['username']='b1user';
		$data['pwd']='123456';
		$data['linecode']=$priceArr['linecode'];
		$data['before_day']=$priceArr['before_day'];
		$data['deposit']=$priceArr['deposit'];
		$data['child_description']=$priceArr['child_description'];
		$data['child_nobed_description']=$priceArr['child_nobed_description'];
		$data['special_description']=$priceArr['special_description'];
        if(!empty($priceArr['prices'])){
        	$priceArr['prices'] = json_decode($priceArr['prices'],true);
        	foreach($priceArr['prices'] as $k=>$v){
        		if(!empty($v)){
        			$priceA['suitId']=$v['tabId'];
        			if(isset($v['tabName'])){
        				$priceA['suitName']=$v['tabName'];
        			}else{
        				$priceA['suitName']='标准价';
        			}
        			if(!empty($v['data'])){
        				foreach ($v['data'] as $key=>$val){
        					$priceA['data'][$key]['day']=$val['day'];
        					$priceA['data'][$key]['adultprice']=$val['adultprice'];
        					$priceA['data'][$key]['agent_rate_int']=$val['agent_rate_int'];
        					$priceA['data'][$key]['childprice']=$val['childprice'];
        					$priceA['data'][$key]['agent_rate_child']=$val['agent_rate_child'];
        					$priceA['data'][$key]['childnobedprice']=$val['childnobedprice'];
        					$priceA['data'][$key]['agent_rate_childno']=$val['agent_rate_childno'];
        					$priceA['data'][$key]['number']=$val['number'];
        					$priceA['data'][$key]['room_fee']=$val['room_fee'];
        					$priceA['data'][$key]['agent_room_fee']=$val['agent_room_fee'];
        					$priceA['data'][$key]['before_day']=$val['before_day'];
        					$priceA['data'][$key]['hour']=$val['hour'];
        					$priceA['data'][$key]['hour']=$val['minute'];
        				}
        			}
        			$data['price'][$k]=$priceA;
        		}
  
        	}
        }  
    //    print_r($data['price']);
   //     exit;
        
        
/*  		$data['price']=array(
		  0=>
			array(
				"suitName"=>"标准价",
				"suitId"=>"35640",
				"data"=>array(
					0=>array(
						"day"=>"2017-04-24",
					 	"adultprice"=>"1700",
					 	"agent_rate_int"=>"100",
					 	"childprice"=>"0",
					 	"agent_rate_child"=>"0",
					 	"childnobedprice"=>"0",
					 	"agent_rate_childno"=>"0",
					 	"number"=>"10",
					 	"room_fee"=>"0",
					 	"agent_room_fee"=>"0",
					 	"before_day"=>"0",
					 	"hour"=>"0",
					 	"minute"=>"0"
				    ),
					1=>array(
						"day"=>"2017-04-26",
						"adultprice"=>"900",
						"agent_rate_int"=>"100",
						"childprice"=>"0",
						"agent_rate_child"=>"0",
						"childnobedprice"=>"0",
						"agent_rate_childno"=>"0",
						"number"=>"10",
						"room_fee"=>"0",
						"agent_room_fee"=>"0",
						"before_day"=>"0",
						"hour"=>"0",
						"minute"=>"0"
				    ),
				),
		    )

		);  */
		
		$str='';
		foreach ($data as $k=>$v){
			if($k!='price'){
				$str=$str.$k.$v;
			}			
		}
		if(!empty($data['price'])){
			foreach ($data['price'] as $k=>$v){
				foreach ($v as $key=>$val){
					if($key=='data'){
						foreach ($val as $n=>$y){
							foreach ($y as $a=>$b){
								$str=$str.$a.$b;
							}
						}
					}else{
						$str=$str.$key.$val;
					}
				}
			}
		}

		
		$data['sign']=md5($str.$ky);
		$jsonArr=http_build_query($data);
		
		//$jsonArr = json_encode($data);
   
		return $jsonArr;
		
	}
	//测试添加的线路
	function get_addline($lineArr,$ky){
		$data=array();
		$data['username']='b1user';
		//$data['pwd']='123456';

		$str=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\t010d1ab82f67d5e5f6.jpg');
		$str0=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\8181143157608739bc37cebfd85515.jpg');
	    $pic=base64_encode($str);
		$pic0=base64_encode($str0); 
		//线路
		$data['line']=array(
				'line_classify'=>$lineArr['line_classify'],
				'linename'=>$lineArr['linename'],
				'linetitle'=>$lineArr['linetitle'],
				'linenight'=>$lineArr['linenight'],
				'lineday'=>$lineArr['lineday'],
				'startcity'=>$lineArr['startcity'],
				'linebefore'=>$lineArr['linebefore'],
				'mainpic'=>$lineArr['mainpic'],
				'overcity'=>$lineArr['overcity'],
				'hour'=>$lineArr['hour'],
				'minute'=>$lineArr['minute'],
				'themeid'=>$lineArr['themeid'],
				'features'=>$lineArr['features'],
				'car_address'=>$lineArr['car_address'],
				'feeinclude'=>$lineArr['feeinclude'],
				'feenotinclude'=>$lineArr['feenotinclude'],
				'other_project'=>$lineArr['other_project'],
				'insurance'=>$lineArr['insurance'],
				'visa_content'=>$lineArr['visa_content'],
				'beizu'=>$lineArr['beizu'],
				'special_appointment'=>$lineArr['special_appointment'],
				'safe_alert'=>$lineArr['safe_alert'],
				'linetype'=>$lineArr['linetype'],
			    /* 'line_img'=>array(
					0=>$pic,
				),  */
		);
		
		//线路行程
		if(!empty($lineArr['route'])){
			$route=$lineArr['route'];
			if(!empty($route['day'])){
				foreach ($route['day'] as $k=>$v){
					$rdata['day']=$route['day'][$k];
					$rdata['title']=$route['title'][$k];
					$rdata['breakfirsthas']=$route['breakfirsthas'][$k];
					$rdata['breakfirst']=$route['breakfirst'][$k];
					$rdata['transport']=$route['transport'][$k];
					$rdata['hotel']=$route['hotel'][$k];
					$rdata['jieshao']=$route['jieshao'][$k];
					$rdata['lunch']=$route['lunch'][$k];
					$rdata['lunchhas']=$route['lunchhas'][$k];
					$rdata['supperhas']=$route['supperhas'][$k];
					$rdata['supper']=$route['supper'][$k];
					$data['route'][]=$rdata;
				}
			}
		}

		//线路套餐价格
		if(!empty($lineArr['prices'])){
			$priceArr['prices']=$lineArr['prices'];
			$priceArr['prices'] = json_decode($priceArr['prices'],true);
			foreach($priceArr['prices'] as $k=>$v){
				if(!empty($v)){
					$priceA['suitId']=$v['tabId'];
					if(isset($v['tabName'])){
						$priceA['suitName']=$v['tabName'];
					}else{
						$priceA['suitName']='标准价';
					}
					if(!empty($v['data'])){
						foreach ($v['data'] as $key=>$val){
							$priceA['data'][$key]['day']=$val['day'];
							$priceA['data'][$key]['adultprice']=$val['adultprice'];
							$priceA['data'][$key]['agent_rate_int']=$val['agent_rate_int'];
							$priceA['data'][$key]['childprice']=$val['childprice'];
							$priceA['data'][$key]['agent_rate_child']=$val['agent_rate_child'];
							$priceA['data'][$key]['childnobedprice']=$val['childnobedprice'];
							$priceA['data'][$key]['agent_rate_childno']=$val['agent_rate_childno'];
							$priceA['data'][$key]['number']=$val['number'];
							$priceA['data'][$key]['room_fee']=$val['room_fee'];
							$priceA['data'][$key]['agent_room_fee']=$val['agent_room_fee'];
							$priceA['data'][$key]['before_day']=$val['before_day'];
							$priceA['data'][$key]['hour']=$val['hour'];
							$priceA['data'][$key]['hour']=$val['minute'];
						}
					}
					$data['price'][$k]=$priceA;
				}
		
			}
		}
		
		
		if(!empty($lineArr['line_img'])){
			$data['line']['line_img']=$lineArr['line_img'];
		}

		//管家培训
		$train=array();
		if(!empty($lineArr['question'])){
			foreach ($lineArr['question'] as $k=>$v){
				$train[$k]['question']=$lineArr['question'][$k];
				$train[$k]['id']=$lineArr['train_id'][$k];
				$train[$k]['answer']=$lineArr['answer'][$k];
				$train[$k]['status']=1;
			}
		}
		$data['train']=$train;
/* 		//管家培训
		$data['train']=array(
		    array(
			    'question'=>'1243234',
		    	'answer'=>'22sdfdf',
			), 
			array(
				'question'=>'dfgdfg',
				'answer'=>'dfgdg',
			),
			array(
				'question'=>'ertdfg',
				'answer'=>'sdfgdfgdfg',
			),
		); */

		$str='';
		foreach ($data as $k=>$v){
			if($k=='line'){
				foreach ($v as $key=>$val){
					if($key!='mainpic' && $key!='line_img'){
						$str=$str.$key.$val;
					}
					
				}
			}else if($k=='train'){
				foreach ($v as $a=>$b){
					foreach ($b as $n=>$y){
						$str=$str.$n.$y;
					}
				}
			}else{
				$str=$str.$k.$v;
			}
		}

		$data['sign']=md5($str.$ky);
		//$str="username=b1user&line%5Bline_classify%5D=1&line%5Blinename%5D=test&line%5Blinetitle%5D=%E6%B5%8B%E8%AF%95&line%5Blinenight%5D=1&line%5Blineday%5D=2&line%5Bstartcity%5D=%E6%B7%B1%E5%9C%B3%E5%B8%82&line%5Blinebefore%5D=&line%5Bmainpic%5D=%2Ffile%2Fupload%2F20161029%2F147773305490488.jpg&line%5Bovercity%5D=%E9%A6%99%E6%B8%AF&line%5Bhour%5D=&line%5Bminute%5D=&line%5Bthemeid%5D=&line%5Bfeatures%5D=test&line%5Bcar_address%5D=&line%5Bfeeinclude%5D=test&line%5Bfeenotinclude%5D=test&line%5Bother_project%5D=&line%5Binsurance%5D=&line%5Bvisa_content%5D=&line%5Bbeizu%5D=test&line%5Bspecial_appointment%5D=test&line%5Bsafe_alert%5D=%E7%89%B9%E8%89%B2%E5%8F%B0&line%5Blinetype%5D=&train%5B0%5D%5Bquestion%5D=1243234&train%5B0%5D%5Banswer%5D=22sdfdf&train%5B1%5D%5Bquestion%5D=dfgdfg&train%5B1%5D%5Banswer%5D=dfgdg&train%5B2%5D%5Bquestion%5D=ertdfg&train%5B2%5D%5Banswer%5D=sdfgdfgdfg";
		$jsonArr=http_build_query($data);
	//	var_dump($jsonArr);
	//	var_dump($data['sign']);exit;
		return $jsonArr;
	}
	
    //测试编辑线路
	function get_editline($lineArr,$ky){
		//线路基础信息
		$data=array();
		$data['username']='b1user';
		$data['pwd']='123456';
		
	/* 	$str=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\t010d1ab82f67d5e5f6.jpg');
		$str0=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\8181143157608739bc37cebfd85515.jpg');
		$pic=base64_encode($str);
		$pic0=base64_encode($str0); */
		
		$data['line']=array(
			'linecode'=>$lineArr['linecode'],
		//	'line_classify'=>$lineArr['line_classify'],
			'linename'=>$lineArr['linename'],
 			'linetitle'=>$lineArr['linetitle'],
			'linenight'=>$lineArr['linenight'],
			'lineday'=>$lineArr['lineday'],
			'startcity'=>$lineArr['startcity'],
			'linebefore'=>$lineArr['linebefore'],
			'mainpic'=>$lineArr['mainpic'],
			'overcity'=>$lineArr['overcity'],
			'hour'=>$lineArr['hour'],
			'minute'=>$lineArr['minute'],
			'themeid'=>$lineArr['themeid'],
			'features'=>$lineArr['features'],
			'car_address'=>$lineArr['car_address'],
			'feeinclude'=>$lineArr['feeinclude'],
			'feenotinclude'=>$lineArr['feenotinclude'],
			'other_project'=>$lineArr['other_project'],
			'insurance'=>$lineArr['insurance'],
			'visa_content'=>$lineArr['visa_content'],
			'beizu'=>$lineArr['beizu'],
			'special_appointment'=>$lineArr['special_appointment'],
			'safe_alert'=>$lineArr['safe_alert'],
			'linetype'=>$lineArr['linetype'],
			/* 'line_img'=>array(
					0=>$pic,
					1=>$pic0,
			),  */
				
		);
		if(!empty($lineArr['line_img'])){
			$data['line']['line_img']=$lineArr['line_img'];
		}
		//管家培训
		$train=array();
		if(!empty($lineArr['question'])){
			foreach ($lineArr['question'] as $k=>$v){
				$train[$k]['question']=$lineArr['question'][$k];
				$train[$k]['id']=$lineArr['train_id'][$k];
				$train[$k]['answer']=$lineArr['answer'][$k];
				$train[$k]['status']=1;
			}
		}
		$data['train']=$train;
/* 		$data['train']=array(
				array(
					'id'=>255371,
					'question'=>'test',
					'answer'=>'22sdfdf',
					'status'=>1,
				),
				array(
					'id'=>255372,
					'question'=>'dfgdfg',
					'answer'=>'dfgdg',
					'status'=>1,
				),
		); */

		$str='';
		foreach ($data as $k=>$v){
			if($k=='line'){
				foreach ($v as $key=>$val){
					if($key!='mainpic' && $key!='line_img'){
						$str=$str.$key.$val;
					}
						
				}
			}else if($k=='train'){
				foreach ($v as $a=>$b){
					foreach ($b as $n=>$y){
						$str=$str.$n.$y;
					}
				}
			}else{
				$str=$str.$k.$v;
			}
		}
		$data['sign']=md5($str.$ky);
		
		$jsonArr=http_build_query($data);

		return $jsonArr;
	}
	//行程安排
	function get_route_data($route,$ky){
		$str=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\t010d1ab82f67d5e5f6.jpg');
		$str0=file_get_contents('D:\xampp\htdocs\bangu\file\b1\images\8181143157608739bc37cebfd85515.jpg');
		$pic=base64_encode($str);
		$pic0=base64_encode($str0);
		
		$data['username']='b1user';
		$data['pwd']='123456';
		
		$data['linecode']=$route['linecode'];
		$data['line_beizhu']=$route['line_beizhu'];
		$data['route']=array();
		if(!empty($route['day'])){
		   foreach ($route['day'] as $k=>$v){
			   	$rdata['day']=$route['day'][$k];
			   	$rdata['title']=$route['title'][$k];
			   	$rdata['breakfirsthas']=$route['breakfirsthas'][$k];
			   	$rdata['breakfirst']=$route['breakfirst'][$k];
			   	$rdata['transport']=$route['transport'][$k];
			   	$rdata['hotel']=$route['hotel'][$k];
			   	$rdata['jieshao']=$route['jieshao'][$k];
			   	$rdata['lunch']=$route['lunch'][$k];
			   	$rdata['lunchhas']=$route['lunchhas'][$k];
			   	$rdata['supperhas']=$route['supperhas'][$k];
			   	$rdata['supper']=$route['supper'][$k];
			   	$data['route'][]=$rdata;	    
		   } 
		}
		//var_dump($data['route']);
	
		
		
/* 		$data['route']=array(
			array(
				'day'=>1,
				'title'=>'海南',
				'breakfirsthas'=>1,
				'breakfirst'=>'早餐',
				'transport'=>'飞机',
				'hotel'=>'酒店',
				'jieshao'=>'三亚一日游',
				'lunch'=>'午餐',
				'lunchhas'=>'1',
				'supperhas'=>'1',
				'supper'=>'晚餐',
				'pic'=>'',
			),
			array(
					'day'=>2,
					'title'=>'海南2',
					'breakfirsthas'=>1,
					'breakfirst'=>'早餐',
					'transport'=>'飞机',
					'hotel'=>'酒店',
					'jieshao'=>'海口一日游',
					'lunch'=>'午餐',
					'lunchhas'=>'1',
					'supperhas'=>'1',
					'supper'=>'晚餐',
					'pic'=>array(0=>$pic),
			),
		); */
		$str='';
		foreach ($data as $k=>$v){
			if($k=='route'){
				foreach ($v as $key=>$val){
					foreach ($val as $a=>$b){
						if($a!='pic'){
							$str=$str.$a.$b;
						}
					}
				}
			}else{
				$str=$str.$k.$v;
			}
		}
		$data['sign']=md5($str.$ky);
		$jsonArr=http_build_query($data);
		return $jsonArr;
	} 
	
	
	
	
	/*
	 * 验证签名
	 * @param $prestr 需要签名的字符串
	 * @param $sign 签名结果
	 * @param $key 私钥
	 * return 签名结果
	 */
	function md5Verify($prestr, $sign, $key) {
		$prestr = $prestr . $key;
		$mysgin =sha1(md5($prestr));
		
		if($mysgin == $sign) {
			return true;
		}
		else {
			return false;
		}
	} 
	/**
	 * @name：公共函数：上传图片
	 * @author: xml
	 * @param:$path,$input_name
	 * @return:picurl
	 *
	 */
	public function get_upload_pimg($path, $imgfile) {
		//上传图片
		$img = base64_decode($imgfile);
		if (!file_exists('.'.$path)) {
			mkdir('.'.$path ,0777 ,true);
		}
		
		$filename = md5(time().mt_rand(10, 99)).".jpg";
	
		$status = file_put_contents('.'.$path.$filename, $img);
		if ($status === false)
		{
			echo json_encode(array('code'=>4000,'msg'=>'上传图片失败'));exit;
		}else{
						
			//压缩图片
			$picName=$path.$filename;
			//$picName=$this->get_thumb_pic($path.$filename);	
            if($picName){
            	return json_encode(array('code'=>200,'msg'=>$status,'url'=>$picName));
            }else{
            	echo json_encode(array('code'=>4000,'msg'=>'图片格式不对'));exit;
            }    
			
		}
	}
	//压缩图片
	function get_thumb_pic($picSrc){
		//压缩图片
		$picName = substr($picSrc ,0 ,strrpos($picSrc ,'.')).'_thumb'.substr($picSrc, strrpos($picSrc ,'.'));
		
		$config['image_library'] = 'gd2';
		$config['source_image'] =dirname(BASEPATH).$picSrc;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']     = 500;
		$config['height']   = 300;
		
		$this->load->library('image_lib', $config);
		$status = $this->image_lib->resize();
		if($status){
			return $picName;
		}
	}
	/**
	 *@method 线路信息
	 *@param linecode 
	 * @author xml
	 * @return array
	 */
	function get_line_msg(){
		//验证登录名
		$ky=sha1('supplier30');

		$username=trim($this->input->post('username',true));
		$pwd=trim($this->input->post('pwd',true));
		$sign=$this->input->post('sign',true);
		$linecode=$this->input->post('linecode',true);
		//签名验证
		$str='username'.$username.'pwd'.$pwd.'linecode'.$linecode;
		$falg=true;
	/* 	if($sign==md5($str.$ky)){
			$falg=true;
		}else{
			$falg=false;
		} */
		
		if($falg){ //操作数据库数据
			$this->db->trans_start();
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
				
			$pwd=$this->security->xss_clean($pwd);
			$username=$this->security->xss_clean($username);
			$supplierData = $this->supplier_model ->get_supplier_msg(array('login_name'=>$username));
		
			if(!empty($supplierData[0])){

					//保存价格
					
					//线路基础信息
					$line=$this->user_shop_model->select_rowData('u_line',array('linecode'=>$linecode,'supplier_id'=>$supplierData[0]['id']));
					if(!empty($line)){
						$lineId=$line['id'];
						
						//线路附表
						$affil=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
						//被选中的主题游
						$theme_name='';
						if(!empty($line['themeid'])){
							$theme=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$line['themeid']));
							if(!empty($theme)){
								$theme_name=$theme[0]['name'];
							}
						}
						//获取线路的出发地
						$citystr='';
						$cityArr=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineId));
						if(!empty($cityArr)){
							foreach ($cityArr as $key=>$val){
								if(empty($citystr)){
									$citystr=$val['cityname'];
								}else{
									$citystr=$citystr.','.$val['cityname'];
								}								
							}
						}	
						//获取线路的目的地
						$overcitystr='';
						$overcity2_arr = array();
						if(""!=$line['overcity2']){
							$overcity2_arr = $this->user_shop_model->get_lineDestData(explode(",",$line['overcity2']));
							if(!empty($overcity2_arr)){
								foreach ($overcity2_arr as $key=>$val){
									 if(empty($overcitystr)){
									 	$overcitystr=$val['name'];
									 }else{
									 	$overcitystr=$overcitystr.','.$val['name'];
									 }
								}
							}
						}
						//上车地点
						$carstr='';
						$carAddress=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));
						if(!empty($carAddress)){
							foreach ($carAddress as $k=>$v){
								if(empty($carstr)){
									$carstr=$v['on_car'];
								}else{
									$carstr=$carstr.','.$v['on_car'];
								}
							}
						}	
						
						//产品标签
						$attrstr="";
						$attr=$this->user_shop_model->get_line_attr($lineId);
						if(!empty($attr)){
							foreach ($attr as $k=>$v){
								if(empty($attrstr)){
									$attrstr=$attrstr.$v['attrname'];
								}else{
									$attrstr=$attrstr.','.$v['attrname'];
								}
							}
						}
						
						$data['line']=array(
								'linecode'=>$line['linecode'],
								'linename'=>$line['linename'],
								'sp_brand'=>$supplierData[0]['brand'],
								'lineprename'=>$line['lineprename'],
								'linenight'=>$line['linenight'],
								'lineday'=>$line['lineday'],
								'linetitle'=>$line['linetitle'],
								'startcity'=>$citystr,
								'themeid'=>$theme_name,
								'linebefore'=>$line['linebefore'],
								'mainpic'=>$line['mainpic'],
								'overcity'=>$overcitystr,
									
								'hour'=>$affil['hour'],
								'minute'=>$affil['minute'],
								'line_classify'=>$line['line_classify'],
								'features'=>$line['features'],
								'car_address'=>$carstr,
									
								'feeinclude'=>$line['feeinclude'],
								'feenotinclude'=>$line['feenotinclude'],
								'other_project'=>$line['other_project'],
								'insurance'=>$line['insurance'],
								'visa_content'=>$line['visa_content'],
								'beizu'=>$line['beizu'],
								'special_appointment'=>$line['special_appointment'],
								'safe_alert'=>$line['safe_alert'],
								'linetype'=>$attrstr,
						);
						
						//线路图片
						$imgurl=$this->user_shop_model->select_imgdata($lineId);
						if(!empty($imgurl)){
							$data['imgurl_str']='';
							foreach ($imgurl as $k=>$v){
								$data['imgurl_str']=$data['imgurl_str'].$v['filepath'].',';
							}
						}
						
					//	$data['attr']=$this->user_shop_model->get_line_attr($lineId);
	
						//行程安排
						$data['rout']=$this->user_shop_model->getLineRout($lineId);
						
						//获取套餐的信息
						$data['price']=array(
							'deposit'=>$affil['deposit'],
							'before_day'=>$affil['before_day'],
							'child_description'=>$line['child_description'],
							'child_nobed_description'=>$line['child_nobed_description'],
							'special_description'=>$line['special_description']
						);
						
						//$data['suits'] =$this->user_shop_model->getLineSuit($lineId);
							
						//管家培训
						$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
							
					}else{
						echo json_encode(array('code'=>4000,'msg'=>'线路编号不存在'));exit;
					}

			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));exit;
			}
		
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));exit;
			}else{
				
				echo json_encode(array('code'=>200,'msg'=>'获取数据成功','data'=>$data));exit;		
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名失败'));exit;
		}
		
	}
	
	/**
	 *@method 线路价格信息
	 *@param linecode
	 * @author xml
	 * @return array
	 */
	function get_suitpriceList(){
		//验证登录名
		$ky=sha1('supplier30');
		
		$username=trim($this->input->post('username',true));
		$pwd=trim($this->input->post('pwd',true));
		$sign=$this->input->post('sign',true);
		$linecode=$this->input->post('linecode',true);
		//签名验证
		$str='username'.$username.'pwd'.$pwd.'linecode'.$linecode;
		if($sign==md5($str.$ky)){
			$falg=true;
		}else{
			$falg=false;
		}
		
		if($falg){ //操作数据库数据
			$this->db->trans_start();
			//判断用户名是否存在
			$this ->load_model('common/u_supplier_model' ,'supplier_model');
		
			$pwd=$this->security->xss_clean($pwd);
			$username=$this->security->xss_clean($username);
			$supplierData = $this->supplier_model ->get_supplier_msg(array('login_name'=>$username));
		
			if(!empty($supplierData[0])){

					//线路基础信息
					$line=$this->user_shop_model->select_rowData('u_line',array('linecode'=>$linecode,'supplier_id'=>$supplierData[0]['id']));
					if(!empty($line)){
						$lineId=$line['id'];
							
						//线路附表
						$affil=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
						
						$data['deposit']=$affil['deposit'];
						$data['before_day']=$affil['before_day'];
						$data['child_description']=$line['child_description'];
						$data['child_nobed_description']=$line['child_nobed_description'];
						$data['special_description']=$line['special_description'];
						//获取套餐的信息
						$data['suits']=$this->user_shop_model->getProductPriceByProductId($lineId);
					}else{
						echo json_encode(array('code'=>4000,'msg'=>'线路编号不存在'));exit;
					}   
			}else{
				echo json_encode(array('code'=>4000,'msg'=>'用户名不存在'));exit;
			}
		
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));exit;
			}else{
		
				echo json_encode(array('code'=>200,'msg'=>'获取数据成功','suit'=>$data));exit;
			}
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'签名失败','suit'=>$suit));exit;
		}
		
	}
	
	//日历价格
	public function getProductPriceJSON(){
		$linecode = $this->get("linecode");
		$line=$this->user_shop_model->select_rowData('u_line',array('linecode'=>$linecode));
		if($line['id']){
			$lineId=$line['id'];
		}else{
			$lineId=0;
		}
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId);
		}
		//echo $this->db->last_query();
		echo $productPrice;
	}
	
	/**
	 * @method 日志
	 * @author xml
	 */
	function write_log($str){
		$url = './application/logs/lineapi';
		$filename=$url.'/log'.date('Y-m-d').'.txt';
		if (!file_exists($url)) {
			mkdir($url ,0777 ,true);
		}
		if(file_exists($filename)){
			file_put_contents($filename, '{'.$str.'}.',FILE_APPEND);
		}else{
			$file=fopen($filename, "w");
			file_put_contents($filename, '{'.$str.'}.',FILE_APPEND);
			fclose($file);
		}
	}
	/**
	 * @method 过滤特殊字符
	 * @author xml
	 */
	function filter_str($data){
		if(!is_array($data)){
			$html_string= array("\\", "/", "\"", "\n", "\r", "\t", "<", ">");
			$data = str_replace($html_string,"",$data);
		}
		return $data;
	}
	/**
	 * 获取图片流数据
	 */
	function get_pic_str($pic){
		$url=$_SERVER['SCRIPT_FILENAME'];
		$te= strpos($url,"bangtest");
		$picurl=substr($url, 0, $te);
		
		if(file_exists($picurl.'/bangtest'.$pic))
		{	
			$str=file_get_contents($picurl.'/bangtest'.$pic,'bangtest');
			$pic=base64_encode($str);
			return  $pic;	
		}else{
			return '';
		}

	}
}
