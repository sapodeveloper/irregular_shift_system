<?php
	/************************************************************************
	*	filename : DBconini.php												*
	*	about    : DBへの接続するphpファイル								*
	************************************************************************/

	/********************
	*	DB接続基本設定	*
	********************/
	$DBSERVER   = "localhost"; //DBの場所
	$DBUSER     = "";  //DBのユーザ名
	$DBPASSWORD = "";     //DBのログインパスワード
	$DBNAME     = "";  //DBの名前
	
	/************
	*	DB接続	*
	************/
	$con = mysql_connect($DBSERVER, $DBUSER, $DBPASSWORD);
    
	/********************************
	*	DB使用文字フォーマット設定	*
	********************************/
	mysql_query("set names utf8");

	/****************************
	*	DBの使用テーブルを設定	*
	****************************/
	$selectdb = mysql_select_db($DBNAME, $con);
?>
