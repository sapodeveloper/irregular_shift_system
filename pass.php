<?php require('./base_header.php'); ?>
ユーザ一覧
<table border="2">
<tr align="center">
	<td>ID</td>
	<td>スタッフ名</td>
	<td>ログイン名</td>
	<td>パスワード</td>
	<td>パスワード(md5)</td>
</tr>
<?php
	require('./DBconini.php');
	
	$sql = "SELECT * FROM user order by grade,yomigana ";
	$rst = mysql_query($sql, $con);
	while($col = mysql_fetch_array($rst)){
		$id = $col['id'];
		$name = $col['name'];
		$login_name = $col['login_name'];
		$pass = $col['password'];
		$pass_md5 = md5($pass);
		printf("<tr align='center'><td>$id</td><td>$name</td><td>$login_name</td><td>$pass</td><td>$pass_md5</td></tr>");
		
		echo $u_sql = "UPDATE user SET password = \"$pass_md5\" WHERE id = $id";
		$u_rst = mysql_query($u_sql, $con);
		mysql_free_result($u_rst);
	
	}
	printf("</table><br />");
		?>
<?php require('./base_footer.php'); ?>
