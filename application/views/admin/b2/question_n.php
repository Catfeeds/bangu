<style type="text/css">
.nav-tabs{ background: none;box-shadow:none;-webkit-box-shadow:none; }
.page-body .nav-tabs li{ padding: 0;background: #eaedf1;}
.page-body{ padding: 20px;}
.page-body .nav-tabs{ background: #fff; border-bottom: 1px solid #ddd;}
.form-group input{ padding: 0; margin: 0; height:26px; line-height: 26px;}
.form-group label{ margin:0; padding: 6px 5px; border: 1px solid #dedede; border-right: none}
.table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px}
.form-group{ margin-top: 0;}
.text_sketch{ padding: 0 5px;color: #09c;cursor:pointer;}
.btn-palegreen,.btn-palegreen:hover{ margin-left: 320px !important; background: #056DAB !important; width: 60px !important;  height: 20px !important; line-height: 20px !important;}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
input{ line-height:100%\9;}
.form-group1 input{ float:left}
.form-control{ width: auto}
.table>tbody>tr>td{ padding: 6px;}
.tabbable { padding: 0 10px;background:#fff;}
.tab-content { padding:10px 0 !important;}
</style>
   <div class="page-breadcrumbs">
    <ul class="breadcrumb">
       <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">客人问答</li>
    </ul>
</div>

	<div class="page-body" id="bodyMsg">
		<div class="widget">
			<!--  <div class="widget-body"> -->
			<div class="flip-scroll">
				<div class="tabbable">

					<ul id="myTab5" class="nav nav-tabs">

						<li class="tab-red"  >
						<a href="/admin/b2/question/index">已回复</a>
						</li>
						<li class="active">
						<a href="">未回复</a>
						</li>
					</ul>
					<div class="tab-content shadow">
						<div class="tab-pane active" id="tab1">
                            <div style=" width:100%; margin-bottom:10px;">
							<label>
								<form class="form-inline" method="post" action="<?php echo site_url('admin/b2/question/index')?>" >

								 <div class="form-group">
       							 <input type="text" class="form-control" placeholder="模糊匹配" name="linename" value="<?php echo $linename;?>"style=" padding:0 10px;"/>
   								 </div>

    							<button type="submit" class="btn btn-darkorange active" style="margin-left: -10px;">  线路搜索</button>

								</form>
							</label>
                            </div>
							<table class="table table-bordered table-hover">
								<thead>
								         <tr>
                                            <th style="text-align:center"> 会员 </th>
                                            <th style="text-align:center"> 线路 </th>
                                            <th style="text-align:center"> 最新时间 </th>
                                            <th style="text-align:center"> 咨询内容</th>
                                            <th style="text-align:center"> 邮箱</th>
                                           <th style="text-align:center"> 操作状态</th>
                                        </tr>
								</thead>
								<tbody>
               						 <?php foreach ($question_list as $item): ?>
                                        <tr>
                                        	<td style="text-align:center">
                                               <?php echo $item['truename'];?>
                                            </td>
                                            <td style="text-align:center" title="<?php echo $item['linename']?>">
                                                <?php echo empty($item['linename']) ? '客人提问' : str_cut($item['linename'] ,50);?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['addtime'];?>
                                            </td>
                                            <td  style="text-align:center" title="<?php echo $item['content']?>">
                                                <?php echo str_cut($item['content'] ,60);?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['email'];?>
                                            </td>
                                             <td style="text-align:center">
                                                <span class="text_sketch"  data-val="<?php echo $item['id'].'|'.$item['content'].'|'.$item['email'];?>" onclick="show_reply_dialog(this)">回复</span>
                                            </td>

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
		</div>
</div>



<div style="display:none;" class="bootbox modal fade in" id="reply_question_modal">
    <div class="modal-dialog">
        <div class="modal-content" style="width:760px;height:240px;">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">问题回复</h4>
            </div>
            <div class="modal-body" >
                    <form class="form-horizontal" role="form" id="reply_question_form" method="post" action="">
            <div class="form-group" style="float:none;">
            <label for="inputPassword3" class="col-sm-1 control-label no-padding-right" style=" border:none; text-align: right;">回复</label>
            <div class="col-sm-10">
                <textarea name="reply_content" style="resize:none;width:100%;height:100%"></textarea>
                <input type="hidden" name="question_id" id="question_id" value=""/>
                <input type="hidden" name="question_content" id="question_content" value=""/>
                <input type="hidden" name="question_email" id="question_email" value=""/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交">
        </div>
    </form>

            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>


<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
function show_reply_dialog(obj){
     var que_info = $(obj).attr('data-val').split('|');
     $("#question_id").val(que_info[0]);
     $("#question_content").val(que_info[1]);
     $("#question_email").val(que_info[2]);
        $("#reply_question_modal").show();
    $("#back_ground_modal").show();
}

//隐藏弹框
function hidden_modal(){
    $("#reply_question_modal").hide();
    $("#back_ground_modal").hide();
    $("#question_id").val('');
     $("#question_content").val('');
     $("#question_email").val('');
}

$('#reply_question_form').submit(function(){
            $.post(
                "<?php echo base_url();?>admin/b2/question/reply",
                $('#reply_question_form').serialize(),
                function(data) {
                    data = eval('('+data+')');
                    //console.log(data);
                    if (data.code == 200) {
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
