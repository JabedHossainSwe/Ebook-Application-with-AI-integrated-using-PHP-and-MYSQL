<?php
session_start();
require_once '../database/connect.php';

// Debug statement to check if session is set
if (!isset($_SESSION['user_id'])) {
        echo "Session not set"; // Debug statement
        exit();
}

$userID = $_SESSION['user_id'];

// Debug statement to check if $userID is correct
echo "User ID: " . $userID . "<br>"; // Debug statement

$sql = "SELECT * FROM `ebook`.`users` WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
        echo "Prepare failed: " . $conn->error; // Debug statement
        exit();
}

$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
} else {
        echo 'User not found.'; // Debug statement
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
        <title>View Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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