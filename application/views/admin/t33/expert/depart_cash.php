<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>

<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>

<style type="text/css">

/* ztree  */
li {font-size: 12px;}
li.title {list-style: none;}
ul.list {margin-left: 17px;}
ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}
/*
.ztree li span.button{height:16px;margin:4px auto;}
.ztree li span{height:18px;margin:3px auto;padding:2px auto !important;}*/
.ztree li a{margin:5px auto;}

.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}

ul li .label{margin:0 0 0 30px;}
.input_cash,.input_credit{width:150px;height:24px;padding:2px 0 2px 4px;margin-top:2px;}
.btn_save{background:#da411f;border:none;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius:2px;color:#fff;font-size:12px;padding:2px;
margin-left:5px;cursor:pointer;text-align:center;
}
.btn_save:hover{background:#ef694b;}

</style>
</head>
<body style="background: #fff">

<SCRIPT type="text/javascript">

function send_ajax_noload(url,data){  //发送ajax请求，无加载层
      //没有加载效果
    var ret;
	  $.ajax({
  	 url:url,
  	 type:"POST",
       data:data,
       async:false,
       dataType:"json",
       success:function(data){
      	 ret=data;
      	
       },
       error:function(){
      	 ret=data;
       }
               
  	});
	    return ret;

}
function get_zNodes(post_url,data)
{
	  var zNodes = null;
	  //var post_url="<?php echo base_url('admin/t33/expert/api_depart_list')?>";
      var return_data=send_ajax_noload(post_url,data);
      zNodes=return_data.data;
      
      for(var i in zNodes)
       {
          //是否打开
           if(parseInt(zNodes[i].open)==1)
           {
          	 zNodes[i].open=true; //将open为1的改为true
          	 //zNodes[i].isParent=true;
           }
           else
           {
          	 zNodes[i].open=false;
	       }
          //是否为文件夹
           if(parseInt(zNodes[i].jibie)==1)
           {
        
          	 zNodes[i].isParent=true;
           }
           else
           {
          	
	       }

       } 
     
      return zNodes;
}
//end

		var tree_input_id="";
		var setting = {
			view: {
				dblClickExpand: true,
				addDiyDom:addDiyDom
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				
			}
		};
        /*增加控件*/
		function addDiyDom(treeId, treeNode) {
			var aObj = $("#" + treeNode.tId);
			//对于第二级营业部，有管家时，“+”符号，没有管家时，“-”符号
			if(treeNode.expert_num=="0"&&treeNode.jibie=="2")
			{
				if(aObj.find("span:first-child").hasClass("bottom_close"))
		 		{
			 		aObj.find("span:first-child").removeClass("bottom_close");
					aObj.find("span:first-child").addClass("bottom_open");
		 		}
		 		else if(aObj.find("span:first-child").hasClass("center_close"))
		 		{
		 			aObj.find("span:first-child").removeClass("center_close");
					aObj.find("span:first-child").addClass("center_open");
			    }
			}
			
			//对于第一级营业部，没有管家时，且没有子营业部时，“-”符号，否则“+”号
		 	if(parseInt(treeNode.expert_num)==0&&parseInt(treeNode.child_num)==0&&treeNode.jibie=="1")
			{
		 		//alert(treeNode.name+","+treeNode.expert_num+","+treeNode.jibie)
		 		//console.log(aObj.find("span:first-child"));
		 		if(aObj.find("span:first-child").hasClass("bottom_close"))
		 		{
			 		aObj.find("span:first-child").removeClass("bottom_close");
					aObj.find("span:first-child").addClass("bottom_open");
		 		}
		 		else if(aObj.find("span:first-child").hasClass("center_close"))
		 		{
		 			aObj.find("span:first-child").removeClass("center_close");
					aObj.find("span:first-child").addClass("center_open");
			    }
				
			} 

			//二级营业部不能设置额度
			if(treeNode.jibie=="2")
			{
				//二级部不能设置额度
				
				var str="<label class='label'>现金额度：<input type='text' class='input_cash' depart_id='"+treeNode.id+"' value='"+treeNode.cash_limit+"' /></label><label class='label'>信用额度：<input type='text' class='input_credit' depart_id='"+treeNode.id+"' value='"+treeNode.credit_limit+"'   /></label><input type='button' class='btn_save' value='保存' />"
				//var str="<label class='label'>现金额度：<input type='text' class='input_cash' depart_id='"+treeNode.id+"' value='"+treeNode.cash_limit+"' readonly /></label><label class='label'>信用额度：<input type='text' class='input_credit' depart_id='"+treeNode.id+"' value='"+treeNode.credit_limit+"' readonly /></label>"
				
				aObj.append(str); //console.log(treeNode.name)
				
			}
			
			if(treeNode.jibie=="1")
			{
				var str="<label class='label'>现金额度：<input type='text' class='input_cash' depart_id='"+treeNode.id+"' value='"+treeNode.cash_limit+"' /></label><label class='label'>信用额度：<input type='text' class='input_credit' depart_id='"+treeNode.id+"' value='"+treeNode.credit_limit+"'  /></label><input type='button' class='btn_save' value='保存' />"
				aObj.find("a:first").after(str);
				//console.log(treeNode.name)
			}
			
			
		}
		/*  情况三  （场景：营业部额度设置）*/
		function showMenu3(id) {
			var post_url="<?php echo base_url('admin/t33/expert/api_level_two')?>";
			   
			var new_zNodes=get_zNodes(post_url);
			
			if(new_zNodes.length>0)
			{
				if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
				new_zNodes.unshift({id:0,pId:0,jibie:0,name:'所有营业部',expert_num:'1',child_num:'1',open:true});

			    for(var i in new_zNodes)
				 {
				           if(parseInt(new_zNodes[i].jibie)==2)
				           {
				        	   new_zNodes[i].isParent=true;
				           }
				          
				    
				 } 
				
			     $.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			}
			else
			{
				$("#no-data").css("display","block");
		    }
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999"); 
			
			$("#treeDemo").css("width",inputWidth); //等于input的长
			
		
		}
		/*  情况四  （场景：搜索营业部名称、负责人）*/
		function showMenu4(id) {
			var post_url="<?php echo base_url('admin/t33/expert/api_level_two')?>";
			var content=$("#content").val();  
			var new_zNodes=get_zNodes(post_url,{content:content});
			
			if(new_zNodes.length>0)
			{
			
				if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
				new_zNodes.unshift({id:0,pId:0,jibie:0,name:'所有营业部',expert_num:'1',child_num:'1',open:true});

			    for(var i in new_zNodes)
				 {
				           if(parseInt(new_zNodes[i].jibie)==2)
				           {
				        	   new_zNodes[i].isParent=true;
				           }
				          
				    
				 } 
			     $("#treeDemo").show();
			     $.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			     $("#no-data").css("display","none");
			    
			}
			else
			{
				$("#treeDemo").hide();
				$("#no-data").css("display","block");
		    }
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999"); 
			
			$("#treeDemo").css("width",inputWidth); //等于input的长
			

		}

		
		//加载树形结构（营业部）
		$(document).ready(function()
		{
		         showMenu3("depart_settting");
                 $(".ztree li").css("margin-top","10px");

                 $("body").on("click",".btn_save",function(){

                    var id=$(this).parent().find(".input_cash").attr("depart_id");
                    var cash_limit=$(this).parent().find(".input_cash").val();
                    var credit_limit=$(this).parent().find(".input_credit").val();

                    var url="<?php echo base_url('admin/t33/expert/api_edit_cash');?>";
        			var post_data={id:id,cash_limit:cash_limit,credit_limit:credit_limit};
        			var return_data=send_ajax_noload(url,post_data);
        			
        			if(return_data.code=="2000")
        			{
        				alert(return_data.data);
        				t33_refresh();
        			}
        			else
        				tan(return_data.msg);
                     
                 });


				 //搜索
				 $("#btn_search").click(function(){
                  var content=$("#content").val();
                 /*  if(content=="")
                  {
                	  showMenu3("depart_settting");
                      $(".ztree li").css("margin-top","10px");
                  }
                  else
                  { */
                	  showMenu4("depart_settting");
                      $(".ztree li").css("margin-top","10px");
                  //}
			    })
			        
		});
		
	</SCRIPT>
	
	
	 
 <!-- 树形（营业部）-->
 <div id="menuContent" class="menuContent" style="display:none; position: absolute;height:750px;">
	<ul id="treeDemo" class="ztree" style="margin-top:0;background:#fff;border:none;overflow:auto;height:750px;"></ul>
</div>
<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>额度管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">额度设置</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content clear">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">额度设置</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content" style="width:100%;float:left;height:auto;">
                 <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group" style="margin: 0 0 0 20px;">
                                   
                                    <input type="text" id="content" name="" placeholder="营业部名称或负责人" class="search_input"/>
                                </div>

                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin: 0;">
                                    <input type="button" id="btn_search" name="submit" class="search_button" value="搜索"/>
                                </div>
                              
                              
                                
                            </div>
                   </form>
                   <div id="no-data" style="display: none;">
                     <p style="margin-top:50px;margin-left:10%;">没有找到营业部</p>
                   </div>
                    <div id="depart_settting" style="width:90%;float:left;">
                         		
                    </div>
                </div>
                
            </div>

        </div>
        
    </div>

</html>


