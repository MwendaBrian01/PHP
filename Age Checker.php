<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Age Checker</title>
</head>
<body>
    <h2>Check if you're an adult</h2>
    <form method="post">
        Enter your age: <input type="number" name="age" required>
        <input type="submit" value="Check">
    </form>

    <?php
    if (isset($_POST['age'])) {
        $age = $_POST['age'];
        if ($age >= 18) {
            echo "<p>You are an <strong>adult</strong>.</p>";
        } else {
            echo "<p>You are <strong>not an adult</strong>.</p>";
        }
    }
    ?>
</body>
</html>
