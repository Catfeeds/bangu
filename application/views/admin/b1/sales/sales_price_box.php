<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<link href="<?php echo base_url('assets/css/product.css')?>"  rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<style type="text/css">

.ul_div{margin-top:55px;padding-left:15px;}
.ul_div .one_p{line-height:30px;margin:10px auto;}
.ul_div .one_p font{font-weight:bold;float:left;}
.ul_div .one_p p{float:left;}

.ul_div .div_trip{border-bottom:1px solid #ddd;margin-bottom:20px;float:left;width:100%;}
.ul_div .div_trip p{line-height:30px;margin:4px auto;float:left;width:100%;}
.ul_div .div_trip p font{font-weight:bold;}

.ul_div .div_trip .div_pic{float:left;width:100%;margin-bottom:5px;}
.ul_div .div_trip .div_pic font{font-weight:bold;}

.ul_div .three_p{margin:5px auto;width:100%;float:left;border-bottom:1px solid #ddd;padding-bottom:10px;}
.ul_div .three_p font{color:#66C9F3;float:left;border:1px solid #66C9F3;padding:4px;margin-right:10px;}
.ul_div .three_p input{width:45px;padding-left:5px;background:#ebebe4;}
.ul_div .three_p p{float:left;}

.page_content { margin-top:0;}
  .add_suit{
  background: #09c;
    outline: none;
    border: none;
    color: #fff;
    border-radius: 2px;
    padding: 8px 12px !important;
    cursor:pointer;
  }

.reserve_table .bg_blue {
    background-color: #F0FAFF;
    border-bottom: #BCD8F4 solid 1px;
    height: 22px;
    line-height: 22px;
    padding: 0 2px;
    text-align: left;
}
.ul_div .one_p p{
    float: none;
}
/* 屏蔽设置价格*/
 .cal-manager .add-package{display:none;}
.line_features { float:left;text-indent:2em !important;}
.line_features p { text-align:left !important;text-indent:2em !important;}

.reserve_table td .lprice {
  color:#F40;
}
 .reserve_table{width: 945px;}
.reserve_record{width: 105px;}
.layoutfix{width: 1050px;} 
.reserve_table input[type="text"]{
    width: 80px;
    border-bottom: 1px solid #666 !important;
}

</style>

</head>
<body>

<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg" style="box-shadow:none;overflow-x: initial;">
    
        <!-- ===============我的位置============ -->
        <!-- <div class="current_page">
            <a href="#" class="main_page_link"><i></i>线路管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">线路列表</a>
        </div> 
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray" style="margin-top:0;">      
            
            <!-- tab切换表格 -->
            <div class="table_content" style="padding-bottom:0px;">
                <div class="itab" style="position: fixed;top:0;left:0;height:31px;z-index:1000;width:96%;margin:0 10px 0 10px;">
                    <ul class="clear"> 
                        <li static="1"><a href="#tab1" class="active" >设置价格</a></li> 
                    </ul>
                </div>
                <div class="tab_content" style="margin-top:10px;">
         
                       <!--报价-->
                        <div class="ul_div" style="float: left; width: 100%;">
                           <div class="one_p" style="margin:0px;  float: left; width: 100%;" >
                                   <form action="<?php echo base_url()?>admin/b1/product/updateLinePrice"   method="post"  id="linePriceForm" >    
                                      <input name="lineId" type="hidden" id="lineId" value="<?php if(!empty($lineId)){ echo $lineId;} ?>" />
                                   </form>
                                   <div class="cal-manager">
                                   </div>  
                                   <div style="padding:30px;margin-left:380px">
                                   		<button class="add_suit" id="savePriceBtn" type="button">保存</button>
                                   </div>                              
                           </div>
                       </div>
                       </div>
                      
                </div>
                
            </div>

        </div>
        

<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script  src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script  src="<?php echo base_url('assets/js/admin/jquery.sales_date.js')?>"></script>
<script src="<?php //echo base_url('assets/js/jQuery-plugin/dateTable/jquery.calendarTable.js')?>"></script>
<script type="text/javascript">
//----------------------------报价------------------------------
(function(){
 
  var priceDate = null;

  function initProductPrice(){
      var url = '<?php echo base_url()?>admin/b1/sales_apply/get_salesPrice';
      priceDate = new jQuery.calendarTable({  record:'', renderTo:".cal-manager",comparableField:"day",
      url :url,
      params : function(){ 
        return jQuery.param( { "lineId":jQuery('#lineId').val()  ,"suitId":jQuery('#suitId').val()  ,"startDate":jQuery('#selectMonth').val() } );
      },
      monthTabChange : function(obj,date){
        jQuery('#selectMonth').val(date); 
      },
      dayFormatter:function(settings,data){
	          var dayid= '';
	          var number= '';
	          var adultprice= '';
	          var childprice= '';
	          var childnobedprice = '';
	          var groupId='';
	          var s_adultprice='';
	          var s_childprice='';
	          var s_childnobedprice='';
	          var s_number ='';
	          var date_flag='';
	          var s_number ='';
	          var date_flag='';
			  date_flag=settings.disabled; 
	          if(data){
	            	dayid = data.dayid;
	            	childnobedprice = data.childnobedprice;
	           		adultprice=data.adultprice;
	            	childprice=data.childprice;
	            	number = data.number;
	            	s_adultprice = data.s_adultprice;
	            	s_childprice=data.s_childprice;
	            	s_childnobedprice=data.s_childnobedprice;
	            	s_number=data.s_number;

	          }
	          
	      	var date='<?php echo date('Y-m-d',time()); ?>';
			if(settings.date>=date){
				date_flag=false;	
			}

			var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
			var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
					
			var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
			html += date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+adultprice+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_adultprice?'':'style="color:#F40" ')+'class="price"  value="'+s_adultprice+'"  size="10" name="s_adultprice"/></p>';
			
			html += date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+(''==childprice?'':childprice)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_childprice?'':'style="color:#F40" ')+'class="price"  value="'+s_childprice+'"  size="10" name="s_childprice"/></p>';
			
			html += date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+(''==childnobedprice?'':childnobedprice)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_childnobedprice?'':'style="color:#F40" ')+'class="price"  value="'+s_childnobedprice+'"  size="10" name="s_childnobedprice"/></p>';
			
			html += date_flag ? '<p>'+(''==number?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">余位：</span><span style="color:#F40;padding-right: 5px;">'+(''==number?'':number)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销位：</span><input type="text" '+(''==s_number?'':'style="color:#F40" ')+'class="price" value="'+s_number+'"  size="10" name="s_number"/></p>';

	        return html;

        },dayFormatter1:function(settings,data){
            var dayid= '';
	          var number= '';
	          var adultprice= '';
	          var childprice= '';
	          var childnobedprice = '';
	          var groupId='';
	          var s_adultprice='';
	          var s_childprice='';
	          var s_childnobedprice='';
	          var s_number ='';
	          var date_flag='';
	          var s_number ='';
	          var date_flag='';
			  date_flag=settings.disabled; 
	          if(data){
	            	dayid = data.dayid;
	            	childnobedprice = data.childnobedprice;
	           		adultprice=data.adultprice;
	            	childprice=data.childprice;
	            	number = data.number;
	            	s_adultprice = data.s_adultprice;
	            	s_childprice=data.s_childprice;
	            	s_childnobedprice=data.s_childnobedprice;
	            	s_number=data.s_number;

	          }
	          
	      	var date='<?php echo date('Y-m-d',time()); ?>';
			if(settings.date>=date){
				date_flag=false;	
			}

			var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
			var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
				
			
				
/* 			var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
			html += date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+adultprice+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+adultprice+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">促销价：</span><span style="color:#F40">'+s_adultprice+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_adultprice?'':'style="color:#F40" ')+'class="price"  value="'+s_adultprice+'"  size="10" name="s_adultprice"/></p>';
			
			html += date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+childprice+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+(''==childprice?'':childprice)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">促销价：</span><span style="color:#F40">'+s_childprice+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_childprice?'':'style="color:#F40" ')+'class="price"  value="'+s_childprice+'"  size="10" name="s_childprice"/></p>';
			
			html += date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+childnobedprice+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+(''==childnobedprice?'':childnobedprice)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">促销价：</span><span style="color:#F40">'+s_childnobedprice+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_childnobedprice?'':'style="color:#F40" ')+'class="price"  value="'+s_childnobedprice+'"  size="10" name="s_childnobedprice"/></p>';
			
			html += date_flag ? '<p>'+(''==number?'':'<span style="float: left;">余位：</span><span style="color:#F40;padding-right: 5px;">'+number+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">余位：</span><span style="color:#F40;padding-right: 5px;">'+(''==number?'':number)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">促销位：</span><span style="color:#F40">'+s_number+"</span>")+'</p>':'<p><span class="lab"></span><span style="float: left;">促销位：</span><input type="text" '+(''==s_number?'':'style="color:#F40" ')+'class="price" value="'+s_number+'"  size="10" name="s_number"/></p>';
 */
 
			var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
			html += date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+adultprice+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_adultprice?'':'style="color:#F40" ')+'class="price"  value="'+s_adultprice+'"  size="10" name="s_adultprice"/></p>';
	
			html += date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+(''==childprice?'':childprice)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_childprice?'':'style="color:#F40" ')+'class="price"  value="'+s_childprice+'"  size="10" name="s_childprice"/></p>';
	
			html += date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">售价：</span><span style="color:#F40;padding-right: 5px;">'+(''==childnobedprice?'':childnobedprice)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销价：</span><input type="text" '+(''==s_childnobedprice?'':'style="color:#F40" ')+'class="price"  value="'+s_childnobedprice+'"  size="10" name="s_childnobedprice"/></p>';
	
			html += date_flag ? '<p>'+(''==number?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">余位：</span><span style="color:#F40;padding-right: 5px;">'+(''==number?'':number)+'</span></p>';
			html+= date_flag ? '<p>'+(''==adultprice?'':'')+'</p>':'<p><span class="lab"></span><span style="float: left;">促销位：</span><input type="text" '+(''==s_number?'':'style="color:#F40" ')+'class="price" value="'+s_number+'"  size="10" name="s_number"/></p>';
 
	        return html;
              
        }
      });
    
    
  }
  initProductPrice()

  //保存提前截止日期
  jQuery('#savePriceBtn').click(function(){ 
        var formParam = jQuery('#linePriceForm').serialize();
        var price = JSON.stringify(priceDate.getValues());
        jQuery.ajax({ type : "POST",data :formParam+"&prices="+price ,url : "<?php echo base_url()?>admin/b1/sales_apply/saveSalesPrice", 
            success : function(response) {
               var response = eval('(' + response + ')');
                if(response.stauts=='1'){
                     alert( response.msg ); 
                     priceDate.loadData();
         
                }else{
                	 alert( response.msg ); 
                } 
            }
        });
  });
  
})();


  $(function(){
    $(".itab ul li").each(function(index){

          $(this).click(function(){
                $(".ul_div").each(function(key){
                        
                    if(key==index)
                        $(this).css("display","block");
                    else
                        $(this).css("display","none");   

                })
          })

      })
    })

    

</script>
</html>


