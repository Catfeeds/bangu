<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月27日18:26:53
 * @author		谢明丽
 *
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Travel extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'member_model', 'member');
		$this->load_model( 'travel_model', 'travel');
		$this->load_model( 'order_model', 'order');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
	}
	//我的游记(全部)
	public function index($page=1){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		
		//分页
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/travel/index_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->travel->get_travel_list($userid, 0, $config['pagesize']));
		$data['row']=$this->travel->get_travel_list($userid,$page, $config['pagesize']);
	 	// echo $this->db->last_query();
		$this->page->initialize ( $config );
		$data['title']="我的游记";
		$this->load->view('base/travel',$data);
	}
	//写游记
    public function write_travels(){
    	//启用session
    	$this->load->library('session');
    	$userid=$this->session->userdata('c_userid');
    	//订单线路
    	$data['order']=$this->travel->order_message($userid);
    	//线路标签
    	$data['line_attr']=$this->travel->sel_line_attr();
		//判断会员是否是体验师
    	$data['experience']=$this->travel->get_alldata('u_member_experience',array('member_id'=>$userid,'status'=>1));

    	$this->load->view('base/release_travels_view',$data);
    	
    }
	//编辑游记
	public function release_travels($id){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
	   	//订单线路
		$data['order']=$this->travel->order_message($userid);
	
		//产品标签分类	
		$data['line_attr']=$this->travel->sel_line_attr();
		//游记
		if(is_numeric($id)){
			$where='userid ='.$userid.' and id='.$id.' and (status=0 or status=1)';
			$get_data=$this->travel->get_alldata('travel_note',$where);
			if(!empty($get_data)){
				$data['travel']=$this->travel->get_alldata('travel_note',array('id'=>$id));
				$data['foodpic']=$this->travel->get_data('travel_note_pic',array('pictype'=>1,'note_id'=>$id));//吃的图片
				$data['hotelpic']=$this->travel->get_data('travel_note_pic',array('pictype'=>2,'note_id'=>$id));//住的图片
				$data['walkpic']=$this->travel->get_data('travel_note_pic',array('pictype'=>3,'note_id'=>$id));//行的图片
				//产品标签
				if(!empty($data['travel']['tags'])){
					$tagesArr=explode(',',$data['travel']['tags']);
					$data['tagesStr']=$this->travel->line_attr_row($tagesArr);
				}		
			}else{
				echo "<script>alert('该游记不能修改或不属于你的游记!');window.history.back(-1);</script>";
			}
		}
		//判断会员是否是体验师
		$data['experience']=$this->travel->get_alldata('u_member_experience',array('member_id'=>$userid,'status'=>1));
		
		$this->load->view('base/release_travels_view',$data);
	}
	//保存游记
	function save_travel(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//插入游记
		$orderArr=array();
		$walk_picsArr=array();
		$hotel_picsArr=array();
		$food_picsArr=array();
		$title=$this->input->post('title');
		$order_id=$this->input->post('orderid');
		$cover_pic=$this->input->post('cover_pic_string');
		$content=$this->input->post('content');
		$walk_pics_string=$this->input->post('walk_pics_string');
		$hotel_pics_string=$this->input->post('hotel_pics_string');
		$food_pics_string=$this->input->post('food_pics_string');
		$is_show=$this->input->post('is_show');
		$note_id=$this->input->post('travel_id');
		$tags=$this->input->post('tags');
		$walk_content=$this->input->post('walk_content');
		$food_content=$this->input->post('food_content');
		$hotel_content=$this->input->post('hotel_content'); 
		$walk_id=$this->input->post('walk_id');
		$hotel_id=$this->input->post('hotel_id');
		$food_id=$this->input->post('food_id');
		$travel_impress=$this->input->post('travel_impress');
	
		$jifen=0;
		
		if(!empty($order_id)){
			$orderArr=explode('-', $order_id);
		}else{
			echo "<script>alert('请选择订单线路!');window.history.back(-1);</script>";
		}

		//游记的订单
		$expert_id='';
		if($orderArr[0]>0){
	    	$orderData=$this->travel->get_alldata('u_member_order',array('id'=>$orderArr[0]));
	    	$expert_id=$orderData['expert_id'];
		}
		//$orderData['expert_id']
		if($is_show=='发布体验'){
			$is_show=1;
		}elseif($is_show=='保存草稿'){
			$is_show=0;
		}else{
			$is_show=0;
		}

		//插入用户的游记最新封面图
		$status=$this->travel->updata_alldata('u_member',array('mid'=>$userid),array('travel_pic'=>$cover_pic));
		$member=$this->travel->get_alldata('u_member',array('mid'=>$userid));
		
	/*-- ------------------------修改游记------------------------------------- */
		if(!empty($note_id)&& is_numeric($note_id)){    //修改游记
				
				$uptravelArr=array(
						'line_id'=>$orderArr[1],
						'order_id'=>$orderArr[0],
						'title'=>$title,
						'content'=>$content,
						'cover_pic'=>$cover_pic,
						'modtime'=>date('Y-m-d H:i:s',time()),
						'tags'=>$tags,
						'status'=>$is_show,
					//	'content'=>$content,
						'travel_impress'=>$travel_impress,
						'expert_id'=>$expert_id,
				);
	
				$status=$this->travel->updata_alldata('travel_note',array('id'=>$note_id),$uptravelArr);
				$travel_data=$this->travel->get_alldata('travel_note',array('userid'=>$userid,'id'=>$note_id));
				
			   if($status){
			       if($is_show==1){            //          送积分
			       	if(!empty($travel_data) && $travel_data['jifen']>0){
			       		 $jifen=$travel_data['jifen'];
			       	}else{
			       		$jifen=1000;	
			       		$update_jifen=$this->order->update_member_jifen($userid,$jifen);
			       		$status=$this->travel->updata_alldata('travel_note',array('id'=>$note_id),array('jifen'=>$jifen));
			       		if($update_jifen){
			       			$jifenArr['member_id']=$userid;
			       			$jifenArr['point_before']=$member['jifen'];
			       			$jifenArr['point_after']=$member['jifen']+$jifen;
			       			$jifenArr['point']=$jifen;
			       			$jifenArr['content']='发布游记赠送积分';
			       			$jifenArr['addtime']=date('Y-m-d H:i:s',time());
			       			$this->travel->insert_data('u_member_point_log',$jifenArr);
			       		}
			       	}	
			   	   } 
			    	// pictype:1吃,2住,3行,4购
				    if(!empty($walk_pics_string)){	  //修改     边走边拍的图片
				    	foreach ($walk_pics_string as $k=>$v){
				    		$walk_Arr=array(
				    				'pic'=>$v,
				    				'note_id'=>$note_id,
				    				'pictype'=>3,
				    				'description'=>$walk_content[$k],
				    		);
				    		if(!empty($walk_id[$k])){  //修改
				    	            $pic_status=$this->travel->updata_alldata('travel_note_pic',array('note_id'=>$note_id,'pictype'=>3,'id'=>$walk_id[$k]),$walk_Arr);
				    		}else{    //插入
				    			$walk_Arr['addtime']=date('Y-m-d H:i:s',time());
				    			$walkid=$this->travel->insert_data('travel_note_pic',$walk_Arr);
				    		}
				    	}
				    }
				    
				    if(!empty($hotel_pics_string)){	  //修改     酒店速写
				    	foreach ($hotel_pics_string as $k=>$v){
				    		$hotel_Arr=array(
				    				'pic'=>$v,
				    				'note_id'=>$note_id,
				    				'pictype'=>2,
				    				'description'=>$hotel_content[$k],
				    		);
				    		if(!empty($hotel_id[$k])){  //修改
				    			$pic_status=$this->travel->updata_alldata('travel_note_pic',array('note_id'=>$note_id,'pictype'=>2,'id'=>$hotel_id[$k]),$hotel_Arr);
				    		}else{    //插入
				    			$hotel_Arr['addtime']=date('Y-m-d H:i:s',time());
				    			$hotelid=$this->travel->insert_data('travel_note_pic',$hotel_Arr);
				    		}
				    	
				    	}
				    }
				    if(!empty($food_pics_string)){	  //修改     美食写真
				    	foreach ($food_pics_string as $k=>$v){
				    		$food_Arr=array(
				    				'pic'=>$v,
				    				'note_id'=>$note_id,
				    				'pictype'=>1,
				    				'description'=>$food_content[$k],
				    		);
				    		if(!empty($food_id[$k])){  //修改
				    			$pic_status=$this->travel->updata_alldata('travel_note_pic',array('note_id'=>$note_id,'pictype'=>1,'id'=>$food_id[$k]),$food_Arr);
				    		}else{    //插入
				    			$food_Arr['addtime']=date('Y-m-d H:i:s',time());
				    			$foodid=$this->travel->insert_data('travel_note_pic',$food_Arr);
				    		}
				    	}
				    }

			     	echo "<script>alert('修改成功!');window.location.href='/base/travel/index';</script>";
			   }else{
			     	echo "<script>alert('提交失败!');window.history.back(-1);</script>";
			   } 
 /*-- ------------------------添加游记------------------------------------- */
		}else{          //添加游记

			$travelArr=array(
					'line_id'=>$orderArr[1],
					'order_id'=>$orderArr[0],
					'title'=>$title,
					'content'=>$content,
					'cover_pic'=>$cover_pic,
					'userid'=>$userid,
					'addtime'=>date('Y-m-d H:i:s',time()),
					'modtime'=>date('Y-m-d H:i:s',time()),
					'usertype'=>0,
					'status'=>$is_show,
					'tags'=>$tags,
					'travel_impress'=>$travel_impress,
					'expert_id'=>$expert_id,

			);

			if($is_show==1){ //发布游记添加积分
				$travelArr['jifen']=1000;	
			}		
			$travel_id=$this->travel->insert_data('travel_note',$travelArr);
		  
			if($travel_id>0){  // pictype:1吃,2住,3行,4购
				if($is_show==1){ //发布游记添加积分
					$jifen=1000;
				   $update_jifen=$this->order->update_member_jifen($userid,$jifen); //送积分
				   if($update_jifen){
				   	$jifenArr['member_id']=$userid;
				   	$jifenArr['point_before']=$member['jifen'];
				   	$jifenArr['point_after']=$member['jifen']+$jifen;
				   	$jifenArr['point']=$jifen;
				   	$jifenArr['content']='发布游记赠送积分';
				   	$jifenArr['addtime']=date('Y-m-d H:i:s',time());
				   	$this->travel->insert_data('u_member_point_log',$jifenArr);
				   }
				}
				
				if(!empty($walk_pics_string)){ //边做边拍
					foreach ($walk_pics_string as $k=>$v){
						if(!empty($v)){
							$walk_Arr=array(
									'pic'=>$v,
									'note_id'=>$travel_id,
									'pictype'=>3,
									'addtime'=>date('Y-m-d H:i:s',time()),
									'description'=>$walk_content[$k],
							);
							$walk_id=$this->travel->insert_data('travel_note_pic',$walk_Arr);
						}
					}	  
				}
				if(!empty($hotel_pics_string)){ //酒店速写
					foreach ($hotel_pics_string as $k=>$v){
						if(!empty($v)){
							$hotel_Arr=array(
									'pic'=>$v,
									'note_id'=>$travel_id,
									'pictype'=>2,
									'addtime'=>date('Y-m-d H:i:s',time()),
									'description'=>$hotel_content[$k],
							);
							$hotel_id=$this->travel->insert_data('travel_note_pic',$hotel_Arr);
						}
					}
				}
				if(!empty($food_pics_string)){ //美食速写
					foreach ($food_pics_string as $k=>$v){
						if(!empty($v)){
							$food_Arr=array(
								'pic'=>$v,
								'note_id'=>$travel_id,
								'pictype'=>1,
								'addtime'=>date('Y-m-d H:i:s',time()),
								'description'=>$food_content[$k],
							);
							$food_id=$this->travel->insert_data('travel_note_pic',$food_Arr);
						}
					}
				}
				
				echo "<script>alert('提交成功!');window.location.href='/base/travel/index';</script>";
			}else{
				echo "<script>alert('提交失败!');window.history.back(-1);</script>";
			}
		}
	}
	//删除游记
	function del_traval(){
		$id=$this->input->post('id');
    		if(is_numeric($id)){
			$status=$this->travel->updata_alldata('travel_note',array('id'=>$id),array('STATUS'=>-1));
			if($status){
				echo json_encode(array('status' => 1,'msg' =>'删除成功'));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'删除失败'));
				exit;
			}
		}else{
		    echo json_encode(array('status' => -1,'msg' =>'删除失败'));
			exit;
		} 
	}
	//上传封面图片
	function update_pic(){
		$config['upload_path']="./file/c/img";//文件上传目录
		if(!file_exists("./file/c/img")){
			mkdir("./file/c/img",0777,true);//原图路径
		}

		if($_FILES['cover_pic']['error']==0){
			$pathinfo=pathinfo($_FILES["cover_pic"]['name']);
			$extension=$pathinfo['extension'];
			$file_url=$config['upload_path'].'/'.date("Ymd").time().".".$extension;
			$file_arr=array('gif','jpg','png','jpeg');
			if(!in_array($extension, $file_arr)){
				
				echo json_encode(array('status' => -1,'msg' =>'上传格式出错,请重新选择gif,jpg,png,jpeg格式的图片'));
				exit;
			}
			if(!move_uploaded_file ($_FILES['cover_pic']['tmp_name'], $file_url)){
				echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
				exit;
			}else{
				$linedoc=substr($file_url,1 );
				$linename=$_FILES['cover_pic']['name'];
				echo json_encode(array('status' =>1, 'url' =>$linedoc,'urlname'=>$linename));
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		}
	}
	//多图片上传的时候的处理程序
	function upload_picsArr(){
		$this->load->helper ( 'url' );
		$config['upload_path'] = './file/c/travel';
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
			$url =  '/file/c/travel/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url,'msg'=>'上传成功!' ));
			exit;
		}
	}
	//选择产品的标签
	function sel_tages(){
		$id=$this->input->post('id');
		if(is_numeric($id)){
			$line_tages=$this->travel->get_alldata('u_line',array('id'=>$id));
			if(!empty($line_tages)){
				//线路属性
			 	$html=''; 
			 	$attrid='';
				if(!empty($line_tages['linetype'])){
					$tagesArr=explode(',', $line_tages['linetype']);
					$attrArr=$this->travel->line_attr_row($tagesArr);
					if(!empty($attrArr)){
						foreach ($attrArr as $k=>$v){
							$html.='<li value='.$v['id'].'>'.$v['attrname'].'<i>X</i></li>';
							$attrDatali[]=$v['id'];	
						}
						if(!empty($attrDatali)){
							$attrid=implode($attrDatali, ',');
						}
					}
				 } 
				 echo json_encode(array('status' =>1,'html' =>$html,'tages'=>$attrid));
			     exit; 
			}
		}
	}
	//删除游记
	function delete(){
		//var_dump($_POST);
		$id=$this->input->post('id');
		if($id>0){
			$re=$this->travel->del_imgdata('travel_note_pic',array('id'=>$id));
			if($re){
				echo json_encode(array('status' =>1,'msg'=>'删除成功!'));
				exit;
			}else{
				echo json_encode(array('status' =>-1,'msg'=>'删除失败!'));
				exit;
			}	
		}else{
			echo json_encode(array('status' =>-1,'msg'=>'删除失败!'));
			exit;
		}
		
	}
	//申请体验师
	function app_experience(){
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$orderid=$this->input->post('orderid');
		if(empty($orderid)){
			echo json_encode(array('status' =>-1,'msg'=>'请选择订单!'));
			exit;
		}
		$experience=$this->member->get_alldata('u_member_experience',array('member_id'=>$userid),'id');
		
		if($orderid>0){
			if(empty($experience)){
				// 插入表
				$insert_data=array('member_id'=>$userid,'status'=>0,'order_id'=>$orderid);
				$mid=$this->member->insert_data('u_member_experience',$insert_data);
				if($mid>0){
					echo json_encode(array('status' =>1,'msg'=>'申请成功！等待平台审核'));
				}else{
					echo json_encode(array('status' =>-1,'msg'=>'申请失败!'));
				}
			}elseif($experience['status']==0){
					echo json_encode(array('status' =>-1,'msg'=>'您已申请过了,正等待平台审核...'));	
			}elseif($experience['status']==1){
					echo json_encode(array('status' =>-1,'msg'=>'您已经成为体验师了'));
			}elseif($experience['status']==-1){
				// 插入表
				$insert_data=array('member_id'=>$userid,'status'=>0,'order_id'=>$orderid);
				$mid=$this->member->insert_data('u_member_experience',$insert_data);
				if($mid>0){
					echo json_encode(array('status' =>1,'msg'=>'你之前申请的体验师已被拒绝!现为您重新提交申请,请等待平台审核'));
				}else{
					echo json_encode(array('status' =>-1,'msg'=>'申请失败!'));
				}
			}
		}else{
			echo json_encode(array('status' =>-1,'msg'=>'选择订单线路'));
		}
	}
	
}