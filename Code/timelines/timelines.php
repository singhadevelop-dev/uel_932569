<?php
// Enter your database connection here
$hostname = "27.254.62.49";
$username = "singha_template_mutipage";
$password = "1ZW096dH";

// Connection to the database
$dbhandle = mysqli_connect($hostname, $username, $password) 
	or die("Unable to connect to MySQL");

// Select a database to work with
$selected = mysqli_select_db($dbhandle, "singha_oembusiness01")
	or die("Could not select database");

// Select timelines table
$result = mysqli_query($dbhandle, "select * from portfolio where PortType='ABOUT-TIMELINE-CONTENT-1' and Active=1");

// Fetch tha data from the database 
$timelines = array();
while ($row = mysqli_fetch_array($result)) {
	$timeline = new stdClass();
	
	$timeline->title 	= $row["PortName"];
	$timeline->image 	= $row["Image"];
	$timeline->day 		= date('d', strtotime($row["PortDateTime"]));
	$timeline->month 	= date('m', strtotime($row["PortDateTime"]));
	$timeline->year 	= date('Y', strtotime($row["PortDateTime"]));
	$timeline->time 	= $row["PortDetail2"];
	$timeline->icon 	= $row["PortDetail1"];
	$timeline->content 	= $row["ShortDescription"];

	array_push($timelines, $timeline);
}

echo json_encode($timelines);

// Close the connection
mysqli_close($dbhandle);
?>