
$(document).ready(function(){
	
	$('#btn_print').on('click',function(){
			window.open('compares_print.html', 'sharer', 'toolbar=0, status=0, width=576, height=798');
	});
	
});

function load_view_print(){

	

	var column = "";
	var item = "";
	get_print_title();
	//get_print_item();

	//column += "<td>"+item+"</td>";
	//view.append("<table><tr>"+item+"</tr></table>");
	
}

function get_print_title(){

	var endpoint = "services/attributes.php";
	var method='get';
	var args = {'_':new Date().getHours(),'type':'other','option':'prod'};
	var view = $('#view_print');
	var item="";
	var column_header="";
	utility.service(endpoint,method,args,function(resp){
		
		
		column_header="<tr style='border-bottom:1px solid #a58b5d;'><td style='border-left:1px solid #a58b5d;' >";
		column_header += "<ul class='content-slider'>";
		column_header += "<li style='text-align:center;'>";
		column_header += "<img src='images/common/compare.png' onerror=this.src='images/common/unavaliable.jpg' class='item-print' >";
		column_header += "<div class='lightslider-title'><label><span class='glyphicon glyphicon-stop'></span><span id='compare.category'></span></label></div>";
		column_header += "<ul class='lightslider-desc'>";

		$.each(resp.result,function(id,val){
			column_header+="<li><span>"+val.value+"<span></li>";
		});

		column_header += "</ul></li></ul></td>";
		
		//view.append(item);
		
	},function(){ //finally
		
		get_print_item(column_header);
		
	});

	
}

function get_print_item(header){

	var endpoint = "services/compare.php";
	var method='get';
	var args = {'_':new Date().getHours(),'type':'view'};
	var view = $('#view_print');
	utility.service(endpoint,method,args,function(resp){

	if(resp.result==null) return;

	
	//compare.html("");
	var item = "";//initial column header
	//for(var i =0 ; i < 5;i++){
		$.each(resp.result,function(id,val){
			
			//check item for new page
			if(id % 4==0){
				
				
				if(id>1){
					item+= "<tr><td colspan='5' style='border:0px solid #a58b5d;'>&nbsp;</td></tr>";
					item+="<tr ><td colspan='5' style='border:0px solid #a58b5d;height:100px;'>";
					item+="<h4 class='text-center'><span class='glyphicon glyphicon-stop'></span><span id='compare.header'></span></h4>";
					item+="</td></tr>";
				}
				
				item+= "</tr>"+header;// append new columns header
				
				
			}

			item += "<td ><ul class='content-slider'>";
			item += "<li style='text-align:center;'>";
			item += "<img src='"+val.info.thumb+"' onerror=this.src='images/common/unavaliable.jpg' class='item-print' >";
			item += "<div class='lightslider-title'><span class='glyphicon glyphicon-stop'></span>"+val.info.cate+"</div>";
			item += "<ul class='lightslider-desc'>";
			
			$.each(val.attrs,function(i,val_attr){

				var title = "-"

				if(val_attr.title!="")
					title = val_attr.title;

				item += "<li><span>"+title+"</span></li>";

			});
			
			item += "</ul></li></ul></td>";
			
		});

		item+="</tr>";//last page
		view.append(item);
	},function(){
		utility.setpage('compare');
	});
}

function loadviewcompare(){

	var endpoint = "services/attributes.php";
	var method='get';
	var args = {'_':new Date().getHours(),'type':'other','option':'prod'};
	utility.service(endpoint,method,args,setviewtemplete,loadproduct);
	
	utility.setpage('compare');
		
}

function setviewtemplete(data){
	
	var compare = $('#compare-slider');
	compare.html('');
	var item = "";

	item += "<li ><a href='javascript:void(0);' >";
	item += "<img src='images/common/compare.png' onerror=this.src='images/common/unavaliable.jpg' class='img-responsive' >";
	item += "<div class='lightslider-title'><label><span class='glyphicon glyphicon-stop'></span><span id='compare.category'></span></label></div>";
	item += "<ul class='lightslider-desc'>";

	$.each(data.result,function(id,val){
		item+="<li><span>"+val.value+"<span></li>";
	});
	item += "</ul>";
	item += "</a></li>";
	

	compare.append(item);

	
	

}

function loadproduct(){

	var endpoint = "services/compare.php";
	var method='get';
	var args = {'_':new Date().getHours(),'type':'view'};

	utility.service(endpoint,method,args,setviewitems,function(){

	
		$('#compare-slider').show();
		
		//check view mobile or desktop
		
		var maxitem = 4;
		
		//checking view mobile
		if (/Mobi/.test(navigator.userAgent)) { 
			maxitem=2;
		}
		
		$("#compare-slider").lightSlider({
			autoWidth: false
			,item:maxitem
			,adaptiveHeight:false
			,loop:false
			,keyPress:false
			,pager:false
			,slideMargin:5
			,enableTouch:true
			,enableDrag:true
			
		});
		
		
		$('.icon_close').on('click',function(){
			//alert('hello');		
			var id = $(this).attr('data-id');
			console.log("remove id = "+id);
			remove_compare(id);
		});

	});

}

function remove_compare(id){
	var endpoint = 'services/compare.php';
	var method = 'get';
	var args = {'_':new Date().getMilliseconds(),'type':'remove','id':id};
	
	utility.service(endpoint,method,args,function(){
		loadviewcompare();
		//loadproduct();
	});
}

function setviewitems(data){
	console.debug(data);
	
	if(data.result==null) return;

	var compare = $('#compare-slider');
	//compare.html("");
	var item = "";
	//for(var i =0 ; i < 5;i++){
	$.each(data.result,function(id,val){

		item += "<li ><div class='icon_close' data-id='"+val.info.id+"' ><img style='width:24px;height:24px;' src='images/common/close.png' /></div>";
		item += "<a href='#' onclick=redirect('"+val.info.id+"')>";
		item += "<img src='"+val.info.thumb+"' onerror=this.src='images/common/unavaliable.jpg' class='img-responsive' ></a>";
		item += "<div class='lightslider-title'><label><span class='glyphicon glyphicon-stop'></span>"+val.info.cate+"</label></div>";
		item += "<ul class='lightslider-desc'>";
		
		$.each(val.attrs,function(i,val_attr){

			var title = "-"

			if(val_attr.title!="")
				title = val_attr.title;

			item += "<li><span>"+title+"</span></li>";

		});
		item += "</ul>";
		item += "</li>";
	});


	compare.append(item);
	
}

function redirect(id){
	window.location.href='productdetail.html?id='+id;
}

