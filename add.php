<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    // Image upload
    $image = 'uploads/' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $image);

    // Use prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, instructions, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $ingredients, $instructions, $image);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Add Recipe</h1>

    <form action="add.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea class="form-control" name="ingredients" required></textarea>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea class="form-control" name="instructions" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Add Recipe</button>
    </form>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
</body>
</html>
