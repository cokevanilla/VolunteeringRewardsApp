<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $org_id = $_POST['org_id'];
    $org_name = $_POST['org_name'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_venue = $_POST['event_venue'];
    $points = $_POST['points'];
    $event_description = $_POST['event_description'];

    $query = "UPDATE volunteering_activities 
              SET org_name='$org_name', event_name='$event_name', event_date='$event_date', event_time='$event_time', event_venue='$event_venue', points='$points', event_description='$event_description' 
              WHERE org_id='$org_id'";

    $result = mysqli_query($link, $query);

    if ($result) {
        $message = "Activity successfully updated.";
    } else {
        $message = "Failed to update activity.";
    }
    header("Location: OrgAdminEditAct.php?message=" . urlencode($message));
    exit();
}

mysqli_close($link);
?>
