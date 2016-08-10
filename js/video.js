$(document).ready(function(){

	$("#video-slider").lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });

});

$('#video-slider').find('li').click(function(){

	var link = $(this).attr('data-link');
	if(link != undefined){ 
		console.log('link to ' + link);
		
		//var url = link.replace("watch?v=", "v/");
		
		$('#mediaplayer').attr('src',link);
	}	
});