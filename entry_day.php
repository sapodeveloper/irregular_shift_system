<?php require('./base_header.php'); ?>
<script type="text/javascript">
<!--
function changeDisabled() {
    if ( document.entry["entry_type"][3].checked ) {
        document . entry["inputReason"] . disabled = false;
    } else {
        document . entry["inputReason"] . disabled = true;
    }
}
window.onload = changeDisabled;
// -->
</script>
<?php
	require('./DBconini.php');
	$irregular_id = $_GET["irregular_id"];
	if(isset($_POST["entry"])){
		$entry_id=$_POST["entry_type"];
		$memo = $_POST["inputReason"];
		$irregular_id = $_POST["day_id"];
		$user_id = $_SESSION["user_id"];
		
		//データ追加処理
		$sql = "SELECT * FROM irregular_shift where day_id = $irregular_id and user_id = $user_id";
		$rst = mysql_query($sql, $con);
		if(mysql_num_rows($rst)){
			mysql_free_result($rst);
			//既にデータが登録されていた場合、更新手続きを行う
			$sql = "UPDATE irregular_shift SET entry_id = $entry_id , decide_entry_id = $entry_id
						WHERE day_id = $irregular_id AND user_id = $user_id";
			$rst = mysql_query($sql, $con);
		}else{
			mysql_free_result($rst);
			//データが登録されていない場合、新規登録手続きを行う
			$sql = "INSERT INTO irregular_shift (day_id, user_id, entry_id, decide_entry_id, memo)
						VALUE (\"$irregular_id\", \"$user_id\", \"$entry_id\", \"$entry_id\", \"$memo\")";
			$rst = mysql_query($sql,$con);
		}
	}
	$day = array("日","月","火","水","木","金","土");
 	$sql = "SELECT * from irregular_day where id = $irregular_id";
	$rst = mysql_query($sql, $con);
	$col = mysql_fetch_array($rst);
	$date = date('m月d日', strtotime($col["date"]));
	$day_w = date('w', strtotime($col["date"]));
	$user_id = $_SESSION["user_id"];
	$sql = "select * from irregular_shift where day_id = $irregular_id and user_id = $user_id";
	$rst = mysql_query($sql, $con);
	$col = mysql_fetch_array($rst);
	$select = $col["entry_id"];
	$checked[$select] = "checked";
	$s_time = "10:00";
	$e_time = "17:00";
	$username = $_SESSION["user"];
	mysql_free_result($rst);
	printf("<p>$date($day[$day_w])の勤務申請画面</p>");
	printf("<p>$username さんの勤務申請</p>");
?>
<?php printf("<form id=\"chkform\" name=\"entry\" method='post' action='$_SERVER[PHP_SELF]'>"); ?>
	<table border="1">
		<tr align="center">
			<td>勤務希望</td>
			<td>
				<label><input type="radio" name="entry_type" value="1" onClick="changeDisabled()" <?php printf("$checked[1]"); ?>>午前勤務</label>
				<label><input type="radio" name="entry_type" value="2" onClick="changeDisabled()" <?php printf("$checked[2]"); ?>>午後勤務</label>
				<label><input type="radio" name="entry_type" value="3" onClick="changeDisabled()" <?php printf("$checked[3]"); ?>>フル勤務</label>
				<label><input type="radio" name="entry_type" value="0" onClick="changeDisabled()" <?php printf("$checked[0]"); ?>>勤務希望しない</label>
			</td>
			<td rowspan="2" width="80">
				<?php printf("<input type=\"hidden\" name=\"day_id\" value=\"$irregular_id\">"); ?>
				<input type="submit" name="entry" value="勤務申請" style="width:70px; height:60px;">
			</td>
		</tr>
		<tr align="center">
			<td>
				勤務に入れない理由
			</td>
			<td>
				<p style="display:inline;">
				<input type="text" name="inputReason" id="textbox" size="55" value="理由を入力"></p>
			</td>
		</tr>
	</table>
</form>
</br>
<p><?php echo $date; ?>の申請状況</p>
<table border="1">
	<tr>
		<td>スタッフ名</td>
		<td>勤務タイプ</td>
		<td>10:00</td>
		<td>11:00</td>
		<td>12:00</td>
		<td>13:00</td>
		<td>14:00</td>
		<td>15:00</td>
		<td>16:00</td>
		<td>17:00</td>
	</tr>
	<?php
		function output($user_name, $entry_type){
			if($entry_type == 1){
			printf("<tr align=\"center\"><td>$user_name</td><td>午前勤務</td>");
			for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
				printf("<td bgcolor=\"#00BFFF\"/>");
			}
			for($time_cnt = 1; $time_cnt <=5; $time_cnt++){
				printf("<td />");
			}
			printf("</tr>");
			}else if($entry_type == 2){
				printf("<tr align=\"center\"><td>$user_name</td><td>午後勤務</td>");
				for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
					printf("<td />");
				}
				for($time_cnt = 1; $time_cnt <=5; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\"/>");
				}
				printf("</tr>");
			}else if($entry_type == 3){
				printf("<tr align=\"center\"><td>$user_name</td><td>フル勤務</td>");
				for($time_cnt = 1; $time_cnt <=8; $time_cnt++){
					printf("<td bgcolor=\"#00BFFF\"/>");
				}
				printf("</tr>");
			}
		}
		$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $irregular_id and user_id = $user_id";
		$rst = mysql_query($sql, $con);
		$col = mysql_fetch_array($rst);
		$user_name = $col["name"];
		$entry_type = $col["entry_id"];
		output($user_name, $entry_type);
			
		$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $irregular_id and user_id != $user_id order by user_id";
		$rst = mysql_query($sql, $con);
  		while($col = mysql_fetch_array($rst)){
			$user_name = $col["name"];
			$entry_type = $col["entry_id"];
			output($user_name, $entry_type);
		}
	?>
</table>
<?php require('./base_footer.php'); ?>