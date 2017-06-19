<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}

.content_wrap{margin:20px 0 0 20px;font-size:14px;}
.remark{margin:20px 0 0 20px;font-size:12px;}
</style>

<SCRIPT type="text/javascript">


	function send_ajax_noload(url,data)
	{  
		//发送ajax请求，无加载层
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
     //设置外交佣金 ,dest_id目的地id、dest_name目的地名称、level菜单层级
     var m_dest_id="";
   
    
     function setting_agent(dest_id,dest_name,level)
     {
        
    	 m_dest_id=dest_id;
    	 m_dest_name=dest_name;
         
    	 var post_url="<?php echo base_url('admin/t33/sys/union/api_agent_detail')?>";
      	 var ajax_data={dest_id:dest_id};
         var return_data=send_ajax_noload(post_url,ajax_data);

         var menu_title="";
         if(level=="3")
         {
        	 menu_title="设置【"+dest_name+"】";
         }
         else
         {
        	 menu_title="设置【"+dest_name+"】子级目的地";
         }
         $("#set_agent h5").html(menu_title);
         $("#set_agent #child_agent").val(return_data.data.child_agent);
         $("#set_agent #adult_agent").val(return_data.data.adult_agent);
         //弹窗
         if(level!="1")
         {
        	 layer.open({
   			  type: 1,
   			  title: false,
   			  closeBtn: 0,
   			  area: '500px',
   			  //skin: 'layui-layer-nobg', //没有背景色
   			  shadeClose: false,
   			  content: $('#set_agent')
   			});
         }
        
     }
     //
		var setting = {
			data: {
				key: {
					title:"t"
				},
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClick,
				onClick: onClick
			}
		};
        //ztree树整体数据
		/*var zNodes =[
			{ name:"pNode 01", open:true,
				children: [
					{ name:"pNode 11",
						children: [
							{ name:"leaf node 111"},
							{ name:"leaf node 112"},
							{ name:"leaf node 113"},
							{ name:"leaf node 114"}
						]},
					{ name:"pNode 12",
						children: [
							{ name:"leaf node 121"},
							{ name:"leaf node 122"},
							{ name:"leaf node 123"},
							{ name:"leaf node 124"}
						]},
					{ name:"pNode 13 - no child", isParent:true}
				]},
			{ name:"pNode 02",
				children: [
					{ name:"pNode 21", open:true,
						children: [
							{ name:"leaf node 211"},
							{ name:"leaf node 212"},
							{ name:"leaf node 213"},
							{ name:"leaf node 214"}
						]},
					{ name:"pNode 22",
						children: [
							{ name:"leaf node 221"},
							{ name:"leaf node 222"},
							{ name:"leaf node 223"},
							{ name:"leaf node 224"}
						]},
					{ name:"pNode 23",
						children: [
							{ name:"leaf node 231"},
							{ name:"leaf node 232"},
							{ name:"leaf node 233"},
							{ name:"leaf node 234"}
						]}
				]},
			{ name:"pNode 3 - no child", isParent:true}

		];*/
		var zNodes = null;
		var post_url="<?php echo base_url('admin/t33/sys/union/api_dest')?>";
      	
     	var ajax_data={};
        var return_data=send_ajax_noload(post_url,ajax_data);
        var new_zNodes=return_data.data;

        
        for(var i in new_zNodes)
        {
            var arr=new_zNodes[i];
            if(parseInt(arr.open)==1)
            {
            	arr.open=true; //将open为1的改为true
            }
           

            var children=arr.children;
            for(var j in children)
            {
               // console.log(children[j])
                if(parseInt(children[j].isParent)==1)
                {
                	children[j].isParent=true;  //将子节点 isParent为1的值改为true
                }
            }
            arr.children=children;
            new_zNodes[i]=arr;
        }
      // console.log(new_zNodes);
        zNodes=new_zNodes;
       
		
		var log, className = "dark";
		function beforeClick(treeId, treeNode, clickFlag) {
			className = (className === "dark" ? "":"dark");
			showLog("[ "+getTime()+" beforeClick ]&nbsp;&nbsp;" + treeNode.name );
			return (treeNode.click != false);
		}
		function onClick(event, treeId, treeNode, clickFlag) {
			//alert("id："+treeNode.id+"名称："+treeNode.name);
		 
		     setting_agent(treeNode.id,treeNode.name,treeNode.level+1)//设置外交佣金
		   
			//showLog("[ "+getTime()+" onClick ]&nbsp;&nbsp;clickFlag = " + clickFlag + " (" + (clickFlag===1 ? "single selected": (clickFlag===0 ? "<b>cancel selected</b>" : "<b>multi selected</b>")) + ")");
		}		
		function showLog(str) {
			if (!log) log = $("#log");
			log.append("<li class='"+className+"'>"+str+"</li>");
			if(log.children("li").length > 8) {
				log.get(0).removeChild(log.children("li")[0]);
			}
		}
		function getTime() {
			var now= new Date(),
			h=now.getHours(),
			m=now.getMinutes(),
			s=now.getSeconds();
			return (h+":"+m+":"+s);
		}

	
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);

			//
			//审核通过: 提交按钮
			$("body").on("click",".btn_save",function(){

				var adult_agent=$("#set_agent #adult_agent").val();
				var child_agent=$("#set_agent #child_agent").val();
				
		     
		        var url="<?php echo base_url('admin/t33/sys/union/api_agent_add');?>";
		        var data={dest_id:m_dest_id,adult_agent:adult_agent,child_agent:child_agent};
		        var return_data=send_ajax_noload(url,data);
		        if(return_data.code=="2000")
		        {
		        	t33_close();
					tan2(return_data.data);
					//t33_refresh();
		        }
		        else
		        {
		            tan(return_data.msg);
		        }
				
			});
			//end
		});
		
	</SCRIPT>
</head>
<body>




<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>旅行社设置</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">外交佣金</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
              <div class="table_content" style="float:left;width:100%;">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">设置外交佣金</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content" style="float:left;width:100%;min-height:680px;">
                    <div class="table_list">
                        <p class="remark">提示：点击第三级目的地，设置当前目的地的佣金；点击第二级目的地，一键设置子级目的地的佣金</p>
                        <!-- 树 -->
	                   <div class="content_wrap">
							<div class="zTreeDemoBackground left">
								<ul id="treeDemo" class="ztree"></ul>
							</div>
						
						</div>
                      
                    </div>                   
                </div>
                
            </div>
           

        </div>
        
    </div>
   
 <!-- 设置外交佣金 弹层 -->
 <div class="fb-content" id="set_agent" style="display:none;height:300px;">
    <div class="box-title">
        <h5>设置外交佣金</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
           
        	 <div class="form-group " style="margin-top:30px;">
                <div class="fg-title" style="width:28%;">成人外交佣金：<i>*</i></div>
                <div class="fg-input" style="width:45%;"><input type="text" id="adult_agent" class="showorder" placeholder="" name="showorder"></div>
             </div>
             <div class="form-group " style="margin-top:30px;">
                <div class="fg-title" style="width:28%;">儿童外交佣金：<i>*</i></div>
                <div class="fg-input" style="width:45%;"><input type="text" id="child_agent" class="showorder" placeholder="" name="showorder"></div>
             </div>
            <div class="form-group" style="margin-top:86px;">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_save" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>


 
</body>

</html>


