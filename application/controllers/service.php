<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		谢明丽
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends UC_NL_Controller {
    public function __construct() {
        parent::__construct();
        $this->load_model('index_model', 'index_model');
		
	}
	
   //管家服务总则
	public function expert_agreement() {
		$article_id=$this->input->get('article_id');
		$data['article_id']=$article_id;
		//底部文章
		$art_where=array('attr_code'=>17);
		$data['atrr']=$this->index_model->get_alldata('u_article_attr',$art_where,'showorder');
		//文章列表
		if($data['atrr']){
			foreach ($data['atrr'] as $k=>$v){
				$article_where=array('attrid'=>$v['id']);
				$data['atrr'][$k]['son']=$this->index_model->get_alldata('u_article',$article_where,'showorder');   //详情页
			}
		}	
		$this->load->view('service/expert_agreement',$data);
	}
	//会员协议
	public function member_agreement(){
		$article_id=$this->input->get('article_id');
		$data['article_id']=$article_id;
		//底部文章
		$art_where=array('ishome'=>1,'attr_code'=>18);
		$data['atrr']=$this->index_model->get_alldata('u_article_attr',$art_where,'showorder');
		//文章列表
		if($data['atrr']){
			foreach ($data['atrr'] as $k=>$v){
				$article_where=array('attrid'=>$v['id']);
				$data['atrr'][$k]['son']=$this->index_model->get_alldata('u_article',$article_where,'showorder');   //详情页
			}
		}
		$this->load->view('service/member_agreement',$data);
	}
	//积分规则
	public function integral_agreement(){
		$article_id=$this->input->get('article_id');
		$data['article_id']=$article_id;
		//底部文章
		$art_where=array('ishome'=>1,'attr_code'=>19);
		$data['atrr']=$this->index_model->get_alldata('u_article_attr',$art_where,'showorder');
		//文章列表
		if($data['atrr']){
			foreach ($data['atrr'] as $k=>$v){
				$article_where=array('attrid'=>$v['id']);
				$data['atrr'][$k]['son']=$this->index_model->get_alldata('u_article',$article_where,'showorder');   //详情页
			}
		}
		$this->load->view('service/integral_agreement',$data);
	}
	//管家协议
	public function cooperation(){
		$article_id=$this->input->get('article_id');
		$data['article_id']=$article_id;
		//底部文章
		$art_where=array('id'=>20);
		$data['atrr']=$this->index_model->get_alldata('u_article_attr',$art_where,'showorder');
		//echo $this->db->last_query();
		//文章列表
		if($data['atrr']){
			foreach ($data['atrr'] as $k=>$v){
				$article_where=array('attrid'=>$v['id']);
				$data['atrr'][$k]['son']=$this->index_model->get_alldata('u_article',$article_where,'showorder');   //详情页
			}
		} 
		//var_dump($data);
		$this->load->view('service/cooperation',$data);
	}
	
}
