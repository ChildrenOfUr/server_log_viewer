<?php
	$HTML_COLORS = array(
		"verbose" => "green",
		"info" => "cyan",
		"command" => "purple",
		"warn" => "orange",
		"error" => "red"
	);

	$HTML_FALLBACK = "white";

	$RTF_COLORS = array(
		"verbose" => 1,
		"info" => 2,
		"command" => 3,
		"warn" => 4,
		"error" => 5
	);

	$RTF_FALLBACK = 0;

	function getColorClass($line) {
		$matches = array();
		preg_match("/\[(.*?)\ /", $line, $matches);

		if (count($matches) > 0) {
			// Log level class
			return strtolower($matches[1]);
		} else {
			// No class
			return false;
		}
	}

	function getHtmlColor($line) {
		global $HTML_COLORS;

		$class = getColorClass($line);
		if ($class !== false) {
			// Log level class
			if ($HTML_COLORS[$class] !== null) {
				// Has color
				return $HTML_COLORS[$class];
			} else {
				// No color
				return $HTML_FALLBACK;
			}
		} else {
			// No class
			return false;
		}
	}

	function getRtfColor($line) {
		global $RTF_COLORS;

		$class = getColorClass($line);
		if ($class !== false) {
			// Log level class
			if ($RTF_COLORS[$class] !== null) {
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
?>
