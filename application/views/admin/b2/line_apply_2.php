<style type="text/css">
a{ color: #09c;}
.form-control{ display: inline; width: 200px; }
.form-group { float: left;}
.nav-tabs{ background: none;box-shadow:none;-webkit-box-shadow:none; }
.page-body .nav-tabs{background: #fff; border-bottom: 1px solid #ddd;}
.page-body{ padding: 20px;}
.nav-tabs > li.active > a, .nav-tabs > li.active > a, .nav-tabs > li.active > a{ border: none ;border-top: 2px solid #2dc3e8;}
.page-body .nav-tabs li{ padding: 0; background: #eaedf1;}
.form-group input{ height: 30px; line-height: 30px;}
.form-group{ margin-right: 20px;}
.form-wlpBox{ padding-bottom: 0px;}
.tab-content{ background: #fff;}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{ background: #fff;}
.form-group{ margin-right: 20px;}
.form-group label{ height: 26px; line-height: 26px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666; float: left}
.form-group input{ height:26px; line-height: 26px; padding: 0; padding-left: 10px; float: left;}
.btn{ margin: 0 5px;}
.table thead>tr>th{ background: #fff;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.btn-info:hover, .open .btn-info.dropdown-toggle,.btn-info, .btn-info:focus{ background-color: #09C!important; border-color: #09C!important; font-size:12px;}
.formBox { padding: 0; min-height:auto !important; padding-bottom: 15px;}
.form-group{ margin:15px; margin-left: 0;}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
input{ line-height:100%\9;}
.tab-content { padding-top:0 !important;}
label { margin-bottom:0;}
.tabbable { padding-left:10px;background:#fff; padding-top: 10px;}
#gcc tbody>tr>td{ padding: 6px;}
.tab-content { padding:0 0 15px 0 !important;}
</style>
   <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
            <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        <li><i class="fa fa-home"> </i> <a
            href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
                        <li class="active">售卖线路列表</li>
                    </ul>
            </div>
                <!-- /Page Header -->
                 <!-- Page Body -->
<div class="page-body" id="bodyMsg">
                <div class="widget">
                   <!--  <div class="widget-body"> -->
                <div class="flip-scroll">
                    <div class="tabbable">
                        <ul id="myTab5" class="nav nav-tabs">
                        <!-- <li class="tab-blue"><a href="<?php echo base_url(); ?>admin/b2/line_apply/new_line" >最新线路</a></li> -->
                            <li class="tab-red"><a href="<?php echo base_url(); ?>admin/b2/line_apply/index" >未申请</a></li>

                            <li class="active"><a href="<?php echo base_url(); ?>admin/b2/line_apply/applyed_index" >已申请</a></li>
                            <li class="tab-red"><a href="<?php echo base_url(); ?>admin/b2/line_apply/group_index" >定制线路</a></li>
                        </ul>
                         <div class="tab-content shadow">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-wlpBox">
                                <label>
                                    <form class="form-inline formBox" method="post" action="<?php echo site_url('admin/b2/line_apply/applyed_index')?>" >

                                        <div class="form-group" style="float:left">
                                                <label>出发地:</label>
                                                <input type="text" class="" id="start_place"  name="start_place" value="<?php echo $startplace_check;?>" style="" />
                                        </div>
    									<div class="form-group " style="float:left">
                                            <label >线路编号:</label>
                                             <input type="text" class="form-control" name="linecode" value="<?php if(!empty($linecode_check)){echo $linecode_check;} ?>">
                                        </div>
                                        <div class="form-group " style="float:left">
                                            <label >线路名称:</label>
                                             <input type="text" class="form-control" name="linename" value="<?php echo $linename_check;?>"/>
                                        </div>
                                         <div class="form-group " style="float:left">
                                           <label>供应商</label>
                                            <select name="supplier_id" class="ie8_select">
                                            <option value="">请选择</option>
                                            <?php foreach ($suppliers as $item):?>
                                                 <?php if ($item['id'] == $supplier_check): ?>
                                                     <option value="<?php echo $item['id'];?>" selected='selected'><?php echo $item['realname'];?></option>
                                                <?php else: ?>
                                                        <option value="<?php echo $item['id'];?>"><?php echo $item['realname'];?></option>
                                                 <?php endif?>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="form-group " style="float:left">
                                           <label>管家等级</label>
                                            <select name="expert_grade" id="expert_grade" v='<?php echo  $expert_grade;?>' class="ie8_select">
                                                    <option value="">请选择</option>
                                                    <option value="1">管家</option>
                                                     <option value="2">初级专家</option>
                                                    <option value="3">中级专家</option>
                                                     <option value="4">高级专家</option>
                                            </select>
                                             <script type="text/javascript">
                                                    var selects = $("#expert_grade");
                                                    for(var i=0 ;selects && i <selects.length ; i++ ){
                                                        selects[i].value=selects[i].getAttribute('v');
                                                    }
                                            </script>
                                        </div>
                                        <div class="form-group"  style="float:left">
                                                <label >目的地:</label>
                                                <input type="text" class="form-control" id="destinations"  name="destination" value="<?php echo $destnation_check;?>" >
                                                <input type="hidden" name="overcity" id="overcity">
                                        </div>
                                        <div class="form-group"  style="float:left">
                                        	<button type="submit" class="btn btn-darkorange active" style="margin: 0px;">搜索</button>
                                        </div>
                                    </form>
                        </label>
                       </div>
                                <table class="table table-bordered table-hover"  id="gcc">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">
                                                线路编号
                                            </th>
                                            <th style="text-align:center">
                                                线路名称
                                            </th>
                                             <th style="text-align:center">
                                                供应商名称
                                            </th>
                                              <th style="text-align:center">
                                                联系人
                                            </th>
                                           <!--  <th style="text-align:center">
                                               管家佣金
                                           </th> -->
                                            <th style="text-align:center">
                                                已获级别
                                            </th>
                                            <th style="text-align:center">
                                                线路状态
                                            </th>
                                            <th style="text-align:center">
                                                操作
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($line_apply_list as $item): ?>
                                        <tr>
                                            <td style="text-align:center">
                                                <?php echo $item['line_sn'];?>
                                            </td>
                                            <td style="text-align:center" title="<?php echo $item['line_title'];?>">
                                                <!-- 将cj,gn改为line,添加后缀.html-->
                                               <a target="_blank" href="<?php echo in_array(1 ,explode(',',$item['overcity'])) ? '/line/'.$item['line_id'].'.html' : '/line/'.$item['line_id'].'.html';?>"><?php echo mb_substr($item['line_title'],0,15,'utf-8').'...';?></a>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['supplier_name'];?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['mobile'];?>
                                            </td>
                                            <!-- <td style="text-align:center">
                                                <?php echo $item['agent_rate_int'];?>
                                            </td> -->
                                            <td style="text-align:center">
                                            <?php if($item['grade']==1):?>
                                                <?php echo '管家';?>
                                            <?php  elseif($item['grade']==2):?>
                                                <?php echo '初级专家';?>
                                            <?php  elseif($item['grade']==3):?>
                                                <?php echo '中级专家';?>
                                            <?php  elseif($item['grade']==4):?>
                                                <?php echo '高级专家';?>
                                            <?php endif;?>
                                            </td>
                                             <td style="text-align:center">
                                                <?php if($item['status']==2)echo "<font color='blue'>正常售卖</font>"; else echo "<font color='red'>已下线</font>";?>
                                            </td>
                                            <td style="text-align:center"><a target="_blank"  class="edit"  href="<?php echo base_url('admin/b2/line_apply/line_detial') ;?>?id=<?php echo $item['line_id'];?>">查看</a><a data-val="<?php echo $item['line_id']?>"  class="edit"  onclick="give_up(this)">放弃</a><a data-val="<?php echo $item['line_id'].'|'.$item['grade']?>"  class="edit"  onclick="show_grade_dialog(this)">申请升级</a></td>
                                        </tr>
                                      <?php endforeach;?>

                                    </tbody>
                                </table>
                                <div class="pageBox">
                                    <div class="pagination"><?php echo $this->page->create_page()?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           <!--  </div> -->
        </div>
</div>


<!--  -->
<!--升级申请-->
<div id="myModal" style="display: none;position:fixed" class="bootbox modal fade in">
    <div class="modal-dialog" style="margin:30px auto; width:600px;">
    <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
    <h4 class="modal-title">升级申请</h4>
  </div>
<div class="modal-body">
<div class="bootbox-body " style=" overflow: hidden;">
  <div>
    <form class="form-horizontal " role="form" id="applyUpgrade" method="post"
        action="#">
        <div style="width:100%; padding-left:150px;">
        <div class="form-group" style="float:none">
            <label for="inputEmail3" class=" control-label col_ts fl">申请级别</label>
            <div class="col_ts fl">
                <select name="after_level" id="after_level" class="ie8_select" style="width:150px;height:30px;">
                    <option value="">--请选择--</option>
                    <option value="1">管家</option>
                    <option value="2">初级专家</option>
                    <option value="3">中级专家</option>
                    <option value="4">高级专家</option>
                </select>
                <input type="hidden" name="before_level" id="before_level" value=""/>
                <input type="hidden" name="upgrade_line_id" id="upgrade_line_id" value=""/>
            </div>
        </div>
</div>
        <div class="form-group" style="float:none; margin:0">
            <input type='submit' class="btn btn-palegreen" value='提交' style="width:100px; padding: 0px !important; margin-left:220px; color:#fff;" />
        </div>
    </form>
 </div>
  </div>
</div>
 </div>
</div>
</div>
<!--end 升级申请-->
<!--背景-->
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>
<!--end 背景-->



<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<!--目的的模糊查询  -->
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>

<script type="text/javascript">

$(document).ready(function(){


$("#applyUpgrade").submit(function(){
         $.post(
    "<?php echo base_url();?>admin/b2/line_apply/apply_grade",
   $("#applyUpgrade").serialize(),
    function (result) {
        result = eval("("+result+")");
        if(result){
            alert("申请已提交等待审核!");
            location.reload();
        }else{
            alert("操作失败!");
        }
        });
         return false;
});
  /*目的的模糊查询*/
 $.post("/common/area/getRoundTripData",{},function(json) {
    var data = eval("("+json+")");
    chioceDestJson.trip = data;
    //所有目的地
    createChoicePlugin({
        data:chioceDestJson,
        nameId:"destinations",
        valId:"overcity"
    });
});
$.post('/admin/b2/comboBox/get_start_data', {}, function(data) {
    var data = eval('(' + data + ')');
    var array = new Array();
    $.each(data, function(key, val) {
        array.push({
            text : val.cityname,
            value : val.id,
            jb : val.simplename,
            qp : val.enname
        });
    });
    //console.log(array);
    var comboBox = new jQuery.comboBox({
        id : "#start_place",
        name : "start_go_city",// 隐藏的value ID字段
        query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
        selectedAfter : function(item, index) {// 选择后的事件

        },
        data : array
    });
});

});

function show_grade_dialog(obj){
  var line_and_grede = $(obj).attr('data-val').split("|");
   $("#upgrade_line_id").val(line_and_grede[0]);
  $("#before_level").val(line_and_grede[1]);
  $("#after_level").val(line_and_grede[1]);
  $("#myModal").show();
  $("#back_ground_modal").show();

}

function hidden_modal(){
      $("#before_level").val("");
  $("#after_level").val("");
    $("#myModal").hide();
  $("#back_ground_modal").hide();
}

function give_up(obj){
    var line_id = $(obj).attr('data-val');
    if(confirm('确定要放弃该条线路吗?')){
           $.post(
        "<?php echo base_url();?>admin/b2/line_apply/give_up",
         {'line_id':line_id },
         function(data){
            data = eval('('+data+')');
            if(data.code==200){
                alert(data.msg);
                location.reload();
            }else{
                alert(data.msg);
            }
         }
        );
    }

}
</script>
