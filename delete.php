<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $result = $conn->query("SELECT image FROM recipes WHERE id=$id");
    $row = $result->fetch_assoc();
    $imagePath = $row['image'];

    // Delete image file
    if (!empty($imagePath) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    $sql = "DELETE FROM recipes WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    $id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Recipe</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Delete Recipe</h1>

    <p>Are you sure you want to delete this recipe?</p>

    <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
</body>
</html>

