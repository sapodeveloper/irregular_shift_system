<?php require('./base_header.php'); ?>
<p>ユーザ管理</p>
<table border="2">
<tr align="center">
	<td></td>
	<td>ID</td>
	<td>スタッフ名</td>
	<td>ログイン名</td>
	<td>入学年度</td>
	<td>権限</td>
	<td>状態</td>
</tr>
<?php
	require('./DBconini.php');
	$recid = $_POST[edit];
	if(isset($recid)){
		for($i=0; $i<count($_POST["check_user"]); $i++){
			$user_id[$i] = $_POST["check_user"][$i];
		}
		if(isset($_POST["edit_auth"])){
			$edit_auth = $_POST["edit_auth"];
		}else{
			$edit_auth = 3;
		}
		if(isset($_POST["edit_state"])){
			$edit_state = $_POST["edit_state"];
		}else{
			$edit_state = 2;
		}
		switch($edit_auth){
			case 0;
				$cnt = 0;
				while($user_id[$cnt] != null){
 					$sql = "UPDATE user SET authority = 0 where id = $user_id[$cnt]";
					$rst = mysql_query($sql, $con);
					mysql_free_result($rst);
					$cnt++;
				}
				break;
			case 1;
				$cnt = 0;
				while($user_id[$cnt] != null){
 					$sql = "UPDATE user SET authority = 1 where id = $user_id[$cnt]";
					$rst = mysql_query($sql, $con);
					mysql_free_result($rst);
					$cnt++;
				}
				break;
			case 2;
				$cnt = 0;
				while($user_id[$cnt] != null){
 					$sql = "UPDATE user SET authority = 2 where id = $user_id[$cnt]";
					$rst = mysql_query($sql, $con);
					mysql_free_result($rst);
					$cnt++;
				}
				break;
		}
		switch($edit_state){
			case 0;
				$cnt = 0;
				while($user_id[$cnt] != null){
 					$sql = "UPDATE user SET state = 0 where id = $user_id[$cnt]";
					$rst = mysql_query($sql, $con);
					mysql_free_result($rst);
					$cnt++;
				}
				break;
			case 1;
				$cnt = 0;
				while($user_id[$cnt] != null){
 					$sql = "UPDATE user SET state = 1 where id = $user_id[$cnt]";
					$rst = mysql_query($sql, $con);
					mysql_free_result($rst);
					$cnt++;
				}
				break;
		}
	}
	printf("<form method='post' action='$_SERVER[PHP_SELF]'>");
	$sql = "SELECT * FROM user order by grade,yomigana ";
	$rst = mysql_query($sql, $con);
	while($col = mysql_fetch_array($rst)){
		$col_auth=$col['authority'];
		if($col_auth==0){
			$auth = "<td>一般権限</td>";
		}elseif($col_auth==1){
			$auth = "<td bgcolor='#FF69B4'>リーダー権限</td>";
		}elseif($col_auth==2){
			$auth = "<td bgcolor='#FFD700'>管理者権限</td>";
		}
		$id = $col['id'];
		$name = $col['name'];
		$login_name = $col['login_name'];
		$grade = $col['grade'];
		$state = $col['state'];
		if($state == 0){
			$state = "<td bgcolor='#F08080'>無効</td>";
		}else{
			$state = "<td bgcolor='#98FB98'>有効</td>";
		}
		printf("<tr align='center'><td><input type='checkbox' name='check_user[]' value='$id'></td><td>$id</td><td>$name</td><td>$login_name</td><td>$grade</td>$auth$state</tr>");
	}
	printf("</table><br />");
	printf("<table border='2'>");
		printf("<tr><td colspan='2'>ユーザ編集</td></tr>");
		printf("<tr><td rowspan='3'>権限</td><td><input type='radio' name='edit_auth' value='0'>チェック対象を一般ユーザ権限にする</td></tr>");
		printf("<tr><td><input type='radio' name='edit_auth' value='1'>チェック対象をリーダ権限にする</td></tr>");
		printf("<tr><td><input type='radio' name='edit_auth' value='2'>チェック対象を管理者権限にする</td></tr>");
		printf("<tr><td rowspan='2'>状態</td><td><input type='radio' name='edit_state' value='0'>チェック対象を無効状態にする</td></tr>");
		printf("<tr><td><input type='radio' name='edit_state' value='1'>チェック対象を有効状態にする</td></tr>");
	printf("</table>");
	printf("<input type='submit' name='edit' value='チェック対象を編集する'>");
	printf("</form><br /><a href='add_user.php'>新規ユーザを追加する</a>");
?>
<?php require('./base_footer.php'); ?>