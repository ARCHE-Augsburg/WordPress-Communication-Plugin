<?php

class aacp_IcalSynchronizer {

	protected $logFileUrl;
	protected $syncScriptUrl;
	protected $calendarUrl;
	
	public function __construct() {
		$this->logFileUrl = "https://termine.arche-augsburg.de/icalsync.log";
		$this->syncScriptUrl = "https://termine.arche-augsburg.de/icalsync.php";
		$this->calendarUrl = "https://arche-augsburg.de/kalender?nocache=true";
	}

	public function evaluateLogFile() {
		$options = array(
			CURLOPT_URL => $this->logFileUrl,
			CURLOPT_RETURNTRANSFER => true,
		);
	
		$curlHandle = curl_init();
		curl_setopt_array($curlHandle, $options);
		$pagecontent = curl_exec($curlHandle);
		curl_close($curlHandle);
		
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
	}
	
	public function synchronize() {
		$this->triggerSyncScript();
		$this->triggerCalendarRefetch();
		return $this->evaluateLogFile();
	}
	
	private function triggerSyncScript() {
		$options = array(
			CURLOPT_URL => $this->syncScriptUrl,
			CURLOPT_RETURNTRANSFER => true,
		);
	
		$curlHandle = curl_init();
		curl_setopt_array($curlHandle, $options);
		curl_exec($curlHandle);
		curl_close($curlHandle);
	}
	
	private function triggerCalendarRefetch(){
		$options = array(
			CURLOPT_URL => $this->calendarUrl,
			CURLOPT_RETURNTRANSFER => true,
		);
	
		$curlHandle = curl_init();
		curl_setopt_array($curlHandle, $options);
		curl_exec($curlHandle);
		curl_close($curlHandle);
	}
}

?>
