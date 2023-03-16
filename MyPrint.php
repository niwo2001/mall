<?php

function myPrint(){

	// Printing date and time
	$date = date("Y/m/d");
	echo '<b style="color:deeppink;">Date:	</b>' . $date . "<br>";
	echo '<b style="color:deeppink;">Time:	</b>' . date("h:i:sa");

	function getWeekday($date) {
		return date('w', strtotime($date));
	}

	if (date('w', strtotime($date)) == 5) {
		echo " - Finally, it's Friday!";
	}

	echo "<br>"."<br>";

	// Printing IP address
	echo '<b style="color:deeppink;">User IP Address: </b>' . $_SERVER["REMOTE_ADDR"];
	echo "<br>"."<br>";

	// Printing search path
	$path_parts = pathinfo("http://localhost/labb3/labb3/index.php");
	echo '<b style="color:deeppink;">Search path:  </b>' . $path_parts["dirname"];
	echo "<br>"."<br>";

	// Printing User agent-sträng
	echo '<b style="color:deeppink;">User agent: </b>' . $_SERVER["HTTP_USER_AGENT"];
}

?>