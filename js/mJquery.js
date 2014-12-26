// JavaScript Document
$(function(){
	
/***********************************
* ヘッダー
***********************************/

	
	$(".title p").hover(function(){
		$(this).html("イレギュラー勤務専用シフト管理システム");
	},function(){
			$(this).html("Irregular Shift Work Management System");
		});
	
	
/***********************************
* メニュー
***********************************/

	$(".menu li").hover(function(){
		$(this).css("background-color","#173360");
	},function(){
			$(this).css("background-color","#3575CA");
		});


});