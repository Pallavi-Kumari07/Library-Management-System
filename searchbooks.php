<?php
session_start();
include('includes/config.php');
$query = $_GET['query'];

$sql = "SELECT * FROM tblbooks WHERE BookName LIKE :search OR Author LIKE :search OR ISBNNumber LIKE :search";
$stmt = $dbh->prepare($sql);
$searchText = "%$query%";
$stmt->bindParam(':search', $searchText, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <h2>Search Results for "<?php echo htmlentities($query); ?>"</h2>
    <hr>
    <?php
    if ($stmt->rowCount() > 0) {
        foreach ($results as $book) {
            echo "<div class='card' style='margin-bottom: 10px; padding: 15px;'>
                    <h4>" . htmlentities($book->BookName) . "</h4>
                    <p><strong>Author:</strong> " . htmlentities($book->Author) . "</p>
                    <p><strong>ISBN:</strong> " . htmlentities($book->ISBNNumber) . "</p>
                  </div>";
        }
    } else {
        echo "<p>No books found matching your search.</p>";
    }
    ?>
    <a href="main.php" class="btn btn-secondary mt-3">Back to Home</a>
</div>
</body>
</html>
