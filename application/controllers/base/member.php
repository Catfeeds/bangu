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

class Member extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'member_model', 'member');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
		//$this->load->helper ( 'My_md5' );
	}

	/*我的资料*/
	public function profile(){
		$this->load->library ( 'callback' );
		$data['title']='基本资料';
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//用户信息
		$where['mid']=$userid;
		$data['member']=$this->member->get_member_message('u_member',$where);

		if ($this->is_post_mode()) {            //修改用户资料
				$btn=$this->input->post('btn');
				$buttom=$this->input->post('buttom');
				//修改个人资料
				$updata['nickname']=$this->input->post('nickname');
				$updata['sex']=$this->input->post('sex');
				$updata['email']=$this->input->post('email');
				$updata['mobile']=$this->input->post('mobile');
				$updata['truename']=$this->input->post('truename');
				$updata['nickname']=$this->input->post('nickname');
				$updata['cardid']=$this->input->post('cardid');
				$updata['address']=$this->input->post('address');
				$updata['postcode']=$this->input->post('postcode');
				$yzm=$this->input->post('yzm');

			 /*  -------------------判断手机验证--------------------------  */
				if($data['member']['mobile']!=$updata['mobile']){
					$time = time();
					if(!empty($yzm)) {
						    //判断该手机是否存在
						    $member_where='mid != '.$userid.'  and  mobile="'.$updata['email'].'"';
						    $member_mobile=$this->member->get_alldata('u_member',$member_where);
							//判断手机验证码
							$custom_mobile_code = $this ->session ->userdata('mobile_code_time');
							if ($custom_mobile_code == false) {
								$this->callback->set_code ( 4000 ,"请您先获取验证码");
								$this->callback->exit_json();
							}
							//10分钟过期
							if ($time - $custom_mobile_code['time'] > 600) {
								$this ->session ->unset_userdata('mobile_code_time');
								$this->callback->set_code ( 4000 ,"您的验证码已过期，请重新获取 ");
								$this->callback->exit_json();
							}

							if ($yzm != $custom_mobile_code['code'] || $updata['mobile'] != $custom_mobile_code['mobile']) {
								$this->callback->set_code ( 4000 ,"您输入的验证码不正确");
								$this->callback->exit_json();
							}
						} else {
							$this->callback->set_code ( 4000 ,"请填写验证码");
							$this->callback->exit_json();
						}
						$updata['loginname']=$updata['mobile'];
				}
				$re=$this->member->updata_member_message($userid,$updata);
				if($re){
					//清除手机验证码
					$this ->session ->unset_userdata('mobile_code_time');
					$this->callback->set_code ( 2000 ,"修改资料成功！");
					$this->callback->exit_json();
				}else{
					$this->callback->set_code ( 4000 ,"修改资料失败！");
					$this->callback->exit_json();
				}
			}else{
				$this->load->view('base/profile',$data);
			}


	}

	/*修改密码*/
	public function updata_password(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$data['title']='修改密码';
		//用户信息
		$where['mid']=$userid;
		$data['member']=$this->member->get_member_message('u_member',$where);

		if($this->is_post_mode()){
			//表单的验证
			$this -> form_validation -> set_rules('pwd' , '原始密码' , 'required');
			$this -> form_validation -> set_rules('pwd1' , '新密码' , 'required');
			$this -> form_validation -> set_rules('pwd2' , '重复密码' ,  'required|matches[pwd1]');
			//表单验证不通过
			if($this -> form_validation ->run() === true) {
				$loginname=$this->input->post('loginname');
				$pwd=$this->input->post('pwd');
				$pwd1=$this->input->post('pwd1');
				if($data['member']['pwd']==md5(trim($pwd))){
					$updata['pwd']=md5(trim($pwd1));
					$where=array(
							'loginname'=>trim($loginname),
							'pwd'=>md5(trim($pwd))
					);
					//修改密码
					$this->member->updata_alldata('u_member',$where,$updata);
					$data['ok']= 1;
					$data['message']= '修改密码成功';
				}else{
					$data['message']= '密码输入不对';
				}
			}
		}

		$this->load->view('base/member_password',$data);
	}

	/*我的点评     */
	public function comment($page=1){
		if($page<1){
			$page=1;
		}
		$data['title']="我的评价";
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');

		//未点评状态   5未点评  6、8点评 
		$data['noid']=$this->member->on_comment(0,$userid);
                 //    var_dump($data['noid']);
		//已点评 的总数
		$where="(c.status=1 ) ";
		$data['did']=$this->member->on_comment(1,$userid);

		$data['type']=$this->uri->rsegment(3);
		$sty=$this->uri->rsegment(2);

    		$data['type']=$sty;
	   	$post_arr = array();//查询条件数组
	   	$post_arr['mo.memberid']=$userid;
	   	$wh='(c.status=1 )';
	 	//$post_arr["mo.status"]=5;
	   	$this->load->library('Page');
	   	$config['base_url'] = '/base/member/comment_';
	   	$config ['pagesize'] = 10;
	   	$config ['page_now'] = $page;

	   	//我的点评订单的信息
	   	$config ['pagecount'] = count($this->member->get_order_message($wh,$post_arr, 0, $config['pagesize']));
		
	   	$data['order']=$this->member->get_order_message($wh,$post_arr,$page, $config['pagesize']);
  		//echo $this->db->last_query();
	   	$this->page->initialize ( $config );
	   	$this->load->view('base/comment',$data);

	}
    /*未评论*/
	function ncomment($page=1){
	  	if($page<1){
			$page=1;
		}
		$data['title']="我的评价";
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//未点评状态   5未点评  6、8点评
		$data['noid']=$this->member->on_comment(0,$userid);
		//$where=array('1'=>6,'2'=>8);
		$where="(c.status=1) ";
		$data['did']=$this->member->on_comment(1,$userid);
		//echo $this->db->last_query();
		$data['type']=$this->uri->rsegment(3);
		$sty=$this->uri->rsegment(2);

    		$data['type']=$sty;
	   	$post_arr = array();//查询条件数组
	   	$post_arr['mo.memberid']=$userid;
	 	 //$post_arr["mo.status"]=5;
	   	$this->load->library('Page');
	   	$config['base_url'] = '/base/member/ncomment_';
	   	$config ['pagesize'] = 10;
	   	$config ['page_now'] = $page;

	   	//我的点评订单的信息
	   	$config ['pagecount'] = count($this->member->get_order_travel($post_arr, 0, $config['pagesize']));
	    	$data['allData']=$config ['pagecount'];
	   	$data['order']=$this->member->get_order_travel($post_arr,$page, $config['pagesize']);
   		//echo $this->db->last_query();
	   	$this->page->initialize ( $config );
	   	$this->load->view('base/ncomment',$data);
	   	
	}
	
	/*编辑评论*/
	public function editcomment_ajax($page=1){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$post_arr['mo.memberid']=$userid;
		$id=$this->input->post('data');
		$where['c.id']=$id;
		$data['rows']=$this->member->get_order_message('',$where);
		$data['tyle']=2;
	   	echo  json_encode($data);
	//	$this->load->view('base/editcomment_ajax',$data);
	}
	/*追评*/
	public function gocomment_ajax($page=1){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$post_arr['mo.memberid']=$userid;
		$id=$this->input->post('data');
		$where['c.id']=$id;
		$rows=$this->member->get_order_message('',$where);
		if(!empty($rows[0])){
			$data=$rows[0];
		}else{
			$data='';
		}
		//$this->load->view('base/editcomment_ajax',$data);
		echo json_encode(array('status'=>1,'data'=>$data));
	}
	/*评论的订单信息*/
	function AddCommentData(){
		$order='';
		$orderid=$this->input->post('orderid');
		if($orderid>0){
			$order=$this->member->get_alldata('u_member_order',array('id'=>$orderid));
			echo  json_encode(array('status'=>1,'order'=>$order));
		}else{
			echo  json_encode(array('status'=>-1,'order'=>$order));
		}
	}
    /*保存点评评论*/
	public function save_diancomment(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$type=$this->input->post('type');
		//判断是否已评论
		$hidden_id=$this->input->post('hidden_id');
		$wh_arr['id']=$hidden_id;
		$rows=$this->member->get_alldata('u_comment',$wh_arr);

		$content=$this->input->post('comment');
		$data['score1']=$this->input->post('score0');
		$data['score2']=$this->input->post('score1');
		$data['score3']=$this->input->post('score2');
		$data['score4']=$this->input->post('score3');
		$data['score5']=$this->input->post('score4');
		$data['score6']=$this->input->post('score5');
		$data['content']=trim($content);
		$data['orderid']=$this->input->post('moid');
		$data['memberid']=$userid;
		$where['id']=$rows['id'];
		if(!empty($data['content'])){  //判断内容是否已编辑
			$wh['id']=$this->input->post('moid');
			$res['status']=6;
			$this->member->updata_alldata('u_member_order',$wh,$res);
		}
		$re=$this->member->updata_alldata('u_comment',$where,$data);
		 if($re){
		 	echo 1;
		 }else{
		 	echo 0;
		 }

	}
	/*保存评论*/
	public function save_comment(){
		if(isset($_POST['go_on'])){ //追评
			$content=$this->input->post('content');
			$content1=$this->input->post('content1');
			$id=$this->input->post('id');
			$where['id']=$id;
			$data['content']='。'.trim($content1);
			$stutas=$this->member->save_gocomment($id,$data['content']);
			if($stutas){
				echo true;
			}else{
				echo false;
			}

		}elseif(isset($_POST['type']) && $_POST['type']=='updata'){ //编辑点评
		 	$content=$this->input->post('content1');
		        	$data['expert_content'] =$this->input->post('content2');
		       	$score0=$this->input->post('score0');
		        	$score1=$this->input->post('score1');
		        	$score2=$this->input->post('score2');
		        	$score3=$this->input->post('score3');
		        	$score4=$this->input->post('score4');
		        	$score5=$this->input->post('score5');
		        	$data['score1'] =$this->input->post('score0');
		        	$data['score2'] =$this->input->post('score1');
		        	$data['score3'] =$this->input->post('score2');
		        	$data['score4'] =$this->input->post('score3');
		        	$data['score5'] =$this->input->post('score4');
		        	$data['score6'] =$this->input->post('score5');
		        	$data['avgscore1'] =($score0+$score1+ $score2+$score3)/4;
		        	$data['avgscore2'] =($score4+$score5)/2;
		        	$data['isanonymous']=$this->input->post('isanonymous');
		       	$img =$this->input->post('img');
			if(!empty($img)){
			           $data['pictures']=implode(',',$img);
			}
			$id=$this->input->post('id');
			$where['id']=$id;
			$data['content']=trim($content);
			$re=$this->member->updata_alldata('u_comment',$where,$data);
			if($re){
				echo 1;
			}else{
				echo 0;
			}
		}

	}
   	 /*保存评论*/
	function add_comment(){
		//会员
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		
		$content=$this->input->post('content1');
		$data['expert_content'] =$this->input->post('content2');
		$score0=$this->input->post('score0');
		$score1=$this->input->post('score1');
		$score2=$this->input->post('score2');
		$score3=$this->input->post('score3');
		$score4=$this->input->post('score4');
		$score5=$this->input->post('score5');
		$data['score1'] =$this->input->post('score0');
		$data['score2'] =$this->input->post('score1');
		$data['score3'] =$this->input->post('score2');
		$data['score4'] =$this->input->post('score3');
		$data['score5'] =$this->input->post('score4');
		$data['score6'] =$this->input->post('score5');
		$data['avgscore1'] =($score0+$score1+ $score2+$score3)/4; //评论平均值
		$data['avgscore2'] =($score4+$score5)/2;
		$lineid=$this->input->post('lineid');
		$data['line_id']=$lineid;
		$expert_id=$this->input->post('expert_id'); //管家id
		$data['expert_id']=$expert_id;
		$isanonymous=$this->input->post('isanonymous'); //匿名评论
		if($isanonymous==1){  //是否匿名
			$data['isanonymous']=1;
		}else{
			$data['isanonymous']=0;
		}
		//获取线路的始发地
		$citystr='';
		$this->load->model ( 'admin/b1/user_shop_model' );
		$cityArr=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineid));
		foreach ($cityArr as $k=>$v){
			if(!empty($v['startplace_id'])){
				$citystr=$citystr.$v['startplace_id'].',';
			}
		}
		$data['starcityid'] = trim($citystr ,',');
		
		$img =$this->input->post('img');
		if(!empty($img)){
			$data['pictures']=implode(',',$img);
		}
		$data['content']=trim($content);
		$data['channel'] = 0;
		$data['isshow'] = 1;
		if(empty($img)){  //是否上传图片
			$data['haspic'] = 0;
		}else{
			$data['haspic'] = 1;
		}
		
		/*******送积分*****/
		$integral=0;
		if($data['avgscore1']>0){ //送积分
			$integral=100;
		}
		if(!empty($content)){
			$integral=$integral+500;
			$content_len=mb_strlen($content, 'UTF-8');
			if($content_len>30){
				$integral=$integral+500;
			}
		}
		if(!empty($pic_url)){ 
			$integral=$integral+500;
		}
		$data['memberid']=$userid;
		$data['addtime']=date('Y-m-d H:i:s',time());
		$data['orderid']=$this->input->post('orderid');
		$data['jifen'] = $integral;
		if($data['orderid']>0){
			$comment=$this->member->get_alldata('u_comment',array('orderid'=>$data['orderid'],'status'=>1));
			if(empty($comment)){
				$re=$this->member->save_commentData($data,$integral,$lineid,$userid,$expert_id);
				if($re>0){
				    //统计订单操作数据
			    		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
				   	 $this->order_status_model->update_order_status_cal($data['orderid']);
				    	//删除缓存
					$this->cache->redis->delete('SYhomeComment');
				     	echo json_encode(array('status' => 1,'msg' =>'提交成功'));	
				}else{
					 echo json_encode(array('status' => -1,'msg' =>'提交失败'));
				}
				
			}else{
				echo json_encode(array('status' => -1,'msg' =>'你已经点评过了.'));
			}
			
		}else{
			echo json_encode(array('status' => -1,'msg' =>'提交失败'));
		}
	}
	
	/*我的收藏*/
	public function collect($page=1){
		$this->load->library('Page');
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');

		//我的收藏
 		$config['base_url'] = '/base/member/collect_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->member->get_collect_data($userid,0, $config['pagesize']));
		$data['row'] = $this->member->get_collect_data($userid, $page, $config['pagesize']);
		$this->page->initialize ( $config );
		$data['title']='线路收藏';
		$this->load->view('base/collect',$data);
	}

	//我的分享
	function myshare($page=1){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');

		//分享
		$data['share']=count($this->member->get_data('u_line_share',array('member_id'=>$userid)));
		//人气
		$data['hits']=$this->member->get_hits($userid);
		//赞
		$data['praise']=$this->member->get_praise($userid);

		//分页
		$where['ls.member_id'] = $userid;
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/member/myshare/';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->member->get_myshare($where, 0, $config['pagesize']));
		$data['row']=$this->member->get_myshare($where,$page, $config['pagesize']); //分享数据
		$data['title']='我的分享';
		$this->page->initialize ( $config );

		$this->load->view('base/myshare',$data);

	}

	/*添加我的分享*/
	function add_share(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');

		$title=$this->input->post('title');
		$img_url=$this->input->post('img_url');

		//插入我的分享表
		$insert=array(
			'member_id'=>$userid,
			'content' =>$title,
			'addtime' =>date('Y-m-d H:i:s',time()),
			'praise_count'=>0,
			'location'=>'深圳',
			'cover_pic'=>$img_url[0],
		);
		$share_id=$this->member->insert_data('u_line_share',$insert);
		if(is_numeric($share_id)){
			if(!empty($img_url)){
				foreach ($img_url as $k=>$v){
					$pic_insert=array('line_share_id'=>$share_id,'pic'=>$v);
					$pic_id=$this->member->insert_data('u_line_share_pic',$pic_insert);
					if(is_numeric($pic_id)){
						echo true;
					}else{
						echo false;
					}
				}
			}
		}else{
			echo false;
		}
	}

	/* 遍历我的分享*/
	function by_shareid(){
		$id=$this->input->post('id');
		if(is_numeric($id)){
			$data['share_content']=$this->member->get_alldata('u_line_share',array('id'=>$id));
			$data['share_pic']=$this->member->get_data('u_line_share_pic',array('line_share_id'=>$id));
			echo  json_encode($data);
		}
	}

	/*编辑我的分享*/
	function editor_share(){
		//标题
		$id=$this->input->post('editor_id');
		$title=$this->input->post('editor_title');
		$img_url=$this->input->post('img_url');
		if(!empty($title)){
			if(is_numeric($id)){
				$data=array('content'=>$title,'addtime'=>date('Y-m-d H:i:s',time()),'cover_pic'=>$img_url[0]);
				$where=array('id'=>$id);
				$this->member->updata_alldata('u_line_share',$where,$data);
			}
			echo true;
		}else{
			echo false;
		}
		//添加图片
		$pic=$this->input->post('editor_pic_arr');
		$pic_arr=explode(';', $pic);
		$pic_arr=array_flip($pic_arr);
		if(!empty($pic_arr)){
			foreach ($pic_arr as $k=>$v){
				if(!empty($k)){
					$data_arr=array('pic'=>$k,'line_share_id'=>$id);
					$this->member->insert_data('u_line_share_pic',$data_arr);
				}
			}
		}
	}

	/*我的分享  删除图片*/
	function del_share_img(){
		$id=$this->input->post('data');
		if($id>0){
			$this->db->delete('u_line_share_pic', array('id' => $id));
		}
	}
 
	 //我的定制单
	function mycustom($page=1){
    		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$tyle=$this->input->get('tyle');

		//分页
		if($page<1){
			$page=1;
		}
		$where='';
		$this->load->library('Page');
		$config['base_url'] = '/base/member/mycustom_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->member->get_custom($where, 0, $config['pagesize']));
		$data['row']=$this->member->get_custom($where,$page, $config['pagesize']);
		
		//查询目的地
		if(!empty($data['row'])){
			foreach ($data['row'] as $k=>$v){
				if(!empty($v['endplace'])){
					$destination=explode(',', $v['endplace']);
					if(!empty($destination)){
					   $data['row'][$k]['dest']=$this->member->getDestinationsID($destination);
					}
				}
			}
		}
		$data['title']="我的定制单";
		$this->page->initialize ( $config );
		$this->load->view('base/mycustom',$data);

	}

	/*查看方案*/
	function scheme(){
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$data['userid']=$userid;
		$data['type']='scheme';
		//客户需求
		$id=$this->input->post('data');
		$where['id']=$id;
		$data['data']=$this->member->get_user_need($id);

		//查询目的地
		if(!empty($data['data'])){
			foreach ($data['data'] as $k=>$v){
				$destination=explode(',', $v['endplace']);
				$data['data'][$k]['dest']=$this->member->getDestinationsID($destination);
			}
		}
		//指定管家的信息
		$data['expert']=array();
		$customize_id=$data['data'][0]['id'];
		if(!empty($customize_id)){
			$data['expert']=$this->member->get_expert_custom(array('c.customize_id'=>$customize_id,'c.isuse'=>1));
		}

	           //查看方案
		$data['solution']=$this->member->get_scheme_data($id);
		$data['status']=$this->input->post('status');
		$this->load->view('base/custom_box',$data);

	}
	//会员登录
	function get_member_login(){
	    	$userid=$this->session->userdata('c_userid');
	    	if($userid>0){
	    		echo 1;
	    	}else{
	    		echo -1;
	    	}
	}
	function update_custom(){
		$cid=$this->input->post('c_id');
		$lineid=$this->input->post('lineid');
		$line=$this->member->get_data('u_line',array('id'=>$lineid));
		if(!empty($line[0]['mainpic'])){
			$pic=$line[0]['mainpic'];
		}else{
			$pic='';
		}
		if(!empty($cid)){
		   $this->member->updata_alldata('u_customize',array('id'=>$cid),array('pic'=>$pic,'status'=>3));
		}
	}
	/*查看回复方案  、二级弹框*/
	function  reply_scheme(){
		$data['type']='reply_scheme';
		//我的需求
		$cu_id=$this->input->post('cu_id');
		$where['id']=$cu_id;

		if($cu_id>0){
	 		 $data['customize']=$this->member->get_reply_scheme($cu_id);
		 	 //查询目的地
			 if(!empty( $data['customize']['endplace'])){
			 	$destination=explode(',', $data['customize']['endplace']);
		 	    	$data['customize']['dest']=$this->member->getDestinationsID($destination);
		 	 }
		 	 //指定管家的信息
		 	 $data['expert']=array();
		 	 $customize_id=$data['customize']['id'];
		 	 if(!empty($customize_id)){
		 	 	$data['expert']=$this->member->get_expert_custom(array('c.customize_id'=>$customize_id,'c.isuse'=>1));
		 	 }
		}
		//行程设计
		$id=$this->input->post('id');
		if(is_numeric($id)){
		  	$data['rout']=$this->member->get_route_data($id);	
		  	//已读的方案
		  	$this->member->updata_alldata('u_customize_answer',array('id'=>$id),array('isread'=>1));
		}
		
		$data['status']=$this->input->post('status');
		$this->load->view('base/custom_box',$data);

	}

	/*选择此方案*/
	function sel_scheme(){
		/*选择此方案*/
		$data['isuse ']=1;
		$ans_id=$this->input->post('ans_id');
		$cust_id=$this->input->post('cust_id');
		$expert_id=$this->input->post('expert_id');
 		if(is_numeric($ans_id)){
			$this->member->updata_alldata('u_customize',array('id'=>$cust_id),array('status'=>1,'is_assign'=>1,'expert_id'=>$expert_id));
		     	$re= $this->member->updata_alldata('u_customize_answer',array('id'=>$ans_id),array('isuse'=>1));
			if($re){
			 	echo true;
			}else{
			 	echo false;
			}
		}else {
			echo false;
		}
	}

   //取消定制单
   function cancel_custom(){
   	    $cid=$this->input->post('c_id');
	    if(is_numeric($cid)){
	     	$this->member->updata_alldata('u_customize',array('id'=>$cid),array('status'=>-2));
	     	echo  true;
	     }else{
	     	echo  false;
	     }
   }
    //定制单的信息、
/*     function show_order(){

    	$this->load->library('session');
    	$userid=$this->session->userdata('c_userid');
    	$id=$this->input->post('id');
    	$data=array();
    	if(is_numeric($id)){

    		$where=array('c.id'=>$id,'ca.isuse'=>1,'eg.isuse'=>1);
    		$data['order_message']=$this->member->get_custom_data($where);

    		//订单金额
    		$data['budget']=$this->member->get_custom_budget($id);
 
    		//获取中国的省份
    		$sql = "select id,name from u_area where pid = 2 and isopen = 1 ";
    		$query = $this ->db ->query($sql);
    		$data['area'] = $query ->result_array();
    		//获取证件类型
    		$this->load->model ( 'dictionary_model', 'dictionary_model' );
    		$data['dict_data'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_CERTIFY_WAY);
    	}


    	$this->load->view('base/return_order',$data);

    } */
    /*转定制单*/
    function save_custom_order(){
    	$this->load->library ( 'callback' );
    	$this->load->helper ( 'regexp' );
    	$time =  date('Y-m-d H:i:s' ,time());
    	$this->load->library('session');
    	$userid=$this->session->userdata('c_userid');
    	//验证发票
    	try{
	    	$isneedpiao=$this->input->post('isneedpiao');
	    	if($isneedpiao==1){
	    		$this ->load_model('area_model');
	    		$invoice_name=$this->input->post('invoice_name');
	    		$receiver=$this->input->post('receiver');
	    		$address=$this->input->post('address');
	    		$telephone=$this->input->post('telephone');
	    		//验证收件人
	    		if (!empty($receiver)) {
	    			if (!preg_match('/^([\x{4e00}-\x{9fa5}]+)$|^([a-z]+)$/u' ,$receiver)) {	
	    				$this->callback->set_code ( 4000 ,"请填写正确的发票收件人姓名,可为汉字或字母");
	    				$this->callback->exit_json();
	    			}
	    		}
	    		//手机
	    		if (!empty($telephone)) {
	    			if (!regexp('mobile' ,$telephone)) {
	    				$this->callback->set_code ( 4000 ,"请填写正确的发票人联系手机号");
	    				$this->callback->exit_json();
	    			}
	    		}
	    	}

	    	//写入线路表
	     	$linename=$this->input->post('linename');
	    	$startcity=$this->input->post('startcity');
	    	$overcity=$this->input->post('overcity');
	    	$overcity2=$this->input->post('overcity2');
	    	$lineprice=$this->input->post('lineprice');
	    	$lineday=$this->input->post('lineday');
	    	$linenight=$this->input->post('linenight');
	    	$supplier_id=$this->input->post('supplier_id');
	    	$hotel_start=$this->input->post('hotelstar');
	    	$agent_rate=$this->input->post('agent_rate');
	    	$budget=$this->input->post('budget');
	    	$childprice=$this->input->post('childprice');
	    	$price=$this->input->post('price');
	    	$childnobedprice=$this->input->post('childnobedprice');
	    	$startdate=$this->input->post('startdate');
	    	$people=$this->input->post('people');
	    	$childnum=$this->input->post('childnum');
	    	$linkname=$this->input->post('linkname');
	    	$email=$this->input->post('email');
	    	$linkphone=$this->input->post('linkphone');
	    	$expert_id=$this->input->post('expert_id');
	    	$realname=$this->input->post('realname');
	    	$srealname=$this->input->post('srealname');
	    	$customize_id=$this->input->post('customize_id');
	    	//验证游客信息(暂时不验证游客信息)
	    	$this->db->trans_begin(); //事务开始

			$lineArr=array(
				'linetype'=>'',
				'producttype'=>1,
				'linename'=>$linename,
				'startcity'=>$startcity,
				'overcity'=>$overcity,
				'lineday'=>$lineday,
				'lineday'=>$lineday,
				'linenight'=>$linenight,
				'addtime'=>$time,
				'supplier_id'=>$supplier_id,
				'status'=>0,
				'hotel_start'=>$hotel_start,
				'agent_rate'=>$agent_rate,
			);
			$lineid=$this->member->insert_data('u_line',$lineArr);
			if($lineid>0){
				$linecode='B'.$lineid;
				$this->member->updata_alldata('u_line',array('id'=>$lineid),array('linecode'=>$linecode));
			}else{
				throw new Exception('生成线路不成功!');
			}
			//写入订单表
			$orderArr=array(
				  'ordersn' =>$this ->create_ordersn(),
				  'memberid'=>$userid,
				  'productname'=>$linename,
				  'productautoid'=>$lineid,
				  'price'=>$budget,
				  'childprice'=>$childprice,
				  'childnobedprice'=>$childnobedprice,
				  'usedate'=>$startdate,
				  'dingnum'=>$people,
				  'childnum'=>$childnum,
				   'ispay'=>0,
				   'status'=>0,
				  'linkman'=>$linkname,
				  'linkemail'=>$email,
				  'linkmobile'=>$linkphone,
				  'isneedpiao'=>$isneedpiao,
				  'addtime'=>$time,
				  'expert_id'=>$expert_id,
				  'supplier_id'=>$supplier_id,
				  'expert_name'=>$realname,
				  'supplier_name'=>$srealname,
				  'first_pay'	=>$lineprice,
				  'total_price'=>$lineprice,
				  'customize_id'=>$customize_id
			);
	    	$orderid=$this->member->insert_data('u_member_order',$orderArr);
	    	if(!$orderid){
	    		throw new Exception('写入订单表失败');
	    	}
	        	$allchild=$this->input->post('allchild');
	    	$hasold=$this->input->post('hasold');
	    	$hasforeign=$this->input->post('hasforeign');
	    	$iszhuan=$this->input->post('iszhuan');
	    	$isyan=$this->input->post('isyan');
	    	$isgai=$this->input->post('isgai');
	    	$iscai=$this->input->post('iscai');
	    	//写入订单附表
	     	$attacArr = array(
	    			'orderid' =>$orderid,
	    			'allchild' =>intval($allchild),
	    			'hasold' =>intval($hasold),
	    			'hasforeign' =>intval($hasforeign),
	    			'iszhuan' =>intval($iszhuan),
	    			'isyan' =>intval($isyan),
	    			'isgai' =>intval($isgai),
	    			'iscai' =>intval($iscai)
	    	);

	    	$status = $this ->db ->insert('u_member_order_attach' ,$attacArr);
				if ($status == false) {
					throw new Exception('写入订单附表失败');
			   	}
				//写入订单日志
				$logArr = array(
						'order_id' =>$orderid,
						'op_type' => 0,
						'userid' =>$userid,
						'content' =>'用户自己下单',
						'addtime' => $time
				);
				$log_status = $this ->db ->insert('u_member_order_log' ,$logArr);
				if ($log_status == false) {
					throw new Exception('写入订单日志表失败');
				}
	    	//写入出游人
	     	$linkename=$this->input->post('linkename');
	    	$certificate_no=$this->input->post('certificate_no');
	    	$certificate_type=$this->input->post('certificate_type');
	    	$birthday=$this->input->post('birthday');
	    	$people_sum=$people+$childnum;
	    	$i = 0;
	    	for( $i ;$i < $people_sum ; $i++) {
	    		$traverArr=array(
	    			'name'=>$linkename[$i],
	    			'certificate_type'=>$certificate_type[$i],
	    			'certificate_no'=>$certificate_no[$i],
	    			'addtime'=>$time,
	    			'modtime'=>$time,
	    			'sex'=>3,
	    		);
	    		$traver_id =$orderid=$this->member->insert_data('u_member_traver',$traverArr);
	    		if ($traver_id == false) {
	    			throw new Exception('写入出游人信息表失败');
	    		}
	    		//写入订单出游人信息关联表
	    		$orderManArr = array(
	    				'order_id' =>$orderid,
	    				'traver_id' =>$traver_id
	    		);
	    		$status = $this ->db ->insert('u_member_order_man' ,$orderManArr);
	    		if ($status == false) {
	    			throw new Exception('写入订单出游人信息关联表失败');
	    		}

	        }
	        //*************保存发票************/
	        if($isneedpiao==1){
	    		//获取地区名字
	    		if (isset($_POST['province']) && $_POST['province'] > 0) {
	    			$parea = $this ->area_model ->row(array('id' =>intval($_POST['province'])));
	    			$pname = $parea['name'];
	    		} else {
	    			$pname = '';
	    		}
	    		if (isset($_POST['city']) && $_POST['city'] > 0) {
	    			$carea = $this ->area_model ->row(array('id' =>intval($_POST['city'])));
	    			$cname = $carea['name'];
	    		} else {
	    			$cname = '';
	    		}
	    		if (isset($_POST['region']) && $_POST['region'] > 0) {
	    			$rarea = $this ->area_model ->row(array('id' =>intval($_POST['region'])));
	    			$rname = $rarea['name'];
	    		} else {
	    			$rname = '';
	    		}
	    		$address = $pname.$cname.$rname.$address;
	    		$insert_invoice=array(
	    			'invoice_type'=>0,
	    			'invoice_name'=>$invoice_name,
	    			'receiver'=>$receiver,
	    			'telephone'=>$telephone,
	    			'address'=>$address,
	    			'addtime'=>$time,
	    			'member_id'=>$userid,

	    		);
	    		$this->member->insert_data('u_member_invoice',$insert_invoice);
	    		$invoiceId = $this ->db ->insert_id();
	    		//写入订单关联发票信息表
	    		$orderInvoiceArr = array(
	    				'order_id' =>$orderid,
	    				'invoice_id' =>$invoiceId
	    		);
	    		$status = $this ->db ->insert('u_member_order_invoice' ,$orderInvoiceArr);
	    		if ($status == false) {
	    			throw new Exception('写入订单关联发票信息表失败');
	    		}
	        }
	        //修改定制单的状态
	        $this->member->updata_alldata('u_customize',array('id'=>$customize_id),array('status'=>3));

	        if ($this->db->trans_status() === FALSE) { //判断此组事务运行结果
	        		throw new Exception('下单失败');
	        		$this->db->trans_rollback();
	        } else {
	        		$this->db->trans_commit();
	        }
	        $this ->session ->unset_userdata('order');
	        $this ->session ->set_userdata(array('cOrderId' =>$orderid));
	        $this->callback->set_code ( 2000 ,'下单成功');
	        $this->callback->exit_json();

        } catch (Exception $e) {
        	$this->db->trans_rollback(); //出现错误执行回滚
        	$error = $e->getMessage();
        	$this->callback->set_code ( 4000 ,$error);
        	$this->callback->exit_json();
        }

    }
    //生成订单号
    public function create_ordersn() {
    	$this->load->model ( 'order_info_model', 'order_model' );
    	$year = date('Y' ,time());
    	$ordersn = substr($year,2).mt_rand(10000000 ,99999999);
    	$order = $this ->order_model ->row(array('ordersn' =>$ordersn));
    	if (!empty($order)) {
    		$this ->create_order();
    	} else {
    		return $ordersn;
    	}
    }
   //我的发票
   function invoice($page=1){
	   	//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//分页
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/member/invoice_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->member->get_invoice_data($userid, 0, $config['pagesize']));
		$data['row']=$this->member->get_invoice_data($userid,$page, $config['pagesize']);

		$this->page->initialize ( $config );
		$data['title']='我的发票';
	    	$this->load->view('base/invoice',$data);
   }

   //我的积分
  function integral($page=1){
  	//启用session
  	$this->load->library('session');
  	$userid=$this->session->userdata('c_userid');
  	//用户信息
  	$where['mid']=$userid;
  	$data['member']=$this->member->get_member_message('u_member',$where);

  	$this->load->library('Page');
  	$config['base_url'] = '/base/member/integral_';
  	$config ['pagesize'] = 10;
  	$config ['page_now'] = $page;
  	$config ['pagecount'] = count($this->member->get_point_log($userid));
  	$data['jifen']=$this->member->get_point_log($userid,$page, $config['pagesize']);
  	$this->page->initialize ( $config );
  	$data['title']='我的积分';
  	$this->load->view('base/integral',$data);
  }

  //管家的收藏
  function collect_expert($page=1){
  	//启用session
  	$this->load->library('session');
  	$userid=$this->session->userdata('c_userid');

  	//管家的收藏
  	$this->load->library('Page');
  	$config['base_url'] = '/base/member/collect_expert_';
  	$config ['pagesize'] = 10;
  	$config ['page_now'] = $page;
  	$config ['pagecount'] = count($this->member->get_expert_collect($userid));
  	$data['row']=$this->member->get_expert_collect($userid,$page, $config['pagesize']);
  	$this->page->initialize ( $config );
  	$data['title']='管家收藏';
  	$this->load->view('base/collect_expert',$data);
  }
  //会员定制团线路
  function group_line($page=1){
  	//启用session
  	$this->load->library('session');
  	$userid=$this->session->userdata('c_userid');
  	
  	//会员定制团线路
  	$this->load->library('Page');
  	$config['base_url'] = '/base/member/group_line_';
  	$config ['pagesize'] = 10;
  	$config ['page_now'] = $page;
  	$config ['pagecount'] = count($this->member->get_member_group($userid));
  	$data['row']=$this->member->get_member_group($userid,$page, $config['pagesize']);
  	$this->page->initialize ( $config );
  	$data['title']='定制团线路';
  	//collect_exper
  	$this->load->view('base/group_line',$data);
  }

}
