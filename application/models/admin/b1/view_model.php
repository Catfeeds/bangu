<?php
/***
*深圳海外国际旅行社
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class View_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}

 		//查询表
 		public function select_data($table,$where){
 			$this->db->select('*');
 			if(!empty($where)){
 				$this->db->where($where);
 			}
 			 
 			return  $this->db->get($table)->result_array();
 		}
 		//查询表
 		public function select_rowData($table,$where){
 			$this->db->select('*');
 			$this->db->where($where);
 			return  $this->db->get($table)->row_array();
 		}
 		//统计信息
 		function statistics($id){		
 			$sql=" SELECT s.satisfactory AS 'satisfactory', ";
 			$sql.=" COALESCE ((SELECT	SUM(l.peoplecount) FROM	u_line AS l	WHERE	l.supplier_id = s.id	),0) AS 'number_sales', ";
 			$sql.=" COALESCE (	ROUND((	SELECT	COUNT(*)	FROM	u_complain AS c LEFT JOIN u_member_order AS mo ON c.order_id = mo.id ";
 			$sql.=" 	WHERE	mo.supplier_id = s.id) / (SELECT COUNT(*)	FROM	u_member_order AS mo WHERE	mo.supplier_id = s.id	AND mo. STATUS >= 5),3	),0) AS 'complain', ";
 			$sql.=" COALESCE ((SELECT	SUM(mo.total_price)	FROM u_member_order AS mo	WHERE	mo.supplier_id = s.id AND mo. STATUS >= 5),0) AS 'business',";
 			$sql.=" COALESCE ((SELECT	SUM(l.all_score) FROM	u_line AS l	WHERE	l.supplier_id = s.id),0) AS 'integral' ";
 			$sql.=" FROM u_supplier AS s 	WHERE s.id=".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//订单字典
 		function orderName(){
 			$sql="SELECT name from cfg_status_definition where type=2 ORDER BY showorder ASC ";
 			$query = $this->db->query($sql);
 			$rows = $query->result_array();
 			return $rows;
 		}
 		
 		//动态监控
/*  		function dynamic($id){
 			$sql="SELECT (SELECT COUNT(*) FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=0 AND cs.order_status=-4 AND cs.supplier_id=s.id and cs.isread=0) AS 'cancel',";
 			$sql.=" (SELECT COUNT(*) FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=4 AND cs.order_status=-4 AND cs.supplier_id=s.id and cs.isread=0) AS 'a_refund', ";
 			$sql.="	(SELECT COUNT(*) FROM cal_supplier_order_status AS cs LEFT JOIN u_refund AS r ON cs.order_id=r.order_id WHERE cs.order_ispay=3 AND cs.order_status=-3 ";
 			$sql.=" AND cs.supplier_id=s.id AND r.status=0 AND r.refund_type=0 and cs.isread=0 ) AS 'c_refund',";
 			$sql.=" (SELECT COUNT(*) FROM cal_supplier_order_status AS cs LEFT JOIN u_refund AS r ON cs.order_id=r.order_id WHERE cs.order_ispay=3 AND cs.order_status=-3 ";
 			$sql.=" AND cs.supplier_id=s.id AND r.status=0 AND r.refund_type=1 and cs.isread=0 ) AS 'b2_refund',";
 			$sql.=" (SELECT COUNT(*) FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=0 AND cs.order_status=0 AND cs.supplier_id=s.id and cs.isread=0) AS 'leave_order',";
 			$sql.=" (SELECT COUNT(*) FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=2 AND cs.order_status=1 AND cs.supplier_id=s.id and cs.isread=0) AS 'confirm_order',";
 			$sql.=" (SELECT COUNT(*) FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=2 AND cs.order_status=6 AND cs.supplier_id=s.id and cs.isread=0) AS 'c_comment',";
 			$sql.=" (SELECT COUNT(*) FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=2 AND cs.order_status=7 AND cs.supplier_id=s.id and cs.isread=0) AS 'c_complain',";
 			$sql.=" (SELECT COUNT(*) FROM travel_note AS tn LEFT JOIN u_line AS l ON tn.line_id=l.id WHERE l.supplier_id=s.id AND TIMESTAMPDIFF(HOUR,tn.modtime,NOW())<48 AND tn.isread=0 AND tn.usertype=0 and tn.s_isread=0) AS 'c_experience'";
 			$sql.=" FROM u_supplier AS s 	WHERE s.id=".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		} */
 		//订单已取消
 		function order_cancel($id){
 			$sql="SELECT COUNT(cs.id) AS 'cancel' FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=0 AND cs.order_status=-4 AND cs.supplier_id={$id} and cs.isread=0";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//平台申请退款
 		function order_refund($id){
 			$sql="SELECT COUNT(cs.id) as a_refund FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=4 AND cs.order_status=-4 AND cs.supplier_id={$id} and cs.isread=0 ";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//客人申请退款
 		function  order_c_refund($id){
 			$sql=" SELECT COUNT(cs.id) AS 'leave_order' FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=0 AND cs.order_status=0 AND cs.supplier_id={$id} and cs.isread=0 ";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		
 		//管家申请退款
 		function order_b2_refund($id){
 	 		$sql=" SELECT COUNT(cs.id) AS 'b2_refund' FROM cal_supplier_order_status AS cs LEFT JOIN u_refund AS r ON cs.order_id=r.order_id WHERE cs.order_ispay=3 AND cs.order_status=-3 ";
 			$sql.=" AND cs.supplier_id={$id} AND r.status=0 AND r.refund_type=1 and cs.isread=0";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//确认订单
 		function order_leave_order($id){
 			$sql=" SELECT COUNT(cs.id) AS 'leave_order' FROM cal_supplier_order_status AS cs  WHERE  cs.order_status=4 ";
 			$sql.=" AND cs.supplier_id={$id}  and cs.isread=0";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		
 		//待确认订单
 		function  order_confirm_order($id){
 			$sql="SELECT COUNT(cs.id) AS 'confirm_order' FROM cal_supplier_order_status AS cs WHERE  (cs.order_status=0 and cs.order_status=1 or cs.order_status=3) AND cs.supplier_id={$id} and cs.isread=0 ";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//订单评论
 		function order_c_comment($id){
 			$sql=" SELECT COUNT(cs.id) AS 'c_comment' FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=2 AND cs.order_status=6 AND cs.supplier_id={$id} and cs.isread=0";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//客人已投诉
 		function order_c_complain($id){
 			$sql=" SELECT COUNT(cs.id)AS 'c_complain' FROM cal_supplier_order_status AS cs WHERE cs.order_ispay=2 AND cs.order_status=7 AND cs.supplier_id={$id} and cs.isread=0";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//客人发体验
 		function order_c_experience($id){
 			$sql="SELECT COUNT(tn.id) AS 'c_experience' FROM travel_note AS tn LEFT JOIN u_line AS l ON tn.line_id=l.id WHERE l.supplier_id={$id} AND TIMESTAMPDIFF(HOUR,tn.modtime,NOW())<48 AND tn.isread=0 AND tn.usertype=0 and tn.s_isread=0 ";
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		
 		//定制单动态
 		function custom($id){
 			
     		$sql=" SELECT (	SELECT	COUNT(*)	FROM	u_enquiry AS ey	WHERE	ey. STATUS =2	AND 	ey.is_assign = 0	AND ey.id NOT IN (";
 			$sql.=" SELECT eg.enquiry_id FROM	u_enquiry_grab AS eg WHERE	eg.enquiry_id = ey.id	AND eg.supplier_id = 30)) AS 'inquiry', ";
     		$sql.="(SELECT COUNT(*)FROM u_enquiry AS ey	WHERE ey. STATUS = 1 AND ey.is_assign = 1 and ey.supplier_id=s.id	AND ey.id NOT IN (";
			$sql.="SELECT eg.enquiry_id FROM	u_enquiry_grab AS eg WHERE eg.enquiry_id = ey.id AND eg.supplier_id = 30))	AS 'inquiry_1',";
			$sql.="(	SELECT	COUNT(*) FROM	u_enquiry_grab AS eg	WHERE	eg.isuse = 1 AND eg.supplier_id = s.id ) AS 'bidding'";
 			$sql.=" FROM u_supplier AS s 	WHERE s.id=".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//产品动态
 		function line_data($id){
 			$sql=" SELECT (SELECT COUNT(id) FROM u_line AS l WHERE l.supplier_id=s.id AND l.status=0 AND l.producttype=0) AS 'line_num0', ";
 			$sql.="  (SELECT COUNT(id) FROM u_line AS l WHERE l.supplier_id=s.id AND l.status=1 AND l.producttype=0) AS 'line_num1', ";
 			$sql.=" (SELECT COUNT(id) FROM u_line AS l WHERE l.supplier_id=s.id AND l.status=2 AND l.producttype=0) AS 'line_num2', ";
 			$sql.=" (SELECT COUNT(id) FROM u_line AS l WHERE l.supplier_id=s.id AND ( l.status=3 or  l. STATUS = 4 ) AND l.producttype=0 AND l.line_status =1) AS 'line_num3' ";
 			$sql.=" FROM u_supplier AS s WHERE	s.id =".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows; 
 		}
 		//管家统计
 		function expert_list($id){
 			$sql=" SELECT 	(SELECT COUNT(*) FROM u_expert AS e WHERE e.supplier_id=s.id and `status`=1) AS 'under_expert', ";
 			$sql.=" (SELECT COUNT(*) FROM u_expert AS e WHERE e.supplier_id=s.id and `status`=2) AS 'opare_expert', ";
 			$sql.="	(SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=1) AS 'expert_number',";
 			$sql.=" (SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=2) AS 'expert1_number',";
 			$sql.=" (SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=3) AS 'expert2_number',";
 			$sql.="	(SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=4) AS 'expert3_number'";
 			$sql.=" FROM u_supplier AS s 	WHERE s.id=".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}
 		//管家动态
 		function expert_dynamic($id){
 /* 			$sql=" SELECT 	(SELECT COUNT(*) FROM u_expert AS e WHERE e.supplier_id=s.id) AS 'under_expert', ";
 			$sql.="	(SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=1) AS 'expert_number',";
 			$sql.=" (SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=2) AS 'expert1_number',";
 			$sql.=" (SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=3) AS 'expert2_number',";
 			$sql.="	(SELECT COUNT(*) FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE l.supplier_id=s.id AND l.status=2 AND la.status=2 AND la.grade=4) AS 'expert3_number'";
 			$sql.=" FROM u_supplier AS s 	WHERE s.id=".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows; */
 		}
 		//平台公告
 		function platform_publish($id){
 			$sql="SELECT (SELECT COUNT(*) FROM u_notice AS n WHERE FIND_IN_SET(2,n.notice_type)>0 AND n.id NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE nr.userid=s.id AND nr.notice_type=2)) AS 'publish'";
 			$sql.=" FROM u_supplier AS s 	WHERE s.id=".$id;
 			$query = $this->db->query($sql);
 			$rows = $query->row_array();
 			return $rows;
 		}

}
