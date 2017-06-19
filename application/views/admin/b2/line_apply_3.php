<style type="text/css">
   .form-control{ display: inline; width: 200px; }
   .form-group { float: left;}
   .nav-tabs{ background: none;box-shadow:none;-webkit-box-shadow:none; }
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
                    <!-- <div class="widget-body"> -->
                <div class="flip-scroll">
                    <div class="tabbable">
                        <ul id="myTab5" class="nav nav-tabs">
                        <li class="active"><a href="<?php echo base_url(); ?>admin/b2/line_apply/new_line" >最新线路</a></li>
                            <li class="tab-blue"><a href="<?php echo base_url(); ?>admin/b2/line_apply/index" >未申请</a></li>
                            <li class="tab-red"><a href="<?php echo base_url(); ?>admin/b2/line_apply/applyed_index" >已申请</a></li>
                        </ul>
                         <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <label>
                                    <form class="form-inline formBox" method="post" action="<?php echo site_url('admin/b2/line_apply/new_line')?>" >

                                           <div class="form-group" >
                                                <label style=" text-align: right;">出发地:</label>
                                                <input type="text" class="" id="start_place"  name="start_place" value="<?php echo $startplace_check;?>" style=" display:inline; width:200px; height:35px;line-height:35px;" />
                                        </div>
                                        <div class="form-group" >
                                                <label style=" text-align: right;">目的地:</label>
                                                <input type="text" class="" id="destinations"  name="destination" value="<?php echo $destnation_check;?>" style=" display:inline; width:200px; height:35px;line-height:35px;" />
                                       			 <input type="hidden" name="overcity" id="overcity">
                                        </div>
                                        <div class="form-group">
                                            <label style=" text-align: right;">线路名称:</label>
                                            <input type="text" class="" name="linename" value="<?php echo $linename_check;?>"style=" display:inline; width:200px;height:35px;line-height:35px;"/>
                                        </div>
                                        <div class="form-group">
                                             <label>供应商:</label>
                                             <!--<input type="text" class="form-control" name="supplier_name" value=""/>-->
                                            <select name="supplier_id">
                                            <option value="">请选择:</option>
                                            <?php foreach ($suppliers as $item):?>
                                                 <?php if ($item['id'] == $supplier_check): ?>
                                                     <option value="<?php echo $item['id'];?>" selected='selected'><?php echo $item['realname'];?></option>
                                                <?php else: ?>
                                                        <option value="<?php echo $item['id'];?>"><?php echo $item['realname'];?></option>
                                                 <?php endif?>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-darkorange active" style="margin-left: 50px; float:
                                        left;">
                                            搜索
                                        </button>
                                    </form>
                        </label>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">
                                                线路编号
                                            </th>
                                            <th style="text-align:center">
                                                线路标题
                                            </th>
                                            <th style="text-align:center">
                                                出发地
                                            </th>
                                            <th style="text-align:center">
                                                管家佣金
                                            </th>

                                            <th style="text-align:center">
                                                供应商名称
                                            </th>
                                            <!-- <th style="text-align:center">操作</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($line_apply_list as $item): ?>
                                        <tr>
                                            <td style="text-align:center">
                                                <?php echo $item['line_sn'];?>
                                            </td>
                                            <td style="text-align:left" title="<?php echo $item['line_title'];?>">
                                                <a target="_blank" href="<?php echo base_url('admin/b2/line_apply/line_detial_apply') ;?>?id=<?php echo $item['line_id'];?>"><?php echo mb_substr($item['line_title'],0,15,'utf-8');?></a>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['start_city'];?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['agent_rate_int'];?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['company_name'];?>
                                            </td>
                                            <!-- <td style="text-align:center"><a  style="cursor:pointer;" data-val="<?php echo $item['line_id'];?>|<?php echo $item['sell_direction'];?>" onclick="show_apply_dialog(this)">申请</a></td> -->
                                        </tr>
                                      <?php endforeach;?>

                                    </tbody>
                                </table>
                            <div class="pagination"><?php echo $this->page->create_page()?></div>
                            </div>
                        </div>
                    </div> <!--tabble end-->
                </div>
            <!-- </div> --><!--end wedge body-->
        </div>
</div>

<div style="display:none;" class="bootbox modal fade in" id="line_sell_direction_modal">
  <div class="modal-dialog">
    <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
    <h4 class="modal-title">申请线路</h4>
  </div>
<div class="modal-body">
<div class="bootbox-body">
  <div id="line_sell_direction">

  </div>
  <form  action="#" id="apply_line_form">
        <input type="hidden" id="apply_line_id" name="apply_line_id" value=""/>
        <input type="submit" value="申请"/>
  </form>
  </div>
</div>
 </div>
</div>
</div>
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>



<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<!--目的的模糊查询  -->
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>

<script type="text/javascript">

$(document).ready(function(){
/*     $.post('/admin/b2/comboBox/get_destinations_data', {}, function(data) {
    var data = eval('(' + data + ')');
    var array = new Array();
    $.each(data, function(key, val) {
        array.push({
            text : val.kindname,
            value : val.id,
            jb : val.simplename,
            qp : val.enname
        });
    });
    //console.log(array);
    var comboBox = new jQuery.comboBox({
        id : "#destinations",
        name : "overcity",// 隐藏的value ID字段
        query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
        selectedAfter : function(item, index) {// 选择后的事件

        },
        data : array
    });
}); */

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

function show_apply_dialog(obj){
     var line_info = $(obj).attr('data-val').split('|');
    var sell_direction_doc = '<?php echo base_url();?>'+line_info[1];

    $("#line_sell_direction").html("<a href='"+sell_direction_doc+"'>下载产品说明</a>");
     $("#apply_line_id").val(line_info[0]);
     $("#line_sell_direction_modal").show();
    $("#back_ground_modal").show();
      /* $.post(
                    "<?php echo base_url();?>admin/b2/line_apply/apply_line_operator",
                    {'line_id':line_id },
                    function (data) {
                         bootbox.dialog({
                                    message: '申请线路成功',
                                    title: "申请路线",
                                    buttons: {
                            success: {
                                label: "申请",
                                className: "btn-success",
                                 callback: function() {
                                     location.reload();
                                 }
                             },
                        }
                });

    }
);*/
}

function hidden_modal(){
    $("#line_sell_direction_modal").hide();
    $("#back_ground_modal").hide();
    $("#line_sell_direction").html('');
    $("#apply_line_id").val('');
}


$('#apply_line_form').submit(function(){
      $.post(
        "<?php echo base_url('admin/b2/line_apply/apply_line_operator');?>",
        $('#apply_line_form').serialize(),
        function(data) {
              data = eval('('+data+')');
              if (data.status == 200) {
                alert(data.msg);
                location.reload();
              } else {
                alert(data.msg);
              }
        }
      );
      return false;
    });
</script>