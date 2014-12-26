$(window).load(function(){
	$("#datepicker").datepicker();
    $(":checked").parent().css("background","#f3f365");
    $("input").click(function(e) {
        var t = e.target.type;
        var chk = $(this).prop('checked');
        var name = $(this).attr('name');
        if(t == 'checkbox') {
            if(chk == true){
                $(this).parent().css('background', '#ADff2F');
            } else {
                $(this).parent().css('background-color', '');
            }
            return true;
    	} else if(t == 'radio') {
        	if(chk == true){
        	    $("input[name=" + name + "]").parent().css("background-color","");
        	    $(this).parent().css("background","#f3f365");
        	}
        	return true;
    	}
    });
	$("input[type=checkbox]").click(function(){
    	var $count = $("input[type=checkbox]:checked").length;
    	var $not = $('input[type=checkbox]').not(':checked')
    	if($count >= 5) {
    	    $not.attr("disabled",true);
    	}else{
    	    $not.attr("disabled",false);
    	}
	});
	
	//テキストボックス初期値
	//初期値の文字色
    var d_color = '#999999';
    //通常入力時の文字色
    var f_color = '#000000'; 

    $('#textbox1').css('color',d_color).focus(function(){
    	if(this.value == this.defaultValue){
        	this.value = '';
            $(this).css('color', f_color);
		}
	})
	//選択が外れたときの処理
    .blur(function(){
		if($(this).val() == this.defaultValue | $(this).val() == ''){
        	$(this).val(this.defaultValue).css('color',d_color);
        };
	});
	$('#textbox2').css('color',d_color).focus(function(){
    	if(this.value == this.defaultValue){
        	this.value = '';
            $(this).css('color', f_color);
		}
	})
    //選択が外れたときの処理
    .blur(function(){
		if($(this).val() == this.defaultValue | $(this).val() == ''){
        	$(this).val(this.defaultValue).css('color',d_color);
        };
	});
	$('#textbox3').css('color',d_color).focus(function(){
    	if(this.value == this.defaultValue){
        	this.value = '';
            $(this).css('color', f_color);
		}
	})
    //選択が外れたときの処理
    .blur(function(){
		if($(this).val() == this.defaultValue | $(this).val() == ''){
        	$(this).val(this.defaultValue).css('color',d_color);
        };
	});
	$('#textbox4').css('color',d_color).focus(function(){
    	if(this.value == this.defaultValue){
        	this.value = '';
            $(this).css('color', f_color);
		}
	})
    //選択が外れたときの処理
    .blur(function(){
		if($(this).val() == this.defaultValue | $(this).val() == ''){
        	$(this).val(this.defaultValue).css('color',d_color);
        };
	});
	$('#textbox5').css('color',d_color).focus(function(){
    	if(this.value == this.defaultValue){
        	this.value = '';
            $(this).css('color', f_color);
		}
	})
    //選択が外れたときの処理
    .blur(function(){
		if($(this).val() == this.defaultValue | $(this).val() == ''){
        	$(this).val(this.defaultValue).css('color',d_color);
        };
	});
}); 