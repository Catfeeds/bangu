<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rankinglist extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @name：管家人气排行榜
     * @author: 张允发
     * @param: number=凭证；orderid=订单ID
     * @return:
     *
     */
    public function expert_list(){
//     	$sql="select count(member_id) as num,b.small_photo,b.nickname from u_expert_collect as a LEFT JOIN u_expert as b on a.expert_id=b.id WHERE a.addtime>='2017-02-03 00:00:00' and a.addtime<='2017-02-10 20:30:00' GROUP BY expert_id ORDER BY num DESC,a.addtime ASC  LIMIT 10 ";
//     	$expert_data=$this->db->query($sql)->result_array();
    	$this->load->view('rankinglist/expertlist');
    }
    
    /**
     * @name：产品人气排行榜
     * @author: 张允发
     * @param: number=凭证；orderid=订单ID
     * @return:
     *
     */
    public function line_list(){
//     	$sql="select count(member_id) as num,b.mainpic,b.linename from u_line_collect as a LEFT JOIN u_line as b on a.line_id=b.id WHERE a.addtime>='2017-02-03 00:00:00' and a.addtime<='2017-02-10 20:30:00' GROUP BY line_id ORDER BY num DESC,a.addtime ASC  LIMIT 10 ";
//     	$line_data=$this->db->query($sql)->result_array();
    	$this->load->view('rankinglist/linelist');
    }
    
    /**
     * @name：管家人气排行榜10秒
     * @author: 张允发
     * @param: number=凭证；orderid=订单ID
     * @return:
     *
     */
    public function expert_list_change(){
    	$sql="select b.small_photo,b.nickname,b.realname,f.collect_num_vr,(count(a.member_id)+(IFNULL(f.collect_num_vr,0))) as num
 			from u_expert_collect as a 
			LEFT JOIN u_expert as b on a.expert_id=b.id
			LEFT JOIN u_expert_affiliated as f on a.expert_id=f.expert_id
			WHERE a.addtime>='2017-02-03 00:00:00' AND a.addtime<='2017-02-10 19:30:00' AND b.city='235' GROUP BY a.expert_id ORDER BY num DESC,a.addtime ASC  LIMIT 10 ";
    	$expert_data=$this->db->query($sql)->result_array();
    	echo json_encode($expert_data);
    }
    
    /**
     * @name：产品人气排行榜10秒
     * @author: 张允发
     * @param: number=凭证；orderid=订单ID
     * @return:
     *
     */
    public function line_list_change(){
    	$sql="select b.mainpic,b.id,b.supplier_id,s.brand,f.collect_num_vr,(count(a.member_id)+(IFNULL(f.collect_num_vr,0))) as num 
			from u_line_collect as a 
			LEFT JOIN u_line as b on a.line_id=b.id
			LEFT JOIN u_supplier as s on b.supplier_id=s.id
			LEFT JOIN u_line_affiliated as f on a.line_id=f.line_id
			WHERE a.addtime>='2017-02-03 00:00:00' and a.addtime<='2017-02-10 19:30:00' AND s.city='235' OR s.city='384' GROUP BY b.supplier_id ORDER BY num DESC,a.addtime ASC  LIMIT 10  ";
    	$line_data=$this->db->query($sql)->result_array();
    	echo json_encode($line_data);
    }
    
    
}