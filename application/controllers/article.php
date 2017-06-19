<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		谢明丽
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends UC_NL_Controller {

	
    public function __construct() {
        parent::__construct();
        $this->load_model('index_model', 'index_model');
		
	}

    public function index($article_id=0) {
    	//$article_id=$this->input->get('article_id'); 	
    	$data['article_id']=$article_id;  
    	//底部文章
    	$art_where=array('ishome'=>1);
    	$data['atrr']=$this->index_model->get_alldata('u_article_attr',$art_where,'showorder');
    	//var_dump($data['atrr']);
    	//文章列表
    	if($data['atrr']){
    		foreach ($data['atrr'] as $k=>$v){
    			$article_where=array('attrid'=>$v['id']);
    			$data['atrr'][$k]['son']=$this->index_model->get_alldata('u_article',$article_where,'showorder');
    		}
    	} 
    	//文章详情
    	if(is_numeric($article_id)){
    		//文章表
    		$data['article']=$this->index_model->get_article_list(array('art.id'=>$article_id));	
    		 			
    	}else{
    		//echo '<script>alert("该文章不存在!");window.location.href="'.base_url().'"</script>';
    	}
    	
        //一系列常见问题
    //	$data['fag']=$this->index_model->get_article_FAQ(array('ishome'=>1));
    	$art_where=array('ishome'=>1);
    	$data['fag']=$this->index_model->get_alldata('u_article_attr',$art_where,'showorder');
    	//文章
    	if($data['fag']){
    		foreach ($data['fag'] as $k=>$v){
    			$article_where=array('attrid'=>$v['id']);
    			$data['fag'][$k]['son']=$this->index_model->get_alldata('u_article',$article_where,'showorder');
    		}
    	}
    	$data['type']='FAQ';//标题
    	
        $this->load->view('article/article_view',$data);
    	
    }
    
    
    //关于我们
    public function about_us($type = ''){
    	//类型
    	//$type=$this->input->get('type');
    	if($type){
    		$data['type']=$type;
    	}else{
    		$data['type']='introduce';
    	}
    	//企业文化
    	$row=$this->index_model->get_alldata('cfg_web','','id');
    	$data['row']=$row[0];
    	$data['show']=1;//显示左侧栏
    	$this->load->view('article/about_us',$data);
    }
    
    //招聘说明
    public function recruit(){
    	//招聘说明文字
    	$row=$this->index_model->get_alldata('cfg_web','','id');
    	$data['row']=$row[0];
    	//招聘信息
    	$where['enable']=1;
    	$data['hire']=$this->index_model->get_alldata('cfg_hire',$where,'id');
    	$data['type']='recruit';//左侧标题
    	$this->load->view('article/recruit',$data);
    }
    
    //联系我们
    public function contact_us(){
    	//联系我们
    	$row=$this->index_model->get_alldata('cfg_web','','id');
    	$data['row']=$row[0];
    	$data['type']='contact_us'; //左侧标题
    	$this->load->view('article/contact_us',$data);
    }
    
    //友情链接
    public function friend_link(){
    	//友情链接的说明
    	$row=$this->index_model->get_alldata('cfg_web','','id');
    	$data['row']=$row[0];
    	//友情链接 --图片
    	$where1['link_type']=1;
    	$data['friend_link1']=$this->index_model->get_alldata('u_friend_link',$where1,'showorder');	
    	//友情链接 --合作
    	$where2['link_type']=2;
    	$data['friend_link2']=$this->index_model->get_alldata('u_friend_link',$where2,'showorder');
    	//友情链接 --文字
    	$where3['link_type']=3;
    	$data['friend_link3']=$this->index_model->get_alldata('u_friend_link',$where3,'showorder');
    	$data['type']='friend_link';//左侧标题
    	
    	$this->load->view('article/friend_link',$data);
    }
    //隐私说明
    public function privacy_desc(){
    	//隐私说明
    	$row=$this->index_model->get_alldata('cfg_web','','id');
    	$data['row']=$row[0];
    	$data['type']='privacy_desc';//左侧标题
    	$this->load->view('article/privacy_desc',$data);
    }
    //营业执照
    public function license() {
     
    	$row=$this->index_model->get_alldata('cfg_web','','id');
    	$data['row']=$row[0];
    	$data['type']='license';
    	$data['show']=1;//显示左侧栏
    	$this->load->view('article/license',$data);
    }
}
