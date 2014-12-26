<?php require('./base_header.php'); ?>
<?php
	$add = $_POST["add"];
	if(isset($add)){
		$group_name = $_POST["group_name"];
		for($post_cnt=0;$post_cnt<count($_POST["set_day"]);$post_cnt++){
			$set_day[$post_cnt] = $_POST["set_day"][$post_cnt];
		}
		$input_limit = date("Y-m-d",strtotime($_POST["input_limit"]));
		$open_limit = end($set_day);
		require('./DBconini.php');
		for($sql_cnt=0; $set_day[$sql_cnt]!=NULL; $sql_cnt++){
			$s_time = "10:00";
			$e_time = "17:00";
			$sql = "INSERT INTO irregular_day (date, s_time_day, e_time_day, limit_date)
						VALUE(\"$set_day[$sql_cnt]\",\"$s_time\",\"$e_time\",\"$input_limit\")";
			$rst = mysql_query($sql, $con);
			$day_id[$sql_cnt] = mysql_insert_id();
			mysql_free_result($rst);
		}
		$sql = "INSERT INTO irregular_shift_day (group_name, day_id1, day_id2, day_id3, day_id4, day_id5, input_limit, open_limit)
					VALUE(\"$group_name\",\"$day_id[0]\",\"$day_id[1]\",\"$day_id[2]\",\"$day_id[3]\",\"$day_id[4]\",\"$input_limit\",\"$open_limit\")";
		$rst = mysql_query($sql, $con);
		mysql_free_result($rst);
		header("location: top.php");
	}
?>

<?php
	printf("<form method='post' action='$_SERVER[PHP_SELF]'>");
?>
<form id="chkform">
<p>イレギュラー勤務の日程設定画面</p>
イレギュラー勤務のグループ名を入れてください。<br/>
<input type="text" name="group_name" id="textbox1" size="20" value="シフトグループ名を入力">
<br/>
勤務に入る日にチェックを入れてください。(最大5日選択可能)<br/>
<table border="1">
	<tr align="center">
		<td bgcolor="#F08080">日</td>
		<td>月</td>
		<td>火</td>
		<td>水</td>
		<td>木</td>
		<td>金</td>
		<td bgcolor="#4682B4">土</td>
	</tr>
	<tr align="center">
	<?php
		for($td_cnt=0; $td_cnt<date("w",strtotime("now"));$td_cnt++){
			printf("<td></td>");
		}
		$add_day_cnt = 6 - $td_cnt;
		$now_date = date("w",strtotime("now"));
		printf("<td bgcolor=\"#FFD700\">今日</td>");
		if($now_date == 6){
			printf("</tr><tr>");
		}
//清水さんの要望により、4週間分表示できるように改造。 by 西本
//		for($day = strtotime("+1 day"); $day <= strtotime("+2 week +$add_day_cnt day"); $day += 86400){
		for($day = strtotime("+1 day"); $day <= strtotime("+4 week +$add_day_cnt day"); $day += 86400){
			$v_date = date("Y-m-d",$day);
			$output_date = date("m月d日",$day);
			printf("<td><label><input type=\"checkbox\" name=\"set_day[]\" value=$v_date>$output_date</input></label></td>");
			if(date("w",$day)==6){
				printf("</tr><tr>");
			}
		}
	?>
	</tr>
</table>
入力期限<input type="text" id="datepicker" name="input_limit"><br />
<input type="submit" name="add" value="登録する">
</form>
</form>
<?php require('./base_footer.php'); ?>
