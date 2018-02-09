<?php

//Diese 4 Daten befuellen
$htaccess_user = "christiandoernen";
$htaccess_password = "R2KHL13D";
$email = "christian.doernen@icloud.de";
$password = "2010geliebt";
$path = "";

$icalUrls = array (
		"gesamtkalender" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical",
		"gottesdienste" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=Ok9eRXhM1tqxjohj0WYHk86aHCoeTGzA&id=13",
		"minitreff" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=aSBLbk0mLxVRi4ExrlgXrRWG9PvSm4w9&id=14",
		"royalrangers" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=RwNtfe5PmKMIX329Z3gzkxUE2ZTz7VEZ&id=15",
		"archeyouth" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=NHPXukcotXXvDbursXhSAIPsgkwHs6w6&id=16",
		"sklasse" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=ehfJGo5s4E9YxBziDjbit1TUCHAwnSQ8&id=17",
		"gebet" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=f8rEfZG3LHhx2l4dMi1P3rG1zimoxx3P&id=19",
		"ferienfeiertage" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=WHXEI4REVdaqa7A8Uvf1NTloYeDSTREd&id=20",
		"jubi" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=QFUNJYZuoakaRn4S3fORvwOVK0KE45K0&id=24",
		"archekids" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=lczHQDhYiD0YFV3zfmLqgURhZWFN2XEx&id=25",
		"veranstaltungen" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=UdIhAPBrwZ37EDdpMgw41XIREbIncHFJ&id=34",
		"kurseseminare" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=iWmnJo2VfQvAqU2Cruvrsc1E6cXTdi3i&id=38",
		"graceland" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=ejRertUpIk37qSzIpdzT5ifCSp4JqGRe&id=39",
		"baueinsaetze" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=KmduR62CluzhnhS3DzwPUj4xswdE5Uon&id=44",
		"besonderegottesdienste" => "https://churchdb.arche-augsburg.de/?q=churchcal/ical&security=kk6DUminHHQtLQ4Uwr2vMcmhSwI7kSLO&id=41",
);

$postfields = array(
		"LoginForm[email]" => $email,
		"LoginForm[password]" => $password,
		"btn_0" => "",
		"RememberMe" => 0,
);
$post_str = http_build_query($postfields);

foreach ($icalUrls as $kalender => $url) {

	$options = array(
			CURLOPT_URL => $url,
			CURLOPT_USERPWD => sprintf("%s:%s", $htaccess_user, $htaccess_password),
			CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $post_str,
			CURLOPT_COOKIEJAR => "cookie.txt",
			CURLOPT_COOKIEFILE => "cookie.txt",
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,
	);

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$pagecontent = curl_exec($ch);
	curl_close($ch);

	$datei = fopen($path.$kalender.".ics", "w+");
	fwrite($datei, $pagecontent);
	fclose($datei);
	
	echo ".";
}

?>
