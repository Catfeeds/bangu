<style>
.page-body{ padding: 20px;}
.orders-container{ background: none;}
.center{ text-align: center; }
.lineHeight{ height: 30px; line-height: 30px; margin: 0 10px; }
.orders-container{-webkit-box-shadow:none;box-shadow:none;}
.orders-container .orders-header{ border:none; }
.form-head{ min-height:50px; padding:10px 0 15px;}
.formBox { padding: 0 10px;min-height:auto;}
.form-group{ margin-top: 0;}
.boostCenter{ padding:15px 15px 0 15px}
.tableBox{ padding:0 10px 15px;}
.orders-container .orders-header{ background-color: #fff;}
.form-group input{ height:26px; line-height: 26px; padding: 0;  padding-left: 10px; float: left;}
.form-group label{ height: 26px; line-height: 26px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666;margin:0;}
.table>tbody>tr>td{ padding: 6px;}
</style>

<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">管家升级</li>
    </ul>
</div>
    <div class="page-body">
        <div class="orders-container">
            <div class="orders-header shadow" style="height: 130px;">
                <img src="<?php echo $get_expert_info['small_photo']?>" alt="图片" style="height: 100px;width:100px;border-radius:50px;float: left; margin:0px 40px;">
                <div style="float: left;">
                    <h1 style="display: inline; margin-right:15px"><?php echo $get_expert_info['realname']?></h1>欢迎你<br>
                    <div style="margin-top:8px; ">专家等级<span style=" font-weight:bold;color:#428bca">
                    <?php if($get_expert_info['grade']==1):?>
	                      管家
	                <?php elseif($get_expert_info['grade']==2):?>
	                      初级专家
	                <?php elseif($get_expert_info['grade']==3):?>
	                      中级专家
	                <?php elseif($get_expert_info['grade']==4):?>
	                      高级专家
	                <?php endif;?>
                    </span>
                    </div>
                </div>
              	<!--<button type="submit" class="btn btn-palegreen" style="margin-left: 100px;">升级</button>  -->
            </div>

            <div>
                <div class="form-head shadow" style="margin-top:3px;">
                    <form class="form-inline formBox clear" method="get" action="<?php echo site_url('admin/b2/upgrade/search')?>" >
                        <div class="form-group " >
                            <label class="fl lineHeight">申请记录:</label>
                                <select name="apply_time" id="apply_time" class="ie8_select" v='<?php echo  $apply_time?>'>
                                        <option value="0" >请选择</option>
                                        <option  value="1">一个月</option>
                                        <option   value="2" >二个月</option>
                                        <option  value="3" >三个月</option>
                                </select>
                             </div>
                                <div class="form-group " >
	                            <label class="fl lineHeight">申请级别:</label>
	                            <select id="apply_grade" name="apply_grade"  v='<?php echo  $apply_grade?>'  class="fl ie8_select">
                                <option value=""  >请选择</option>
                                <option value="1"  >管家</option>
                                <option value="2"  >初级专家</option>
                                <option value="3"  >中级专家</option>
                                <option value="4"  >高级专家</option>
                            </select>
                             </div>

                             <div class="form-group " >
                            <label class="fl lineHeight">申请状态:</label>
                            <select id="apply_status" name="apply_status" v='<?php echo  $apply_status?>'  class="fl">
                                <option value=""  >请选择</option>
                                <option value="1"  >审核中</option>
                                <option value="2"  >审核通过</option>
                                <option value="-2"  >审核拒绝</option>
                            </select>
                             </div>
                              <script type="text/javascript">
                                    var apply_time = $("#apply_time");
                                    var apply_grade = $("#apply_grade");
                                    var apply_status = $("#apply_status");
                                    for(var i=0 ;apply_time && i <apply_time.length ; i++ ){
                                        apply_time[i].value=apply_time[i].getAttribute('v');
                                    }
                                     for(var i=0 ;apply_grade && i <apply_grade.length ; i++ ){
                                      apply_grade[i].value=apply_grade[i].getAttribute('v');
                                    }
                                     for(var i=0 ;apply_status && i <apply_status.length ; i++ ){
                                      apply_status[i].value=apply_status[i].getAttribute('v');
                                    }
                            </script>
                        <button type="submit" class="btn btn-darkorange active " style="margin-left: 10px; margin-top:0px">
                            搜索
                        </button>
                    </form>
                </div>
           </div>

            <div class="shadow tableBox">
                <table class="table table-striped table-hover table-bordered dataTable no-footer" id="editabledatatable" aria-describedby="editabledatatable_info">
                    <thead>
                        <tr role="row">
                            <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px; text-align: center;">
                                申请时间
                            </th>
                            <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px;text-align: center;">
                                专家
                            </th>
                            <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px;text-align: center;">
                                申请级别
                            </th>
                            <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 150px;text-align: center;">
                              线路
                            </th>
                           <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align: center;">
                               状态
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($upgrade_list as $item):?>
                        <tr>
                            <td class="center"><?php echo $item['addtime']?></td>
                            <td class=" center"><?php echo $item['realname']?></td>
                            <td class=" center"><?php if($item['grade_after']==1){echo '管家';}elseif($item['grade_after']==2){echo '初级专家' ;}elseif($item['grade_after']==3){ echo '中级专家';}elseif($item['grade_after']==4){ echo '高级专家';}?></td>
                            <td class="center"><?php echo $item['linename'] ?></td>
                            <td class=" center"><?php if($item['status']==1){echo "审核中";}elseif($item['status']==2){echo "审核通过";}elseif($item['status']==-2){echo "审核拒绝";}?></td>


                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <div class="boostCenter">
                    <div class="pagination"><?php echo $this->page->create_page()?></div>
                </div>
            </div>
        </div>
    </div>
<script>
function gradeChange(){
	   var time=$('#pid option:selected').val();
               window.location.href = '/admin/b2/upgrade/search?&time='+time;
}
</script>
