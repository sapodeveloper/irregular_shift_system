<?php
		function count_entry_id($i, $day_id){
			$cnt_sql = "select decide_entry_id from irregular_shift where day_id = $day_id and decide_entry_id = $i";
			$cnt_res = mysql_query($cnt_sql);
			return mysql_num_rows($cnt_res);
		}
		function count_entry($day_id){
			$cnt_sql = "select decide_entry_id from irregular_shift where day_id = $day_id";
			$cnt_res = mysql_query($cnt_sql);
			return mysql_num_rows($cnt_res);
		}
		function count_time($entry_id, $entry_cnt){
			if($entry_id==1){
				return $entry_cnt * 3;
			}elseif($entry_id==2){
				return $entry_cnt * 4;
			}elseif($entry_id==3){
				return $entry_cnt * 7;
			}
		}

?>