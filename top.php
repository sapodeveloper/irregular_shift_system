<?php require('./base_header.php'); ?>
<p>現在受付中勤務シフト</p>
<?php
$day = array("日","月","火","水","木","金","土");
$now = date('Ymd', mktime(0,0,0, date("m"), date("d"), date("y")));
require('./DBconini.php');
require("./session_manage.php");
$sql = "SELECT * from  irregular_shift_day where input_limit >= $now and mode  = 0";
$rst = mysql_query($sql, $con);
if(mysql_num_rows($rst)){
	printf("<table border='2'>");
	printf("<tr align='center'>");
	printf("<td>エントリーグループ名</td><td>入力期限</td><td>勤務形態</td><td>エントリー状況の確認</td>");
	printf("</tr>");
 	while($col = mysql_fetch_array($rst)){
		$id = $col['irregular_id'];
		$title = $col['group_name'];
		$input_limit = date('m月d日', strtotime($col["input_limit"]));
		$input_limit_w = date('w', strtotime($col["input_limit"]));
		printf("<tr><td><form method='get' action='entry_shift.php' name='form$id'><a href='#' onClick='document.form$id.submit();'>
					<input type=\"hidden\" name=\"irregular_id\" value=\"$id\">$title</form></td>
					<td>$input_limit($day[$input_limit_w])まで</td><td>イレギュラー勤務</td>");
		printf("<td><form method='get' action='check_entry.php' name='form2$id'><a href='#' onClick='document.form2$id.submit();'>
					<input type='hidden' name='irregular_id' value='$id'>エントリー状況を確認する</form></td></tr>");
	}
	printf("</table>");
}else{
	printf("現在、エントリーを受け付けていません。");
}
$sql = "SELECT * FROM extend_irregular_shift where user_id = $user_id and extend_limit >= $now";
$rst = mysql_query($sql, $con);
if(mysql_num_rows($rst)){
	printf("<br /><hr>");
	printf("<p>特別追加可能勤務シフト</p>");
	$extend_col = mysql_fetch_array($rst);
	$extend_id = $extend_col['irregular_id'];
	$extend_limit = $extend_col['extend_limit'];
	$extend_sql = "SELECT * from  irregular_shift_day where irregular_id = $extend_id";
	$extend_rst = mysql_query($extend_sql, $con);
	printf("<table border='2'>");
	printf("<tr align='center'>");
	printf("<td>エントリーグループ名</td><td>入力期限</td><td>勤務形態</td><td>エントリー状況の確認</td>");
	printf("</tr>");
	while($col = mysql_fetch_array($extend_rst)){
		$id = $col['irregular_id'];
		$title = $col['group_name'];
		$input_limit = date('m月d日', strtotime($extend_limit));
		$input_limit_w = date('w', strtotime($extend_limit));
		printf("<tr><td><form method='get' action='entry_shift.php' name='form$id'><a href='#' onClick='document.form$id.submit();'>
					<input type=\"hidden\" name=\"irregular_id\" value=\"$id\">$title</form></td>
					<td>$input_limit($day[$input_limit_w])</td><td>イレギュラー勤務</td>");
		printf("<td><form method='get' action='check_entry.php' name='form2$id'><a href='#' onClick='document.form2$id.submit();'>
					<input type='hidden' name='irregular_id' value='$id'>エントリー状況を確認する</form></td></tr>");
	}
	printf("</table>");
}
?>
<?php require('./base_footer.php'); ?>
