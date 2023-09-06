<?php
session_start();
include '../database/connect.php';

if (!isset($_SESSION['username'])) {
        header("Location: ../auth/login.php");
        exit;
}

$username = $_SESSION['username'];

// Fetch user information based on the logged-in username
$sql = "SELECT * FROM `ebook`.`users` WHERE username=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
} else {
        echo 'User not found.';
        exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>

        <style>
                .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                }

                h2 {
                        text-align: center;
                        margin-bottom: 20px;
                }

                p {
                        font-size: 18px;
                        margin-bottom: 10px;
                }

                .btn-primary {
                        margin-top: 20px;
                }
        </style>
</head>

<body>
        <div class="container mt-5">
                <h2>Profile Information</h2>
                <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
                <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p><strong>Mobile:</strong> <?php echo $user['mobile']; ?></p>
                <a class="btn btn-primary" href="../views/dashboard.php">Back to Dashboard</a>
        </div>

</body>

</html>