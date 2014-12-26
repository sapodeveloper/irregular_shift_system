<?php

	require("./DBconini.php");
	require("./session_manage.php");
	require("./func_day_manage.php");
	require("./func_output.php");
	require("./func_output_entry_table.php");
	
	$irregular_id = $_GET["irregular_id"];
	$title = $_GET["title"];
	require("./part_get_day_id.php");
	$sql = "select DISTINCT(name) from user inner join irregular_shift on user.id = user_id where decide_entry_id != 4 and day_id in 
				($day_id[1],$day_id[2],$day_id[3],$day_id[4],$day_id[5]) order by grade,yomigana";
	$rst = mysql_query($sql, $con);
	$cnt = 1;
	while($col = mysql_fetch_array($rst)){
		$name_data[$cnt] = $col[name];
		$staff_state[$cnt] = $col[schedule_state];
		$week_work_time[$cnt] = 0;
		$week_work_cnt[$cnt] = 0;
		$cnt++;
	}
	$fp = fopen("hoge.html", "w");
	fputs($fp, "<html><body>");
	fputs($fp, "<table><tr><td height=\"25\"><font size=\"20\">$title</font></td></tr><tr><td width=\"500\">");
	for($i=1; $i<=5; $i++){
		if($day_id[$i] != null){
			$sql = "select * from irregular_day where id = $day_id[$i]";
			$rst = mysql_query($sql, $con);
 				while($col = mysql_fetch_array($rst)){
				$staff_cnt = 0;
				$AM_staff_cnt = 0;
				$PM_staff_cnt = 0;
				$FULL_staff_cnt = 0;
				$NULL_staff_cnt = 0;
				$entry_total_time = 0;
				$decide_entry_total_time = 0;
				$date = change_day($col["date"]);
				$sql_num = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i] and entry_id != 4";
				$rst_num = mysql_query($sql_num, $con);
				if(mysql_num_rows($rst_num)){
					fputs($fp, "<table border=\"1\"><tr align=\"center\"><td width=\"80\">$date</td><td width=\"60\">勤務タイプ</td>
								<td width=\"40\">10:00</td><td width=\"40\">11:00</td><td width=\"40\">12:00</td>
								<td width=\"40\">13:00</td><td width=\"40\">14:00</td><td width=\"40\">15:00</td>
								<td width=\"40\">16:00</td></tr>");
					$sql = "select * from irregular_shift left join user on irregular_shift.user_id = user.id where day_id = $day_id[$i] order by user_id";
					$rst = mysql_query($sql, $con);
			  		while($col = mysql_fetch_array($rst)){
						$user_name = $col["name"];
						$decide_entry_type = $col["decide_entry_id"];
						if($decide_entry_type==1){
							$staff_cnt++;
							$AM_staff_cnt++;
							$decide_entry_total_time =$decide_entry_total_time + 3;
							$day_time = 3;
						}elseif($decide_entry_type==2){
							$staff_cnt++;
							$PM_staff_cnt++;
							$decide_entry_total_time =$decide_entry_total_time + 4;
							$day_time = 4;
						}elseif($decide_entry_type==3){
							$staff_cnt++;
							$FULL_staff_cnt++;
							$AM_staff_cnt++;
							$PM_staff_cnt++;
							$decide_entry_total_time =$decide_entry_total_time + 6;
							$day_time = 6;
						}
						$cnt = 1;
						while($name_data[$cnt] != null){
							if($name_data[$cnt] == $user_name && $decide_entry_type!=4){
								$week_work_time[$cnt] = $week_work_time[$cnt] + $day_time;
								$week_work_cnt[$cnt] = $week_work_cnt[$cnt] + 1;
							}
							$cnt++;
						}
						if($decide_entry_type == 1){
							fputs($fp, "<tr align=\"center\"><td>$user_name</td><td>午前勤務</td>");
							for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
								fputs($fp, "<td bgcolor=\"#00BFFF\"></td>");
							}
							for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
								fputs($fp, "<td></td>");
							}
							fputs($fp, "</tr>");
						}else if($decide_entry_type == 2){
							fputs($fp, "<tr align=\"center\"><td>$user_name</td><td>午後勤務</td>");
							for($time_cnt = 1; $time_cnt <=3; $time_cnt++){
								fputs($fp, "<td></td>");
							}
							for($time_cnt = 1; $time_cnt <=4; $time_cnt++){
								fputs($fp, "<td bgcolor=\"#00BFFF\"></td>");
							}
							fputs($fp, "</tr>");
						}else if($decide_entry_type == 3){
							fputs($fp, "<tr align=\"center\"><td>$user_name</td><td>フル勤務</td>");
							for($time_cnt = 1; $time_cnt <=7; $time_cnt++){
								fputs($fp, "<td bgcolor=\"#00BFFF\"></td>");
							}
							fputs($fp, "</tr>");
						}
					}
					fputs($fp, "<tr align=\"center\"><td>$staff_cnt 人</td><td>$decide_entry_total_time 時間</td>");
					if($NULL_staff_cnt !=0 && $AM_staff_cnt == 0 && $PM_staff_cnt == 0){
						fputs($fp, "<td colspan=\"8\">0人</td></tr>");
					}elseif($FULL_staff_cnt != 0 && $AM_staff_cnt+$PM_staff_cnt == $FULL_staff_cnt*2){
						fputs($fp, "<td colspan=\"8\">$PM_staff_cnt 人</td></tr>");
					}else{
						fputs($fp, "<td colspan=\"3\">$AM_staff_cnt 人</td><td colspan=\"4\">$PM_staff_cnt 人</td></tr>");
					}
					mysql_free_result($rst);
					if(mysql_num_rows($rst_num)){
						fputs($fp, "</table>");
					}
					fputs($fp, "<br/>");
				}else{
					fputs($fp, "<br/>誰も申請していません。<br/>");
				}
			}
		}
	}
	fputs($fp, "</td><td>");
	fputs($fp, "<table border=\"1\">");
	fputs($fp, "<tr><td width=\"70\">スタッフ名</td><td width=\"60\">勤務日数</td><td width=\"60\">勤務時間</td></tr>");
	$cnt = 1;
	while($name_data[$cnt] != null){
		fputs($fp, "<tr><td width=\"70\">$name_data[$cnt]</td>
						<td width=\"60\">$week_work_cnt[$cnt]</td>
						<td width=\"60\">$week_work_time[$cnt]</td></tr>");
		$cnt++;
	}
	$sum_time = array_sum($week_work_time);
	fputs($fp, "<tr><td width=\"70\"></td><td width=\"60\"></td><td width=\"60\">$sum_time</td></tr>");
	fputs($fp, "</table>");
	fputs($fp, "</td></tr></table>");
	fputs($fp, "</body></html>");
	fclose($fp);

	// ライブラリをインクルード
	require_once('/var/www/html/tcpdf/config/lang/eng.php');
	require_once('/var/www/html/tcpdf/tcpdf.php');
	// PDFオブジェクトを作成
	$pdf = new TCPDF(req_PAGE_ORIENTATION, PDF_UNIT, 'A3', true, 'UTF-8', false);
	
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	//$pdf->SetMargins(10,0,10);
	$pdf->setFontSubsetting(false);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	// フォントサブセットの利用を無効
	$pdf->setFontSubsetting(false);
	    
	// フォントをセット
	$pdf->SetFont('ipam', '', 11,'','','',true);
	// ページセット
	$pdf->AddPage();
	
	$html = file_get_contents("hoge.html");
	// 枠付で文字列を出力
	$pdf->WriteHTML($html, false, false, false, false, 'C');
			          
	//出力
	if(isset($_REQUEST["fileDownload"])){
		$pdf->Output('業務スケジュール.pdf', 'D');
	} else {
		$pdf->Output();
	}
?>
