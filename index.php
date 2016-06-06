<?
	require_once('files.php');
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
				<input type="date" name="logdate" value="<? echo($_GET['logdate']); ?>" required>
				<button type="submit">View Log</button>
				<a href="download.php?logdate=<? echo($_GET['logdate']); ?>">
					<button type="button">Download displayed log</button>
				</a>
			</form>
		</div>

		<?php
			if (isset($_GET['logdate'])) {
				// Safely parse date string
				$date = parseDate($_GET['logdate']);

				// Find log file
				$log = getLog($date);
				if ($log !== false) {
					// Apply CSS classes to displayed lines based on context
					foreach ($log as $line) {
						$lowerLine = strtolower($line);
						$class = '';

						if (strpos($line, ': >') !== false) {
							$class = 'input';
						} else if (
							strpos($lowerLine, 'error') !== false
							|| strpos($lowerLine, 'severe') !== false
							|| strpos($lowerLine, '#') === 0
							|| strpos($lowerLine, 'could not') !== false
							|| strpos($lowerLine, 'failed') !== false
						) {
							$class = 'error';
						} else if (
							strpos($lowerLine, 'info') === 0
							|| strpos($lowerLine, 'loaded ') !== false
						) {
							$class = 'info';
						} else if (strpos($lowerLine, 'success') !== false) {
							$class = 'success';
						}

						echo('<pre class="' . $class . '">' . $line . '</pre>');
					}
				} else {
					echo('Could not find a log file for the specified date.');
				}
			}
		?>
	</body>
</html>
