<?php
		$sql = "SELECT * FROM irregular_shift where day_id = $day_id and user_id = $user_id";
		$rst = mysql_query($sql, $con);
		if(mysql_num_rows($rst)){
			mysql_free_result($rst);
			//既にデータが登録されていた場合、更新手続きを行う
			$sql = "UPDATE irregular_shift SET entry_id = $entry_type , decide_entry_id = $entry_type, memo = \"$memo\"
						WHERE day_id = $day_id AND user_id = $user_id";
			$rst = mysql_query($sql, $con);
			mysql_free_result($rst);
		}else{
			mysql_free_result($rst);
			//データが登録されていない場合、新規登録手続きを行う
			$sql = "INSERT INTO irregular_shift (day_id, user_id, entry_id, decide_entry_id, memo)
						VALUE (\"$day_id\", \"$user_id\", \"$entry_type\", \"$entry_type\", \"$memo\")";
			$rst = mysql_query($sql,$con);
			mysql_free_result($rst);
		}
?>