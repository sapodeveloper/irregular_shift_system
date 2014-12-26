<?php
	$pass = "garaku";
	echo $pass;
	echo "<br />";
	
	for($i=1; $i<=10; $i++){
		echo md5($pass);
		echo "<br />";
	}
	
?>