<?php
	// HTML colors are handled in styles.css

	// RTF colors, as defined in the RTF headers (download.php)
	$RTF_COLORS = array(
		"verbose" => 1,
		"info" => 2,
		"command" => 3,
		"warning" => 4,
		"error" => 5
	);

	// Default RTF color
	$RTF_FALLBACK = 0;

	// Gets color class based on line context
	// Returns a key from RTF_COLORS, or false if no context
	function getColorClass($line) {
		global $RTF_COLORS;

		$lowerLine = strtolower($line);

		if (strpos($lowerLine, "severe") === 0) {
			// Redstone severe messages are really bad
			return "severe";
		} else {
			// Get class name from line
			$class = trim(substr($lowerLine, 1, 8));

			if (array_key_exists($class, $RTF_COLORS)) {
				// Defined color
				return $class;
			} else {
				// No color, no change in format
				return false;
			}
		}
	}

	// Returns the color code defined in the RTF file for a line
	function getRtfColor($line) {
		global $RTF_COLORS;

		$class = getColorClass($line);
		if ($class !== false) {
			// Log level class
			if (array_key_exists($class, $RTF_COLORS)) {
				// Has color
				return $RTF_COLORS[$class];
			} else {
				// No color
				return $RTF_FALLBACK;
			}
		} else {
			// No class
			return false;
		}
	}

	// Formats a log file in HTML
	function displayLog($lines) {
		// Creates a <pre> element from a class and set of lines
		function makePre($class, $lines) {
			echo("<pre class=\"$class\">$lines</pre>");
		}

		// Start making an element
		$blockLines = "";

		// Apply CSS classes to displayed lines based on context
		$blockColor = "";

		foreach ($lines as $line) {
			// Get color of this line
			$newColor = getColorClass($line);

			if ($newColor !== false) {
				// Save the current block
				makePre($blockColor, $blockLines);

				// Create a new block
				$blockColor = "";
				$blockLines = "";
			}

			if ($blockColor === "") {
				// First line block
				$blockColor = $newColor;
			}

			// Add line to block
			$blockLines .= htmlspecialchars($line);

			// if ($newColor === false) {
			// 	// Add line to current block
			// 	$blockLines .= htmlspecialchars($line);
			// } else if ($thisColor !== false) {
			// 	// Save the current color block
			// 	makePre($lastColor, $block);
			//
			// 	// Create a new color block
			// 	$lastColor = $thisColor;
			// 	$block = "";
			// }
		}
	}
?>
