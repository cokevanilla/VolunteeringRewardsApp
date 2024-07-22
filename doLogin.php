<?php
session_start();
$msg = "";

// Check whether session variable 'user_id' is set
if (isset($_SESSION['user_id'])) {
    $msg = "You are already logged in.";
} else {
    // Check whether form input 'email' contains value
    if (isset($_POST['email'])) {

        // Retrieve form data
        $entered_email = $_POST['email'];
        $entered_password = $_POST['password'];
        $entered_role = $_POST['role'];

        // Connect to database
        include ("db.php");

        // Match the email, password, and role entered with database record
        $query = "SELECT userID, name, password FROM users 
                  WHERE email='$entered_email' AND password='$entered_password' AND
                  role='$entered_role'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        // If record is found
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);

            // Verify password
            if (password_verify($entered_password, $row['password'])) {
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_id'] = $row['userId'];
                $_SESSION['email'] = $entered_email;
                $_SESSION['role'] = $entered_role;

                header("location: cashier.html");
            } else {
                $msg = "Invalid password.";
            }
        } else {
            $msg = "No account found with that email and role.";
        }
    } 
}
?>