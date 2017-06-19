<?php
/**
 * @copyright 深圳海外国际旅行社有限公司   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Common_detail extends UC_NL_Controller {
	
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
			$data['common']=$this->common->get_common_detail(array('cp.id'=>$id,'cp.is_show'=>1));
	        if(!empty($data['common'])){ 
	        	$type=$data['common']['index_kind_id'];
	        	if($type>0){
		        	//常见问题的类型
		        	$common_kind=$this->common->get_tableData('cfg_index_kind',array('id'=>$type),1);
	 				//体验分享
		        	if(!empty($common_kind['id'])&& $common_kind['name']=='主题游'){ //判断类型是否是主题游
		        		//查询条件
		        		$where='l.themeid >0';
		        	}else{
		        		//查询条件
		        		$where='FIND_IN_SET('.$type.',l.overcity)>0';
		        	}
		        	//体验分享
		        	$data['tarve']=$this->common->get_trave_data($where,10);
		        	
		        	//旅游线路
		        	$line_where='FIND_IN_SET('.$type.',l.overcity)>0';
		        	$data['line']=$this->common->get_line_data($where,5);
	        	}
			 	if(!empty($type)){
					$whereStr=' and cp.index_kind_id='.$type;
				}else{
					$whereStr='';
				}  
				//上一条
				$data['prev_consult']=$this->common->get_prev_data($id,$whereStr);
				//下一条
				$data['next_consult']=$this->common->get_next_data($id,$whereStr);
				//echo $this->db->last_query();
				$this->load->view ( 'common/common_detail',$data );
            }else{
            	echo "<script>alert('不存在该条详情页!');window.history.back(-1);</script>";
            }
		}else{
			echo "<script>alert('不存在该条详情页!');window.history.back(-1);</script>";
		}
	}

}

