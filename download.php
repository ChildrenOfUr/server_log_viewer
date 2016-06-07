<?php
	/*
	 * Handles the formatting and downloading of logs as RTF files.
	 */

	require_once("files.php");
	require_once("format.php");

	if (isset($_GET["logdate"])) {
		// Safely parse log date
		$date = parseDate($_GET["logdate"]);
		$filename = getFilename($date) . ".rtf";
		$file = getLog($date);

		// File exists?
		if ($file === false) {
			die("Could not find server log file.");
		}

		// Format RTF file
		$rtf = formatRtf($file);

		// Display in page or download as file?
		if (!isset($_GET["display"])) {
			header("Content-Disposition: attachment; filename='$filename'");
		}
		header("Content-Type: text/plain");
		header("Content-Length: " . strlen($rtf));
		header("Connection: close");

		echo($rtf);
	} else {
		die("No server log date specified.");
	}

	// Creates an RTF file based on the log file (list of lines) provided
	function formatRtf($file) {
		global $RTF_FALLBACK;

		// RTF header
		$rtf = "{\\rtf1\\ansi\\deff0\n";

		// Monospaced font
		$rtf .= "{\\fonttbl {\\f0\\fmodern\\fcharset0 Droid Sans Mono;}}\n";

		// Color definitions
		$rtf .= "{\\colortbl";
		$rtf .= " \\red0\\green0\\blue0;"; // Black (0)
		$rtf .= " \\red0\\green128\\blue0;"; // Green (1)
		$rtf .= " \\red0\\green255\\blue255;"; // Cyan (2)
		$rtf .= " \\red128\\green0\\blue128;"; // Purple (3)
		$rtf .= " \\red25\\green165\\blue0;"; // Orange (4)
		$rtf .= " \\red255\\green0\\blue0;"; // Red (5)
		$rtf .= "}";
		$rtf .= "\n\n";

		// Store color of last line
		$lastColor = "\\cf$RTF_FALLBACK";
		foreach ($file as $line) {
			// Get color of this line
			$thisColor = getRtfColor($line);
			if ($thisColor !== false) {
				// Use new color?
				$lastColor = "\\cf$thisColor";
			}

			// Set font size (11 for normal lines, 9 for continued errors/stacks)
			$fontSize = (strpos($line, "[") === 0 ? "fs22" : "fs18");

			// Write an RTF block
			$rtf .= "$lastColor\n\\f0\n\\$fontSize\n";
			$rtf .= "{" . $line . "\\line}\n\n";
		}

		// RTF footer
		$rtf .= "}";

		return $rtf;
	}
?>
