<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript"	src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>

<style type="text/css">

li {list-style: circle;font-size: 12px;}
li.title {list-style: none;}
ul.list {margin-left: 17px;}
ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}

</style>
<script type="text/javascript">


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
    var return_data=send_ajax_noload(post_url,data);
    zNodes=return_data;
    for(var i in zNodes)
     {
         if(parseInt(zNodes[i].open)==1)
         {
        	 zNodes[i].open=true; //将open为1的改为true
        	 //zNodes[i].isParent=true;
         }
         else
         {
        	 zNodes[i].open=false;
	       }
         if(parseInt(zNodes[i].level)==1)
         {
        	 zNodes[i].isParent=true;
         }
         else
         {
      	   zNodes[i].isParent=false;
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
			cityObj.attr("value", '');
			cityObj.attr("data-id",data_id);

			//选目的地
			var valObj=$("#overcitystr");
			var ids = valObj.val();
			var idArr = ids.split(",");
			var s = true;
			$.each(idArr ,function(key ,val) {
				if (data_id == val) {
					alert("此选项你已选择");
					s = false;
				}
			})
			if (s == false) {
				return false;
			}
			ids += data_id+',';
			valObj.val(ids); 
			
		
			var valId="overcitystr";
			var buttonId="ds-list";
			var html = '<span class="selectedContent" value="'+data_id+'">'+v+'<span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
			$('#ds-list').append(html);
			$('#ds-list').css('display','block');

		    
			hideMenu();
		}
		
		function showMenu(id,value) {
			var post_url="<?php echo base_url('common/get_data/getDestBaseData')?>";
			var new_zNodes=get_zNodes(post_url,{name:value});
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
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
			$("#treeDemo").css("width",inputWidth); //等于input的长
			$("body").bind("mousedown", onBodyDown);
		}
		/*出境游*/
		function show_JL_Menu(id,value) {
			var post_url="<?php echo base_url('common/get_data/getJLDestBaseData')?>";
			var new_zNodes=get_zNodes(post_url,{name:value});
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
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
			$("#treeDemo").css("width",inputWidth); //等于input的长
			$("body").bind("mousedown", onBodyDown);
		}
		/*国内游*/
		function show_GL_Menu(id,value) {
			var post_url="<?php echo base_url('common/get_data/getGLDestBaseData')?>";
			var new_zNodes=get_zNodes(post_url,{name:value});
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
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
			$("#treeDemo").css("width",inputWidth); //等于input的长
			$("body").bind("mousedown", onBodyDown);
		}
		/*周边游*/
		function show_ZL_Menu(id,value) {
			var startcity=$('#lineCityId').val();
			var post_url="<?php echo base_url('common/get_data/getTripDestAll')?>";
			var new_zNodes=get_zNodes(post_url,{name:value,startcity:startcity});
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
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
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

</script>
 <!-- 树形（营业部）-->
 <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0;"></ul>
</div>
