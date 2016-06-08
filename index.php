<?
	require_once("bin/files.php");
	require_once("bin/format.php");

	$viewing = isset($_GET["logdate"]);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CoU Server Log Viewer</title>
		<link rel="stylesheet" href="css/blocks.css">
		<link rel="stylesheet" href="css/contexts.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="header">
			<form action="" method="GET">
				<input type="date" name="logdate" value="<? echo($_GET["logdate"]); ?>" required>
				<button type="submit">View selected log</button>
			</form>

			<?
			if ($viewing) {
				?>
				<span>&nbsp;&#124;&nbsp;</span>

				<a id="download" href="download.php?logdate=<? echo($_GET["logdate"]); ?>">
					<button>Download displayed log</button></a>

				<button id="top" title="Top">&#9650;</button>
				<button id="bottom" title="Bottom">&#9660;</button>
				<?
			}
			?>
		</div>

		<?php
			if ($viewing) {
				// Safely parse date string
				$date = parseDate($_GET["logdate"]);

				// Find log file
				$log = getLog($date);
				if ($log !== false) {
					displayLog($log);
				} else {
					echo("<pre>Could not find a log file for the specified date.</pre>");
				}
			}
		?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="js/collapse.js"></script>
		<script src="js/scroll.js"></script>
	</body>
</html>
