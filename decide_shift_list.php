<?php require('./base_header.php'); ?>
<p>確定勤務シフト</p>
<?php
$day = array("日","月","火","水","木","金","土");
$now = date('Ymd', mktime(0,0,0, date("m"), date("d"), date("y")));
require('./DBconini.php');
$sql = "SELECT * from  irregular_shift_day where mode = 1 and open_limit >= $now";
$rst = mysql_query($sql, $con);
if(mysql_num_rows($rst)){
	printf("<table border='2'>");
	printf("<tr align='center'>");
	printf("<td>エントリーグループ名</td><td>入力期限</td><td>勤務形態</td>");
	printf("</tr>");
 	while($col = mysql_fetch_array($rst)){
		$id = $col['irregular_id'];
		$title = $col['group_name'];
		$input_limit = date('m月d日', strtotime($col["input_limit"]));
		$input_limit_w = date('w', strtotime($col["input_limit"]));
		printf("<tr><td><form method='get' action='decide_shift.php' name='form$id'><a href='#' onClick='document.form$id.submit();'>
					<input type='hidden' name='irregular_id' value='$id'>
					<input type='hidden' name='title' value='$title'>$title</form></td>
					<td>$input_limit($day[$input_limit_w])</td><td>イレギュラー勤務</td></tr>");
	}
}else{
	printf("現在、公開中のシフトはありません。");
}
printf("</tr></table>");
?>
<?php require('./base_footer.php'); ?>