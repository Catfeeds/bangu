<style type="text/css">
.col_st{ float: left;}
.col_lb{ margin-top: 8px;}
.form-group {margin-left: 2px; margin-top: 0;}
.page-body{ padding: 15px;}
.form-group{ margin-right:10px;}
.form-group input{ padding: 0; margin: 0;}
.form-group label{ margin:0; padding:0 5px; border: 1px solid #dedede; border-right: none; height: 26px;line-height: 26px;;}
.well.with-footer{ padding-bottom: 20px;}
.well.with-header{ padding:0px;box-shadow:none;}
.headerBox{ min-height: 50px; padding-top:15px;}
.tableBox{ padding: 15px 10px;padding-top:0;}
.well{ background: none;}
.shadow{ background: #fff;}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
input{ line-height:100%\9;}
.table>tbody>tr>td{ padding: 6px;}
.formBox { padding:0 10px 15px;}
</style>
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"> </i>
			<a href="<?php echo site_url('admin/b2/home/index')?>">主页</a>
		</li>
		<li class="active">投诉维权</li>
	</ul>
</div>
<div class="page-body" id="bodyMsg">

	<div class="well with-header with-footer ">
		<div class="shadow headerBox">
			<form class="form-inline formBox" method="post" action="<?php echo site_url('admin/b2/complain/index')?>" >
				<div class="form-group col_st">
				    <label class="col_st col_lb">产品名称:</label>
				    <input type="text"  name="productname" value="<?php echo $productname;?>" style=" padding:6px 10px; "/>
				</div>
				<div class="form-group col_st">
				    <label class="col_st col_lb">投诉人:</label>
				    <input type="text" name="nickname" value="<?php echo $nickname;?>" style=" padding:6px 10px;"/>
				</div>
				<div class="form-group col_st">
				    <label class="col_st col_lb">状态:</label>
				    <select id="month" name="status" class="ie8_select" >
				        <option value="">请选择</option>
				         <?php if ($status === '0'): ?>
				            <option value="0" selected="selected">待处理</option>
				             <option value="1" >已处理</option>
				        <?php elseif($status == 1 ): ?>
				            <option value="0" >待处理</option>
				            <option value="1" selected="selected">已处理</option>
				        <?php else:?>
				            <option value="0" >待处理</option>
				            <option value="1">已处理</option>
				        <?php endif?>
				    </select>
				</div>
				<button type="submit" class="btn btn-darkorange active" style="margin-left: 10px;"> 搜索</button>
			</form>
	    </div>
	    <div class="tableBox  shadow">
		<table class="table table-bordered table-hover">
		    <thead>
		        <tr>
		            <th style="text-align:center;width:7%"> 投诉人</th>
		            <th style="text-align:center;width:10%"> 投诉时间</th>
		        	<th style="text-align:center;width:25%">产品名称</th>
		            <th style="text-align:center;width:8%"> 专家</th>
		            <th style="text-align:center;width:7%">状态</th>
		            <th style="text-align:center;width:25%">联系电话</th>
		            <th style="text-align:center;width:35%"> 投诉内容 和处理意见</th>
		        </tr>
		    </thead>
		    <tbody>
		    <?php foreach ($complain_list as $item): ?>
		        <tr>
		        	<td style="text-align:center"><?php echo $item['complain_name'];?></td>
		            <td style="text-align:center"><?php echo $item['complain_time'];?></td>
		            <td style="text-align:center"><?php echo $item['proc_name'];?></td>
		            <td style="text-align:center"><?php echo $item['expert_name'];?></td>
		            <td style="text-align:center">
		                <?php if($item['status']==='0'):?>
		                    	待处理
		                <?php elseif($item['status']==1):?>
		                    	已处理
		                <?php else:?>
		                    	状态
		                <?php endif;?>
		            </td>
		            <td style="text-align:center"> <?php echo $item['mobile'];?></td>
		            <td style="text-align:left">
					               内容:<span style="color:#2dc3e8;"><?php echo $item['complain_content'];?></span> <br/>
					               <?php if(!empty($item['attachment'])):?>
					                附件: <span style="color:#9900ff;"><a href="<?php echo base_url().$item['attachment'];?>">附件下载</a></span></br>
					                <?php endif;?>
					                处理: <span style="color:#9900ff;"><?php echo $item['advice'];?></span></br>
		            </td>
		        </tr>
		      <?php endforeach;?>
		    </tbody>
		</table>
		<div class="pagination"><?php echo $this->page->create_page()?></div>
	</div>
</div>
