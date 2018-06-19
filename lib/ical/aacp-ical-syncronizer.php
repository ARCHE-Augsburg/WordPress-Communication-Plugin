<?php

class aacp_IcalSynchronizer {

	private $logFileUrl;
	private $syncScriptUrl;
	private $calendarUrl;
	
	public function __construct() {
		$this->logFileUrl = "https://termine.arche-augsburg.de/icalsync.log";
		$this->syncScriptUrl = "https://termine.arche-augsburg.de/icalsync.php";
		$this->calendarUrl = "https://arche-augsburg.de/kalender";
	}

	public function evaluate_log_file() {
		$response;
		
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
				$response .= AACP_SUCCESS_ICON;
			}
			else {
				$response .= AACP_FAULURE_ICON;
			}
			
			$timestampTime = strtotime($syncInfoFields[1]);
			$friendlytime = date("d.m.Y, H:i", $timestampTime);
			
			$response .= $syncInfoFields[0].", ".$friendlytime.", ".$syncInfoFields[2].", ".$syncInfoFields[3]."<br />";
		}
		
		return $response;
	}
	
	public function evaluate_cache_files(){
		$response;
		
		$cacheDirectory = wp_upload_dir()['path']."/ical-events-cache/";
		
		if ( is_dir ( $cacheDirectory ))
		{
		    if ( $handle = opendir($cacheDirectory) )
		    {
		        while (($file = readdir($handle)) !== false)
		        {
		        	if(substr($file, -strlen(".ics"))===".ics")
		        	{
			            $response .=  $file.", ";
			            $response .=  date("d.m.Y, H:i", filemtime($cacheDirectory.$file));
			            $response .=  "<br />";
		        	}
		        }
		        closedir($handle);
		    }
		}
		
		return $response;
	}
	
	public function synchronize() {
		$this->trigger_sync_script();
		$this->trigger_calendar_refetch();
	}
	
	private function trigger_sync_script() {
		$options = array(
			CURLOPT_URL => $this->syncScriptUrl,
			CURLOPT_RETURNTRANSFER => true,
		);
	
		$curlHandle = curl_init();
		curl_setopt_array($curlHandle, $options);
		curl_exec($curlHandle);
		curl_close($curlHandle);
	}
	
	private function trigger_calendar_refetch(){
		$parameter = array(
			"nocache" => "true"
		);
		
		$getParameter = http_build_query($parameter);
		
		$options = array(
			CURLOPT_URL => $this->calendarUrl."?".$getParameter,
			CURLOPT_RETURNTRANSFER => true,
		);
	
		$curlHandle = curl_init();
		curl_setopt_array($curlHandle, $options);
		curl_exec($curlHandle);
		curl_close($curlHandle);
	}
}

?>
