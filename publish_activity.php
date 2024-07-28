<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Include the database connection file
include ("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $org_name = $_POST['org_name'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_venue = $_POST['event_venue'];
    $points = $_POST['points'];
    $event_description = $_POST['event_description'];

    // Validate form data
    if (empty($org_name) || empty($event_name) || empty($event_date) || empty($event_time) || empty($event_venue) || empty($points) || empty($event_description)) {
        $message = "All fields are required.";
    } else {
        // Escape data to prevent SQL injection
        $org_name = mysqli_real_escape_string($link, $org_name);
        $event_name = mysqli_real_escape_string($link, $event_name);
        $event_date = mysqli_real_escape_string($link, $event_date);
        $event_time = mysqli_real_escape_string($link, $event_time);
        $event_venue = mysqli_real_escape_string($link, $event_venue);
        $points = mysqli_real_escape_string($link, $points);
        $event_description = mysqli_real_escape_string($link, $event_description);

        // SQL query to insert data into the database
        $publishActivity = "INSERT INTO volunteering_activities (org_name, event_name, event_date, event_time, event_venue, points, event_description) VALUES ('$org_name', '$event_name', '$event_date', '$event_time', '$event_venue', '$points', '$event_description')";

        // Execute the query
        $resultPublishActivity = mysqli_query($link, $publishActivity);

        if ($resultPublishActivity) {
            $message = "Activity successfully published.";
        } else {
            $message = "Failed to publish activity: " . mysqli_error($link);
        }
    }
} else {
    // Redirect if accessed directly without form submission
    header("Location: publish_activities.html");
    exit();
}

// Close the database connection
mysqli_close($link);

// Display the message
echo $message;
?>