<?php require('./base_header.php'); ?>
		<?php
			$edit = $_POST["edit"];
			if(isset($edit)){
				$user_id = $_SESSION["user_id"];
				$login_name = $_POST["login_name"];
				$old_pass = $_POST["old_pass"];
				$new_pass = $_POST["new_pass"];
				require('./DBconini.php');
				$sql = "SELECT * FROM user where id = $user_id";
				$rst = mysql_query($sql, $con);
				$col = mysql_fetch_array($rst);
				$password = $col["password"];
				mysql_free_result($rst);
				if($password == $old_pass){
 					$sql = "UPDATE user SET password = \"$new_pass\", login_name = \"$login_name\" where id = $user_id";
					$rst = mysql_query($sql, $con);
					mysql_free_result($rst);
					printf("更新完了");
				}else{
					printf("パスワードが違います");
				}
			}
		  	printf("<form method='post' action='$_SERVER[PHP_SELF]'>");
		?>
		<table border="2">
			<tr>
				<td colspan="2"><?php echo $username; ?>さんの個人設定</td>
			</tr>
			<tr>
				<td>ユーザ名</td>
				<td><input type="test" name="user_name" size="16" value="<?php echo $_SESSION["user"]; ?>" readonly></td>
			</tr>
			<tr>
				<td>ログイン名</td>
				<td><input type="test" name="login_name" size="16" value="<?php echo $_SESSION["login_name"]; ?>" readonly></td>
			</tr>
			<tr>
				<td rowspan="2">パスワードを変更する</td>
				<td>現在のパスワード<input type="password" name="old_pass" size="16"></td>
			</tr>
			<tr>
				<td>新規パスワード<input type="password" name="new_pass" size="16"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" value="更新" name="edit"></td>
			</tr>
		</table>
		</form>
		<?php
			if($_SESSION["user_auth"]==2){
		  		printf("<a href='add_user.php'>新規ユーザを追加する</a>");
			}
		?>
<?php require('./base_footer.php'); ?>
