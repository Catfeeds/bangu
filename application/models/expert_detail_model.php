<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expert_detail_model extends MY_Model {

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct('u_expert');
    }

    /**
     * 获取专家个人信息
     */
/*people_count 已成交多少人, satisfaction_rate 满意度,total_score 总积分
COALESCE((SELECT SUM(mo.total_price) FROM u_member_order AS mo WHERE mo.status>=5 AND mo.expert_id=e.id) ,0) 成交额*/
    public function get_expert_detail($where) {
        $sql = "SELECT `e`.`id`, `e`.`sex`, `e`.`small_photo`, `e`.`nickname`, `e`.`template`,`e`.`travel_title`,
(CASE WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' END) AS grade,
e.total_score AS volume,
`e`.`avg_score` AS comments, `e`.`talk`, `e`.`business`, `e`.`beizhu` ,`e`.`city`,`e`.`visit_service`,
((SELECT GROUP_CONCAT(kindname SEPARATOR ',') FROM u_dest_base AS d WHERE FIND_IN_SET(d.id,e.expert_dest))) AS dest,e.people_count AS people_count,e.satisfaction_rate AS satisfaction_rate,e.total_score AS total_score,e.order_amount AS turnover
FROM (`u_expert` AS e) WHERE `e`.`id` = {$where}";
       $query = $this->db->query($sql);
        $data = $query->result_array();
         array_walk($data, array($this, '_fetch_list'));
        return $data;
    }

    /**
     * 获取专家服务记录
     */

    public function get_expert_services($where, $page = 1, $num = 10) {
        if($page > 0){
                             $res_str ="mo.id,mo.litpic,mo.productname,mo.usedate";
                        }else{
                               $res_str = 'count(*) AS num';
                        }
        $this->db->select($res_str);
        $this->db->from('u_member_order AS mo');
        $this->db->join('u_expert AS e', 'e.id=mo.expert_id', 'left');
        $this->db->where($where);

         if ($page > 0) {
            $this->db->order_by('usedate', 'desc');
                $offset = ($page-1) * $num;
                $this->db->limit($num, $offset);
                $query = $this->db->get();
                 return $query->result_array();
            }else{
                $query = $this->db->get();
                $ret_arr = $query->result_array();
                return $ret_arr[0]['num'];
            }

    }

    /**
     * 售卖产品
     *
     */
    public function get_sale_product($where){
        $where_str = "";
        $country_sql = "SELECT id FROM u_startplace WHERE cityname='全国出发'";
        $country_res = $this->db->query($country_sql)->result_array();
        $city_location_id = $this ->session ->userdata('city_location_id');
        $country_id = $country_res[0]['id'];
        foreach ($where as $key => $value) {
            $where_str .= $key.' = '.$value.' AND ';
        }
        $where_str .= "(FIND_IN_SET($city_location_id,ls.startplace_id)>0 OR FIND_IN_SET($country_id,ls.startplace_id)>0)";
        $SQL = " SELECT  l.id ,  l.mainpic ,  l.addtime ,  l.linename,  l.lineprice, l.overcity  FROM ( u_line_apply  AS la) LEFT JOIN  u_expert  AS e ON  la.expert_id = e.id  LEFT JOIN  u_line  AS l ON  la.line_id = l.id  LEFT JOIN  u_line_startplace  AS ls ON  ls.line_id = l.id  WHERE ". $where_str." GROUP BY l.id";
        return $this->db->query($SQL)->result_array();
    }



    /**
     * 游客咨询
     */

    public function expert_customer_ask($where, $page = 1, $num = 10) {
        if($page > 0){
                             $res_str ='l.id AS l_id,l.linename,lq.content,lq.replycontent';
                        }else{
                               $res_str = 'count(*) AS num';
                        }
        $this->db->select($res_str);
        $this->db->from('u_line_question AS lq');
        $this->db->join('u_expert AS e','lq.reply_id=e.id','left');
        $this->db->join('u_line AS l','lq.productid=l.id','left');
        $this->db->where($where);
         if ($page > 0) {
                $offset = ($page-1) * $num;
                $this->db->limit($num, $offset);
                 $query = $this->db->get();
                return $query->result_array();
            }else{
            $query = $this->db->get();
            $ret_arr = $query->result_array();
            return $ret_arr[0]['num'];
        }

    }

    /**
     * 游客评价
     */
    public function get_customer_comments($where, $page = 1, $num = 10) {
         if($page > 0){
                             $res_str ='c.id,m.litpic,m.truename,c.addtime,c.pictures,c.level,c.score1,c.score2,c.score3,c.score4,c.content,c.expert_content,c.avgscore1,c.avgscore2,c.channel,c.reply';
                        }else{
                               $res_str = 'count(*) AS num';
                        }
        $this->db->select($res_str);
        $this->db->from('u_comment AS c');
        $this->db->join('u_member AS m','c.memberid=m.mid','left');
        $this->db->join('u_member_order AS mo','c.orderid=mo.id','left');
        $this->db->join('u_expert AS e','c.expert_id=e.id','left');
        $this->db->where($where);

         if ($page > 0) {
                $this->db->order_by('c.addtime','desc');
                $offset = ($page-1) * $num;
                $this->db->limit($num, $offset);
                $query = $this->db->get();
                $data = $query->result_array();
                array_walk($data, array($this, '_fetch_list'));
                return $data;
            }else{
                $query = $this->db->get();
                $ret_arr = $query->result_array();
                return $ret_arr[0]['num'];
            }

    }

    /**
     * 个人荣誉
     */
 public function get_expert_honor($expert_id) {
        $result = array();
        $sql = 'SELECT travel_title,travel_title_pic FROM u_expert where id='.$expert_id;
        $query = $this->db->query($sql);
        $res=$query->result_array();
        $result['travel_title'] = $res[0];

        $sql = 'SELECT certificate,certificatepic FROM u_expert_certificate where expert_id='.$expert_id;
        $query = $this->db->query($sql);
        $res=$query->result_array();
        if(!empty($res)){
            foreach ($res as $key => $value) {
                $result['cer'][]= $value;
            }
        }else{
            $result['cer']= array();
        }
        return $result;
    }

    /**
     * 定制记录
     */



    public function expert_trans_record($where, $page = 1, $num = 4) {
              if($page > 0){
                             $res_str ="c.id AS c_id,c.question,m.truename,m.litpic,c.addtime,c.service_range,c.startdate,c.estimatedate,de.cityname as startplace,c.endplace,c.people,c.budget,ca.plan_design,ca.plan_feature,ca.score1,ca.score2,ca.score3";
                        }else{
                               $res_str = 'count(*) AS num';
                        }

        $this->db->select($res_str);
        $this->db->from('u_customize AS c');
        $this->db->join('u_member AS m', 'c.member_id=m.mid', 'left');
        $this->db->join('u_customize_answer AS ca', 'ca.customize_id=c.id', 'left');
		$this->db->join('u_startplace AS de', 'de.id = c.startplace', 'left');
        $this->db->where($where);

         if ($page > 0) {
                 $this->db->order_by('c.addtime', 'desc');
                $offset = ($page-1) * $num;
                $this->db->limit($num, $offset);
                $query = $this->db->get();
                $data = $query->result_array();
                array_walk($data, array($this, '_fetch_list'));
                return $data;
            }else{
                $query = $this->db->get();
                $ret_arr = $query->result_array();
                return $ret_arr[0]['num'];
            }

    }
/**
 * 向评论表那里插入用户在线咨询
 */
function inert_online_consultation($insert_data = array()){
    $insert_data['addtime'] = date('Y-m-d H:i:s');
    $insert_data['productid'] = 0;
    $insert_data['reply_type'] = 1;
    $this->db->insert('u_line_question',$insert_data);
}


        /**
         * 个人游记记录
         */
        function get_expert_travels($whereArr, $page = 1, $num = 4){
            if($page > 0){
                             $res_str ="tn.id AS nid,
                                    tn.title AS title,
                                    tn.addtime AS addtime,
                                    tn.comment_count AS comment_count,
                                    tn.praise_count AS praise_count,
                                    tn.content AS content,
                                    tn.cover_pic AS tn_pic";
                        }else{
                               $res_str = 'count(*) AS num';
                        }
         $this->db->select($res_str);
        $this->db->from('travel_note AS tn');
       $whereArr['tn.usertype'] = 1;
       $whereArr['tn.is_show'] = 1;
        $this->db->where($whereArr);
         if ($page > 0) {
                $this->db->order_by('tn.addtime', 'desc');
                $offset = ($page-1) * $num;
                $this->db->limit($num, $offset);
                 $query = $this->db->get();
                 $data = $query->result_array();
                 return $data;
            }else{
                $query = $this->db->get();
                $ret_arr = $query->result_array();
                return $ret_arr[0]['num'];
            }


        }

        /**
         * 个人随笔
         */
        function get_travel_note($whereArr, $page = 1, $num = 4){
             if($page > 0){
                             $res_str =" ee.id AS es_id,
                                        ee.content AS es_content,
                                        ee.addtime AS ee_addtime,
                                        eep.pic AS e_pic,
                                        ee.praise_count AS praise_count";
                        }else{
                               $res_str = 'count(*) AS num';
                        }
        $this->db->select($res_str);
        $this->db->from('u_expert_essay AS ee');
        $this->db->join('u_expert AS e', 'ee.expert_id=e.id', 'left');
        $this->db->join('u_expert_essay_pic AS eep', 'ee.id=eep.expert_essay_id', 'left');
        $this->db->where($whereArr);

         if ($page > 0) {
                $this->db->order_by('ee.addtime', 'desc');
                $offset = ($page-1) * $num;
                $this->db->limit($num, $offset);
                $query = $this->db->get();
                $data = $query->result_array();
                array_walk($data, array($this, '_fetch_list'));
                 return $data;
            }else{
                $query = $this->db->get();
                $ret_arr = $query->result_array();
                return $ret_arr[0]['num'];
            }

        }

/**
 * 统计是否有被收藏过
 */

function get_expert_collection($whereArr = array()){
    $this->db->select ( "count(*) AS collection_count" );
        $this->db->from ( 'u_expert_collect' );
        $this->db->where ( $whereArr );
        $query = $this->db->get ();
        return $query->result_array ();
}

/**
     * 收藏专家
     */
    function insert_expert_collection($insert_data = array()){
        $insert_data['addtime'] = date ( 'Y-m-d H:i:s' );
        $this->db->insert ( 'u_expert_collect', $insert_data );
        return $this->db->insert_id();
    }

    /**
     * 删除收藏专家
     */
    function delete_expert_collection($whereArr=array()){
        if($this->db->delete('u_expert_collect', $whereArr)){
            return true;
        }else{
            return false;
        }
    }
        /**
     * 回调函数
     * @param unknown $value
     * @param unknown $key
     */
    protected function _fetch_list(&$value, $key) {
        $endplace_str = "";
        if(isset($value['e_pic'])&&$value['e_pic']!=''){
            $c_pic = trim($value['e_pic'], ';');
            $pic_arr = explode(';', $c_pic);
            $value['e_pic_arr'] = $pic_arr;
        }
      if(isset($value['pictures'])&&$value['pictures']!=''){
            $c_pic = trim($value['pictures'], ',');
            $pic_arr = explode(',', $c_pic);
            $value['c_pic_arr'] = $pic_arr;
        }
    if(isset($value['endplace']) && $value['endplace']!=''){
            $value['endplace'] = rtrim($value['endplace'],',');
            $sql = 'SELECT kindname  FROM u_dest_base  WHERE id in ('.$value['endplace'].')';
            $query = $this->db->query($sql);
            $res=$query->result_array();
            foreach($res AS $k=>$vl){
                $endplace_str .= $vl['kindname'].',';
            }
            $endplace_str = rtrim($endplace_str,',');
            $value['endplace_name'] = $endplace_str;
        }

         if(isset($value['city'])&&$value['city']!=''){
            $city_sql ='select name from u_area where id='.$value['city'];
            $query = $this->db->query($city_sql);
            $res=$query->result_array();
            $value['city'] = $res['0']['name'];
        }

        if(isset($value['visit_service'])&&$value['visit_service']!=''){
            $city_sql ='select GROUP_CONCAT(name) AS kindname from u_area where id in ('.$value['visit_service'].')';
            $query = $this->db->query($city_sql);
            $res=$query->result_array();
            $value['visit_service'] = $res['0']['kindname'];
        }


    }
}
