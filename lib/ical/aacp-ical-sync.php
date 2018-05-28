<?php

	$logFileUrl = "https://termine.arche-augsburg.de/icalsync.log";
	
	$options = array(
		CURLOPT_URL => $logFileUrl,
		CURLOPT_RETURNTRANSFER => true,
	);

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$pagecontent = curl_exec($ch);
	curl_close($ch);
	
	$syncInfos = explode("\n", $pagecontent);
	
	array_pop($syncInfos); // Last element is an empty line
	
	foreach($syncInfos as $syncInfo){
		$syncInfoFields = explode(",", $syncInfo);
		
		if ($syncInfoFields[2] == "OK") {
			echo "<span class='dashicons dashicons-yes' style='color: green'></span>";
		}
		else {
			echo "<span class='dashicons dashicons-no-alt' style='color: red'></span>";
		}
		
		$timestampTime = strtotime($syncInfoFields[1]);
		$friendlytime = date("d.m.Y, H:i", $timestampTime);
		
		echo $syncInfoFields[0].", ".$friendlytime.", ".$syncInfoFields[2].", ".$syncInfoFields[3]."<br />";
	}
	
?>
