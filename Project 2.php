<?php
// 1. Connect to the database
$host = 'localhost';
$dbname = 'user_registration_db';
$username = 'root';
$password_db = ''; // renamed to avoid confusion with form password

$conn = new mysqli($host, $username, $password_db, $dbname);

// 2. Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 4. Collect and sanitize form data
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $password_plain = $_POST['password'] ?? '';

    // Check if all required fields are filled
    if (empty($fullname) || empty($email) || empty($phone) || empty($dob) || empty($gender) || empty($country) || empty($password_plain)) {
        die("Please fill in all required fields.");
    }

    // 5. Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format"); 
    }

    // 6. Hash password
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

    // 7. Insert into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, phone, dob, gender, country) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $fullname, $email, $password_hashed, $phone, $dob, $gender, $country);

   if ($stmt->execute()) {
		
		
        $message = "✅ Registration successful!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beautiful Registration Form</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6c63ff, #42a5f5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }

        .form-container h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .gender-group {
            display: flex;
            gap: 10px;
        }

        .form-submit {
            background-color: #6c63ff;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-submit:hover {
            background-color: #594ee2;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>User Registration</h2>
    
	
	<?php if (!empty($message)): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
		
    <form action="" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="fullname" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone">
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="dob">
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div class="gender-group">
                <label><input type="radio" name="gender" value="Male" required> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>
        </div>

        <div class="form-group">
            <label>Country</label>
            <select name="country" required>
                <option value="">Select Country</option>
                <option value="Kenya">Kenya</option>
                <option value="USA">USA</option>
                <option value="UK">UK</option>
            </select>
        </div>

        <input type="submit" class="form-submit" value="Register">
    </form>
</div>

</body>
</html>

