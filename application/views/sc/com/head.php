<div class="header">
  	<div class="sc_1000 wind_top">
	
	 
  		<!-- 花式登陆 等等 -->
  		<ul class="logis_top">
  			<li><a href=""><i class="weibo"></i><span>微博</span></a></li>
  			<li><a href=""><i class="weixin"></i><span>微信</span></a></li>
  			<li><a href="http://m.1b1u.com" target="_blank"><i class="shouji"></i><span>手机版</span></a></li>
  			<li><a href=""><i class="shoucang"></i><span>设为首页</span></a></li>
  		</ul>
		 <a href="javascript:void(0);" class="yuming"   rel="sidebar" onclick="addFavorite('1b1u.com','zhy')" >收藏本站</a>
                    <script>
                  //收藏本站
                    function addFavorite(sURL, sTitle) {
                    	//window.external.addFavorite(sURL, sTitle);
					    try {
					        //IE
					        window.external.addFavorite(sURL, sTitle);
					    } catch (e) {
					        try {
					            //Firefox
					            window.sidebar.addPanel(sTitle, sURL, "");
					        } catch (e) {
					            alert("您的浏览器不支持自动加入收藏，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.", "提示信息");  
					        }
					    }
					}
                    </script>
  		<!-- 搜索栏 -->
		  <div class="sc_search">  
                      <!-- 将guanj改为guanjia\/ 魏勇编辑-->
		<form id="search_line_form" class="search_line_form" action="<?php if(!empty($search_type) && $search_type ==1){echo site_url('guanj\/');}else{echo site_url('all');}?>" method="post">
	                	<input type="submit" class="sech_button" value="搜索" style="_border:none"  />
	                	<input type="text" class="sech_text" placeholder="快速检索管家" autocomplete="off" value="<?php if(empty($key_word)) echo ''; else echo $key_word ;?>" name="key_word" onkeyup="this.value=this.value.replace(/[^\u4e00-\u9fa5\w]/g,'')" ；this.value=this.value.replace(/[^\u4e00-\u9fa5\w]/g,''/>
	                	
                	
  		<!--
  			<input type="button" class="sech_button" value="搜索">
  			<input type="text" class="sech_text" placeholder="站内搜索" />-->
  		
		</form>
		</div>
  	</div>
</div>
<!-- 旅游目的地分类 -->
<div class="travel_des clear">
	<div class="travel_type">
    	<div class="left_title">
        	<i class="zb"></i>
            <span>周边游</span>
        </div>
        <div class="right_conten">
        	<?php if(count($zb5)>0):?>
		         <?php foreach ($zb5 as $zb=>$zb_value):?>
		            <?php if($zb<13):?>
		        	<a href="<?php echo $url['gn'].$zb_value['id'].$url['wei']?>" target="_blank"><?php echo $zb_value['kindname'];?></a>
		            <?php endif;?>
		         <?php endforeach;?>
		            <?php if(count($zb5)>=13):?>
                                <!-- 将gn改为guonei/-->
		              <a href="<?php echo base_url('guonei/');?>" target="_blank">...</a> 
		            <?php endif;?>
            <?php endif;?>
        </div>
        
    </div>
	
    <div class="travel_type">
    	<div class="left_title">
        	<i class="gn"></i>
            <span>国内游</span>
        </div>
        <div class="right_conten">
        	<?php if(count($gn5)>0):?>
		         <?php foreach ($gn5 as $gn=>$gn_value):?>
		            <?php if($gn<13):?>
                               <?php var_dump($ur);?>
		        	<a href="<?php echo $url['gn'].$gn_value['id'].$url['wei']?>" target="_blank"><?php echo $gn_value['kindname'];?></a>
		            <?php endif;?>
		         <?php endforeach;?>
		            <?php if(count($gn5)>=13):?>
                                <!-- 将gn改为guonei/-->
		             <a href="<?php echo base_url('guonei/');?>" target="_blank">...</a> 
		            <?php endif;?>
            <?php endif;?>
        </div>
    </div>
    
    <div class="travel_type">
    	<div class="left_title">
        	<i class="cj"></i>
            <span>出境游</span>
        </div>
        <div class="right_conten">
        <?php if(count($jw5)>0):?>
         <?php foreach ($jw5 as $jw=>$jw_value):?>
            <?php if($jw<10):?>
        	<a href="<?php echo $url['cj'].$jw_value['id'].$url['wei']?>" target="_blank"><?php echo $jw_value['kindname'];?></a>
            <?php endif;?>
         <?php endforeach;?>
            <?php if(count($jw5)>=10):?>
                <!--将cj改为chujing/-->
             <a href="<?php echo base_url('chujing/');?>" target="_blank">...</a> 
            <?php endif;?>
        <?php endif;?>
        </div>
    </div>
    
    <div class="travel_type" style="margin-right:0;">
    	<div class="left_title">
        	<i class="zt"></i>
            <span>主题游</span>
        </div>
        <div class="right_conten">
        	<?php if(count($zt5)>0):?>
		         <?php foreach ($zt5 as $zt=>$zt_value):?>
		            <?php if($zt<8):?>
		        	<a href="<?php echo $url['zt'].$zt_value['id'].$url['wei']?>" target="_blank"><?php echo $zt_value['name'];?></a>
		            <?php endif;?>
		         <?php endforeach;?>
		            <?php if(count($zt5)>=8):?>
		            <a href="<?php echo base_url('zt');?>" target="_blank">...</a> 
		            <?php endif;?>
            <?php endif;?>
        </div>
    </div>
</div>