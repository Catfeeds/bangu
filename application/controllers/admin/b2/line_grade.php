<?php
/**
 * 专家查看售卖线路级别
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月16日18:00:01
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Line_grade extends UB2_Controller{
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/line_grade_model', 'line_grade');
	}

	public function index(){
		$supplier = $this->line_grade->get_supplier();
		$overcity = $this->line_grade->get_destinations();
		$data = array(
			'suppliers'=>$supplier,
			'destinations' => $overcity
			);
		$this->load_view('admin/b2/line_grade_view', $data);
	}
	public function line_grade_list(){
		$post_arr = array();
		$post = $this->security->xss_clean($_POST);
		$number = $post['pageSize'];
       		 $page = $post['pageNum'];
        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
		if($post['supplier_id']!=''){
       			$post_arr['l.supplier_id'] = $post['supplier_id'];
       		}
       		/*if($this->input->post('destination')!=''){
       			$post_arr['FIND_IN_SET('.$this->input->post('destination').',l.overcity)>'] = 0;
       		}*/

       		if (!empty($post['destination']) && !empty($post['overcity'])) {
			//$post_arr['l.overcity'] = intval($this->input->post['overcity']);
			$post_arr['l.overcity'] = array(intval($post['overcity']));
		} elseif (!empty($post['destination'])) {
			 $this ->db->select('*');
			 $this ->db->from('u_dest_base');
			 $this->db->where(array('kindname like' =>"%{$post['destination']}%"));
			 $dest = $this->db->get()->result_array();
			 //echo json_encode($dest);exit();
			if (empty($dest)) {
				echo false;exit;
			} else {
				$dest_id = array();
				foreach($dest as $val) {
					$dest_id[] = $val['id'];
				}
				$post_arr['l.overcity'] = $dest_id;
				//$whereArr['l.overcity'] = rtrim($dest_id ,',');
			}
		}

       		if($this->input->post('line_name')!=''){
       			$post_arr['l.linename LIKE'] = '%'.$this->input->post('line_name').'%';
       		}
       		if($this->input->post('grade')!=''){
       			$post_arr['la.grade'] = $this->input->post('grade');
       		}
		$package_list = $this->line_grade->get_line_grade_list($post_arr,$page, $number,$this->expert_id);
		$pagecount = count($this->line_grade->get_line_grade_list($post_arr,0,$number,$this->expert_id));

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
	               	"rows" => $package_list
            	);
		echo json_encode($data);
	}

}