<?php require('./base_header.php'); ?>
<?php
			$login = $_POST["login"];
			if(isset($login)){
				$login_name = $_POST["login_name"];
				$login_pass = $_POST["pass"];
				if($login_name != null){
					if($login_pass != null){
						require("./DBconini.php");
						$sql = "SELECT * FROM user where login_name = \"$login_name\" and password = \"$login_pass\"";
						$rst = mysql_query($sql, $con);
						$col = mysql_fetch_array($rst);
						$col_pass = $col["password"];
						if($login_pass == $col_pass){
							$auth = $col["authority"];
							$name = $col["name"];
							session_start();
							session_register($name);
							$_SESSION["user"] = $name;
							$_SESSION["user_auth"] = $auth;
							$_SESSION["login_name"] = $login_name;
							$_SESSION["user_id"] = $col["id"];
							header("location: top.php");
						} 
					}
				}
			}
		?>
		<?php
			printf("<form method='post' action='$_SERVER[PHP_SELF]'>");
		?>
<table width="710" height="200">
	<tr>
		<td align="center" valign="middle">
			<table border="1">
				<tr align="center">
					<td>ログイン名</td>
					<td><input type="text" name="login_name" size="20"></td>
				</tr>
				<tr align="center">
					<td>ログインパスワード</td>
					<td><input type="password" name="pass" size="20"></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="login" value="ログイン"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<?php require('./base_footer.php'); ?>