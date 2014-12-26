<?php require('./base_header.php'); ?>
<script type="text/javascript">
	function fold(id) {
		if(typeof(id) == "object") {
			for(var i in id) {
				fe(id[i]);
			}
		} else {
			fe(id);
		}
	}
	function fe(id) {
		var target = document.getElementById(id);
		if(target.style.display == "none") {  
			target.style.display = "block";
			target.style.visibility = "visible";
		} else {
			target.style.display = "none";
			target.style.visibility = "hidden";
		}
	}

</script>

<?php
		require("./DBconini.php");
		require("./session_manage.php");
		require("./func_day_manage.php");
		require("./func_edit_entry.php");
		require("./func_output.php");
		require("./func_output_entry_table.php");
		if(isset($_POST["entry"])){
			$day_id =  $_POST["day_id"];
			for($i=0; $i<count($_POST["user_id"]); $i++){
				$user_id = $_POST["user_id"][$i];
				$cnt = $day_id *1000 + $_POST["user_id"][$i];
				$entry_type = $_POST["entry_type$cnt"];
				$memo = $_POST["inputReason$cnt"];
				if(!empty($entry_type)){
					//require("./func_db.php");
					$sql = "SELECT * FROM irregular_shift where day_id = $day_id and user_id = $user_id";
					$rst = mysql_query($sql, $con);
					if(mysql_num_rows($rst)){
						mysql_free_result($rst);
						//既にデータが登録されていた場合、更新手続きを行う
						$sql = "UPDATE irregular_shift SET decide_entry_id = $entry_type, memo = \"$memo\"
									WHERE day_id = $day_id AND user_id = $user_id";
						$rst = mysql_query($sql, $con);
						mysql_free_result($rst);
					}
				}
			}
			header("Location: edit_entry.php?day_id=$day_id");
		}
		if(isset($_POST["add"])){
			$day_id =  $_POST["day_id"];
			$user_id = $_POST["add_staff"];
			$entry_type = $_POST["entry_typeadd"];
			$memo = "事後登録";
			$sql = "INSERT INTO irregular_shift (day_id, user_id, entry_id, decide_entry_id, memo)
						VALUE (\"$day_id\", \"$user_id\", \"$entry_type\", \"$entry_type\", \"$memo\")";
			$rst = mysql_query($sql,$con);
			mysql_free_result($rst);
			header("Location: edit_entry.php?day_id=$day_id");
		}
		if(!empty($_GET["irregular_id"])){
			$irregular_id = $_GET["irregular_id"];
			$day_id = $_GET["day_id"];
			session_start();
			$_SESSION["irregular_id"] = $irregular_id;
		}else{	
			session_start();
			$irregular_id = $_SESSION["irregular_id"];
			$day_id = $_GET["day_id"];
		}

		printf("<a href=\"./entry_group.php?irregular_id=$irregular_id\">日付選択画面に戻る</a>");	
		
		

		printf("<form id=\"chkform\" name=\"entry\" method='post' action='$_SERVER[PHP_SELF]'>");

		$sql = "select * from irregular_day where id = $day_id";
		$rst = mysql_query($sql, $con);
  		while($col = mysql_fetch_array($rst)){
			$AM_staff_cnt = 0;
			$PM_staff_cnt = 0;
			$FULL_staff_cnt = 0;
			$NULL_staff_cnt = 0;
			$entry_total_time = 0;
			$decide_entry_total_time = 0;
			$date = change_day($col["date"]);
			printf("$date");
			printf("の勤務申請");
			$schedule_sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id order by user_id";
			$schedule_rst = mysql_query($schedule_sql, $con);
			printf("<table border=\"1\">");
			printf("<tr><td>スタッフ名</td><td>希望勤務</td><td>備考</td></tr>");
			while($schedule_col = mysql_fetch_array($schedule_rst)){
				$id = $day_id*1000 + $schedule_col["user_id"];
				edit_entry($id,$schedule_col["user_id"],$schedule_col["name"],$schedule_col["decide_entry_id"],$schedule_col["memo"]);
			}
			printf("</table>");
			printf("<input type=\"hidden\" name=\"day_id\" value=\"$day_id\">");
			printf("<input type=\"submit\" name=\"entry\" value=\"勤務申請\" style=\"width:580px; height:30px;\"></form>");
			printf("<br /><hr>");
			
			printf("<a href=\"#\" onclick=\"fold('add'); return false;\">申請追加</a>");
			printf("<div id=\"add\">");
			printf("<form id=\"chkform\" name=\"add\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
			printf("<table border=\"1\"><tr>");
			printf("<td width=\"80\">");
				$now = getdate();
				$year = $now["year"] - 2;
				printf("<select name=\"add_staff\">");
				$sql = "select * from user where grade >= $year and id not in 
						(select user_id from irregular_shift 
							where day_id = $day_id)";
				$rst = mysql_query($sql, $con);
				if(mysql_num_rows($rst)){
					while($col = mysql_fetch_array($rst)){
						printf("<option value=\"$col[id]\">$col[name]</option>");
					}
				}
				printf("</select></td>");
			printf("<td><label><input type=\"radio\" name=\"entry_typeadd\" value=\"1\" >午前勤務</label>");
			printf("<label><input type=\"radio\" name=\"entry_typeadd\" value=\"2\" >午後勤務</label>");
			printf("<label><input type=\"radio\" name=\"entry_typeadd\" value=\"3\" >フル勤務</label>");
			printf("<label><input type=\"radio\" name=\"entry_typeadd\" value=\"4\" checked>勤務希望しない</label></td>");
			printf("<td><input type=\"hidden\" name=\"day_id\" value=\"$day_id\">");
			printf("<input type=\"submit\" name=\"add\" value=\"追加する\">");
			printf("</form></td></tr></table></div><br /><hr>");
			
			printf("<a href=\"#\" onclick=\"fold('1'); return false;\">申請状況</a>");
			printf("<div id=\"1\">");
			$sql_num = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id";
			$rst_num = mysql_query($sql_num, $con);
			if(mysql_num_rows($rst_num)){
				printf("<table border=\"1\"><tr align=\"center\"><td width=\"98\">スタッフ名</td><td width=\"98\">申請勤務</td><td width=\"98\">確定勤務</td>
						<td>10:00</td><td>11:00</td><td>12:00</td>
						<td>13:00</td><td>14:00</td><td>15:00</td>
						<td>16:00</td></tr>");
				$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id order by user_id";
				$rst = mysql_query($sql, $con);
				while($col = mysql_fetch_array($rst)){
					$user_name = $col["name"];
					$entry_type = $col["entry_id"];
					$decide_entry_type = $col["decide_entry_id"];
					$staff_cnt++;
					if($entry_type==1){
						$entry_total_time =$entry_total_time + 3;
					}elseif($entry_type==2){
						$decide_entry_total_time =$entry_total_time + 4;
					}elseif($entry_type==3){
						$entry_total_time =$entry_total_time + 6;
					}
					if($decide_entry_type==1){
						$AM_staff_cnt++;
						$decide_entry_total_time =$decide_entry_total_time + 3;
					}elseif($decide_entry_type==2){
						$PM_staff_cnt++;
						$decide_entry_total_time =$decide_entry_total_time + 4;
					}elseif($decide_entry_type==3){
						$FULL_staff_cnt++;
						$AM_staff_cnt++;
						$PM_staff_cnt++;
						$decide_entry_total_time =$decide_entry_total_time + 6;
					}elseif($decide_entry_type==4){
						$NULL_staff_cnt++;
					}
					edit_shift_output($user_name, $entry_type, $decide_entry_type);
				}
				printf("<tr align=\"center\"><td>$staff_cnt 人</td><td>$entry_total_time 時間</td><td>$decide_entry_total_time 時間</td>");
				if($NULL_staff_cnt !=0 && $AM_staff_cnt == 0 && $PM_staff_cnt == 0){
					printf("<td colspan=\"8\">0人</td></tr>");
				}elseif($FULL_staff_cnt != 0 && $AM_staff_cnt+$PM_staff_cnt == $FULL_staff_cnt*2){
					printf("<td colspan=\"8\">$PM_staff_cnt 人</td></tr>");
				}else{
					printf("<td colspan=\"3\">$AM_staff_cnt 人</td><td colspan=\"4\">$PM_staff_cnt 人</td></tr>");
				}
				mysql_free_result($rst);
				if(mysql_num_rows($rst_num)){
					printf("</table>");
				}
			}else{
				printf("誰も申請していません。");
			}
				
			
		}
?>
<?php require('./base_footer.php'); ?>