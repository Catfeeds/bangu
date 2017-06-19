  var pagerExperts;
  function GetLinelistPage(pageNum){
        var pagesize = 10;
        $.ajax({
           type:'GET',
           url:'http://api.51ubang.com:9999/webservices/line_list?page=' + pageNum + '&callback=?',
           cache: false,
           dataType:'jsonp',
           success:function(data){
                   if (data.data.rows!=null && data.data.rows.length>0) { 
                             var len = data.data.rows.length;
                             var expertslist=new Array();
                              
                             for (var i = 0; i < len; i++) {
                               expertslist[i]=$.templates("#linelistpage").render(data.data.rows[i]);
                             };
                             $("#line_index_page").html(expertslist);
                               
               }
         },
         error:function (XMLHttpRequest, textStatus, errorThrown){
           throw XMLHttpRequest.responseText;
          }
        });
}
  $(function () {
	  var page = $("#line_index_page").attr("page");
      GetLinelistPage(page);
  });
  var index=1;
function showNext(){
	$("#pre").show();
	if(index>=$(".show_experts_s img").length-7){
		$("#down").hide();
	}
	$('#change').animate({left: -165*index+'px'}, 10);
	index++;
}
function showPre(){
	$("#down").show();
	if(index<=1){
		this.index=1;
		$("#pre").hide();
	}
	$('#change').animate({left: -165*(index-1)+'px'}, 10); 
	index--;
}