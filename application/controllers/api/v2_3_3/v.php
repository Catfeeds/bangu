<?php
/**
 *   @name:APP接口 => 直播
 * 	 @author: 
 *   @time: 2016.05.25
 *   
 *	 @abstract:
 *
 *      1、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *        
 *      2、数据传递方式： POST
 * 		
 *      3、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */


if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//继承APP_Controller类
class V extends APP_Controller {
	public function __construct() {
		parent::__construct ();
		$this ->load_model('live/anchor_model' ,'anchor_model');
		$this ->load_model('live/video_model' ,'video_model');
	}

	/**
	 * @method:主播注册
	 * @author: xml
	 * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
	 * @return:
	 */
	public function save_live_anchor() 
	{
                  //  var_dump($_FILES['anchor_pic']);exit;

           	$user_id=$this->input->post ( 'user_id', true );
		$user_type=$this->input->post ( 'user_type', true );
		$user_type=$user_type; //类型
                      if($user_id==0){
                      	$this->__errormsg('user is null');
                      }
		//APP传来的数据
		$name=$this->input->post('name',true);//主播名
		$description=$this->input->post('description',true);//个人简介
		$comment=$this->input->post('comment',true);//个人签名

		$path = "/file/c/img/";
		$idcard=$this->cfgm_upload_pimg($path,'idcard');//身份证正面照
           	$idcardconpic=$this->cfgm_upload_pimg($path,'idcardconpic');//身份证反面照          	
		$video_pic=$this->cfgm_upload_pimg($path,'video_pic');//视频封面图
		$anchor_pic='';
		$anchor_pic=$this->input->post($path,'anchor_pic');//主播图片

		// 上传图片
		$anchor_pic_arr=$_FILES['anchor_pic'];
		//var_dump($anchor_pic_arr);
		$pics='';
		if ($_FILES['anchor_pic']) {
/*			foreach ( $anchor_pic_arr as $key => $val ) {				
				if ($val) {
					$input_name =$anchor_pic_arr[$key];
					$fx_pic = $this->cfgm_upload_pimg ( $path, $input_name);
					$pics[]= "/file/c/img/" . $fx_pic;
				}
			}*/
			$input_name ='anchor_pic';
			$fx_pic = $this->cfgm_upload_pimg( $path, $input_name);
			$pics[]= "/file/c/img/" . $fx_pic;
		}
		$anchor_pic=$pics;

		$anchor_attr=$this->input->post('anchor_attr',true);//签名;

		//验证数据
		if(empty($name)){$this->__errormsg ( '请填写主播名' );}
		if(empty($description)){$this->__errormsg ( '请填写个人简介' );}
		if(empty($comment)){$this->__errormsg ( '请填写个人描述' );}
		if(empty($idcardconpic)){$this->__errormsg ( '请上传身份证反面照' );}
		if(empty($idcard)){$this->__errormsg ( '请上传身份证正面照' );}
		if(empty($video_pic)){$this->__errormsg ( '请视频封面图' );}
		if(empty($anchor_pic)){$this->__errormsg ( '请上传我的图片' );}
		//if(empty($anchor_attr)){$this->__errormsg ( '请填写我的标签' );}

		//添加的数据
		$data['user_id']=$user_id;  
		$data['user_type']=$user_type; //注册类型
		$data['name']=$name ;     //主播名
		$data['description']=$description ;  //个人简介
		$data['comment']=$comment;//个人签名
		$data['idcard']=$path.$idcard;//身份证正面照
		$data['idcardconpic']=$path.$idcardconpic;//身份证正面照
		$data['video_pic']=$path.$video_pic;//视频封面图
		$data['addtime']=date("Y-m-d H:i:s",time());//添加时间
		$data['applytime']=date("Y-m-d H:i:s",time());//申请时间
		$data['modtime']=date("Y-m-d H:i:s",time());//修改时间
		$data['status']=0;//申请状态

		$anchor=$this->anchor_model->select_table('live_anchor',array('user_id'=>$user_id,'status'=>1,'user_type'=>$user_type));

		if(empty($anchor[0])){  //判断是否已注册
			$re=$this->anchor_model->save_anchor_data($data,$anchor_pic,$anchor_attr);

			if($re){
				echo json_encode(array('code'=>2000,'anchor_id'=>$re));  //成功返回数据
			}else{
				$this->__errormsg('注册异常');
			}
		}else{
			$this->__errormsg('您已成为主播了');
		}

	}
	/**
	*@method:申请用户
	 * @author: xml
	 * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
	*/
	function  insert_live_anchor(){

           	$user_id=$this->input->post ( 'user_id', true );
		$user_type=$this->input->post ( 'user_type', true );

		if($user_id>0 && $user_type==0){ //用户注册主播
			$user_id=$user_id ; 
			$user_type=0;   
			$user=$this->anchor_model->select_table('bangu.u_member',array('mid'=>$user_id)); //登录用户信息
			$data['realname']=$user[0]['truename']; //真实姓名
			$data['photo']=$user[0]['litpic']; //头像图片

		}elseif($user_id >0 && $user_type==1){ //管家注册主播
			$user_id=$user_id ;  
			$user_type=1;    
			$user=$this->anchor_model->select_table('bangu.u_expert',array('id'=>$user_id)); //管家用户信息
			$data['realname']=$user[0]['realname']; //真实姓名
			$data['photo']=$user[0]['big_photo']; //头像图片
			$data['country']=$user[0]['country']; //国家id

		}else{
			$this->__errormsg ( 'user is null !' );
		}

		//添加的数据
		$data['user_id']=$user_id;  
		$data['user_type']=$user_type; //注册类型
		$data['status']=5;//用户状态

		$data['mobile']=$user[0]['mobile']; //手机号
		$data['sex']=$user[0]['sex']; //性别
		$data['province']=$user[0]['province']; //省份id
		$data['city']=$user[0]['city']; //城市id

		$anchor=$this->anchor_model->select_table('live_anchor',array('user_id'=>$user_id,'user_type'=>$user_type));

		if(empty($anchor[0])){  //判断是否已是用户
			$re=$this->anchor_model->insert_liveAnchor($data);
			if($re>0){
				echo json_encode(array('code'=>2000,'anchor_id'=>$re));  //成功返回数据
			}else{
				$this->__errormsg('注册异常');
			}
		}else{
			//$this->__errormsg('您已经是用户');
			echo json_encode(array('code'=>'1','msg'=>'您已经是用户','anchor_id'=>$anchor[0]['anchor_id']));
		}

	}

	/**
	*@method:主播全部标签
	*@return:
	*/
	function get_anchor_attr(){
		$attr=$this->anchor_model->get_anchor_attr_data();
		$this->__outmsg($attr);  //成功返回数据
	}
	/**
	*@method 获取网站的域名
	*return  url
	*/
         function get_web_url(){

		$web=$this->video_model->select_rowtable('bangu.cfg_web',array());
		if(!empty($web)){
			return $web['url'];
		}else{
			return '';
		}	
         }

	/**
	 * @method:编辑主播
	 * @author: xml
	 * @param: anchor_id :主播id；
	 * @return:
	 */
	function edit_live_anchor(){
		$anchor_id=$this->input->post('id',true);
		if($anchor_id>0){
			//APP传来的数据
			$name=$this->input->post('name',true);//主播名
			$description=$this->input->post('description',true);//个人简介
			$comment=$this->input->post('comment',true);//个人签名
			$idcard=$this->input->post('idcard',true);//身份证正面照
			$video_pic=$this->input->post('video_pic',true);//视频封面图
			$anchor_pic=$this->input->post('anchor_pic',true);//主播图片
			//$anchor_attr=$this->input->post('anchor_attr',true);//签名;

			$path = "../bangu/file/c/img/";
	/*		$idcard=$this->cfgm_upload_pimg($path,'idcard');//身份证正面照
	           	$idcardconpic=$this->cfgm_upload_pimg($path,'idcardconpic');//身份证反面照          	
			$video_pic=$this->cfgm_upload_pimg($path,'video_pic');//视频封面图*/
			$anchor_pic=$this->cfgm_upload_pimg($path,'anchor_pic');//主播图片

			//验证数据
			if(empty($name)){$this->__errormsg ( '请填写主播名' );}
			if(empty($description)){$this->__errormsg ( '请填写个人简介' );}
			if(empty($comment)){$this->__errormsg ( '请填写个人描述' );}
			if(empty($anchor_pic)){$this->__errormsg ( '请上传我的图片' );}
			//if(empty($anchor_attr)){$this->__errormsg ( '请填写我的标签' );}

			$updateArr['name']=$name;
			$updateArr['comment']=$comment; //个人签名
			$updateArr['description']=$description; //个人简介

			$re=$this->anchor_model->save_edit_anchor($updateArr,$anchor_pic,$anchor_attr,$anchor_id);

			if($re){
				$this->__outmsg(array('code'=>2000,'msg'=>'success'));  //成功返回数据
			}else{
				$this->__errormsg('编辑失败!');	
			}

		}else{
			$this->__errormsg('编辑失败!');	
		}

	}

	/**
	 * @method:视频列表页  ---直播推荐默认首页
	 * @author: xml
	 * @param:video_play_type:视频类型(0,默认 1,最热 2,正在直播,3.精彩 ),视频标签 (attr_id:标签id) 
	 * @return:hot_video:最热,action_video:正在直播,most_video:最精彩,video_data:更多的视频
	 */
	function live_video_most(){
                     $video_play_type=$this->input->post('video_play_type',true);//视频类型
                     $attr_id=$this->input->post('attr_id',true);//标签id
                     //$video_play_type='1';
                     if($video_play_type==0){ 
                     		//根据$attr_id 返回最热,正在直播,精彩的视频
                     	          if($attr_id>0){  

                     	          		//最热的视频
                     	          	         	$hot_where=" where lra.attr_id={$attr_id}  order by lr.peoples desc";
				$hot_video=$this->video_model->live_video_most($hot_where,0);
                                  
				//正在直播的视频
				$action_where=" where lra.attr_id={$attr_id} and lr.live_status=1 ";
				$action_video=$this->video_model->live_video_most(' ',1);

				//精彩视频
				$most_where=" where lra.attr_id={$attr_id}  order by collect desc ";
				$most_video=$this->video_model->live_video_most($most_where,2);

				$outdata=array(
					'hot_video'=>$hot_video,  //最热
					'action_video'=>$action_video,  //正在直播
					'most_video'=>$most_video,   //最精彩		
				);
		                     $this->__outmsg($outdata); 

                     	          }else{      //默认

                     	          		//最热的视频
				$hot_video=$this->video_model->live_video_most(' order by lr.peoples desc',0);

				//正在直播的视频
				$action_video=$this->video_model->live_video_most(' where  lr.live_status=1',1);

				//精彩视频
				$most_video=$this->video_model->live_video_most(' order by collect desc',2);

				$outdata=array(
					'hot_video'=>$hot_video,  //最热
					'action_video'=>$action_video,  //正在直播
					'most_video'=>$most_video,   //最精彩		
				);
		                     $this->__outmsg($outdata); 

                     	          }

                     }else if($video_play_type==1){ //最热的视频

                     		$video_data=$this->video_model->live_video_type(2,' order by lr.peoples desc');
			$outdata=array(
				'video_data'=>$video_data,  	
			);
 			$this->__outmsg($outdata); 

                     }else if($video_play_type==2){  //正在直播更多

                    	           $video_data=$this->video_model->live_video_type(3,' where  lr.live_status=1');
                    	           $outdata=array(
				'video_data'=>$video_data,  	
			);
 			$this->__outmsg($outdata); 

                     }else if($video_play_type==3){  //精彩视频

          			$video_data=$this->video_model->live_video_type(4,' order by collect desc');
                    	        	$outdata=array(
				'video_data'=>$video_data,  	
			);
 			$this->__outmsg($outdata); 
                     }else{

                 	          	//最热的视频
			$hot_video=$this->video_model->live_video_most(' order by lr.peoples desc',0);

			//正在直播的视频
			$action_video=$this->video_model->live_video_most(' where la.live_status=1',1);

			//精彩视频
			$most_video=$this->video_model->live_video_most(' order by collect desc',2);

			$outdata=array(
				'hot_video'=>$hot_video,  //最热
				'action_video'=>$action_video,  //正在直播
				'most_video'=>$most_video,   //最精彩		
			);
	                     $this->__outmsg($outdata); 
                     } 


	}

      	/**
	 * @method:我的直播默认首页
	 * @author: xml
	 * @param: $user_id:用户id ,user_type:0用户1管家
	 * @return:$follow_video:我的关注正在直播,更新的视频, $fans_video:我的粉丝,$month_video:本月新增,$anchor:我的资料
	 */
      	function anchor_video_msg(){
      		
      		$user_id=$this->input->post('user_id',true);
      		$user_type=$this->input->post('user_type',true);
      		/*$user_id=1;
      		$user_type=1;*/
      		if($user_id>0){
                               	//用户信息资料
            		$anchor=$this->anchor_model->sel_abchor_msg(array('user_id'=>$user_id,'user_type'=>$user_type));
                      	if(!empty($anchor)){
                      		$user_id=$anchor['anchor_id'];
		                      //我的关注--更新直播  
		                     $follow_video0=$this->video_model->follow_live_video($user_id,0,24);
		                      //我的关注--正在直播
		   		$follow_video1=$this->video_model->follow_live_video($user_id,1,24);
			
		   		$follow_video=array_merge($follow_video0,$follow_video1);
		   		$follow_video=array_unique($follow_video);
		   		$follow_video=array_slice($follow_video,0,24);

		                       //我的标签
			           $anchor_attr=$this->video_model->live_anchor_attr($user_id);
			      	//我的图片
			           $url=$this->get_web_url();
				$anchor_pic=$this->anchor_model->select_table('live_anchor_pic',array('anchor_id'=>$user_id));
				if(!empty($anchor_pic)){
					foreach ($anchor_pic as $key => $value) {
						$anchor_pic[$key]['pic']=$url.$value['pic'];
					}
				}
				
                      		if($anchor['status']==1){     //主播

			      		//我的粉丝
			      		$fans_video=$this->video_model->live_anchor_fans(array('user_id'=>$user_id));		                              
			      		//本月新增
			      		$where="date_format(addtime,'%Y-%m')=date_format(now(),'%Y-%m') and user_id={$user_id}";
			      		$month_video=$this->video_model->live_anchor_fans($where);

			      		$outdata['rows']=array(
						'follow_video'=> $follow_video,  
						'fans_video'=>$fans_video,
						'month_video'	=>$month_video,
						'anchor'=>$anchor,
						'anchor_attr'=>$anchor_attr,
						'anchor_pic'=>$anchor_pic
					);

		 			//$this->__outmsg($outdata); 
		 			echo json_encode(array('code'=>'2000','msg'=>'success','data'=>$outdata));

                      		}else{           //用户

                      		  	$outdata['rows']=array(
						'follow_video'=> $follow_video,  
						'anchor'=>$anchor,
						'anchor_attr'=>$anchor_attr,
						'anchor_pic'=>$anchor_pic
					);
					//$this->__outmsg($outdata); 
                      		  	echo json_encode(array('code'=>'4000','msg'=>'success','data'=>$outdata));
                      		}              
                      	}else{
				echo json_encode(array('code'=>'-1'));
                      	}

      		}else{
      			$this->__errormsg('获取数据失败!');	
      		}
      	}
          
            /**
	 * @method:主播个人页
	 * @author: xml
	 * @param: $anchor_id:主播id , $user_id:用户id, status:0 默认视频 1:资料
	 * @return:gift:打赏,fans_video:粉丝,  video:视频 ,anchor_attr:我的标签,anchor_pic:我的图片,anchor:用户信息
	 */
            function direct_seeding(){
            	$anchor_id=$this->input->post('anchor_id',true);
            	$status=$this->input->post('status',true);
            	$user_id=$this->input->post('user_id',true);
            	/*$anchor_id=3;
            	$user_id=2;
            	$status=1;*/
            	if($anchor_id>0){

            		//主播资料
            		$anchor=$this->anchor_model->select_table('live_anchor',array('anchor_id'=>$anchor_id,'status'=>1));
                                 if(!empty($anchor[0])){
                                 	//主播获取的打赏
				$gift=$this->video_model->get_gift_record($anchor_id);
			
			           //主播的粉丝
				$fans_video=$this->video_model->live_anchor_fans(array('anchor_id'=>$anchor_id));

				if($status==0){  //视频信息
					//我的最新一条播放视频
					$order='addtime desc';
					$video=$this->video_model->select_rowtable('live_video',array('anchor_id'=>$anchor_id),$order);
					if(!empty($video)){
 						$url=$this->get_web_url();
 						$video['pic']=$url.$video['pic'];
					}	
					$outdata=array(
						'anchor'=>$anchor[0],    
						'gift'=>$gift, //打赏
						'fans_video'=>$fans_video,//粉丝
						'video'=>$video, //视频
					);
		 			$this->__outmsg($outdata);

				}else{   //资料

					//我的标签
		      			$anchor_attr=$this->video_model->live_anchor_attr($anchor_id);
		      			//我的图片
		      		          $url=$this->get_web_url();
					$anchor_pic=$this->anchor_model->select_table('live_anchor_pic',array('anchor_id'=>$anchor_id));
					if(!empty($anchor_pic)){
						foreach ($anchor_pic as $key => $value) {
							$anchor_pic[$key]['pic']=$url.$value['pic'];
						}
					}

					$outdata=array(
						'anchor'=>$anchor[0],    
						'gift'=>$gift, //打赏
						'fans_video'=>$fans_video,//粉丝
						'anchor_attr'=>$anchor_attr, //标签
						'anchor_pic'=>$anchor_pic //图片
					);
		 			$this->__outmsg($outdata);
				}

                                 }else{
				$this->__errormsg('不存在该用户!');	
                                 }
            	}else{
            		$this->__errormsg('获取数据失败!');	
            	}
            }

           /**
           *@method:直播视频
	*@author xml
	*@param room_id:房间id 
	*/
	function  show_video_msg(){
		$room_id=$this->input->post('room_id');
		//$room_id=1;
		if($room_id>0){

			//房间信息,视频的信息,主播信息
                 		$room_video=$this->video_model->get_room_video($room_id);

			//打赏
                 		
			//平台推荐的
                 		$line=$this->video_model->get_recommend_line($room_id);
     
			$outdata=array(
				'room_video'=>$room_video,
				'line'=>$line
			);
			$this->__outmsg($outdata);
		}else{
		        $this->__errormsg('获取数据失败!');	
		}
	}	
 
          /**
          *@method 我的关注 or 取消关注
          *@author xml
          *@param $anchor_id:主播id  ,$user_id:用户id ,$type 0:关注  1:取消关注
          */
          function my_attention(){

          	     	$anchor_id=$this->input->post('anchor_id',true);
          	     	$user_id=$this->input->post('user_id',true);
          	     	$type=$this->input->post('type',true);
          	     	if($anchor_id>0 && $user_id>0){
	          	     	if($type==0){ //关注 
	          	     		$re=$this->video_model->select_rowtable('live_anchor_fans',array('status'=>1,'anchor_id'=>$anchor_id,'user_id'=>$user_id));
	          	     		if(!empty($re)){
					$this->__errormsg('您已经关注了');
	          	     		}else{	          	     			
	          	     			$fansArr=array(
				          	     	'anchor_id'=>$anchor_id,
				          	     	'user_id'=>$user_id,
				          	     	'addtime'=>date('Y-m-d H:i:s',time()),
				          	     	'status'=>1,
				          	);

				          $id=$this->video_model->save_anchor_fans($fansArr,0);
			          	     	if($id>0){
			          	     		$this->__outmsg(array('id'=>$id));
			          	     	}else{
						$this->__errormsg('操作失败!');	
			          	     	}  
	          	     		}	          	     			          	     	
	          	     	}else{  //取消关注
	          	     		$re=$this->video_model->select_rowtable('live_anchor_fans',array('status'=>0,'anchor_id'=>$anchor_id,'user_id'=>$user_id));
	          	     		if(!empty($re)){
	          	     			$this->__errormsg('您已经取消了关注');
	          	     		}else{

                                                      $fansArr=array(
                                                      	'anchor_id'=>$anchor_id,
                                                      	'user_id'=>$user_id,
                                                      );  
				       
				           $id=$this->video_model->save_anchor_fans($fansArr,1);
			          	     	if($id){		          	     
			          	     		echo json_encode(array('code'=>'2000','msg'=>'取消成功'));
			          	     	}else{
						$this->__errormsg('操作失败!');	
			          	     	}  
	          	     		}
	          	     	}

	          	}else{
          	     		$this->__errormsg('操作失败!');	
          	     	}

          	     	/*if($anchor_id>0 && $user_id>0){  //关注
          	     		$re=$this->video_model->select_rowtable('live_anchor_fans',array('anchor_id'=>$anchor_id,'user_id'=>$user_id));
          	     		if(!empty($re)){  //关注和取消关注
				$re=$this->video_model->opare_attetion($fansArr);
				if($re==1){
	                                         echo json_encode(array('code'=>'2000','msg'=>'关注成功')); 
				}else{
				         echo json_encode(array('code'=>'4000','msg'=>'取消关注成功')); 
				}
          	     		}else{  //关注
				$fansArr=array(
			          	     	'anchor_id'=>$anchor_id,
			          	     	'user_id'=>$user_id,
			          	     	'addtime'=>date('Y-m-d H:i:s',time()),
			          	     	'status'=>1,
			          	);

			          $id=$this->video_model->save_anchor_fans($fansArr,0);
		          	     	if($id>0){
		          	     		$this->__outmsg(array('id'=>$id));
		          	     	}else{
					$this->__errormsg('操作失败!');	
		          	     	}  	
          	     		}
          	     	}*/
          }

          /**
          *@method 我的收藏 
          *@param video_id:视频id ,user_id:用户id
          *@return bool 
          */
          function get_video_collect(){
          		$video_id=$this->inpust->post('video_id',true);
          		$user_id=$this->inpust->post('user_id',true);
          		if($video_id>0 && $user_id>0){
          			$re=$this->video_model->select_rowtable('live_video_collect',array('video_id'=>$video_id,'user_id'=>$user_id));
          			if(!empty($re)){
          				$this->__errormsg('您已经收藏了');
          			}else{
                                      	$collectArr=array(
				          	'video_id'=>$video_id,
				          	'user_id'=>$user_id,
				          	'addtime'=>date('Y-m-d H:i:s',time()),
				);
				$id=$this->video_model->insert_tvideo_collect($collectArr);
		          	     	if($id>0){
		          	     		$this->__outmsg(array('id'=>$id));
		          	     	}else{
					$this->__errormsg('操作失败!');	
		          	     	}       
          			}

          		}else{
          			$this->__errormsg('操作失败!');
          		}
          } 

          /**
          *@method 直播视频信息
          *@param video_id:视频id 
          *@return peoples:观看人数  fans:订阅人数 umoney:U币 video_time:时长 video:视频地址
          */
          function get_video_room(){
          		$video_id=$this->input->post('video_id',true); 
          		//$video_id=1;
          		if($video_id>0){
          			//直播信息
          			$video_room=$this->video_model->get_direct_seeding($video_id);
          			$this->__outmsg($video_room);
          		}else{
			$this->__errormsg('获取数据失败!');
          		}
          }
          	/**
	*@method 人气主播
	*@param 无
	*@return array
	*/
	function get_popularity_anchor(){
		
		//搜索

		$anchor=$this->video_model->get_top_anchor();
		$this->__outmsg($anchor);
	}



	/**
	 * @name：公共函数：上传图片
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_upload_pimg($path, $input_name) {
		if (! file_exists ( $path )) {
			mkdir($path ,0777 ,true);
		}
		foreach ( $_FILES [$input_name] as $key => $val ) {
			if ($key == "name") {
				if (is_array ( $val )) {
					foreach ( $val as $k => $v ) {
						$ext [$k] = pathinfo ( $v, PATHINFO_EXTENSION );
						if (! in_array ( strtolower ( $ext [$k] ), array (
								'jpg',
								'gif',
								'png',
								'jpeg'
						) )) {
							$this->__errormsg ( 'ext is error' );
						}
						$file = time () . mt_rand ( 0, 9999 ) . "." . $ext [$k];
						$file_path [$k] = $path . $file;
					}
				} else {
					$ext = pathinfo ( $_FILES [$input_name] ['name'], PATHINFO_EXTENSION );
					$file = time () . mt_rand ( 0, 9999 ) . "." . $ext;
					$file_path = $path . $file;
				}
			}
			if ($key == "tmp_name") {
				if (is_array ( $val )) {
					foreach ( $val as $k => $v ) {
						if (! move_uploaded_file ( $v, $file_path [$k] )) {
							$error_msg = "from " . $k . " is failed";
							$this->__errormsg ( $error_msg );
						}
					}
				} else {
					if (! move_uploaded_file ( $_FILES [$input_name] ['tmp_name'], $file_path )) {
						$error_msg = "upload failed";
						$this->__errormsg ( $error_msg );
					}
				}
			}
		}
		// 返回新图片的名称
		return $file;
	}
}