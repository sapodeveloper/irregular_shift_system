<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/css.css">
<link rel="stylesheet" href="css/default.css">
<script src="js/jquery.js"></script>
<script src="js/mJquery.js"></script>
<script type='text/javascript' src='http://code.jquery.com/jquery-1.7.1.js'></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-darkness/jquery-ui.css" rel="stylesheet" />
<script type='text/javascript' src="js/clender.js"></script>
<script type='text/javascript' src="js/table.js"></script>
<title>イレギュラー勤務専用シフト管理システム</title>
</head>

<body>

	<!----- header ----->
	<div id="top">
		<div id="header">
			
      <div class="title">	
      	 <p>Irregular Shift Work Management System</p>
     	</div>
     	<div class="message">
     		<table class="messageTable">
      		<tr>
      			<td>
      				<?php
						session_start();
						$user_name = $_SESSION["user"];
						if($user_name == ''){
							$user_name = "ゲスト";
							$path=basename($_SERVER["PHP_SELF"],".php");
  	 						if($path!="login"){
								header("location: login.php");
							}
						}
						$logout = $_POST["logout"];
						if(isset($logout)){
							$_SESSION = array();
							session_destroy();
							header("location: login.php");
						}
						printf("ようこそ！　");
						echo $user_name;
						printf("さん");
					?>	
      			</td>
      			<?php
  	 				if($user_name!="ゲスト"){
  	 					printf("<td>
  	 								<form method='post' action='$_SERVER[PHP_SELF]' name='logout'>
  	 									<input type='submit' value='ログアウト' name='logout'>
  	 								</form>
  	 							</td>");
					}
      			?>
        	</tr>
      	</table>
     	</div>
      
      <span class="clear"></span>
      
   	</div>
 	</div>  
    
 	  <div id="all">
    	
  	 	<!----- navigation  ----->
  	 	<?php
  	 		$path=basename($_SERVER["PHP_SELF"],".php");
  	 		if($path!="login"){
  	 			printf("<div id=\"nav\"><ul class=\"menu\">");
  	 			printf("<li><a href=\"top.php\"><font color=\"#FFFFFF\">申請受付中シフト</font></a></li>");
				printf("<li><a href=\"decide_shift_list.php\"><font color=\"#FFFFFF\">確定シフト確認</font></a></li>");
				if($_SESSION["user_auth"]!=0){
					printf("<li><a href='entry_group_list.php'><font color=\"#FFFFFF\">申請中シフト編集</font></a></li>");
					printf("<li><a href='set_work_day.php'><font color=\"#FFFFFF\">シフト申請設定</font></a></li>");
				}
				if($_SESSION["user_auth"]==2){
					printf("<li><a href='user_list.php'><font color=\"#FFFFFF\">ユーザ管理</font></a></li>");
				}
				printf("<li><a href=\"profile.php\"><font color=\"#FFFFFF\">個人設定</font></a></li>");
  	 			printf("</ul></div>");
  	 		}
     	?>
		
			
    	<!----- contents ----->
   		<div id="contents">