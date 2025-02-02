<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashed password is longer than 50 chars

    // Check if email or username exists
    $check_query = $conn->prepare("SELECT * FROM green WHERE email = ? OR username = ?");
    
    if (!$check_query) {
        die("Prepare failed: " . $conn->error);
    }

    $check_query->bind_param("ss", $email, $username);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        echo "Email or Username already exists!";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO green (name, username, email, password) VALUES (?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssss", $name, $username, $email, $password);
        
        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Signup failed: " . $stmt->error;
        }

        $stmt->close();
    }
    $check_query->close();
    $conn->close();
}
?>
