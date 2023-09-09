<?php
include '../database/connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $bookId = $_GET['id'];

        // Fetch the book details from the database
        $sql = "SELECT * FROM `books` WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
                echo 'Book not found.';
                exit();
        }

        $book = $result->fetch_assoc();

        // Display the book cover image if available
        if (!empty($book['cover_image'])) {
                $coverImageData = $book['cover_image'];
                $coverImageFormat = 'image/jpeg'; // You can adjust this based on the actual format

                // Create a data URI for the book cover image
                $coverImageBase64 = 'data:' . $coverImageFormat . ';base64,' . base64_encode($coverImageData);

                // Display the book cover image using an <img> tag
                echo '<img src="' . $coverImageBase64 . '" alt="' . $book['title'] . '" class="book-cover">';
        } else {
                echo '<p>No cover image available</p>';
        }
} else {
        echo 'Invalid book ID.';
        exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $book['title']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <style>
                .book-details {
                        padding: 20px;
                }

                .book-cover {
                        max-width: 300px;
                        margin-bottom: 20px;
                }
        </style>
</head>

<body>
        <div class="book-details">
                <?php
                if (!empty($book['cover_image'])) {
                        // Displaying the book cover image is already handled above
                }
                ?>
                <h1><?php echo $book['title']; ?></h1>
                <p><?php echo $book['author']; ?></p>
                <p>Published Year: <?php echo $book['published_year']; ?></p>

                <a class="btn btn-primary" href="../books/download_pdf.php?id=<?php echo $book['id']; ?>">Download PDF</a>

                <a class="btn btn-primary" href="../views/dashboard.php">Back to Dashboard</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>