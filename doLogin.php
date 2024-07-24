<?php
session_start();
$msg = "";

// Check whether session variable 'user_id' is set
if (isset($_SESSION['user_id'])) {
    $msg = "You are already logged in.";
} else {
    // Check whether form input contains value
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {

        // Retrieve form data
        $entered_email = $_POST['email'];
        $entered_password = $_POST['password'];
        $entered_role = $_POST['role'];

        // Connect to database
        include("db.php");

        // Use prepared statements to prevent SQL injection
        $stmt = $link->prepare("SELECT userID, username, password, role FROM users WHERE email=? AND role=?");
        $stmt->bind_param("ss", $entered_email, $entered_role);
        $stmt->execute();
        $result = $stmt->get_result();

        // If record is found
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify password (plain text for now)
            if ($entered_password === $row['password']) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['userID'];
                $_SESSION['email'] = $entered_email;
                $_SESSION['role'] = $entered_role;

                // Redirect based on role
                if ($entered_role === 'volunteer') {
                    header("Location: volunteer_dashboard.html");
                } elseif ($entered_role === 'organisation admin') {
                    header("Location: OrgAdminHome.html");
                } elseif ($entered_role === 'event admin') {
                    header("Location: event_admin_dashboard.html");
                } elseif ($entered_role === 'retail admin') {
                    header("Location: retail_admin_dashboard.html");
                } else {
                    header("Location: login.html");
                }
                exit();
            } else {
                $msg = "Invalid password.";
            }
        } else {
            $msg = "No account found with that email and role.";
        }

        $stmt->close();
    } else {
        $msg = "Please enter email, password, and role.";
    }
}

// Display message
echo $msg;
?>
