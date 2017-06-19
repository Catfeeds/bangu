


<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>

<style type="text/css">

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
	  var zNodes = null;
	  //var post_url="<?php echo base_url('admin/t33/expert/api_tree_dest')?>";
      var return_data=send_ajax_noload(post_url,data);
      zNodes=return_data.data;
      for(var i in zNodes)
      {
          if(parseInt(zNodes[i].open)==1){
          	 zNodes[i].open=true; //将open为1的改为true
          	 zNodes[i].isParent=true;
           }else{
               if(zNodes[i].type=="depart_id"){
            	 	 zNodes[i].isParent=true;
               }
               
	        /*     var aObj = $("#" + treeNode.tId);             
	           	if(aObj.find("span:first-child").hasClass("bottom_close"))
		 		{
			 		aObj.find("span:first-child").removeClass("bottom_close");
					aObj.find("span:first-child").addClass("bottom_open");
		 		}
		 		else if(aObj.find("span:first-child").hasClass("center_close"))
		 		{
		 			aObj.find("span:first-child").removeClass("center_close");
					aObj.find("span:first-child").addClass("center_open");
			    } */
	
	               
	          	zNodes[i].open=false;
	          
	       }

  		
		
    
      } 
      return zNodes;
}
//end

		var tree_input_id="";
		var setting = {
			view: {
				dblClickExpand: false,
				addDiyDom:addDiyDom
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

		function addDiyDom(treeId, treeNode) {
			var aObj = $("#" + treeNode.tId);
			//对于第二级营业部，有管家时，“+”符号，没有管家时，“-”符号
			if(treeNode.expert_num==0 && treeNode.type=='depart_id')
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
		}

			
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

           var post_url="";
           var zNodes ='';

	 		
        //数据 end
		function beforeClick(treeId, treeNode) {
			var check = (treeNode && !treeNode.isParent);
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

			if(nodes[0].type=='depart_id'){
				alert('单项不能选择营业部门');
				return  false;
			}
			
			var cityObj = $("#"+tree_input_id);
			cityObj.attr("value", v);
			if(nodes[0].type=='union'){
				cityObj.attr("data-id",nodes[0].union_id);
			}else{
				cityObj.attr("data-id",data_id);
			}
			

			//------用于供应商添加单项时的销售对象-----------
		/* 	if(nodes[0].type=='expert_id'){  
				cityObj.attr("data-value",'-1');
				cityObj.attr("data-name",v);
			}else if(nodes[0].type==1){
				cityObj.attr("data-value", nodes[0].expert_id);
				cityObj.attr("data-id", nodes[0].expert_id);
				cityObj.attr("data-name",v);
				//expert_id		
			} */

			if(nodes[0].type=='union'){  
				cityObj.attr("data-value",'-1');
				cityObj.attr("data-name",v);
			}else if(nodes[0].type=='expert_id'){
				cityObj.attr("data-value", nodes[0].expertid);
				cityObj.attr("data-id", nodes[0].expertid);
				cityObj.attr("data-name",v);
			}
			hideMenu();
		}



		/*  情况三：供应商添加出发地 */
		function showMenu_s_startplace(id) {
	
			var post_url="<?php echo base_url('admin/b1/line_single/api_tree_startplace')?>";
				   
			var new_zNodes=get_zNodes(post_url);

			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999"); 
			
			$("#treeDemo").css("width",inputWidth); //等于input的长
			
			$("body").bind("mousedown", onBodyDown);
		}

		/*  （场景：旅行社管理下的销售人员） */
		function showUnionExpert(id,content) {
			var data={'content':content};
			var post_url="<?php echo base_url('admin/b1/group_line/api_union_expert')?>";
			var new_zNodes=get_zNodes(post_url,data);

			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999"); 
			
			$("#treeDemo").css("width",inputWidth); //等于input的长
			
			$("body").bind("mousedown", onBodyDown);

		}
		function  showUnExpert(id){
					
			var url = '/admin/b1/group_line/api_union_expert';			
			var data={'content':''};	
			var new_zNodes = get_zNodes(url ,data);
			$("#"+id).unbind('keyup');
			$("#"+id).keyup(function(event) {
				var value = $("#"+id).val();
				
				if (typeof event != 'undefined') {
					var code = event.keyCode;
					if (value == '') {
						$("#"+id).attr('data-id' ,'');
						$("#"+id).attr('data-value' ,'');
						$("#"+id).attr('data-name' ,'');
						$("#"+id).next('input').val('');
						
					}
				}
				
				
				var data={'content':value};
				var new_zNodes = get_zNodes(url ,data);	

				$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
				tree_input_id=id;
				var cityObj = $("#"+id);
				var cityOffset = $("#"+id).offset();
				var inputWidth=$("#"+id).width()+5;
				$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
				$("#menuContent").css("z-index","99999999"); 
				
				$("#treeDemo").css("width",inputWidth); //等于input的长
				
				$("body").bind("mousedown", onBodyDown);
					
			})
	
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			tree_input_id=id;
			var cityObj = $("#"+id);
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

		//去掉数组的重复值
		function uniqueArrayTree(dataArr) {
			dataArr.sort();
			//去除重复的数值
			var arr = new Array;
			var tempStr="";
			for(var i in dataArr) {
				if(dataArr[i] != tempStr){
					arr.push(dataArr[i]);
			    	tempStr=dataArr[i];
			    }else{
			    	continue;
			    }
			}
			return arr;
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

	