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

class Sc_scactivity_model extends MY_Model {


    function __construct() {
        parent::__construct();
    }
/*
*
*        do     quality		line
*
*        by     zhy
*
*        at     2016年2月22日 15:22:59
*
*/
    function quality_line(){
        $sql = " select u.id as lineid,linename,lineprice,marketprice,linetitle,ordertime ,lineprename ,overcity,marketprice ,t.pic from sc_high_quality_line as t LEFT JOIN  u_line as u  on u.id = t.line_id where t.`status`=1 ORDER BY showorder  limit 5   ";
    	return $this ->db ->query($sql) ->result_array();
    }
	
/*
*
*        do     recommend	line
*
*        by     zhy
*
*        at     2016年2月22日 15:22:59
*
*/
    function recommend_line(){
        $sql = " select u.id as lineid,linename,lineprice,linetitle  ,overcity,marketprice ,t.pic from 	sc_recommend_line as t LEFT JOIN  u_line as u    on u.id = t.line_id  where t.`status`=1   ORDER BY showorder    limit 3  ";
    	return $this ->db ->query($sql) ->result_array();
    }
	

/*
*
*        do     recommend	line
*
*        by     zhy
*
*        at     2016年2月22日 15:45:58
*
*/
    
 
    function out_inseid_line($loca){
        $sql = " 	   SELECT sc.name as kindname  FROM `sc_activity_dest` AS sc LEFT JOIN u_dest_base AS u ON sc.dest_id = u.id WHERE index_kind_id ={$loca} AND `status`=1  order by sc.showorder  LIMIT 5  ";
    	return $this ->db ->query($sql) ->result_array();
    }

 /*
 *
 *        do    sole
 *
 *        by     zhy
 *
 *        at    2016年2月24日 17:05:05
 *
 */
    function sole_num($loca){
        $sql = " 	  SELECT sc.id  FROM `sc_activity_dest` AS sc	LEFT JOIN u_dest_base AS u ON sc.dest_id = u.id  	WHERE index_kind_id ={$loca} AND sc.`status`=1  order by sc.showorder  limit 5  ";
        return $this ->db ->query($sql) ->result_array();
    }  

/*
*
*        do     recommend	line
*
*        by     zhy
*
*        at     2016年2月22日 15:45:53
*
*/
    function out_inseid_pro($tip){
        $sql = " 	
	SELECT 
  u.id,
  u.lineprice,
  u.linename,
  u.mainpic,
  u.overcity    
FROM
sc_activity_dest_line AS dl
  LEFT JOIN u_line AS u 
    ON u.id = dl.line_id 
WHERE 

   dl.sc_activity_dest_id={$tip}
  AND u.status = 2 
  AND dl.status=1
   order by dl.showorder
LIMIT 6 





    ";
    	return $this ->db ->query($sql) ->result_array();
    } 
/*
*
*        do     round	line
*
*        by     zhy
*
*        at     2016年2月22日 15:45:49
*
*/
    function round_pro(){
        $sql = " 	SELECT u.kindname FROM `sc_activity_dest` as sc LEFT JOIN u_dest_base as u on sc.dest_id = u.id		where sc.dest_id in (10388,10434,10542,10436,10437,10438,10439,10440,10441,10442  ) and sc.status=1 ";
    	return $this ->db ->query($sql) ->result_array();
    } 
	
	
/*
*
*        do     round	line
*
*        by     zhy
*
*        at     2016年2月22日 15:45:45
*
*/
    function round_pro_list(){
        $sql = " 	SELECT u.id,u.lineprice,u.linename,u.mainpic,u.overcity FROM sc_activity_dest as d  LEFT JOIN sc_activity_dest_line as dl on d.id=dl.activity_city_id LEFT JOIN u_line as u on u.id=dl.line_id  where d.`status`=1 and index_kind_id =1 and d.dest_id in (10388,10434,10542,10436,10437,10438,10439,10440,10441,10442  ) and u.status = 2  limit 6";
    	return $this ->db ->query($sql) ->result_array();
    }
 /*
 *
 *        do    3
 *
 *        by     zhy
 *
 *        at    2016年2月24日 17:55:46
 *
 */
    function show_pic_3(){
        $sql = " SELECT pic,dest_id,name from sc_activity_dest_love where status =1 limit 3";
        return $this ->db ->query($sql) ->result_array();
    }
   /*
   *
   *        do     3->1,2,3
   *
   *        by     zhy
   *
   *        at  2016年2月26日 17:24:19
   *
   */

    function show_pic_3_2($loca){
        $sql = "     select pid from u_dest_base where id = {$loca}";
        return $this ->db ->query($sql) ->result_array();
    }
}