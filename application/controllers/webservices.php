<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webservices extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database("default", TRUE);
        $this->callback = $this->input->get("callback");
        header('Content-type: application/json');
//        header("content-type:text/html;charset=utf-8");
    }

    // 定义数据接口开始

    /**
     * 获取所有专家列表
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function admin_b2_orders() {
        $this->load->library('Page');
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 4 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $dataFiled = 'e.id,e.small_photo,e.realname,e.talk,(SELECT COUNT(*) FROM u_member_order AS mo WHERE mo.expert_id=e.id) AS counts,e.service_time,e.visit_service,e.expert_theme';
        $tableName = 'u_expert AS e';
        $count = $this->list_count($tableName, $dataFiled);   //统计、分页
        $this->db->select($dataFiled);
        $this->db->from($tableName);
        $this->db->order_by('e.id', 'desc');
        $this->db->limit($number, $fromDada);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $this->__outmsg($reDataArr, $count);
    }

    /**
     * 线路列表
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function line_list() {
        $this->load->library('Page');
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $dataFiled = 'l.id,l.linename,l.linepic,l.lineprice,l.satisfyscore,l.features,l.bookcount AS sales, l.comment_count AS comments,l.transport,l.hotel,l.lineday';
        $tableName = 'u_line AS l';
        $total_number = $this->list_count($tableName, $dataFiled);   //统计、分页
        $this->db->select($dataFiled);
        $this->db->from($tableName);
        $this->db->limit($number, $fromDada);
        $this->db->where(array(
             'l.status'=>2
        ));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
         $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 线路列表1
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function line_list1() {
        $like = array();
        $newDataArr = array();
        $this->load->library('Page');
        $linecode = $this->input->get('linecode', true);
        $linename = $this->input->get('linename', true);
        $number = $this->input->get('pageSize', true);
        $page = $this->input->get('pageNum', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $dataFiled = 'l.id,l.linecode,l.linename,l.linepic,l.lineprice,l.satisfyscore,l.features,l.bookcount AS sales, l.comment_count AS comments,l.transport,l.hotel,l.lineday';
        $tableName = 'u_line AS l';
        $count = $this->list_count($tableName, $dataFiled, $linecode, $linename);   //统计、分页
        $this->db->select($dataFiled);
        $this->db->from($tableName);
        if (!empty($linecode)) {
            $where = array('l.linecode' => $linecode);
            $this->db->where($where);
        }
        if (!empty($linename)) {
            $like = array('l.linename' => $linename);
            foreach ($like as $k => $v) {
                $this->db->like($k, $v);
            }
        }
        $this->db->limit($number, $fromDada);
        $this->db->where(array(
             'l.status'=>2
        ));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        if (($total = $count - $count % $number) / $number == 0) {
            $total = 1;
        } else {
            $total = ($count - $count % $number) / $number;
            if ($count % $number > 0) {
                $total +=1;
            }
        }
        if ($reDataArr) {
            foreach ($reDataArr as $key => $arr) {
               foreach ($arr as $k => $v) {
                    if ($k == 'linepic') {
                        $linepic = explode(',', $v);
                        $nArr[$k] = htmlspecialchars($linepic[0]);
                    }else{
                        $nArr[$k] = htmlspecialchars($v);
                    }
                }
                $newDataArr[$key] = $nArr;
            }
        }
        $lastData['rows'] = $newDataArr;
        $lastData['total'] = $count;
        $this->resultJSON = json_encode(array(
            "totalRecords" => $lastData['total'],
            "totalPages" => $total,
            "pageNum" => $page,
            "pageSize" => $number,
            "rows" => $lastData['rows']
        ));
        echo $this->callback . "(" . $this->resultJSON . ")";
    }

    /**
     * 游记
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function travel_notes() {
        $this->load->library('Page');
        $e_id = $this->input->get('e_id', true);    //id
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 1 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $dataFiled = 'c.id,m.truename,m.litpic,c.addtime,c.service_range,c.startdate,c.startplace,c.endplace,c.theme,c.people,c.budget,ca.plan_design,ca.plan_feature';
        $tableName = 'u_customize AS c';
        $this->db->select($dataFiled);
        $this->db->from($tableName);
        $this->db->join('u_member AS m', 'c.member_id=m.mid', 'left');
        $this->db->join('u_customize_answer AS ca', 'ca.customize_id=c.id', 'left');
        $this->db->where(array('ca.expert_id' => $e_id));
        $this->db->order_by('c.addtime', 'desc');
        $this->db->limit($number, $fromDada);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $count = $this->travel_count($e_id);                //分页
        $this->__outmsg($reDataArr, $count);
    }

    /*
     * 统计游记  分页
     */

    public function travel_count($e_id) {
        $dataFiled = 'c.id,m.truename,c.addtime,c.service_range,c.startdate,c.startplace,c.endplace,c.theme,c.people,c.budget,ca.plan_design,ca.plan_feature';
        $tableName = 'u_customize AS c';
        $this->db->select($dataFiled);
        $this->db->from($tableName);
        $this->db->join('u_member AS m', 'c.member_id=m.mid', 'left');
        $this->db->join('u_customize_answer AS ca', 'ca.customize_id=c.id', 'left');
        $this->db->where(array('ca.expert_id' => $e_id));
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    /*
     * 统计专家/线路、 分页
     */

    public function list_count($tableName, $dataFiled, $linecode = 0, $linename = '') {
        $this->db->select($dataFiled);
        $this->db->from($tableName);
        if (!empty($linecode)) {
            $where = array('l.linecode' => $linecode);
            $this->db->where($where);
        }
        if (!empty($linename)) {
            $like = array('l.linename' => $linename);
            foreach ($like as $k => $v) {
                $this->db->like($k, $v);
            }
        }
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    /**
     * 用户设计方案
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function customer_lines() {
        $this->db->select('c.id,e.realname,m.truename,m.litpic,c.addtime,c.startdate,c.startplace,c.endplace,c.theme,c.people,c.budget');
        $this->db->from('u_customize AS c');
        $this->db->join('u_member AS m', 'c.id=m.mid', 'left');
        $this->db->join('u_customize_answer AS ca', 'ca.customize_id=c.id', 'left');
        $this->db->join('u_expert AS e', 'e.id=ca.expert_id', 'left');
        $this->db->order_by('c.addtime', 'desc');
        $this->db->limit(2, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 热门路线列表信息
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function hot_line() {
        $this->db->select('l.id,l.linepic,l.linename,l.lineprice,l.bookcount AS sales, l.comment_count AS comments,l.satisfyscore');
        $this->db->from('u_line AS l');
        $this->db->order_by('l.id', 'asc');
        $this->db->limit(4, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 旅游顾问专家列表
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function consult_expert() {
        $this->db->select('id,small_photo');
        $this->db->from('u_expert');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 专家详情
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function expert_detail() {
        $e_id = $this->input->get('e_id', true);
        $this->db->select("e.id,e.small_photo,e.realname,(CASE WHEN e.grade=0 THEN '初级' WHEN e.grade=1 THEN '中级' WHEN e.grade=2 THEN '高级' END) AS grade,(SELECT COUNT(*) FROM u_member_order AS mo WHERE e.id=mo.expert_id) AS volume,(SELECT COUNT(*) FROM u_comment AS c WHERE c.expert_id=e.id) AS comments,e.talk");
        $this->db->from('u_expert AS e');
        $this->db->where(array('e.id' => $e_id));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 服务记录列表
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function expert_services() {
        $e_id = $this->input->get('e_id', true);
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $this->db->select('mo.id,mo.litpic,mo.productname,mo.usedate');
        $this->db->from('u_member_order AS mo');
        $this->db->join('u_expert AS e', 'e.id=mo.expert_id', 'left');
        $this->db->where(array('e.id' => $e_id));
        $this->db->order_by('usedate', 'desc');
        $this->db->limit($number, $fromDada);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 游客咨询
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function expert_customer_ask() {
        $reply_id = $this->input->get('e_id', true);
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $this->db->select('id,content,replycontent');
        $this->db->from('u_line_question');
        $this->db->where(array(
            'reply_type' => 1,
            'reply_id' => $reply_id
        ));
        $this->db->order_by('addtime', 'desc');
        $this->db->limit($number, $fromDada);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 线路详情
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    /*
     * 线路详情 线路主表
     */
    public function line_detail() {   //,lsp.oldprice
        $l_id = $this->input->get('id', true);
        $this->db->select('l.id,l.linename,l.linecode,l.lineprice,l.linepic,l.satisfyscore,l.bookcount AS sales, l.comment_count AS comments,s.cityname,l.childrule,l.product_recommend,l.simple_trip');
        $this->db->from('u_line AS l');
        $this->db->join('u_startplace AS s', 'l.startcity=s.id', 'left');
        $this->db->where(array('l.id' => $l_id));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $lastData['rows'] = "";
        if (sizeof($reDataArr) == 0) {
            $this->result_code = "4001";
            $this->result_msg = "data empty";
        } else {
            $this->result_code = "2000";
            $this->result_msg = "success";
        }
        if ($reDataArr) {
            foreach ($reDataArr as $key => $arr) {
                foreach ($arr as $k => $v) {
                    if ($k == 'linepic') {
                        $linepic = explode(',', $v);
                        for($i=0;$i<count($linepic);$i++){
                            $nArr[$k][$i] = htmlspecialchars($linepic[$i]);
                        }
                    }else{
                        $nArr[$k] = htmlspecialchars($v);
                    }
                }
                $newDataArr[$key] = $nArr;
            }
            $lastData['rows'] = $newDataArr;
        }
        $lastData['total'] = $total_number;
        $this->result_data = $lastData;
        $this->resultJSON = json_encode(array(
            "msg" => $this->result_msg,
            "code" => $this->result_code,
            "data" => $this->result_data
        ));
        echo $this->callback . "(" . $this->resultJSON . ")";
    }

    /*
     * 线路属性
     */

    public function line_property() {
        $l_id = $this->input->get("id", true);
        $sql = "SELECT * FROM u_line_attr st WHERE FIND_IN_SET(st.id ,(SELECT l.linetype FROM u_line l WHERE l.id=$l_id))>0 ORDER BY st.pid ASC";
        $result = $this->db->query($sql);
        $reDataArr = $result->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /*
     * 线路详情    线路套餐
     */

    public function line_meal() {
        $l_id = $this->input->get('id', true);
        $this->db->select('ls.id,ls.suitname');
        $this->db->from('u_line_suit AS ls');
        $this->db->where(array('ls.lineid' => $l_id));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /*
     *  线路价格日历套餐
     */
    public function calendar_meal(){
       $suit_id = $this->input->get('suitid');
       $where = array(
           'ls.id' => $suit_id,
           'day >' => date('Y-m-d', time()),
       	   'lsp.number >' =>0,
       		'ls.is_open' =>1,
       		'lsp.is_open' =>1
       );
       $this->db->select("ls.id,lsp.day,lsp.adultprice,lsp.childprice,lsp.childnobedprice,lsp.oldprice,lsp.number,ls.child_description AS child_rule,ls.old_description AS old_rule,ls.special_description AS special_rule");
       $this->db->from("u_line_suit_price AS lsp");
       $this->db->join("u_line_suit AS ls","lsp.suitid=ls.id","left");
       $this->db->where($where);
       $this->db->order_by("lsp.day");
       $query = $this->db->get();
       $reDataArr = $query->result();
       $total_number = count($reDataArr);
       $this->__outmsg($reDataArr, $total_number);
    }


    /*
     * 根据线路ID，查费用包含和不包含，预定须知,签证
     */

    public function line_info() {
        $l_id = $this->input->get('id', true);
        $this->db->select('id,feeinclude,feenotinclude,book_notice,visa_content');
        $this->db->from('u_line');
        $this->db->where(array('id' => $l_id));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 右侧专家
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function right_expert() {
        $l_id = $this->input->get('id');
        $this->db->select("e.id,e.small_photo,e.realname,e.city,(CASE WHEN e.grade=0 THEN '初级' WHEN e.grade=1 THEN '中级' WHEN e.grade=2 THEN '高级' END) AS grade,(SELECT COUNT(*) FROM u_customize_answer AS ca LEFT JOIN u_expert AS e ON ca.expert_id=e.id) AS scheme,e.comment_count,e.satisfaction_rate");
        $this->db->from('u_expert AS e');
        $this->db->join('u_line_apply AS la', 'e.id=la.expert_id', 'left');
        $this->db->where(array('la.line_id' => $l_id, 'la.status' => 2));
        $this->db->limit(5, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 热卖产品
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function hot_product() {
        $this->db->select('l.id,l.linename,l.lineprice,l.linepic');
        $this->db->from('u_line AS l');
        $this->db->order_by('(SELECT COUNT(*) FROM u_member_order AS mo LEFT JOIN u_line AS l ON l.id=mo.productautoid)', 'desc');
        $this->db->limit(5, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 其他专家
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function other_expert() {
        $l_id = $this->input->get('id');
        $this->db->select('e.id,e.small_photo,e.realname,e.city');
        $this->db->from('u_expert AS e');
        $this->db->join('u_line_apply AS la', 'e.id=la.expert_id', 'left');
        $this->db->where(array('la.line_id' => $l_id, 'la.status' => 2));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        foreach ($reDataArr as $k => $v) {
            if ($k < 5) {
                unset($reDataArr[$k]);
            }
        }
        $reDataArr = array_values($reDataArr);
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 专家心得
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function expert_mind() {
        $l_id = $this->input->get('id');
        $this->db->select("e.id,e.small_photo,e.realname,e.city,(CASE WHEN e.grade=0 THEN '初级' WHEN e.grade=1 THEN '中级' WHEN e.grade=2 THEN '高级' END) AS grade,e.business,e.talk");
        $this->db->from('u_expert AS e');
        $this->db->join('u_line_apply AS la', 'e.id=la.expert_id', 'left');
        $this->db->where(array('la.line_id' => $l_id, 'la.status' => 2, 'e.id' => 1));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     *    行程须知
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function line_notice() {
        $l_id = $this->input->get('id', true);
        $this->db->select('day AS days, title AS theme,breakfirst AS dejeuner,transport AS traffic,jieshao AS introduce,lunch AS nooning,supper AS dinner,hotel');
        $this->db->from('u_line_jieshao');
        $this->db->where(array('lineid' => $l_id));
        $this->db->order_by('day');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 在线咨询
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function online_ask() {
        $p_id = $this->input->get('id', true);
        $this->db->select('id,productid,content,typeid');
        $this->db->from('u_line_question');
        $this->db->where(array('productid' => $p_id));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 游客点评
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function tourist_review() {
        $l_id = $this->input->get('id', true);
        $level = $this->input->get('lev', true);
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        if (!empty($level)) {
            $cwhere = array(
                'c.line_id' => $l_id,
                'c.level' => $level
            );
        } else {
            $cwhere = array(
                'c.line_id' => $l_id
            );
        }

        $this->db->select('c.id,m.litpic,m.truename,c.level,c.score1,c.score2,c.score3,c.score4,c.content,c.addtime,c.channel');
        $this->db->from('u_comment AS c');
        $this->db->join('u_member AS m', 'c.memberid=m.mid', 'left');
        $this->db->join('u_member_order AS mo', 'c.orderid=mo.id', 'left');
        $this->db->join('u_line AS l', 'mo.productautoid=l.id', 'left');
        $this->db->where($cwhere);
        $this->db->limit($number, $fromDada);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 热词搜索
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function hot_search() {
        $hot = $this->input->get('hot', true);
        $like = array('name' => $hot);
        $this->db->select('id,name');
        $this->db->from('cfg_index_hot_search');
        foreach ($like as $k => $v) {
            $this->db->like($k, $v);
        }
        $this->db->order_by('showorder', 'asc');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 导航栏
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function nav_list() {
        $this->db->select('id,name');
        $this->db->from('cfg_index_nav');
        $this->db->order_by('showorder', 'asc');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 轮播图
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function banner_list() {
        $sql = "SELECT id,pic,link FROM cfg_index_roll_pic ORDER BY showorder";
        $this->db->select('id,pic,link');
        $this->db->from('cfg_index_roll_pic');
        $this->db->order_by('showorder', 'asc');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        ;
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 线路搜索
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function line_search() {
        $homecity_name = $this->input->get('homecity_name', true);
        $fonts = $this->input->get('fonts', true);
        if ($homecity_name) {
            $cwhere = array(
                'l.startcity' => $homecity_name
            );
        }
        if ($fonts) {
            $like = array(
                'l.linename' => $fonts
            );
        }
        $number = $this->input->get('number', true);
        $page = $this->input->get('page', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        $fromDada = ($page - 1) * $number;
        $this->db->select('l.id,l.linename,l.lineprice,l.satisfyscore,l.features,l.bookcount AS sales, l.comment_count AS comments,l.transport,l.hotel,l.lineday');
        $this->db->from('u_line AS l');
        if ($cwhere) {
            $this->db->where($cwhere);
        }
        if ($fonts) {
            foreach ($like as $k => $v) {
                $this->db->like($k, $v);
            }
        }
        $this->db->limit($number, $fromDada);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 旅游专家顾问
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function travel_expert() {
        $this->db->select("e.id,e.credit,e.avg_score,cfg.pic,cfg.smallpic,e.realname,e.city,(CASE WHEN grade=0 THEN '初级' WHEN grade=1 THEN '中级' WHEN grade=2 THEN '高级' END) AS grade");
        $this->db->from('cfg_index_expert AS cfg');
        $this->db->join('u_expert AS e', 'cfg.expert_id=e.id', 'left');
        $this->db->where(array('cfg.location' => 1));
        $this->db->order_by('cfg.showorder', 'asc');
        $this->db->limit(20, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 最美专家
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function best_expert() {
        $this->db->select('e.id,cfg.smallpic,e.realname,e.expert_dest');
        $this->db->from('cfg_index_expert AS cfg');
        $this->db->join('u_expert AS e', 'cfg.expert_id=e.id', 'left');
        $this->db->where(array('cfg.location' => 4));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 畅销路线
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function best_line() {
        $this->db->select('l.id,cfg.pic,cfg.name');
        $this->db->from('cfg_index_line_hot AS cfg');
        $this->db->join('u_line AS l', 'cfg.line_id=l.id', 'left');
        $this->db->order_by('showorder', 'desc');
        $this->db->limit(10, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 出境游
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function emigrate_travel() {
        $this->db->select('f.dest_id AS f_dest_id,f.name AS f_name,f.smallpic AS f_smallpic,f.pic AS f_pic,tw.dest_id AS tw_dest_id,tw.name AS tw_name,tw.pic AS tw_pic,l.id AS th_id,th.pic AS th_pic,th.name AS th_name,l.linename,l.lineprice AS th_lineprice');
        $this->db->from('cfg_index_kind AS f');
        $this->db->join('cfg_index_kind_dest AS tw', 'tw.index_kind_id=f.dest_id', 'left');
        $this->db->join('cfg_index_kind_dest_line AS th', 'th.index_kind_dest_id=tw.dest_id', 'left');
        $this->db->join('u_line AS l', 'th.line_id=l.id', 'left');
        $this->db->where(array('f.dest_id' => 1));
        $this->db->limit(6, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 国内游
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function internal_travel() {
        $this->db->select('f.dest_id AS f_dest_id,f.name AS f_name,f.smallpic AS f_smallpic,f.pic AS f_pic,tw.dest_id AS tw_dest_id,tw.name AS tw_name,tw.pic AS tw_pic,l.id AS th_id,th.pic AS th_pic,th.name AS th_name,l.linename,l.lineprice AS th_lineprice');
        $this->db->from('cfg_index_kind AS f');
        $this->db->join('cfg_index_kind_dest AS tw', 'tw.index_kind_id=f.dest_id', 'left');
        $this->db->join('cfg_index_kind_dest_line AS th', 'th.index_kind_dest_id=tw.dest_id', 'left');
        $this->db->join('u_line AS l', 'th.line_id=l.id', 'left');
        $this->db->where(array('f.dest_id' => 2));
        $this->db->limit(6, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 定制游
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function customize_travel() {
        $this->db->select('f.id,f.dest_id AS f_dest_id,f.name AS f_name,f.smallpic AS f_smallpic,f.pic AS f_pic,tw.id,tw.dest_id AS tw_dest_id,tw.name AS tw_name,tw.pic AS tw_pic,l.id AS th_id,th.pic AS th_pic,th.name AS th_name,l.linename,l.lineprice AS th_lineprice');
        $this->db->from('cfg_index_kind AS f');
        $this->db->join('cfg_index_kind_dest AS tw', 'tw.index_kind_id=f.dest_id', 'left');
        $this->db->join('cfg_index_kind_dest_line AS th', 'th.index_kind_dest_id=tw.dest_id', 'left');
        $this->db->join('u_line AS l', 'th.line_id=l.id', 'left');
        $this->db->where(array('f.dest_id' => 3));
        $this->db->limit(6, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /*
     * 邮轮游
     */

    public function steamer_travel() {
        $this->db->select('f.id,f.dest_id AS f_dest_id,f.name AS f_name,f.smallpic AS f_smallpic,f.pic AS f_pic,tw.id,tw.dest_id AS tw_dest_id,tw.name AS tw_name,tw.pic AS tw_pic,l.id AS th_id,th.pic AS th_pic,th.name AS th_name,l.linename,l.lineprice AS th_lineprice');
        $this->db->from('cfg_index_kind AS f');
        $this->db->join('cfg_index_kind_dest AS tw', 'tw.index_kind_id=f.dest_id', 'left');
        $this->db->join('cfg_index_kind_dest_line AS th', 'th.index_kind_dest_id=tw.dest_id', 'left');
        $this->db->join('u_line AS l', 'th.line_id=l.id', 'left');
        $this->db->where(array('f.dest_id' => 4));
        $this->db->limit(6, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 可能喜欢(推荐目的地)
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function recommend_des() {
        $this->db->select('id,pic,name');
        $this->db->from('cfg_index_dest_love');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 最新点评
     * para:page 页数，默认1
     * para:number 记录数，默认10
     * return：json
     */
    public function newest_comment() {
        $this->db->select('c.id,m.truename,c.content');
        $this->db->from('u_comment AS c');
        $this->db->join('u_member AS m', 'c.memberid=m.mid', 'left');
        $this->db->order_by('c.addtime', 'desc');
        $this->db->limit(5, 0);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $total_number = count($reDataArr);
        $this->__outmsg($reDataArr, $total_number);
    }

    /**
     * 手机验证
     */
    public function tel_verify() {
        $this->load->model('member_model');
        $this->load->library('session');
        $tel_id = $this->input->get('tel_id');
        $sql = "SELECT * FROM u_member WHERE mobile='" . $tel_id . "' LIMIT 1";
        $is_reg = $this->db->query($sql)->result();
        if (sizeof($is_reg) == 0) {  //手机号未被注册
            if (preg_match("/1[3458]{1}\d{9}$/", $tel_id)) {
                $generate_code = rand(100000, 999999);
                $this->session->set_userdata(array('yzm' => $generate_code, 'tel_id' => $tel_id));
                echo $this->session->userdata('yzm');
                $this->result_code = "2000";
                $this->result_msg = "success";
//                session_start();
//                echo session_id();
            } else {   //为空或者手机号码格式不对
                $this->result_code = "4000";
                $this->result_msg = "fail";
            }
        } else {  //手机已被注册
            $this->result_code = "4001";   //操作失败
            $this->result_msg = "data has exist";
        }
        $this->resultJSON = array(
            "msg" => $this->result_msg,
            "code" => $this->result_code
        );
        echo $this->callback . "(" . json_encode($this->resultJSON) . ")";
    }

    /*
     * 用户注册
     */

    public function register() {
        $this->load->model('member_model');
        $this->load->library('session');
        $tel_id = $this->input->get('tel_id');
        $m_p = $this->input->get('m_p');
        $m_r_p = $this->input->get('m_r_p');
        $yzm = $this->input->get('yzm');
        $sql = "SELECT * FROM u_member WHERE mobile='" . $tel_id . "' LIMIT 1";
        $is_reg = $this->db->query($sql)->result();
        if (sizeof($is_reg) > 0) {
            $this->result_code = "4001";
            $this->result_msg = "data has exist";
            $this->resultJSON = array(
                "msg" => $this->result_msg,
                "code" => $this->result_code
            );
            echo $this->callback . "(" . json_encode($this->resultJSON) . ")";
            exit;
        }
        if ($yzm == $this->session->userdata('yzm') && $tel_id == $this->session->userdata('tel_id') && $m_p == $m_r_p) {
            if (!empty($m_p)) {
                $data = array('pwd' => md5($m_p), 'loginname' => $tel_id, 'mobile' => $tel_id);
                if ($this->member_model->insert($data)) {
                    $this->result_code = "2000";
                    $this->result_msg = "success";
                }
//                session_start();
//                echo session_id();
            } else {
                $this->result_code = "4000";
                $this->result_msg = "data empty";
            }
        } else {
            $this->result_code = "4001";
            $this->result_msg = "fail";
        }
        $this->resultJSON = array(
            "msg" => $this->result_msg,
            "code" => $this->result_code
        );
        echo $this->callback . "(" . json_encode($this->resultJSON) . ")";
    }

    /**
     * 登陆判断用户名密码是否正确
     */
    public function login() {
        $this->load->model('member_model');
        $this->load->library('session');
        $mem_name = $this->input->get('m_name');
        $password = $this->input->get('m_p');
        $query_data = array();
        if (!empty($mem_name)) {
            $query_data = array(
                "loginname" => $mem_name
            );
            $res_query = $this->member_model->result($query_data);
            if (!empty($res_query)) {
                $password_local = $res_query[0]->pwd;
                $password = md5($password);
                if ($password == $password_local) {
                    $this->session->set_userdata(array('username' => $mem_name));
                    $this->result_code = "2000";
                    $this->result_msg = "success";
                    $this->resultJSON = array(
                        "msg" => $this->result_msg,
                        "code" => $this->result_code
                    );
                    echo $this->callback . "(" . json_encode($this->resultJSON) . ")";
                } else {
                    $this->result_code = "4001";
                    $this->result_msg = "two data not equal";
                    $this->resultJSON = array(
                        "msg" => $this->result_msg,
                        "code" => $this->result_code
                    );
                    echo $this->callback . "(" . json_encode($this->resultJSON) . ")";
                }
            } else {
                $this->result_code = "4001";
                $this->result_msg = "data not exist";
                $this->resultJSON = array(
                    "msg" => $this->result_msg,
                    "code" => $this->result_code
                );
                echo $this->callback . "(" . json_encode($this->resultJSON) . ")";
            }
        }
    }

    // 定义数据接口结束

    /**
     * 定义数据结构结束
     */
    private function __filterVal($var) {
        $result = (isset($var)) ? $var : "";
        return $result;
    }

    private function __outmsg($reDataArr, $total_number) {
        $lastData['rows'] = "";
        if (sizeof($reDataArr) == 0) {
            $this->result_code = "4001";
            $this->result_msg = "data empty";
        } else {
            $this->result_code = "2000";
            $this->result_msg = "success";
        }
        if ($reDataArr) {
            foreach ($reDataArr as $key => $arr) {
                foreach ($arr as $k => $v) {
                    if ($k == 'linepic') {
                        $linepic = explode(',', $v);
                        $nArr[$k] = htmlspecialchars($linepic[0]);
                    }else{
                        $nArr[$k] = htmlspecialchars($v);
                    }
                }
                $newDataArr[$key] = $nArr;
            }
            $lastData['rows'] = $newDataArr;
        }
        $lastData['total'] = $total_number;
        $this->result_data = $lastData;
        $this->resultJSON = json_encode(array(
            "msg" => $this->result_msg,
            "code" => $this->result_code,
            "data" => $this->result_data
        ));
        echo $this->callback . "(" . $this->resultJSON . ")";
    }

}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */