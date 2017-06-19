<?php
/*
*
*        do     one     sql     one     model
*
*        by     zhy
*
*        at     2016年2月18日 15:13:16
*
*/
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sc_db_model extends MY_Model {


    function __construct() {
        parent::__construct();
    }
/*
*
*        do     gn	jw
*
*        by     zhy
*
*        at     2016年2月22日 16:31:44
*
*/
    function show_gnjw($loca){
        $sql = " select id,kindname from u_dest_base where pid in(select id from u_dest_base where pid={$loca}) and ishot=1 and isopen=1 limit 15  ";
    	return $this ->db ->query($sql) ->result_array();
    }
/*
*
*        do     zb
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_zb($loca){
        $sql = " select crt.id,d.kindname from (select * from cfg_round_trip where startplaceid={$loca})crt left join (select * from u_dest_base)d on d.id=crt.neighbor_id limit 15  ";
    	return $this ->db ->query($sql) ->result_array();
    }
/*
*
*        do     zt
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_zt(){
        $sql = " select * from u_theme order by showorder limit 15  ";
    	return $this ->db ->query($sql) ->result_array();
    }
/*
*
*        do     lunbo
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_lunbo(){
        $sql = "select * from sc_index_roll_pic order by id limit 4  ";
    	return $this ->db ->query($sql) ->result_array();
    }


 /*
*
*        do     public
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_public($loca){
        $sql = "SELECT a.id,a.title,aa.attrname FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id left join sc_index_article_attr as aa on aa.id=a.article_attr_id where c.is_show=1 and c.index_kind_id={$loca} ORDER BY c.showorder desc limit 5 ";
    	return $this ->db ->query($sql) ->result_array();
    }

 /*
*
*        do     recommend_line
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_recommend_line(){
        $sql = "select r.line_id as lineid,l.linename,l.lineprice,l.linetitle,l.overcity,l.marketprice,l.mainpic,e.nickname,e.id as expert_id,e.sex,e.big_photo from sc_index_recommend_line as r left join u_line as l on r.line_id=l.id left join u_line_apply as la on la.line_id=l.id left join u_expert as e on e.id=la.expert_id where r.status=1 GROUP BY r.line_id limit 3 ";
    	return $this ->db ->query($sql) ->result_array();
    }


 /*
*
*        do     index_application
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_application(){
        $sql = "select name,pic,link from sc_index_application where isopen=1 order by showorder limit 9";
    	return $this ->db ->query($sql) ->result_array();
    }


 /*
*
*        do     index_application
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_kind(){
        $sql = "select id,pic,name from sc_index_kind where isopen=1 order by showorder asc";
    	return $this ->db ->query($sql) ->result_array();
    }




 /*
*
*        do     index_kind_line
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_kind_line(){
        $sql = "select kl.*,l.linename,l.mainpic,l.overcity,l.lineprice from sc_index_kind_line as kl left join u_line as l on kl.line_id=l.id where kl.is_show=1 order by showorder";
    	return $this ->db ->query($sql) ->result_array();
    }



 /*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_category(){
        $sql = "select * from sc_index_category order by showorder";
    	return $this ->db ->query($sql) ->result_array();
    }



 /*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_category_consult(){
        $sql = "select cc.*,aa.attrname,uc.pic,uc.title from sc_index_category_consult as cc left join sc_index_article_attr as aa on cc.article_attr_id=aa.id left join u_consult as uc on cc.consult_id=uc.id order by showorder";
    	return $this ->db ->query($sql) ->result_array();
    }


 /*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_public_qrcode(){
        $sql = "select * from sc_index_public_qrcode where status=1 limit 1";
    	return $this ->db ->query($sql) ->result_array();
    }





	 /*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_bangu_article(){
        $sql = "select * from sc_index_bangu_article order by showorder limit 3";
    	return $this ->db ->query($sql) ->result_array();
    }


	 /*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_ndex_travel_article(){
        $sql = "select * from sc_index_travel_article where is_show=1 order by showorder limit 4";
    	return $this ->db ->query($sql) ->result_array();
    }


/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_fix_desc(){

        $sql = "select * from sc_fix_desc where is_show=1 and location=1 order by showorder";
        $sql2 = "select * from sc_fix_desc where is_show=1 and location=2 order by showorder";
        $data['top']=$this ->db ->query($sql) ->result_array();
        $data['center']=$this ->db ->query($sql2) ->result_array();

        return $data;
    }


	/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_index_category_consult_two(){
        $sql = "SELECT a.id,a.title,aa.attrname FROM sc_index_category_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id left join sc_index_article_attr as aa on aa.id=a.article_attr_id where (c.sc_index_category_id=1 or c.sc_index_category_id=2) and c.is_top=1 ORDER BY c.showorder desc limit 5";
    	return $this ->db ->query($sql) ->result_array();
    }
	/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_travel_sc_consult(){
        $sql = "SELECT a.id,a.title FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id where c.is_show=1 ORDER BY c.istop desc,c.showorder limit 2,6 ";
    	return $this ->db ->query($sql) ->result_array();
    }



	/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_travel_sc_consult_2(){
        $sql = "	SELECT a.id,a.title,a.content,a.pic FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id where c.is_show=1 ORDER BY c.istop desc,c.showorder limit 1 ";
    	return $this ->db ->query($sql) ->result_array();
    }


   /**
    * sidebar部分的咨询
    * 
    * */
    function sidebar_consult($limit="")
    {
    	$sql = "SELECT a.id,a.title,a.pic,a.pic_tar FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id where c.is_show=1 ORDER BY c.istop desc,c.showorder limit {$limit}";
    	return $this ->db ->query($sql) ->result_array();
    }


	/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_travel_expert(){
        $sql = "	SELECT `e`.`id` as eid, `e`.`nickname`, `e`.`talk`, (select GROUP_CONCAT(kindname) from u_dest_base where FIND_IN_SET(id,e.expert_dest) >0 )as end ,(select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,e.visit_service) >0 )as door ,`a`.`name` as cityname, `ie`.`smallpic`, `ie`.`pic`, CASE WHEN e.grade=1 THEN '管家'  WHEN	e.grade=2 THEN '初级管家'  WHEN e.grade=3 THEN '中级管家' WHEN e.grade=4 THEN '高级管家' END grade	FROM (`cfg_index_expert` as ie) LEFT JOIN `u_expert` as e ON `ie`.`expert_id` = `e`.`id` LEFT JOIN `u_area` as a ON `a`.`id` = `ie`.`startplaceid` WHERE `ie`.`is_show` = 1 AND `ie`.`location` = 1 AND `e`.`status` = 2 AND `ie`.`startplaceid` = '235' ORDER BY `ie`.`showorder` asc LIMIT  1,12 ";
    	return $this ->db ->query($sql) ->result_array();
    }



/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_travel_line($loca){
        $sql = "	SELECT u.id as lineid,linename,lineprice,mainpic,linetitle,overcity ,marketprice,satisfyscore from sc_index_dest_line as s LEFT JOIN u_line as u on s.line_id= u.id where find_in_set({$loca},u.overcity) limit 3  ";
    	
        return $this ->db ->query($sql) ->result_array();
    }



/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_travel_line_zb(){
        $sql = "	SELECT u.id as lineid,linename,lineprice,mainpic,linetitle, right(overcity , 1) AS inou   ,overcity,marketprice,satisfyscore from sc_index_dest_line as s LEFT JOIN u_line as u on s.line_id= u.id where s.dest_id IN (SELECT neighbor_id FROM `cfg_round_trip` WHERE startplaceid=235 AND isopen=1) limit 3 ";
    	
        return $this ->db ->query($sql) ->result_array();
    }

/*
*
*        do     index_category
*
*        by     zhy
*
*        at     2016年2月22日 17:12:55
*
*/
    function show_travel_line_zt(){
        $sql = "SELECT u.id as lineid,linename,lineprice,mainpic,linetitle, right(overcity , 1) as inou   ,overcity,marketprice,satisfyscore   from  sc_index_theme_line as t LEFT JOIN  u_line as u    on u.id = t.line_id  where t.is_show=1 and u.themeid!=0 ORDER BY showorder   limit 3	";
        
        return $this ->db ->query($sql) ->result_array();
    }
    /**
     * 友情链接
     * */
    function friend_link($limit){
    	$sql = "select * from u_friend_link where link_type='1' order by showorder limit {$limit}";
    
    	return $this ->db ->query($sql) ->result_array();
    }

	}