<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    // Image upload (update only if a new image is provided)
    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $imageUpdate = ", image=?";
    } else {
        $imageUpdate = '';
    }

    // Use prepared statement to update data
    $stmt = $conn->prepare("UPDATE recipes SET title=?, ingredients=?, instructions=? $imageUpdate WHERE id=?");
    
    if (!empty($_FILES['image']['name'])) {
        $stmt->bind_param("ssssi", $title, $ingredients, $instructions, $image, $id);
    } else {
        $stmt->bind_param("sssi", $title, $ingredients, $instructions, $id);
    }

    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM recipes WHERE id=$id");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Edit Recipe</h1>

    <form action="edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" value="<?= $row['title'] ?>" required>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea class="form-control" name="ingredients" required><?= $row['ingredients'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea class="form-control" name="instructions" required><?= $row['instructions'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Recipe</button>
    </form>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
</body>
</html>
