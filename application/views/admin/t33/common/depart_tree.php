


<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>

<style type="text/css">

li {/*list-style: circle;*/font-size: 12px;}
li.title {list-style: none;}
ul.list {margin-left: 17px;}
ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}

</style>

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
	 //if(data.length==0||data=="") data={};
	 
	  var zNodes = null;
	  //var post_url="<?php echo base_url('admin/t33/expert/api_depart_list')?>";
      var return_data=send_ajax_noload(post_url,data);
      zNodes=return_data.data;
      for(var i in zNodes)
       {
           if(parseInt(zNodes[i].open)==1)
           {
          	 zNodes[i].open=true; //将open为1的改为true
          	 zNodes[i].isParent=true;
           }
           else
           {
          	 zNodes[i].open=false;
	       }


           if(parseInt(zNodes[i].level)==1)
           {
        	   zNodes[i].isParent=true;
           }
    
       } 
     
      return zNodes;
}
//end

		var tree_input_id="";
		var setting = {
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClick,
				onClick: onClick
			}
		};

		/*var zNodes =[
			{id:1, pId:0, name:"北京"},
			{id:2, pId:0, name:"天津"},
			{id:3, pId:0, name:"上海"},
			{id:6, pId:0, name:"重庆"},
			{id:4, pId:0, name:"河北省", open:true},
			{id:41, pId:4, name:"石家庄"},
			{id:42, pId:4, name:"保定"},
			{id:43, pId:4, name:"邯郸"},
			{id:44, pId:4, name:"承德"},
			{id:5, pId:0, name:"广东省", open:true},
			{id:51, pId:5, name:"广州"},
			{id:52, pId:5, name:"深圳"},
			{id:53, pId:5, name:"东莞"},
			{id:54, pId:5, name:"佛山"},
			{id:6, pId:0, name:"福建省", open:true},
			{id:61, pId:6, name:"福州"},
			{id:62, pId:6, name:"厦门"},
			{id:63, pId:6, name:"泉州"},
			{id:64, pId:6, name:"三明"},
			{id:65, pId:64, name:"三明子级"},
			{id:66, pId:65, name:"三明子二级"}
		 ];*/
         //数据
            var post_url="<?php echo base_url('admin/t33/expert/api_depart_list')?>";
		    var zNodes = get_zNodes(post_url);
	 		
        //数据 end
		function beforeClick(treeId, treeNode) {
			var check = (treeNode && !treeNode.isParent);
			//if (!check) alert("只能选择城市...");
			//return check;
		}
		
		function onClick(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getSelectedNodes(),
			v = "";
			var data_id="";
			nodes.sort(function compare(a,b){return a.id-b.id;});
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].name + ",";
				data_id += nodes[i].id + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			if (data_id.length > 0 ) data_id = data_id.substring(0, data_id.length-1);
			
			var cityObj = $("#"+tree_input_id);
			cityObj.attr("value", v);
			cityObj.attr("data-id",data_id);
			hideMenu();
		}
		/*  情况二 （场景：营业部一级、二级） */
		function showMenu(id,value) {
			var post_url="<?php echo base_url('admin/t33/expert/api_depart_list')?>";
			var new_zNodes=get_zNodes(post_url,{value:value});
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var value=$("#"+id).val();
			if(value=="")
			{
				$("#"+id).attr("data-id","");
			}
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999"); 
			
			$("#treeDemo").css("width",inputWidth); //等于input的长
			
			$("body").bind("mousedown", onBodyDown);
		}
		/*  情况二 （场景：营业部一级） */
		function showMenu2(id,value) {
			var post_url="<?php echo base_url('admin/t33/expert/api_level_one')?>";
			var new_zNodes=get_zNodes(post_url,{value:value});
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var value=$("#"+id).val();
			if(value=="")
			{
				$("#"+id).attr("data-id","");
			}
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999"); 
			
			$("#treeDemo").css("width",inputWidth); //等于input的长
			
			$("body").bind("mousedown", onBodyDown);
		}

		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}

		
		//加载树形结构（营业部）
		$(document).ready(function(){
			        
			         $.fn.zTree.init($("#treeDemo"), setting, zNodes);
			        
		});
		
	</SCRIPT>
	
	
	 
 <!-- 树形（营业部）-->
 <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0;"></ul>
</div>

	