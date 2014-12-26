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

	if(isset($_GET["extend_time"])){
		require './DBconini.php';
		$irregular_id = $_GET["irregular_id"];
		$extend_day = $_GET["extend_day"];
		for($i=0; $i<count($_GET["extend_id"]); $i++){
			$user_id = $_GET["extend_id"][$i];
			$sql = "SELECT * FROM extend_irregular_shift where irregular_id = $irregular_id and user_id = $user_id";
			$rst = mysql_query($sql, $con);
			if(!mysql_num_rows($rst)){
				mysql_free_result($rst);
				$add_sql = "INSERT INTO extend_irregular_shift (irregular_id, user_id, extend_limit)
								VALUE (\"$irregular_id\", \"$user_id\", \"$extend_day\")";
				$add_rst = mysql_query($add_sql,$con);
				mysql_free_result($add_rst);
			}
		}
	}
	if(isset($_GET["open"])){
		require './DBconini.php';
		$irregular_id = $_GET["irregular_id"];
		$sql = "UPDATE irregular_shift_day SET mode = 1 WHERE irregular_id = $irregular_id";
		$rst = mysql_query($sql, $con);
		mysql_free_result($rst);
	}
	if(isset($_GET["not_open"])){
		require './DBconini.php';
		$irregular_id = $_GET["irregular_id"];
		$sql = "UPDATE irregular_shift_day SET mode = 0 WHERE irregular_id = $irregular_id";
		$rst = mysql_query($sql, $con);
		mysql_free_result($rst);
	}
	if(isset($_GET["del"])){
		require './DBconini.php';
		$irregular_id = $_GET["irregular_id"];
		require './part_get_day_id.php';
		for($i=1; $i<=5; $i++){
			if($day_id[$i] != null){
				$sql = 	"DELETE FROM irregular_day where id = $day_id[$i]";
				$rst = mysql_query($sql, $con);
				mysql_free_result($rst);
				$sql = 	"DELETE FROM irregular_shift where day_id = $day_id[$i]";
				$rst = mysql_query($sql, $con);
				mysql_free_result($rst);
			}
		}
		$sql = "DELETE FROM irregular_shift_day WHERE irregular_id = $irregular_id";
		$rst = mysql_query($sql, $con);
		mysql_free_result($rst);
		header("location: entry_group_list.php");
	}

	$title = $_GET["group_name"];
	$irregular_id = $_GET["irregular_id"];
	printf("<p>$title</p>");
	printf("<a href=\"./entry_group_list.php\">グループ選択画面に戻る</a>");	
						
?>
<p>エントリー状況</p>
<table border="1">
	<tr align="center">
		<td rowspan="2">入力日</td>
		<td rowspan="2">開始時間</td>
		<td rowspan="2">終了時間</td>
		<td rowspan="2">入力期限</td>
		<td colspan="5">申請状況</td>
		<td rowspan="2">合計時間</td>
	</tr>
	<tr>
		<td>申請数</td>
		<td>午前勤務</td>
		<td>午後勤務</td>
		<td>フル勤務</td>
		<td>勤務希望なし</td>
	</tr>
	<?php
		require './DBconini.php';
		require './func_count.php';
		require './func_day_manage.php';
		$now = date('Ymd', mktime(0,0,0, date("m"), date("d"), date("y")));
 		require './part_get_day_id.php';
		$limit_date = date('m月d日', strtotime($input_limit));
		mysql_free_result($rst);
		
		for($i=1; $i<=5; $i++){
			if($day_id[$i] != null){
				$sql = "select * from irregular_day where id = $day_id[$i]";
				$rst = mysql_query($sql, $con);
  				while($col = mysql_fetch_array($rst)){
					$date = change_day($col["date"]);
					$s_time = "10:00";
					$e_time = "17:00";
					$num[$i] = count_entry($day_id[$i]);
					for($cnt=1; $cnt<=4;$cnt++){
						$cnt_row[$cnt][$i] = count_entry_id($cnt, $day_id[$i]);
						$total_time[$i] = $total_time[$i] + count_time($cnt, $cnt_row[$cnt][$i]);
					}
					printf("<tr align=\"center\">
								<td>
									<form method=\"get\" action=\"edit_entry.php\" name=\"form$i\">
										<a href='#' onClick='document.form$i.submit();'>
										<input type=\"hidden\" name=\"day_id\" value=\"$day_id[$i]\">
										<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">
										$date
									</form>
								</td>
								<td>$s_time</td>
								<td>$e_time</td>
								<td>$limit_date</td>
								<td>$num[$i]</td>
								<td>".$cnt_row[1][$i]."</td>
								<td>".$cnt_row[2][$i]."</td>
								<td>".$cnt_row[3][$i]."</td>
								<td>".$cnt_row[4][$i]."</td>
								<td>".$total_time[$i]."</td>
								</tr>");
				}
			}
		}
		printf("<tr align=\"center\"><td></td><td></td><td></td>
					<td>合計</td><td>".array_sum($num)."</td>
					<td>".array_sum($cnt_row[1])."</td>
					<td>".array_sum($cnt_row[2])."</td>
					<td>".array_sum($cnt_row[3])."</td>
					<td>".array_sum($cnt_row[4])."</td>
					<td>".array_sum($total_time)."</td></tr>")
	?>
</table>
<?php
	if($limit_date > $now){
		printf("<br/><hr><br/>");
		printf("<a href=\"#\" onclick=\"fold('not_entry'); return false;\">期限内未申請者リスト</a>");
		printf("<div id=\"not_entry\">");
			printf("<form method=\"get\" action=\"$_SERVER[PHP_SELF]\" name=\"extend_time\">");
				$now = getdate();
				$year = $now["year"];
				for($year_cnt=0; $year_cnt<=1; $year_cnt++){
					$grade = $year - $year_cnt;
					$sql = "select * from user where grade = $grade and id not in 
								(select user_id from irregular_shift 
									where day_id = $day_id[1] and day_id = $day_id[2] 
										and day_id = $day_id[3] and day_id = $day_id[4] and day_id = $day_id[5])";
					$rst = mysql_query($sql, $con);
					if(mysql_num_rows($rst)){
						$grade = $year_cnt + 1;
						printf("<p>未登録者リスト(".$grade."年次)</p>");
						$output_cnt = 0;
						while($col = mysql_fetch_array($rst)){
							printf("<input type=\"hidden\" name=\"extend_id[]\" value=\"$col[id]\">$col[name]　　");
							$output_cnt++;
							if($output_cnt == 5){
								printf("<br />");
								$output_cnt = 0;
							}
						}
					}
				}
				printf("<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">");
				$extend_day = date('Ymd',strtotime('+1 day'));
				printf("<input type=\"hidden\" name=\"extend_day\" value=\"$extend_day\">");
				printf("<br />今実行すると期限は	".date("m月d日",strtotime("+1 day"))."になります<input type=\"submit\" name=\"extend_time\" value=\"延長処理実行\">");
			printf("</form>");
		printf("</div>");
	}
	printf("<br/><hr><br/>");
	
	
	printf("<a href=\"#\" onclick=\"fold('option'); return false;\">グループ処理</a>");
		printf("<div id=\"option\">");
			if($mode == 0){
				printf("<form method=\"get\" action=\"$_SERVER[PHP_SELF]\" name=\"open\">");
					printf("このシフトのグループを確定する。(シフト公開)");
					printf("<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">");
					printf("<input type=\"submit\" name=\"open\" value=\"シフト公開\">");
				printf("<form>");
				printf("<br/>");
			}else{
				printf("<form method=\"get\" action=\"$_SERVER[PHP_SELF]\" name=\"not_open\">");
					printf("このシフトのグループの公開を停止する。");
					printf("<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">");
					printf("<input type=\"submit\" name=\"not_open\" value=\"シフト公開停止\">");
				printf("<form>");
				printf("<br/>");
			}
			printf("<form method=\"get\" action=\"$_SERVER[PHP_SELF]\" name=\"del\">");
				printf("このシフトのグループを削除する。(シフト削除)");
				printf("<input type=\"hidden\" name=\"irregular_id\" value=\"$irregular_id\">");
				printf("<input type=\"submit\" name=\"del\" value=\"シフト削除\">");
			printf("<form>");
		printf("</div>");
?>
<?php require('./base_footer.php'); ?>