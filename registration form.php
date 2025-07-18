<?php
// registration.php

// Only process if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = ""; // Update as necessary
    $dbname = "registration_db";

      // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection error
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
   
    // Retrieve and sanitize input
    $user = htmlspecialchars(trim($_POST['username']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass);

   // Execute and respond
    if ($stmt->execute()) {
		
		
        $message = "✅ Registration successful!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}



?>






<!DOCTYPE html>
<html>
<head>

    <title>Simple Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            margin-top: 15px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

