<?php
session_start();
include "db.php";

// Fetch data from the database
$query = "SELECT * FROM volunteering_activities";
$result = mysqli_query($link, $query);

$activities = [];
while ($row = mysqli_fetch_assoc($result)) {
    $activities[] = $row;
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteering Activities</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d9d9d9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            height: 100vh;
            overflow-y: auto;
        }
        .container {
            background-color: #f5c57a;
            width: 100%; 
            max-width: 500px; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .notification {
            font-size: 24px;
            color: red;
        }
        .month-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .event-day {
            margin-bottom: 20px;
        }
        .event-card {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .event-info {
            display: flex;
            flex-direction: column;
        }
        .event-info img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .event-description {
            flex: 1;
        }
        .edit-link {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="bi bi-person-circle user-icon"></i>
            <h1>VolunPerks</h1>
            <i class="bi bi-bell notification"></i>
        </div>
        <div class="month-nav">
            <i class="bi bi-chevron-left"></i>
            <h2>August 2024</h2>
            <i class="bi bi-chevron-right"></i>
        </div>
        <?php foreach ($activities as $activity) { ?>
            <div class="event-day">
                <h3><?php echo date('j M', strtotime($activity['event_date'])); ?></h3>
                <div class="event-card">
                    <div class="event-description">
                        <p><strong>Organization:</strong> <?php echo htmlspecialchars($activity['org_name']); ?></p>
                        <p><strong>Event:</strong> <?php echo htmlspecialchars($activity['event_name']); ?></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($activity['event_time']); ?></p>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($activity['event_venue']); ?></p>
                        <p><strong>Points:</strong> <?php echo htmlspecialchars($activity['points']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($activity['event_description']); ?></p>
                    </div>
                    <a class="edit-link" href="edit_activity.php?org_id=<?php echo $activity['org_id']; ?>">Edit</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
