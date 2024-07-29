<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("location: login.html");
    exit();
}

if (!isset($_GET['activity_id'])) {
    header("Location: OrgAdminEditAct.php");
    exit();
}

$activity_id = $_GET['activity_id'];
$query = "SELECT * FROM volunteering_activities WHERE activity_id='$activity_id'";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: OrgAdminEditAct.php");
    exit();
}

$activity = mysqli_fetch_assoc($result);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d9d9d9;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #f5c57a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Activity</h2>
        <form action="update_activity.php" method="POST">
            <input type="hidden" name="activity_id" value="<?php echo $activity['activity_id']; ?>">
            <div class="form-group">
                <label for="org_name">Organization Name:</label>
                <input type="text" class="form-control" id="org_name" name="org_name" value="<?php echo htmlspecialchars($activity['org_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo htmlspecialchars($activity['event_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_date">Event Date:</label>
                <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo htmlspecialchars($activity['event_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_time">Event Time:</label>
                <input type="time" class="form-control" id="event_time" name="event_time" value="<?php echo htmlspecialchars($activity['event_time']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_venue">Event Venue:</label>
                <input type="text" class="form-control" id="event_venue" name="event_venue" value="<?php echo htmlspecialchars($activity['event_venue']); ?>" required>
            </div>
            <div class="form-group">
                <label for="points">Points:</label>
                <input type="number" class="form-control" id="points" name="points" value="<?php echo htmlspecialchars($activity['points']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_description">Event Description:</label>
                <textarea class="form-control" id="event_description" name="event_description" rows="4" required><?php echo htmlspecialchars($activity['event_description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Activity</button>
        </form>
    </div>
</body>
</html>
