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
		require("./func_output.php");
		require("./func_output_entry_table.php");
		if(isset($_POST["entry"])){
			for($i=1; $i<=5; $i++){
				$day_id =  $_POST["day_id$i"];
				$entry_type = $_POST["entry_type$i"];
				$memo = $_POST["inputReason$i"];
				if(!empty($entry_type)){
						require("./func_db.php");
				}
			}
			$irregular_id = $_POST["irregular_id"];
		}else{
			$irregular_id = $_GET["irregular_id"];	
		}

		require("./part_get_day_id.php");
		
		
		printf("<form id=\"chkform\" name=\"entry\" method='post' action='$_SERVER[PHP_SELF]'>");
		for($i=1; $i<=5; $i++){
			if($day_id[$i] != null){
				$sql = "select * from irregular_day where id = $day_id[$i]";
				$rst = mysql_query($sql, $con);
  				while($col = mysql_fetch_array($rst)){
					$date = change_day($col["date"]);
					printf("$date");
					printf("の勤務申請");
					$schedule_sql = "select * from irregular_shift where day_id = $day_id[$i] and user_id = $user_id";
					$schedule_rst = mysql_query($schedule_sql, $con);
					$schedule_col = mysql_fetch_array($schedule_rst);
					output_table($i,$schedule_col["entry_id"], $schedule_col["memo"]);
					printf("<a href=\"#\" onclick=\"fold('$i'); return false;\">申請状況</a>");
					printf("<div id=\"$i\">");
					$sql_num = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i]";
					$rst_num = mysql_query($sql_num, $con);
					if(mysql_num_rows($rst_num)){
						printf("<table border=\"1\"><tr align=\"center\"><td width=\"98\">スタッフ名</td><td width=\"98\">勤務タイプ</td>
									<td>10:00</td><td>11:00</td><td>12:00</td>
									<td>13:00</td><td>14:00</td><td>15:00</td>
									<td>16:00</td><td>17:00</td><td>メモ</td></tr>");
									
						$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i] and user_id = $user_id";
						$rst = mysql_query($sql, $con);
						$col = mysql_fetch_array($rst);
						$user_name = $col["name"];
						$entry_type = $col["entry_id"];
						$memo = $col["memo"];
						output($user_name, $entry_type, $memo);
						mysql_free_result($rst);
							
						$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i] and user_id != $user_id order by user_id";
						$rst = mysql_query($sql, $con);
				  		while($col = mysql_fetch_array($rst)){
							$user_name = $col["name"];
							$entry_type = $col["entry_id"];
							$memo = $col["memo"];
							output($user_name, $entry_type, $memo);
						}
						mysql_free_result($rst);
						if(mysql_num_rows($rst_num)){
							printf("</table>");
						}
					}else{
						printf("誰も申請していません。");
					}
					printf("<input type=\"hidden\" name=\"day_id$i\" value=\"$day_id[$i]\"></div><br/><hr><br/>");
					printf("<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">");
				}
			}
		}
		printf("<input type=\"submit\" name=\"entry\" value=\"勤務申請\" style=\"width:580px; height:30px;\"></form>");
?>
<?php require('./base_footer.php'); ?>