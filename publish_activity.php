<?php
$db_host = "srv994.hstgr.io";
$db_user = "u877255869_User2";
$db_pass = "C300_Fyp_2024";
$db_name = "u877255869_FYP_2024_02_DB";

$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$org_name = mysqli_real_escape_string($link, $_POST['org_name']);
$event_name = mysqli_real_escape_string($link, $_POST['event_name']);
$event_date = mysqli_real_escape_string($link, $_POST['event_date']);
$event_time = mysqli_real_escape_string($link, $_POST['event_time']);
$event_venue = mysqli_real_escape_string($link, $_POST['event_venue']);
$points = mysqli_real_escape_string($link, $_POST['points']);
$event_description = mysqli_real_escape_string($link, $_POST['event_description']);

// Insert data into database
$sql = "INSERT INTO activities (org_name, event_name, event_date, event_time, event_venue, points, event_description) VALUES ('$org_name', '$event_name', '$event_date', '$event_time', '$event_venue', '$points', '$event_description')";

if (mysqli_query($link, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

mysqli_close($link);
?>
