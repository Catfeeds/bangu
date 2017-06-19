<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
	<title>注册</title>
	<?php $this->load->view('admin/a/common/head');?>
</head>
<!-- /Head -->
<!-- Body -->
<body>	
<form method="post"
	action="<?php echo site_url('admin/a/register/do_register')?>">
<div class="register-container animated fadeInDown">
        <div class="registerbox bg-white">
            <div class="registerbox-title">注册</div>

            <div class="registerbox-caption ">请填写您的信息</div>
            <div class="registerbox-textbox">
                <input type="text" class="form-control" placeholder="用户名" name="username" />
            </div>
            <div class="registerbox-textbox">
                <input type="text" class="form-control" placeholder="邮箱" name="email"/>
            </div>
            <div class="registerbox-textbox">
                <input type="text" class="form-control" placeholder="手机号/邮箱" name="mobile"/>
            </div>
            <div class="registerbox-textbox">
                <input type="password" class="form-control" placeholder="输入用户密码" name="password"/>
            </div>
            <div class="registerbox-textbox">
                <input type="password" class="form-control" placeholder="请再输入一次密码" name="password1"/>
            </div>
            <hr class="wide" />
            <div class="registerbox-textbox no-padding-bottom">
               <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-primary" checked="checked">
                        <span class="text darkgray">我同意该 <a class="themeprimary">协议</a>内容</span>
                    </label>
                </div>
            </div>
            <div class="registerbox-submit">
                <input type="submit" class="btn btn-primary pull-right" value="提交">
            </div>
        </div>
        <div class="logobox">
        </div>
    </div>
    </form>
</body>
<!--  /Body -->
</html>