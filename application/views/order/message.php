<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $web['title']?></title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>static/css/message.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>static/css/common.css">
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<body>
<div>
	<!-- 头部 -->
	<?php $this->load->view('common/header'); ?>

           <form action="" id="message_form" method="post">
            <div class="os1000">
                <div id="container">
                    <div class="conn_sm">
                        <dd><img src="../static/img/details/u0.png" alt=""><span class="sm-xixin">游客信息</span>
                        </dd>
                        <dd class="sm-p">为了保障您的合法权益，请准确、完整的填写游客证件信息，出游人信息不完整会延误你的正常出游；儿童游客如无相关证件，证件类型请选择“其他 ，并填写出生日期。因填写信息不完整、不准确造成的保险拒赔等问题，我司不承担相应责任。</dd>
                        <?php 
                        	foreach($traver as $key =>$val):
                        		$a = $key + 1;	
                        ?>
                        <dd class="sm-youke">第<?php echo $a?>位游客<span onclick="empty_user(<?php echo $a?>)">[清空]</span>
                        </dd>
                        <div class="tab user_info_<?php echo $a ?>">
                            <ul>
                                <li><span>*中文姓名： </span>
                                    <input type="text" value="<?php echo $val['name']?>" name="username<?php echo $a ;?>"  />点击可选择常用游客
                                   </li>
                                <li><span>英文姓名： </span>
                                    <input type="text" name="eusername<?php echo $a ;?>" /> 填写说明
                                </li>
                                 <li><span>国籍： </span>
                                    <select name="country<?php echo $a ;?>">
                                    	<?php 
                                    		foreach($country as $cv) {
                                    			echo "<option value='{$cv['name']}'>{$cv['name']}</option>";
                                    		}
                                    	?>
                                    </select>
                                </li>
                                <li><span>证件类型： </span>
                                    <select name="type<?php echo $a;?>">
                                    	<option value="0">请选择</option>
                                    	<?php 
                                    		foreach($dict_data as $k =>$v) {
												if ($v['dict_id'] == $val ['certificate_type']) {
													$dict_selected = "selected='selected'";
												} else {
													$dict_selected = null;
												}
                                    			echo "<option value='{$v['dict_id']}' {$dict_selected}>{$v['description']}</option>";
                                    		}
                                    	?>
                                    </select>
                                </li>
                                <li><span>证件号码： </span>
                                    <input type="text" value="<?php echo $val ['certificate_no']?>" name="number<?php echo $a;?>"  />可参考护照样本填写</li>
                                <li><span>证件有效期 </span>
                                    <select name="c_year<?php echo $a;?>" >
                                        <option value="0">请选择</option>
                                         <?php 
                                        	foreach($cyear as $k =>$v) {
                                        		echo "<option value='{$v}'>$v</option>";
                                        	}
                                        ?>
                                    </select>年
                                    <label for="select2"></label>
                                    <select name="c_month<?php echo $a;?>" key="<?php echo $a?>" class="card_month" >
                                        <option value="0">请选择</option>
                                        <?php 
                                        	foreach($month as $val) {
                                        		echo "<option value='{$val}'>$val</option>";
                                        	}
                                        ?>
                                    </select> 月
                                    <label for="select3"></label>
                                    <select name="c_day<?php echo $a;?>" >
                                        <option value="0">请选择</option>
                                    </select> 日点击可选择常用游客</li>
                                <li><span>签发地： </span>
                                	<input type="text"  name="sign_place<?php echo $a?>"  />
                                <li><span>性别： </span>
                                    <select name="sex<?php echo $a;?>" >
										<option value="0">女</option>
                                        <option value="1">男</option>
                                    </select>点击可选择常用游客</li>
                                <li><span>出生日期： </span>
                                    <select name="year<?php echo $a;?>">
                                        <option value="0">请选择</option>
                                        <?php 
                                        	foreach($year as $val) {
                                        		echo "<option value='{$val}'>$val</option>";
                                        	}
                                        ?>
                                    </select> 年
                                    <label for="select2"></label>
                                    <select name="month<?php echo $a;?>" class="s_month"  key="<?php echo $a?>">
                                        <option value="0">请选择</option>
                                        <?php 
                                        	foreach($month as $val) {
                                        		echo "<option value='{$val}'>$val</option>";
                                        	}
                                        ?>
                                    </select>月
                                    <label for="select3"></label>
                                    <select name="day<?php echo $a;?>" id="select3">
                                        <option value="0">请选择</option>
                                    </select> 日>点击可选择常用游客</li>
                                <li><span>手机： </span>
                                    <input type="text" name="telephone<?php echo $a;?>"  />点击可选择常用游客</li>
                            </ul>
                        </div>
                        <?php endforeach;?>
                        <div class="order_btn">
                            <input class="yellow_btn" type="submit" value="保存 "> <span class="miss">
                            <a href="<?php echo site_url('order_from/order/show_order_detail?order_id='.$id)?>">查看订单</a></span>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    <?php $this->load->view('common/footer'); ?>
    </body>
    </html>
    <script>
		$('#message_form').submit(function(){
			$.post(
					"<?php echo site_url('order_from/confirm_order/edit_message');?>",
					$('#message_form').serialize(),
					function(data) {
						data = eval('('+data+')');
						if (data.code == 2000) {
							alert("更改成功");
							location.href="<?php echo base_url();?>order_from/order/show_order_detail?order_id="+data.msg;
						} else {
							alert(data.msg);
						}
					}
				);
			return false;
		});
    
		$('.card_month').change(function(){
			var key = $(this).attr('key');
			
			var month = $('select[name="c_month'+key+'"] :selected').val();
			var year = $('select[name="c_year'+key+'"] :selected').val();
			var str = '<option value="0">请选择</option>';
			var a = 1;
			if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
				for (a ;a <32 ;a++) {
					str += '<option value="'+a+'">'+a+'</option>';
				}
				$('select[name="c_day'+key+'"]').html('').html(str);	
			}
			if (month == 4 || month == 6 || month == 9 || month == 11) {
				for (a ;a <31 ;a++) {
					str += '<option value="'+a+'">'+a+'</option>';
				}
				$('select[name="c_day'+key+'"]').html('').html(str);	
			}
			if (month == 2) {
				if (year%4 == 0 && year%100 != 0 || year%400 ==0) { //闰年
					for (a ;a <30 ;a++) {
						str += '<option value="'+a+'">'+a+'</option>';
					}
					$('select[name="c_day'+key+'"]').html('').html(str);
				} else {
					for (a ;a <29 ;a++) {
						str += '<option value="'+a+'">'+a+'</option>';
					}
					$('select[name="c_day'+key+'"]').html('').html(str);
				}
			}
 		});
		$('.s_month').change(function(){
			var key = $(this).attr('key');
			var month = $('select[name="month'+key+'"] :selected').val();
			var year = $('select[name="year'+key+'"] :selected').val();
			var str = '<option value="0">请选择</option>';
			var a = 1;
			if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
				for (a ;a <32 ;a++) {
					str += '<option value="'+a+'">'+a+'</option>';
				}
				$('select[name="day'+key+'"]').html('').html(str);	
			}
			if (month == 4 || month == 6 || month == 9 || month == 11) {
				for (a ;a <31 ;a++) {
					str += '<option value="'+a+'">'+a+'</option>';
				}
				$('select[name="day'+key+'"]').html('').html(str);	
			}
			if (month == 2) {
				if (year%4 == 0 && year%100 != 0 || year%400 ==0) { //闰年
					for (a ;a <30 ;a++) {
						str += '<option value="'+a+'">'+a+'</option>';
					}
					$('select[name="day'+key+'"]').html('').html(str);
				} else {
					for (a ;a <29 ;a++) {
						str += '<option value="'+a+'">'+a+'</option>';
					}
					$('select[name="day'+key+'"]').html('').html(str);
				}
			}
		});
		//清空信息
		function empty_user(key) {
			$('.user_info_'+key).find('input').val('');
			$('.user_info_'+key).find('select').val(0);
		}
    </script>
