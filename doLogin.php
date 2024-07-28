<?php
session_start();
$msg = "";

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    $msg = "You are already logged in.";
    echo $msg;
    exit();
}

// Check whether form input contains value
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    // Retrieve form data
    $entered_email = $_POST['email'];
    $entered_password = $_POST['password'];
    $entered_role = $_POST['role'];

    // Include database connection file
    include "db.php";

    // Prepare and execute the SQL query
    $stmt = $link->prepare("SELECT userID, username, password, role FROM users WHERE email=? AND role=?");
    $stmt->bind_param("ss", $entered_email, $entered_role);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if exactly one user was found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify the password using password_verify() if passwords are hashed
        if (password_verify($entered_password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['userID'];
            $_SESSION['email'] = $entered_email;
            $_SESSION['role'] = $entered_role;

            // Redirect based on role
            switch ($entered_role) {
                case 'volunteer':
                    header("Location: volunteerPage.html");
                    break;
                case 'organisation admin':
                    header("Location: OrgAdminHome.html");
                    break;
                case 'event admin':
                    header("Location: event_admin_dashboard.html");
                    break;
                case 'retail admin':
                    header("Location: retail-admin.html");
                    break;
                default:
                    header("Location: login.html");
                    break;
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

echo $msg;
?>
