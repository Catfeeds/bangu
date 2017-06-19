
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="#">首页</a></li>
            <li class="active">供应商后台</li>
		<li class="active">产品管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<!-- Page Header -->
<div class="page-header position-relative">
	<div class="header-title">
		<h1>基本资料</h1>
	</div>
	<div class="header-buttons">
		<a class="sidebar-toggler" href="#"> <i class="fa fa-arrows-h"></i>
		</a> <a class="refresh" id="refresh-toggler" href=""> <i
			class="glyphicon glyphicon-refresh"></i>
		</a> <a class="fullscreen" id="fullscreen-toggler" href="#"> <i
			class="glyphicon glyphicon-fullscreen"></i>
		</a>
	</div>
</div>
<!-- /Page Header -->
                                            <div class="widget flat radius-bordered">
                                                <div class="widget-body">
                                                    <div id="registration-form">
                                                    
                                         <?php echo form_open_multipart('/b1/user/insert');?>

                                                            <div class="form-title">
																&nbsp;
                                                            </div>
                                                            <div class="form-group">
                                                             <label for="inputName" class="col-sm-2 control-label no-padding-right">姓名</label>
                                                                <span class="input-icon icon-right">
                                                                    <input type="text" placeholder="供应商名称" id="userameInput" class="form-control user_name_b1" name="username" value="<?php echo $login_name;?>"/>
                                                                </span>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label for="inputPhone" class="col-sm-2 control-label no-padding-right">手机号</label>
                                                                        <span class="input-icon icon-right">
                                                                            <input type="text" placeholder="手机" class="form-control user_name_b1" name="mobile" value="<?php echo $mobile;?>" />
                                                                        </span>
                                                                    </div>
                                                                    
                                                            <div class="form-group">
                                                            <label for="inputIdCard" class="col-sm-2 control-label no-padding-right">身份证号码</label>
                                                                <span class="input-icon icon-right">
                                                                    <input type="text" placeholder="身份证号码"  class="form-control user_name_b1" name="name_id" value="<?php echo $idcard;?>"/>
                                                                </span>
                                                            </div>
                                                                   
                                                           
                                                                    <div class="form-group">
                                                                     <label for="inputIdCardImg" class="col-sm-2 control-label no-padding-right">身份证扫描件</label>
                                                                        <span class="input-icon icon-right">
                                                                        <img src="<?php echo $idcardpic;?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" style="width:350px;height:200px;"/>
                                                                           <label for="inputImg" class="col-sm-2 control-label no-padding-right"></label> <input type="file" placeholder="身份证扫描" data-date-format="dd-mm-yyyy"  />
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                        
                                                                <div class="form-group">
                                                                   <label for="inputIdCardImg" class="col-sm-2 control-label no-padding-right">所属城市</label>
                                                                      <span class="input-icon icon-right">
                                                                    <input type="text" placeholder="城市"  class="form-control user_name_b1" name="name_id" value="<?php echo $city;?>"/>
                                                                </span><i style="display: none;" class="form-control-feedback" data-bv-field="country"></i><i style="display: none;" data-bv-field="country" class="form-control-feedback"></i>
                                                           
                                                                </div>
                                                                   
                                                            <label for="inputImg" class="col-sm-2 control-label no-padding-right"></label><label for="inputImg" class="col-sm-2 control-label no-padding-right"></label><button class="btn btn-blue" type="submit" >更新</button>
                                                        </form>
                                                    </div>
                                                </div>