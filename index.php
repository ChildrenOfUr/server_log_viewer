<?
	require_once("files.php");
	require_once("format.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CoU Server Log Viewer</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<div id="header">
			<form action="" method="GET">
				<input type="date" name="logdate" value="<? echo($_GET["logdate"]); ?>" required>
				<button type="submit">View Log</button>
				<a href="download.php?logdate=<? echo($_GET["logdate"]); ?>">
					<button type="button">Download displayed log</button>
				</a>
			</form>
		</div>

		<?php
			if (isset($_GET["logdate"])) {
				// Safely parse date string
				$date = parseDate($_GET["logdate"]);

				// Find log file
				$log = getLog($date);
				if ($log !== false) {
					displayLog($log);
				} else {
					echo("Could not find a log file for the specified date.");
				}
			}
		?>
	</body>
</html>
