<?php
/**
 * @method		专家详情页面
 * @since		2015年5月10日
 * @author		何俊(junhey@qq.com)
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Expert_detail extends UC_NL_Controller {
  public function __construct() {
    parent::__construct ();
    $this->load_model ( 'expert_detail_model', 'expert_model' );
  }
  public function index($expertid=0) {
    $this->load->helper ( 'url' );
    $this->load->helper ( 'kefu' );
    $this->load->helper ( 'my_text' );
    $this->load->library ( 'Page' );
    // 获取专家详情
    //$expertid = $this->input->get ( 'expertid', true );
    $cwhere = array(
        'e.id' => $expertid
    );
    $expert_detail = $this->expert_model->get_expert_detail ( /*$cwhere*/$expertid );
    //print_r($this->db->last_query());exit();
    if(empty($expert_detail)){
    	redirect('expert/expert_list');
    }
    $c_whereArr['member_id'] = $this->session->userdata('c_userid');
    $c_whereArr['expert_id'] = $expertid;
    $collection_arr = $this->expert_model->get_expert_collection($c_whereArr);
    // 售卖产品
    $cwhere = array(
        'e.id' => $expertid,
        'la.status' => 2,
         'l.status' => 2,
         'l.producttype'=>0/*,
         'l.startcity'=>$this ->session ->userdata('city_location_id')*/
    );
    $sale_product = $this->expert_model->get_sale_product ( $cwhere );
    // 个人荣誉
    $expert_honor = $this->expert_model->get_expert_honor ($expertid);
    //print_r($expert_honor);exit();
    $post_arr['tn.userid'] =  $expertid;
    $expert_travels = $this->expert_model->get_expert_travels( $post_arr,1, 4);

    $data = array(
        'expert_detail' => $expert_detail,
        'sale_product' => $sale_product,
        'expert_honor' => $expert_honor,
        'expertid' => $expertid,
        'user_id' => $this->session->userdata('c_userid'),
        'expert_travels'=>$expert_travels,
        'collection_count' => $collection_arr[0]['collection_count']
    );
    $this->load->view ( 'expert/expert_detail_view', $data );
  }

  // 个人定制记录
  function get_trans_record() {
    $e_id = $this->input->post ( 'expertid', true );
    $pre_page = $this->input->post ( 'pageSize', true );
    $num = empty ( $pre_page ) ? 10 : $pre_page;
    $new_page = $this->input->post ( 'pageIndex', true );
    $new_page = empty ( $new_page ) ? 1 : $new_page;
    $post_arr = array(
        'ca.expert_id' => $e_id,
        'c.status'=>3
    );
    $result = $this->expert_model->expert_trans_record ( $post_arr, $new_page, $num );
    $total = $this->expert_model->expert_trans_record ( $post_arr, 0, $num);
    echo json_encode ( array(
        'total' => $total,
        'result' => $result
    ) );
  }

  // 游客咨询记录
  function get_consultation_record() {
    $typeid = $this->input->post ( 'typeid', true );
    $e_id = $this->input->post ( 'expertid', true );
    $pre_page = $this->input->post ( 'pageSize', true );
    $num = empty ( $pre_page ) ? 10 : $pre_page;
    $new_page = $this->input->post ( 'pageIndex', true );
    $new_page = empty ( $new_page ) ? 1 : $new_page;
    $post_arr['e.id'] = $e_id;
    if (! empty ( $typeid )) {
      $post_arr['lq.typeid'] = $typeid;
    }
    $total = $this->expert_model->expert_customer_ask ( $post_arr, 0, $num );
    $customer_ask = $this->expert_model->expert_customer_ask ( $post_arr, $new_page, $num );

    echo json_encode ( array(
        'total' => $total,
        'result' => $customer_ask
    ) );
  }

  // 游客评价
  function get_comment_record() {
    $e_id = $this->input->post ( 'expertid', true );
    $pre_page = $this->input->post ( 'pageSize', true );
    $num = empty ( $pre_page ) ? 10 : $pre_page;
    $new_page = $this->input->post ( 'pageIndex', true );
    $new_page = empty ( $new_page ) ? 1 : $new_page;
    $post_arr = array(
        'e.id' => $e_id
    );
    $customer_comments = $this->expert_model->get_customer_comments ( $post_arr, $new_page, $num );
    $total = $this->expert_model->get_customer_comments ( $post_arr, 0, $num );
    echo json_encode ( array(
        'total' => $total,
        'result' => $customer_comments
    ) );
  }

    /**
     * 汪晓烽
     * 2015-05-19 11:26:36
     * 游客在线咨询
     */
    function online_consultation(){
        $data = $this->security->xss_clean($_POST);
        $insert_data = array(
            'typeid'=>$data['consultation_radio'],
            'content'=>$data['consultation_content'],
            'reply_id'=>$data['expert_id'],
            'pid'=>0,
            'addtime'=>date('Y-m-d H:i:s'),
            'status'=>0

        );
        if(trim($data['consultation_content'])==''){
            echo json_encode(array('status' =>-1 ,'msg' =>'咨询咨询内容不能空'));
             exit;
        }
        $user_id = $this->session->userdata('c_userid');
        $sql = "select truename,mobile from u_member where mid=$user_id";
        $member_info = $this->db->query($sql)->result_array();
        $insert_data['nickname'] = empty($member_info[0]['truename']) ? $member_info[0]['mobile'] : $member_info[0]['truename'];
        $insert_data['memberid'] = $this->session->userdata('c_userid');
        $this->expert_model->inert_online_consultation($insert_data);
        echo json_encode(array('status' =>1 ,'msg' =>'咨询已提交'));
        exit;
    }


//个人游记
function expert_travels(){
    $expert_id = $this->input->post('expertid');
   // $pre_page = $this->input->post ( 'pageSize', true );
    $num = 4;//empty ( $pre_page ) ? 5 : $pre_page;
    $new_page = $this->input->post ( 'scroll_page', true );
    //$new_page = empty ( $new_page ) ? 1 : $new_page;
    $post_arr = array();
    $post_arr['tn.userid'] =  $expert_id;
    $expert_travels = $this->expert_model->get_expert_travels( $post_arr, $new_page, $num );
    //$total = $this->expert_model->get_expert_travels( $post_arr, 0, $num );
    echo json_encode ( array(
  /*      'total' => $total,*/
        'result' => $expert_travels
    ) );
}


//个人游记详情
function expert_travel_detail(){
  $this->load->view ( 'expert/expert_travels_view');
}
//个人随笔记录
function expert_travel_note(){
    $expert_id = $this->input->post('expertid');
    $pre_page = $this->input->post ( 'pageSize', true );
    $num = empty ( $pre_page ) ? 10 : $pre_page;
    $new_page = $this->input->post ( 'pageIndex', true );
    $new_page = empty ( $new_page ) ? 1 : $new_page;
    $post_arr = array();
    $post_arr['ee.expert_id'] = $expert_id;
    $total = $this->expert_model->get_travel_note( $post_arr, 0, $num );
    $travel_notes = $this->expert_model->get_travel_note( $post_arr, $new_page, $num );
    echo json_encode ( array(
        'total' => $total,
        'result' => $travel_notes
    ) );
}

//用户对专家随笔点赞
function click_praise (){
    $insert_arr = array();
    $c_id = $this->input->post('c_id');
    $eesy_id = $this->input->post('eesy_id');
    $this->db->select("count(*) AS  praise_count");
    $this->db->from('u_expert_essay_praise');
    $this->db->where(array('expert_essay_id'=>$eesy_id,'member_id'=>$c_id));
    $res = $this->db->get()->result_array();
    if($res[0]['praise_count']==0){
        $insert_arr['expert_essay_id'] = $eesy_id;
        $insert_arr['member_id'] = $c_id;
        $insert_arr['ip'] = $_SERVER["REMOTE_ADDR"];
        $insert_arr['addtime'] = date('Y-m-d H:i:s');
        if($this->db->insert('u_expert_essay_praise',$insert_arr)){
            $update_sql = "update u_expert_essay set praise_count=praise_count+1 where id=$eesy_id";
            if($this->db->query($update_sql)){
                $this->db->select("praise_count");
                $this->db->from('u_expert_essay');
                $this->db->where(array('id'=>$eesy_id));
                $res = $this->db->get()->result_array();
                echo json_encode(array('status'=>200,'msg'=>'点赞成功','praise_count'=>$res[0]['praise_count']));
            }else{
                echo json_encode(array('status'=>-201,'msg'=>'点赞失败'));
            }
        }else{
            echo json_encode(array('status'=>-202,'msg'=>'点赞失败'));
        }
    }else{
        $delete_sql = "delete from u_expert_essay_praise where expert_essay_id=$eesy_id and member_id=$c_id";
        if($this->db->query($delete_sql)){
            $update_sql = "update u_expert_essay set praise_count=praise_count-1 where id=$eesy_id";
            if($this->db->query($update_sql)){
                $this->db->select("praise_count");
                $this->db->from('u_expert_essay');
                $this->db->where(array('id'=>$eesy_id));
                $res = $this->db->get()->result_array();
                echo json_encode(array('status'=>200,'msg'=>'取消点赞','praise_count'=>$res[0]['praise_count']));
            }else{
                echo json_encode(array('status'=>-201,'msg'=>'取消点赞失败'));
            }
        }else{
            echo json_encode(array('status'=>-202,'msg'=>'取消点赞失败'));
        }
    }
}

function add_cancle_expert(){
     $userid = $this ->session ->userdata('c_userid');
        if ($userid < 1) {
            echo json_encode(array('status'=>400,'msg'=>'您还未登录'));
            exit();
        }
    $c_member_id = $this->input->post('c_member_id');
        $collect_count = $this->input->post('collect_count');
        $expert_id = $this->input->post('expert_id');
        $whereArr = array();
        if($collect_count==0){ //如果没有收藏过就添加收藏
           $insert_data['member_id'] = $c_member_id;
           $insert_data['expert_id'] = $expert_id;
           $insert_id = $this->expert_model->insert_expert_collection($insert_data);
           if($insert_id){
            echo json_encode(array('status'=>200,'msg'=>'收藏成功'));exit();
           }else{
            echo json_encode(array('status'=>-201,'msg'=>'收藏失败'));exit();
           }
        }else{   //如果已经收藏过了,就取消收藏
            $whereArr['member_id'] = $c_member_id;
            $whereArr['expert_id'] = $expert_id;
            $result = $this->expert_model->delete_expert_collection($whereArr);
            if($result){
                echo json_encode(array('status'=>200,'msg'=>'取消收藏'));exit();
            }else{
                echo json_encode(array('status'=>-202,'msg'=>'取消收藏失败'));exit();
            }
        }
}
}