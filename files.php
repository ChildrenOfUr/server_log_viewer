<?php
	// How files are named
	// {year}: 2016 -> 16
	// {month}: June -> 06
	// {day}: 5th -> 05
	define("NAME_FORMAT", "{month}_{day}_{year}-server.log");

	function parseDate($date) {
		$nums = explode("-", $_GET["logdate"]);
		$year = $nums[0];
		$month = $nums[1];
		$day = $nums[2];

		if (
			sizeof($nums) !== 3 ||
			!is_numeric($year) ||
			!is_numeric($month) ||
			!is_numeric($day)
		) {
			die("Invalid log date specified!");
		}

		return array(
			"year"	=> $year,
			"month"	=> $month,
			"day"	=> $day
		);
	}

	function getFilename($date) {
		$filename = NAME_FORMAT;
		$filename = str_replace("{year}", substr($date["year"], 2), $filename);
		$filename = str_replace("{month}", $date["month"], $filename);
		$filename = str_replace("{day}", $date["day"], $filename);
		return $filename;
	}

	function getLog($date) {
		return file(getLogDirectory() . getFilename($date));
	}

	function getLogDirectory() {
		return trim(file_get_contents("log_directory.txt"));
	}
?>
