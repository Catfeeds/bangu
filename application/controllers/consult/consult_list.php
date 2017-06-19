<?php
/**
 * @copyright 深圳海外国际旅行社有限公司   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Consult_list extends UC_NL_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'consult_model', 'consult_model' );
	}
	//资讯列表页
	public function index(){
		//导航轮播图
		$data['location']=$this->consult_model->get_cgf_consult(array('cf.location'=>1,'cf.is_show'=>1));
		//中间固定
		$data['middle']=$this->consult_model->get_cgf_consult(array('cf.location'=>2,'cf.is_show'=>1));
		//最新资讯
		$data['new_consult']=$this->consult_model->get_consult_data(array('c.type'=>1),15);
		//最新知识
		$data['knowledge']=$this->consult_model->get_consult_data(array('c.type'=>2),15);
		//热门资讯
		$data['hot_consult']=$this->consult_model->get_consult_data(array('c.type'=>1,'c.ishot'=>1),10);
		//热门旅游知识
		$data['hot_knowledge']=$this->consult_model->get_consult_data(array('c.type'=>2,'c.ishot'=>1),10);
		//热门资讯 前十条的访问总数
		$data['hot']=$this->consult_model->get_hot_consult();
		$this->load->view ( 'consult/consult_list',$data );
	}
	//更多资讯
	 function consult_page($type,$page){
		 	$data['type']=intval($type);
		 	$page=intval($page);
		 	$whereArr=array('type'=>$data['type']);
		    if(empty($data['type'])){
		    	$data['type']=1;
		    }
	    	if($page==0){
	    		$page=1;
	    	}
	    	$this->load->library ( 'page' );
	    	$config['pagesize'] =20;
	    	$config['page_now'] = $page;
	    	//查询数据
	    	$consult=$this->consult_model->get_consult_page($whereArr,$page,$config['pagesize']);	
	   
	    	$config ['pagecount'] = $consult['count'];
	    	$config['base_url'] = '/lyzx_page-'.$data['type'].'-';
	    	$config['suffix'] = '.html';
	        $data['consult']=$consult['consultData'];
	    	$this->page->initialize ( $config );
	    	//热门资讯
	    	$data['hot_consult']=$this->consult_model->get_consult_data(array('c.type'=>1,'c.ishot'=>1),10);
	    	//热门旅游知识
	    	$data['hot_knowledge']=$this->consult_model->get_consult_data(array('c.type'=>2,'c.ishot'=>1),10);
	    	//热门资讯 前十条的访问总数
	    	$data['hot']=$this->consult_model->get_hot_consult();	
	    	$this->load->view ( 'consult/consult_page',$data);

	 }
	
}

