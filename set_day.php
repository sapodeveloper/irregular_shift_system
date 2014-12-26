
<form id="chkform">
<p>イレギュラー勤務の日程設定画面</p>
イレギュラー勤務のグループ名を入れてください。<br/>
<input type="text" name="group_name" size="20">
<br/>
勤務に入る日にチェックを入れてください。<br/>
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
		printf("<td>今日</td>");
		for($day = strtotime("+1 day"); $day <= strtotime("+2 week +$add_day_cnt day"); $day += 86400){
			$v_date = date("Y-m-d",$day);
			printf("<td><label><input type=\"checkbox\" name=\"set_day[]\" value=$v_date>");
			echo date("m月d日",$day);
			printf("</input></label></td>");
			if(date("w",$day)==6){
				printf("</tr><tr>");
			}
		}
	?>
	</tr>
</table>
入力期限<input type="text" id="datepicker"><br />
<input type="submit" name="add" value="登録する">
</form>
