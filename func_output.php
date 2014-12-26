<?php
	//
	function output($user_name, $entry_type, $memo){
			if($entry_type == 1){
				printf("<tr align=\"center\"><td>$user_name</td><td>午前勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\"/ width=\"40\">");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				printf("<td>$memo</td></tr>");
			}else if($entry_type == 2){
				printf("<tr align=\"center\"><td>$user_name</td><td>午後勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("<td>$memo</td></tr>");
			}else if($entry_type == 3){
				printf("<tr align=\"center\"><td>$user_name</td><td>フル勤務</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("<td>$memo</td></tr>");
			}else if($entry_type == 4){
				printf("<tr align=\"center\"><td>$user_name</td><td>勤務希望なし</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td width=\"40\"/>");
				}
				printf("<td>$memo</td></tr>");
			}
		}
	function output_check($user_name, $entry_type){
			if($entry_type == 1){
				printf("<tr align=\"center\"><td>$user_name</td><td>午前勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\"/ width=\"40\">");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				printf("</tr>");
			}else if($entry_type == 2){
				printf("<tr align=\"center\"><td>$user_name</td><td>午後勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("</tr>");
			}else if($entry_type == 3){
				printf("<tr align=\"center\"><td>$user_name</td><td>フル勤務</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("</tr>");
			}
		}
	function edit_shift_output($user_name, $entry_type, $decide_entry_type){
			if($entry_type==1){
				$entry_type = "午前勤務";
				$bgcolor=" bgcolor=\"#ADFF2F\"";
			}elseif($entry_type == 2){
				$entry_type = "午後勤務";
				$bgcolor=" bgcolor=\"#90EE90\"";
			}elseif($entry_type == 3){
				$entry_type = "フル勤務";
				$bgcolor=" bgcolor=\"#FF69B4\"";
			}elseif($entry_type == 4){
				$entry_type = "勤務希望なし";
			}
			if($decide_entry_type == 1){
				printf("<tr align=\"center\"><td>$user_name</td><td $bgcolor>$entry_type</td><td bgcolor=\"#ADFF2F\">午前勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\"/ width=\"40\">");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				printf("</tr>");
			}else if($decide_entry_type == 2){
				printf("<tr align=\"center\"><td>$user_name</td><td $bgcolor>$entry_type</td><td bgcolor=\"#90EE90\">午後勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("</tr>");
			}else if($decide_entry_type == 3){
				printf("<tr align=\"center\"><td>$user_name</td><td $bgcolor>$entry_type</td><td bgcolor=\"#FF69B4\">フル勤務</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("</tr>");
			}else if($decide_entry_type == 4){
				printf("<tr align=\"center\"><td>$user_name</td><td $bgcolor>$entry_type</td><td>勤務希望なし</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td width=\"40\"/>");
				}
				printf("</tr>");
			}
		}
	function output_for_leader($user_name, $entry_type,$memo){
			if($entry_type == 1){
				printf("<tr align=\"center\"><td>$user_name</td><td>午前勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\"/ width=\"40\">");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				printf("<td>$memo</td></tr>");
			}else if($entry_type == 2){
				printf("<tr align=\"center\"><td>$user_name</td><td>午後勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td width=\"40\" />");
				}
				for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("<td>$memo</td></tr>");
			}else if($entry_type == 3){
				printf("<tr align=\"center\"><td>$user_name</td><td>フル勤務</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\" width=\"40\"/>");
				}
				printf("<td>$memo</td></tr>");
			}else if($entry_type == 4){
				printf("<tr align=\"center\"><td>$user_name</td><td>勤務希望なし</td>");
				for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
					printf("<td width=\"40\"/>");
				}
				printf("<td>$memo</td></tr>");
			}
		}
	
?>