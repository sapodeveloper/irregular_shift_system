<?php require('./base_header.php'); ?>

<?php
		require("./DBconini.php");
		require("./session_manage.php");
		require("./func_day_manage.php");
		require("./func_output.php");
		require("./func_output_entry_table.php");
		

		$irregular_id = $_GET["irregular_id"];
		$title = $_GET["title"];
		require("./part_get_day_id.php");
		
		

		for($i=1; $i<=5; $i++){
			if($day_id[$i] != null){
				$sql = "select * from irregular_day where id = $day_id[$i]";
				$rst = mysql_query($sql, $con);
  				while($col = mysql_fetch_array($rst)){
  					$staff_cnt = 0;
  					$AM_staff_cnt = 0;
					$PM_staff_cnt = 0;
					$FULL_staff_cnt = 0;
					$NULL_staff_cnt = 0;
					$entry_total_time = 0;
					$decide_entry_total_time = 0;
					$date = change_day($col["date"]);
					printf("$date");
					printf("の勤務申請");
					$sql_num = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i] and entry_id != 4";
					$rst_num = mysql_query($sql_num, $con);
					if(mysql_num_rows($rst_num)){
						printf("<table border=\"1\"><tr align=\"center\"><td width=\"98\">スタッフ名</td><td width=\"98\">勤務タイプ</td>
									<td>10:00</td><td>11:00</td><td>12:00</td>
									<td>13:00</td><td>14:00</td><td>15:00</td>
									<td>16:00</td><td>17:00</td></tr>");
						$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i] order by user_id";
						$rst = mysql_query($sql, $con);
				  		while($col = mysql_fetch_array($rst)){
							$user_name = $col["name"];
							$decide_entry_type = $col["decide_entry_id"];
							$memo = $col["memo"];
							if($decide_entry_type==1){
								$staff_cnt++;
								$AM_staff_cnt++;
								$decide_entry_total_time =$decide_entry_total_time + 3;
							}elseif($decide_entry_type==2){
								$staff_cnt++;
								$PM_staff_cnt++;
								$decide_entry_total_time =$decide_entry_total_time + 4;
							}elseif($decide_entry_type==3){
								$staff_cnt++;
								$FULL_staff_cnt++;
								$AM_staff_cnt++;
								$PM_staff_cnt++;
								$decide_entry_total_time =$decide_entry_total_time + 7;
							}elseif($decide_entry_type==4){
								$NULL_staff_cnt++;
							}
							output_check($user_name, $decide_entry_type);
						}
						printf("<tr align=\"center\"><td>$staff_cnt 人</td><td>$decide_entry_total_time 時間</td>");
						if($NULL_staff_cnt !=0 && $AM_staff_cnt == 0 && $PM_staff_cnt == 0){
							printf("<td colspan=\"8\">0人</td></tr>");
						}elseif($FULL_staff_cnt != 0 && $AM_staff_cnt+$PM_staff_cnt == $FULL_staff_cnt*2){
							printf("<td colspan=\"8\">$PM_staff_cnt 人</td></tr>");
						}else{
							printf("<td colspan=\"3\">$AM_staff_cnt 人</td><td colspan=\"5\">$PM_staff_cnt 人</td></tr>");
						}
						mysql_free_result($rst);
						if(mysql_num_rows($rst_num)){
							printf("</table>");
						}
						printf("<br/><hr><br/>");
					}else{
						printf("<br/>誰も申請していません。<br/><hr><br/>");
					}
					
					
				}
			}
		}
	printf("<form method=\"get\" action=\"./testpdf2.php\" name=\"form\">
				<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">
				<input type=\"hidden\" name=\"title\" value=\"$title\">
				<input type=\"submit\" name=\"form\" value=\"PDFを出力する。\">
			</form>");
?>
<?php require('./base_footer.php'); ?>