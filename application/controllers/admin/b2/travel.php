<?php
/**
 * 专家相对应的游记
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年08月24日10:07:15
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Travel extends UB2_Controller {

	public function __construct() {
		parent::__construct ();
		//$this->load_model( 'member_model', 'member');
		$this->load_model( 'admin/b2/travel_model', 'travel');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
	}

	public function index() {
		$data = array();
		$this->load_view('admin/b2/travel_list_view.php', $data);
	}


	public function travel_list(){
		$post_arr = array();
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 10 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr['tn.userid'] = $this->expert_id;
		$travel_list = $this->travel->get_travel_list($post_arr, $page, $number);
		$pagecount = $this->travel->get_travel_list($post_arr,0);
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $travel_list
            	);
		echo json_encode($data);
	}




	//写游记
	public function release_travel(){
		//启用session
		$this->load->library('session');
		$userid=$this->expert_id;
	    //订单线路
		$data['line']=$this->travel->line_message($userid);
		//print_r($this->db->last_query());exit();
		//游记
		$id=$this->input->get('id');
		$data['line_attr']=$this->travel->sel_line_attr();
		if(is_numeric($id)){
			$get_data=$this->travel->get_alldata('travel_note',array('userid'=>$userid,'id'=>$id));
			if($get_data){
				$data['travel']=$this->travel->get_alldata('travel_note',array('id'=>$id));
				$data['foodpic']=$this->travel->get_data('travel_note_pic',array('pictype'=>1,'note_id'=>$id));//吃的图片
				$data['hotelpic']=$this->travel->get_data('travel_note_pic',array('pictype'=>2,'note_id'=>$id));//住的图片
				$data['walkpic']=$this->travel->get_data('travel_note_pic',array('pictype'=>3,'note_id'=>$id));//行的图片
				//产品标签
				/*if(!empty($data['travel']['tags'])){
					$tagesArr=explode(',',$data['travel']['tags']);
					$data['tagesStr']=$this->travel->line_attr_row($tagesArr);
				}*/
			}else{
				echo "<script>alert('该游记不能修改或不属于你的游记!');window.location.href='/admin/b2/travel/index';</script>";
			}
		}

		$this->load->view('admin/b2/release_travels_view',$data);
	}



	//保存游记
	function save_travel(){
		//启用session
		$this->load->library('session');
		$userid=$this->expert_id;
		//插入游记
		$orderArr=array();
		$walk_picsArr=array();
		$hotel_picsArr=array();
		$food_picsArr=array();
		$title=$this->input->post('title');
		$line_id=$this->input->post('lineid');
		$cover_pic=$this->input->post('cover_pic_string');
		$content=$this->input->post('content');
		$walk_pics_string=$this->input->post('walk_pics_string');
		$hotel_pics_string=$this->input->post('hotel_pics_string');
		$food_pics_string=$this->input->post('food_pics_string');
		$is_show=$this->input->post('is_show');
		$note_id=$this->input->post('travel_id');
		//$tags=$this->input->post('tags');
		$content=$this->input->post('content');
		$walk_content=$this->input->post('walk_content');
		$food_content=$this->input->post('food_content');
		$hotel_content=$this->input->post('hotel_content');
		$walk_id=$this->input->post('walk_id');
		$hotel_id=$this->input->post('hotel_id');
		$food_id=$this->input->post('food_id');
		$travel_impress=$this->input->post('travel_impress');
		/*if(!empty($order_id)){
			$orderArr=explode('-', $order_id);
		}*/

		if($is_show=='发布体验'){
			$is_show=1;
			$travel_status = 1;
		}elseif($is_show=='保存草稿'){
			$is_show=0;
			$travel_status = 0;
		}else{
			$is_show=0;
			$travel_status = 0;
		}


		//$status=$this->travel->updata_alldata('u_member',array('mid'=>$userid),array('travel_pic'=>$cover_pic));
		if(!empty($note_id)&& is_numeric($note_id)){    //修改游记

				$uptravelArr=array(
						'line_id'=>$line_id,
						'title'=>$title,
						'content'=>$content,
						'cover_pic'=>$cover_pic,
						'modtime'=>date('Y-m-d H:i:s',time()),
						//'tags'=>$tags,
						'is_show'=>$is_show,
						'status' => $travel_status,
						'travel_impress'=>$travel_impress
				);

				$status=$this->travel->updata_alldata('travel_note',array('id'=>$note_id),$uptravelArr);
			   if($status){
			    	// pictype:1吃,2住,3行,4购
				    if(!empty($walk_pics_string)){	  //修改     边走边拍的图片
				    	foreach ($walk_pics_string as $k=>$v){
				    		$walk_Arr=array(
				    				'pic'=>$v,
				    				'note_id'=>$note_id,
				    				'pictype'=>3,
				    				'addtime'=>date('Y-m-d H:i:s',time()),
				    				'description'=>$walk_content[$k],
				    		);
				    		if(!empty($walk_id[$k])){  //修改
				    	            $pic_status=$this->travel->updata_alldata('travel_note_pic',array('note_id'=>$note_id,'pictype'=>3,'id'=>$walk_id[$k]),$walk_Arr);
				    		}else{    //插入
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
				    				'addtime'=>date('Y-m-d H:i:s',time()),
				    				'description'=>$hotel_content[$k],
				    		);
				    		if(!empty($hotel_id[$k])){  //修改
				    			$pic_status=$this->travel->updata_alldata('travel_note_pic',array('note_id'=>$note_id,'pictype'=>2,'id'=>$hotel_id[$k]),$hotel_Arr);
				    		}else{    //插入
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
				    				'addtime'=>date('Y-m-d H:i:s',time()),
				    				'description'=>$food_content[$k],
				    		);
				    		if(!empty($food_id[$k])){  //修改
				    			$pic_status=$this->travel->updata_alldata('travel_note_pic',array('note_id'=>$note_id,'pictype'=>1,'id'=>$food_id[$k]),$food_Arr);
				    		}else{    //插入
				    			$foodid=$this->travel->insert_data('travel_note_pic',$food_Arr);
				    		}
				    	}
				    }

			     	echo "<script>alert('修改成功!'); window.opener.location.reload();window.close();</script>";
			   }else{
			     	echo "<script>alert('提交失败!'); window.opener.location.reload();window.close();</script>";
			   }

		}else{          //添加游记

			$travelArr=array(
					'line_id'=>$line_id,
					'title'=>$title,
					'content'=>$content,
					'cover_pic'=>$cover_pic,
					'userid'=>$userid,
					'is_show'=>$is_show,
					'addtime'=>date('Y-m-d H:i:s',time()),
					'usertype'=>1,
					'status' => $travel_status,
					//'tags'=>$tags,
					'travel_impress'=>$travel_impress

			);
			$travel_id=$this->travel->insert_data('travel_note',$travelArr);

			if($travel_id>0){  // pictype:1吃,2住,3行,4购
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
				if(!empty($food_pics_string)){ //酒店速写
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

				echo "<script>alert('提交成功!'); window.opener.location.reload();window.close();</script>";
			}else{
				echo "<script>alert('提交失败!'); window.opener.location.reload();window.close();</script>";
			}
		}
	}
	//删除游记
	function delete_travel(){
		$id=$this->input->post('travel_id');
    	if(is_numeric($id)){
			$status=$this->travel->updata_alldata('travel_note',array('id'=>$id),array('STATUS'=>-1,'is_show'=>0));
			if($status){
				echo json_encode(array('status' => 200,'msg' =>'删除成功'));
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
			echo json_encode(array('status' => -1,'msg' =>'请重新选择要上传的文件'));
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
}