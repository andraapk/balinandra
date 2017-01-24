/*
* plugin for ajax paging 
* variable
* data-url 		: data url 
* @author 		: budi
*/

var tmpData;

function ajaxPaging(e) {
	var toUrl = $(e).attr("data-url");
	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
};

function ajaxPage(toUrl) {
	$("#contentData").hide(400);
	$.ajax({
	   	url: toUrl,
	   	type:'GET',
	   	success: function(data){
	    	$('#contentData').html($(data).find('#contentData').html());
	    	$('#filters').html($(data).find('#filters').html());
	    	$('#filter-contents').html($(data).find('#filter-contents').html());
			$("#contentData").show(400);
			$("#filters").show(400);
			$("#filter-contents").show(400);
			tmpData = data;
	   	}
	});	
};