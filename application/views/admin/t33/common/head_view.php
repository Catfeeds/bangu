<style type="text/css"> 
.HcloseBtn{ float: right; width: 200px; height: 40px;}
.HcloseBtn img{ width: 36px; height: 36px; line-height: 36px; margin-top: 5px;}
.Hmatter{float: right;border-left:1px solid #0087b4; cursor: pointer;height:40px;line-height:40px;}
.Hmatter i{ float: left; margin-top: 5px; margin-left: 10px; display: inline-block; width: 20px; height: 28px; background: url(../../../../assets/img/lingdang.png) no-repeat; background-position: 0px 0px; background-size: cover;}
.Hmatter span{ float: left; background: #f90; width: 30px; height: 20px; color: #fff; margin:10px 14px; margin-left: 8px; text-align: center; line-height: 19px; border-radius: 4px;}
.header_right{ padding: 0;}
.userOname{ cursor: pointer; height: 40px; line-height: 40px; font-size: 14px; text-align: center; border-left:1px solid #0087b4; border-right:1px solid #0087b4; color: #fff;}
.userMune{ background: #fff; display: none;}
.userMune li{ height: 40px; line-height: 40px; text-align: center; border: 1px solid #eaedf1; border-top:none;}
.userMune li a{ color: #666; font-size: 13px; display: block;}
.userMune li:hover{background: #eaedf1;}
.userOn{ background: #0087b4; box-shadow: 0 1px 3px rgba(0,0,0,0.1);}
.HmatterHidden{ display: none; width: 400px; position: absolute; top: 40px; right: 0; height: auto; background: #fff; border: 1px solid #eaedf1;}
.HmatTitle{ height: 40px; line-height: 40px; background: #eaedf1;border: 1px solid #eaedf1; box-shadow: 0 1px 2px rgba(0,0,0,0.175); padding-left: 10px; font-size: 13px; color: #666;}
.Hmatleft{ width: 300px; line-height: 24px;float: left;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; padding: 5px 10px;}
.Hmatleft a{overflow: hidden;white-space: nowrap;text-overflow: ellipsis; display:block; width:100%;}
.Hmatleft span{ color: #666; float: left; background: #fff; margin: 3px 0px;width: auto;}
.Hmatright{ float: right; margin-right: 5px;}
.Hmatright input{ margin-top: 16px; padding: 5px 8px; border-radius: 2px; background: #eaedf1; cursor: pointer; font-family: "微软雅黑";}
.HmatListy li{ border-bottom: 1px solid  #eaedf1; overflow: hidden; width:100%;}
.Hmatr_more{ width: 100%; text-align: center; height: 50px;line-height: 50px;}
.Hmatr_more a{  display: block;width: 100%;height: 100%;}
.hamerr{ height:40px; border-right: 1px solid #0087b4}
.closeThiss{ float:right !important; background:#fff !important;border:1px solid #999; color:#666 !important; padding:2px 5px; width: auto !important; height: 26px !important; line-height: 20px !important; position: relative; top:-3px;}
#main { width: 100%; padding-left: 160px;box-sizing:border-box;}

.header_right{ min-width: 314px; }
</style>
<div class="navbar" id="top">
    <div class="navbar-inner clear">
        <div class="navbar-header fl">
            <a href="<?php echo base_url('admin/t33/home/index');?>" class="navbar-brand">
                <!--<img src="/assets/ht/img/logo.png" /> --><span>帮游旅行社管理系统</span>
            </a>
        </div>
        <div class="header_right fr">
            <!--<div class="user_photo"><img src="<?php echo base_url('assets/ht/img/face.png');?>" onclick="change_avatar();"/></div> -->
            <div class="user_info">
		        <span class="logout_img" onclick="loginout();"><img src="<?php echo base_url('assets/ht/img/logout.png');?>" title="退出" /></span>
            	<div>
                    <a href="<?php echo base_url('admin/t33/home/update_info');?>" style="color:#fff;" target="main"><span class="login_name" title="个人中心">账户名 ：<?php echo $employee['realname'];?></span></a>
                </div>
				 <!-- start -->
                <div class="">
                </div>
		        <!-- end -->
            </div>

        </div>
		
		<div class="Hmatter uklist clickthis">
            	<div class="hamerr"><i></i><span><?php echo $num;?></span></div>
            	            	<div class="HmatterHidden thisshow">
	            	<div class="HmatTitle">站内消息通知<span class="closeThiss">关闭</span></div>
	            	<ul class="HmatListy">
	            		<?php foreach($msgArr as $val):?>
	            		<li>
		            		<div class="Hmatleft">
		            			<a href="#"><?php echo $val['content']?></a>
		            			<span><?php echo $val['addtime']?></span>
		            		</div>

		            		<div class="Hmatright">
		            			<input type="button" class="see-msg-but" data-val="<?php echo $val['id']?>" value="查看消息" />
		            		</div>
	            		</li>
						<?php endforeach;?>
	            	</ul>
	            	<div class="Hmatr_more">
	            		<a href="/msg/t33_msg_list/msg_list?employee_id=<?php echo $employee_id;?>" target="main" id="see-msg">查看全部</a>
	            	</div>
	            </div>
	         </div>




    </div>
</div>
<script type="text/javascript">
	$('#see-msg').click(function(){
		$(this).parent().parent().hide();
		$(this).parent().parent().parent().removeClass('userOn');
		$('#asideInner').find('dl').each(function(){
			var name = $.trim($(this).find('dt').text());
			$(this).find('dd').children('div').removeClass('cur');
			if (name == '旅行社中心') {
				$(this).find('dt').addClass('up');
				$(this).find('dd').show();
				$(this).find('dd').find('div').each(function(){
					var title = $(this).find('a').text();
					if (title == '消息提醒') {
						$(this).addClass('cur');
					}
				})
			}
		})
	})
	
	$('.see-msg-but').click(function(){
		window.top.openWin({
			  type: 2,
			  area: ['900px', '600px'],
			  title :'消息详细',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('msg/t33_msg_list/detail');?>"+"?id="+$(this).attr('data-val')
		});
	})
	
	$(".user_info>div").hover(function(){
		$(".hide_box").show(300);
	},function(){
		$(".hide_box").hide(300);
	});
	function loginout(){

		layer.confirm('确定要退出吗?', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				location.href="<?php echo base_url('admin/t33/login/login_out');?>";
			}, function(){
			  
			});
		
		/*if(confirm('确定要退出吗?')){
			location.href="<?php echo base_url('admin/t33/login/login_out');?>";
		}*/
	}

	$(".hamerr").click(function(){
		if($(this).parent().hasClass("userOn")){
			$(this).parent().removeClass("userOn");
			$(this).parent().find(".thisshow").hide();
		}else{
			$(".clickthis").find(".thisshow").hide();
			$(".clickthis").removeClass("userOn");
			$(this).parent().addClass("userOn");
			$(this).parent().find(".thisshow").show();
		}
	})
	$(".closeThiss").click(function(){
		$(".uklist").removeClass("userOn");
		$(".uklist").find(".thisshow").hide();
	})

</script>