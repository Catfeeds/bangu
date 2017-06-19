<?php
/**
 * @copyright 深圳海外国际旅行社有限公司   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Sc_detail extends UC_NL_Controller {
	
/* 	private $whereArr = array('e.status' =>2); //保存管家的搜索条件
	private $dataArr = array();//保存视图层的数据
	private $postArr = array();//搜索条件 */
	
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'sc_common_model', 'common' );
	}
	//常见问题详情页
	public function index($id){
		$id=intval($id);	
		if($id>0){
			//资讯详情
			$data['common']=$this->common->get_travel_article(array('scp.id'=>$id,'scp.is_show'=>1));
			//echo $this->db->last_query();
			//游记分享
			$data['tarvel']=$this->common->get_travel_hot();
			
			//旅游线路
			$whereArr = array(
					'status' =>2
			);
			$this->load_model ( 'line_model', 'line_model' );
			$data['line']= $this ->line_model ->lineSortData($whereArr ,1 ,5 ,'bookcount desc');
			//echo $this->db->last_query();
			
	        if(!empty($data['common'])){ 
				$whereStr='';
				//上一条
				$data['prev_consult']=$this->common->get_prev_travedata($id,$whereStr);
				
				//下一条
				$data['next_consult']=$this->common->get_next_travedata($id,$whereStr);
				
				$this->load->view ( 'sc/sc_detail',$data );
            }else{
            	show_404('404',500,'page not found');
            }
		}else{
			show_404('404',500,'page not found');
		}
	}

}


