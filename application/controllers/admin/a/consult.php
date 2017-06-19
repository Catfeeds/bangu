<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年11月20日16:10:50
 * @author		xml
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Consult extends UA_Controller {
	const pagesize = 10; //分页的页数

	public function __construct() {
		//error_reporting(0);
		parent::__construct ();
		$this->load_model ( 'admin/a/consult_model', 'consult_model' );
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
	}

	public function index() {
		//主题游
		$this->load->model ( 'admin/b1/user_shop_model');
		$this->load_model ( 'admin/a/consult_model', 'consult_model' );
		$data['theme']=$this->user_shop_model->get_user_shop_select('u_theme','');
		if(!empty($data['theme'])){
			$data['themeData']='';
			foreach ($data['theme'] as $k=>$v){
				$data['themeData'].=$v['id'].',';
			}
			$data['themeData']=substr($data['themeData'],0,-1);
		}
		//标签
		$this->load_model ( 'admin/a/sc_cfg_model/sc_article_attr_model', 'sc_article' );
		$data['tag']=$this->sc_article->all(); 
		$data['pageData']=$this->consult_model->get_consult_data(array('status'=>1),$this->getPage ());
	//	echo $this->db->last_query();
		$this->load_view ( 'admin/a/ui/base/consult',$data);
	}
	public function consultData(){
		$param = $this->getParam(array('status','title','consultType'));
		$data = $this->consult_model->get_consult_data( $param , $this->getPage ());
		echo  $data ;
	}
	//添加,编辑资讯
	function add_consult(){
		//咨询的表内容
		$insertCon['user_id'] = $this->admin_id;// 发布人id
		$insertCon['user_name'] = $this->realname;// 发布人id
		$insertCon['dest_id']=$this->input->post('overcitystr');  //目的地
		$insertCon['pic']=$this->input->post('cover_pic');  //封面图
		
		//压缩的封面图；温文斌
		$this->load->library('images');
		$images = new images();
		$re=$images->resize("../bangu".$insertCon['pic'],"142","85");
		$small_pic=$re['path'];
		$small_pic=substr($small_pic, 8);
		$insertCon['pic_tar']=$small_pic;  //压缩的封面图

		$insertCon['title']=$this->input->post('c_title');  //标题
		$insertCon['content']=$this->input->post('content');
		$insertCon['ishot']=$this->input->post('ishot');
		$insertCon['type']=$this->input->post('type');//咨询类型
		$insertCon['theme_id']=intval($this->input->post('theme'));//主题游
		$insertCon['article_attr_id']=intval($this->input->post('tag')); //标签
		$insertCon['content_paper']=strip_tags($insertCon['content']);
		//$insertCon['channel']=$this->input->post('channel');//主题游
		$insertCon['shownum']=0;
		$insertCon['praisetnum']=0;
		if(empty($insertCon['title'])){
			echo json_encode(array('status'=>-1,'msg'=>'请填写标题'));
			exit;
		}
		if(empty($insertCon['article_attr_id'])){
			echo json_encode(array('status'=>-1,'msg'=>'请选择标题'));
			exit;
		}
		if(empty($insertCon['dest_id'])){        
		    	echo json_encode(array('status'=>-1,'msg'=>'请选择目的地'));
		    	exit;
		 }else{
		    	//三级目的地的父类
		    	$overcity='';
		    	$bourn='';
		    	$citystr='';
		    	if(!empty($insertCon['dest_id'])){
		    		//获取目的地
		    		$whereArr = array(
		    				'in' =>array('id' =>str_replace(',,',',',trim($insertCon['dest_id'] ,',')))
		    		);
		    		$destData = $this ->dest_base_model ->getDestBaseAll($whereArr);
		    		
		    		$overcity = '';
		    		foreach($destData as $val)
		    		{
		    			$overcity .= $val['list'];
		    		}
		    	}
		    	if(!empty($overcity)){
		    		$city=array_unique(explode(',', $overcity));
		    		$insertCon['dest_id']=implode(',',$city);
		    	}
		}	
		$typeid=$this->input->post('typeid');
		if($typeid>0){  //编辑
		    	$re=$this->consult_model->update($insertCon,array('id'=>$typeid));
		    	if($re>=0){
		    		echo json_encode(array('status'=>1,'msg'=>'编辑成功'));
		    	}else{
		    		echo json_encode(array('status'=>-1,'msg'=>'编辑失败'));
		    	}
		}else{     //插入
		    	$insertCon['addtime']=date('Y-m-d H:i:s');
		    	//插入表
		    	$id=$this->consult_model->insert_consult($insertCon);
		    	if($id>0){
		    		echo json_encode(array('status'=>1,'msg'=>'添加成功'));
		    	}else{
		    		echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
		    	}
		}
	}
	//某条资讯的数据
	function get_consult(){
		$id=$this->input->post('id');
		if($id>0){
			$dest='';
			 $consult=$this->consult_model->get_consult_listData(array('c.id'=>$id));		
			 if(!empty($consult['dest_id'])){
			 	$consult['dest_id']=$consult['dest_id'].',';
			 	
			 	$whereArr = array(
			 			'in' =>array('id' => trim($consult['dest_id'] ,',')),
			 			'level =' =>3
			 	);
			 	$dest = $this ->dest_base_model ->getDestBaseAllData($whereArr);
			 }
			 if(!empty($consult)){
			 	echo json_encode(array('status'=>1,'msg'=>'获取数据成功','data'=>$consult,'dest'=>$dest));
			 }
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
}
