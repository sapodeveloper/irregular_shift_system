<?php

	function edit_entry($i, $user_id, $user_name, $entry_id, $memo){
		if($entry_id == 1){
			$checked1 = "checked";
		}elseif($entry_id == 2){
			$checked2 = "checked";
		}elseif($entry_id == 3){
			$checked3 = "checked";
		}elseif($entry_id == 4){
			$checked0 = "checked";
		}
		if($memo != "備考を入力"){
			$value = $memo;
			$id = "";
		}else{
			$value = "備考を入力";
			$id = "textbox$i";
		}
		printf("<tr>");
			printf("<td><input type=\"hidden\" name=\"user_id[]\" value=\"$user_id\">");
			printf($user_name);
			printf("</td>");
			printf("<td><label><input type=\"radio\" name=\"entry_type$i\" value=\"1\" $checked1>午前勤務</label>");
			printf("<label><input type=\"radio\" name=\"entry_type$i\" value=\"2\" $checked2>午後勤務</label>");
			printf("<label><input type=\"radio\" name=\"entry_type$i\" value=\"3\" $checked3>フル勤務</label>");
			printf("<label><input type=\"radio\" name=\"entry_type$i\" value=\"4\" $checked0>勤務希望しない</label></td>");
			printf("<td><input type=\"text\" name=\"inputReason$i\" size=\"30\" value=\"$value\" readonly></p></td>");
		printf("</tr>");
	}
?>	