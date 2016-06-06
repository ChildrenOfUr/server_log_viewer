<?php
	require_once('files.php');

	if (isset($_GET['logdate'])) {
		$date = parseDate($_GET['logdate']);
		$filename = getFilename($date);
		$file = getLogStr($filename);

		if ($file === false) {
			die('Could not find server log file.');
		}

		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Type: text/plain');
		header('Content-Length: ' . strlen($file));
		header('Connection: close');

		echo($file);
	} else {
		die('No server log date specified.');
	}
?>
