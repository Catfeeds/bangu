<style type="text/css">
	.col_st{ float: left;}
	.lineHeight{ height: 30px; line-height: 30px; margin: 0 10px; }
    .page-body{ padding: 20px;}
    .form-head{ background: #fff; padding-top: 10px;}
    .form-group{ margin-right: 20px; margin-top: 0;}
    .form-group label{ height: 26px; line-height: 26px; border: 1px solid #dedede; border-right:none; padding: 0 6px; margin: 0; color: #666; float: left}
    .form-group input{ height:26px; line-height: 26px; padding: 0; padding-left: 10px; float: left;}
    .boostCenter{ padding:15px 15px 0 15px}
    .tableBox{ padding:10px;}
	.form-group{ float:left}
	.ie8_input{ width:100px\9;}
	.ie8_select{ padding:5px 5px 6px 5px\9;}
	.ie8_pageBox{ width:50%\9; float:left\9}
	input{ line-height:100%\9;}
	.table>tbody>tr>td{ padding: 6px;}
	.formBox { padding-bottom:0;min-height:auto;padding-left:10px;}
</style>
<!-- Page Header -->
 <div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">学习机会</li>
    </ul>
</div>
<!-- Page Body -->
<div class="page-body" id="bodyMsg">
    <div class="form-head shadow">
        <form class="form-inline formBox" method="post"
            action="<?php echo site_url('admin/b2/opportunity/search')?>">

            <div class="form-group col_st">
                <label class="lineHeight">主题:</label> <input type="text" class="form-control"
                    name="title" value="<?php if(isset($title)){echo $title;} ?>"  style=" display:inline; width:250px;"/>
            </div>
            <div class="form-group col_st">
                <label class="lineHeight">状态:</label>
                <select name="status" class="ie8_select">
                <option value="-1" <?php if(isset($status)&& $status===''){ echo 'selected="selected"';} ?>>请选择</option>
                <option value="0" <?php if(isset($status)){if($status=='0'){ echo 'selected="selected"';}} ?>>未开始</option>
                <option value="1" <?php if(isset($status)){if($status==1){ echo 'selected="selected"';}} ?>>报名中</option>
                <option value="2" <?php if(isset($status)){if($status==2){ echo 'selected="selected"';}} ?>>已取消</option>
                <option value="3" <?php if(isset($status)){if($status==3){ echo 'selected="selected"';}} ?>>已完成</option>
                </select>
            </div>

            <button type="submit" class="btn btn-darkorange active"
                style="margin-left: 10px;">搜索</button>
        </form>
    </div>

		<div class="header bordered-sky"></div>
<div class="shadow tableBox">
		<table class="table table-bordered table-hover ">
			<thead>
				<tr>
					<th style="text-align:center" width="150">报名开始时间</th>
					<th style="text-align:center" width="150">报名截止时间</th>
					<th style="text-align:center" width="150">地点</th>
					<th style="text-align:center" width="150">主题</th>
					<th style="text-align:center" width="150">培训开始时间</th>
					<th style="text-align:center" width="100">培训时长</th>
					<th style="text-align:center" width="100">主办方</th>
					<th style="text-align:center" width="80">状态</th>
					<th style="text-align:center" width="100">报名人数</th>
					<th style="text-align:center" width="200">说明</th>
					<th style="text-align:center" width="150">我的报名状态</th>
					<th style="text-align:center" width="80">操作</th>
				</tr>
			</thead>
			<tbody>
				  <?php foreach ($op_apply_list as $item): ?>
                  <tr>
					<td style="text-align:center" width="80">
				                        <?php echo $item['begintime'];?>
				             </td>
			                    <td style="text-align:center" width="80">
			                          <?php echo $item['endtime']?>
			                    </td>
				        <td title="<?php echo $item['address']?>"  width="200" style="text-align:center" >

			                        	  <?php
				                             if(mb_strlen($item['address'],'utf-8')>15){
				                             	echo mb_substr($item['address'], 0, 15, 'utf-8').'...';
				                             }else{
				                             	echo $item['address'];
				                             }
			                              ?>
			                    </td>
					<td  width="200"style="text-align:center" title="<?php echo $item['title']?>">
						<?php
					                             if(mb_strlen($item['title'],'utf-8')>15){
					                             	echo mb_substr($item['title'], 0, 15, 'utf-8').'...';
					                             }else{
					                             	echo $item['title'];
					                             }
				                              ?>
					</td>
					<td width="80" style="text-align:center" >
						<?php echo $item['starttime']?>
					</td>
					<td width="80" style="text-align:center" >
						<?php echo $item['spend']?>分钟
					</td>
					<td width="100" style="text-align:center">
                          <?php echo $item['sponsor']?>
                    </td>
					<td width="60" style="text-align:center">
                            <?php 	if($item['status']==0 && date("Y-m-d H:is",time())<$item['endtime']){
                            			echo '未开始';
                            		}elseif($item['status']==1){
	                            		  if(date("Y-m-d H:is",time())>=$item['endtime']){
	                            		  	echo '已过期';
	                            		  }elseif ($item['begintime']>=date("Y-m-d H:is",time())){
	                            		  	echo '未开始';
	                            		  }else{
	                            		  	 echo '报名中';
	                            		  }
                            		 }elseif($item['status']==2){
                            		 	echo '已取消';
                            		 }elseif($item['status']==3){
                            		 	echo '已完成';
                            		 } ?>
                    </td>
					<td width="80" style="text-align:center">
                             <?php echo $item['people']?>
                    </td>
                    <td width="200" style="text-align:center" title="<?php echo $item['description']?>">

                             <?php
	                             if(mb_strlen($item['description'],'utf-8')>15){
	                             	echo mb_substr($item['description'], 0, 15, 'utf-8').'...';
	                             }else{
	                             	echo $item['description'];
	                             }
                              ?>
                    </td>
                    <td width="80" style="text-align:center">
                             <?php if($item['mystatus']==null){ echo '未报名';}elseif($item['mystatus']==-1){echo '取消中';}elseif($item['mystatus']==0){echo '已报名';}?>
                    </td>
					<td width="80" style="text-align:center">
                              <?php if($item['mystatus']==null && $item['status']==1){ if($item['endtime']>=date("Y-m-d H:is",time()) && date("Y-m-d H:is",time())>=$item['begintime']){echo '<a href="#" data="'.$item['id'].'"  time="'.$item['modtime'].'" name="apply">报名</a>';}}elseif($item['mystatus']==0 && $item['mystatus']!=null){ echo '<a href="#" data="'.$item['opid'].'" name="cancel" data-val="'.$item['id'].'" >取消报名</a>'; }?>
                    </td>
				</tr>
                            <?php endforeach;?>

            </tbody>
		</table>
        <div class="boostCenter">
            <div class="pagination"><?php echo $this->page->create_page()?></div>
        </div>
    </div>
</div>
<div id="myModal_txt" style="display: none;">
	<form class="form-horizontal" role="form" id="applyMoney" method="post"
		action="<?php echo site_url('admin/a/supplier/add_supplier')?>" enctype="multipart/form-data">
		<div class="form-group">
			<label for="inputEmail3"
				class="col-sm-2 control-label no-padding-right">发布时间：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name ='company_name' value="<?php echo date('Y-m-d H:i', time());?>">

			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3"
				class="col-sm-2 control-label no-padding-right">发布人：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name = 'login_name' value="<?php 	$this->load->library('session');
		echo $this->session->userdata('login_name'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">培训时间：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control"  name="phone_num" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">培训人：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="idcard" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">报名时间</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="corp_idcard" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">截止报名时间</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="corp_idcard" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">状  态：</label>
			<div class="col-sm-10">
				<select>
					<option>未开始</option>
					<option>报名中</option>
					<option>进行中</option>
					<option>已完成</option>
					<option>已取消</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">主办方：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="corp_idcard" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">说  明：</label>
			<div class="col-sm-10">
				<textarea rows="" cols="" style="width:470px;height: 100px;"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3"
				class="col-sm-2 control-label no-padding-right">附  件:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="province">
			</div>
		</div>
		<div class="form-group">
			<input type="button" class="btn btn-palegreen bootbox-close-button " aria-hidden="true"  type="button" value="取消" style="float: right; margin-right: 2%; " />
			<input type='submit' class="btn btn-palegreen" value='提交' style="float: right; margin-right: 2%;" />
		</div>
	</form>
</div>
<script type="text/javascript">
	jQuery('.table-hover').on("click", 'a[name="show"]',function(){
		var data=jQuery(this).attr('data');
		var val=jQuery(this).attr('val');

		  bootbox.dialog({
              message: $("#myModal_txt").html(),
              title: "主题："+val,
              className: "modal-darkorange"
          });
	});
	jQuery('.table-hover').on("click", 'a[name="apply"]',function(){
		var data=jQuery(this).attr('data');
		var time=jQuery(this).attr('time');

		var status=0;
		$.post("<?php echo base_url()?>admin/b2/opportunity/ajax_insert", { data:data,time:time} , function(result) {

			if(result){
				alert('报名成功');
				//location.reload();
			}else{
				//alert('报名失败');
			}
		});
	});
	jQuery('.table-hover').on("click", 'a[name="cancel"]',function(){
		var data=jQuery(this).attr('data');
		var opid=jQuery(this).attr('data-val');
		var status=-1;
		$.post("<?php echo base_url()?>admin/b2/opportunity/update_data", { data:data,status:status,opid:opid} , function(result) {
			if(result){
				alert('取消成功');
				location.reload();
			}else{
				alert('取消失败');
			}
		});
	});

    </script>
