<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversion Meter</title>
</head>
<body>
    <h2>Conversion<h2>
        <form method="post">
    <input type="number" name="kes" placeholder="Amount in KES" required>
    <input type="submit" name="convert" value="Convert to USD">
</form>
<?php
if (isset($_POST['convert'])) {
    $kes = $_POST['kes'];
    $rate = 130; // 1 USD = 130 KES (example rate)
    $usd = $kes / $rate;
    echo "<p>$kes KES = $usd USD</p>";
}
?>



</body>
</html>
