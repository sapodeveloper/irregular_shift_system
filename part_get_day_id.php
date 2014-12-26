<?php
	//irregular_shift_dayから該当するirregular_idを持つデータを抽出する
	$sql = "SELECT * from irregular_shift_day where irregular_id = $irregular_id";
	$rst = mysql_query($sql, $con);
	while($col = mysql_fetch_array($rst)){
		$day_id[1] = $col["day_id1"];
		$day_id[2] = $col["day_id2"];
		$day_id[3] = $col["day_id3"];
		$day_id[4] = $col["day_id4"];
		$day_id[5] = $col["day_id5"];
		$input_limit = $col["input_limit"];
		$open_limit = $col["open_limit"];
		$mode = $col["mode"];
	}
	mysql_free_result($rst);
?>