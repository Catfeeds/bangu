<?php
/**
 * @copyright 深圳海外国际旅行社有限公司   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Common_list extends UC_NL_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'consult_model', 'consult_model' );
		$this->load_model ( 'sc_common_model', 'common' );
	}
	
	//更多
	function common_page($type,$page){
		$data['type']=intval($type);
		$page=intval($page);

		if(empty($data['type'])){
			$data['type']=1;
		}
		if($page==0){
			$page=1;
		}
		$this->load->library ( 'page' );
		$config['pagesize'] =20;
		$config['page_now'] = $page;
		
		//常见问题的类型
		$data['common_kind']=$this->common->get_tableData('cfg_index_kind',array('id'=>$data['type']),1);
		
		//查询数据
		$whereArr=array('cp.index_kind_id'=>$data['type'],'cp.is_show'=>1);
		$common=$this->common->get_common_list($whereArr,$page,$config['pagesize']);
		
		$config ['pagecount'] = $common['count'];
		$config['base_url'] = '/common_list-'.$data['type'].'-';
		$config['suffix'] = '.html';
		$data['common']=$common['consultData'];

		$this->page->initialize ( $config );
		
		if(!empty($data['common_kind']['id'])&& $data['common_kind']['name']=='主题游'){ //判断类型是否是主题游
			//查询条件
			$where='l.themeid >0';
		}else{
			//查询条件
			$where='FIND_IN_SET('.$type.',l.overcity)>0';
		}
		//体验分享
		$data['tarve']=$this->common->get_trave_data($where);
		//旅游线路
		$line_where='FIND_IN_SET('.$type.',l.overcity)>0';
		$data['line']=$this->common->get_line_data($where);
	
		//游记 前十条的访问总数
		$data['hot']=$this->common->get_hot_consult($where);
		
		$this->load->view ( 'common/common_list',$data);
	}

}

