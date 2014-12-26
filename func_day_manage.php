<?php
	//日付処理と関数
	
	//曜日管理
	$day = array("日","月","火","水","木","金","土");
	$day_f = array("日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日");

	//日付処理
	function change_day($date){
		$day = array("日","月","火","水","木","金","土");
		$date_d = date('m月d日', strtotime($date));
		$date_w = date('w', strtotime($date));
		$now = "$date_d($day[$date_w])";
		return $now;
	}

?>